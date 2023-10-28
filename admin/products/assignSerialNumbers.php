<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';
require_once ROOT_PATH.'imports/functions.php';
$gump = new GUMP();

$product_id = 0;
if (isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {
        $product_id = $_GET['id'];
    }
}

$select_pro = mysqli_query($localhost,"SELECT `item_code`,`name` FROM `products` WHERE `id`='$product_id' ");
$fetch_pro = mysqli_fetch_array($select_pro);

$fetch_pro = $gump->sanitize($fetch_pro); 

$sanitized_query_data = $gump->run($fetch_pro);

$serialNumberList = array();
$select = mysqli_query($localhost," SELECT s.`id`,s.`name`,s.`serial_number` 
                                    FROM `serial_numbers` AS s 
                                    WHERE s.id NOT IN 
                                        ( SELECT ps.`serial_id` AS psid 
                                          FROM `product_serial` AS ps ) ");
while($fetch = mysqli_fetch_array($select)){
    array_push($serialNumberList, array(
        'id' => $fetch['id'],
        'name' => $fetch['name'],
        'serial' => $fetch['serial_number'],
    ));
}

$assigned_numbers = array();
$selectProSerial = mysqli_query($localhost,"SELECT sn.*,ps.`id` AS psid
                                            FROM `product_serial` AS ps
                                            INNER JOIN `serial_numbers` AS sn ON sn.`id` = ps.`serial_id` 
                                            WHERE ps.`product_id` = '$product_id' ");
while($fetchProSerial = mysqli_fetch_array($selectProSerial)){
    // $id = $fetchProSerial['id'];
    $selectProDealers = mysqli_query($localhost,"SELECT u.*,pd.`id` AS psid
                                            FROM `product_dealers` AS pd
                                            INNER JOIN `users` AS u ON u.`id` = pd.`dealer_id` 
                                            WHERE pd.`product_id` = '$product_id' LIMIT 1");
    $fetchProDealer = mysqli_fetch_array($selectProDealers);
    $dealer = 'No dealer';
    if (mysqli_num_rows($selectProDealers) > 0 ) {
        $dealer = $fetchProDealer['name'];
    }
    array_push($assigned_numbers, array(
        // 'dealer'=>$dealer,
        'id' => $fetchProSerial['id'],
        'psid'=>$fetchProSerial['psid'],
        'name' => $fetchProSerial['name'],
        'serial' => $fetchProSerial['serial_number'],
        'verified_status' => $fetchProSerial['verified_status'],
    ));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    $meta_single_page_title = 'Assign Products ';
    $meta_single_page_desc = 'Assign Products ';
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
                                <h3>Assign Serial Numbers
                                <br>
                                <small>For the Product <b><?php echo $sanitized_query_data['name']?></b></small>
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
                        <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                                            action="<?php echo URL ?>products/ajax/controller/createProductController.php">
                            <div class="row">
                            <hr>
                                <div class="col-md-5 col-sm-5">
                                    <select class="form-control select2"  name="serialNumbers[]" multiple>
                                        <?php foreach ($serialNumberList as $key => $value) { ?>
                                            <option value="<?php echo $value['id']?>"><?php echo $value['name'].' - '.$value['serial']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <input type="hidden" name="assign_serial_numbers">
                                    <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>">
                                    <button class="btn btn-primary submit_form_no_confirm" 
                                                                data-notify_type=2 
                                                                data-validate=0 
                                                                type="button"><i class="fa fa-arrow-circle-right"></i></button>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-left">Assigned Serial Numbers</th>
                                                <!-- <th class="text-left">Dealer</th> -->
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($assigned_numbers as $key => $singleNumber) { ?>
                                            <tr>
                                                <td class="text-left">
                                                    <?php if ($singleNumber['verified_status'] == 1) {?>
                                                        <i class="verified-icon fa fa-check-circle"></i> 
                                                   <?php } ?>
                                                </td>
                                               
                                                <td class="text-left">
                                                    <?php echo $singleNumber['serial']?>
                                                </td>
                                                <!-- <td class="text-right"><?php //echo $singleNumber['dealer']?></td> -->
                                                <td class="text-left"><button onclick="deleteSerialFromProduct('<?php echo $singleNumber['psid']?>')" class="btn btn-sm small-icon btn-danger"><i class="fa fa-times-circle"></i></button></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Container-fluid Ends-->
        </div>
        
        <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>
    </div>
</div>

<?php include_once ROOT_PATH.'imports/js.php'?>
<script src="<?php echo URL ?>assets/js/pages/products.js"></script>
</body>
</html>
