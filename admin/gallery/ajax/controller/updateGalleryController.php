<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_gallery'])){

        $result = 0;
        $error = 0;
        $message = "Failed to Update the size";
        $redirectUrl = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'category' => 'required',
            'update_gallery' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'category' => 'trim',
            'update_gallery' => 'trim|sanitize_numbers',
        ));
        
        $validated_data = $gump->run($_POST);
        
        $gallery_id = $validated_data['update_gallery'];

        $data = array(
            'category' => $validated_data['category'],
            'caption'=>$validated_data['caption']
        );

        $whereArr = array('id' => $gallery_id);

        $DBResult = $dbOpertionsObj->update('gallery', $data , $whereArr);
        $error = $DBResult;
        
        if ($DBResult['result'] == 1) {
            $result=1;
            $message = "Gallery Item has been updated successfully!";

            $auditArray = array(
            'action' => 'Update Gallery',
            'description' =>$message
            );
            $dbOpertionsObj->auditTrails($auditArray);

            $redirectUrl = URL.'gallery/upload?id='.$gallery_id;
        } else {
            $message = "Sorry! Failed to update the Gallery";
            $error = $DBResult;
        }
        // $dbOpertionsObj->auditTrails($auditArr);
        echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error,'redirectURL'=>$redirectUrl));


    } // Update Category

} // Post End 