<?php
require('top.inc.php');

$employee_id=$_SESSION['EMP_ID'];

$row1=mysqli_fetch_assoc(mysqli_query($con,"select *
      from employee where id=$eid"));

$company_id=$row1['company_id'];
$division_id=$row1['division_id'];
$district_id=$row1['district_id'];

?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Order Master </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
							<thead>
								<tr>
									<th class="product-thumbnail">Order ID</th>
									<th class="product-name"><span class="nobr">Order Date</span></th>
									<th class="product-stock-stauts"><span class="nobr"> Payment Type </span></th>
									<th class="product-stock-stauts"><span class="nobr"> Payment Status </span></th>
									<th class="product-stock-stauts"><span class="nobr"> Order Status </span></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$res=mysqli_query($con,"select `order`.id as odr_id,`order`.added_on,`order`.payment_type,`order`.payment_status,order_status.name as order_status_str,order_detail.* from `order`,order_status,order_detail where order_status.id=`order`.order_status and `order`.id=order_detail.order_id and order_detail.company_id=$company_id and order_detail.division_id=$division_id and order_detail.district_id=$district_id");
								while($row=mysqli_fetch_assoc($res)){
								?>
								<tr>
									<td class="product-add-to-cart">
										<a href="order_details.php?id=<?php echo $row['odr_id']?>"> <?php echo $row['odr_id']?>
										</a>
									</td>
									<td class="product-name"><?php echo $row['added_on']?></td>
									<td class="product-name"><?php echo $row['payment_type']?></td>
									<td class="product-name"><?php echo $row['payment_status']?></td>
									<td class="product-name"><?php echo $row['order_status_str']?></td>
									
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