<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_new_user'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create the User";
        $redirectURL = URL.'admin/users.php';

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'username' => 'required',
            'password' => 'required',
            'c_password' => 'required',
            'level' => 'required|numeric'
        ));
        
        $gump->filter_rules(array(
            'username' => 'trim',
            'password' =>'trim',
            'c_password' => 'trim',
            'level' => 'trim'
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {
            if ($validated_data['password'] == $validated_data['c_password']) {

                $encrypted_pwd = password_hash($validated_data['password'], PASSWORD_DEFAULT);

                $insertData = array(
                    'username' => $validated_data['username'],
                    'level' => $validated_data['level'],
                    'password' => $encrypted_pwd,
                    'status' => 1
                );
                
                $DBResult = $dbOpertionsObj->insert('admin', $insertData);
                
                if($DBResult['result']){

                    $result = 1;
                    $message = 'New User '.$validated_data['username'].' has been created';

                    $auditArr = array(
                        'action' => 'Create User',
                        'description' => $message
                    );

                    $dbOpertionsObj->auditTrails($auditArr);

                }// db check result end
            } else {
                $message = "Passwords do not match!";
            }
        }
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectURL));
    }//add category


} // Request Method