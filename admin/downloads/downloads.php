<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

$categoryLevel = array();
for ($i=1; $i <= CAT_MAX_LEVEL; $i++) { 
    array_push($categoryLevel, [
        'level' => $i, 'name' => 'Level '.$i
    ]);
}

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
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>Downloads</h3>
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
                            <div class="col-lg-12 text-right">
                                <a href="<?php echo URL ?>downloads/file/upload" class="btn btn-secondary create-btn1"> Upload New File</a>
                                <br>&nbsp;
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" 
                                        id="downloads-list_table" 
                                        data-url = '<?php echo URL ?>downloads/ajax/downloads-list.php'
                                        onchange="downloadListDatatable()">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>description</th>
                                            <th>Image</th>
                                            <th id="sort">created</th>
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

        <input type="hidden" id="dataTableRefresh" onclick="downloadListDatatable()">

        <!-- footer start-->
       <?php include_once ROOT_PATH.'imports/footer.php'?>
        <!-- footer end-->
    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>

<script>
function downloadListDatatable(){

    var tableName = 'downloads-list_table';
    var actionUrl = $('#'+tableName).data('url');

    var postData = { 
        'download': 'yes',
    };

    ajaxDataTableLoad(tableName, actionUrl, postData);

} //categoryListDatatable

downloadListDatatable();
</script>

</body>
</html>
