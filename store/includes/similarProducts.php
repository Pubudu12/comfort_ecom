<?php if(count($similarProductsArray) > 0){ ?>
    <div class="related-products section-space--ptb_90">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center mb-30">
                    <h4 class="uppercase">Related products</h4>
                </div>
            </div>
        </div>

        <div class="row product-slider-active-1">
            <?php foreach ($similarProductsArray as $key => $simProAr) { 
                if ($key == 4) {
                    break;
                }else{ ?>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <?php echo $simProAr; ?>
                </div>
            <?php }
            } ?>
        </div>
    </div>
<?php }else{ ?>
    <div class="section-space--ptb_60"></div>
<?php } ?>