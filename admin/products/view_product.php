<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

require_once ROOT_PATH.'imports/functions.php';
$gump = new GUMP();

$product_id = 0;
if (isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {
        $product_id = $_GET['id'];
    }
}

$sizeArray = array();
$select_size = mysqli_query($localhost,"SELECT * FROM `sizes` ");
if(mysqli_num_rows($select_size) > 0){
    while($fetch_size = mysqli_fetch_array($select_size)){
        array_push($sizeArray,array(
            'id'=>$fetch_size['id'],
            'name'=>$fetch_size['name'],
        ));
    }
}

// $fetch_size = $gump->sanitize($fetch_size); 

$select_pro = mysqli_query($localhost,"SELECT p.*, cat.`name` AS category, cat.`level` catlevel
                                        FROM `products` AS p 
                                        INNER JOIN `categories` AS cat ON cat.`id` = p.`sub_category`
                                        WHERE p.`id`='$product_id'");
$fetch_pro = mysqli_fetch_array($select_pro);
$fetch_pro = $gump->sanitize($fetch_pro); 

$sanitized_query_data = $gump->run($fetch_pro);

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


$images_array = array();
$select_all_images = mysqli_query($localhost,"SELECT * FROM `product_images` WHERE `product_id`='$product_id' ORDER BY `id` ASC ");
while($fetch_all_images = mysqli_fetch_array($select_all_images)){

    array_push($images_array, URL.PRO_IMG_PATH.$fetch_all_images['name']);

}

$product_name = $sanitized_query_data['name'];

$contentArray = array();
$selectContent = mysqli_query($localhost, "SELECT * FROM `product_body` WHERE `product_id` = '$product_id' ORDER BY `order` ASC ");
if(mysqli_num_rows($selectContent) > 0){

    while($fetchContent = mysqli_fetch_array($selectContent)){
        array_push($contentArray, array(
            'row_id' => $fetchContent['id'],
            'title' => $fetchContent['title'],
            'order' => $fetchContent['order'],
            'details' => $fetchContent['details'],
        ));
    }

} // If num rows End 

$contentHtmlArray = array();
$contentHtmlFile = file_get_contents(ROOT_PATH.'products/container/productDetailsSectionBox.html');
foreach ($contentArray as $key => $singleContentArray) {
    
    $tempFile = $contentHtmlFile;

    $tempFile = str_replace('{{ ROW_ID }}', $singleContentArray['row_id'], $tempFile);
    $tempFile = str_replace('{{ TITLE }}', $singleContentArray['title'], $tempFile);
    $tempFile = str_replace('{{ ORDER }}', $singleContentArray['order'], $tempFile);
    $tempFile = str_replace('{{ CONTENT }}', $singleContentArray['details'], $tempFile);

    array_push($contentHtmlArray, $tempFile);

} // Foreach End


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';

    $meta_single_page_title = $product_name.' | View Product - ';
    $meta_single_page_desc = $product_name.' | View Product - ';
    include_once ROOT_PATH.'app/meta/meta_more_details.php'; 

    include_once ROOT_PATH.'imports/css.php';
    ?>

    <link rel="stylesheet" href="<?php echo URL ?>assets/vendor/summernote/summernote-bs4.min.css">

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
                        <div class="col-lg-12">
                            <div class="page-header-left">
                                <h3><?php echo $product_name ?>
                                    <small>Product Detail</small>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id ?>">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="card">

                    <div class="floating_btn_bar">
                        <label>Active</label>

                        <div class="switch-field">
                            <input type="radio" id="radio-one" name="switch-one" onchange="changeProductVerification(this)" <?php echo checkboxChecked($fetch_pro['active'], 1) ?> value="<?php echo $product_id ?>"/>
                            <label for="radio-one">Yes</label>
                            <input type="radio" id="radio-two" name="switch-one" onchange="changeProductVerification(this)" <?php echo checkboxChecked($fetch_pro['active'], 0) ?> value="<?php echo $product_id ?>" />
                            <label for="radio-two">No</label>
                        </div>


                        <a href="<?php echo URL?>products/edit_product.php?id=<?php echo $product_id ?>" class="btn btn-primary btn-sm colour-blue mr-1"> <i class="fa fa-edit"></i></a>
                        <a href="<?php echo URL?>products/upload_images.php?id=<?php echo $product_id ?>" class="btn btn-primary btn-sm colour-blue mr-1"><i class="fa fa-upload"></i> Change Images</a>
                        <a href="<?php echo URL?>products/assignSerialNumbers.php?id=<?php echo $product_id ?>" class="btn btn-primary colour-blue btn-sm mr-1"><i class="fa fa-list-alt"></i></a>
                        <a href="<?php echo URL?>products/assignDealers.php?id=<?php echo $product_id ?>" class="btn btn-primary colour-blue btn-sm"><i class="fa fa-users"></i></a>
                        <button  class="btn btn-danger btn-sm colour-red ml-1"
                            onclick="deleteItem(this)"
                            data-after-success=2
                            data-id='<?php echo $product_id ?>' 
                            data-refresh='<?php echo URL ?>products/products.php' 
                            data-url="<?php echo URL ?>products/ajax/controller/deleteProductController.php" 
                            data-key="delete_product"> <i class="fa fa-trash"></i></button>
                    </div>

                    <div class="row product-page-main card-body">
                    
                        <div class="col-xl-4">
                            <div class="product-slider owl-carousel owl-theme" id="sync1">
                                <?php 
                                foreach ($images_array as $key => $imgUrl) { ?>
                                    <div class="item"><img src="<?php echo $imgUrl ?>" alt="" class="blur-up lazyloaded"></div>
                                <?php } ?>
                            </div>
                            <div class="owl-carousel owl-theme" id="sync2">
                                <?php 
                                foreach ($images_array as $key => $imgUrl) { ?>
                                    <div class="item"><img src="<?php echo $imgUrl ?>" alt="" class="blur-up lazyloaded"></div>
                                <?php } ?>
                            </div>
                        </div>


                        <div class="col-xl-8">
                            
                            <div class="row">
                                <div class="col-12 product-page-details product-right mb-0">

                                    <h2><?php echo $fetch_pro['name']?></h2>
                                    <h5><?php echo $fetch_pro['category']?></h5>
                                    <h6><?php echo $sub_name ?></h6>
                                    <h4>Minumum Order Qty: <?php echo $fetch_pro['min_order_qty']?></h4>
                                    <hr>
                                    <?php if (isset($fetch_pro['description'])) {?>
                                        <h6><?php echo $fetch_pro['description']?></h6>
                                    <?php } ?>
                                </div>

                                <div class="col-lg-12">
                                    <?php //include_once ROOT_PATH.'products/includes/oneDReferenceUpdate.php' ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <?php include_once ROOT_PATH.'products/includes/stockDetails.php' ?>
                        </div>

                        
                        <div class="col-lg-12 container product-adding" id="section_area">
                            <?php 
                            foreach ($contentHtmlArray as $key => $content) {
                                echo $content;
                            }
                            ?>
                        </div>

                        <div class="col-lg-12 text-center">
                            <br><br>
                            <button class="btn btn-primary" onclick="addNewSec()">Add New Section</button>
                            <br><br>
                        </div>

                    </div>

                </div>
            </div>
            <!-- Container-fluid Ends-->

        <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>
    </div>
</div>

<?php include_once ROOT_PATH.'imports/js.php'?>
<script src="<?php echo URL ?>assets/js/pages/productDetails.js"></script>

<script src="<?php echo URL ?>assets/vendor/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo URL ?>assets/vendor/summernote/summerNoteFun.js"></script>

</body>
</html>
