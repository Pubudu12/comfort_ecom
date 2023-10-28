<?php
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Create Post Category - ';
    $meta_single_page_desc = 'Create Post Category - ';
    include_once ROOT_PATH.'app/meta/meta_more_details.php'; 
    
    include_once ROOT_PATH.'imports/css.php';

    $checkArr = array(
        'page_level_code' => 2
    );
    require_once ROOT_PATH.'account/include/authViewPage.php';
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
                                <h3>Create Post Category</h3>
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
                                            action="<?php echo URL ?>blog/categories/ajax/controller/createBlogCategoryController.php">

                                        <div class="col-xl-12">
                                            <div class="row">

                                                <div class="container-form form-group col-3 offset-2 mt-2">
                                                    <select name="type" class="form-control custom-select select2">
                                                        <option value="0" selected disabled> Select Type </option>
                                                        <option value="blog"> Blog </option>
                                                        <option value="news"> News </option>
                                                    </select>
                                                </div>

                                                <div class="col-5 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="name" placeholder="">
                                                        <label class="col-sm-4 col-form-label">Category Name *</label>
                                                    </div>
                                                </div>


                                                <div class="col-xs-12 col-lg-12 text-right">

                                                    <input type="hidden" name="create_blog_category">
                                                    <a href="<?php echo URL ?>blog/category" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
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