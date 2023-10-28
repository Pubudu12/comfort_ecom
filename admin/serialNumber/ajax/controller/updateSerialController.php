
<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['update_serial'])){
        $result = 0;
        $error = 0;
        $message = "Failed to update Serial Number";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{
            $name = $validated_data['name'];

            $updateData = array(
                'name' => $validated_data['name'],
                'serial_number' => $validated_data['serial'],
            );

            $whereArr = array('id'=>$validated_data['serial_id']);

            $DBResult = $dbOpertionsObj->update('serial_numbers', $updateData,$whereArr);
            if($DBResult['result'] == 1){
                $result = 1;
                $message = 'Serial Number has been updated';
                $redirectURL = URL.'serialNumbers';
                $auditArr = array(
                    'action' => 'Update Serial Number',
                    'description' => $message
                );
                $dbOpertionsObj->auditTrails($auditArr);
            }else{
                $error = $DBResult;
            }// db check result end
        } // Validation end 
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));
    }// isset


} // Post End 