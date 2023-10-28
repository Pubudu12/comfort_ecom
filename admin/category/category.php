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
    
    $meta_single_page_title = 'Categories - ';
    $meta_single_page_desc = 'Categories - ';
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
                                <h3>Category</h3>
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

                            <div class="col-xs-12 col-md-4 col-lg-3">

                                <select id="category_level" class="form-control select2 order_filter" onchange="categoryListDatatable()">
                                    <?php 
                                    foreach ($categoryLevel as $key => $value) {
                                        echo '<option value="'.$value['level'].'">'.$value['name'].'</option>';
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="col-xs-12 col-md-8 col-lg-9 offset-3 text-right">
                                <a href="<?php echo URL ?>category/createCategory.php" class="btn btn-secondary create-btn1"> Create Category</a>
                                <br>&nbsp;
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" 
                                        id="products-list_table" 
                                        data-url = '<?php echo URL ?>category/ajax/category-list.php'
                                        onchange="categoryListDatatable()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Name</th>
                                            <th>Thumb</th>
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

        <input type="hidden" id="dataTableRefresh" onclick="categoryListDatatable()">

        <!-- footer start-->
       <?php include_once ROOT_PATH.'imports/footer.php'?>
        <!-- footer end-->
    </div>

</div>
<?php include_once ROOT_PATH.'imports/js.php'?>

<script>
function categoryListDatatable(){

    var tableName = 'products-list_table';
    var actionUrl = $('#'+tableName).data('url');

    var catLevel = $("#category_level").val();        
    var postData = { 
        'categoryList': 'yes',
        'cat_level': catLevel
    };

    ajaxDataTableLoad(tableName, actionUrl, postData);

} //categoryListDatatable

categoryListDatatable();
</script>

</body>
</html>
