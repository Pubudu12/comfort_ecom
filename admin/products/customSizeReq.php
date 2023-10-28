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
    
    $meta_single_page_title = 'Custom Size Requests - ';
    $meta_single_page_desc = 'Custom Size Requests - ';
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
                                <h3>Custom Size Requests</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="col-md-12 card">
                    <div class="col-md-12 card-body"> 

                        <div class="row">

                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" 
                                        id="products-list_table" 
                                        data-url = '<?php echo URL ?>products/ajax/sizeReq-list.php'
                                        onchange="productListDatatable()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Mail</th>
                                            <th>Contact No</th>
                                            <th>Created at</th>
                                            <th>Requested Size</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
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

<script>
    function productListDatatable(){

        var tableName = 'products-list_table';
        var actionUrl = $('#'+tableName).data('url');

        var postData = { 
            'sizeRequests': 'yes',
        };

        ajaxDataTableLoad(tableName, actionUrl, postData);
    }

    productListDatatable();

</script>

</body>
</html>

