<?php require_once 'app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'newsAndEvents/controller/newsControllerClass.php';

$newsPostArray = $newsControllerObj->recentPosts(3);
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'About Us | ';
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

        <?php require_once 'imports/css.php' ?>

</head>

<body class="transparent-header">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>  
      <!--====================  End of header area  ====================-->


    <!-- breadcrumb-area start -->
    <div class="section-space--pt_80 breadcrumb-area" style="background-image:url('<?php echo URL?>assets/images/about/CWB1.jpg');height: 600px;display: flex;
justify-content: center;
align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center text-sm-left">
                            <h1 class="breadcrumb-title text-center" style="color:#fff !important;">COMFORT, LUXURY AND PREMIUM CRAFTMANSHIP</h1>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <div class="site-wrapper-reveal border-bottom">

        <div class="about-us-pages-area">
         
        <div class="perfection-area section-space--pt_90">
                <div class="container">
                    
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="perfection-dec">
                                <!-- <h5 class="mb-10">About Comfort World International</h5> -->
                                <p class="text-justify">
                                Comfort world International is an established family business with an illustrious history which serves as a key factor to produce our masterpieces to international standards. All Comfort World products are being produced using <b> quality material, premium craftsmanship </b> and years of research which ensures our customers' products at its highest quality.
Comfort world revolutionized the mattress space within the country securing the license for manufacturing and distribution of Spring Air-USA mattresses in the region. We take pride in being one of the 35 licensees operating worldwide.

                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <img src="assets/img/abc.jpg" class="img-fluid mb-10" alt="Banner images">
                        </div>
                    </div>
                   
                </div>
            </div>

            <div class="our-customer-suppoer-area">
                <div class="container">
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <h5 class="about-heading1">What we believe in</h5>
                        </div>
                    </div> -->
                    <div class="row mb-5">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mbl-mb-40-1">
                            <!-- Single Support Item Start -->
                            <div class="single-support-item">
                                <div class="header-support">
                                    <div class="icon mb-10">
                                        <!-- <i class="icon-bag2"></i> -->
                                        <img style="width: 50px;height: auto;" src="<?php echo URL?>assets/images/about/Cart.png">
                                    </div>
                                    <h6><b>Ultimate client satisfaction</b></h6>
                                </div>
                                <div class="iconbox-desc">
                                    <p class="text-justify">
                                    Customer loyalty is what we are after through the provision of the best quality product and an undisputed after sales service. We are driven by our customer’s ultimate satisfaction which is what the company is built on. 
                                    </p>
                                </div>
                            </div>
                            <!-- Single Support Item End -->
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mbl-mb-40-1">
                            <!-- Single Support Item Start -->
                            <div class="single-support-item">
                                <div class="header-support">
                                    <div class="icon mb-10" style="margin-bottom: 15px;">
                                    <img style="width: 50px;height: auto;" src="<?php echo URL?>assets/images/about/quality.png">
                                    </div>
                                    <h6><b>Quality is priority </b></h6>
                                </div>
                                <div class="iconbox-desc">
                                    <p class="text-justify">
                                    Never do we ever compromise on Quality no matter what. Cause we are well aware that the quality of the produce through the premium quality ingredients is what is primary in providing the optimum level of comfort for our customer. 
                                    </p>
                                </div>
                            </div>
                            <!-- Single Support Item End -->
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mbl-mb-40-1">
                            <!-- Single Support Item Start -->
                            <div class="single-support-item">
                                <div class="header-support">
                                    <div class="icon mb-10">
                                    <img style="width: 50px;height: auto;" src="<?php echo URL?>assets/images/about/plane.png">
                                    </div>
                                    <h6><b>Constant research to stay ahead </b></h6>
                                </div>
                                <div class="iconbox-desc">
                                    <p class="text-justify">
                                    Research plays a pivotal role in our company which enables us to constantly stay ahead identifying the most recent developments and introducing the same into the production line. A recommended 1/3 of the day being allocated to sleep requires us to craft our mattresses that would keep our client’s physical health at an optimum level. 
                                    </p>
                                </div>
                            </div>
                            <!-- Single Support Item End -->
                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="">
                <div class="" style="background-image:url('<?php echo URL?>assets/images/about/1qw3.jpg');height: 500px;background-position: center; background-repeat: no-repeat;"><!--background-repeat: no-repeat;width: 100%;-->
                </div>
            </div>

            <div class="perfection-area section-space--pt_90">
                <div class="container">

                <div class="row">
                <div class="col-lg-5 col-md-5 about-col-div">
                            <img src="assets/images/about/5.jpg" class="img-fluid mb-10 " alt="Banner images">
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="">
                                <h5>Meet our Chairman,</h5>
                                <h5 class="about-heading1"> Naushad Mohideen!</h5>
                                
                                    <p class="text-justify">
                                    Naushad Mohideen is the Chairman of Comfort World International (Pvt) Limited - A one-stop-shop for world-class bedding solutions. Upon completing his studies, Naushad spent seven years in Japan, where he progressed to Vice President of Shigadry with Earth – Japan, a Group specializing in infection control and hygienic bedding solutions. Wanting to give back to Sri Lanka, its economy, and its people, Naushad returned home and started a diversified group of companies, which included 2 BOI-approved large-scale manufacturing facilities.  
                                    </p>
                                <!-- <p>
                                The Group has made significant investments in Sri Lanka. As the Chairman, Naushad has contributed in the development of quality products and concurrently maintain strategic synergies with a large network and key decision makers in the Public and Private sectors of the respective markets.                                </p> -->
                            </div>
                        </div>
                </div>
<!--                     
                    <div class="row">
                    <div class="col-lg-5 col-md-5 about-col-div">
                            <img src="assets/images/about/5.jpeg" class="img-fluid mb-10 about-img-radius" alt="Banner images">
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="perfection-dec mr-lg-5">
                                <h5 class="about-heading1">Meet our Chairman, Naushad Mohideen!</h5>
                                <p>Comfort World International is an established family business with an illustrious history which is the key ingredient of its products built to international standards. All Comfort World products have been produced combining <span style="font-weight:900;">years of research, high quality material</span> and <span style="font-weight:900;">premium craftsmanship</span> which ensures our customers of products at the highest quality. </p>
                                <p>
                                The Group has made significant investments in Sri Lanka. As the Chairman, Naushad has contributed in the development of quality products and concurrently maintain strategic synergies with a large network and key decision makers in the Public and Private sectors of the respective markets.                                </p>
                            </div>
                        </div>
                        
                    </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="perfection-dec ">
                            <p class="text-justify">Over the years, this group has made significant investments in Sri Lanka and has contributed to the development of high-quality products, while maintaining strategic synergies that are parallel to high net worth, key decision-makers in the public and private sectors in the respective industries.</p>
                                <p class="text-justify">
                                Health Care, Environment, and Entrepreneurship are the three areas that Naushad is passionate about and involved in. He is the Chairman to a group of companies and he is proud to say that he is the first to secure a USA license manufacturer status for Sri Lanka and the Maldives, from Spring Air International USA - One of the 4 largest bedding brands in the world. Naushad is a co-inventor of the world's first MRSA-certified hospital bedding system and is actively involved in research and development for bedding solutions. He was also involved in developing the ‘Earth with Us’ campaign in Japan, where they focus on manufacturing 100% natural-based bedding solutions, and further promoting rubber plantations for their CO2 absorption capabilities. A passionate advocate for a greener planet, Naushad is also the owner of the world's first Carbon Negative Product concept with bedding. Furthermore, he is an entrepreneur with creative design skills and is well experienced in running multiple, diversified corporate group activities, and large-scale manufacturing facilities.</p>
                           
                           <p class="text-justify">

                           Having worked with the development and innovation of bedding and mattresses, with the experience in creating hygienic mattresses that penetrated over 1600 hospitals and households in Japan, Naushad and his team at Comfort World are confident when they say they offer much more than just a mattress. Comfort World introduced the 8-inch mattress, and now offers a range up to the 18-inch mattress - It’s all about Comfort and First Class Luxury, and they are certain they offer mattresses unlike any other. With his extensive training and exposure in Japan, it is Naushad’s mission to bring to Sri Lanka world class bedding technology that will contribute towards the well-being of the Nation. 
                           </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                        <img style="margin: auto;
border-radius: 223px;display: flex;
margin-top: 20px;" src="assets/images/banners/im-md-3.jpg">
                            <blockquote>
                            <p class="text-center" style="font-family: 'Dancing Script', cursive !important;
font-size: 28px !important;
line-height: 43px;">
                            Naushad Mohideen is the Founder and Chairman of a diversified Group of Companies specialized in international and local manufacturing and trading activities. After a successful business cum studies tenure of 7 years in Japan, he returned and invested in diversified operations in Sri Lanka, inclusive of two BOI approved large scale manufacturing facilities. 
                            <br>
                            The Group has made significant investments in Sri Lanka. As the Chairman, Naushad has contributed in the development of quality products and concurrently maintain strategic synergies with a large network and key decision makers in the Public and Private sectors of the respective markets.
                            <br>
                            He was also successful in introducing Spring Air-USA, the first International Mattress brand to the Sri Lankan Market. Other brands include the World’s #1 Mattress brand, Serta. Both brands are manufactured in Sri Lanka under the direct franchise license from the respective principals in the USA covering the Maldives islands and the Seychelles.
                            <br>
                            Naushad is currently actively involved in developing the world’s first MRSA free hospital mattress, the world’s first Non-alcohol based Anti-microbial and the world’s first Carbon Negative Product concept
                            </p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div> -->


            <div class="banner-preduct-wrapper section-space--pt_90 section-space--pb_90">
                <div class="container">
                    <div class="row row--6">
                        <div class="col-lg-8 col-md-8">
                            <div class="banner-product-image mt-10">
                                <!-- <a href="#"> -->
                                    <img src="assets/images/about/1.jpg" style="width: 100%;height: auto;" alt="Banner images">
                                <!-- </a> -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="banner-product-image mt-10">
                                <!-- <a href="#"> -->
                                    <img src="assets/images/about/2.jpg" style="width: 100%;height: auto;" alt="Banner images">
                                <!-- </a> -->
                            </div>
                            <div class="banner-product-image mt-10">
                                <!-- <a href="#"> -->
                                    <img src="assets/images/about/4.jpg" style="width: 100%;height: auto;" alt="Banner images">
                                <!-- </a> --> 
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="banner-product-image mt-10">
                                <!-- <a href="#"> -->
                                    <img src="assets/images/about/cw.png" style="width: 100%;height: auto;" alt="Banner images">
                                <!-- </a> -->
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="banner-product-image mt-10">
                                <!-- <a href="#"> -->
                                    <img src="assets/images/about/3.jpg" style="width: 100%;height: auto;" alt="Banner images">
                                <!-- </a> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- News and events section -->
            <div class="about-us-area margin-tb1-pho">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="col-12 mob-news-title">
                                <h2 class="uppercase">News & Events</h2>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="col-12 mob-news-title">
                                <a class="news-view-link call-to-pro" href="<?php echo URL?>news"><u>View All</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      
        <div class="container mb-40">
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
    <?php require_once 'imports/js.php' ?>
    <script>
        $('#aboutus').addClass('active');
    </script>
</body>
</html>