
<?php require_once 'app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Payment Return| ';
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

<body class="">

    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->
    <div class="site-wrapper-reveal border-bottom">

        <!-- Blog Page Area Start -->
        <div class="blog-page-wrapper section-space--pt_120 section-space--pb_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Single Blog Item Start -->
                        <div class="single-blog-item">
                            
                            <div class="blog-contents">
                                <h3 class="blog-title-lg"><a href="#">Interior design is the art, the interior designer is the artist.</a></h3>

                                <div class="row">
                                    <div class="col-lg-12">
                                    
                                        <p class="mt-20 ">Contrary to popular belief, Lorem Ipsum indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same saying.One order all scale sense her gay style wrote.</p>

                                        <p class="mt-20 ">Contrary to popular belief, Lorem Ipsum indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same saying.One order all scale sense her gay style wrote.</p>

                                        <p class="mt-20 ">Contrary to popular belief, Lorem Ipsum indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same saying.One order all scale sense her gay style wrote.</p>

                                        <p class="mt-20 ">Contrary to popular belief, Lorem Ipsum indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same saying.One order all scale sense her gay style wrote.</p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Single Blog Item End -->
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
    <?php require_once 'imports/js.php' ?>
</body>
</html>