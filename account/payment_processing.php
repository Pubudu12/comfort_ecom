<?php include_once '../app/global/url.php' ?>
<?php include_once ROOT_PATH.'/app/global/sessions.php' ?>
<?php include_once ROOT_PATH.'/app/global/Gvariables.php' ?>
<?php include_once ROOT_PATH.'/db/db.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<?php

if($_SERVER['REQUEST_METHOD'] == "GET"){


    if(isset($_GET['order_no']) && isset($_GET['paynow']) ){
        
        $order_no = mysqli_real_escape_string($localhost,trim($_GET['order_no']));

        $select_order_details  = mysqli_query($localhost,"SELECT o.`order_no`, o.`total`, o.`payment`,
                                                    dd.`name`, dd.`mobile_no`, dd.`email`, dd.`door_no`, dd.`city`, dd.`state`
                                                    FROM `orders` AS o
                                                    INNER JOIN `delivery_details` AS dd ON dd.`order_no` = o.`order_no`
                                                    WHERE o.`order_no`='$order_no' ");
        
        $fetch_order_details = mysqli_fetch_array($select_order_details);


        if( $fetch_order_details['payment'] < $fetch_order_details['total'] ){

            $amount_to_be_paid = $fetch_order_details['total']-$fetch_order_details['payment'];

            $OrderID = $fetch_order_details['order_no']; // define by me
            $PurchaseAmt = $amount_to_be_paid; // should be 12 digit including decimal two points


            $merchant_id = 1211692;

            $order_id = $OrderID; // generated for merchant
            $items = rand();// Invoice No
            $currency = 'LKR';
            $amount = $PurchaseAmt;

            $first_name = $fetch_order_details['name'];
            $last_name = '';
            $email = $fetch_order_details['email'];
            $phone = $fetch_order_details['mobile_no'];
            $address = $fetch_order_details['door_no'];
            $city = $fetch_order_details['city'];
            $country = $fetch_order_details['state'];

            $return_url = URL.'account/view_order.php?order_no='.$OrderID.'&email='.$email.'&response=success';
            $cancel_url = URL.'account/view_order.php?order_no='.$OrderID.'&email='.$email.'&response=failed';
            $notify_url = URL.'account/response.php';
            
            ?>


            <form method="post" id="pay_now_form" action="https://sandbox.payhere.lk/pay/checkout">   

                <input type="hidden" name="merchant_id" value="<?php echo $merchant_id ?>">    <!-- Replace your Merchant ID -->
                <input type="hidden" name="return_url" value="<?php echo $return_url ?>">
                <input type="hidden" name="cancel_url" value="<?php echo $cancel_url ?>">
                <input type="hidden" name="notify_url" value="<?php echo $notify_url ?>">  

                
                <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                <input type="hidden" name="items" value="<?php echo $items ?>"><br>
                <input type="hidden" name="currency" value="<?php echo $currency ?>">
                <input type="hidden" name="amount" value="<?php echo $amount ?>">

                
                <input type="hidden" name="first_name" value="<?php echo $first_name ?>">
                <input type="hidden" name="last_name" value="<?php echo $last_name ?>"><br>
                <input type="hidden" name="email" value="<?php echo $email ?>">
                <input type="hidden" name="phone" value="<?php echo $phone ?>"><br>
                <input type="hidden" name="address" value="<?php echo $address ?>">
                <input type="hidden" name="city" value="<?php echo $city ?>">
                <input type="hidden" name="country" value="<?php echo $country ?>"><br><br> 

            </form> 
            
            <script>
                $('#pay_now_form').submit();
            </script>

            <?php
            
            }// check payment is made or not

        
    } // isset 


} // request method

?>

