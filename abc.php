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

  if(isset($_SESSION['COUPON_ID'])){
    $coupon_id=$_SESSION['COUPON_ID'];
    $coupon_code=$_SESSION['COUPON_CODE'];
    $coupon_value=$_SESSION['COUPON_VALUE'];
    $total_price=$total_price-$coupon_value;
    unset($_SESSION['COUPON_ID']);
    unset($_SESSION['COUPON_CODE']);
    unset($_SESSION['COUPON_VALUE']);
  }else{
    $coupon_id='';
    $coupon_code='';
    $coupon_value=''; 
  } 

	mysqli_query($con,"insert into `order` ( user_id,company_id,division_id,district_id,payment_status,payment_type,
    order_status,total_price,added_on,coupon_id,coupon_value,coupon_code ) values ( '$user_id','$cid','$division_id','$district_id','$payment_status','$payment_type','$order_status','$total_price','$added_on','$coupon_id','$coupon_value','$coupon_code' ) " );

	//catch the order_id that inserted last
	$order_id=mysqli_insert_id($con);
	
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'',$key);
		$price=$productArr[0]['price'];
		$qty=$val['qty'];
		
		mysqli_query($con,"insert into `order_detail`(order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");
	}
	
	unset($_SESSION['cart']);

if($payment_type=='cod'){

  $res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product,`order` where order_detail.order_id='$order_id' and order_detail.product_id=product.id");

  $user_order=mysqli_fetch_assoc(mysqli_query($con,"select `order`.*, users.name,users.email  from `order`,users where users.id=`order`.user_id and `order`.id='$order_id'"));
  $email = $user_order['email'];

  $coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value from `order` where id='$order_id'"));
  $coupon_value=$coupon_details['coupon_value'];

  $total_price=0;

    $html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */
        
        @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
        body {
          width: 100% !important;
          height: 100%;
          margin: 0;
          -webkit-text-size-adjust: none;
        }
        
        a {
          color: #3869D4;
        }
        
        a img {
          border: none;
        }
        
        td {
          word-break: break-word;
        }
        
        .preheader {
          display: none !important;
          visibility: hidden;
          mso-hide: all;
          font-size: 1px;
          line-height: 1px;
          max-height: 0;
          max-width: 0;
          opacity: 0;
          overflow: hidden;
        }
        /* Type ------------------------------ */
        
        body,
        td,
        th {
          font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
        }
        
        h1 {
          margin-top: 0;
          color: #333333;
          font-size: 22px;
          font-weight: bold;
          text-align: left;
        }
        
        h2 {
          margin-top: 0;
          color: #333333;
          font-size: 16px;
          font-weight: bold;
          text-align: left;
        }
        
        h3 {
          margin-top: 0;
          color: #333333;
          font-size: 14px;
          font-weight: bold;
          text-align: left;
        }
        
        td,
        th {
          font-size: 16px;
        }
        
        p,
        ul,
        ol,
        blockquote {
          margin: .4em 0 1.1875em;
          font-size: 16px;
          line-height: 1.625;
        }
        
        p.sub {
          font-size: 13px;
        }
        /* Utilities ------------------------------ */
        
        .align-right {
          text-align: right;
        }
        
        .align-left {
          text-align: left;
        }
        
        .align-center {
          text-align: center;
        }
        /* Buttons ------------------------------ */
        
        .button {
          background-color: #3869D4;
          border-top: 10px solid #3869D4;
          border-right: 18px solid #3869D4;
          border-bottom: 10px solid #3869D4;
          border-left: 18px solid #3869D4;
          display: inline-block;
          color: #FFF;
          text-decoration: none;
          border-radius: 3px;
          box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
          -webkit-text-size-adjust: none;
          box-sizing: border-box;
        }
        
        .button--green {
          background-color: #22BC66;
          border-top: 10px solid #22BC66;
          border-right: 18px solid #22BC66;
          border-bottom: 10px solid #22BC66;
          border-left: 18px solid #22BC66;
        }
        
        .button--red {
          background-color: #FF6136;
          border-top: 10px solid #FF6136;
          border-right: 18px solid #FF6136;
          border-bottom: 10px solid #FF6136;
          border-left: 18px solid #FF6136;
        }
        
        @media only screen and (max-width: 500px) {
          .button {
            width: 100% !important;
            text-align: center !important;
          }
        }
        /* Attribute list ------------------------------ */
        
        .attributes {
          margin: 0 0 21px;
        }
        
        .attributes_content {
          background-color: #F4F4F7;
          padding: 16px;
        }
        
        .attributes_item {
          padding: 0;
        }
        /* Related Items ------------------------------ */
        
        .related {
          width: 100%;
          margin: 0;
          padding: 25px 0 0 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .related_item {
          padding: 10px 0;
          color: #CBCCCF;
          font-size: 15px;
          line-height: 18px;
        }
        
        .related_item-title {
          display: block;
          margin: .5em 0 0;
        }
        
        .related_item-thumb {
          display: block;
          padding-bottom: 10px;
        }
        
        .related_heading {
          border-top: 1px solid #CBCCCF;
          text-align: center;
          padding: 25px 0 10px;
        }
        /* Discount Code ------------------------------ */
        
        .discount {
          width: 100%;
          margin: 0;
          padding: 24px;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #F4F4F7;
          border: 2px dashed #CBCCCF;
        }
        
        .discount_heading {
          text-align: center;
        }
        
        .discount_body {
          text-align: center;
          font-size: 15px;
        }
        /* Social Icons ------------------------------ */
        
        .social {
          width: auto;
        }
        
        .social td {
          padding: 0;
          width: auto;
        }
        
        .social_icon {
          height: 20px;
          margin: 0 8px 10px 8px;
          padding: 0;
        }
        /* Data table ------------------------------ */
        
        .purchase {
          width: 100%;
          margin: 0;
          padding: 35px 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .purchase_content {
          width: 100%;
          margin: 0;
          padding: 25px 0 0 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .purchase_item {
          padding: 10px 0;
          color: #51545E;
          font-size: 15px;
          line-height: 18px;
        }
        
        .purchase_heading {
          padding-bottom: 8px;
          border-bottom: 1px solid #EAEAEC;
        }
        
        .purchase_heading p {
          margin: 0;
          color: #85878E;
          font-size: 12px;
        }
        
        .purchase_footer {
          padding-top: 15px;
          border-top: 1px solid #EAEAEC;
        }
        
        .purchase_total {
          margin: 0;
          text-align: right;
          font-weight: bold;
          color: #333333;
        }
        
        .purchase_total--label {
          padding: 0 15px 0 0;
        }
        
        body {
          background-color: #F4F4F7;
          color: #51545E;
        }
        
        p {
          color: #51545E;
        }
        
        p.sub {
          color: #6B6E76;
        }
        
        .email-wrapper {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #F4F4F7;
        }
        
        .email-content {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        /* Masthead ----------------------- */
        
        .email-masthead {
          padding: 25px 0;
          text-align: center;
        }
        
        .email-masthead_logo {
          width: 94px;
        }
        
        .email-masthead_name {
          font-size: 16px;
          font-weight: bold;
          color: #A8AAAF;
          text-decoration: none;
          text-shadow: 0 1px 0 white;
        }
        /* Body ------------------------------ */
        
        .email-body {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #FFFFFF;
        }
        
        .email-body_inner {
          width: 570px;
          margin: 0 auto;
          padding: 0;
          -premailer-width: 570px;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #FFFFFF;
        }
        
        .email-footer {
          width: 570px;
          margin: 0 auto;
          padding: 0;
          -premailer-width: 570px;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          text-align: center;
        }
        
        .email-footer p {
          color: #6B6E76;
        }
        
        .body-action {
          width: 100%;
          margin: 30px auto;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          text-align: center;
        }
        
        .body-sub {
          margin-top: 25px;
          padding-top: 25px;
          border-top: 1px solid #EAEAEC;
        }
        
        .content-cell {
          padding: 35px;
        }
        /*Media Queries ------------------------------ */
        
        @media only screen and (max-width: 600px) {
          .email-body_inner,
          .email-footer {
            width: 100% !important;
          }
        }
        
        @media (prefers-color-scheme: dark) {
          body,
          .email-body,
          .email-body_inner,
          .email-content,
          .email-wrapper,
          .email-masthead,
          .email-footer {
            background-color: #333333 !important;
            color: #FFF !important;
          }
          p,
          ul,
          ol,
          blockquote,
          h1,
          h2,
          h3 {
            color: #FFF !important;
          }
          .attributes_content,
          .discount {
            background-color: #222 !important;
          }
          .email-masthead_name {
            text-shadow: none !important;
          }
        }
        </style>
        <!--[if mso]>
        <style type="text/css">
          .f-fallback  {
            font-family: Arial, sans-serif;
          }
        </style>
      <![endif]-->
      </head>
      <body>
        <span class="preheader">This is an invoice for your purchase on '.$user_order['added_on'].'. Please submit payment by {{ due_date }}</span>
        <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td align="center">
              <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="email-masthead">
                    <a href="https://example.com" class="f-fallback email-masthead_name">
                    Invoice
                  </a>
                  </td>
                </tr>
                <!-- Email Body -->
                <tr>
                  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                    <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                      <!-- Body content -->
                      <tr>
                        <td class="content-cell">
                          <div class="f-fallback">
                            <h1>Hi '.$user_order['name'].',</h1>
                            <p>Thanks for using ourwebsite. This is an invoice for your recent purchase.</p>
                            <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td class="attributes_content">
                                  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                      <td class="attributes_item">
                                        <span class="f-fallback">
                                          <strong>Amount : </strong> '.$user_order['total_price'].'.
                                        </span>
                                      </td>
                                    </tr>
                                   
                                  </table>
                                </td>
                              </tr>
                            </table>
                            <!-- Action -->
                            
                            <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>
                                  <h3>'.$user_order['id'].'.</h3>
                                </td>
                                <td>
                                  <h3 class="align-right">'.$user_order['added_on'].'.</h3>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <th class="purchase_heading" align="left">
                                        <p class="f-fallback">Description</p>
                                      </th>
                                      <th class="purchase_heading" align="right">
                                        <p class="f-fallback">Amount</p>
                                      </th>
                                    </tr>
                                    Invoice Details';
                                    while($row=mysqli_fetch_assoc($res)){
                                      $total_price=$total_price+($row['qty']*$row['price']);
                                      $pp=$row['qty']*$row['price'];
                                      $html.='<tr>
                                        <td width="80%" class="purchase_item"><span class="f-fallback">'.$row['name'].'</span></td>
                                        <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$pp.'</span></td>
                                      </tr>';
                                    }
                    
                                  if($coupon_value!=''){                
                                  $html.=' <td width="80%" class="purchase_footer" valign="middle">
                                        <p class="f-fallback purchase_total purchase_total--label">Coupon Value</p>
                                      </td>
                                      <td width="20%" class="purchase_footer" valign="middle">
                                        <p class="f-fallback purchase_total">'.$coupon_value.'</p>
                                      </td>
                                    </tr>';
                                    }
                                    $total_price=$total_price-$coupon_value;
                                    $html.='<tr>
                                      <td width="80%" class="purchase_footer" valign="middle">
                                        <p class="f-fallback purchase_total purchase_total--label">Total</p>
                                      </td>
                                      <td width="20%" class="purchase_footer" valign="middle">
                                        <p class="f-fallback purchase_total">'.$total_price.'</p>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            <p>If you have any questions about this invoice, simply reply to this email or reach out to our support team for help.</p>

                            <!-- Sub copy -->
                            
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td class="content-cell" align="center">
                          <p class="f-fallback sub align-center">&copy; 2021 All rights reserved.</p>
                          <p class="f-fallback sub align-center">
                            Asbab Farniture
                            <br>Rupatoly Housing
                            <br>Barishal
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </body>
    </html>';
    include('smtp/PHPMailerAutoload.php');
    $mail=new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host="smtp.mailtrap.io";
    $mail->Port=2525;
    $mail->SMTPSecure="tls";
    $mail->SMTPAuth=true;
    $mail->Username="cb13a3ef4b0dc1";
    $mail->Password="4ebc773e056a16";
    $mail->SetFrom("khalidbucse02@gmail.com");
    $mail->addAddress($email);
    $mail->IsHTML(true);
    $mail->Subject="Invoice Details";
    $mail->Body=$html;
    $mail->SMTPOptions=array('ssl'=>array(
      'verify_peer'=>false,
      'verify_peer_name'=>false,
      'allow_self_signed'=>false
    ));
    if($mail->send()){
      //echo "done";
    }else{
      //echo "Error occur";
    }
}

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
            <div class="ordre-details__total" id="coupon_box">
              <h5>Coupon Value</h5>
              <span class="price" id="coupon_price"></span>
            </div>
            <div class="ordre-details__total">
              <h5>Order total</h5>
              <span class="price" id="order_total_price"><?php echo $cart_total?></span>
            </div>
            <div class="ordre-details__total bilinfo">
              <input type="textbox" id="coupon_str" class="coupon_style mr5"/> <input type="button" name="submit" class="fv-btn coupon_style" value="Apply Coupon" onclick="set_coupon()"/>
            </div>
            <div id="coupon_result"></div>

            </div>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript">
  function set_coupon(){
    var coupon_str=jQuery('#coupon_str').val();
      if(coupon_str!=''){
        jQuery('#coupon_result').html('');
        jQuery.ajax({
          url:'set_coupon.php',
          type:'post',
          data:'coupon_str='+coupon_str,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.is_error=='yes'){
              jQuery('#coupon_box').hide();
              jQuery('#coupon_result').html(data.dd);
              jQuery('#order_total_price').html(data.result);
            }
            if(data.is_error=='no'){
              jQuery('#coupon_box').show();
              jQuery('#coupon_price').html(data.dd);
              jQuery('#order_total_price').html(data.result);
            }           
          }
        });
      }
  }
</script>

<?php 
if(isset($_SESSION['COUPON_ID'])){
  unset($_SESSION['COUPON_ID']);
  unset($_SESSION['COUPON_CODE']);
  unset($_SESSION['COUPON_VALUE']);
}
?>
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