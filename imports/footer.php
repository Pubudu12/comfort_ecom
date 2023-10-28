<?php 

$slug = 'mettresses';
$page_full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$slug = basename(parse_url($page_full_url, PHP_URL_PATH));

$categoryId = 0;
if(isset($_GET['id'])){
    if(is_numeric($_GET['id'])){
        $categoryId = trim(mysqli_real_escape_string($localhost, $_GET['id']));        
    }
}
$otherDetails = $productControllerObj->getStoreSelectedCategoryDetails($slug);
$catlevel = $otherDetails['categoryDetailsArray']['level'];

$menuFullListArray = $headerClassOBJ->getFullListMenu();
$trendingProductsArray = $productControllerObj->trendingProducts(4);
$categoryArr = $productControllerObj->fetchCategories();
?>

<div class="footer-area-wrapper" id="outlets">
        <div class="footer-area section-space--pt_50">
            <div class="container container-fluid--cp-100">
                <div class="row footer-widget-wrapper">
                    <div class="col-lg-4 col-md-6 col-sm-6 footer-widget">
                        <h6 class="footer-widget__title">Address</h6>
                        <div class="footer-line-1"></div>
                        <ul class="footer-widget__list mb-4">
                            <li><i class="icon_pin"></i> No 175, Bauddhaloka Mawatha, <br>Colombo 7</li>
                            <li> <i class="icon_phone"></i><a href="tel:94(77)2663678" class="hover-style-link">+ 94 (77) 266 3678</a></li>
                        </ul>
                        <ul class="footer-widget__list">
                            <li><i class="icon_pin"></i> No 60A, Avissawella Road, Ambatale,<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sedawatta - Ambatale Road.</li>
                            <li> <i class="icon_phone"></i><a href="tel:94(77)7748789" class="hover-style-link">+  94 (77) 774 8789</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-widget">
                        <h6 class="footer-widget__title">Quick links</h6>
                        <div class="footer-line-1"></div>
                        <ul class="footer-widget__list">
                            <li><a href="<?php echo URL?>home" class="hover-style-link">Home</a></li>
                            <li><a href="<?php echo URL?>about" class="hover-style-link">About Us</a></li>
                            <li><a href="<?php echo URL?>blog" class="hover-style-link">Blog</a></li>
                            <li><a href="<?php echo URL?>news" class="hover-style-link">News and events</a></li>
                            <!-- <li><a href="<?php echo URL?>terms" class="hover-style-link">Terms and Conditions</a></li> -->
                        </ul>
                    </div>
                   
                    <div class="col-lg-4 col-md-6 col-sm-6 footer-widget">
                    <h6 class="footer-widget__title">Categories</h6>
                    <div class="footer-line-1 line-extend"></div>
                    <div class="ffoter-flex-1">
                        <ul class="footer-widget__list">
                            <?php foreach ($menuFullListArray as $key => $singleCategory) {
                                 if (($key == 0) |($key == 1)|($key == 2) | ($key == 3)) {?>
                                    <li><a href="<?php echo URL?>shop/<?php echo $singleCategory['slug_url'] ?>" ><?php echo $singleCategory['name']?></a></li>
                                <?php }
                                } ?>
                        </ul>
                        <ul class="footer-widget__list">
                            <?php foreach ($menuFullListArray as $key => $singleCategory) {
                                if (($key == 4) |($key == 5)|($key == 6)) {?>
                                    <li><a href="<?php echo URL?>shop/<?php echo $menuFullListArray[$key]['slug_url'] ?>" ><?php echo $menuFullListArray[$key]['name']?></a></li>
                                <?php }
                                } ?>
                        </ul>
                            </div>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-6 footer-widget" style="align-items: center;display: flex;align-content: center;text-align: center;margin: auto;">
                    <ul class="list footer-social-networks center-flex-footer1 footer1-ka social-icon-center-mbl">
                                <li class="item">
                                    <a href="https://www.facebook.com/comfortwi/" target="_blank" aria-label="Twitter">
                                        <i class="social social_facebook"></i>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="https://www.instagram.com/comfortworldinternational/"  target="_blank" aria-label="Instagram">
                                        <i class="social social_instagram"></i>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="https://www.linkedin.com/company/comfortworld/?originalSubdomain=lk"  target="_blank" aria-label="Instagram">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                    </div>
                </div>
                <div class="row so-footr1">
                    <div class="col-lg-4 col-md-4 col-sm-6  center-flex-footer1 dealer-custom">
                                <a class="footer-underline" href="<?php echo URL?>dealer/login">Dealer Login</a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 ">
                        <div class="center-flex-footer1">
                            <a href="<?php echo URL?>"><img class="footer-logo" alt="Comfort-world" src="<?php echo URL?>assets/img/logo-slide/b.png" ></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 center-flex-footer1">
                    <a class="footer-underline" target="_blank" href="<?php echo URL?>terms">Terms and Condition / Privacy Policy</a>
                    <!-- <li style="list-style-type: none;"><a href="<?php echo URL?>dealer/login" class="hover-style-link btn--lg btn-brown font-weight--reguler text-white
                    ">Dealer Sign In</a></li> -->
                    </div>
                </div>
            </div>

            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-link1">© <?php echo date('Y')?> Comfort World. All Rights Reserved. A <a class="f-com-link" href="https://www.creativehub.global/" target="_blank">Creative<span style="color:#f1634c;">Hub</span>&nbsp;</a>Website</div>
                    </div>
                </div>
            </div>
        </div>
    </div>