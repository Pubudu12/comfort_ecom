        <div class="about-us-area section-space--ptb_50 section-space--ptb_60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="about-us-content_6 text-center">
                            <h2>DIVE RIGHT INTO THE SLEEP MAGAZINE</h2>
                            <!-- <p>
                            At Comfort World, we believe that you deserve to sleep better for a more productive, healthier, and happier life. 
                            We work hard everyday to give you a luxury night's rest with our line of sleep products.
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-box-area margin-gallery">
            <div class="container-fluid">
                <div class="row row--5">
                    <?php foreach ($blogArray as $key => $singleBlog) {?>
                        <div class="<?php echo $singleBlog['class']?>">
                            <div class="hero-product-image mt-10">
                                <a href="<?php echo $singleBlog['url_query']?>">
                                    <img src="<?php echo $singleBlog['cover']?>" class="image-position-change" alt="<?php echo $singleBlog['heading']?>">
                                    <div class="blog-ovly">
                                        <!-- <h1>bhjhj</h1> -->
                                    </div>
                                </a>
                                <div class="product-banner-title">
                                    <h4 class="font-Cormorant-md"><a class="home-b-clr" href="<?php echo $singleBlog['url_query']?>"><?php echo $singleBlog['heading']?></a></h4>
                                    <!-- <h6>
                                    We treasure sleep as blessed time of inactivity. This is why we recommend a luxurious mattress for a quality night of sleep.</h6> -->
                                </div>
                            </div>
                        </div>
                    <?php }?>
                   
                    <div class="col-lg-5 col-md-5 store-tt">
                        <div class="">
                            <div class="product-banner-title pro-activity-1">
                                <h4><a style="color:#000 !important;" href="<?php echo URL?>blog">Read more on sleep and sleep related articles</a></h4>
                                <a href="<?php echo URL?>shop"><u>Discover luxury sleep</u></a>
                                <!-- <h6>We treasure sleep as blessed time of inactivity. This is why we recommend a luxurious mattress for a quality night of sleep.</h6> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>