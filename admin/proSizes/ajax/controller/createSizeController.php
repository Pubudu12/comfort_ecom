<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_size'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create size";
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
                'category_id'=>$validated_data['category']
            );

            $DBResult = $dbOpertionsObj->insert('sizes', $insertData);

            $error = $DBResult;
            if($DBResult['result']){

                $result = 1;
                $message = 'New size '.$validated_data['name'].' has been created';

                $redirectURL = URL.'sizes';

                $auditArr = array(
                    'action' => 'Create Size',
                    'description' => $message
                );
                $dbOpertionsObj->auditTrails($auditArr);

            }// db check result end
            

        } // Validation end 

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));


    }// isset




    if(isset($_POST['upload_image'])){

        $result = 0;
        $message = "Failed to changes the thumb";
        $error = 0;
        $imgBox = '';

        $category_id = $_POST['upload_image'];
        $img_type = $_POST['img_type'];
        $imageFile = $_FILES['img_name'];

        switch ($img_type) {
            case 'thumb':
                $newWidth = 600;
                break;

            case 'cover':
                $newWidth = 1500;
                break;

            case 'default':
                $newWidth = 1000;
                break;
            
            default:
                $newWidth = 1200;
                break;
        }


        if(isset($imageFile['name']) ) {

            if(strlen($imageFile['name']) > 0 ) {
                
                $path = ROOT_PATH.CAT_IMG_PATH;
                
                $pass_parm = storeUploadedImage($path, $imageFile, $newWidth, null,'default-');

                if($pass_parm['error'] == 0){
                    
                    $result = 1;
                    $message = "Category images has been uploaded";
                    $file_to_save = $pass_parm['filename'];

                    // Insert new Pic
                    $insertData = array(
                        'category_id' => $category_id,
                        'name' => $file_to_save,
                        'type' => $img_type
                    );

                    $DBResult = $dbOpertionsObj->insert('categories_images', $insertData);
                    
                    $imgBox = $DBResult;
                    if($DBResult['result']){

                        $result = 1;
                        $message = 'Category image has been changed';

                        $imgBoxContainer = file_get_contents(ROOT_PATH.'category/container/imgUploadCardContainer.html');
                        
                        $imgBoxContainer = str_replace('{{ IMG_NAME }}', URL.CAT_IMG_PATH.$file_to_save,  $imgBoxContainer);
                        $imgBoxContainer = str_replace('{{ IMG_ID }}', $DBResult['id'],  $imgBoxContainer);
                        $imgBoxContainer = str_replace('{{ IMGTYPE }}', $img_type,  $imgBoxContainer);

                        $imgBox = $imgBoxContainer;

                        $auditArr = array(
                            'action' => 'Upload Category Thumb Image',
                            'description' => $message
                        );


                    }// db check result end


                }else{
                    $message = $pass_parm['message'];
                }

            } // If Issey

        } // If end 


        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'imgBox'=>$imgBox) );

    } // upload_image



} // Post End 