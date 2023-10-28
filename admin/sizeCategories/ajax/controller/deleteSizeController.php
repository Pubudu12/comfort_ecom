<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_size'){

            $result = 0;
            $message = "Failed to delete the size";
            $error = 0;

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $size_id = (int)$_POST['id'];

            $select_size = mysqli_query($localhost, "SELECT `name` FROM `product_size_categories` WHERE `id` = '$size_id' ");
            $fetch_size = mysqli_fetch_array($select_size);
            $name = $fetch_size['name'];

            $count = $dbOpertionsObj->count('sizes', array('category_id'=>$size_id));
            if($count != 0){
                $resultArray['message'] = "This size category has sizes";
                echo json_encode($resultArray);
                Exit(403);
            }else {
                 // Delete from category
                $DBResult = $dbOpertionsObj->delete('product_size_categories', array('id'=>$size_id));

                if ($DBResult['result'] == 1) {
                    $result = 1;
                    $message = "Size category ".$name." deleted successfully !";

                    $auditArray = array(
                            'action' => 'delete size category',
                            'description' =>$message
                        );
                        $dbOpertionsObj->auditTrails($auditArray);
                } else {
                    $result = 0;
                    $message = "Sorry! Failed to delete the size";
                    $error = $DBResult;
                }

                $resultArray = array(
                    'result' => $result,
                    'message' => $message,
                    'error' => $error,
                );
            }
           
            echo json_encode($resultArray);
        }
    } // Isset Delete


} // Post End 