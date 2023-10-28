<?php
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['admin_login'])){
        
        $result = 0;
        $message = "Username or password is wrong";

        $username = $_POST['username'];
        $password = $_POST['password'];

        $login = array(
            'username' => $username,
            'password' => $password
        );

        $DBresult = $dbOpertionsObj->loginAdmin($login);

        if($DBresult['result'] == 1){
            $result = 1;
            $message = "User has been logged in successfully";
        }

        echo json_encode(array('result' => $result, 'message'=>$message));

    } //isset

    
}// Post Method

?>