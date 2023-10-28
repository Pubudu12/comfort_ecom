<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_new_dealer'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create the User";
        $redirectURL = URL.'dealer/dealers.php';

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'username' => 'required',
            'password' => 'required',
            'c_password' => 'required'
        ));
        
        $gump->filter_rules(array(
            'username' => 'trim',
            'password' =>'trim',
            'c_password' => 'trim'
        ));
        $DBResult = 0;
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {
            $email = $validated_data['email'];
            $select = mysqli_query($localhost,"SELECT * FROM `login` WHERE `email`='$email' ");
            if(mysqli_num_rows($select) == 0){
                if ($validated_data['password'] == $validated_data['c_password']) {

                    $encrypted_pwd = password_hash($validated_data['password'], PASSWORD_DEFAULT);
                    $access_token = date("iymdhs");

                    $insertData = array(
                        'access_token' => $access_token,
                        'name' => $validated_data['name'],
                        'email' => $validated_data['email'],
                        'contact_no'=> $validated_data['contact_no'],
                        'mobile_no'=> '',
                        'user_type' => 'dealer'
                    );

                    $insertLogin = array(
                        'access_token' => $access_token,
                        'email' => $validated_data['email'],
                        'password'=>$encrypted_pwd,
                        'active' => 1
                    ); 

                    $DBResultLogin = $dbOpertionsObj->insert('login', $insertLogin);
                    $DBResult = $dbOpertionsObj->insert('users', $insertData);
                    
                    if($DBResult['result']){
                        $result = 1;
                        $message = 'New Dealer '.$validated_data['name'].' has been created!';
                        $auditArr = array(
                            'action' => 'Create Dealer',
                            'description' => $message
                        );
                        $dbOpertionsObj->auditTrails($auditArr);
                    }// db check result end
                } else {
                    $message = "Passwords do not match!";
                }
            }else{
                $message = "This email already exists!";
            }
        }
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$DBResult,'redirectURL'=>$redirectURL));
    }//add category


} // Request Method