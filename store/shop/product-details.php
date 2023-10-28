<?php 
// require_once '../includes/productsListTop.php';

require_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'app/controllers/productsControllerClass.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

$gump = new GUMP();

$productId = 0;
if(isset($_GET['q'])){
    if(is_numeric($_GET['q'])){
        $productId = trim(mysqli_real_escape_string($localhost, $_GET['q']));
    }
}

$sizeArray = array();
$select = mysqli_query($localhost,"SELECT p.*,s.`name` sname,p.`size_id` sizeid FROM `price` AS p 
                                   INNER JOIN `sizes` s ON s.`id`=p.`size_id` 
                                   WHERE p.`product_id`='$productId' ");
while($fetch = mysqli_fetch_array($select)){
    array_push($sizeArray,array(
        'id'=>$fetch['sizeid'],
        'name'=>$fetch['sname']
    ));
}

$productDetailsArray = $productControllerObj->getStoreSingleProductDetails($productId);

$productDetailsArray = $gump->sanitize($productDetailsArray); 
$sanitized_query_data = $gump->run($productDetailsArray);

$reviewArray = $productControllerObj->fetchReviews($productId);

// $productOneDReferenceDetails = $productControllerObj->productOneDReferenceDetails($productId);

$name = $sanitized_query_data['name'];
$desc = '';
$category_name = $productDetailsArray['categoryName'];
if (isset($productDetailsArray['description'])) {
    $desc = $productDetailsArray['description'];
}
// $thumb = $productDetailsArray['productsImagesArray']['thumb'][0];

$productDetailsArray = $productControllerObj->getStoreSingleProductDetails($productId);
$similarProductsArray = $productControllerObj->getStoreSimilarProductList($productId, $productDetailsArray['category_id']);

$proOtherContent = $productControllerObj->getProOtherContent($productId);

$productsDiscountArray = $productControllerObj->getProDiscountsList($productId);
$page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php 
        $meta_single_page_desc = '';
        if ($productDetailsArray['description'] != null) {
            $meta_single_page_desc = $productDetailsArray['description'];
        }
        
        require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = $name.' | ';
        $meta_arr = array(
            'title' => $meta_single_page_title,
            'description' => $meta_single_page_desc,
            'image' => $productDetailsArray['productsImagesArray'][0],
            
            'og:title' => $meta_single_page_title,
            'og:image' => $productDetailsArray['productsImagesArray'][0],
            'og:description' => $meta_single_page_desc,

            'twitter:image' => $productDetailsArray['productsImagesArray'][0],
            'twitter:title' => $meta_single_page_title,

        );
        require_once ROOT_PATH.'app/meta/meta_more_details.php'; 
        ?>
        
        <?php require_once ROOT_PATH.'imports/css.php' ?>

</head>

<body class="">

    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->

      <!-- breadcrumb-area start -->
    <div class="section-space--pt_90 breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-8 col-md-6 col-sm-6 text-center ">
                            <!-- <h2 class="breadcrumb-title"><?php //echo $name ?></h2> -->
                            <ul class="breadcrumb-list text-center text-sm-left">
                                <!-- Form Back Url -->
                                <?php $path = URL.'shop/'.$sanitized_query_data['slug']; ?>

                                <li class="breadcrumb-item call-to-link-color"><a href="<?php echo $path ?>"><i class="fa fa-chevron-left mr-2"></i>Back To Shop</a></li>
                                <!-- <li class="breadcrumb-item active"><?php //echo $sanitized_query_data['category_id']?></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

    <div class="site-wrapper-reveal">
        <div class="single-product-wrap section-space--pt_90 border-bottom">
            <div class="container">
                <div class="row">
                    <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="product-slider owl-carousel owl-theme" id="sync1">
                            <?php 
                            foreach ($productDetailsArray['productsImagesArray'] as $key => $imgUrl) { ?>
                                <div class="item"><img src="<?php echo $imgUrl ?>" alt="" class="blur-up lazyloaded"></div>
                            <?php } ?>
                        </div>
                        <div class="owl-carousel owl-theme mt-2" id="sync2">
                            <?php 
                            foreach ($productDetailsArray['productsImagesArray'] as $key => $imgUrl) { ?>
                                <div class="item"><img src="<?php echo $imgUrl ?>" alt="" class="blur-up lazyloaded"></div>
                            <?php } ?>
                        </div>
                    </div> -->
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                        <!-- Product Details Left -->
                        <div class="product-details-left">
                            <div class="product-details-images-2 slider-lg-image-2" style="position: inherit;">
                            <?php 
                                foreach ($productDetailsArray['productsImagesArray'] as $key => $imgUrl) { ?>
                                <div class="easyzoom-style">
                                    <div class="easyzoom easyzoom--overlay">
                                        <a href="<?php echo $imgUrl ?>" class="poppu-img" style="width: auto; height: auto;">
                                            <img src="<?php echo $imgUrl ?>" class="img-fluid pro-det-img" alt="" >  <!--style="width: 500px; height: 500px;"-->
                                            <?php if ($productDetailsArray['price']['discount'] != 0.00) {
                                                 echo '<label id="discount-percentage" class="discount-label"><span id="discount-type"></span></label>';
                                            }?>                                           
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="product-details-thumbs-2 slider-thumbs-2" style="position: inherit;">
                                <?php foreach ($productDetailsArray['productsImagesArray'] as $key => $imgUrl) { ?>
                                    <div class="sm-image"><img src="<?php echo $imgUrl ?>" alt="<?php echo $name?>" style="height: 100px; width: 100px;"></div>
                                <?php }?>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                        <div class="product-details-content ">
                            <h5 class="font-weight--reguler mb-10 product-name1 mob-name-res"><?php echo $name ?></h5>
                            <?php if (isset($_SESSION['user_type'])) {
                                if ($_SESSION['user_type'] == 'dealer') { ?>
                                <h4 class="price" id="dealer_price"><?php echo $productDetailsArray['dealer_price'] ?></h4>
                                <?php if ($productDetailsArray['price']['discount'] != 0.00) {?>
                                        <span class="old-price ml-4"><?php echo $productDetailsArray['actual_price']?></span> 
                                    <?php }?>
                                <!-- <sup id="currency"></sup> -->
                            <?php }else{ ?>
                                <!-- <h4 class="price" id="sale_price"><?php echo $productDetailsArray['actual_price'] ?></h4> -->
                                <!-- <sup id="currency"></sup> -->
                                <div class="on-sale-price">
                                    <h4 style="color: black;" class="price" id="sale_price"><?php echo $productDetailsArray['price']['sale_price'] ?></h4>
                                    <?php if ($productDetailsArray['price']['discount'] != 0.00) {?>
                                        <span class="old-price ml-4"><?php echo $productDetailsArray['actual_price']?></span> 
                                    <?php }?>
                                    
                                </div>
                            <?php }
                            } else {?>
                            <?php //print_r($productDetailsArray['price']['discount'])?>
                                <div class="on-sale-price">
                                    <h4 style="color: black;" class="price" id="sale_price"><?php echo $productDetailsArray['price']['sale_price'] ?></h4>
                                    <?php if ($productDetailsArray['price']['discount'] != 0.00) {?>
                                        <span class="old-price ml-4"><?php echo $productDetailsArray['actual_price']?></span> 
                                    <?php } ?>
                                    
                                </div>
                            <?php }?>                            
              
                            <input type="hidden" id="product_id" value="<?php echo $productId?>">
                            
                            <!-- 3d link -->
                            <?php if ($productDetailsArray['3d_link'] != '0') {?>
                                
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 mt-3 quickview-button">
                                    <button class="btn btn--brown font-weight--reguler text-white elendo-video-box new-3d">View Product in 3D
                                    <i class="linear-ic-play"></i>
                                        <a href="<?php echo $productDetailsArray['3d_link']?>" class="popup-youtube">
                                            <div class="video-icon">
                                            </div>
                                        </a>
                                    </button>
                                    <!-- <div class="elendo-video-box new-3d"> 
                                        <i class="linear-ic-play"></i>
                                        <a href="<?php echo $productDetailsArray['3d_link']?>" class="popup-youtube">
                                            <div class="video-icon">
                                            </div>
                                        </a>
                                    </div>   -->
                                </div>
                            </div>
                            <?php }  ?>

                            <div class="col-md-10 col-lg-10 col-sm-12 variable-size-selector variations p-0 mt-3 font-brown-light"><!--mt-20-->
                                <label>Select Size</label>
                                <select name="pro_size" id="pro_size" onchange="getDetailsOnSize()">
                                    <option value="0" disabled>Select Size</option>
                                    <?php foreach ($sizeArray as $key => $value) { ?>
                                        <option class="attached enabled" value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="row mt-5 ml-1 center-mob-res" id="headingTwo">
                                <a href="#" data-toggle="modal" data-target="#exampleModal">
                                    <u>Request for custom size</u>
                                </a>
                            </div>

                            <!-- Size Req Modal -->
                            <?php include ROOT_PATH.'store/modal/sizeReqModal.php'?>

                            <div id="productAddToCart"></div>

                            <div class="product_socials center-mob-res">
                                <span class="label">Share this item :</span>
                                <ul class="helendo-social-share socials-inline">
                                    <li>
                                        <a class="share-twitter helendo-twitter" href="<?php echo $productDetailsArray['fb_link']?>" target="_blank"><i class="social_twitter"></i></a>
                                    </li>
                                    <li>
                                        <a class="share-facebook helendo-facebook" href="" target="_blank"><i class="social_facebook"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descriptions -->
                <?php include ROOT_PATH.'store/includes/otherDetails.php'?>

                <!-- Simialr products -->
                <?php include ROOT_PATH.'store/includes/similarProducts.php'?>
                
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
    <!-- <script src="<?php echo URL?>assets/js/form/confirmDialogBox.js"></script>
    <script src="<?php echo URL ?>assets/js/form/form_ajax_submission.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="<?php echo URL?>assets/js/validation/size.js"></script>

    <script>
        // $(document).ready(function () {
        var ratedIndex = -1;
        $('.fa-star').on('click', function () {
            ratedIndex = parseInt($(this).data('index'));
            localStorage.setItem('ratedIndex', ratedIndex);

            // for (let i = 0; i <= ratedIndex; i++) {
            //     $('.fa-star:eq('+i+')').css('color', '#cfcbcb');
            // }
            ExactRate = ratedIndex + 1;
            
            document.getElementById("rateIndex").value = ExactRate;
        });

        $('.fa-star').mouseover(function () {
            
            resetStarColors();
            var currentIndex = parseInt($(this).data('index'));
            for (let i = 0; i <= currentIndex; i++) {
                $('.fa-star:eq('+i+')').css('color', '#dcb14a');
            }
        });  
        
        // $('.fa-star').mouseleave(function () {
        //     resetStarColors();
        //     if (ratedIndex != -1) {
        //         for (let i = 0; i <= ratedIndex; i++) {
        //             $('.fa-star:eq('+i+')').css('color', '#cfcbcb');
        //         }
        //     }
        // });

        function resetStarColors() {
            $('.fa-star').css('color', '#cfcbcb');
        }
    </script>

    <script>
        function getDetailsOnSize(){
            size = $('#pro_size').val();
            product_id = $('#product_id').val();

            var fetchURL = ROOT_URL+'store/includes/productsListTop.php';
            $.ajax({
                type: 'POST',
                url: fetchURL,
                data: {
                    'size': size,
                    'product_id':product_id,
                    'fetch_pro_detail_on_size' : 'yes',
                },
                dataType: 'json',
                success:function(res){
                    // console.log(res)
                    $('#productAddToCart').html(res.prosec.productAddToCart)
                    $('#dealer_price').html('<sup>LKR </sup>'+currencyFormat(res.dealer,2))
                    $('#sale_price').html('<sup>LKR </sup>'+currencyFormat(res.acprice,2))
                    // $('#currency').html(res.currency)
                    
                    if (res.discount.discount != 0) {
                        $('#discount-percentage').html(currencyFormat(res.discount.discount,0)+''+res.discount.discount_type)
                        // $('#discount-type').html(res.discount.discount_type)
                    } else {
                        $('#discount-percentage').addClass('hide');
                    }
                },
                error:function(err){
                    console.error(err);
                }
            });
        }

        getDetailsOnSize();

        function sharePosts() {
            let fbshare = document.querySelector(".helendo-facebook");
            let twitterShare = document.querySelector(".helendo-twitter");

            let postUrl = encodeURI(document.location.href);
            let postTile = encodeURI('<?php echo $name?>');
            
            fbshare.setAttribute("href", `https://www.facebook.com/sharer.php?u=${postUrl}`);
            twitterShare.setAttribute("href", `https://twitter.com/share?url=${postUrl}&text=${postTile}`);
        }

        sharePosts();
    </script>
</body>
</html>