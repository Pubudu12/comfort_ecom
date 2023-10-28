<?php 

$today = Date('Y-m-d');
$this_month_start_date = Date("Y-m-")."01";


$total_pending_orders = 0;
$total_processing_orders = 0;
$total_todays_orders = 0;

//monthly analytics

$currenct_date = date("d");

for($j=1; $j <= $currenct_date; $j++){

    $k = $j-1;
    $day_lab[$k] = $j;

    $day_order_data[$k] = 0;

    $day_signup_data[$k] = 0;

    $day_purchase_date[$k] = 0;

    $day_payments_data[$k] = 0;

    $day_refaunds_data[$k] = 0;

    $date_of_day = Date("Y-m-").$j;

    $select_day_orders = mysqli_query($localhost,"SELECT COUNT(`id`) AS orders, SUM(`total`) AS total, SUM(`payment`) AS payment FROM `orders` WHERE `checkout_date`='$date_of_day' ");
    $fetch_day_orders = mysqli_fetch_array($select_day_orders);

    //Payment
    $select_day_payment = mysqli_query($localhost,"SELECT SUM(`payment`) AS payment FROM `orders` WHERE `refaund_date`='$date_of_day' ");
    $fetch_day_payment = mysqli_fetch_array($select_day_payment);

    //Refaund
    $select_day_refaund = mysqli_query($localhost,"SELECT SUM(`refaund_amount`) AS refaund FROM `orders` WHERE `refaund_date`='$date_of_day' ");
    $fetch_day_refaund = mysqli_fetch_array($select_day_refaund);

    $day_order_data[$k] = $fetch_day_orders['orders'];

    if($fetch_day_orders['total'] > 0){
        $day_purchase_date[$k] = $fetch_day_orders['total'];
    }
    
    if($fetch_day_payment['payment'] > 0){
        $day_payments_data[$k] = $fetch_day_payment['payment'];
    }

    if($fetch_day_refaund['refaund'] > 0){
        $day_refaunds_data[$k] = $fetch_day_refaund['refaund'];
    }

    // fetch sign up
    $select_day_signup = mysqli_query($localhost,"SELECT COUNT(`id`) signup FROM `users` WHERE `created` LIKE '$date_of_day%' ");
    $fetch_day_signup = mysqli_fetch_array($select_day_signup);

    $day_signup_data[$k] = $fetch_day_signup['signup'];

} // date wise varibale assign for loop end 

// year analytics

$month_total_refaunds_data = $month_total_payments_data = $month_total_purchase_data = array();


for($i = 0; $i < 12; $i++){

    //labels
    $month_lab[$i] = Date("M-Y", strtotime("-".$i." month",Time() ));

    $month_order_data[$i] = 0;

    $month_signup_data[$i] = 0;

    $month_total_purchase_data[$i] = 0;

    $month_total_payments_data[$i] = 0;

    $month_total_refaunds_data[$i] = 0;

    // Month total orders monthly wise
    $month_start_date = Date("Y-m-d",strtotime($month_lab[$i])); 
    $month_end_date = Date("Y-m-d", strtotime($month_start_date." last day of this month"));

    $select_year_orders = mysqli_query($localhost,"SELECT COUNT(`id`) AS orders, SUM(`total`) AS total FROM `orders` WHERE DATE_FORMAT(`checkout_date`,'%Y-%m-%d') BETWEEN '$month_start_date' AND '$month_end_date' ");
    $fetch_year_orders = mysqli_fetch_array($select_year_orders);


    //payement
    $select_year_payments = mysqli_query($localhost,"SELECT SUM(`payment`) AS payment, SUM(`refaund_amount`) AS refaund FROM `orders` WHERE DATE_FORMAT(`payment_date`,'%Y-%m-%d') BETWEEN '$month_start_date' AND '$month_end_date' ");
    $fetch_year_payments = mysqli_fetch_array($select_year_payments);

    //Refaund
    $select_year_refaund = mysqli_query($localhost,"SELECT SUM(`refaund_amount`) AS refaund FROM `orders` WHERE DATE_FORMAT(`refaund_date`,'%Y-%m-%d') BETWEEN '$month_start_date' AND '$month_end_date' ");
    $fetch_year_refaund = mysqli_fetch_array($select_year_refaund);

    $month_order_data[$i] = $fetch_year_orders['orders'];

    if($fetch_year_orders['total'] > 0){
        $month_total_purchase_data[$i] = $fetch_year_orders['total'];
    }
    
    if($fetch_year_payments['payment'] > 0){
        $month_total_payments_data[$i] = $fetch_year_payments['payment'];
    }

    if($fetch_year_refaund['refaund'] > 0){
        $month_total_refaunds_data[$i] = $fetch_year_refaund['refaund'];
    }

    // fetch sign up
    $select_year_signup = mysqli_query($localhost,"SELECT COUNT(`id`) signup FROM `users` WHERE DATE_FORMAT(`created`,'%Y-%m-%d') BETWEEN '$month_start_date' AND '$month_end_date' ");
    $fetch_year_signup = mysqli_fetch_array($select_year_signup);

    $month_signup_data[$i] = $fetch_year_signup['signup'];
    

} // yearly analytics for llop end 



// pie

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return "#".random_color_part() . random_color_part() . random_color_part();
}


$pie_products_label = array();
$pie_products_background_color = array();
$pie_products_data = array();

// select products
$select_product_pie = mysqli_query($localhost,"SELECT COUNT(oi.`id`) countProducts, p.`name` 
                                    FROM `order_items` oi INNER JOIN `products` p ON p.`id` = oi.`product_id` WHERE DATE_FORMAT(oi.`created`,'%Y-%m-%d')  BETWEEN '$this_month_start_date' AND '$today'
                                    GROUP BY oi.`product_id`  ");

while($fetch_product_pie = mysqli_fetch_array($select_product_pie)){

    array_push($pie_products_label,$fetch_product_pie['name']);
    array_push($pie_products_background_color,random_color());
    array_push($pie_products_data,$fetch_product_pie['countProducts']);

}

if( count($pie_products_label)  == 0 ){
    array_push($pie_products_label,"No Date");
    array_push($pie_products_background_color,random_color());
    array_push($pie_products_data,'0');
}

mysqli_num_rows($select_product_pie);


//total
$total_amount_of_purchases = 0;
$total_amount_of_payments = 0;
$total_amount_of_refaunds = 0;

$total_orders = 0;
$total_customers = 0;
$total_products = 0;


// parsing data from db
$select_orders = mysqli_query($localhost,"SELECT COUNT(IF(`delivery_status`='pending', `id`,NULL )) pending, 
                                    COUNT(IF( `delivery_status`='delivered', `id`, NULL )) delivered, 
                                    COUNT(IF(`checkout_date`='$today', `id`, NULL)) today_orders,
                                    SUM(`total`) total_purchases,
                                    SUM(`refaund_amount`) total_refaunds,
                                    SUM(`payment`) total_payments,
                                    COUNT(`id`) total_orders
                                    FROM `orders` WHERE `checkout_date`='$today' ");

$fetch_orders = mysqli_fetch_array($select_orders);


$total_pending_orders = $fetch_orders['pending'];
$total_processing_orders = $fetch_orders['delivered'];
$total_todays_orders = $fetch_orders['today_orders'];


$total_amount_of_purchases = $fetch_orders['total_purchases'];
$total_amount_of_payments = $fetch_orders['total_payments'];
$total_amount_of_refaunds = $fetch_orders['total_refaunds'];

$total_orders = $fetch_orders['total_orders'];


$select_users = mysqli_query($localhost,"SELECT COUNT(`id`) AS total_users FROM `users` ");
$fetch_users = mysqli_fetch_array($select_users);

$select_categories = mysqli_query($localhost,"SELECT COUNT(`id`) AS total_categ FROM `categories` WHERE `level`='1' ");
$fetch_categories = mysqli_fetch_array($select_categories);

$total_customers = $fetch_users['total_users'];

$select_poducts = mysqli_query($localhost,"SELECT COUNT(`id`) AS total_products FROM `products` ");
$fetch_poducts = mysqli_fetch_array($select_poducts);

$total_products = $fetch_poducts['total_products'];



// reversing array here

//yearly
$month_lab = array_reverse($month_lab);
$month_order_data = array_reverse($month_order_data);
$month_total_payments_data = array_reverse($month_total_payments_data);
$month_total_purchase_data = array_reverse($month_total_purchase_data);
$month_total_refaunds_data = array_reverse($month_total_refaunds_data);

$month_signup_data = array_reverse($month_signup_data);



$select_all_products_v = mysqli_query($localhost, "SELECT 
                                                        COUNT(CASE WHEN `approved` = '1' THEN `approved` END ) AS verified,
                                                        COUNT(CASE WHEN `approved` = '0' THEN `approved` END ) AS notverified
                                                        FROM `products` WHERE `active` = 1 ");
$fetch_all_products_v = mysqli_fetch_array($select_all_products_v);
$total_verified_products = $fetch_all_products_v['verified'];
$total_not_verified_products = $fetch_all_products_v['notverified'];

?>