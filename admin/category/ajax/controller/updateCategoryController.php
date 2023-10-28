<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_category'])){


        $result = 0;
        $error = 0;
        $message = "Failed to Update the Category";
        $redirectUrl = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'update_category' => 'required|numeric',
            'slug'=>'required'
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'update_category' => 'trim|sanitize_numbers',
            'slug'=>'trim'
        ));
        
        $validated_data = $gump->run($_POST);
        
        $name = $_POST['name'];
        $category_id = $_POST['update_category'];
        // $code = $_POST['code'];
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $validated_data['slug'])));

        $data = array(
            'name' => $name,
            // 'code' => $code,
            'slug'=>$slug
        );

        $whereArr = array('id' => $category_id);

        $DBResult = $dbOpertionsObj->update('categories', $data , $whereArr);
        $error = $DBResult;
        
        if ($DBResult['result'] == 1) {
            $result=1;
            $message = "Category ".$name." has been updated sucessfully";

            $auditArray = array(
            'action' => 'Update Category',
            'description' =>$message
            );
            $dbOpertionsObj->auditTrails($auditArray);
        } else {
            $message = "Sorry! Failed to update the Category";
            $error = $DBResult;
        }
        // $dbOpertionsObj->auditTrails($auditArr);
        echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));


    } // Update Category

} // Post End 