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
    
    $meta_single_page_title = 'Promo Code List';
    $meta_single_page_desc = 'Promo Code List';
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
                                <h3>Promo Code List
                                </h3>
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
                                <a href="<?php echo URL?>promo/create" class="btn btn-secondary create-btn1"> Create Promo Code</a>
                                <br>&nbsp;
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" id="promo_code_list" data-url = '<?php echo URL ?>promoCodes/ajax/promoCodeList.php' onchange="promoCodeList()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Start Date</th>
                                            <th>Expire Date</th>
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

<input type="hidden" id="dataTableRefresh" onclick="promoCodeList()">

<script>
    function promoCodeList(){

        var tableName = 'promo_code_list';
        var actionUrl = $('#'+tableName).data('url');

        var postData = { 
            'promo_list': 'yes',
        };

        ajaxDataTableLoad(tableName, actionUrl, postData);
    }

    promoCodeList();

</script>

</body>
</html>
