<?php 
require_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'app/controllers/productsControllerClass.php';
require_once ROOT_PATH.'imports/functions.php';
include ROOT_PATH.'store/includes/productsListTop.php';

?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Shop | ';
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
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->

       <!-- breadcrumb-area start -->
    <div class="breadcrumb-area section-space--pt_40">
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
                                <li class="breadcrumb-item active"><a href="<?php echo URL.'shop'?>"><?php echo $bredcrumb ?></a></li>
                                <li class="breadcrumb-item active"><?php echo $title ?></li>
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

<!-- Product Area Start -->
<div class="product-wrapper section-space--ptb_80">
    <div class="container">

        <div class="row">
            <div class="col-lg-3 col-md-3 order-md-1 order-2 mt-4 small-mt__40">
                <!--start Product Filter By categories-->
                <div class="shop-widget widget-shop-categories">
                    <div class="product-filter">
                        <h6 class="mb-20"><b>Categories</b></h6>
                        <ul class="widget-nav-list">
                            <?php foreach ($menuFullListArray as $key => $menuMainArray) { ?>
                                <li> <a href="<?php echo URL?>shop/<?php echo $menuMainArray['slug_url'] ?>" class="<?php echo doActive($categoryId, $menuMainArray['id']) ?>"><?php echo $menuMainArray['name'] ?></a> </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!--end Product Filter By categories-->
             
                <!-- Brand Filter -->
                <!-- <div class="shop-widget widget-size">
                    <div class="shop-widget widget-shop-categories mt-40">
                        <h6 class="mb-20">Brands</h6>
                        <ul class="widget-nav-list">
                            <?php if(count($oneDimensionalRefeArray) > 0){ ?>
                               <?php foreach ($oneDimensionalRefeArray as $key => $masterRefArray) { ?> 
                                    <?php foreach ($masterRefArray['sub_list'] as $key => $sub_listRef) { ?>
                                        <li> <a href="<?php echo $sub_listRef['url'] ?>" class="<?php echo doActive($sub_listRef['selected'], $sub_listRef['id']) ?>"><?php echo $sub_listRef['name'] ?></a> </li>
                                    <?php }
                                }
                            } ?>
                        </ul>
                    </div>
                </div> -->
            </div>
            <div class="col-lg-9 col-md-9 order-md-2 order-1">
                <?php if ($categoryId == 1) {?>
                    <!-- <div>
                        <div class="container">
                            <div class="home-sm-logo-slide home-sm-logo-slide-pro">
                                <div class="logo-slide-div logo-slide-div1">
                                    <div class="align-center-logo"  data-toggle="modal" data-target="#prodect-modal"><img src="<?php echo URL?>assets/img/logo-slide/cwl.png"></div>
                                </div>
                                <div class="logo-slide-div logo-slide-div1">
                                    <div class="align-center-logo" data-toggle="modal" data-target="#prodect-modal2"><img src="<?php echo URL?>assets/img/logo-slide/a.png"></div>
                                </div>
                                <div class="logo-slide-div logo-slide-div1">
                                    <div class="align-center-logo" data-toggle="modal" data-target="#prodect-modal3"><img src="<?php echo URL?>assets/img/logo-slide/clb.png"></div>
                                </div>
                                <div class="logo-slide-div logo-slide-div1">
                                    <div class="align-center-logo" data-toggle="modal" data-target="#prodect-modal3"><img src="<?php echo URL?>assets/img/logo-slide/b.png"></div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <?php }?>
            
                <hr>
                <div class="row">
                    <div class="col-lg-6 col-md-8">
                        <div class="shop-toolbar__items shop-toolbar__item--left">
                            <div class="shop-toolbar__item shop-toolbar__item--result">
                                <p class="result-count">Showing <?php echo $paginationArray['showingProductsStart'].'-'.$paginationArray['showingProductsEnd'].' of '.$paginationArray['totalRows'] ?>  Result</p>
                            </div>

                            <div class="shop-toolbar__item shop-short-by">
                                <ul>
                                    <li>
                                        <a href="#">Sort by: <span class="d-none d-sm-inline-block">Default</span> <i class="fa fa-angle-down angle-down"></i></a>
                                        <ul>
                                            <?php foreach ($sortArray as $key => $singlesortType) {?>
                                                <li><a href="<?php echo $singlesortType['url'] ?>"><?php echo $singlesortType['name'] ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4">
                        <div class="shop-toolbar__items shop-toolbar__item--right">
                            <div class="shop-toolbar__items-wrapper">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab_columns_01">
                        <div class="row">
                        <?php if(count($proArray) > 0){
                            if ($categoryId == 1) {                            
                                foreach ($fetchListOfCategories as $keyCategory => $singleCategory) {?>                                
                                    <div class="col-12 mt-5">
                                        <?php foreach ($singleCategory['catgeory_images']['cover'] as $key => $value) {?>
                                            <div class="logo-slide-div logo-slide-div1">
                                                <div class=""><img src="<?php echo $value?>" alt="<?php echo $value['name']?>" style="width: 40%;"></div>
                                            </div>
                                        <?php }?>                                       
                                    </div>
                                    
                                    <?php foreach ($proArray as $keyProduct => $singleProduct) { 
                                            if (($singleCategory['id'] == $productsAllArray['category_array'][$keyProduct])) {?>
                                                <div class="col-lg-4 col-md-4 col-sm-6">
                                                    <!-- Single Product Item Start -->
                                                    <?php echo $singleProduct ?>
                                                    <!-- Single Product Item End | ($categoryId == $productsAllArray['category_array'][$keyProduct]) -->
                                                </div>
                                            <?php 
                                            }                               
                                        }?>                               
                               <?php  }
                            }else{
                                foreach ($proArray as $keyProduct => $singleProduct) {?>
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <!-- Single Product Item Start -->
                                        <?php echo $singleProduct ?>
                                        <!-- Single Product Item End -->
                                    </div>
                                <?php } 
                            }

                        }else { ?>
                            <br>
                            <p class="mt-4 ml-3">No products available in selected category</p>
                        <?php } ?>
                        </div>
                    </div>
                     <!-- paginatoin-area start -->
                     <?php //include_once ROOT_PATH.'store/shop/pagination.php'; ?>
                    <!-- paginatoin-area end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End -->

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
    <!-- JS
    ============================================ -->
    <?php require_once ROOT_PATH.'imports/js.php' ?>
</body>
</html>