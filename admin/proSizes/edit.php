<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';


$size_id = 0;
if(isset($_GET['id'])){

    if(is_numeric($_GET['id'])){
        $size_id = $_GET['id'];
    }
}

$select_size = mysqli_query($localhost,"SELECT `id`, `name`,`category_id` FROM `sizes` WHERE `id`='$size_id'");
$fetch_size = mysqli_fetch_array($select_size);

$catArray = array();
$categories = mysqli_query($localhost,"SELECT `id`, `name` FROM `product_size_categories` ");
while($fetch_categ = mysqli_fetch_array($categories)){
    array_push($catArray,array(
        'id'=>$fetch_categ['id'],
        'name'=>$fetch_categ['name'],
    ));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Update Size - ';
    $meta_single_page_desc = 'Update Size - ';
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
                                <h3>Update Size
                                    <small><?php echo $fetch_size['name'] ?></small>
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
                                    
                                    <form class="form add-product-form" data-action-after=2 data-redirect-url="<?php echo URL ?>sizes" method="POST"
                                            action="<?php echo URL ?>proSizes/ajax/controller/updateSizeController.php">

                                        <div class="col-xl-12">
                                            <div class="row offset-2">

                                                <div class="col-5 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" value="<?php echo $fetch_size['name'] ?>" name="name" placeholder="">
                                                        <label class="col-form-label">Size *</label>
                                                    </div>
                                                </div>

                                                <div class="col-4 container-form">
                                                    <div class="row">
                                                        <select class="form-control select2" data-level="1" name="category">
                                                            <option selected disabled value="0"> Select Size Category</option>                                                            
                                                            <?php foreach ($catArray as $key => $value) {?>
                                                                <!-- <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option> -->
                                                                <option value="<?php echo $value['id'] ?>" <?php echo comboboxSelected($value['id'], $fetch_size['category_id']) ?>> <?php echo $value['name'] ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-lg-12 text-right">

                                                    <input type="hidden" name="update_size" value="<?php echo $size_id ?>">
                                                    <a href="<?php echo URL ?>sizes" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
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
