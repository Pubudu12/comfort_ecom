
<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_1d_reference'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create reference";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'master_id' => 'required',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'master_id' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{

            $name = $validated_data['name'];
            $master_id = $validated_data['master_id'];
            $code = preg_replace('/\s+/', '', $name);
            $code = trim(strtolower($code)).$master_id.date("dmyhis");

            $insertData = array(
                'name' => $name,
                'master_id' => $master_id,
                'code' => $code,
                'description' => '',
            );

            $DBResult = $dbOpertionsObj->insert('ref_one_dimension', $insertData);

            if($DBResult['result'] == 1){

                $result = 1;
                $message = 'New reference '.$validated_data['name'].' has been created';

                $redirectURL = '#clickReset';

                $auditArr = array(
                    'action' => 'Create Reference',
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