<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';
$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';
$gump = new GUMP();

$id = 0;
if(isset($_GET['id'])){

    if(is_numeric($_GET['id'])){
        $id = $_GET['id'];
    }
}

$select_req = mysqli_query($localhost,"SELECT *
                                        FROM `custom_size_requests` 
                                        WHERE `id`='$id'");
$fetch_req = mysqli_fetch_array($select_req);
$id = $fetch_req['product_id'];
$contact = '';
if (isset($fetch_req['contact_no'])) {
    $contact = $fetch_req['contact_no'];
}

$select_pro = mysqli_query($localhost,"SELECT `name`
                                        FROM `products`
                                        WHERE `id`='$id' ");
$fetch_pro = mysqli_fetch_array($select_pro);
$name = $gump->sanitize($fetch_pro);
$sanitized_query_data = $gump->run($name);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'View Request -';
    $meta_single_page_desc = 'View Request -';
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
                                <h3>Requested Size Details</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-adding">
                                    
                                    <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                                            action="<?php echo URL ?>products/ajax/controller/updateProductController.php">

                                        <div class="col-xl-12">
                                            <div class="row">

                                                <div class="col-md-6 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Customer Name</label>
                                                        <input type="text" class="form-control " name="name" value="<?php echo $fetch_req['customer_name'] ?>" readonly placeholder="">
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-6 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Email </label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo $fetch_req['email'] ?>" readonly placeholder="">
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-6 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Product Name </label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo $sanitized_query_data['name'] ?>" readonly placeholder="">
                                                        
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-3 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label"> Contact No </label>
                                                        <input type="text" class="form-control" name="" value="<?php echo $contact ?>" readonly placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-3 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Requested at </label>
                                                        <input type="text" class="form-control" name="" value="<?php echo date("F j, Y, g:i a",strtotime($fetch_req['created'])) ?>" placeholder="" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label"> Requested Width </label>
                                                        <input type="text" class="form-control" name="" value="<?php echo $fetch_req['requested_width'] ?>" readonly placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label"> Requested Height </label>
                                                        <input type="text" class="form-control" name="" value="<?php echo $fetch_req['requested_height'] ?>" readonly placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group">
                                                        <label class="col-form-label"> Requested Length </label>
                                                        <input type="text" class="form-control" name="" value="<?php echo $fetch_req['requested_length'] ?>" readonly placeholder="">
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group col-sm-12 col-lg-12">
                                                    <div class="description-sm">
                                                        <textarea class="form-control" id="description" name="description" cols="6" rows="10" placeholder="" readonly><?php echo $fetch_req['message']?></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-lg-12 text-right">
                                                    <a href="<?php echo URL ?>products/customSizeReq.php" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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