<?php 
require_once '../app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'shopController/http/controller/checkoutController.php';

$getUserType = checkUserAccess();
$user_id = $_SESSION['user_id'];

if( $getUserType['access'] == 0 ){ ?>
        
<script>
    window.location = "<?php echo URL ?>login";
</script>
<?php 
}else{
    $user_id = $_SESSION['user_id'];
    $select_user = mysqli_query($localhost,"SELECT * FROM `users` WHERE `id`='$user_id' ");
    $fetch_users = mysqli_fetch_array($select_user);
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'My Orders | ';
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
                            <h2 class="breadcrumb-title colour-brown"><b>My Orders</b></h2>
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
    <!-- breadcrumb-area end -->
    <div class="site-wrapper-reveal border-bottom">
        <!-- checkout start -->
        <div class="checkout-main-area section-space--ptb_90">
            <div class="container">
                <div class="row">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Order</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Payment Status</th>
                                <th class="text-center">Delivery Status</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $no = 1;
                            $select_order_history = mysqli_query($localhost,"SELECT o.*
                                                                        FROM `orders` o 
                                                                        INNER JOIN `user_std_order_history` uh ON uh.`order_no` = o.`order_no` AND uh.`user_id`='$user_id'
                                                                        WHERE  o.`user_type`='std' GROUP BY o.`order_no` ");
                            while($fetch_order_history = mysqli_fetch_array($select_order_history)){ 
                                
                                if($fetch_order_history['payment'] == 0){ 
                                    $payment_status = "Pending";
                                }else{ 
                                    $payment_status = "Paid";
                                }

                                $payment_empty = 0;

                                if($fetch_order_history['payment'] == 0 && strtolower($fetch_order_history['payment_method']) != "cod"){
                                    $pay_now = $fetch_order_history['payment_method'];
                                    $payment_empty = 1;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $no?></td>
                                    <td class="text-center"><?php echo $fetch_order_history['order_no']; ?></td>
                                    <td class="text-center"><?php echo Date("d M Y", strtotime($fetch_order_history['checkout_date'])) ?></td>
                                    <td class="text-center"><?php echo $payment_status ?></td>
                                    <td class="text-center"><?php echo $fetch_order_history['delivery_status'] ?></td>
                                    <td class="text-center"><?php echo CURRENCY ?> <?php echo number_format($fetch_order_history['total'],2) ?></td>
                                    <td class="text-center">
                                    <a href="<?php echo URL ?>view_order?order_no=<?php echo $fetch_order_history['order_no'] ?>" class="btn btn--lg btn--black" target="_blank" >view</a><?php 
                                        if($fetch_order_history['payment'] == 0){ ?>

                                            <a href="<?php echo URL ?>view_order?order_no=<?php echo $fetch_order_history['order_no'] ?>&paynow=<?php echo $pay_now ?>" class="btn btn--lg btn--black" target="_blank"  > Pay Now</a>

                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
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
</body>
</html>
<?php } ?>