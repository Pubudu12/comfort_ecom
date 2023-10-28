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
    
    $meta_single_page_title = 'Size Category- ';
    $meta_single_page_desc = 'Size Category- ';
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
                                <h3>Product Size Category</h3>
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

                            <div class="col-xs-12 col-md-8 col-lg-9 offset-3 text-right">
                                <a href="<?php echo URL ?>sizeCategories/create.php" class="btn btn-secondary create-btn1"> Create Size Category</a>
                                <br>&nbsp;
                            </div>
                          

                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" 
                                        id="products-list_table" 
                                        data-url = '<?php echo URL ?>sizeCategories/ajax/size-list.php'
                                        onchange="sizeListDatatable()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Size Category</th>
                                            <th>Actions</th>
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

        <input type="hidden" id="dataTableRefresh" onclick="sizeListDatatable()">

        <!-- footer start-->
       <?php include_once ROOT_PATH.'imports/footer.php'?>
        <!-- footer end-->
    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>

<script>
function sizeListDatatable(){

    var tableName = 'products-list_table';
    var actionUrl = $('#'+tableName).data('url');
    
    var postData = { 
        'sizeLisr': 'yes',
        // 'cat_level': catLevel
    };

    ajaxDataTableLoad(tableName, actionUrl, postData);

} //sizeListDatatable

sizeListDatatable();
</script>

</body>
</html>
