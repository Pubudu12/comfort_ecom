<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

// Page scripts
include_once ROOT_PATH.'orders/ajax/updateStockClass.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['order_status'])){

        $row_id  = $_POST['id'];
        $status = $_POST['order_status'];

        $result = 0;
        $message = "Failed to update the status";

        $today = date("Y-m-d");

        if($status == "delivered"){
            
            $update = mysqli_query($localhost,"UPDATE `orders` SET `delivery_status`='$status',`delivery_date`='$today' WHERE `id`='$row_id' ");

        }else if($status == "cancelled"){
            
            $select_order = mysqli_query($localhost, "SELECT `order_no` FROM `orders` WHERE `id` = '$row_id' ");
            $fetch_orders = mysqli_fetch_array($select_order);
            $orderNo = $fetch_orders['order_no'];
            $revertStock = $updateStockObj->updateStockOnCancel($orderNo);

            if($revertStock['result'] == 1){
                $update = mysqli_query($localhost,"UPDATE `orders` SET `delivery_status`='$status',`cancel_date`='$today' WHERE `id`='$row_id' ");
            }else{
                $update = false;
                $message = $revertStock['message'];
            }
            

        }else{

            $update = mysqli_query($localhost,"UPDATE `orders` SET `delivery_status`='$status' WHERE `id`='$row_id' ");

        }

        

        if($update){

            $select_order = mysqli_query($localhost,"SELECT `order_no` FROM `orders` WHERE `id`='$row_id' ");
            $fetch_order = mysqli_fetch_array($select_order);

            $result = 1;
            $message = "Order <b>".$fetch_order['order_no']."</b> status has been updated to <b>".$status."</b>";
        }

        $arr = array("result"=>$result,"message"=>$message);
        echo json_encode($arr);

    } // isset of order status

    if(isset($_POST['payment_status'])){

        $row_id  = $_POST['id'];
        $status = $_POST['payment_status'];

        $result = 0;
        $message = "Failed to update the payment status";

        $today = date("Y-m-d");

        if($status == "paid"){

            $update = mysqli_query($localhost,"UPDATE `orders` SET `payment`= total, `payment_date`='$today' WHERE `id`='$row_id' ");

        }else if($status == "unpaid"){

            $update = mysqli_query($localhost,"UPDATE `orders` SET `payment`= '0' WHERE `id`='$row_id' ");

        }

        if($update){

            $select_order = mysqli_query($localhost,"SELECT `order_no` FROM `orders` WHERE `id`='$row_id' ");
            $fetch_order = mysqli_fetch_array($select_order);


            $result = 1;
            $message = "Order <b>" .$fetch_order['order_no']. "</b> status has been <b>".$status ."</b>";
        }


        $arr = array("result"=>$result,"message"=>$message);
        echo json_encode($arr);
        

    } // isset of payment status


    //refaund
    if( isset($_POST['refund_id']) ){

        $row_id  = mysqli_real_escape_string($localhost,trim($_POST['refund_id']));
        $refaund_amount = mysqli_real_escape_string($localhost, trim($_POST['refaund_amount']) );

        

        $select_order = mysqli_query($localhost,"SELECT `order_no`,`payment`,`refaund_amount` FROM `orders` WHERE `id`='$row_id' ");
        $fetch_order = mysqli_fetch_array($select_order);
        
        $result = 0;
        $message = "Failed to refund the order ".$fetch_order['order_no'];
        
        if(mysqli_num_rows($select_order) == 1 ){
            
            if( ($fetch_order['payment'] != 0 ) && ( $refaund_amount <= $fetch_order['payment']  ) ){
                $new_pay_amount = $fetch_order['payment'] - $refaund_amount;
                $refaund_Date = Date("Y-m-d");
                $update = mysqli_query($localhost,"UPDATE `orders` SET `refaund_amount`= '$refaund_amount', `refaund_date`='$refaund_Date' , `total`='$new_pay_amount' WHERE `id`='$row_id' ");

                if($update){
                    $result = 1;
                    $message = "The order ".$fetch_order['order_no']." has been refunded successfully";
                }

            } // check if end

        } // check num rows
        
        $arr = array("result"=>$result,"message"=>$message);
        echo json_encode($arr);
    }// refaund isset

} // request method

?>