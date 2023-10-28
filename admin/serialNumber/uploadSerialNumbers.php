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
        
        $meta_single_page_title = 'Serial Number ';
        $meta_single_page_desc = 'Serial Number ';
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
                                <h3>Serial Number</h3>
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
                                <!-- <div class="col-lg-12"> -->
                                    <form id="upload_csv" method="post" class="forms-sample" data-action-after=1 data-redirect-url="" enctype="multipart/form-data">
                                        <div class="col-12 text-right offset-5">
                                            <div class="col-md-12 col-xl-7 col-lg-">  
                                                <a href="<?php echo URL?>serialNumber/ajax/controller/createSerialController.php?path=samplecsv.csv" name="download" id="download" value="Download Sample" class="btn btn-primary"><i class="fa fa-download"></i>&nbsp; Download Sample</a>
                                            </div>  
                                        </div>
                                        <div class="row mt-3">
                                            <div class="form-group col-md-12 col-lg-6 col-xl-6">
                                                <label>Select File <b>.csv only</b> </label>
                                                <label><b>NOTE : </b> Make sure to remove empty rows of the file and upload.</label>
                                                <input type="file" name="csv_file" id="csv_file" accept=".csv"/>
                                            </div>
                                            <div class="col-md-12 col-xl-6 col-lg-6">  
                                                <input type="hidden" name="csv_file_upload">
                                                <input type="submit" name="upload" id="upload" value="Validate" class="btn btn-primary" />
                                            </div>  
                                        </div>
                                        <div id="tableData" class="mt-4 hide">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th>Name</th>
                                                    <th>Serial Number</th>
                                                    <th>Message</th>
                                                </thead>
                                                <tbody id="csv_data_table">
                                                    
                                                </tbody>
                                            </table>
                                            <input type="hidden" name="serialArray[]" id="serialArray" value="">
                                            <button type="button" class="btn btn-primary" id="upload_data">Upload</button>
                                        </div>
                                    </form>
                                <!-- </div> -->
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
<script src="<?php echo URL ?>assets/js/pages/serialNumber.js"></script>
</body>
</html>