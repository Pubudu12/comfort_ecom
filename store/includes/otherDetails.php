<?php if (($productDetailsArray['description'] != null) | (isset($proOtherContent['details'])) | ((isset($reviewArray)))) {?>
    <div class="row">
        <div class="col-12">
            <div class="product-details-tab section-space--pt_90">
                <ul role="tablist" class=" nav">
                    <?php if ($productDetailsArray['description'] != null) {?>
                        <li class="active" role="presentation">
                            <a data-toggle="tab" role="tab" href="#description" class="active">Description</a>
                        </li>
                    <?php }?>
                    <?php if (isset($proOtherContent['details'])) {?>
                        <li role="presentation">
                            <a data-toggle="tab" role="tab" href="#sheet">Features</a>
                        </li>
                    <?php }?>
                    <?php if (($productDetailsArray['description'] == null) & (!isset($proOtherContent['details']))) {?>
                        <li class="active" role="presentation">
                            <a data-toggle="tab" role="tab" href="#reviews" class="active">Reviews</a>
                        </li>
                    <?php }else{?>
                        <li role="presentation">
                            <a data-toggle="tab" role="tab" href="#reviews">Reviews</a>
                        </li>
                        <?php  }?>
                </ul>
            </div>
        </div>
        <div class="col-12">
            <div class="product_details_tab_content tab-content mt-30">
                <?php if ($productDetailsArray['description'] != null) {?>
                    <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
                        <div class="product_description_wrap">
                            <div class="product-details-wrap">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 order-md-1 order-2">
                                        <div class="details mt-30">
                                            <!-- <h5 class="mb-10">Detail</h5> -->
                                            <p><?php echo $productDetailsArray['description']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <?php if (isset($proOtherContent['details'])) {?>
                    <div class="product_tab_content tab-pane" id="sheet" role="tabpanel">
                        <div class="pro_feature">
                            <div class="product_description_wrap">
                                <div class="product-details-wrap">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 order-md-1 order-2">
                                            <div class="details mt-30">
                                                <!-- <h5 class="mb-10">Detail</h5> -->
                                                <p>
                                                <?php echo $proOtherContent['details']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <?php if (($productDetailsArray['description'] == null) & (!isset($proOtherContent['details']))) {?>
                    <div class="product_tab_content tab-pane active" id="reviews" role="tabpanel">
                        <?php if (count($reviewArray) > 0) {?>
                            <div class="post-author-box clearfix row section-space--mb_60">
                            <?php foreach ($reviewArray as $key => $value) {?>
                            <div class="post-author-info col-12 mb-5">
                                <div class="review-flex">
                                    <h6 class="author-name" style="font-weight:600; "><?php echo $value['name']?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  |  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                                    <h6 class="author-name"> <?php echo date('j F Y', strtotime($value['created']))?></h6>
                                </div>
                                <div class="star-div">
                                    <?php if ($value['rate'] != null) {?>
                                            <?php $remain = 5 - $value['rate']; 
                                                for ($i=0; $i < $value['rate']; $i++) { ?>
                                                <i class="icon_star star-color"></i>
                                            <?php }
                                            
                                            if ($remain > 0) {
                                                for ($i=0; $i < $remain; $i++) { ?>
                                                    <i class="icon_star star-color-grey"></i>
                                                <?php }
                                            }
                                            ?>
                                    <?php }?>
                                        
                                </div>
                                <p class="mt-1"><?php echo $value['message']?></p>
                            </div>
                        <?php }?>
                    </div>
                <?php }
                }else{?>
                    <div class="product_tab_content tab-pane" id="reviews" role="tabpanel">
                        <?php if (count($reviewArray) > 0) {?>
                            <div class="post-author-box clearfix row section-space--mb_60">
                            <?php foreach ($reviewArray as $key => $value) {?>
                            <div class="post-author-info col-12 mb-5">
                                <div class="review-flex">
                                    <h6 class="author-name" style="font-weight:600; "><?php echo $value['name']?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  |  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                                    <h6 class="author-name"> <?php echo date('j F Y', strtotime($value['created']))?></h6>
                                </div>
                                <div class="star-div">
                                    <?php if ($value['rate'] != null) {?>
                                            <?php $remain = 5 - $value['rate']; 
                                                for ($i=0; $i < $value['rate']; $i++) { ?>
                                                <i class="icon_star star-color"></i>
                                            <?php }
                                            
                                            if ($remain > 0) {
                                                for ($i=0; $i < $remain; $i++) { ?>
                                                    <i class="icon_star star-color-grey"></i>
                                                <?php }
                                            }
                                            ?>
                                    <?php }?>
                                        
                                </div>
                                <p class="mt-1"><?php echo $value['message']?></p>
                            </div>
                        <?php }?>
                    </div>

                <?php } 
            }?>
                    
                    <!-- Start RAting Area -->
                    <div class="rating_wrap mb-30">
                        <h4 class="rating-title-2">Leave a review on <?php echo $name?></h4>
                        <p>Your rating</p>
                        <div class="rating_list">
                            <div class="product-rating d-flex">
                                <i class="fa fa-star fa-2x mr-1"  id="f1" data-index="0"></i><!--onmouseover="mouover('0')"-->
                                <i class="fa fa-star fa-2x mr-1"  id="f1" data-index="1"></i>
                                <i class="fa fa-star fa-2x mr-1"  id="f1" data-index="2"></i>
                                <i class="fa fa-star fa-2x mr-1"  id="f1" data-index="3"></i>
                                <i class="fa fa-star fa-2x mr-1"  id="f1" data-index="4"></i>
                            </div>
                        </div>
                    </div>
                    <!-- End RAting Area -->
                    <div class="comments-area comments-reply-area">
                        <div class="row">
                            <div class="col-lg-12">
                                <form class="comment-form-area" data-action-after=2 data-redirect-url="" method="POST"
                                    action="<?php echo URL ?>store/class/reviewController.php">
                                    
                                    <div class="comment-input">
                                        <p class="comment-form-author">
                                            <label>Name <span class="required">*</span></label>
                                            <input type="text" required="required" name="username">
                                        </p>
                                        <p class="comment-form-email">
                                            <label>Email <span class="required">*</span></label>
                                            <input type="text" required="required" name="email">
                                        </p>
                                    </div>
                                    <p class="comment-form-comment">
                                        <label>Your review *</label>
                                        <textarea class="comment-notes" name="message" required="required"></textarea>
                                    </p>

                                    <div class="comment-form-submit">
                                        <input type="hidden" value="" name="rateIndex" id="rateIndex">
                                        <input type="hidden" name="add_user_review" value="<?php echo $productId?>">
                                        <input type="button" value="Submit" class="comment-submit submit_form_no_confirm" data-notify_type=2 >
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>