<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        include_once ROOT_PATH.'app/meta/meta.php';
        
        $meta_single_page_title = 'Downloads - ';
        $meta_single_page_desc = 'Downloads - ';
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
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h3>Downloads</h3>
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

                                <div class="col-lg-4">
                                    <form class="forms-sample" 
                                            data-action-after=1 
                                            data-redirect-url="" 
                                            method="POST" 
                                            id="package_images_form"
                                            action="<?php echo URL ?>downloads/ajax/controller/createDownloadsController.php">

                                        <div class="form-group text-center">

                                            <img src="" alt="Preview" id="img_preview" class="img-fluid">
                                            <input type="file" id="imgInp" name="img_preview">
                                            <input type="text" name="name" class="form-control" placeholder="Name">
                                            <br>
                                            <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                            <br><br>
                                            <p>Select File <b>.pdf, .docs only</b> </p>
                                            <input type="file" name="pdf_document" class="file-upload-default " id="pack_img_upload">
                                        </div>
                                        <div class="text-center">
                                            <input type="hidden" name="upload_file_downloads">

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


<script>


    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
        $('#img_preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
    }

    $("#imgInp").change(function() {
    readURL(this);
    });

</script>

</body>
</html>