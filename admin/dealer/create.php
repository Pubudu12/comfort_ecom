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
    
    $meta_single_page_title = 'Create Dealer - ';
    $meta_single_page_desc = 'Create Dealer - ';
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
        
    <!-- side bar -->
    <?php include_once ROOT_PATH.'imports/sidebar.php'?>

        <div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                
                    <div class="col-lg-12">
                        <div class="page-header-left">
                            <h3>Create Dealer</h3>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-adding">
                                    
                                    <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                                            action="<?php echo URL ?>dealer/ajax/controller/createDealerController.php">

                                        <div class="col-xl-12">
                                            <div class="row">

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="name" placeholder="">
                                                        <label class="col-form-label">Name* </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="username" placeholder="">
                                                        <label class="col-form-label">Username* </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="contact_no" placeholder="">
                                                        <label class="col-form-label">Contact Number* </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="email" placeholder="">
                                                        <label class="col-form-label">Email* </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="password" class="form-control" name="password" placeholder="">
                                                        <label class="col-form-label">Password* </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="password" class="form-control" name="c_password" placeholder="Confirm Password">
                                                        <label class="col-form-label">Confirm Password* </label>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-lg-12 text-right">
                                                    <input type="hidden" name="create_new_dealer">
                                                    <a href="<?php echo URL ?>dealer/dealers.php" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
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

    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>
<script>
    
</script>
</body>
</html>
