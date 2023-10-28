<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_serial'){

            $result = 0;
            $message = "Failed to delete the the Serial Number";
            $error = 0;
            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $serial_id = (int)$_POST['id'];

            $count = $dbOpertionsObj->count('product_serial', array('serial_id'=>$serial_id));
            if($count != 0){
                $resultArray['message'] = "This serial number belongs to a product";
                echo json_encode($resultArray);
                Exit(403);
            }else {
                // Delete from category
                $DBResult = $dbOpertionsObj->delete('serial_numbers', array('id'=>$serial_id));

                if ($DBResult['result'] == 1) {
                    $result = 1;
                    $message = "Serial Number has been deleted successfully !";

                    $auditArray = array(
                        'action' => 'Delete Serial Number',
                        'description' =>$message
                        );
                        $dbOpertionsObj->auditTrails($auditArray);
                } else {
                    $result = 0;
                    $message = "Sorry! Failed to delete the Serial Number";
                    $error = $DBResult;
                }
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