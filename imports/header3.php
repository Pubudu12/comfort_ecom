<?php 
// require_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/sessions.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'app/controllers/productsControllerClass.php'; 

$productsArray = $productControllerObj->getTrendingProducts('latest', 1);

require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'shopController/class/cartClass.php';
$cartItemsArray = $cartObj->fetchCartItemsFromOut();
$menuFullListArray = $headerClassOBJ->getFullListMenu();
?>
<div class="header-area header-area--default">

<!-- Header Bottom Wrap Start -->
<!-- <header class="header-area  header-sticky"> -->
<header class="header-area header_absolute header_height-90 header-sticky">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-2 d-md-block" style="margin:0px !important;padding-left: 0 !important;">
                <div class="header-left-search">
                    <div class="logo text-md-left">
                        <!-- <div class="white-background"> -->
                            <a href="<?php echo URL?>"><img src="<?php echo URL?>assets/img/logo/logofinal.png" style="margin-left: 20px;" alt=""></a><!--logo/logo-lg.png-->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-5">
            <div class="header__navigation d-none d-lg-block">
                    <nav class="navigation-menu">
                        <ul class="justify-content-center">
                            <li class="">
                                <a id="aboutus" href="<?php echo URL?>about"><span>About Us</span></a>
                            </li>
                            <li class="">
                                <a id="shop" href="<?php echo URL?>shop"><span>The Sleep Shop</span></a>
                                <!-- <ul class="submenu">
                                    <li>
                                        <?php foreach ($menuFullListArray as $key => $singleMenu) {?>
                                            <a href="<?php echo URL?>shop/<?php echo $singleMenu['slug_url']?>"><span><?php echo $singleMenu['name']?></span></a>
                                        <?php }?>
                                    </li>
                                </ul> -->
                            </li>
                            <li class="">
                                <a id="blogs" href="<?php echo URL?>blog"><span>The Sleep Blog</span></a>
                            </li>
                            <li class="">
                                <a id="newsevents" href="<?php echo URL?>news"><span>News and Events</span></a>
                            </li>
                            <li class="">
                                <a id="gallery" href="<?php echo URL?>gallery"><span>The Gallery</span></a>
                            </li>
                            <li class="">
                                <a id="contactus" href="<?php echo URL?>contact"><span>Contact Us</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-5">
                <div class="header-right-side text-right">
                    <div class="header-right-items d-none d-md-block" id="header-right-items">
                            <?php if(isset($_SESSION['user_id'])){ ?>
                                <a  class="dropdown-toggle" data-toggle="dropdown">
                                    <?php if ($_SESSION['user_type'] == 'dealer') {?>
                                        <small class="margin-left-af-login">Hi<?php echo $_SESSION['name']?></small>
                                        <!-- <br> -->
                                        <small class="font-resize">(Dealer)</small>
                                    <?php }else{?>
                                        <small class="margin-left-af-login">Hi <?php echo $_SESSION['name']?></small>
                                    <?php }?>
                                </a>
                                <div class="dropdown-menu">
                                    <?php if(($_SESSION['user_type'] == 'std') | ($_SESSION['user_type'] == 'dealer')) { ?>
                                        <a class="dropdown-item" href="<?php echo URL?>my_account">My Account</a>
                                    <?php }?>
                                    <a class="dropdown-item" href="<?php echo URL?>logout">Logout</a>
                                </div>
                            <?php }else{ ?>
                                <a  class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-user"></i>
                                </a>
                                <?php if (! isset($_SESSION['user_type'])){?>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item d-hover" href="<?php echo URL?>login">Sign In</a>
                                    <a class="dropdown-item d-hover" href="<?php echo URL?>register">Sign Up</a>
                                </div>
                                <?php }?>
                            <?php } ?>
                    </div>

                    <div class="header-right-items">
                        <a href="#miniCart" class=" header-cart minicart-btn toolbar-btn header-icon">
                            <i class="icon-bag2"></i>
                            <span class="item-counter text-clr-black" id="menu-total_items"> 0 </span>
                        </a>
                    </div>
                    <div class="header-right-items">
                        <a href="javascript:void(0)" class="search-icon" id="search-overlay-trigger">
                            <i class="icon-magnifier"></i>
                        </a>
                    </div>
                    <div class="header-right-items">
                        <a href="#" class="mobile-navigation-icon" id="mobile-menu-trigger">
                            <i class="icon-menu"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Bottom Wrap End -->

</div>
  <!--====================  mobile menu overlay ====================-->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay">
        <div class="mobile-menu-overlay__inner">
            <div class="mobile-menu-close-box text-left">
                <span class="mobile-navigation-close-icon" id="mobile-menu-close-trigger"> <i class="icon-cross2"></i></span>
            </div>
            <div class="mobile-menu-overlay__body">
                <nav class="offcanvas-navigation">
                    <ul>
                        <?php if(isset($_SESSION['user_id'])){ ?>
                            <li class=" mob-name dekstop-account-display">
                                Hi <?php echo $_SESSION['name']?>
                                <!-- <br> -->
                                <?php if ($_SESSION['user_type'] == 'dealer') {?>
                                    <small class="font-resize">(Dealer)</small>
                                <?php }?>
                            </li>
                        <?php }?>
                        <li class="has-children">
                            <a id="homepage" href="<?php echo URL?>home">Home</a>
                        </li>
                        <li class="has-children">
                            <a id="aboutus" href="<?php echo URL?>about">About Us</a>
                        </li>
                        <li class="has-children">
                            <a href="#">The Sleep Shop</a>
                            <ul class="sub-menu">
                                <?php foreach ($menuFullListArray as $key => $value) {?>
                                    <li><a href="<?php echo URL?>shop/<?php echo $value['slug_url']?>"><span><?php echo $value['name']?></span></a></li>
                                <?php }?>
                            </ul>
                        </li>
                        <li class="has-children">
                            <a id="blogs" href="<?php echo URL?>blog">The Sleep Blog</a>
                        </li>
                        <li class="has-children">
                            <a id="newsevents" href="<?php echo URL?>news">News and Events</a>
                        </li>
                        <li class="has-children">
                            <a id="gallery" href="<?php echo URL?>gallery">Gallery</a>
                        </li>
                        <li class="has-children">
                            <a id="contactus" href="<?php echo URL?>contact">Contact Us</a>
                        </li>
                        <?php if(isset($_SESSION['user_id'])){
                            if(($_SESSION['user_type'] == 'std') | ($_SESSION['user_type'] == 'dealer')) { ?>
                                <li class="has-children dekstop-account-display">
                                    <a href="<?php echo URL?>my_account">My Account</a>      
                                </li>
                                <li class="has-children dekstop-account-display">
                                    <a href="<?php echo URL?>logout">Logout</a>      
                                </li>
                        <?php }
                        }?>
                        <?php if (! isset($_SESSION['user_type'])){?>
                            <li class="has-children dekstop-account-display">
                                <a href="<?php echo URL?>login">Sign In</a>      
                            </li>
                            <li class="has-children dekstop-account-display">
                                <a href="<?php echo URL?>login">Sign Up</a>      
                            </li>
                            <!-- <li class="has-children dealer-login-padding">
                                <a href="<?php echo URL?>dealer/login" class="hover-style-link btn--lg btn-brown font-weight--reguler text-white de-btn">Dealer Sign In</a>
                            </li> -->
                            <li class="has-children desktop-dealer-align">
                                <a href="<?php echo URL?>dealer/login" class="dealer-menu-btn">Dealer Sign In</a>
                            </li>
                        <?php }?>
                        
                    </ul>
                </nav>
            </div>
        </div>
    </div>
<!--====================  End of mobile menu overlay  ====================-->

  <!--  offcanvas Minicart Start -->
  <div class="offcanvas-minicart_wrapper" id="miniCart">
        <div class="offcanvas-menu-inner">
            <div class="close-btn-box">
                <a href="#" class="btn-close"><i class="icon-cross2"></i></a>
            </div>
            <div class="minicart-content">
                <ul class="minicart-list" id="menu-cart_items">
                    
                </ul>
            </div>
            <div class="minicart-item_total">
                <span class="font-weight--reguler font-brown">Total:</span>
                <span class="ammount font-weight--reguler font-brown" id="menu-totalCartAmount"></span>
            </div>
            <?php 
            $disabled = '';
            if( count($cartItemsArray['itemsArray']) <= 0){
                $disabled = 'disabled';
            }?>
            <div class="minicart-btn_area">
                <a href="<?php echo URL?>cart" class="btn btn--full btn--border_1 y-btn <?php echo $disabled?>">View Cart</a>
            </div>
            <div class="minicart-btn_area">
                <a href="<?php echo URL?>checkout" class="btn btn--full btn--brown <?php echo $disabled?>">Checkout</a> <!--btn--black-->
            </div>
        </div>
    </div>
    <!--  offcanvas Minicart End -->


<!-- search overlay -->

<div class="search-overlay" id="search-overlay">

        <div class="search-overlay__header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-8">
                        <div class="search-title">
                            <h4 class="font-weight--normal">Search</h4>
                        </div>
                    </div>
                    <div class="col-md-6 ml-auto col-4">
                        <!-- search content -->
                        <div class="search-content text-right">
                            <span class="mobile-navigation-close-icon" id="search-close-trigger"><i class="icon-cross"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-overlay__inner">
            <div class="search-overlay__body">
                <div class="search-overlay__form">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9 ml-auto mr-auto">
                                <form action="<?php echo URL?>search">
                                    <div class="product-cats section-space--mb_60 text-center">
                                    <?php foreach ($menuFullListArray as $key => $singleCategory) { ?>
                                        <label> 
                                                <a href="<?php echo URL?>shop/<?php echo $singleCategory['slug_url'] ?>" class="hover-style-link <?php echo doActive($categoryId, $singleCategory['id']) ?>"><span class="line-hover"><?php echo $singleCategory['name']?></span></a>
                                            
                                            </label>
                                        <?php }?>
                                        <!-- <label> <input type="radio" name="product_cat" value="chair"> <span class="line-hover">Chair</span> </label> -->
                                    </div>
                                    <div class="search-fields">
                                        <input type="text" placeholder="Search" name="q">
                                        <button class="submit-button" type="submit"><i class="icon-magnifier"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<!-- <div class="search-overlay" id="search-overlay">
    <div class="search-overlay__header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-8">
                    <div class="search-title">
                    </div>
                </div>
                <div class="col-md-6 ml-auto col-4">
                    <div class="search-content text-right">
                        <span class="mobile-navigation-close-icon" id="search-close-trigger"><i class="icon-cross"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-overlay__inner">
        <div class="search-overlay__body">
            <div class="search-overlay__form">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 ml-auto mr-auto header-left-search">
                                <div class="product-cats section-space--mb_60 text-left">
                                    
                                    <?php foreach ($menuFullListArray as $key => $singleCategory) { ?>
                                        <label> 
                                            <a href="<?php echo URL?>shop<?php echo $singleCategory['slug_url'] ?>" class="hover-style-link <?php echo doActive($categoryId, $singleCategory['id']) ?>"><span class="line-hover"><?php echo $singleCategory['name']?></span></a>
                                        
                                        </label>
                                    <?php }?>
                                </div>
                                <form action="<?php echo URL?>search" class="header-search-box">
                                    <input class="search-field" type="text" name="q" placeholder="Search">
                                    <button class="search-icon" type="submit"><i class="icon-magnifier"></i></button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<script>
    if (<?php echo $_SESSION['user_id']?>) {
        // $(".header-right-side .header-right-items").removeClass('header-right-items')
        // $(".header-right-side .header-right-items").addClass('logged-in-ml')

        // document.getElementById("header-right-items").removeClass('header-right-items');
        // document.getElementById("header-right-items").addClass('logged-in-ml');
        // myElement.style.color = "red";
        // addClass('margin-left-af-login');
    }    
</script>