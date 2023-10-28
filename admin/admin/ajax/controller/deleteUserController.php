<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_user'){

            $result = 0;
            $message = "Failed to delete the the user";
            $error = 0;

            $user_id = $_POST['id'];

            $select_user = mysqli_query($localhost, "SELECT `username` FROM `admin` WHERE `id` = '$user_id' ");
            $fetchUser = mysqli_fetch_array($select_user);
            $name = $fetchUser['username'];

            // Delete from user
            $DBResult = $dbOpertionsObj->delete('admin', array('id'=>$user_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "User ".$name." deleted successfully !";

                $auditArray = array(
                    'action' => 'delete user',
                    'description' =>$message
                    );
                    $dbOpertionsObj->auditTrails($auditArray);
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the user";
                $error = $DBResult;
            }
            // $dbOpertionsObj->auditTrails($auditArr);
            echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));
        }
    }

} // Post

?>