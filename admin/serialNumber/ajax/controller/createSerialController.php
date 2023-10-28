
<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['create_serial'])){
        $result = 0;
        $error = 0;
        $message = "Failed to create Serial Number";
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

            $insertData = array(
                'name' => $validated_data['name'],
                'serial_number' => $validated_data['serial'],
            );

            $DBResult = $dbOpertionsObj->insert('serial_numbers', $insertData);
            if($DBResult['result'] == 1){
                $result = 1;
                $message = 'New Serial Number has been created';
                $redirectURL = URL.'serialNumbers';
                $auditArr = array(
                    'action' => 'Create Serial Number',
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

if (isset($_GET['path'])) {
    //Read the filename
    $filename = $_GET['path'];
    $path = ROOT_PATH.'serialNumber/downloadSampleFile/samplecsv.csv';
    //Check the file exists or not
    if(file_exists($path)) {
    //Define header information
        // header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        // header("Cache-Control: no-cache, must-revalidate");
        // header("Expires: 0");
        // header('Content-Disposition: attachment; filename="'.basename($path).'"');
        // header('Content-Length: ' . filesize($path));
        // header('Pragma: public');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Type: application/octet-stream"); 
        header("Content-type: application/force-download");

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($path);

        //Terminate from the script
        die();
    } else{
        echo "File does not exist.";
    }
}