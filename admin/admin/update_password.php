<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';
?>
<?php
    $user_id = 0;
    if (isset($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $user_id = $_GET['id'];
        }
    }

    $select_user = mysqli_query($localhost,"SELECT `id`,`username` FROM `admin` WHERE `id`='$user_id' ");
    $fetch_user = mysqli_fetch_array($select_user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Change User Password - ';
    $meta_single_page_desc = 'Change User Password - ';
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
            <div class="container">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header-left">
                                <h3>Change User Password <small><?php echo $fetch_user['username']?></small> </h3>
                            </div>
                            <br>
                        </div>
                    </div>

                    <div class="row">
                    
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="product-adding">
                                        
                                        <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                                                action="<?php echo URL ?>admin/ajax/controller/updateUserController.php">

                                            <div class="col-xl-12">
                                                <div class="row">

                                                    <div class="col-md-6 container-form">
                                                        <div class="form-group form-label-group row">
                                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                                            <label class="col-form-label">Password* </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 container-form">
                                                        <div class="form-group form-label-group row">
                                                            <input type="password" class="form-control" name="c_password" placeholder="Confirm Password">
                                                            <label class="col-form-label">Confirm Password* </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-lg-12 text-right">
                                                        <input type="hidden" name="user_id" value="<?php echo $fetch_user['id']?>">
                                                        <input type="hidden" name="update_user_pswd">
                                                        <a href="<?php echo URL ?>admin/users.php" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
                                                        <button class="btn btn-primary submit_form_no_confirm" 
                                                                data-notify_type=2 
                                                                data-validate=0 
                                                                type="button">Update</button>
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
            </div>
            <!-- Container-fluid Ends-->



        </div>

        <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>

    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>
</body>
</html>
