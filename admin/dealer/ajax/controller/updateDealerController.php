<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_dealer_pswd'])){
                        
        $result = 0;
        $error = 0;
        $message = "Failed to Update the new password";
        $redirectURL = URL.'dealer/dealers.php';

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'dealer_id' => 'required',
            'password' => 'required',
            'c_password' => 'required'
        ));
        
        $gump->filter_rules(array(
            'dealer_id' => 'trim',
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
                $user_id = $validated_data['dealer_id'];
                $select_user = mysqli_query($localhost,"SELECT l.`id` 
                                                        FROM `users`
                                                        INNER JOIN `login` l ON l.`email`=`users`.email
                                                        WHERE `users`.`id`='$user_id' ");
                $fetch_user = mysqli_fetch_array($select_user);
                $login_id = $fetch_user['id'];

                $insertData = array(
                    'password' => $encrypted_new_pwd
                );

                $whereArr = array('id' => $login_id);

                $DBResult = $dbOpertionsObj->update('login', $insertData , $whereArr);
                $error = $DBResult;
                
                if ($DBResult['result'] == 1) {
                    $result=1;
                    $message = "New Password updated sucessfully";

                    $auditArray = array(
                        'action' => 'Update Dealer password',
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