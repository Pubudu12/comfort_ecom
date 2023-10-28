<?php 
require_once '../app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'shopController/http/controller/checkoutController.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';
require_once ROOT_PATH.'shopController/class/cartClass.php';

$gump = new GUMP();

$order_no = 0;
if(isset($_GET['order_no'])){
    $order_no = $_GET['order_no'];

    // If ResultIndicator Cmes pls do this
    if(isset($_GET['resultIndicator']) && isset($_GET['sessionVersion']) ){
        require_once ROOT_PATH.'account/class/paymentClass.php';
        
        // Verify the Payment and make the further
        $resultIndicator = trim($_GET['resultIndicator']);
        $paymentIndication = $paymentObj->response($resultIndicator, $order_no, $localhost);
        if ($paymentIndication['result'] == '1') {
            // $query_payment = " ";
            $select_payment = mysqli_query($localhost, "SELECT `payment` FROM `orders` WHERE `order_no` = '$order_no'");
            $fetch_payment = mysqli_fetch_array($select_payment);
            if ($fetch_payment['payment'] > '0') {
                $t = $cartObj->clearCart();
            }
        }

    }

}



$checkuser = checkUserAccess();

if( ($checkuser['access'] == 1 ) | ($checkuser['access'] == 2 )){
        
    // standard user
    $user_id = $_SESSION['user_id'];

    $selectQuery = "SELECT o.*,dd.*, refShM.`name` shippingMethod
                    FROM `orders` o 
                    INNER JOIN `user_std_order_history` uh ON uh.`order_no` = o.`order_no` AND uh.`user_id`='$user_id'
                    INNER JOIN `delivery_details` AS dd ON dd.`order_no`=o.`order_no`
                    LEFT JOIN `ref_shipping_methods` AS refShM ON refShM.`id` = dd.`shipping_method`
                    WHERE o.`order_no`='$order_no' AND (o.`user_type`='std' OR o.`user_type`='dealer') ";
}else{
    // if guest users   
    
    $email = 0;
    if(isset($_GET['email'])){
        $email = mysqli_real_escape_string($localhost,trim($_GET['email']));
    } // get isset of email

    $selectQuery = "SELECT o.*,dd.*, refShM.`name` shippingMethod
                        FROM `orders` o 
                        INNER JOIN `delivery_details` AS dd ON dd.`order_no` = o.`order_no`
                        LEFT JOIN `ref_shipping_methods` AS refShM ON refShM.`id` = dd.`shipping_method`
                        WHERE o.`order_no`='$order_no'";
    
} // access control end 
    
    $select_order = mysqli_query($localhost, $selectQuery);
    $fetch_order = mysqli_fetch_array($select_order);
    mysqli_num_rows($select_order);

    $order_no = $fetch_order['order_no'];

    $payment = $fetch_order['payment'];

    $payment_status = "Paid";
    if($payment == 0){
        $payment_status = "Pending";
    }

    $payment_method = $fetch_order['payment_method'];


    $orderDetailsArray = array(
        'Order Date' => Date("d, F y", strtotime($fetch_order['checkout_date'])),
        'Payment Status' => $payment_status,
        'Payment Method' => $payment_method,
        'Delivery Status' => $fetch_order['delivery_status'],
        'Shipping Method' => $fetch_order['shippingMethod']
    );

    $orderDeliveryDetails = array(
        'Name' => $fetch_order['name'],
        'Phone' => $fetch_order['mobile_no'],
        'Email' => $fetch_order['email'],
        'Address' => $fetch_order['door_no'].", ".$fetch_order['state'].", ".$fetch_order['city'].",".$fetch_order['district'].'-'.$fetch_order['zip_code'],
    );


    $orderItemsDetails = array();
    $query = "SELECT oi.*,p.`name`, p.`id` product_id, thumb.`name` AS thumb
            FROM `order_items` oi 
            INNER JOIN `products` p ON p.`id`=oi.`product_id`
            LEFT JOIN `product_images` AS thumb ON thumb.`product_id` = p.`id` AND thumb.`type` = 'cover'
            WHERE oi.`order_no`='$order_no' GROUP BY oi.`product_id` AND oi.`size_id` ";
    $select_products = mysqli_query($localhost, $query);

    while($fetch_products = mysqli_fetch_array($select_products)){
        $fetch_products = $gump->sanitize($fetch_products); 
        $sanitized_query_data = $gump->run($fetch_products);

        $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=CW";
        if(isset($fetch_products['thumb'])){
            if(file_exists(ROOT_PATH."admin/uploads/products/mainthumb/".$fetch_products['thumb']) && (strlen($fetch_products['thumb']) > 0) ){
                $thumbnail_image = URL."admin/uploads/products/mainthumb/".$fetch_products['thumb'];
            }
        }
        
        $verified = 0;
        if ($checkuser['user_type'] != 'guest') {
            $pro_id = $fetch_products['product_id'];
            $select_serials = mysqli_query($localhost, "SELECT sn.* ,ps.`product_id`
                                                    FROM `serial_numbers` AS sn
                                                    INNER JOIN `product_serial` AS ps ON ps.`serial_id` = sn.`id`
                                                    WHERE ps.`product_id`='$pro_id' AND sn.`verified_user`='$user_id' ");
            $count = mysqli_num_rows($select_serials);
            if ($count != 0) {
                $verified = 1;
            }
        }
        
        array_push($orderItemsDetails, array(
            'thumb' => $thumbnail_image,
            'name' => $sanitized_query_data['name'],
            'pro_url' => URL.'shop/pro?q='.$fetch_products['product_id'].'&product='.urlencode(strtolower(trim($fetch_products['name']))),
            'price' => number_format($fetch_products['rate'],2),
            'qty' => $fetch_products['qty'],
            'product_id' => $fetch_products['product_id'],
            'verified_status' => $verified,
            'total' => number_format($fetch_products['amount'],2)
        ));

    } // While

    $orderSummary = array();

    if( $fetch_order['delivery_charges'] > 0){
        $orderSummary['Cart total'] = number_format($fetch_order['cart_total'],2);
        $orderSummary['Shipping'] = number_format($fetch_order['delivery_charges'],2);
    }

    $orderSummary['Total'] = number_format($fetch_order['total'], 2);
    
    if( $fetch_order['payment'] > 0){ 
        $orderSummary['Paid'] = $fetch_order['payment'];
    }

    if($fetch_order['refaund_amount'] > 0){ 
        $orderSummary['Refunded'] = $fetch_order['refaund_amount'];
    }

?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'View Order | '.$order_no.' ';
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
      <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title colour-brown"><b>My Order</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">My Orders</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- action="<?php echo URL ?>account/payment_processing.php" -->
    <form action="<?php echo URL ?>payment/processing" method="GET" id="redirect_payment_gateway">
        <input type="hidden" name="order_no" id="order_no" value="<?php echo $order_no ?>" >
        <input type="hidden" name="paynow" value="card" >
    </form>
    <!-- breadcrumb-area end -->

          <!-- response message -->
    <?php
    if(isset($_GET['response'])){ ?>

        <section class="container">
            <div class="row">
                <div class="col-12 text-center pt-50">
                <?php if($_GET['response'] == "success"){ ?>

                    <p class="alert alert-success text-uppercase">your order has been placed successfully.</p>

                <?php }else if($_GET['response'] == "update_error"){ ?>

                    <p class="alert alert-danger text-uppercase">your payment has been processed successfully.<br> 
                        Please contact the us to update the invoice.
                    </p>

                <?php }else if($_GET['response'] == "failed"){ ?>

                    <p class="alert alert-danger  text-uppercase">your payment transaction has been declined.</p>

                <?php } ?>
                <br>

                </div>
            </div>
        </section>

    <?php } ?>


    <?php 
    if(isset($paymentIndication)){  ?>

        <section class="container">
            <div class="row">
                <div class="col-12 text-center pt-50">
        <?php
        if($paymentIndication['result'] == 1){ ?>
            <p class="alert alert-success text-uppercase">your order has been placed successfully.<br> your payment has been processed successfully. </p>
        <?php }else{ ?>
            <p class="alert alert-danger  text-uppercase">your payment transaction has been declined.</p>
        <?php } ?>

                <br>

                </div>
            </div>
        </section>

    <?php } ?>



    <div class="site-wrapper-reveal border-bottom">
        <!-- checkout start -->
        <div class="checkout-main-area section-space--ptb_90">
            <div class="container">
            <form action="#"> 
                <div class="row">
                    <div class="col-12 order_customer_details_box pb-30">
                        <div class="row">
                            <div class="col-md-12 col-lg-7">
                                <h1 class="h1-font-resize"> <small>Order No </small> <?php echo $order_no ?></h1>
                                <?php 
                                foreach ($orderDetailsArray as $key => $value) {
                                  echo   "<h4> <small>".$key." </small> ".$value."</h4>";
                                } ?>
                            </div>

                            <div class="col-md-12 col-lg-5">
                                <h3>Delivery Details</h3>
                                <table class="table"> 
                                    <?php 
                                    foreach ($orderDeliveryDetails as $key => $value) {
                                        echo '  <tr>
                                                    <td> '.$key.' </td>
                                                    <td>:</td>
                                                    <td> '.$value.' </td>
                                                </tr>';
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-desc">
                            <div class="cart-page table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="product-remove">#</th>
                                            <th class="product-thumb">Image</th>
                                            <th class="product-name">Product</th>
                                            <th class="product-price text-right">Price</th>
                                            <th class="product_quantity text-right">Quantity</th>
                                            <th class="product-total text-right">Total</th>
                                            <!-- <th class="text-right">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($orderItemsDetails as $key => $itemsArr) { ?>
                                            <tr>
                                                <td class="product-remove"><a><i class="fa"> <?php echo $key+1 ?> </i>
                                                       <?php if ($itemsArr['verified_status'] == 1) {?>
                                                          <i class="list-verified-icon fa fa-check-circle"></i> 
                                                       <?php } ?>
                                                    </a>
                                                </td>
                                                <td class="product-thumb"><a><img src="<?php echo $itemsArr['thumb'] ?>" alt="<?php echo $itemsArr['name'] ?>" style="width:30%"></a></td>
                                                <td class="product-name"><a href="<?php echo $itemsArr['pro_url'] ?>" target="_blank"> <?php echo $itemsArr['name'] ?>  </a> </td>
                                                <td class="product-price text-right"> <?php echo $itemsArr['price'] ?></td>
                                                <td class="product_quantity text-right"> <?php echo $itemsArr['qty'] ?></td>
                                                <td class="product-total text-right"> <?php echo $itemsArr['total'] ?> </td>
                                                <!-- <td class="text-right"> 
                                                    <button class="btn btn--lg btn--black" data-toggle="modal" type="button" data-target="#verifyModal">Verify</button>
                                                    <input type="hidden" name="pro_id" id="pro_id" value="<?php echo $itemsArr['product_id']?>">
                                                </td> -->
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>  
                                <?php //include_once ROOT_PATH.'account/modal/verifySerialModal.php'?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area start-->
                <div class="coupon-code-area">
                    <div class="row">
                        
                        <div class="col-lg-6 col-md-12 text-right">
                            <?php if($fetch_order['payment'] == 0 && strtolower($fetch_order['payment_method']) !="cod" ){ ?>

                                <div class="pb-10 pt-20 text-center">
                                    <button class="btn btn_pay_now" type="button" onclick="redirectPaymentGateway()" >Pay Now</button>
                                </div>

                            <?php } ?>
                        </div>

                        <div class="col-lg-6 col-md-12 text-right">
                            <div class="coupon-code">
                                <h3>Summary</h3>
                                <div class="cart-total-amount">

                                    <?php foreach ($orderSummary as $key => $value) { ?>
                                    
                                        <div class="cart-subtotal">
                                            <p class="subtotal"><?php echo $key ?></p>
                                            <p class="cart-amount"><?php echo CURRENCY ?> <?php echo $value ?></p>
                                        </div>
                                    
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!--coupon code area end-->
            </form> 
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
    <script src="<?php echo URL ?>assets/js/pages/serialVerification.js"></script>
</body>

<script>
    function redirectPaymentGateway(){
        $('#redirect_payment_gateway').submit();
    }
</script>

<?php 
if(isset($_GET['paynow'])){
    $_GET['paynow'] = trim($_GET['paynow']);

    if($_GET['paynow'] == "card"){
        ?>
            <script>
                redirectPaymentGateway();
            </script>
        <?php
    } // check payment method

} // isset of get
?>
</html>