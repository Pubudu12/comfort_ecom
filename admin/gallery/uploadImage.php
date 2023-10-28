<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

$imgTypeArray = array('image', 'video');

$gallery_id = 0;
if(isset($_GET['id'])){
    $gallery_id = $_GET['id'];
}// check isset

$select = mysqli_query($localhost, "SELECT * FROM `gallery` WHERE `id` = '$gallery_id' ");
$fetch = mysqli_fetch_array($select);

$imgBoxContainer = file_get_contents(ROOT_PATH.'gallery/container/imgUploadCardContainer.html');
$images_array = array();

if ($fetch['type'] == 'image') {
    $tempCardCont = $imgBoxContainer;
    $tempCardCont = str_replace('{{ IMG_NAME }}', URL.GALLERY_IMG_PATH.$fetch['gallery_media'],  $tempCardCont);
    $tempCardCont = str_replace('{{ IMG_ID }}', $fetch['id'],  $tempCardCont);
    $tempCardCont = str_replace('{{ IMGTYPE }}', $fetch['type'],  $tempCardCont);
    $tempCardCont = str_replace('{{ HIDE_LINK }}', 'hide',  $tempCardCont);
    array_push($images_array, $tempCardCont);
}else{
    $tempCardCont = $imgBoxContainer;
    // $tempCardCont = str_replace('{{ IMG_NAME }}', URL.GALLERY_IMG_PATH.$fetch['gallery_media'],  $tempCardCont);
    $tempCardCont = str_replace('{{ IMG_ID }}', $fetch['id'],  $tempCardCont);
    $tempCardCont = str_replace('{{ IMGTYPE }}', $fetch['type'],  $tempCardCont);
    $tempCardCont = str_replace('{{ HIDE_IMG }}', 'hide',  $tempCardCont);
    $tempCardCont = str_replace('{{ LINK }}', $fetch['gallery_media'],  $tempCardCont);
    array_push($images_array, $tempCardCont);
}

// print_r($images_array);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Upload Gallery Image - ';
    $meta_single_page_desc = 'Upload Gallery Image - ';
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
                                <h3> Add Gallery Image/Video
                                <!-- <small></small> -->
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
                                                                data-redirect-url="<?php echo URL ?>galleryItems" 
                                                                method="POST" 
                                                                id="package_images_form"
                                                                action="<?php echo URL ?>gallery/ajax/controller/createGalleryController.php">

                                                            <div class="form-group text-center">
                                                                <select name="img_type"  id="upload_type" onchange="changeDesign()">
                                                                    <?php 
                                                                    foreach ($imgTypeArray as $key => $imgType) { ?>
                                                                        <option value="<?php echo $imgType ?>"><?php echo $imgType ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <br><br>
                                                                <div id="image_section">
                                                                    <label class="file-upload-browse btn btn-info img_preview_label" for="pack_img_upload"> <i class="fa fa-plus"></i> </label>
                                                                    <!-- <p>Resolution</p> -->
                                                                    <input type="file" name="img_name" class="file-upload-default hide" id="pack_img_upload">
                                                                </div>
                                                                <div id="video_section">
                                                                    <div class="form-group form-label-group row">
                                                                        <input type="text" class="form-control" name="link" id="linkName">
                                                                        <label class="">Video Link</label>
                                                                    </div>
                                                                    
                                                                    
                                                                    <button class="btn btn-primary submit_form_no_confirm" 
                                                                        data-notify_type=2 
                                                                        data-validate=0 
                                                                        type="button">Update</button>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="upload_image" value="<?php echo $gallery_id ?>">
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

<script src="<?php echo URL ?>assets/js/pages/gallery.js"></script>

</body>
</html>
