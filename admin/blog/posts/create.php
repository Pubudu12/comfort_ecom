<?php
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

$category_arr = array();
$select = mysqli_query($localhost, "SELECT * FROM `blog_categories` ");
while($fetch = mysqli_fetch_array($select)){
    array_push($category_arr, array(
        'id' => $fetch['id'],
        'name' => $fetch['name']
    ));
}

$type_arr = array();
$select_type = mysqli_query($localhost, "SELECT * FROM `blog_type` ");
while($fetch_type = mysqli_fetch_array($select_type)){
    array_push($type_arr, array(
        'id' => $fetch_type['id'],
        'type' => $fetch_type['type']
    ));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Create Post - ';
    $meta_single_page_desc = 'Create Post - ';
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
                                <h3>Create Post</h3>
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
                                            action="<?php echo URL ?>blog/posts/ajax/controller/createPostController.php">

                                        <div class="col-xl-12">
                                            <div class="row">

                                                <div class="form-group col-8">
                                                    <label>Heading</label>
                                                    <input type="text" class="form-control" name="heading" placeholder="Post Heading">
                                                </div>

                                                <div class="text-left form-group col-2">
                                                    <label for="">Post Type</label>
                                                    <select name="post_type" id="post_type" class="form-control custom-select select2" onchange="fetchCategories()">
                                                        <option value="0" selected disabled>Select Type</option>
                                                        <?php foreach ($type_arr as $key => $value) { ?>
                                                            <option value="<?php echo $value['id'] ?>"> <?php echo $value['type'] ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-2">
                                                    <label for="">Category</label>
                                                    <select name="category" id="category_list" class="form-control custom-select select2">
                                                    </select>
                                                </div>

                                                <div class="form-group col-12">
                                                    <label>Description</label>
                                                    <textarea name="description" max-length="300" class="form-control" cols="30" rows="5" placeholder=""></textarea>
                                                </div>

                                                
                                                <div class="form-group col-3">
                                                    <label for="">Post Date</label>
                                                    <input type="date" class="form-control datepicker" value="<?php echo date("d-m-Y") ?>" name="post_date" placeholder="">
                                                </div>

                                                <div class="text-right col-6 offset-3 mt-4">
                                                    <input type="hidden" name="published_date" value="<?php echo date("d-m-Y") ?>">
                                                    <input type="hidden" name="create_blog_post">
                                                    <a href="<?php echo URL ?>blog/post" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
                                                    <button class="btn btn-primary submit_form_no_confirm" 
                                                            data-notify_type=2 
                                                            data-validate=0 
                                                            type="button">Create</button>
                                                </div>


                                                <!-- <div class="col-xs-12 col-lg-12 text-right">

                                                    <input type="hidden" name="published_date" value="<?php echo date("d-m-Y") ?>">

                                                    <input type="hidden" name="create_blog_post">
                                                    <a href="<?php echo URL ?>blog/post" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
                                                    <button class="btn btn-primary submit_form_no_confirm" 
                                                            data-notify_type=2 
                                                            data-validate=0 
                                                            type="button">Create</button>
                                                </div> -->

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
<script src="<?php echo URL ?>assets/js/pages/post.js"></script>

</body>
</html>