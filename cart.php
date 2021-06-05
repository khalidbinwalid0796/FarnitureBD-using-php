<?php 
require('top.inc.php');
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
                                  <span class="breadcrumb-item active">shopping cart</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#">               
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">Product</th>
                                            <th class="product-name">Name of Product</th>
                                            <th class="product-name">Name of Company</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                <tbody>
					<?php
					if(isset($_SESSION['cart'])){
						foreach($_SESSION['cart'] as $key=>$val){
						$productArr=get_product($con,'',$key);
                        $image=$productArr[0]['image'];
						$pname=$productArr[0]['name'];
						$selling_price=$productArr[0]['price'];
                        $com_id=$productArr['0']['company_id'];
                        $qty=$val['qty'];

                        //Company name show
                        $cat=mysqli_fetch_assoc(mysqli_query($con,"select com_name from company where id='$com_id'"));
                        $cname=$cat['com_name'];
						?>

                    <tr>
                        <td class="product-thumbnail"><a href="product_details.php?id=<?php echo $key?>"><img src="employee/<?php echo $image?>"  /></a></td>
                        <td class="product-name"><a href="product_details.php?id=<?php echo $key?>"><?php echo $pname?></a>
                        </td>
                        <td class="product-name"><?php echo $cname?>
                        </td>
                        <td class="product-price"><span class="amount">TK. <?php echo $selling_price?></span></td>
                        <td class="product-quantity"><input type="number" id="<?php echo $key?>qty" value="<?php echo $qty?>" />
                        <br/><a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','update')">update</a>
                        </td>
                        <td class="product-subtotal">TK. <?php echo $qty*$selling_price ?></td>
                        <td class="product-remove"><a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','remove')"><i class="icon-trash icons"></i></a></td>
                    </tr>                    
					<?php } } ?>
            </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                        <div class="buttons-cart">
                                            <a href="index.php">Continue Shopping</a>
                                        </div>
                                        <div class="buttons-cart checkout--btn">
                                            <a href="checkout.php">checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        
										
<?php require('footer.inc.php')?>        