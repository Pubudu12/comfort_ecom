<?php 
require_once '../app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'shopController/http/controller/checkoutController.php';

$getUserType = checkUserAccess();
$product_id = 0;
if(isset($_GET['id'])){
    $product_id = $_GET['id'];
}
// $user_id = $_SESSION['user_id'];

// if( $getUserType['access'] != 1 ){ ?>
        
<!-- <script>
    window.location = "<?php echo URL ?>login";
</script> -->
<?php 
// }else{
    // $user_id = $_SESSION['user_id'];
    // $select_user = mysqli_query($localhost,"SELECT * FROM `users` WHERE `id`='$user_id' ");
    // $fetch_users = mysqli_fetch_array($select_user);

    $serialNumberArray = array();
    $select_product = mysqli_query($localhost,"SELECT sn.* ,ps.`product_id`
                                                FROM `serial_numbers` AS sn
                                                INNER JOIN `product_serial` AS ps ON ps.`serial_id` = sn.`id`
                                                WHERE ps.`product_id`='$product_id' ");
    while($fetch_product = mysqli_fetch_array($select_product)){
        if ($fetch_product['verified_status'] == 1) {
            array_push($serialNumberArray,array(
                'id'=>$fetch_product['id'],
                'name'=>$fetch_product['name'],
                'verified_status'=>$fetch_product['verified_status'],
                'serial_number'=>$fetch_product['serial_number']
            ));
        }
    }
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Serial Number Verification ';
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
                            <h2 class="breadcrumb-title colour-brown"><b>Product Verification</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">Product Verification</li>
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
                <div class="row billing-info-wrap">
                    <div class="col-sm-12 col-lg-6">
                        <div class="container-form billing-info">
                            <div class="form-label-group">
                                <input type="text"  name="serial_number" id="serial_number" placeholder="Serial Number">
                                <!-- <label class="col-form-label">Name </label> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="container-form">
                            <div class="form-group form-label-group text-right">
                                <button class="btn btn--lg btn--black" type="button" onclick="fetchSerialProduct()">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table cart-table table-responsive-xs">
                            <thead>
                                <tr>
                                    <th class="text-center">Product Name</th>	 	
                                    <th class="text-center">Action</th>	
                                </tr>
                            </thead>
                            <tbody>
                            <?php //if (count($serialNumberArray) > 0 ) { 
                               // foreach ($serialNumberArray as $key => $singleSerial) { ?>
                                    <tr>
                                        <td id="pro_name" class="text-center"></td>
                                        <td class="text-center" id="button-verify">
                                            <button class="btn btn--lg btn--black hide"  type="button" onclick="verifySerial()">Verify</button>
                                            <input type="hidden" name="pro_id" id="pro_id" value="">
                                            <?php //include_once ROOT_PATH.'account/modal/verifySerialModal.php'?>
                                        </td>
                                    </tr>   
                                <?php
                                //} 
                           // } else { ?>
                                    <!-- <tr>
                                        <td></td>
                                        <td class="text-center">No Products Available</td>
                                    </tr> -->
                            <?php //} ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
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
    <script src="<?php echo URL ?>assets/js/pages/serialVerification.js"></script>
</body>
</html>
<?php //} ?>