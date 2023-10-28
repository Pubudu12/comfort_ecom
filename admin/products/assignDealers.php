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

$dealer = array();
$select = mysqli_query($localhost,"SELECT `id`,`name` FROM `users` WHERE `user_type`='dealer' ");
while($fetch = mysqli_fetch_array($select)){
    array_push($dealer, array(
        'id' => $fetch['id'],
        'name' => $fetch['name'],
    ));
}

$assignedDealers = array();
$selectProDealer = mysqli_query($localhost,"SELECT u.`name`,pd.`id` AS pdid
                                            FROM `product_dealers` AS pd
                                            INNER JOIN `users` AS u ON u.`id` = pd.`dealer_id` 
                                            WHERE pd.`product_id` = '$product_id' AND u.`user_type`='dealer' ");
while($fetchProDealer = mysqli_fetch_array($selectProDealer)){
    array_push($assignedDealers, array(
        // 'id' => $fetchProDealer['id'],
        'pdid'=>$fetchProDealer['pdid'],
        'name' => $fetchProDealer['name'],
    ));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Assign Dealers ';
    $meta_single_page_desc = 'Assign Dealers ';
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
                                <h3>Assign Dealers 
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
                                <select class="form-control select2"  name="dealers[]" multiple>
                                    <?php foreach ($dealer as $key => $value) { ?>
                                        <option value="<?php echo $value['id']?>"><?php echo $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-1 col-sm-1">
                                <input type="hidden" name="assign_dealers">
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
                                            <th class="text-center">Assigned Delers</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($assignedDealers as $key => $singleDealer) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $singleDealer['name']?></td>
                                            <td class="text-center"><button onclick="deleteDealerFromProduct('<?php echo $singleDealer['pdid']?>')" class="btn btn-sm small-icon btn-danger"><i class="fa fa-times-circle"></i></button></td>
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
