<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['create_new_user'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create the User";
        $redirectURL = URL.'admin/user-list.php';

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required'
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim'
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {
            if ($validated_data['pwd'] == $validated_data['confirm_pwd']) {

                $encrypted_pwd = password_hash($validated_data['pwd'],PASSWORD_DEFAULT);

                $insertData = array(
                    'username' => $validated_data['user_name'],
                    'level' => $validated_data['user_type'],
                    'password' => $encrypted_pwd,
                    'status' => 1
                );
                
                $DBResult = $dbOpertionsObj->insertData('admin', $insertData);
                
                if($DBResult['result']){

                    $result = 1;
                    $message = 'New User '.$validated_data['user_name'].' has been created';

                    $auditArr = array(
                        'action' => 'Create User',
                        'description' => $message
                    );

                    // $dbOpertionsObj->auditTrails($auditArr);

                }// db check result end
            } else {
                $message = "Passwords do not match!";
            }
        }
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectURL));
    }//add category


    if(isset($_POST['update_pwd'])){
                        
        $result = 0;
        $error = 0;
        $message = "Failed to Update the new password";
        $redirectUrl = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'new_pwd' => 'required'
        ));
        
        $gump->filter_rules(array(
            'new_pwd' => 'trim'
        ));
        
        $validated_data = $gump->run($_POST);
        
        $encrypted_new_pwd = password_hash($validated_data['new_pwd'],PASSWORD_DEFAULT);
        $user_id = $validated_data['user_id'];
        $insertData = array(
            'password' => $encrypted_new_pwd
        );

        $whereArr = array('id' => $user_id);

        $DBResult = $dbOpertionsObj->updateData('admin', $insertData , $whereArr);
        $error = $DBResult;
        
        if ($DBResult['result'] == 1) {
            $result=1;
            $message = "New Password updated sucessfully";

            $auditArray = array(
            'action' => 'Update password',
            'description' =>$message
            );
        } else {
            $message = "Sorry! Failed to update the password";
            $error = $DBResult;
        }
        echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));
    } // update User


    //user delete
    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_user'){

            $result = 0;
            $message = "Failed to delete the the user";
            $error = 0;

            $user_id = $_POST['id'];

            $select_user = mysqli_query($localhost, "SELECT `name` FROM `admin` WHERE `id` = '$user_id' ");
            $fetchUser = mysqli_fetch_array($select_user);
            $name = $fetchUser['name'];

            // Delete from user
            $DBResult = $dbOpertionsObj->deleteBYId('admin', array('id'=>$user_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "User.'$name'.deleted successfully !";

                $auditArray = array(
                    'action' => 'delete user',
                    'description' =>$message
                    );
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the user";
                $error = $DBResult;
            }
            // $dbOpertionsObj->auditTrails($auditArr);
            echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));
        }
    }//end delete
}