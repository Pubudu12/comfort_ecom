<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

// $imgTypeArray = array('thumb', 'cover', 'default');
$imgTypeArray = array('cover');

$category_id = 0;
if(isset($_GET['id'])){
    $category_id = $_GET['id'];
}// check isset

$select = mysqli_query($localhost, "SELECT * FROM `categories` WHERE `id` = '$category_id' ");
$fetch = mysqli_fetch_array($select);

$imgBoxContainer = file_get_contents(ROOT_PATH.'category/container/imgUploadCardContainer.html');

$images_array = array();
$select_all_images = mysqli_query($localhost,"SELECT * FROM `categories_images` AS catI WHERE `category_id`='$category_id' ORDER BY `id` ASC ");

while($fetch_all_images = mysqli_fetch_array($select_all_images)){

    $tempCardCont = $imgBoxContainer;
    $tempCardCont = str_replace('{{ IMG_NAME }}', URL.CAT_IMG_PATH.$fetch_all_images['name'],  $tempCardCont);
    $tempCardCont = str_replace('{{ IMG_ID }}', $fetch_all_images['id'],  $tempCardCont);
    $tempCardCont = str_replace('{{ IMGTYPE }}', $fetch_all_images['type'],  $tempCardCont);
    array_push($images_array, $tempCardCont);

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Upload Products Images - ';
    $meta_single_page_desc = 'Upload Products Images - ';
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
                                <h3> <?php echo $fetch['name'] ?>
                                <small>Add Category Image</small>
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
                                <div class="row product-adding">
                                    <div class="col-xl-12">
                                        <div class="add-product">
                                            <div class="row">

                                                <div class="col-xl-12 col-sm-12 col-lg-4">
                                                    <div class="img-box-parent">
                                                    </div>
                                                </div>

                                                <div class="col-12 flex-container append_info_clone_here">


                                                    <?php  
                                                    foreach ($images_array as $key => $imageCard) {  
                                                        echo $imageCard;
                                                    } ?>


                                                    <div class="img_single_box uploadBox">
                                
                                                        <form class="forms-sample" 
                                                                data-action-after=0 
                                                                data-redirect-url="" 
                                                                method="POST" 
                                                                id="package_images_form"
                                                                action="<?php echo URL ?>category/ajax/controller/createCategoryController.php">

                                                            <div class="form-group text-center">
                                                                <!-- <select name="img_type">
                                                                    <?php 
                                                                    ///foreach ($imgTypeArray as $key => $imgType) { ?>
                                                                        <option value="<?php echo $imgType ?>"><?php echo $imgType ?></option>
                                                                    <?php ///} ?>
                                                                </select> -->
                                                                <br><br>
                                                                <label class="file-upload-browse btn btn-info img_preview_label" for="pack_img_upload"> <i class="fa fa-plus"></i> </label>
                                                                <p>Resolution</p>
                                                                <input type="file" name="img_name" class="file-upload-default hide" id="pack_img_upload">
                                                            </div>

                                                            <input type="hidden" name="upload_image" value="<?php echo $category_id ?>">

                                                        </form>

                                                    </div>

                                                </div>


                                            </div>
                                        </div>
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

<script src="<?php echo URL ?>assets/js/pages/category.js"></script>

</body>
</html>
