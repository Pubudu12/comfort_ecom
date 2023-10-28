
<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['update_promo_code'])){
        $result = 0;
        $error = 0;
        $message = "Failed to update reference";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'max_usage' => 'required',
            'amount'=>'required'
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'max_usage' => 'trim',
            'amount'=>'trim'
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{
            $name = $validated_data['name'];
            // $code = preg_replace('/\s+/', '', $name);
            // $code = trim(strtolower($code)).date("dmyhis");

            $updateData = array(
                'name' => $name,
                'code' => $validated_data['code'],
                'max_usage' => $validated_data['max_usage'],
                'amount' => $validated_data['amount'],
                'discount_type' => $validated_data['dis_type'],
                'start_date' => $validated_data['start_date'],
                'end_date' => $validated_data['end_date'],
            );

            $whereArr = array('id' => $validated_data['promo_id']);
            $DBResult = $dbOpertionsObj->update('promo_codes', $updateData, $whereArr);
            if($DBResult['result'] == 1){
                $result = 1;
                $message = 'Promo Code has been updated';
                $redirectURL = URL.'promoCodes/promoCodes.php';
                $auditArr = array(
                    'action' => 'Update Promo Code',
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