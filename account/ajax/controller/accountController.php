<?php 
require_once '../../../app/global/url.php';
require_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'/mail/mails.php';

require_once ROOT_PATH.'account/ajax/class/accountClass.php';

// Login
if($_SERVER['REQUEST_METHOD'] == "POST"){


    if(isset($_POST['register_customer'])){
        $mail = 0;
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
            // $redirectURL = URL.'/login';

            $mail = $eCommerceMailObj->registration($register['user_id']);
            
        }else{
            $message = $register['message'];
            // $redirectURL = URL.'login';
        }

        echo json_encode(array('result' => $result, 'message' => $message));
        

    }// register isset end


    if(isset($_POST['login_customer'])){

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
    

    if (isset($_POST['sendPasswordResetMail'])) {
        $result = 0;
        $message = "Mail is not sent!";
        $redirectURL = '';
        $details = array();

        $email = mysqli_real_escape_string($localhost,$_POST['email']);

        $details['email'] =  $email;
        $details['link'] =  URL.'resetPassword';

        $mail = $eCommerceMailObj->sendPasswordResetMail($details);

        if ($mail['result'] == 1) {
            $result = $mail['result'];
            $message = $mail['message'];
            $redirectURL = URL.'login';
        }

        echo json_encode(array('result' => $result, 'message' => $message,'redirectURL'=>$redirectURL));
    }//sendPasswordResetMail


    if (isset($_POST['reset_customer_password'])) {
        $mail = 0;
        $result = 0;
        $message = "Password Reset Failed!";
        $redirectURL = '';

        $email = mysqli_real_escape_string($localhost,$_POST['reset_email']);
        $password = mysqli_real_escape_string($localhost,$_POST['reset_password']);
        $c_password = mysqli_real_escape_string($localhost,$_POST['reset_confirm_password']);

        $credentials['email'] = $email;
        $credentials['password'] = $password;
        $credentials['c_password'] = $c_password;

        $reset = $myaccountObj->reset_customer_password($credentials);

        if($reset['result'] == 1){
            
            $result = 1;
            $message = $reset['message'];
            // $redirectURL = URL.'/login';
            
        }else{
            $message = $reset['message'];
            // $redirectURL = URL.'login';
        }

        echo json_encode(array('result' => $result, 'message' => $message));
        
    }//reset_customer_password

} // login
?>