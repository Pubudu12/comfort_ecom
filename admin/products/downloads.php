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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Product Downloads - ';
    $meta_single_page_desc = 'Product Downloads - ';
    include_once ROOT_PATH.'app/meta/meta_more_details.php'; 
    
    include_once ROOT_PATH.'imports/css.php';

    $pdfFilesArray = array();
    $pdfBox = file_get_contents(ROOT_PATH.'products/container/pdfContainer.html');
    $deleteURL = URL.'products/ajax/controller/deleteProductController.php';
    
    $selectFile = mysqli_query($localhost, "SELECT * FROM `pro_downloads` WHERE `product_id` = '$product_id' ");
    while($fetchFile = mysqli_fetch_array($selectFile)){
        $tempBox = $pdfBox;

        $fileLink = URL.PRO_DOWNLOAD_PATH.$fetchFile['file_name'];
        $tempBox = str_replace("{{ FILE_LINK }}", $fileLink, $tempBox);
        $tempBox = str_replace("{{ FILE_NAME }}", $fetchFile['name'], $tempBox);
        $tempBox = str_replace("{{ ID }}", $fetchFile['id'], $tempBox);
        $tempBox = str_replace("{{ DELETE_URL }}", $deleteURL, $tempBox);
        

        array_push($pdfFilesArray, $tempBox);

    }

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
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h3><?php echo $fetch_pro['name'] ?>
                                    <small>Manage Downloads</small>
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
                                <div class="col-lg-12 product-adding">

                                    <?php 
                                    foreach ($pdfFilesArray as $key => $pdfFile) {
                                        echo $pdfFile;
                                    }
                                    ?>
                                    
                                </div>

                                <div class="col-lg-4">
                                    <form class="forms-sample" 
                                            data-action-after=1 
                                            data-redirect-url="" 
                                            method="POST" 
                                            id="package_images_form"
                                            action="<?php echo URL ?>products/ajax/controller/createProductController.php">

                                        <div class="form-group text-center">
                                            <input type="text" name="name" class="form-control" placeholder="Name">
                                            <br><br>
                                            <p>Select File <b>.pdf only</b> </p>                                            
                                            <input type="file" name="pdf_document" class="file-upload-default " id="pack_img_upload">
                                        </div>
                                        <div class="text-center">
                                            <input type="hidden" name="upload_document" value="<?php echo $product_id ?>">

                                            <button class="btn btn-primary submit_form_no_confirm" 
                                                    data-notify_type=2 
                                                    data-validate=0 
                                                    type="button">Upload</button>

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

        <input type="hidden" id="product_id" value="<?php echo $product_id ?>">

        <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>

    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>

</body>
</html>