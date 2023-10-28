<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';


$catg_id = 0;
if(isset($_GET['id'])){

    if(is_numeric($_GET['id'])){
        $catg_id = $_GET['id'];
    }
}

$select_catg = mysqli_query($localhost,"SELECT `id`, `name` FROM `gallery_category` WHERE `id`='$catg_id'");
$fetch_catg = mysqli_fetch_array($select_catg);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Update Gallery Category - ';
    $meta_single_page_desc = 'Update Gallery Category - ';
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
                                <h3>Update Gallery Category
                                    <small><?php echo $fetch_catg['name'] ?></small>
                                </h3>
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
                                    
                                    <form class="form add-product-form" data-action-after=2 data-redirect-url="<?php echo URL ?>gallery/categories" method="POST"
                                            action="<?php echo URL ?>galery_categories/ajax/controller/updateGalleryController.php">

                                        <div class="col-xl-12">
                                            <div class="row">

                                                <div class="col-5 offset-2 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" value="<?php echo $fetch_catg['name'] ?>" name="name" placeholder="">
                                                        <label class="col-form-label">Name *</label>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-lg-12 text-right">

                                                    <input type="hidden" name="update_gal_category" value="<?php echo $catg_id ?>">
                                                    <a href="<?php echo URL ?>gallery/categories" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
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
