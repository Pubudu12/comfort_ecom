<?php 
require_once '../app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';

require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'shopController/http/controller/checkoutController.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

$gump = new GUMP();

$getUserType = checkUserAccess();
$fetch_users = '';

if( isset($_SESSION['user_type'])){ 
    if (($_SESSION['user_type'] == 'std') | ($_SESSION['user_type'] == 'dealer') ) {
        $user_id = $_SESSION['user_id'];
        $select_user = mysqli_query($localhost,"SELECT * FROM `users` WHERE `id`='$user_id' ");
        $fetch_users = mysqli_fetch_array($select_user);
    }
}

$cartItemsArray = $cartObj->fetchCartItemsFromOut();
$cartItemsArray = $gump->sanitize($cartItemsArray); 
$sanitized_query_data = $gump->run($cartItemsArray);
$shippingChargesArray = $checkoutObj->getShippingCharges();
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Checkout | ';
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
      <div class="breadcrumb-area section-space--pt_80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title colour-brown"><b>Check-out</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">Check-out</li>
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
        <!-- checkout start -->
        <div class="checkout-main-area section-space--ptb_90">
            <div class="container">
                <div class="row">
                  <?php //if (! isset($_SESSION['user_type'])) {?>
                    <div class="col-lg-12">
                        <div class="customer-zone mb-30">
                            <p class="cart-page-title">Have a coupon? <a class="checkout-click" href="#">Click here to enter your code</a></p>
                            <div class="checkout-coupon-info single-input">
                                <p>If you have a coupon code, please apply it below.</p>
                                <form action="#">
                                    <input type="text" placeholder="Coupon code" id="coupon_code" name="coupon_code">
                                    <p class="error_message" id="error_message"></p>
                                    <button class="btn btn--lg btn--black btn--full text-center" name="apply_coupon" type="button" onclick="applyCoupon()">Apply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                  <?php //} ?>
                </div>

                <div class="checkout-wrap">
                    <form action="<?php echo URL ?>checkout" method="POST" name="checkout_form" id="checkout_Form">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="billing-info-wrap mr-100">
                                    <h6 class="mb-20">Shipping Details</h6>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label> Name <span class="required" title="required">*</span></label>
                                                <?php if (isset($_SESSION['user_type'])) {?>
                                                    <input type="text" id="billing-form-name" name="billing-form-name" value="<?php echo $fetch_users['name']?>" required>
                                                <?php }else{?>
                                                    <input type="text" id="billing-form-name" name="billing-form-name" placeholder="Enter Name" required>
                                               <?php }?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label>Phone <span class="required" title="required">*</span></label>
                                                <?php if (isset($_SESSION['user_type'])) {?>
                                                    <input type="text" id="billing-form-phone" name="billing-form-phone" value="<?php echo $fetch_users['contact_no']?>" required>
                                                <?php }else{?>
                                                    <input type="text" id="billing-form-phone" name="billing-form-phone" placeholder="Enter Contact Number" required>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="billing-info mb-25">
                                                <label>Email <span class="required" title="required">*</span></label>
                                                <?php if (isset($_SESSION['user_type'])) {?>
                                                    <input type="text" id="billing-form-email" name="billing-form-email" value="<?php echo $fetch_users['email']?>" required>
                                                <?php }else{?>
                                                    <input type="text" id="billing-form-email" name="billing-form-email" placeholder="Enter Email" required>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label>House/Flat No <span class="required" title="required" >*</span></label>
                                                <?php if (isset($_SESSION['user_type'])) {?>
                                                    <input type="text" id="billing-form-door_no" name="billing-form-door_no" value="<?php echo $fetch_users['p_door_no']?>" required>
                                                <?php }else{?>
                                                    <input type="text" id="billing-form-door_no" name="billing-form-door_no" placeholder="Enter Door number" required>
                                                <?php }?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label>Street <span class="required" title="required">*</span></label>
                                                <?php if (isset($_SESSION['user_type'])) {?>
                                                    <input type="text" id="billing-form-state" name="billing-form-state" value="<?php echo $fetch_users['p_state']?>" required>
                                                <?php }else{?>
                                                    <input type="text" id="billing-form-state" name="billing-form-state" placeholder="Enter Street" required>
                                                <?php }?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label> City/Town <span class="required" title="required">*</span></label>
                                                <?php if (isset($_SESSION['user_type'])) {?>
                                                    <input type="text" id="billing-form-city" name="billing-form-city" value="<?php echo $fetch_users['p_city']?>" required>
                                                <?php }else{?>
                                                    <input type="text" id="billing-form-city" name="billing-form-city" placeholder="Enter City" required>
                                                <?php }?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label>District <span class="required" title="required">*</span></label>
                                                <input class="billing-address" id="billing-form-district" name="billing-form-district" type="text" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label>Postcode <span class="required" title="required">*</span></label>
                                                <?php if (isset($_SESSION['user_type'])) {?>
                                                    <input type="text" id="billing-form-zip_code" name="billing-form-zip_code" value="<?php echo $fetch_users['p_zip_code']?>" required>
                                                <?php }else{?>
                                                    <input type="text" id="billing-form-zip_code" name="billing-form-zip_code" placeholder="Enter Post Code" required>
                                                <?php }?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-25">
                                                <label>Country <span class="required" title="required"></span></label>
                                                <input class="billing-address" id="billing-form-country" name="billing-form-country" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <input hidden name="shipping_method" class="form-control" id="shipping_method_combo" value="1">
                                    <div class="additional-info-wrap">
                                        <h6 class="mb-10">Additional information</h6>
                                        <label>Order notes (optional)</label>
                                        <textarea placeholder="Notes about your order, e.g. special notes for delivery. " id="shipping-form-memo" name="shipping-form-memo"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="your-order-wrappwer tablet-mt__60 small-mt__60">
                                    <h6 class="mb-20">Your order</h6>
                                    <div class="your-order-area">
                                        <div class="your-order-wrap gray-bg-4">
                                            <div class="your-order-info-wrap">
                                                <div class="your-order-info">
                                                    <ul>
                                                        <li class="bill-ttl">Product <span>Total</span></li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-middle">
                                                    <ul>
                                                        <?php foreach ($sanitized_query_data['itemsArray'] as $key => $singleItemArray) { ?>
                                                            <li class="checkout-li"><p><?php echo $singleItemArray['name'] ?> X <?php echo $singleItemArray['qty'] ?> 
                                                                <?php if($singleItemArray['discount'] > 0){ ?>
                                                                    <small> <i>Discount (<?php echo CURRENCY ?>):</i> <?php echo number_format($singleItemArray['discount'], 2) ?></small> 
                                                                <?php } ?></p>
                                                                <span><?php echo CURRENCY.' '.number_format($singleItemArray['lineGrand'], 2) ?> </span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-subtotal">
                                                    <ul>
                                                        <li><strong>Subtotal</strong> <span><?php echo CURRENCY.' '.number_format($cartItemsArray['grand_total'], 2) ?> </span></li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-total display-change no-display" id="promo_disc_section">
                                                    <ul>
                                                        <li><strong>Promo Discount</strong> <span id="promo_discount">LKR 0.00</span></li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-total">
                                                    <ul>
                                                        <li><strong>Shipping</strong> <span><?php echo $shippingChargesArray['display_shipping_charges'] ?></span></li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-total">
                                                    <ul><!--shipping_charges-->
                                                        <li><strong>Total</strong> <span id="final_total"><?php echo CURRENCY.' '.number_format($cartItemsArray['grand_total']+$shippingChargesArray['shipping_charges'], 2) ?></span></li>
                                                    </ul>
                                                </div>

                                                <div class="payment-area mt-30">
                                                    <div class="single-payment">
                                                        <h6 class="mb-10">Check payments</h6>
                                                        <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                                        <ul class="row">
                                                            <li class="col-md-6 col-sm-12">
                                                                <div class="radio-option">
                                                                    <input type="radio" checked name="payment_option" value="card" id="credit_card" required>
                                                                    <label class="righ-0" for="credit_card">Online Payment</label>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-8 col-xs-8 col-lg-12 large-checkout-image">
                                                                        <img src="<?php echo URL?>assets/img/check1.png" alt="Checkout">
                                                                    </div>
                                                                    <div class="col-sm-8 col-xs-8 mob-checkout-image">
                                                                        <img src="<?php echo URL?>assets/img/check2m.png" alt="Checkout">
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="icons">
                                                                    <i class="fa fa-cc-mastercard"></i>
                                                                    <i class="fa fa-cc-visa"></i>
                                                                    <i class="fa fa-cc-amex"></i>
                                                                </div> -->

                                                            </li>
                                                            <li class="col-md-6 col-sm-12">
                                                                <div class="radio-option">
                                                                    <input type="radio" name="payment_option" value="cod" id="cash_on_delivary">
                                                                    <label class="righ-0" for="cash_on_delivary">Contact Agent</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        <p><input class="mt-5" type="checkbox" name="check" id="termcheck" onchange="ckecked()"> I accept the <a target="_black" href="<?php echo URL?>terms"><b>terms and conditions.</b></a></p>
                                        <p class="mt-30">Your personal data will be used to process your order, support your experience throughout this website , and for other purposes described in our privacy policy.</p>
                                    </div>
                                    <div class="place-order mt-30">
                                        <button class="btn btn--full btn--black btn--lg text-center inputDisabled" type="submit" name="checkout" disabled>Place Order</button>
                                        <input type="hidden" name="coupon_code" value="" id="checkout_promo">
                                        <input type="hidden" name="apply_promo_status" id="apply_promo_status" value="">
                                        <input type="hidden" name="discount_of_promo" value="" id="discount_of_promo">
                                        <input type="hidden" name="total_after_pro_discount" value="" id="total_after_pro_discount">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- checkout end -->

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
    <script src="<?php echo URL ?>assets/js/general/addCart.js"></script>

    <script>
        function ckecked() {
            // cb = document.getElementById('termcheck');
            if(document.querySelector('#termcheck:checked') !== null){
                // console.log("checked");
                $('.inputDisabled').prop("disabled", false);
            }else{
                $('.inputDisabled').prop("disabled", true);
            }
        }
        ckecked();
    </script>
</body>
</html>