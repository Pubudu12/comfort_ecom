<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_user_pswd'])){
                        
        $result = 0;
        $error = 0;
        $message = "Failed to Update the new password";
        $redirectURL = URL.'admin/users.php';

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'user_id' => 'required',
            'password' => 'required',
            'c_password' => 'required'
        ));
        
        $gump->filter_rules(array(
            'user_id' => 'trim',
            'password' => 'trim',
            'c_password' => 'trim'
        ));

        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {
            if ($validated_data['password'] == $validated_data['c_password']) {

                $encrypted_new_pwd = password_hash($validated_data['password'],PASSWORD_DEFAULT);
                $user_id = $validated_data['user_id'];
                $insertData = array(
                    'password' => $encrypted_new_pwd
                );

                $whereArr = array('id' => $user_id);

                $DBResult = $dbOpertionsObj->update('admin', $insertData , $whereArr);
                $error = $DBResult;
                
                if ($DBResult['result'] == 1) {
                    $result=1;
                    $message = "New Password updated sucessfully";

                    $auditArray = array(
                    'action' => 'Update password',
                    'description' =>$message
                    );
                    $dbOpertionsObj->auditTrails($auditArray);
                } else {
                    $message = "Sorry! Failed to update the password";
                    $error = $DBResult;
                }

            } else {
                $message = "Passwords do not match!";
            }
        }

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectURL));
        
    } // update User


} // Request Method