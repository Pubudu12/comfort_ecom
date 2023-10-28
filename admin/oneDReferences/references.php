<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';


$ref_master_id = 0;
if(isset($_GET['id'])){

    if(is_numeric($_GET['id'])){
        $ref_master_id = $_GET['id'];
    }
}

$select = mysqli_query($localhost, "SELECT * FROM `references_master_list` WHERE `id` = '$ref_master_id' ");
$fetch = mysqli_fetch_array($select);

$name = $fetch['name'];
$ref_master_id = $fetch['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = $name.' - Reference List - ';
    $meta_single_page_desc = $name.' - Reference List - ';
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
                                <h3>Brands List</h3>
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

                            <div class="col-12 text-right">
                                <a href="<?php echo URL ?>ref/1d/create?id=<?php echo $ref_master_id ?>&c=<?php echo $fetch['code'] ?>" class="btn btn-secondary create-btn1"> Create Brand </a>
                                <br>&nbsp;
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" 
                                        id="references-list_table" 
                                        data-url = '<?php echo URL ?>oneDReferences/ajax/oneDReferencesList.php'
                                        onchange="referenceListDatatable()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Action</th>
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

<input type="hidden" id="dataTableRefresh" onclick="referenceListDatatable()">

<script>
    function referenceListDatatable(){

        var tableName = 'references-list_table';
        var actionUrl = $('#'+tableName).data('url');
        var refId = '<?php echo $ref_master_id ?>';
        var refCode = '<?php echo $fetch['code'] ?>';

        var postData = { 
            'ref_code' : refCode,
            'ref_id': refId,
            'reference_list': 'yes',
        };

        ajaxDataTableLoad(tableName, actionUrl, postData);
    }

    referenceListDatatable();

</script>

</body>
</html>
