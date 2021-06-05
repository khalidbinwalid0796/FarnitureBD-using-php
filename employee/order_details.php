<?php
require('top.inc.php');
$order_id=get_safe_value($con,$_GET['id']);
if(isset($_POST['update_order_status'])){
	$update_order_status=$_POST['update_order_status'];
		mysqli_query($con,"update `order` set order_status='$update_order_status' where id='$order_id'");
	}

$coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value from `order` where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];

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
				   <h4 class="box-title">Order Detail </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
								<thead>
									<tr>
                                        <th class="product-thumbnail">Product Name</th>
										<th class="product-thumbnail">Product Image</th>
                                        <th class="product-thumbnail">Division</th>
                                        <th class="product-thumbnail">District</th>
                                        <th class="product-name">Qty</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-price">Total Price</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image,division.id,division.name as dv_name,district.id,district.name as ds_name from order_detail,product,`order`,company,division,district where order_detail.order_id='$order_id' and  order_detail.product_id=product.id and order_detail.company_id=company.id and order_detail.division_id=division.id and order_detail.district_id=district.id");
									$total_price=0;

									
									while($row=mysqli_fetch_assoc($res)){
									
									$total_price=$total_price+($row['qty']*$row['price']);
									?>
									<tr>
										<td class="product-name"><?php echo $row['name']?></td>
										<td class="product-name"><img src="<?php echo $row['image']?>"></td>
										<td class="product-name"><?php echo $row['dv_name']?></td>
										<td class="product-name"><?php echo $row['ds_name']?></td>
										<td class="product-name"><?php echo $row['qty']?></td>
										<td class="product-name"><?php echo $row['price']?></td>
										<td class="product-name"><?php echo $row['qty']*$row['price']?></td>
										
									</tr>
                                        <?php } 
                                        if($coupon_value!=''){
                                        ?>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td class="product-name">Coupon Value</td>
                                            <td class="product-name"><?php echo $coupon_value?></td>
                                            
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td class="product-name">Total Price</td>
                                            <td class="product-name">
                                            <?php 
                                                echo $total_price - $coupon_value;
                                            ?></td>
                                            
                                        </tr>
								</tbody>
							
						</table>

						<div>
							<form method="post">
								<select class="form-control" name="update_order_status" required>
									<option value="">Select Status</option>
									<?php
									$res=mysqli_query($con,"select * from order_status");
									while($row=mysqli_fetch_assoc($res)){
											echo "<option value=".$row['id'].">".$row['name']."</option>";
										}
									?>
								</select>
								<input type="submit" class="form-control"/>
							</form>
						</div>
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