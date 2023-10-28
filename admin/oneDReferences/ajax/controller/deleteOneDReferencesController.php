<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_1d_reference'){

            $result = 0;
            $message = "Failed to delete the the reference";
            $error = 0;

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $ref_id = (int)$_POST['id'];

            $select = mysqli_query($localhost, "SELECT `name` FROM `ref_one_dimension` WHERE `id` = '$ref_id' ");
            $fetch = mysqli_fetch_array($select);
            $name = $fetch['name'];


            $count = $dbOpertionsObj->count('ref_pro_one2one', array('reference_id'=>$ref_id));
            if($count != 0){
                $resultArray['message'] = "This reference has assigned to products";
                echo json_encode($resultArray);
                Exit(403);
            }

            // Delete from category
            $DBResult = $dbOpertionsObj->delete('ref_one_dimension', array('id'=>$ref_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "Reference .'$name'. has been deleted successfully !";

                $auditArray = array(
                    'action' => 'Delete Reference',
                    'description' =>$message
                    );
                    $dbOpertionsObj->auditTrails($auditArray);
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the reference";
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