<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';
$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';
$gump = new GUMP();

$product_id = 0;
if(isset($_GET['id'])){

    if(is_numeric($_GET['id'])){
        $product_id = $_GET['id'];
    }
}
$select_pro = mysqli_query($localhost,"SELECT p.*, cat.`name` AS category, cat.`level` catlevel
                                        FROM `products` AS p 
                                        INNER JOIN `categories` AS cat ON cat.`id` = p.`sub_category`
                                        WHERE p.`id`='$product_id'");
$fetch_pro = mysqli_fetch_array($select_pro);
// $fetch_pro = ; 
$name = $gump->sanitize($fetch_pro);
$sanitized_query_data = $gump->run($name);

$cat_level = $fetch_pro['catlevel'];
$sub_category_id = $fetch_pro['sub_category'];

$categoryFetchQuery ="SELECT cat1.`name` cat1, cat1.`id` ";

if($cat_level > 1){

    for ($i=2; $i <= $cat_level; $i++) { 
        $categoryFetchQuery .= ", cat".$i.".`name` AS cat".$i." ";
    }
    
}

$categoryFetchQuery .= "   FROM `categories` AS cat1 ";

if($cat_level > 1){

    for ($i=2; $i <= $cat_level; $i++) {
        $categoryFetchQuery .= " LEFT JOIN `categories` AS cat".$i." ON cat".$i.".`id` = cat".($i-1).".`parent` ";
    }
    
}
   
$categoryFetchQuery .= " WHERE cat1.`level` = '$cat_level' and cat1.`id` = '$sub_category_id' ";

$categorySelect = mysqli_query($localhost, $categoryFetchQuery);
while($categoryFetch = mysqli_fetch_array($categorySelect) ){
    
    $sub_name = '';
    if($cat_level > 1){
    
        $sub_name .= "<br>";
    
        for ($i=2; $i <= $cat_level; $i++) {
            $temColName = "cat".$i; 
            $sub_name .= "<small> <i class='fa fa-chevron-left'></i> ".$categoryFetch[$temColName]."</small>";
            $categoryFetchQuery .= ", cat".$i.".`name` AS cat".$i." ";
        }
        
    }

} // While end 


$catg_list = array();
$maxCatLevel = CAT_MAX_LEVEL;
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
    
    $meta_single_page_title = 'Update Product - ';
    $meta_single_page_desc = 'Update Product - ';
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
                                <h3>Update Product</h3>
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
                                            action="<?php echo URL ?>products/ajax/controller/updateProductController.php">

                                        <div class="col-xl-12">
                                            <div class="row">

                                                <div class="col-md-6 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="name" value="<?php echo $sanitized_query_data['name'] ?>" placeholder="">
                                                        <label class="col-form-label">Name </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="min_ord_qty" value="<?php echo $fetch_pro['min_order_qty'] ?>" placeholder="" required>
                                                        <label class="col-form-label">Minimum Order Qty </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 container-form">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="product_code" value="<?php echo $fetch_pro['item_code'] ?>" placeholder="">
                                                        <label class="col-form-label">Product Code </label>
                                                    </div>
                                                </div>

                                                <!--<div class="col-md-4 container-form mt-3 mb-3">
                                                    <label for="">Category</label>
                                                    <div class="form-group form-label-group row">
                                                        <select name="sub_category" id="category_list" class="form-control custom-select select2" required="">
                                                            <option value="0" selected disabled>Select Category</option>
                                                                <?php foreach ($catg_list as $key => $value) { ?>
                                                                    <option value="<?php echo $value['id'] ?>" <?php echo comboboxSelected($value['id'], $fetch_pro['sub_category']) ?>> <?php echo $value['name'] ?> </option>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>-->

                                                <div class="col-md-12 container-form mt-5 mb-3">
                                                    <div class="form-group form-label-group row">
                                                        <input type="text" class="form-control" name="3d_link" value="<?php echo $fetch_pro['3d_link'] ?>" placeholder="">
                                                        <label class="col-form-label">3D Link </label>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-12 col-lg-12">
                                                    <div class="description-sm">
                                                        <textarea class="form-control" id="description" name="description" cols="6" rows="10" placeholder=""><?php echo $fetch_pro['description']?></textarea>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-12">                                                
                                                    <h5>
                                                        <?php echo $fetch_pro['category']?>
                                                        <small><?php echo $sub_name ?></small>
                                                    </h5>

                                                    <div class="form-group">
                                                        <input type="checkbox" id="enableCategoryEdit" name="change_category_checkbox" onchange="enableChangeCategory()"> Change Category
                                                    </div>
                                                    
                                                    <div class="col-4 hide" id="">
                                                    
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
                                                </div> -->

                                                <div class="col-12 mt-3">
                                                    <div class="">
                                                        <label for="">Upwards Status(Disable if you don't want to show the text)</label>
                                                        <div class="switch-field">                                                        
                                                            <input type="radio" id="radio-one" <?php echo checkboxChecked($fetch_pro['upwards_status'], 1) ?> name="upwards" value="1" />
                                                            <label for="radio-one">Yes</label>
                                                            <input type="radio" id="radio-two" <?php echo checkboxChecked($fetch_pro['upwards_status'], 0) ?> name="upwards" value="0" />
                                                            <label for="radio-two">No</label>
                                                        </div>
                                                    </div>

                                                    <div class=" text-right">
                                                        <input type="hidden" name="update_product" value="<?php echo $product_id ?>">
                                                        <a href="<?php echo URL ?>products/products.php" class="btn btn-transprent"> <i class="fa fa-chevron-left"></i> Back</a>
                                                        <button class="btn btn-primary submit_form_no_confirm" 
                                                                data-notify_type=2 
                                                                data-validate=0 
                                                                type="button">Update</button>
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