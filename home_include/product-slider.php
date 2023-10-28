<div class="product-wrapper section-space--pt_120 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="section-title text-lg-center text-center mb-20">
                    <h3 class="section-title">OUR FEATURED PRODUCTS FOR THE BEST SLEEP OF YOUR LIFE</h3>
                </div>
            </div>
            </div>
            <div class="col-lg-12">
                <ul class="nav product-tab-menu justify-content-lg-center justify-content-center" id="category-parent" role="tablist">
                    <!-- <li class="tab__item nav-item active">
                        <a class="nav-link active" data-toggle="tab" href="#tab_list_01" role="tab">All Products</a>
                    </li> -->
                    <?php foreach ($categoryArr as $key => $singleCategory) { ?>
                        <li class="tab__item nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_list_<?php echo $singleCategory['id']?>"  id="<?php echo $singleCategory['id']?>" role="tab"><?php echo $singleCategory['name']?></a>
                            <?php
                                // $categoryId = $singleCategory['id'];
                                // $featureProducts = $productControllerObj->fetchSliderProducts($slug);
                            ?>
                            <!-- onclick="getCategoryId('<?php echo $singleCategory['id']?>')" -->
                        </li>
                    <?php }?>
                    <!-- <li class="tab__item nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab_list_03" role="tab">Divans</a>
                    </li>
                    <li class="tab__item nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab_list_04" role="tab">Head boards</a>
                    </li>
                    <li class="tab__item nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab_list_05" role="tab">Mattress Protectors</a>
                    </li>
                    <li class="tab__item nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab_list_08" role="tab">Cushions</a>
                    </li> -->
                </ul>
            </div>
        </div>

        <div class="tab-content mt-30">
        <?php foreach ($categoryArr as $key => $singleCategory) {?>
            <div class="tab-pane show active" id="tab_list_<?php echo $singleCategory['id']?>">
                <div class="wrap">  
                    <div class="slider">
                    <?php foreach ($trendingProductsArray as $key => $singleProduct) {?>
                        <!-- <div class="item">
                            <img src="<?php echo $singleProduct['thumbArray']?>" alt="<?php echo $singleCategory['name']?>">
                        </div> -->
                    <?php }?>
                        
                        <div class="item">
                            <img src="https://images.unsplash.com/photo-1489440543286-a69330151c0b?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1490718687940-0ecadf414600?dpr=1&auto=format&fit=crop&w=568&h=378&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1507032336878-13f159192baa?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1506268919522-a927511962a9?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1501879779179-4576bae71d8d?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1494253188410-ff0cdea5499e?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1511965682784-5ec68f744ea1?dpr=1&auto=format&fit=crop&w=568&h=319&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- <div class="tab-pane" id="tab_list_02">
                <div class="wrap">  
                    <div class="slider">
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1425342605259-25d80e320565?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1489440543286-a69330151c0b?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1490718687940-0ecadf414600?dpr=1&auto=format&fit=crop&w=568&h=378&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1507032336878-13f159192baa?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1506268919522-a927511962a9?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1501879779179-4576bae71d8d?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1494253188410-ff0cdea5499e?dpr=1&auto=format&fit=crop&w=568&h=379&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                        <div class="item">
                        <img src="https://images.unsplash.com/photo-1511965682784-5ec68f744ea1?dpr=1&auto=format&fit=crop&w=568&h=319&q=60&cs=tinysrgb&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="">
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="tab-pane fade" id="tab_list_03">
            
            </div>
            <div class="tab-pane fade" id="tab_list_04">
            
            </div>
            <div class="tab-pane fade" id="tab_list_05">
            
            </div>
            <div class="tab-pane fade" id="tab_list_08">
            
            </div> -->

        </div>
    </div>
</div>
<script>
    function getCategoryId(catgId) {
        $.ajax({
        type: 'POST',
        url: ROOT_URL+'index.php',
        data: {
            'set_catg_id': 'yes', 
            'category_id': catgId,
        },
        dataType: 'json',

        success: function (response) {
            console.log(response);
        },error:function (err) {
            console.log(err);
        }
    });
    }
</script>