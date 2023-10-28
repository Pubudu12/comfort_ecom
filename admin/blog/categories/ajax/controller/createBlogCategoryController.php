<?php 
include_once '../../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_blog_category'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create blog category";
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
                'name' => $name,
                'type'=> $validated_data['type']
            );

            $DBResult = $dbOpertionsObj->insert('blog_categories', $insertData);

            if($DBResult['result'] == 1){

                $result = 1;
                $message = 'New blog category '.$validated_data['name'].' has been created';

                $redirectURL = URL.'blog/category';

                $auditArr = array(
                    'action' => 'Create Blog Category',
                    'description' => $message
                );
                // $dbOpertionsObj->auditTrails($auditArr);

            }else{
                $error = $DBResult;
            }// db check result end
            

        } // Validation end 

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));


    }// isset


} // Post End 