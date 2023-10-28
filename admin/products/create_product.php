<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

$catg_list = array();
$select_catogory = mysqli_query($localhost,"SELECT * FROM `categories` WHERE `level`='1' ");
while($fetch_category = mysqli_fetch_array($select_catogory)){
    array_push($catg_list,array(
        'id'=>$fetch_category['id'],
        'name'=>$fetch_category['name']
    ));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Create Products - ';
    $meta_single_page_desc = 'Create Products - ';
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
                                <h3>Add Product</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-adding">
                                    
                                    <form class="form add-product-form" data-action-after=2 data-redirect-url="" method="POST"
                                            action="<?php echo URL ?>products/ajax/controller/createProductController.php">

                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-3">                                                    
                                                    <div class="row" id="sub_categories_fields">                                                        
                                                        <div class="col-lg-12 category_box">
                                                            <select class="form-control select2" onchange="loadSubCatForPro(this)" data-level="1" name="sub_category[]">
                                                                <option selected disabled value="0"> Select Category</option>
                                                                
                                                                <?php foreach ($catg_list as $key => $value) {?>
                                                                    <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-lg-9">
                                                    <div class="row">

                                                        <div class="col-md-8 container-form">
                                                            <div class="form-group form-label-group row">
                                                                <input type="text" class="form-control" name="name" placeholder="">
                                                                <label class="col-form-label">Name </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 container-form">
                                                            <div class="form-group form-label-group row">
                                                                <input type="text" class="form-control" name="min_ord_qty" placeholder="" required>
                                                                <label class="col-form-label">Minimum Order Qty </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-lg-12">
                                                            <div class="description-sm">
                                                                <textarea class="form-control" id="description" name="description" cols="6" rows="10" placeholder=""></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-lg-12">
                                                            <div class="form-group form-label-group row">
                                                                <input type="text" class="form-control" name="3d_link" placeholder="" required>
                                                                <label class="col-form-label">3D Link </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row offset-3 mt-3">
                                                    <div class="col-md-6">
                                                        <label for="">Upwards Status(Disable if you don't want to show the text)</label>
                                                        <div class="switch-field">                                                        
                                                            <input type="radio" id="radio-one" name="upwards" value="1" />
                                                            <label for="radio-one">Yes</label>
                                                            <input type="radio" id="radio-two" name="upwards" value="0" />
                                                            <label for="radio-two">No</label>
                                                        </div>
                                                    </div>                                                    

                                                    <div class="col-md-6 text-right">
                                                        <input type="hidden" name="create_product">
                                                        <a href="<?php echo URL ?>products/products.php" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
                                                        <button class="btn btn-primary submit_form_no_confirm" 
                                                                data-notify_type=2 
                                                                data-validate=0 
                                                                type="button">Create</button>
                                                    </div>                                                    
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

    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>

<script src="<?php echo URL ?>assets/js/pages/products.js"></script>

</body>
</html>
