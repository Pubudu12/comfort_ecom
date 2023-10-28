
<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_1d_reference'])){

        $result = 0;
        $error = 0;
        $message = "Failed to update reference";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'ref_id' => 'required',
            'master_id' => 'required',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'ref_id' => 'trim',
            'master_id' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{

            $name = $validated_data['name'];
            $master_id = $validated_data['master_id'];
            $ref_id = $validated_data['ref_id'];

            $updateData = array(
                'name' => $name,
            );

            $DBResult = $dbOpertionsObj->update('ref_one_dimension', $updateData, [
                'id' => $ref_id
            ]);

            if($DBResult['result'] == 1){

                $result = 1;
                $message = 'Reference '.$validated_data['name'].' has been updated';

                $redirectURL = '#clickReset';

                $auditArr = array(
                    'action' => 'Update Reference',
                    'description' => $message
                );
                $dbOpertionsObj->auditTrails($auditArr);

            }else{
                $error = $DBResult;
            }// db check result end
            

        } // Validation end 

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error));


    }// isset

    if(isset($_POST['update_post_cover'])){

        $ref_id = $_POST['update_post_cover'];

        $result = 0;
        $message = "Please fill the required fields";
        $imageBox = 0;


        // Cover Image
        if(isset($_FILES['cover_img']['name']) ){

            $error_image = 0;

            // Img Upload
            $uploadedImage = $_FILES['cover_img'];
            $path = ROOT_PATH.BRAND_IMG_PATH;

            if(strlen($uploadedImage['name']) ) {

                $newWidth = 1500;
                //$newHeight = 100; //Optional ---> If need fixed size
                $pass_parm = storeUploadedImage($path, $uploadedImage, $newWidth);

                if($pass_parm['error'] == 0){

                    $file_name = $pass_parm['filename'];
                    $error_image = 0;

                    $select = mysqli_query($localhost, "SELECT `name`,`image_name` FROM `ref_one_dimension` WHERE `id` = '$ref_id' ");
                    $fetch = mysqli_fetch_array($select);
                    if(strlen($fetch['image_name']) > 0){
                        $old_img = ROOT_PATH.BRAND_IMG_PATH.$fetch['image_name'];
                        $dbOpertionsObj->deleteImage($old_img);
                    }

                    // Insert Sub Cat Images
                    $DBResult = $dbOpertionsObj->update('ref_one_dimension', array('image_name' => $file_name), array('id' => $ref_id));

                    if($DBResult['result'] == 1){
                        $result = 1;
                        $message = "Upload Done";

                        $imageURL = URL.BRAND_IMG_PATH.$file_name;

                        $imageBox = file_get_contents(ROOT_PATH.'oneDReferences/container/brand_image.html');
                        $imageBox = str_replace("{{ IMAGE_URL }}", $imageURL, $imageBox);

                        $auditArr = array(
                            'action' => 'Brand Image Uploaded',
                            'description' => $message
                        );
                        $dbOpertionsObj->auditTrails($auditArr);
                    }

                }else{
                    $error_image = 1;
                    $message = $pass_parm['message'];
                    $cover_image_message = $message;
                }

            }

        }// if end for check strlen


        echo json_encode(array("result"=>$result,"message"=>$message, 'image_box' => $imageBox));

    } //update_post_cover
    

} // Post End 