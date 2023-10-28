<?php 
    require_once '../app/global/url.php';
    include_once ROOT_PATH.'/app/global/sessions.php';
    include_once ROOT_PATH.'/app/global/Gvariables.php';
    include_once ROOT_PATH.'/db/db.php';
    // require_once ROOT_PATH.'mail/mails.php'; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    if( (isset($_POST['merchant_id'])) && (isset($_POST['order_id'])) && (isset($_POST['payhere_amount'])) && (isset($_POST['payhere_currency'])) && (isset($_POST['status_code'])) && (isset($_POST['md5sig'])) ){
    
        $merchant_id      = $_POST['merchant_id'];
        $order_id         = $_POST['order_id'];
        $transaction_ref  = $_POST['payment_id'];
        $payhere_amount   = $_POST['payhere_amount'];
        $payhere_currency = $_POST['payhere_currency'];
        $status_code      = $_POST['status_code'];
        $md5sig           = $_POST['md5sig'];

        $method           = $_POST['method'];
        $status_message   = $_POST['status_message'];

        $merchant_secret = '4jo38lJA4yR4TnfGF8Dn7A4UoZrdyFiIk4eVJbdnl0qZ'; // Replace with your Merchant Secret (Can be found on your PayHere account's Settings page)

        $local_md5sig = strtoupper (md5 ( $merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)) ) );

        // if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
            if(1==1){
            //TODO: Update your database as payment success


            $select_order_details  = mysqli_query($localhost,"SELECT `order_no` FROM `orders` WHERE `order_no`='$order_id' ");
            $fetch_order_details = mysqli_fetch_array($select_order_details);

            $OrderID = $fetch_order_details['order_no'];
            $date = Date('Y-m-d');
            
            $amount_to_be_paid = $payhere_amount;
            $trx_reference_code = $transaction_ref;

            $card_type = $method;
            $card_response_code = $status_code;

            $card_no = null;
            if(isset($_POST['card_no'])){
                $card_no = $results['card_no'];
            }

            $card_holder_name = null;
            if(isset($_POST['card_holder_name'])){
                $card_holder_name = $results['card_holder_name'];
            }

            $card_response_text = null;
            if(isset($_POST['card_expiry'])){
                $card_response_text = Date("Y-m-d", strtotime($results['card_expiry']));
            }
            

            $updateQuery = "UPDATE `orders` SET `payment_date`='$date' ,`payment`= '$amount_to_be_paid', `trx_reference_no`='$trx_reference_code', `card_type` = '$card_no', `card_holder_name` = '$card_holder_name', `payment_res_code` = '$card_response_code', `payment_res_text` = '$card_response_text' WHERE `order_no`='$OrderID' ";
            $update_order = mysqli_query($localhost, $updateQuery);

            if($update_order){
                // send mail now here
                $result = $eCommerceMailObj->invoice($OrderID);
                $status = 'success';
            }


        } // Checkcum End
        
    } // isset end 

} // Request Method

?>