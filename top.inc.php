<?php
    require('connection.inc.php');
    require('function.inc.php');
    require('add_to_cart.inc.php');

$wishlist_count=0;
$cat_res=mysqli_query($con,"select * from category order by cat_name asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
    $cat_arr[]=$row;    
}

// cart count
$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();

//wishlist delete then count
if(isset($_SESSION['USER_LOGIN'])){
    $uid=$_SESSION['USER_ID'];
    
    if(isset($_GET['wishlist_id'])){
        $wid=get_safe_value($con,$_GET['wishlist_id']);
        mysqli_query($con,"delete from wishlist where id='$wid' and user_id='$uid'");
    }

    $wishlist_count=mysqli_num_rows(mysqli_query($con,"select product.name,product.image,product.price,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Asbab - eCommerce HTML5 Templatee</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Place favicon.ico in the root directory -->

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Owl Carousel min css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">

    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">

    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
        <style>
        .htc__wishlist{
        background: #c43b68;
        border-radius: 100%;
        color: #fff;
        font-size: 9px;
        height: 17px;
        line-height: 19px;
        position: absolute;
        right: 18px;
        text-align: center;
        top: -4px;
        width: 17px;
    }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->  

    <!-- Body main wrapper start -->
    <div class="wrapper">
        <!-- Start Header Style -->
        <header id="htc__header" class="htc__header__area header--one">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="index.php"><img src="images/logo/4.png" alt="logo images"></a>
                                </div>
                            </div>

                            <div class="col-md-7 col-lg-6 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        <li class="drop"><a href="index.php">Home</a></li>

                                        <?php
                                        foreach($cat_arr as $list){
                                        ?>
                                            <li class="drop"><a href="category_details.php?id=<?php echo $list['id'] ?>"><?php echo $list['cat_name']?></a>
                                            </li>

                                        <?php } ?>

                                        <li><a href="contact.html">contact</a></li>
                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                        <ul>
                                            <li><a href="index.php">Home</a></li>

                                        <?php
                                        foreach($cat_arr as $list){
                                        ?>
                                            <li class="drop"><a href="category_details.php?id=<?php echo $list['id'] ?>"><?php echo $list['cat_name']?></a>
                                            </li>

                                        <?php } ?>

                                            <li><a href="contact.html">contact</a></li>
                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            <div class="col-md-3 col-lg-4 col-sm-4 col-xs-4">
                                <div class="header__right">
                                    <div class="header__search search search__open">
                                        <a href="search.php"><i class="icon-magnifier icons"></i></a>
                                    </div>
                                    <div class="header__account">
                                    <?php if(isset($_SESSION['USER_LOGIN'])){ ?>
                                        <nav class="main__menu__nav hidden-xs hidden-sm">
                                            <ul class="main__menu">
                                                <li class="drop"><a href="#"><?php echo $_SESSION['USER_NAME']?></a>
                                                    <ul class="dropdown">
                                                        <li><a href="my_order.php">Order</a></li>
                                                        <li><a href="blog-details.html">Profile</a></li>
                                                        <li><a href="logout.php">Logout</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </nav>
                                    <?php
                                        }else{
                                            echo '<a href="login.php">Login/Register</a>';
                                        }
                                    ?>
                                    </div>
                                    <div class="htc__shopping__cart">
                                    <?php
                                        if(isset($_SESSION['USER_ID'])){
                                    ?>
                                        <a href="wishlist.php"><i class="icon-heart icons"></i></a>
                                        <a href="wishlist.php"><span class="htc__wishlist"><?php echo $wishlist_count?></span></a>
                                        
                                    <?php } ?>
                                        <a class="cart__menu" href="cart.php"><i class="icon-handbag icons"></i></a>
                                        <a href="cart.php"><span class="htc__qua"><?php echo $totalProduct?></span></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Area -->

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="#" method="get">
                                    <input placeholder="Search here... " type="text">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>