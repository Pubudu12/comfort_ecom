<?php 
$menuFullListArray = $headerClassOBJ->getFullListMenu();
$trendingProductsArray = $productControllerObj->trendingProducts(7);
// print_r($trendingProductsArray);
?>

<div class="product-wrapper mbl-swiper section-space--ptb_60 swiper-tab-res">
    <div class="container">       
    <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="section-title text-lg-center text-center mb-20">
                    <h3 class="section-title">OUR FEATURED PRODUCTS FOR THE BEST SLEEP OF YOUR LIFE</h3>
                </div>
            </div>
            </div>

            <div class="col-lg-12">
                <ul class="nav product-tab-menu justify-content-lg-center justify-content-center mb-2" id="category-parent" role="tablist">
                    <?php foreach ($menuFullListArray as $key => $value) {?>
                        <li class="tab__item nav-item call-to-pro">
                            <a class="nav-link"  href="<?php echo URL?>shop/<?php echo $value['slug_url'] ?>" ><?php echo $value['name']?></a>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>

            <!-- Slider main container -->
            <div class="swiper-container  "><!--mb-4-->
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper ">
                    <!-- Slides -->
                    <?php foreach ($trendingProductsArray as $key => $value) { ?>
                    <!-- <div class="swipeer-flex-1"> -->
                        <div class="swiper-slide swipeer-flex-1">
                            <a href="<?php echo $value['url_query']?>"><img class="pc-view-res swiper-image-res" alt="<?php echo $value['name']?>" src="<?php echo $value['thumbArray']?>" ></a>
                            <div class="swiper-price-div">
                            <p class="pro-name-1"><?php echo $value['name']?></p>
                            <p class="pro-price-1"><?php echo CURRENCY.' '. number_format($value['sale_price'],2) .' Upwards'?></p>
                        </div>
                        </div>
                        <!-- <div class="swiper-price-div">
                            <p class="pro-name-1"><?php echo $value['name']?></p>
                            <p class="pro-price-1"><?php echo CURRENCY.' '. number_format($value['sale_price'],2) .' Upwards'?></p>
                        </div> -->
                    <!-- </div> -->
                    <?php }?>
                </div>
                
                <!-- <p style="color: red;
font-size: 50px;
position: absolute;
bottom: 0;
left: 46%;">aaa</p> -->
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

            <!-- <div class="col-lg-12 mb-30" style="display: flex;" >
                <a href="<?php echo URL?>shop" class="shopNow_btn">SHOP NOW</a>
            </div> -->
    </div>
</div>