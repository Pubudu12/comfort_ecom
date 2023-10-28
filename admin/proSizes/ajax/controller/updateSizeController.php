<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_size'])){


        $result = 0;
        $error = 0;
        $message = "Failed to Update the size";
        $redirectUrl = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'update_size' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'update_size' => 'trim|sanitize_numbers',
        ));
        
        $validated_data = $gump->run($_POST);
        
        $name = $_POST['name'];
        $size_id = $_POST['update_size'];

        $data = array(
            'name' => $name,
            'category_id'=>$validated_data['category']
        );

        $whereArr = array('id' => $size_id);

        $DBResult = $dbOpertionsObj->update('sizes', $data , $whereArr);
        $error = $DBResult;
        
        if ($DBResult['result'] == 1) {
            $result=1;
            $message = "Size ".$name." has been updated sucessfully";

            $auditArray = array(
            'action' => 'Update Size',
            'description' =>$message
            );
            $dbOpertionsObj->auditTrails($auditArray);
        } else {
            $message = "Sorry! Failed to update the Size";
            $error = $DBResult;
        }
        // $dbOpertionsObj->auditTrails($auditArr);
        echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));


    } // Update Category

} // Post End 