<?php
require('top.inc.php');
isAdmin();
?>

<div class="content pb-0">
	<div class="orders">
	   	<div class="row">
		  	<div class="col-xl-12">
			 	<div class="card">
					<div class="card-body">
						<h4 class="box-title">Đơn Hàng </h4>
					</div>
					<div class="card-body--">
						<div class="table-stats order-table ov-h">
							<table class="table">
								<thead>
									<tr>
										<th class="product-thumbnail">Đơn Hàng ID</th>
										<th class="product-name"><span class="nobr">Ngày Đặt</span></th>
										<th class="product-price"><span class="nobr"> Tên người nhận </span></th>
										<th class="product-price"><span class="nobr"> Địa Chỉ </span></th>
										<th class="product-price"><span class="nobr"> Số điện thoại </span></th>
										<th class="product-stock-stauts"><span class="nobr"> Phương Thức Thanh Toán</span></th>
										<th class="product-stock-stauts"><span class="nobr"> Trạng Thái Thanh Toán </span></th>
										<th class="product-stock-stauts"><span class="nobr"> Trạng Thái Đơn Hàng</span></th>
										<th class="product-stock-stauts"><span class="nobr">Thông Tin Giao Hàng </span></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$res=mysqli_query($con,"select `order`.*,order_status.name as order_status_str from `order`,order_status where order_status.id=`order`.order_status order by `order`.id desc");
										while($row=mysqli_fetch_assoc($res)){
									?>
									<tr>
										<td class="product-add-to-cart">
											<a href="order_master_detail.php?id=<?php echo $row['id']?>"><?php echo $row['id']?></a><br/>
											<a href="../order_pdf.php?id=<?php echo $row['id']?>">PDF</a>
										</td>
										<td class="product-name"><?php echo $row['added_on']?></td>
										<td class="product-name">
											<?php echo $row['orname']?><br/>
											
										
										</td>
										<td class="product-name">
											<?php echo $row['address']?><br/>
										
										</td>
										<td class="product-name">
											
											<?php echo $row['ormobile']?><br/>
										
										</td>
										<td class="product-name"><?php echo $row['payment_type']?></td>
										<td class="product-name"><?php echo $row['payment_status']?></td>
										<td class="product-name"><?php echo $row['order_status_str']?></td>
										<td class="product-name">
											<?php 
												echo "Order Id:- ".$row['ship_order_id'].'<br/>';
												echo "Shipment Id:- ".$row['ship_shipment_id'];
											?>
										</td>
									</tr>
									<?php } ?>
								</tbody>									
							</table>
						</div>
					</div>
			 	</div>
		  	</div>
	   	</div>
	</div>
</div>

<?php
require('footer.inc.php');
?>