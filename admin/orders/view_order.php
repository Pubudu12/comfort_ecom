<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

$order_no = 0;
if(isset($_GET['order_no'])){
    $order_no = $_GET['order_no'];
}

$selectQuery = "SELECT o.*,dd.*, refShM.`name` shippingMethod
                    FROM `orders` o 
                    INNER JOIN `delivery_details` AS dd ON dd.`order_no`=o.`order_no`
                    LEFT JOIN `ref_shipping_methods` AS refShM ON refShM.`id` = dd.`shipping_method`
                    WHERE o.`order_no`='$order_no' ";
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
    'Address' => $fetch_order['door_no'].", ".$fetch_order['city'].", ".$fetch_order['district'].",".$fetch_order['state'].'-'.$fetch_order['zip_code'],
);


$orderItemsDetails = array();
$query = "SELECT oi.*,p.`name`, p.`id` product_id, thumb.`name` AS thumb
        FROM `order_items` oi 
        INNER JOIN `products` p ON p.`id`=oi.`product_id`
        LEFT JOIN `product_images` AS thumb ON thumb.`product_id` = p.`id` AND thumb.`type` = 'cover'
        WHERE oi.`order_no`='$order_no' GROUP BY oi.`product_id` AND oi.`size_id`";
$select_products = mysqli_query($localhost, $query);
while($fetch_products = mysqli_fetch_array($select_products)){
    $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=CW";
    if((strlen($fetch_products['thumb']) > 0) ){
        $thumbnail_image = URL.PRO_IMG_PATH.$fetch_products['thumb'];
    }

    array_push($orderItemsDetails, array(
        'thumb' => $thumbnail_image,
        'name' => $fetch_products['name'],
        'pro_url' => URL.'products/view_product.php?id='.$fetch_products['product_id'].'&product='.urlencode(strtolower(trim($fetch_products['name']))),
        'price' => number_format($fetch_products['rate'],2),
        'qty' => $fetch_products['qty'],
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
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'View Order ';
    $meta_single_page_desc = 'View Order ';
    include_once ROOT_PATH.'app/meta/meta_more_details.php'; 
    
    include_once ROOT_PATH.'imports/css.php';
    ?>
</head>
<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">

    <!-- Page Header Start-->
    <?php include_once ROOT_PATH.'imports/header.php'?>
    <!-- Page Header Ends -->

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

        <!-- Page Sidebar Start-->
        <?php include_once ROOT_PATH.'imports/sidebar.php'?>

        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>View Order
                                <br>
                                <small><?php echo $order_no ?></small>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
           
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="col-md-12 card">
                    <div class="col-md-12 card-body"> 
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
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                foreach ($orderItemsDetails as $key => $itemsArr) { ?>
                                                                    <tr>
                                                                        <td class="product-remove"><a><i class="fa"> <?php echo $key+1 ?> </i></a></td>
                                                                        <td class="product-thumb"><a><img src="<?php echo $itemsArr['thumb'] ?>" alt="<?php echo $itemsArr['name'] ?>" style="width:30%"></a></td>
                                                                        <td class="product-name"><a href="<?php echo $itemsArr['pro_url']?>" target="_blank"> <?php echo $itemsArr['name'] ?>  </a> </td>
                                                                        <td class="product-price text-right"> <?php echo $itemsArr['price'] ?></td>
                                                                        <td class="product_quantity text-right"> <?php echo $itemsArr['qty'] ?></td>
                                                                        <td class="product-total text-right"> <?php echo $itemsArr['total'] ?> </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>  
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                        <!--coupon code area start-->
                                        <!-- <div class="coupon-code-area">-->
                                            <!-- <div class="row">  -->
                                                <div class="col-lg-6 col-md-12 " style="float: left;">
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
                                            <!-- </div> -->
                                        <!-- </div> coupon code area end -->
                                        <input type="hidden" name="order_no" id="order_no" value="<?php echo $order_no?>">
                                    </form> 
                                </div>
                            </div>
                            <!-- checkout end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>
    </div>
</div>

<?php include_once ROOT_PATH.'imports/js.php'?>
<script src="<?php echo URL ?>assets/js/pages/orders.js"></script>
</body>
</html>
