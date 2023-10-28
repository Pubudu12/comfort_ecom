<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';

include ROOT_PATH.'dashboard/dashboard_data.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = '';
    $meta_single_page_desc = '';
    include_once ROOT_PATH.'app/meta/meta_more_details.php'; 
    
    include_once ROOT_PATH.'imports/css.php';
    ?>
</head>

<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">

    <!-- Page Header Start-->
    <?php include_once ROOT_PATH.'imports/header.php'?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

        <!-- Page Sidebar Start-->
      <?php include_once ROOT_PATH.'imports/sidebar.php'?>

        <div class="page-body">

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">

                    <div class="col-xl-4 col-md-6 xl-50">
                        <div class="card o-hidden  widget-cards">
                            <div class="bg-secondary card-body">
                                <a href="<?php echo URL?>products">
                                    <div class="media static-top-widget row">
                                        <div class="icons-widgets col-4">
                                            <div class="align-self-center text-center"><i data-feather="box" class="font-secondary"></i></div>
                                        </div>
                                        <div class="media-body col-8"><span class="m-0 font-white">Products</span>
                                            <h3 class="mb-0"><span class="counter"><?php echo number_format($total_verified_products,0) ?></span><small> Total</small></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-warning card-body">
                                <a href="<?php echo URL?>category">
                                    <div class="media static-top-widget row">
                                        <div class="icons-widgets col-4">
                                            <div class="align-self-center text-center"><i data-feather="navigation" class="font-warning"></i></div>
                                        </div>
                                        <div class="media-body col-8"><span class="m-0 font-white">Product Categories</span>
                                            <h3 class="mb-0"> <span class="counter"><?php echo number_format($fetch_categories['total_categ']) ?></span><small> Total</small></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-danger card-body">
                                <a href="<?php echo URL?>customer/customers.php">
                                    <div class="media static-top-widget row">
                                        <div class="icons-widgets col-4">
                                            <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                                        </div>
                                        <div class="media-body col-8"><span class="m-0 font-white">Customers</span>
                                            <h3 class="mb-0"> <span class="counter"><?php echo number_format($total_customers) ?></span><small> Total</small></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-4 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-primary card-body">
                                <a href="<?php echo URL?>orders/orders.php">
                                    <div class="media static-top-widget row">
                                        <div class="icons-widgets col-4">
                                            <div class="align-self-center text-center"><i data-feather="message-square" class="font-primary"></i></div>
                                        </div>
                                        <div class="media-body col-8"><span class="m-0 font-white">Pending Orders</span>
                                            <h3 class="mb-0"> <span class="counter"><?php echo number_format($total_pending_orders) ?></span><small> Total</small></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-primary card-body">
                                <a href="<?php echo URL?>orders/orders.php">
                                    <div class="media static-top-widget row">
                                        <div class="icons-widgets col-4">
                                            <div class="align-self-center text-center"><i data-feather="message-square" class="font-primary"></i></div>
                                        </div>
                                        <div class="media-body col-8"><span class="m-0 font-white">Delivered Orders</span>
                                            <h3 class="mb-0"> <span class="counter"><?php echo number_format($total_processing_orders) ?></span><small> Total</small></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-primary card-body">
                                <a href="<?php echo URL?>orders/orders.php">
                                    <div class="media static-top-widget row">
                                        <div class="icons-widgets col-4">
                                            <div class="align-self-center text-center"><i data-feather="message-square" class="font-primary"></i></div>
                                        </div>
                                        <div class="media-body col-8"><span class="m-0 font-white">Today's Orders</span>
                                            <h3 class="mb-0"> <span class="counter"><?php echo number_format($total_todays_orders) ?></span><small> Total</small></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php include ROOT_PATH.'dashboard/includes/monthlyAnalytics.php' ?>
                    <?php include ROOT_PATH.'dashboard/includes/yearlyAnalytics.php' ?>


                    <!-- <div class="col-xl-3 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-danger card-body">
                                <div class="media static-top-widget row">
                                    <div class="icons-widgets col-4">
                                        <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                                    </div>
                                    <div class="media-body col-8"><span class="m-0">Purchased Amount</span>
                                        <h3 class="mb-0"> <span class="counter"><?php echo number_format($total_amount_of_purchases,2) ?></span><small> <?php echo CURRENCY ?></small></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-danger card-body">
                                <div class="media static-top-widget row">
                                    <div class="icons-widgets col-4">
                                        <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                                    </div>
                                    <div class="media-body col-8"><span class="m-0">Payments</span>
                                        <h3 class="mb-0"> <span class="counter"><?php echo number_format($total_amount_of_payments,2) ?></span><small> <?php echo CURRENCY ?></small></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-danger card-body">
                                <div class="media static-top-widget row">
                                    <div class="icons-widgets col-4">
                                        <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                                    </div>
                                    <div class="media-body col-8"><span class="m-0">Refund</span>
                                        <h3 class="mb-0"> <span class="counter"><?php echo number_format($total_amount_of_refaunds,2) ?></span><small> <?php echo CURRENCY ?></small></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 xl-50">
                        <div class="card o-hidden widget-cards">
                            <div class="bg-danger card-body">
                                <div class="media static-top-widget row">
                                    <div class="icons-widgets col-4">
                                        <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                                    </div>
                                    <div class="media-body col-8"><span class="m-0">Income</span>
                                        <h3 class="mb-0"> <span class="counter"><?php echo number_format( ($total_amount_of_payments-$total_amount_of_refaunds) ,2) ?></span><small> <?php echo CURRENCY ?></small></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                </div>
            </div>
            <!-- Container-fluid Ends-->

        </div>

        <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>
    </div>

</div>

<?php include_once ROOT_PATH.'imports/js.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script>
    
    var orderDataLabel_php = eval('<?php  echo json_encode($month_lab) ?>');
    var orderDataMonthly_php = eval('<?php echo json_encode($month_order_data) ?>');
    var signupDataMonthly_php = eval('<?php echo json_encode($month_signup_data) ?>');

    var purchaseDataMonthly_php = eval('<?php echo json_encode($month_total_purchase_data) ?>');
    var paymentsDataMonthly_php = eval('<?php echo json_encode($month_total_payments_data) ?>');
    var refaundDataMonthly_php = eval('<?php echo json_encode($month_total_refaunds_data) ?>');
    //-----------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------
    /// graph of orders and income 

    var ordersData = [ {
                        label: 'Total Monthly Orders ',
                        steppedLine: true,
                        data: orderDataMonthly_php,
                        borderColor: 'black',
                        fill: false
                    },
                    {
                        label: 'Total Monthly Sign Ups ',
                        steppedLine: false,
                        data: signupDataMonthly_php,
                        borderColor: 'blue',
                        fill: false
                    } ];
    var ctx = document.getElementById('order_chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: orderDataLabel_php,
            datasets: ordersData
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'This Month Total Orders & Signups'
            }
        }
    });


    // Amount chart
    var amountData = [ {
                        label: 'Monthly Purchases ',
                        steppedLine: true,
                        data: purchaseDataMonthly_php,
                        borderColor: 'orange',
                        fill: false
                    },
                    {
                        label: 'Monthly Payments ',
                        steppedLine: false,
                        data: paymentsDataMonthly_php,
                        borderColor: 'green',
                        fill: false
                    },
                    {
                        label: 'Monthly Refunds ',
                        steppedLine: false,
                        data: refaundDataMonthly_php,
                        borderColor: 'red',
                        fill: false
                    } ];
    var ctx = document.getElementById('amount_chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: orderDataLabel_php,
            datasets: amountData
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'This Month Total Purchases & Payments'
            }
        }
    });


    /// graph of orders and income  end 
    //-----------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------

    var dayData_lable_php = eval('<?php  echo json_encode($day_lab) ?>');

    var dayData_order_php = eval('<?php  echo json_encode($day_order_data) ?>');
    var dayData_signup_php = eval('<?php  echo json_encode($day_signup_data) ?>');

    var dayData_purchase_php = eval('<?php  echo json_encode($day_purchase_date) ?>');
    var dayData_payments_php = eval('<?php  echo json_encode($day_payments_data) ?>');
    var dayData_refaunds_php = eval('<?php  echo json_encode($day_refaunds_data) ?>');

    // Total This month Orders and sign up
    var thisMonthLabel = dayData_lable_php;
    var thisMonthOrderData = [ {
                                label: 'Total Monthly Orders ',
                                steppedLine: true,
                                data: dayData_order_php,
                                borderColor: 'black',
                                fill: false
                            },
                            {
                                label: 'Total Monthly Sign Ups ',
                                steppedLine: false,
                                data: dayData_signup_php,
                                borderColor: 'blue',
                                fill: false
                            } ];
    var ctx = document.getElementById('month-order_chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: thisMonthLabel,
            datasets: thisMonthOrderData
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'This Month Total Orders & Signups'
            }
        }
    });


    // Total This month Purchase and paymens and sign up
    var thisMonthLabel = dayData_lable_php;
    var thisMonthOrderData = [ {
                                label: 'Total Monthly Purchases ',
                                steppedLine: true,
                                data: dayData_purchase_php,
                                borderColor: 'orange',
                                fill: false
                            },
                            {
                                label: 'Total Monthly Payments ',
                                steppedLine: false,
                                data: dayData_payments_php,
                                borderColor: 'green',
                                fill: false
                            },
                            {
                                label: 'Total Monthly Refunds ',
                                steppedLine: false,
                                data: dayData_refaunds_php,
                                borderColor: 'red',
                                fill: false
                            } ];
    var ctx = document.getElementById('month-amount_chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: thisMonthLabel,
            datasets: thisMonthOrderData
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'This Month Total Purchases & Payments'
            }
        }
    });




    // pie chat

    var pieData_lable_php = eval('<?php  echo json_encode($pie_products_label) ?>');

    var pieData_bg_php = eval('<?php  echo json_encode($pie_products_background_color) ?>');
    var pieData_php = eval('<?php  echo json_encode($pie_products_data) ?>');

    

    var config = {
        data: {
            datasets: [{
                data: pieData_php,
                backgroundColor: pieData_bg_php,
                label: 'My dataset' // for legend
            }],
            labels: pieData_lable_php
        },
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Most Selling Products of This Month'
            },
            scale: {
                ticks: {
                    beginAtZero: true
                },
                reverse: false
            },
            animation: {
                animateRotate: false,
                animateScale: true
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('month-product_chart');
        window.myPolarArea = Chart.PolarArea(ctx, config);
    };




</script>


</body>
</html>
