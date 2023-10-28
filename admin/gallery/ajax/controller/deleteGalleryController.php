<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_galleryItem'){

            $result = 0;
            $message = "Failed to delete the the Gallery Item";
            $error = 0;

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $gallery_id = (int)$_POST['id'];

            // Delete from category
            $DBResult = $dbOpertionsObj->delete('gallery', array('id'=>$gallery_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "Gallery Item deleted successfully !";

                $auditArray = array(
                        'action' => 'delete gallery Item',
                        'description' =>$message
                    );
                    $dbOpertionsObj->auditTrails($auditArray);
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the gallery Item";
                $error = $DBResult;
            }

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            echo json_encode($resultArray);
        }

    } // Isset Delete

    if(isset($_POST['deletePackThumb'])){

        $result = 0;
        $message = "Please fill the required fields";
        
        $imageId = trim($_POST['imageId']);

        $select = mysqli_query($localhost, "SELECT `gallery_media`,`type` FROM `gallery` WHERE `id` = '$imageId' ");
        if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_array($select);
            if ($fetch['type'] == 'image') {
                $image_name = URL.PRO_IMG_PATH.$fetch['gallery_media'];

                $fullPath = ROOT_PATH.PRO_IMG_PATH.$fetch['gallery_media'];
                if(file_exists($fullPath)){
                    unlink($fullPath);
                }
            }

            $data= array(
                'gallery_media'=>'',
                'type'=>'',
            );

            // $DBResult = $dbOpertionsObj->update('gallery', $data , $whereArr);
            $DBResult = $dbOpertionsObj->update('gallery',$data ,array('id' => $imageId) );

            if($DBResult['result'] == 1){
                $result = 1;
                $message = "Gallery image has been removed";
            }
        }

        echo json_encode(array("result"=>$result,"message"=>$message));

    } //deletePackThumb

} // Post End 