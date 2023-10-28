<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_galleryItem'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create Gallery Item";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'category' => 'required',
        ));
        
        $gump->filter_rules(array(
            'category' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{

            $insertData = array(
                'category' => $validated_data['category'],
                'caption' => $validated_data['caption']
            );

            $DBResult = $dbOpertionsObj->insert('gallery', $insertData);
            $select = mysqli_query($localhost,"SELECT `id` FROM `gallery` ORDER BY id DESC LIMIT 1");
            $fetch = mysqli_fetch_array($select);
            $latestId = $fetch['id'];

            $error = $DBResult;
            if($DBResult['result']){

                $result = 1;
                $message = 'New Gallery Item created!';

                $redirectURL = URL.'galleryItems';

                $auditArr = array(
                    'action' => 'Create Gallery Item',
                    'description' => $message
                );
                $dbOpertionsObj->auditTrails($auditArr);
                $redirectURL = URL.'gallery/upload?id='.$latestId;

            }// db check result end
            

        } // Validation end 

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));


    }// isset


    if(isset($_POST['upload_image'])){

        $result = 0;
        $message = "Failed to changes the thumb";
        $error = 0;
        $imgBox = '';
        $redirectURL = URL.'galleryItems';

        $gallery_id = $_POST['upload_image'];
        $img_type = $_POST['img_type'];
    
        $newWidth = 600;
        // switch ($img_type) {
        //     case 'thumb':
        //         $newWidth = 600;
        //         break;

        //     case 'cover':
        //         $newWidth = 1500;
        //         break;

        //     case 'default':
        //         $newWidth = 1000;
        //         break;
            
        //     default:
        //         $newWidth = 1200;
        //         break;
        // }
        $imgBoxContainer = file_get_contents(ROOT_PATH.'gallery/container/imgUploadCardContainer.html');
        $imgBox = $imgBoxContainer;

        if ($img_type == 'image') {
            $imageFile = $_FILES['img_name'];
            if(isset($imageFile['name']) ) {

                if(strlen($imageFile['name']) > 0 ) {
                    
                    $path = ROOT_PATH.GALLERY_IMG_PATH;
                    
                    $pass_parm = storeUploadedImage($path, $imageFile, $newWidth, null,'default-');

                    if($pass_parm['error'] == 0){
                        
                        $result = 1;
                        $message = "Gallery has been uploaded";
                        $file_to_save = $pass_parm['filename'];

                        // Insert new Pic
                        $updateData = array(
                            'gallery_media' => $file_to_save,
                            'type' => $img_type
                        );

                        $whereArr = array('id'=>$gallery_id);

                        $DBResult = $dbOpertionsObj->update('gallery', $updateData , $whereArr);
                        
                        $imgBox = $DBResult;
                        if($DBResult['result']){

                            $result = 1;
                            $message = 'Gallery image has been changed';

                            $imgBoxContainer = file_get_contents(ROOT_PATH.'gallery/container/imgUploadCardContainer.html');
                            
                            $imgBoxContainer = str_replace('{{ IMG_NAME }}', URL.GALLERY_IMG_PATH.$file_to_save,  $imgBoxContainer);
                            $imgBoxContainer = str_replace('{{ IMG_ID }}', $gallery_id,  $imgBoxContainer);
                            $imgBoxContainer = str_replace('{{ IMGTYPE }}', $img_type,  $imgBoxContainer);
                            $imgBoxContainer = str_replace('{{ HIDE_LINK }}', 'hide',  $imgBoxContainer);

                            $imgBox = $imgBoxContainer;
                            $redirectURL = URL.'galleryItems';
                            

                            $auditArr = array(
                                'action' => 'Upload Gallery Thumb Image',
                                'description' => $message
                            );
                        }// db check result end
                    }else{
                        $message = $pass_parm['message'];
                    }
                } // If Issey
            } // If end 
        }else{
            $updateData = array(
                'gallery_media' => $_POST['link'],
                'type' => $img_type
            );

            $whereArr = array('id'=>$gallery_id);

            $DBResult = $dbOpertionsObj->update('gallery', $updateData , $whereArr);

            if($DBResult['result']){
                $result = 1;
                $message = 'Gllery video updated!';

                $imgBoxContainer = file_get_contents(ROOT_PATH.'gallery/container/imgUploadCardContainer.html');
                            
                $imgBoxContainer = str_replace('{{ LINK }}', $_POST['link'],  $imgBoxContainer);
                $imgBoxContainer = str_replace('{{ IMG_ID }}', $gallery_id,  $imgBoxContainer);
                $imgBoxContainer = str_replace('{{ IMGTYPE }}', $img_type,  $imgBoxContainer);
                $imgBoxContainer = str_replace('{{ HIDE_IMG }}', 'hide',  $imgBoxContainer);

                $imgBox = $imgBoxContainer;

                $auditArr = array(
                    'action' => 'Gallery video updated',
                    'description' => $message
                );

                $redirectURL = URL.'galleryItems';
            }// db check result end
        }

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL ,'imgBox'=>$imgBox) );

    } // upload_image



} // Post End 