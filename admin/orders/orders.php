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
    
    $meta_single_page_title = 'Orders - ';
    $meta_single_page_desc = 'Orders - ';
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
                                <h3>Orders List</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body"> 
                        <div class="row">

                            <div class="col-lg-12">

                                <div class="row">

                                    <div class="col-md-4 col-lg-3">
                                        <label for="">Order Status</label>
                                        <select id="order_status" onchange="orderListDatatable()" class="form-control select2">
                                            <option value="all">All</option>
                                            <option value="pending" selected>Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="returned">Returned</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <label for="">Payment Status</label>
                                        <select id="payment_status" onchange="orderListDatatable()" class="form-control select2">
                                            <option value="all">All</option>
                                            <option value="paid">Paid</option>
                                            <option value="unpaid">Unpaid</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <label for="">Customer Type</label>
                                        <select id="customer_type" onchange="orderListDatatable()" class="form-control select2">
                                            <option value="all">All</option>
                                            <option value="std">Standard</option>
                                            <option value="guest">Guest</option>
                                            <option value="dealer">Dealer</option>
                                        </select>
                                    </div>

                                </div>

                                </div>
                                <br>&nbsp;

                                <div class="col-xs-12 table-responsive">

                                <table class="dataTableCall" 
                                        id="orders_list_table" 
                                        data-url = '<?php echo URL ?>orders/ajax/orders_list.php'
                                        onchange="orderListDatatable()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Order No</th>
                                            <th>Customer Name</th>
                                            <th>Customer Type</th>
                                            <th>Date</th>
                                            <th class="text-right">Total</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Payment</th>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">Refunds</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                    </tbody>
                                </table>

                            </div> <!-- ./ col-12 -->

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
<script src="<?php echo URL ?>assets/js/pages/orders.js"></script>


</body>
</html>
