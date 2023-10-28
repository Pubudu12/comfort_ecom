<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['upload_file_downloads'])){

        $result = 0;
        $message = "Failed to upload the file";
        $error = 0;

        $name = trim($_POST['name']);
        if(strlen($name)==0){
            $name = "Document";
        }
        $description = $_POST['description'];

        // name of the uploaded file
        $uploadedFileArray = $_FILES['pdf_document'];
        $filename = rand().date("Ymdhi").'download.pdf';

        $target_dir = ROOT_PATH.PRO_DOWNLOAD_PATH;

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // destination of the file on the server
        $destination = $target_dir.$filename;

        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // the physical file on a temporary uploads directory on the server
        $file = $uploadedFileArray['tmp_name'];
        $size = $uploadedFileArray['size'];

        if (!in_array($extension, ['pdf', 'docx'])) {

            $message = "You file extension must be .pdf or .docx";

        } elseif ($uploadedFileArray['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
            $message = "File too large! it should be less than 10MB";
        } else {
            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination)) {

                $file_to_save = 'no';
                $imageFile = $_FILES['img_preview'];
                // Img Preview Upload
                if(isset($imageFile['name']) ) {

                    if(strlen($imageFile['name']) > 0 ) {
                        
                        $path = ROOT_PATH.PRO_DOWNLOAD_PATH;
                        
                        $newWidth = '400';
                        $pass_parm = storeUploadedImage($path, $imageFile, $newWidth, null,'default-');
        
                        if($pass_parm['error'] == 0){
                            
                            $result = 1;
                            $message = "Product images has been uploaded";
                            $file_to_save = $pass_parm['filename'];
                        }else{
                            $message = $pass_parm['message'];
                        }
        
                    } // If Issey
        
                } // If end 

                $dataArray = [
                    'name' => $name,
                    'description' => $description,
                    'image' => $file_to_save,
                    'file_name' => $filename,
                ];

                $DBResult = $dbOpertionsObj->insert('downloads', $dataArray);
                if($DBResult['result'] == 1){

                    $result = 1;
                    $message = "File has been uploaded successfully";

                }

            } else {
                $message = "Failed to upload file.";
            }
        }


        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error) );

    } //upload_document

}

?>