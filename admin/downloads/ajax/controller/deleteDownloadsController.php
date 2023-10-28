<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){

        if($_POST['delete'] == 'delete_download' ){
         

            $result = 0;
            $message = "Please fill the required fields";
            
            $id = trim($_POST['id']);

            $select = mysqli_query($localhost, "SELECT `file_name`, `image` FROM `downloads` WHERE `id` = '$id' ");
            if(mysqli_num_rows($select) > 0){
                $fetch = mysqli_fetch_array($select);

                $image_name = URL.PRO_DOWNLOAD_PATH.$fetch['image'];
                $fullPath = ROOT_PATH.PRO_DOWNLOAD_PATH.$fetch['image'];
                if(file_exists($fullPath)){
                    unlink($fullPath);
                }

                $image_name = URL.PRO_DOWNLOAD_PATH.$fetch['file_name'];
                $fullPath = ROOT_PATH.PRO_DOWNLOAD_PATH.$fetch['file_name'];
                if(file_exists($fullPath)){
                    unlink($fullPath);
                }

                $DBResult = $dbOpertionsObj->delete('downloads', array('id' => $id) );

                if($DBResult['result'] == 1){
                    $result = 1;
                    $message = "Document has been removed";
                }
            }


            echo json_encode(array("result"=>$result,"message"=>$message));
            
        }

    } //delete_download


} // Post End 