<?php require_once '../app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'newsAndEvents/controller/newsControllerClass.php';

$newsArray = $newsControllerObj->fetchAllNews(1);
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'News & Events | ';
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
    <div class="breadcrumb-area section-space--pt_80"><!--breadcrumb-area-->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title colour-brown"><b>News & Events</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">News & Events</li>
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

        <!-- Blog Page Area Start -->
        <div class="blog-page-wrapper section-space--pt_90 section-space--pb_120">
            <div class="container">
                <div class=""> <!--masonry-activation-->
                    <div class="row clearfix "> <!--mesonry-list-->
                        <?php foreach ($newsArray['newsArray'] as $key => $singleNews) {?>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-20 "><!--masonary-item-->
                                <!-- Single Blog Item Start -->
                                <div class="single-blog-item mt-40">
                                    <div class="blog-thumbnail-box">
                                        <a href="<?php echo $singleNews['url_query']?>" class="thumbnail">
                                            <img src="<?php echo $singleNews['cover']?>" class="img-fluid" alt="news Image" style="<?php echo $singleNews['imageSize']?> width:100%">
                                        </a>
                                        <!-- <a href="<?php echo $singleNews['url_query']?>" class="btn-blog"> Read more </a> -->
                                    </div>
                                    <div class="blog-contents">
                                        <div class="meta-tag-box ">
                                            <div class="meta date"><span><?php echo date('j F Y', strtotime($singleNews['published_date'])) ?></span></div>
                                            
                                            <!-- <div class="meta author"><span><a href="#"><?php echo $singleNews['category']?></a></span></div> -->
                                            <!-- <div class="meta cat"><span>in <a href="#">Chair</a></span></div> -->
                                        </div>
                                        <hr class="hr-posts">
                                        <h6 class="blog-title-two"><a href="<?php echo $singleNews['url_query'] ?>"><?php echo $singleNews['heading']?></a></h6>
                                        <div class="button-box mt-15">
                                            <!-- <a href="<?php echo $singleNews['url_query'] ?>" class="btn btn--sm btn--border_1"> Read more </a> -->
                                            <a class="blog-read-more" href="<?php echo $singleNews['url_query'] ?>">Read more</a>
                                        </div>
                                    </div>
                                </div><!-- Single Blog Item End -->
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Page Area End -->
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
    <script>
        $('#newsevents').addClass('active');
    </script>
</body>
</html>