<?php
require '../../app/global/url.php';
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'app/controllers/class/generalFunctionsClass.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['add_user_review'])){

        $generalObj = new GeneralFunctions;

        $title = '';
        $message = 'Failed to add the review!';
        $result = 0;
        $product_id = NumberValidation($localhost, $_POST['add_user_review']);
        $name = $_POST['username'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $ip_address = $generalObj->getIp();
        $rate = $_POST['rateIndex'];
        $DBesult = 0;

        $DBesult = mysqli_query($localhost,"INSERT INTO `user_reviews`(`product_id`,`ip_id`,`name`,`message`,`email`,`rate`) VALUES ('$product_id','$ip_address','$name','$message','$email','$rate') ");

        if ($DBesult) {
            $message = "Review added successfully!";
            $result = 1;
        } else {
            $message = "Review is not added !";
        }
        
        echo json_encode( array('title' => $title, 'message'=>$message,"result"=>$result) );
    }
}

?>