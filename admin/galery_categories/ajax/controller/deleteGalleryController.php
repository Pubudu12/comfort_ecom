<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_gallery_category'){

            $result = 0;
            $message = "Failed to delete the galery category";
            $error = 0;

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $category_id = (int)$_POST['id'];

            $select_size = mysqli_query($localhost, "SELECT `name` FROM `gallery_category` WHERE `id` = '$category_id' ");
            $fetch_size = mysqli_fetch_array($select_size);
            $name = $fetch_size['name'];

            $count = $dbOpertionsObj->count('gallery', array('category'=>$category_id));
            if($count != 0){
                $resultArray['message'] = "This Category includes gallery items!";
                echo json_encode($resultArray);
                Exit(403);
            }

            // Delete from category
            $DBResult = $dbOpertionsObj->delete('gallery_category', array('id'=>$category_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "Category ".$name." deleted successfully !";

                $auditArray = array(
                        'action' => 'delete gallery category',
                        'description' =>$message
                    );
                    $dbOpertionsObj->auditTrails($auditArray);
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the gallery category";
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


} // Post End 