<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

$product_id = 0;
if(isset($_GET['id'])){

    if(is_numeric($_GET['id'])){
        $product_id = $_GET['id'];
    }
}
$select_pro = mysqli_query($localhost,"SELECT `id`, `name` FROM `products` WHERE `id`='$product_id'");
$fetch_pro = mysqli_fetch_array($select_pro);
$product_id = $fetch_pro['id'];

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
    
    $meta_single_page_title = 'Product Description - ';
    $meta_single_page_desc = 'Products Description - ';
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
                            <div class="text-center">
                                <h3><?php echo $fetch_pro['name'] ?>
                                    <small>Product Description</small>
                                </h3>
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
                                <div class="product-adding" id="section_area">

                                    <?php 
                                    foreach ($contentHtmlArray as $key => $content) {
                                        echo $content;
                                    }
                                    ?>
                                    
                                </div>
                            </div>


                            <div class="col-lg-12 text-center">
                                <br><br>
                                <button class="btn btn-primary" onclick="addNewSec()">Add New Section</button>
                                <br><br>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>

        <input type="hidden" id="product_id" value="<?php echo $product_id ?>">

        <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>

    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>

<script src="<?php echo URL ?>assets/vendor/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo URL ?>assets/vendor/summernote/summerNoteFun.js"></script>

</body>
</html>