<?php 
require_once 'app/global/url.php';
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
include_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'newsAndEvents/controller/newsControllerClass.php';
require_once ROOT_PATH.'blog/controller/blogControllerClass.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';
require_once ROOT_PATH.'app/controllers/productsControllerClass.php';
require_once ROOT_PATH.'imports/functions.php';
include_once ROOT_PATH.'/mail/mails.php';

$gump = new GUMP();

//blogs
$blogArray = $blogControllerObj->recentBlogPosts(8);

//news and event
$newsPostArray = $newsControllerObj->recentPosts(3);

//trending products
$trendingProductsArray = $productControllerObj->trendingProducts(7);
$trendingProductsArray = $gump->sanitize($trendingProductsArray); 

$featureProducts = array();
$sanitized_query_data = $gump->run($trendingProductsArray);
$categoryArr = $productControllerObj->fetchAllCategories();

$coccyx = '';
$napper = '';
foreach ($categoryArr as $key => $singleCatgArr) {
    // seacrh coccyx
    if ($singleCatgArr['code'] == '1_87729357521040210' ) {
        $coccyx = $singleCatgArr['slug'];
    }

    // seacrh napper
    if ($singleCatgArr['code'] == '1_999729692521021503' ) {
        $napper = $singleCatgArr['slug'];
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Home | ';
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
    <!-- Favicon -->
    <!-- CSS============================================ -->

        <?php require_once ROOT_PATH.'imports/css.php' ?>
        <link rel="stylesheet" href="<?php echo URL?>assets/css/popup.css">
        <link rel="stylesheet" href="<?php echo URL?>assets/css/product.css">
</head>

<body class="transparent-header">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->
    <div class="site-wrapper-reveal">

        <!-- Hero Slider Area Start -->
        <?php include_once ROOT_PATH.'home_include/slider.php'; ?>
        <!-- Hero Slider Area End -->

        <?php include_once ROOT_PATH.'home_include/logo-slide.php'; ?>
       
        <!-- About us Area Start -->
        <?php include_once ROOT_PATH.'home_include/aboutus.php'; ?>
        <!-- About us Area End -->

          <!-- About us Area Start -->
          <?php include_once ROOT_PATH.'home_include/video.php'; ?>
        <!-- About us Area End -->

        <!-- overlay box start -->
        <?php include_once ROOT_PATH.'home_include/overlay-box.php'; ?>
        <!-- overlay box end -->
        <?php include_once ROOT_PATH.'home_include/swiper.php'; ?>
        <!-- overlay box start -->
        <?php include_once ROOT_PATH.'home_include/contact.php'; ?>
        <!-- overlay box end -->
        <!-- helendo store start -->
        <?php include_once ROOT_PATH.'home_include/store.php'; ?>
        <!-- helendo store end -->
        <!-- overlay box start -->
        <?php include_once ROOT_PATH.'home_include/mattrest.php'; ?>
        <!-- overlay box end -->

        <div class="popup gee-popup">
            <div class="popup-inner">
                <a class="close-button popup-close-button">
                    &times;
                </a>
                <div class="popup-header">
                    <h3 class="popup-title"></h3>
                </div>
                <!-- <div class="row">
                    <div class="col-md-12"> -->
                        <div class="pop-outer">
                            <img src="<?php echo URL?>assets/images/about/pop.jpg" class="img-popup-res" alt="" srcset="">
                        </div>
                    <!-- </div>
                </div> -->
                <div class="row">
                    <div class="col-md-12 text-justify mt-2 f-14">
                        The orthopedic coccyx cushion is expressly designed to relieve leg, lower back, and tail-bone pain associated with sciatica, poor posture and extended seating hours. The rear-cutout of the coccyx cushion enables the muscles and nerves in your lower-back to reducing pressure on your tail-bone and relax while improving circulation while the premium quality foam ensures a perfect fit and greater durability
                    </div>
                </div>
                
                <div class="row mt-2 mb-2">
                    <div class="col-md-6 col-12 mb-b-res">
                        <a href="<?php echo URL?>shop/<?php echo $coccyx?>"><button class="btn btn-info btn-block btn-sm ip-pro-btn" style="background: #9a7b54 !important; padding: 0px 70px;" >Shop Now</button></a>   
                    </div>
                    <div class="col-md-6 col-12">
                        <a href="<?php echo URL?>contact"><button class="btn btn-info btn-block btn-sm ip-pro-btn" style="background: #9a7b54 !important; padding: 0px 70px;">Contact Us</button></a>
                    </div>
                </div>
            </div>
        </div>
       
         <!-- Banner Product Area Start -->
         <div class="about-us-area margin-tb1-pho">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="col-12 mob-news-title">
                            <h2 class="uppercase">News & Events</h2>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="col-12 mob-news-title call-to-pro">
                            <a class="news-view-link " href="<?php echo URL?>news"><u>View All</u></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="container">
         <div class="banner-preduct-wrapper">
            <div class="container-fluid">
                <div class="row row--6">
                    <?php foreach ($newsPostArray as $key => $value) { ?>
                        <div class="col-lg-4 col-md-4">
                            <div class="banner-product-image mt-10">
                                <a href="<?php echo $value['url_query']?>">
                                    <img src="<?php echo $value['cover']?>" class="img-fluid test-css" alt="<?php echo $value['heading']?>">
                                    <div class="news-overlay"></div>
                                </a>
                                <div class="product-banner-title">
                                    <h3><a class="news-a" href="<?php echo $value['url_query']?>"><?php echo $value['heading']?></a></h3>
                                    <!-- <h6>Table collection</h6> -->
                                </div>
                            </div>
                        </div>
                   <?php }?>
                </div>
            </div>
        </div>
        </div>

        <!-- Banner Product Area End -->

        <div class="about-us-area margin-tb1-pho  section-space--pt_70 ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="about-us-content_6 text-center">
                            <h2>OUR PARTNERS IN HOSPITALITY</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Area Start -->
        <div class="container-fluid">
            <div class="logos" data-aos="fade-up">
                <div class="logo-container " id="clients_logos-box">
                    <div class="single-logo">
                        <img src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====================  Google reviews ====================-->
    <?php require_once ROOT_PATH.'home_include/googleReviews.php' ?>

    <!--====================  footer area ====================-->
    <?php require_once ROOT_PATH.'imports/footer.php' ?>

    <!-- Modal -->
    <div class="product-modal-box modal fade" id="prodect-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="icon-cross" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body container">
                    <div class="row align-items-center">
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content-wrap modal-padding" style="padding: 20px !important;">

                                <h5 class="font-weight--reguler mb-10">Spring Air</h5>

                                <div class="quickview-peragraph mt-10">
                                    <p>

                                    Since 1926, Spring Air has been widely recognized for its innovative mattresses and sleep sets. Francis Karr, who founded the company, was himself a visionary. His free-end offset coil design, which adjusts to each sleeper’s weight, is now the most copied design in the bedding industry. In the late 1940s, the company introduced button-free technology, quilted surfaces and extra-supportive bedding materials. In 1953, Spring Air began producing its “Health Center” mattress which featured zones for different areas of the body. The Pillow Top mattress was introduced by Spring Air in 1973. With 4 billion dollars worth of Spring Air sleep sets sold at retail over the past 10 years, Spring Air has stayed true to quality, innovative design and value. Today, Spring Air has 8 domestic factories and 35 international licensees that operate in 43 countries worldwide.
                                    </p>
                                </div>

                                <div class="quickview-action-wrap mt-30"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

<!-- Modal -->
    <div class="product-modal-box modal fade" id="prodect-modal2" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="icon-cross" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body container">
                    <div class="row align-items-center">
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content-wrap modal-padding" style="padding: 20px !important;">

                                <h5 class="font-weight--reguler mb-10">Comfort World</h5>                           

                                <div class="quickview-peragraph mt-10">
                                    <p>

                                    Bringing you a world of comfort to better help you find that secret place of rest and serenity. We know what it takes to have a good nights rest. So go ahead browse our wide variety of sleep products. Comfort World houses the best brands in sleep products and accessories from around the world
                                    </p>
                                </div>
                                <div class="quickview-action-wrap mt-30 mr-3 icon-links">
                                    <a href="<?php echo URL?>about" class="btn--text-icon see-more-btn">Read More <i class="arrow_carrot-2right"></i></a>
                                    <a href="<?php echo URL?>shop/" class="btn--text-icon see-more-btn">Go to our Sleep Shop <i class="arrow_carrot-2right"></i></a>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-modal-box modal fade" id="prodect-modal3" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="icon-cross" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content-wrap modal-padding" style="padding: 20px !important;">
                                <h5 class="font-weight--reguler mb-10">Napper</h5>   
                                <div class="quickview-peragraph mt-10">
                                    <p>
                                    Our panel of loving and protective mothers have come together to help us assemble the perfect
                                    product for your baby. We are the trail blazers who have emerged to wrap your baby with nothing but the best. Baby products that have the element of comfort, safety and hygiene. What more does your little angel faced bambino need? A child is only as healthy as their sleep. So leave them at peace while they immerse in their sleep.
                                    </p>
                                </div>
                                <div class="quickview-action-wrap mt-30" style="text-align: center;">
                                    <a href="<?php echo URL?>shop/<?php echo $napper?>" class="btn--text-icon see-more-btn">Go to our Napper Shop <i class="arrow_carrot-2right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top icon-arrow-up"></i>
        <i class="arrow-bottom icon-arrow-up"></i>
    </a>
    <!--====================  End of scroll top  ====================-->
    <!-- JS
    ============================================ -->
    <?php require_once ROOT_PATH.'imports/js.php' ?>
    <?php require_once 'imports/clientLogoSlider.php';?>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="<?php echo URL?>assets/js/validation/contact.js"></script>
    <script src="<?php echo URL?>assets/js/general/popup.js"></script>

    <script>
    $('.li-modal').on('click', function(e){
      e.preventDefault();
      $('#theModal').modal('show').find('.modal-content').load($(this).attr('href'));
    });
  </script>

  <script>
  $(document).ready(function() {
  // Assign some jquery elements we'll need
  var $swiper = $(".swiper-container");
  var $bottomSlide = null; // Slide whose content gets 'extracted' and placed
  // into a fixed position for animation purposes
  var $bottomSlideContent = null; // Slide content that gets passed between the
  // panning slide stack and the position 'behind'
  // the stack, needed for correct animation style

  var mySwiper = new Swiper(".swiper-container", {
    spaceBetween: 1,
    slidesPerView: 3,
    centeredSlides: true,
    roundLengths: true,
    loop: true,
    loopAdditionalSlides: 30,
    breakpoints: {  
    '576': {
      slidesPerView: 1,
      autoplay: true,},
    '@640': {
      slidesPerView: 5,
      spaceBetween: 50, },
  },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    }
  });
});

  </script>

    <script>
  AOS.init();
</script>
    <script type="text/javascript">
    
    $('.logo-slider-1').slick({
//   dots: true,
//   infinite: false,
  speed: 300,
  slidesToShow: 7,
  slidesToScroll: 7,
  autoplay: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 5,
        // infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
  ]
});
  </script>

      <script>
      $('.slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        centerMode: true,
        variableWidth: true,
        infinite: true,
        focusOnSelect: true,
        cssEase: 'linear',
        touchMove: true,
        prevArrow:'<button class="slick-prev"> < </button>',
        nextArrow:'<button class="slick-next"> > </button>',
    });


        var imgs = $('.slider img');
        imgs.each(function(){
        var item = $(this).closest('.item');
            item.css({
                'background-image': 'url(' + $(this).attr('src') + ')', 
                'background-position': 'center',            
                '-webkit-background-size': 'cover',
                'background-size': 'cover', 
            });
            $(this).hide();
        });

        $('.owl-carousel').owlCarousel({
            margin: 10,
            nav: true,
            loop:true,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });
      </script>

        <script type="text/javascript">
       
        $("html").jPopup({
            heading : "Best Seller!",
            paragraph: "Get Weekly Email on latest Web & Graphic Design freebies",
            buttonText1 : "About Us",
            buttonText2 : "Contact Us",
            buttonClass : "btn btn-info",
        });
		</script>
</body>

</html>