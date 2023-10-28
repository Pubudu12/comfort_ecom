<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

require_once ROOT_PATH.'mail/mails.php';
// Page scripts
include_once ROOT_PATH.'orders/ajax/updateStockClass.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    //refaund
    if( isset($_POST['send_invoice_again']) ){

        $orderNo  = mysqli_real_escape_string($localhost,trim($_POST['orderNo']));

        $result = 0;
        $message = "Failed to send the invoice to customer";
        
        $result = $eCommerceMailObj->invoice($orderNo);

        if($result){
            $result = 1;
            $message = "Email has been sent to the customer successfully";
        }
        

        $arr = array("result"=>$result,"message"=>$message);
        echo json_encode($arr);
    }// refaund isset

} // request method

?>