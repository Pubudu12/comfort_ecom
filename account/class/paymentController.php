<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'app/global/sessions.php';
include_once ROOT_PATH.'app/global/Gvariables.php';
include_once ROOT_PATH.'db/db.php';

require_once ROOT_PATH.'account/class/paymentClass.php';
require_once ROOT_PATH.'shopController/class/cartClass.php';

$resultArray = [
    'result' => 0,
    'message' => "Failed to process the payment",
];

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['make_payment']) && isset($_POST['orderid']) ){

        $orderId = trim($_POST['orderid']);
        $query = "SELECT `id`,`total` FROM `orders` WHERE `order_no` = '$orderId'";
        $select = mysqli_query($localhost, $query);
        
        if(mysqli_num_rows($select) == 1){

            $fetch = mysqli_fetch_array($select);

            $amount = $fetch['total'];
            if($amount > 0){
                $resultArray = $paymentObj->request(['order_id'=>$orderId, 'amount' => $amount]);
                
            }

        }


    }

}

echo json_encode($resultArray)


?>