<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Create - Promo Code - ';
    $meta_single_page_desc = 'Create - Promo Code - ';
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
                                <h3>Create Promo Code</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-adding">
                                    
                                    <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                                            action="<?php echo URL ?>promoCodes/ajax/controller/createPromoController.php">

                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="name" placeholder="">
                                                        <label class="col-sm-4 col-form-label"> Name </label>
                                                    </div>
                                                </div>

                                                <div class="col-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="code" placeholder="">
                                                        <label class="col-sm-4 col-form-label"> Code </label>
                                                    </div>
                                                </div>

                                                <div class="col-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="max_usage" placeholder="">
                                                        <label class=" col-form-label"> Max usage per customer</label>
                                                    </div>
                                                </div>

                                                <div class="col-2 container-form mt-3">
                                                    <div class="form-group form-label-group row">
                                                        <select id="category_level" class="form-control select2 order_filter" name="dis_type">
                                                            <option value="0" selected disabled>Discount Type</option>
                                                            <option value="%">%</option>
                                                            <option value="/">/</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-3 container-form mt-3">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="amount" placeholder="">
                                                        <label class="col-sm-6 col-form-label"> Amount *</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-3 container-form mt-3">
                                                    <div class="form-group form-label-group row">
                                                        <input type="date" class="form-control" name="start_date" placeholder="">
                                                        <label class="col-sm-4 col-form-label"> Start Date</label>
                                                    </div>
                                                </div>

                                                <div class="col-4 container-form mt-3">
                                                    <div class="form-group form-label-group row">
                                                        <input type="date" class="form-control" name="end_date" placeholder="">
                                                        <label class="col-sm-4 col-form-label"> End Date</label>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-lg-12 text-right mt-3">
                                                    <input type="hidden" name="create_promo_code">
                                                    <a href="<?php echo URL?>promo_codes" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
                                                    <button class="btn btn-primary submit_form_no_confirm" 
                                                            data-notify_type=2 
                                                            data-validate=0 
                                                            type="button">Create</button>
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
        <!-- footer end-->
    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>

</body>
</html>
