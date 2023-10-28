<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';


$ref_id = 0;
if(isset($_GET['id'])){

    if(is_numeric($_GET['id'])){
        $ref_id = $_GET['id'];
    }
}

$select = mysqli_query($localhost, "SELECT rod.*, rml.`name` masterName, rml.`id` master_id, rml.`code` master_code
                                    FROM `ref_one_dimension` AS rod
                                    INNER JOIN `references_master_list` AS rml ON rml.`id` = rod.`master_id`
                                    WHERE rod.`id` = '$ref_id' ");
$fetch = mysqli_fetch_array($select);
$name = $fetch['name'];
$masterName = $fetch['masterName'];
$ref_master_id = $fetch['master_id'];
$ref_master_code = $fetch['master_code'];

// Existing Img
$img_exist = '';
$existingImage = 0;
if(file_exists(ROOT_PATH.BRAND_IMG_PATH.$fetch['image_name']) && ( strlen(trim($fetch['image_name'])) > 0 ) ){
    $existingImage = URL.BRAND_IMG_PATH.$fetch['image_name'];
    $img_exist = 'img_exist';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = $name.' - Update Reference List - ';
    $meta_single_page_desc = $name.' - Update Reference List - ';
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
                                <h3>Update <?php echo $name ?>
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
                                    <div class="col-xl-12">
                                        <div class="row">

                                            <div class="col-lg-12 cover_img_box <?php echo $img_exist ?>">

                                                <div class="form-group text-center cover_img_div">

                                                    <form class="forms-sample" 
                                                        data-action-after=3 
                                                        data-redirect-url = "pills-meta-tab" 
                                                        method="POST" 
                                                        id="cover_images_form"oneDReferences/ajax/controller/updateOneDReferencesController.php
                                                        action="<?php echo URL ?>oneDReferences/ajax/controller/updateOneDReferencesController.php">

                                                        <label class="file-upload-browse btn btn-info" for="cover_img_upload"> Upload Brand Image</label>                            
                                                        <h3><b>500 x 500</b> </h3>
                                                        <input type="file" name="cover_img" class="file-upload-default hide" id="cover_img_upload">

                                                        <input type="hidden" name="update_post_cover" value="<?php echo $ref_id ?>">

                                                    </form>

                                                </div>


                                                <?php if($existingImage !== 0){ ?>

                                                    <img src="<?php echo $existingImage ?>" class="cover_img w-100" alt="">
                                                <?php } ?>


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
        <!-- footer end-->
    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>
<script src="<?php echo URL ?>assets/js/pages/post.js"></script>

</body>
</html>
