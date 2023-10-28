<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_promo_code'){

            $result = 0;
            $message = "Failed to delete the the Promo Code";
            $error = 0;

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $promo_id = (int)$_POST['id'];

            // Delete from category
            $DBResult = $dbOpertionsObj->delete('promo_codes', array('id'=>$promo_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "Promo Code has been deleted successfully !";

                $auditArray = array(
                    'action' => 'Delete Promo Code',
                    'description' =>$message
                    );
    
                    $dbOpertionsObj->auditTrails($auditArray);
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the Promo Code";
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