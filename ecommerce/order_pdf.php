<?php
include('vendor/autoload.php');
require('connection.inc.php');
require('functions.inc.php');

if(!$_SESSION['ADMIN_LOGIN']){
	if(!isset($_SESSION['USER_ID'])){
		die();
	}
}

$order_id=get_safe_value($con,$_GET['id']);

$css=file_get_contents('css/bootstrap.min.css');
$css.=file_get_contents('style.css');

$html='<div class="wishlist-table table-responsive">
   <table>
      <thead>
         <tr>
            <th class="product-thumbnail">Tên sản phẩm</th>
            <th class="product-thumbnail">Hình ảnh</th>
            <th class="product-name">Số lượng</th>
            <th class="product-price">Giá</th>
            <th class="product-price">Tổng giá</th>
         </tr>
      </thead>
      <tbody>';
		
		if(isset($_SESSION['ADMIN_LOGIN'])){
			$res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and order_detail.product_id=product.id");
		}else{
			$uid=$_SESSION['USER_ID'];
			$res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and `order`.user_id='$uid' and order_detail.product_id=product.id");
		}
		
		$total_price=0;
		if(mysqli_num_rows($res)==0){
			die();
		}
		while($row=mysqli_fetch_assoc($res)){
		$total_price=$total_price+($row['qty']*$row['price']);
		$pp=$row['qty']*$row['price'];
        $html.='<tr>
            <td class="product-name">'.$row['name'].'</td>
            <td class="product-name"> <img src="'.PRODUCT_IMAGE_SITE_PATH.$row['image'].'"></td>
            <td class="product-name">'.$row['qty'].'</td>
            <td class="product-name">'.formatMoney($row['price']).' đ</td>
            <td class="product-name">'.formatMoney($pp).' đ</td>
        </tr>';
		}
		 
		$html.='<tr>
				<td colspan="3"></td>
				<td class="product-name">Total Price</td>
				<td class="product-name">'.formatMoney($total_price).' đ</td>
				
			</tr>';
		 
      $html.='</tbody>
   </table>
</div>';
$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$file=time().'.pdf';
$mpdf->Output($file,'D');
?>
