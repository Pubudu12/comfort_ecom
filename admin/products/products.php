<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';


$sub_categories_list = array();
$sub_category_query = " SELECT cat.`id`, cat.`name`, COUNT(p.`id`) AS proCounts
                        FROM `categories` AS cat
                        INNER JOIN `products` AS p ON p.`sub_category` = cat.`id` 
                        WHERE cat.`level` = '1'
                        GROUP BY p.`sub_category` ";

$sub_categories = mysqli_query($localhost, $sub_category_query);
while($fetch_categories = mysqli_fetch_array($sub_categories)){
    array_push($sub_categories_list, array(
        'id' => $fetch_categories['id'],
        'name' => $fetch_categories['name'],
        'proCounts' => $fetch_categories['proCounts'],
    ));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Products - ';
    $meta_single_page_desc = 'Products - ';
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
                                <h3>Product List</h3>
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

                                <select id="sub_category_id" class="form-control select2 order_filter" onchange="productListDatatable()">
                                    <option value="0">All</option>
                                    <?php 
                                    foreach ($sub_categories_list as $key => $value) {
                                        echo '<option value="'.$value['id'].'">'.$value['name'].' ('.$value['proCounts'].')</option>';
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="col-xs-12 col-md-8 col-lg-9 text-right">
                                <a href="<?php echo URL ?>products/create_product.php" class="btn btn-secondary create-btn1"> Create Product</a>
                                <br>&nbsp;
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" 
                                        id="products-list_table" 
                                        data-url = '<?php echo URL ?>products/ajax/products-list.php'
                                        onchange="productListDatatable()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Thumb</th>
                                            <th>name</th>
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

        var subCategoryId = $("#sub_category_id").val(); 
        var postData = { 
            'productList': 'yes',
            'sub_category': subCategoryId,
        };

        ajaxDataTableLoad(tableName, actionUrl, postData);
    }

    productListDatatable();

</script>

</body>
</html>

