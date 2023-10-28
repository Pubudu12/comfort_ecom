<?php 
include_once '../../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['edit_blog_category'])){

        $result = 0;
        $error = 0;
        $message = "Failed to update blog category";

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'edit_blog_category' => 'required',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'edit_blog_category' => 'trim'
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{

            $name = $validated_data['name'];
            $category_id = $validated_data['edit_blog_category'];
            $type = $validated_data['type'];

            $dataArray = array(
                'name' => $name,
                'type' => $type
            );

            $DBResult = $dbOpertionsObj->update('blog_categories', $dataArray, ['id'=>$category_id]);

            if($DBResult['result'] == 1){

                $result = 1;
                $message = 'Blog category '.$validated_data['name'].' has been updated';

                $auditArr = array(
                    'action' => 'Update Blog Category',
                    'description' => $message
                );
                // $dbOpertionsObj->auditTrails($auditArr);

            }else{
                $error = $DBResult;
            }// db check result end
            

        } // Validation end 

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error));


    }// isset


} // Post End 