<?php

    include_once '../../app/global/url.php';
    include_once ROOT_PATH.'/app/global/global.php';

    include_once ROOT_PATH.'orders/ajax/updateStockClass.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['or_del_id'])){

            $order_no = $_POST['or_del_id'];

            $result = 0;
            $message = "Failed to delete order";

            

            $revertStock = $updateStockObj->updateStockOnCancel($order_no);

            if($revertStock['result'] == 1){

                // delete order delivery details
                $delete_dd = mysqli_query($localhost,"DELETE FROM `delivery_details` WHERE `order_no`='$order_no' ");

                // delete history
                $delete_hist = mysqli_query($localhost,"DELETE FROM `user_std_order_history` WHERE `order_no`='$order_no' ");

                // delete order items
                $delete_items = mysqli_query($localhost,"DELETE FROM `order_items` WHERE `order_no`='$order_no' ");

                if($delete_items){
                    $delete_order = mysqli_query($localhost,"DELETE FROM `orders` WHERE `order_no`='$order_no' ");

                    if($delete_order){
                        $result = 1;
                        $message = "Order ".$order_no." has been deleted successfully";
                    }

                }

            }else{

                $message = $revertStock['message'];

            }

            echo json_encode(array( "result"=>$result, "message"=>$message ));

            


        } // isset

    }/// request method

?>
