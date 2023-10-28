<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_category'){

            $result = 0;
            $message = "Failed to delete the the category";
            $error = 0;

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $catg_id = (int)$_POST['id'];

            $select_catg = mysqli_query($localhost, "SELECT `name` FROM `categories` WHERE `id` = '$catg_id' ");
            $fetch_catg = mysqli_fetch_array($select_catg);
            $name = $fetch_catg['name'];


            $count = $dbOpertionsObj->count('categories', array('parent'=>$catg_id));
            if($count != 0){
                $resultArray['message'] = "This category has sub category";
                echo json_encode($resultArray);
                Exit(403);
            }

            $count = $dbOpertionsObj->count('products', array('sub_category'=>$catg_id));
            if($count != 0){
                $resultArray['message'] = "This category has products";
                echo json_encode($resultArray);
                Exit(403);
            }

            // Delete Categories Images
            $selectImages = mysqli_query($localhost, "SELECT * FROM `categories_images` WHERE `category_id` = '$catg_id' ");
            if(mysqli_num_rows($selectImages) > 0){
                while($fetchImages = mysqli_fetch_array($selectImages)){
                
                    $fullPath = ROOT_PATH.PRO_IMG_PATH.$fetchImages['name'];
                    if(file_exists($fullPath)){
                        unlink($fullPath);
                    }

                }

                $DBResult = $dbOpertionsObj->delete('categories_images', array('category_id'=>$catg_id));    

            }

            // Delete from category
            $select_special_integration = mysqli_query($localhost, "SELECT `special_integrations` FROM `categories` WHERE `id` = '$catg_id' ");
            $fetchspecial_integration = mysqli_fetch_array($select_special_integration);
            if ($fetchspecial_integration['special_integrations'] != '1') {
                $DBResult = $dbOpertionsObj->delete('categories', array('id'=>$catg_id));
            }            

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "Category ".$name." deleted successfully !";

                $auditArray = array(
                    'action' => 'delete Category',
                    'description' =>$message
                    );
                    $dbOpertionsObj->auditTrails($auditArray);
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the Category";
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

        $select = mysqli_query($localhost, "SELECT `name` FROM `categories_images` WHERE `id` = '$imageId' ");
        if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_array($select);

            $image_name = URL.PRO_IMG_PATH.$fetch['name'];

            $fullPath = ROOT_PATH.PRO_IMG_PATH.$fetch['name'];
            if(file_exists($fullPath)){
                unlink($fullPath);
            }

            $DBResult = $dbOpertionsObj->delete('categories_images', array('id' => $imageId) );

            if($DBResult['result'] == 1){
                $result = 1;
                $message = "Category images have been removed";
            }
        }


        echo json_encode(array("result"=>$result,"message"=>$message));

    } //deletePackThumb


} // Post End 