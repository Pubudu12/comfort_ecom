<?php
require_once '../../../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_blog_tag'])){
        
        $result = 0;
        $error = 0;
        $message = "Failed to create blog Tag";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{

            $name = $validated_data['name'];

            $insertData = array(
                'type' => $name,
            );

            $DBResult = $dbOpertionsObj->insert('blog_type', $insertData);

            if($DBResult['result'] == 1){

                $result = 1;
                $message = 'New blog Tag '.$validated_data['name'].' has been created';

                $redirectURL = '#clickReset';

                $auditArr = array(
                    'action' => 'Create Blog Tag',
                    'description' => $message
                );
                // $dbOpertionsObj->auditTrails($auditArr);

            }else{
                $error = $DBResult;
            }// db check result end
            

        } // Validation end 

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));

    } //create_tags


    if(isset($_POST['edit_blog_tag'])){
        
        $result = 0;
        $message = "Please fill the field";

        $tagName = trim($_POST['name']);

        if(strlen($tagName) > 0){

            $id = trim($_POST['edit_blog_tag']);

            $updateData = array(
                'type' => $tagName,
            );
    
            $DBresult = $dbOpertionsObj->update('blog_tags', $updateData, array('id' => $id));
    
            if($DBresult['result'] == 1){
                $result = 1;
                $message = "Tag has been updated successfully";
            }
        }else{
            $message = "Please write someting";
        }

        echo json_encode(array('result' => $result, 'message'=>$message));

    } //update_tag
    


    if(isset($_POST['delete'])){

        if($_POST['delete'] == "delete_tag"){

            $result = 0;
            $message = "Failed to delete the tag";

            $id = $_POST['id'];

            $whereArr = array('id' => $id);
            $DBResult = $dbOpertionsObj->delete('blog_tags', $whereArr);

            if($DBResult['result'] == 1){
                $result = 1;
                $message = "Tag has been deleted successfully";
            }

            echo json_encode(array('result' => $result, 'message'=>$message));

        }

    } // delete_tag

    
}// Post Method

?>