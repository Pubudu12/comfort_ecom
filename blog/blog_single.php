<?php 
require_once 'includes/blogListTop.php';
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php 
        $meta_single_page_desc = '';
        if ($blogDetailsArray['description'] != null) {
            $meta_single_page_desc = $blogDetailsArray['description'];
        }

        require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = $blogDetailsArray['heading'].' | ';
        
        $meta_arr = array(
            'title' => $meta_single_page_title,
            'description' => $meta_single_page_desc,
            'image' => $blogDetailsArray['cover'],
            
            'og:title' => $meta_single_page_title,
            'og:image' => $blogDetailsArray['cover'],
            'og:description' => $meta_single_page_desc,

            'twitter:image' => $blogDetailsArray['cover'],
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

    <script>
        var editorContent = <?php echo json_encode($blogContentArray) ?>;
        console.log(editorContent)
    </script>

    <!--====================  End of header area  ====================-->
    <div class="site-wrapper-reveal border-bottom">
        <!-- Blog Page Area Start -->
        <div class="blog-page-wrapper section-space--pt_120 section-space--pb_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Single Blog Item Start -->
                        <div class="single-blog-item">
                            <div class="blog-thumbnail-box">
                                <a href="#" class="thumbnail"><!--1170x672-->
                                    <img src="<?php echo $blogDetailsArray['cover']?>" class="img-fluid" alt="<?php echo $blogDetailsArray['heading']?>">
                                </a>
                            </div>
                            <div class="blog-contents">
                                <h3 class="blog-title-lg "><a class="font-Cormorant-md" href="#"><?php echo $blogDetailsArray['heading']?></a></h3>

                                <div class="row">
                                    <div class="col-lg-9 ">
                                        <div class="meta-tag-box mb-40">
                                            <div class="meta date"><span><?php echo date('j F Y', strtotime($blogDetailsArray['published_date'])) ?></span></div>
                                            <!-- <div class="meta author"><span><a href="#"><?php echo $blogDetailsArray['categoryName']?></a></span></div> -->
                                            <!-- <div class="meta cat"><span>in <a href="#">Chair</a></span></div> -->
                                        </div>

                                        <?php 
                                        // if (isset($blogContentArray['blocks'])) {
                                        //     foreach ($blogContentArray['blocks'] as $key => $singleContent) { ?>
                                                <p class="mt-20 d_text text-justify" id="editorContent"></p>
                                        <?php //}
                                           //}  ?>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="blog-post-social-networks mt-20">
                                            <h6 class="title">Share this story on :</h6>
                                            <ul class="list">
                                                <li class="item">
                                                    <a href="" class="share-fb" target="_blank" aria-label="Twitter">
                                                        <i class="social social_facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="item">
                                                    <a href="" class="share-twitter" target="_blank" aria-label="Facebook">
                                                        <i class="social social_twitter"></i>
                                                    </a>
                                                </li>
                                                <!-- <li class="item">
                                                    <a href="" target="_blank" aria-label="Instagram">
                                                        <i class="social social_tumblr"></i>
                                                    </a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    <?php 
                                    //if(isset($blogDetailsArray['tags'])){?>
                                        <!-- <div class="col-lg-6">
                                            <div class="tag-blog d-flex justify-content-lg-end justify-content-start mt-20">
                                                <h6 class="mr-2">Tags:</h6>
                                                <div class="tagcloud">
                                                    <?php foreach ($blogDetailsArray['tags'] as $key => $singleTag) { ?>
                                                            <a href="#"><?php echo $singleTag['tag_name']?></a>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div> -->
                                    <?php //}?>
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
    <?php require_once ROOT_PATH.'imports/js.php' ?>
    <script src="<?php echo URL ?>assets/js/general/viewHtml.js"></script>

    <script>
        function sharePosts() {
            let fbshare = document.querySelector(".share-fb");
            let twitterShare = document.querySelector(".share-twitter");
            // let likedinShare = document.querySelector(".share-linkedin");

            let postUrl = encodeURI(document.location.href);
            let postTile = encodeURI('<?php echo $blogDetailsArray['heading']?>');
            
            fbshare.setAttribute("href", `https://www.facebook.com/sharer.php?u=${postUrl}`);
            twitterShare.setAttribute("href", `https://twitter.com/share?url=${postUrl}&text=${postTile}`);
            // likedinShare.setAttribute("href", `https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTile}`);
        }

        sharePosts();
    </script>
</body>
</html>