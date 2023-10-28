<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';
$gump = new GUMP();
$imgTypeArray = array('thumb', 'cover', 'default');

$product_id = 0;
if(isset($_GET['id'])){
    $product_id = $_GET['id'];
}// check isset

$imgTypes = array('cover'=>'cover','thumb'=>'thumb','default'=>'default');

$selectPro = mysqli_query($localhost,"SELECT `name` FROM `products` WHERE `id`='$product_id' ");
$fetchPro = mysqli_fetch_array($selectPro);
$fetchPro = $gump->sanitize($fetchPro); 
$sanitized_query_data = $gump->run($fetchPro);

$imgBoxContainer = file_get_contents(ROOT_PATH.'products/container/imgUploadCardContainer.html');

$images_array = array();
$select_all_images = mysqli_query($localhost,"SELECT * FROM `product_images` WHERE `product_id`='$product_id' ORDER BY `id` ASC ");
while($fetch_all_images = mysqli_fetch_array($select_all_images)){

    $tempCardCont = $imgBoxContainer;
    $tempCardCont = str_replace('{{ IMG_NAME }}', URL.PRO_IMG_PATH.$fetch_all_images['name'],  $tempCardCont);
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
                                <h3> <?php echo $sanitized_query_data['name']?>
                                <small>Add Product Images</small>
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

                                                <?php $select_all_images = mysqli_query($localhost,"SELECT * FROM `product_images` WHERE `product_id`='$product_id' ORDER BY `id` ASC ");
                                                        while($fetch_all_images = mysqli_fetch_array($select_all_images)){?>
                                                            <div class="img_single_box imgcard">
                                                                <img src="<?php echo URL.PRO_IMG_PATH.$fetch_all_images['name']?>" alt="">
                                                                <div class="fix-box" data-id="<?php echo $fetch_all_images['id']?>">
                                                                    <label class="img_type_label">
                                                                        <select class="form-control" name="image_type" id="image_type" onchange="changeImageType('<?php echo $fetch_all_images['id']?>',this)">
                                                                           <?php foreach ($imgTypes as $key => $type) {?>
                                                                                <option value="<?php echo $type?>" <?php echo comboboxSelected($type, $fetch_all_images['type']) ?>><?php echo $type?></option>
                                                                            <?php }?>
                                                                        </select> 
                                                                    </label>
                                                                    <button class="btn btn-sm text-danger deletebtn" onclick="deleteImage(this)" type="button"> <i class="fa fa-trash-o"></i> </button>
                                                                </div>
                                                            </div>
                                                <?php }?>


                                                    <?php  
                                                    //foreach ($images_array as $key => $imageCard) {  
                                                    //    echo $imageCard;
                                                    //} ?>


                                                    <div class="img_single_box uploadBox">
                                
                                                        <form class="forms-sample" 
                                                                data-action-after=0 
                                                                data-redirect-url="" 
                                                                method="POST" 
                                                                id="package_images_form"
                                                                action="<?php echo URL ?>products/ajax/controller/createProductController.php">

                                                            <div class="form-group text-center">
                                                                <select name="img_type">
                                                                    <?php 
                                                                    foreach ($imgTypeArray as $key => $imgType) { ?>
                                                                        <option value="<?php echo $imgType ?>"><?php echo $imgType ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <br><br>
                                                                <label class="file-upload-browse btn btn-info img_preview_label" for="pack_img_upload"> <i class="fa fa-plus"></i> </label>
                                                                <p>Resolution</p>
                                                                <h3><b>1200 x 1200</b> </h3>
                                                                <input type="file" name="img_name" class="file-upload-default hide" id="pack_img_upload">
                                                            </div>

                                                            <input type="hidden" name="upload_image" value="<?php echo $product_id ?>">

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

<script src="<?php echo URL ?>assets/js/pages/products.js"></script>

</body>
</html>
