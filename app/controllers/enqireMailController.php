<?php 
require_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
include_once ROOT_PATH.'/mail/mails.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if (isset($_POST['sendEnquireMail'])) {
        $detailArray = array();
        $result = 0;
        $message = 'Failed to send mail!';
        $error = '';

        $detailArray['name'] = $_POST['name'];
        $detailArray['email'] = $_POST['email'];
        $detailArray['phone'] = $_POST['phone'];
        $detailArray['date'] = $_POST['date'];
        $detailArray['time'] = $_POST['time'];
        $detailArray['message'] = $_POST['message'];

        $result = $eCommerceMailObj->sendEnquire($detailArray);

        // echo json_encode($result);

        if ($result['result'] == 1) {
           $result = 1;
           $message = 'Mail sent successfully!';
           $error = $result;
        }
        echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));
    }//sendEnquireMail

    if (isset($_POST['rquest_custom_size'])) {

        $result = 0;
        $error = 0;
        $mail = 0;
        $message = "Failed to requets size!";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'email' => 'required',
            'custom_width' => 'required',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'email' => 'trim',
            'custom_width' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{
            $detailArray = array();
            $detailArray['name'] = $validated_data['name'];
            $detailArray['pro_id'] = $validated_data['rquest_custom_size'];
            $detailArray['email'] = $validated_data['email'];
            $detailArray['requested_width'] = $validated_data['custom_width'];
            $detailArray['requested_length'] = $validated_data['custom_length'];
            $detailArray['requested_height'] = $validated_data['custom_height'];
            $detailArray['message'] = $validated_data['message'];

            $pro_id = $validated_data['rquest_custom_size'];
            $name = $validated_data['name'];
            $email = $validated_data['email'];
            $requested_width = $validated_data['custom_width'];
            $requested_length = $validated_data['custom_length'];
            $requested_height = $validated_data['custom_height'];
            $message = $validated_data['message'];
            $contact = $validated_data['contact_no'];

            // $DBResult = $dbOpertionsObj->insert('custom_size_requests', $insertData);
            $sql = "INSERT INTO `custom_size_requests`(`customer_name`,`product_id`,`email`,`contact_no`, `requested_width`, `requested_length`, `requested_height`, `message`)
                         VALUES ('$name','$pro_id','$email','$contact','$requested_width','$requested_length','$requested_height','$message')";
            $DBResult = (mysqli_query($localhost,$sql));
            $error = $DBResult;

            if($DBResult == true){
                $result = 1;
                $message = 'Custom size Request is sent!';
                $redirectURL = URL.'shop/pro?q='.$pro_id;

                $auditArr = array(
                    'action' => 'Custom size Request',
                    'description' => $message
                );
                // $dbOpertionsObj->auditTrails($auditArr);
                $mail = $eCommerceMailObj->sendCustomSizeRequest($detailArray);

            }// db check result end

        } // Validation end 

        echo json_encode(array('result'=>$result,'status'=>$mail['result'], 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));
    }

    if (isset($_POST['send_contact_us_mail'])) {

        $result = 0;
        $error = 0;
        $mail = 0;
        $message = "Failed to send email!";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'email' => 'required',
        ));
        
        $gump->filter_rules(array(
            'name' => 'trim',
            'email' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{
            $detailArray = array();
            $detailArray['name'] = $validated_data['name'];
            $detailArray['email'] = $validated_data['email'];
            $detailArray['subject'] = $validated_data['subject'];
            $detailArray['message'] = $validated_data['message'];

            $mail = $eCommerceMailObj->sendContactUsMail($detailArray);

            if ($mail['result'] == 1) {
                $result = 1;
                $message = 'Mail sent successfully!';
                $error = $mail;

                $auditArr = array(
                    'action' => 'Contact us mail sending',
                    'description' => $message
                );
            }

        } // Validation end 

        echo json_encode(array('result'=>$result,'status'=>$mail['result'], 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));
    }
    
}

?>