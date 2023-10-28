<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';


$catgArr = array();
$select_gallery_catg = mysqli_query($localhost,"SELECT `id`, `name` FROM `gallery_category` ");
while($fetch_gallery_catg = mysqli_fetch_array($select_gallery_catg)){
    array_push($catgArr,array(
        'id'=>$fetch_gallery_catg['id'],
        'name'=>$fetch_gallery_catg['name'],
    ));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Create Gallery Item - ';
    $meta_single_page_desc = 'Create Gallery Item - ';
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
                                <h3>Create Gallery Item</h3>
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
                                    
                                    <form class="form add-product-form" data-action-after=2 data-redirect-url="<?php echo URL?>galleryItems" method="POST"
                                            action="<?php echo URL ?>gallery/ajax/controller/createGalleryController.php">

                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-3">
                                                    <div class="row">
                                                        <!-- <div class="col-lg-12 category_box"> -->
                                                            <select class="form-control select2" data-level="1" name="category">
                                                                <option selected disabled value="0"> Select Category</option>
                                                                
                                                                <?php foreach ($catgArr as $key => $value) {?>
                                                                    <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <!-- </div> -->
                                                    </div>
                                                </div>

                                                <div class="col-lg-9">
                                                    <!-- <div class="row"> -->
                                                        <div class="form-group col-lg-12">
                                                            <div class="description-sm">
                                                                <label for="">Caption</label>
                                                                <textarea class="form-control" id="caption" name="caption" cols="6" rows="7" placeholder=""></textarea>
                                                            </div>
                                                        </div>
                                                    <!-- </div> -->
                                                </div>

                                                <div class="col-xs-12 col-lg-12 text-right">
                                                    <input type="hidden" name="create_galleryItem">
                                                    <a href="<?php echo URL ?>galleryItems" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
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

<script src="<?php echo URL ?>assets/js/pages/category.js"></script>

</body>
</html>
