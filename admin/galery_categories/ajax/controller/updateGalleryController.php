<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_gal_category'])){


        $result = 0;
        $error = 0;
        $message = "Failed to Update the size";
        $redirectUrl = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'update_gal_category' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'update_gal_category' => 'trim|sanitize_numbers',
        ));
        
        $validated_data = $gump->run($_POST);
        
        $name = $_POST['name'];
        $size_id = $_POST['update_gal_category'];

        $data = array(
            'name' => $name,
        );

        $whereArr = array('id' => $size_id);

        $DBResult = $dbOpertionsObj->update('gallery_category', $data , $whereArr);
        $error = $DBResult;
        
        if ($DBResult['result'] == 1) {
            $result=1;
            $message = "Gallery Category ".$name." has been updated sucessfully";

            $auditArray = array(
            'action' => 'Update Gallery Category',
            'description' =>$message
            );
            $dbOpertionsObj->auditTrails($auditArray);
        } else {
            $message = "Sorry! Failed to update the Gallery Category";
            $error = $DBResult;
        }
        // $dbOpertionsObj->auditTrails($auditArr);
        echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));


    } // Update Category

} // Post End 