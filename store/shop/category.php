<?php require_once '../../app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
include ROOT_PATH.'store/includes/productsListTop.php';

$trendingProductArray = $productControllerObj->getTrendingProducts('latest', 1);
// print_r($trendingProductArray);
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Product Categories | ';
        $meta_single_page_desc = '';
        $meta_arr = array(
            'title' => $meta_single_page_title,
            'description' => $meta_single_page_desc,
            'image' => URL.'assets/images/meta/home.jpg',
            
            'og:title' => $meta_single_page_title,
            'og:image' => URL.'assets/images/meta/home.jpg',
            'og:description' => $meta_single_page_desc,

            'twitter:image' => URL.'assets/images/meta/home.jpg',
            'twitter:title' => $meta_single_page_title,

        );
        require_once ROOT_PATH.'app/meta/meta_more_details.php'; 
        ?>

    <!-- CSS
        ============================================ -->

        <?php require_once ROOT_PATH.'imports/css.php' ?>

</head>

<body class="">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>    <!--====================  End of header area  ====================-->
    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area section-space--pt_80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title colour-brown"><b>The Sleep Shop</b></h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">The Sleep Shop</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    
    <div class="site-wrapper-reveal border-bottom">

    <div class="categories-shop-area section-space--pt_90 section-space--pb_90 category-shop-1">
            <div class="container">
                <div class="row row--5">
                    <?php foreach ($menuFullListArray as $key => $menuMainArray) {?>
                        <div class="<?php echo $menuMainArray['class']?>">
                            <div class="hero-product-image mt-10">
                                <a href="<?php echo URL?>shop/<?php echo $menuMainArray['slug_url'] ?>">
                                    <img src="<?php echo $menuMainArray['imagesArray']['thumb'][0]?>" class="img-fluid" alt="<?php echo $menuMainArray['name'] ?>">
                                    <div class="category-overlay"></div>
                                </a>
                                <div class="product-banner-title shop-font">
                                    <h4><a href="<?php echo URL?>shop/<?php echo $menuMainArray['slug_url'] ?>"><?php echo $menuMainArray['name'] ?></a></h4>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- trending products -->
                <div class="row">
                    <?php if(count($trendingProductArray) > 0){ ?>
                        <div class="related-products section-space--ptb_90">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="section-title text-center mb-30">
                                        <h4 class="uppercase">Trending products</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row product-slider-active-1">
                                <?php foreach ($trendingProductArray as $key => $simProAr) { 
                                    if ($key == 8) {
                                        break;
                                    }else{ ?>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <?php echo $simProAr; ?>
                                    </div>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="section-space--ptb_60"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!--====================  footer area ====================-->
    <?php require_once ROOT_PATH.'imports/footer.php' ?>
    <!--====================  End of footer area  ====================-->


    <!--====================  scroll top ====================-->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top icon-arrow-up"></i>
        <i class="arrow-bottom icon-arrow-up"></i>
    </a>
    <!--====================  End of scroll top  ====================-->

    <?php require_once ROOT_PATH.'imports/js.php' ?>

    <script>
        $('#shop').addClass('active');
    </script>

</body>

</html>