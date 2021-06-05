<?php 
	require('top.inc.php');

//middleware
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='login.php';
	</script>
	<?php
}

if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
	?>
	<script>
		window.location.href='index.php';
	</script>
	<?php
}

$cart_total=0;

if(isset($_POST['submit'])){
	$division_id=get_safe_value($con,$_POST['division_id']);
	$district_id=get_safe_value($con,$_POST['district_id']);
	$payment_type=get_safe_value($con,$_POST['payment_type']);
	$user_id=$_SESSION['USER_ID'];
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'',$key);
		$price=$productArr[0]['price'];
    $company_id=$productArr[0]['company_id'];
		$qty=$val['qty'];
		$cart_total=$cart_total+($price*$qty);
		
	}
  $cid = $company_id;
	$total_price=$cart_total;
	$payment_status='pending';
	if($payment_type=='cod'){
		$payment_status='success';
	}
	$order_status='1';
	$added_on=date('Y-m-d h:i:s');	 

	mysqli_query($con,"insert into `order`(user_id,payment_status,payment_type,
    order_status,total_price,added_on)values('$user_id','$payment_status','$payment_type','$order_status','$total_price','$added_on')");

	//catch the order_id that inserted last
	$order_id=mysqli_insert_id($con);
	
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'',$key);
		$price=$productArr[0]['price'];
		$qty=$val['qty'];
		
		mysqli_query($con,"insert into `order_detail`(order_id,product_id,company_id,division_id,district_id,qty,price) values('$order_id','$key','$cid','$division_id','$district_id','$qty','$price')");
	}
	
	unset($_SESSION['cart']);



	?>
	<script>
		window.location.href='thank_you.php';
	</script>
	<?php
	
}
?>
	<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
      <div class="ht__bradcaump__wrap">
          <div class="container">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="bradcaump__inner">
                          <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.php">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">checkout</span>
                          </nav>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- cart-main-area start -->
    <div class="checkout-wrap ptb--100">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="checkout-method__login">
              <form method="post">
              <h5 class="checkout-method__title">Address</h5>
                <div class="form-group">
                  <label for="cars">Select Division Name</label>
                  <select class="form-control" id="division_id" name="division_id" onchange="get_district('')">
                  <option>Select Division</option>
                  <?php
                  $res=mysqli_query($con,"select id,name from division order by name asc");
                    while($row=mysqli_fetch_assoc($res)){
                      echo "<option value=".$row['id'].">".$row['name']."</option>";
                    }
                  ?>
                  </select>
                  <span class="field_error" id="division_error"></span>
                </div>                        
                <div class="form-group">
                  <label for="cars">Select District Name</label>
                  <select class="form-control" name="district_id" id="district_id">
                      <option>Select District</option>
                  </select>
                  <span class="field_error" id="district_error"></span>
                </div>
                <div class="single-method">
                  COD <input type="radio" name="payment_type" value="cod" required/>
                  &nbsp;&nbsp;Stripe <input type="radio" name="payment_type" value="stripe" required/>
                </div>

                <input type="submit" name="submit" value="submit" class="fv-btn"/>
              </form>
            </div>
          </div>
          <div class="col-md-4">
            <div class="order-details">
              <h5 class="order-details__title">Your Order</h5>
              <div class="order-details__item">
                  <?php
    								$cart_total=0;
    								foreach($_SESSION['cart'] as $key=>$val){
    								$productArr=get_product($con,'',$key);
    								$pname=$productArr[0]['name'];
    								$price=$productArr[0]['price'];
    								$image=$productArr[0]['image'];
    								$qty=$val['qty'];
    								$cart_total=$cart_total+($price*$qty);
    							?>
    							<div class="single-item">
                    <div class="single-item__thumb">
                        <img src="employee/<?php echo $image?>"  />
                    </div>
                    <div class="single-item__content">
                        <a href="#"><?php echo $pname?></a>
                        <span class="price"><?php echo $price*$qty?></span>
                    </div>
                    <div class="single-item__remove">
    									
    									<td class="product-remove"><a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','remove')"><i class="icon-trash icons"></i></a></td>
                    </div>
                  </div>
                <?php } ?>
            </div>

            <div class="ordre-details__total">
              <h5>Order total</h5>
              <span class="price" id="order_total_price"><?php echo $cart_total?></span>
            </div>


            </div>
          </div>
        </div>
      </div>
    </div>


<?php require('footer.inc.php')?>
<script>
    function get_district(dist_id){
        var division_id=jQuery('#division_id').val();
        jQuery.ajax({
            url:'get_district.php',
            type:'post',
            data:'division_id='+division_id+'&dist_id='+dist_id,
            success:function(result){
                jQuery('#district_id').html(result);
            }
        });
    }
 </script>
 <script>
    <?php
    if(isset($_GET['id'])){
    ?>
    get_district('<?php echo $district_id?>');
    <?php } ?>
</script>  