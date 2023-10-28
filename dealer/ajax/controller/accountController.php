<?php 
require_once '../../../app/global/url.php';
require_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'/mail/mails.php';

require_once ROOT_PATH.'dealer/ajax/class/accountClass.php';

// Login
if($_SERVER['REQUEST_METHOD'] == "POST"){


    if(isset($_POST['register_customer'])){

        $result = 0;
        $message = "Registration failed, please try again";
        $redirectURL = '';

        $name = mysqli_real_escape_string($localhost,$_POST['register_form_name']);
        $email = mysqli_real_escape_string($localhost,$_POST['register_form_email']);
        $phone = mysqli_real_escape_string($localhost,$_POST['register_form_phone']);
        $password = mysqli_real_escape_string($localhost,$_POST['register_form_password']);
        $c_password = mysqli_real_escape_string($localhost,$_POST['register_form_repassword']);

        $credentials['name'] = $name;
        $credentials['phone'] = $phone;
        $credentials['email'] = $email;
        $credentials['password'] = $password;
        $credentials['c_password'] = $c_password;

        $register = $myaccountObj->register($credentials);

        if($register['result'] == 1){
            
            $result = 1;
            $message = $register['message'];
            $redirectURL = URL.'/login';

            // $eCommerceMailObj->registration($user_id);
            
        }else{
            $message = $register['message'];
            $redirectURL = URL.'login';
        }

        echo json_encode(array('result' => $result, 'message' => $message,'redirectURL'=>$redirectURL));
        

    }// register isset end


    if(isset($_POST['login_dealer'])){

        $result = 0;
        $message = "Email id or password is wrong";
        $redirectURL = URL;

        $email = mysqli_real_escape_string($localhost,$_POST['login_form_email']);
        $password = mysqli_real_escape_string($localhost,$_POST['login_form_password']);

        $credentials['email'] =  $email;
        $credentials['password'] =  $password;

        if(isset($_POST['ip_address'])){
            $credentials['ip_address'] = mysqli_real_escape_string($localhost,$_POST['ip_address']);

            $redirectURL = URL."checkout";
            
        }

        $login = $myaccountObj->login($credentials);

        $login_error = $login['message'];

        if ($login['result'] == 1){ 
            $result = 1;
            $message = "Login successfull";
            $redirectURL = URL."shop";
        } // check login


        echo json_encode(array('result' => $result, 'message' => $message, 'redirectURL' => $redirectURL));

    }// login isset
    
} // login


?>