<?php 
require_once 'includes/newsListTop.php'; 
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php   

        $meta_single_page_desc = '';
        if ($newsDetailsArray['description'] != null) {
            $meta_single_page_desc = $newsDetailsArray['description'];
        }

        require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = $newsDetailsArray['heading'].' | ';
        
        $meta_arr = array(
            'title' => $meta_single_page_title,
            'description' => $meta_single_page_desc,
            'image' => $newsDetailsArray['cover'],
            
            'og:title' => $meta_single_page_title,
            'og:image' => $newsDetailsArray['cover'],
            'og:description' => $meta_single_page_desc,

            'twitter:image' => $newsDetailsArray['cover'],
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
    
    <script>
        var editorContent = <?php echo json_encode($newsContentArray) ?>;
        console.log(editorContent)
    </script>

    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->

    <div class="site-wrapper-reveal border-bottom">

        <!-- Blog Page Area Start -->
        <div class="blog-page-wrapper section-space--pt_120 section-space--pb_120">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Single Blog Item Start -->
                                <div class="single-blog-item">
                                    <div class="blog-thumbnail-box">
                                        <a href="" class="thumbnail"><!--870x500-->
                                            <img src="<?php echo $newsDetailsArray['cover']?>" class="img-fluid" alt="<?php echo $newsDetailsArray['heading']?>">
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="blog-contents col-lg-9 col-md-8">
                                            <h3 class="blog-title-lg"><a class="font-Cormorant-md" href="#"><?php echo $newsDetailsArray['heading']?></a></h3>
                                            <div class="meta-tag-box mb-40">
                                                <div class="meta date"><span><?php echo date('j F Y', strtotime($newsDetailsArray['published_date']))?></span></div>
                                                <!-- <div class="meta author"><span><a href="#"><?php echo $newsDetailsArray['categoryName']?></a></span></div> -->
                                            </div>

                                            <p class="mt-20 d_text text-justify" id="editorContent"></p>

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
                                                                <a href="" class="share-linkedin" target="_blank" aria-label="Linkedin">
                                                                    <i class="social social_linkedin"></i>
                                                                </a>
                                                            </li> -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 mt-40">
                                            <div class="blog-widget widget-blog-recent-post ">
                                                <h6 class="mb-20">Recent Posts</h6>
                                                <ul class="widget-nav-list">
                                                    <?php foreach ($recentPostsInNewsSinglePage as $key => $singleRecent) { ?>
                                                        <li><a href="<?php echo $singleRecent['url_query']?>"><?php echo $singleRecent['heading']?> </a> 
                                                        <div class="mt-2"><span class="post-date"><?php echo date('j F Y', strtotime($singleRecent['published_date'])) ?></span></div></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <!-- <div class="blog-widget widget-blog-categories mt-40">
                                                <h6 class="mb-20">Categories</h6>
                                                <ul class="widget-nav-list">
                                                    <li><a href="#">Art Deco <span>(1)</span></a></li>
                                                    <li><a href="#">Chair <span>(4)</span></a></li>
                                                    <li><a href="#">Lightning <span>(3)</span></a></li>
                                                    <li><a href="#">Wooden <span>(4)</span></a></li>
                                                </ul>
                                            </div> -->

                                            <!-- <div class="blog-widget widget-blog-banner mt-40">
                                                <a href="#"><img src="assets/images/blog/blog-widget.jpg" class="img-fluid" alt="blog widget"></a>
                                            </div> -->

                                            <?php if(isset($newsDetailsArray['tags'])){?>
                                            <!-- <div class="blog-widget widget-blog-tag mt-40">
                                                <h6 class="mb-20">Tags</h6>
                                                <div class="blog-tagcloud">
                                                    <?php foreach ($newsDetailsArray['tags'] as $key => $singleTag) { ?>
                                                                <a href="#" class=""><?php echo $singleTag['tag_name']?></a>
                                                    <?php }?>
                                                </div>
                                            </div> -->
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div><!-- Single Blog Item End -->
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Blog Page Area End -->
    </div>

   <!--====================  footer area ====================-->
   <?php require_once ROOT_PATH.'imports/footer.php' ?>

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
            let postTile = encodeURI('<?php echo $newsDetailsArray['heading']?>');
            
            fbshare.setAttribute("href", `https://www.facebook.com/sharer.php?u=${postUrl}`);
            twitterShare.setAttribute("href", `https://twitter.com/share?url=${postUrl}&text=${postTile}`);
            // likedinShare.setAttribute("href", `https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTile}`);
        }

        sharePosts();
    </script>
</body>
</html>