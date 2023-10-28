<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

$catArray = array();
$categories = mysqli_query($localhost,"SELECT `id`, `name` FROM `product_size_categories` ");
while($fetch_categ = mysqli_fetch_array($categories)){
    array_push($catArray,array(
        'id'=>$fetch_categ['id'],
        'name'=>$fetch_categ['name'],
    ));
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Sizes - ';
    $meta_single_page_desc = 'Sizes - ';
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
                                <h3>Product Sizes</h3>
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
                                    <select id="size_category" class="form-control select2 order_filter" onchange="sizeListDatatable()">
                                        <option value="0" selected>All</option>
                                       <?php 
                                        foreach ($categories as $key => $value) {?>
                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-xs-12 col-md-8 col-lg-9 text-right">
                                    <a href="<?php echo URL ?>size/create" class="btn btn-secondary create-btn1"> Create Size</a>
                                    <br>&nbsp;
                                </div>                                
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-12 col-sm-12">
                                    <table class="dataTableCall" 
                                            id="products-list_table" 
                                            data-url = '<?php echo URL ?>proSizes/ajax/size-list.php'
                                            onchange="sizeListDatatable()">
                                        <thead>
                                            <tr>
                                                <th id="sort">#</th>
                                                <th>Size</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
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
    var category = $("#size_category").val();   

    var postData = { 
        'sizeLisr': 'yes',
        'category': category
    };

    ajaxDataTableLoad(tableName, actionUrl, postData);

} //sizeListDatatable

sizeListDatatable();
</script>

</body>
</html>
