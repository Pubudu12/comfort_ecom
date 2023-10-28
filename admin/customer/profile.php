<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

require_once ROOT_PATH.'imports/functions.php';
$user_id = 0;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['id'])){
        if(is_numeric( trim($_GET['id']) )){
            $user_id = mysqli_real_escape_string($localhost, $_GET['id']);
        }
    } // isset of order_no
}// request method

$select_user = mysqli_query($localhost,"SELECT u.*, l.`active` 
                                            FROM `users` u 
                                            INNER JOIN `login` l ON l.`access_token`=u.`access_token` 
                                            WHERE u.`id`='$user_id' ");
$fetch_users = mysqli_fetch_array($select_user);

$active = "";
if($fetch_users["active"] == 1){
    $active = '<i class="text-success fa fa-circle"></i>';
}else{
    $active = '<i class="text-danger fa fa-circle"></i>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Customer Profile - ';
    $meta_single_page_desc = 'Customer Profile - ';
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
                                <h3> <span style="color:silver">View Profile of </span> <?php echo $fetch_users['name'] ?></h3>
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

                            <div class="col-xs-12 col-md-6">
                                
                                <table class="table table-stripped table-condensed no-border">

                                    <tr>
                                        <td>Name</td>
                                        <td> : </td>
                                        <td> <?php echo $active. " ".$fetch_users['name'] ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Email</td>
                                        <td> : </td>
                                        <td> <?php echo $fetch_users['email'] ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Mobile No</td>
                                        <td> : </td>
                                        <td> <?php echo $fetch_users['mobile_no'] ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Contact No</td>
                                        <td> : </td>
                                        <td> <?php echo $fetch_users['contact_no'] ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Permanent Address</td>
                                        <td> : </td>
                                        <td> <?php echo $fetch_users['p_door_no'].", ".$fetch_users['p_city'].", ".$fetch_users['p_state'].", ".$fetch_users['p_zip_code'] ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Temporary Address</td>
                                        <td> : </td>
                                        <td> <?php echo $fetch_users['t_door_no'].", ".$fetch_users['t_city'].", ".$fetch_users['t_state'].", ".$fetch_users['t_zip_code'] ?> </td>
                                    </tr>
                                </table>

                            </div>


                            <div class="col-xs-12 col-md-6">

                                <?php 
                                $select_total_orders = mysqli_query($localhost,"SELECT SUM(o.`total`) AS total, SUM(o.`payment`) payment, COUNT(uh.`id`) counts FROM `user_std_order_history` AS uh INNER JOIN `orders` o ON o.`order_no` = uh.`order_no` WHERE uh.`user_id`='$user_id' ");
                                $fetch_total_orders = mysqli_fetch_array($select_total_orders);
                                $total_orders = $fetch_total_orders['counts']; ?>
                                
                                <table class="table table-stripped table-condensed">

                                    <tr>
                                        <td>Total Orders</td>
                                        <td> : </td>
                                        <td> <?php echo $total_orders ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Total Purchased</td>
                                        <td> : </td>
                                        <td> <?php echo CURRENCY." <b>".number_format($fetch_total_orders['total'],2)."</b>" ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Total Paid</td>
                                        <td> : </td>
                                        <td> <?php echo CURRENCY." <b>".number_format($fetch_total_orders['payment'],2)."</b>" ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Total Balance</td>
                                        <td> : </td>
                                        <td> <?php echo CURRENCY." <b>".number_format( ($fetch_total_orders['total'] - $fetch_total_orders['payment']) ,2)."</b>" ?> </td>
                                    </tr>

                                </table>

                            </div>


                            <div class="col-12">
                            
                                <div class="row">
                                
                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="">Order Status</label>
                                        <select id="order_status" class="form-control select2" onchange="cusOrdersListDatatable()">
                                            <option value="all">All</option>
                                            <option value="pending">Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="returned">Returned</option>
                                        </select>
                                    </div>

                                    <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="">Payment Status</label>
                                        <select id="payment_status" class="form-control select2" onchange="cusOrdersListDatatable()">
                                            <option value="all">All</option>
                                            <option value="paid">Paid</option>
                                            <option value="unpaid">Unpaid</option>
                                        </select>
                                    </div>

                                    <!-- <div class="col-xs-12 col-md-4 col-lg-3">
                                        <label for="">Customer Type</label>
                                        <select id="customer_type" class="form-control select2" onchange="cusOrdersListDatatable()">
                                            <option value="all">All</option>
                                            <option value="std">Standard</option>
                                            <option value="guest">Guest</option>
                                            <option value="dealer">Dealer</option>
                                        </select>
                                    </div> -->

                                </div>

                                <br>&nbsp;

                            </div>

                            <div class="col-md-12 col-sm-12">
                                <table class="dataTableCall" 
                                        id="customers_order_list_table" 
                                        data-url = '<?php echo URL ?>orders/ajax/orders_list.php'
                                        onchange="cusOrdersListDatatable()">
                                    <thead>
                                        <tr>
                                            <th id="sort">#</th>
                                            <th>Order No</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th class="text-right">Total</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Payment</th>
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
    function cusOrdersListDatatable(){

        var tableName = 'customers_order_list_table';
        var actionUrl = $('#'+tableName).data('url');

        var orderStatus = $('#order_status').val();
        var paymentStatus = $('#payment_status').val();
        // var customerType = $('#customer_type').val();
        var userId = '<?php echo $user_id ?>';

        var postData = { 
            'order_status':orderStatus, 
            'payment_status' : paymentStatus, 
            // 'customer_type' : customerType, 
            'user_id' : userId
        };

        ajaxDataTableLoad(tableName, actionUrl, postData);
    }

    cusOrdersListDatatable();

</script>

</body>
</html>
