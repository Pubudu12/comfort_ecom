<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';
require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';
require_once ROOT_PATH.'serialNumber/ajax/class/serialNumberClass.php';

$dataArray = array();
if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['csv_file_upload'])){

            $result = 0;
            $message = "Failed to upload the file";
            $error = 0;

            // name of the file
            $uploadedFileArray = $_FILES['csv_file'];
            $csvFileDataArray = array();
            $ar = array();
            $f_pointer = fopen($uploadedFileArray['tmp_name'], 'r');
                while(! feof($f_pointer)){
                    $ar = fgetcsv($f_pointer);
                    array_push($csvFileDataArray,$ar);
                }
            $newAddArray = array();
            $final = count($csvFileDataArray) - 1;
            unset($csvFileDataArray[0]);
            unset($csvFileDataArray[$final]);
            $dataArray = $serialNumberOBJ->validateArray($csvFileDataArray);
            $serialized = serialize($dataArray['new_serial_numbers']);
                
            echo json_encode(array('result'=>$result, 'message'=>$message, 'error'=>$error,'data'=>$dataArray,'serialized'=>$serialized));
        // } //validate data

        }


    if(isset($_POST['upload_serial_number_list'])){
        $result = 0;
        $message = "Failed to upload the file";
        $error = 0;
        $dataArray = unserialize($_POST['serial_list']);
        $redirectURL = '';
        // name of the uploaded file
        // $uploadedFileArray = $_FILES['csv_file'];
        // $filename = rand().date("Ymdhi").'serialNumbers.csv';
        // $target_dir = ROOT_PATH.SERIAL_NUMBER_FILE_PATH;
        // // destination of the file on the server
        // $destination = $target_dir.$filename;

        // // get the file extension
        // $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // // the physical file on a temporary uploads directory on the server
        // $file = $uploadedFileArray['tmp_name'];
        // $size = $uploadedFileArray['size'];
        // $ar = array();
        // $csvFileDataArray = array();
        // $dataArray = array();
        // $testArr = array();
        // $f_pointer = 0;
        // if (!in_array($extension, ['csv'])) {
        //     $message = "You file extension must be .csv";
        // } elseif ($uploadedFileArray['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        //     $message = "File too large! it should be less than 10MB";
        // } else {
        //     // move the uploaded (temporary) file to the specified destination
        //     if (move_uploaded_file($file, $destination)) {
        //         $message = "File Moved";
        //         $openCSVfile = ROOT_PATH.SERIAL_NUMBER_FILE_PATH.$filename;
        //     $f_pointer = fopen($file,"r"); // file pointer
        //     } else {
        //         $message = "Failed to upload file.";
        //     }
        // }
        $DBResult = 0;
        foreach ($dataArray as $key => $value) {
            $DBResult = $dbOpertionsObj->insert('serial_numbers', array('name'=>$value['name'],'serial_number'=>$value['serial_number']));
        }
       
        if($DBResult['result'] == 1){
            $result = 1;
            $message = 'New Serial Number(s) created';
            $redirectURL = URL.'serialNumbers';
            $auditArr = array(
                'action' => 'Create Serial Number',
                'description' => $message
            );
            $dbOpertionsObj->auditTrails($auditArr);
        }else{
            $error = $DBResult;
        }// db check result end
        echo json_encode(array('result'=>$result, 'message'=>$message, 'error'=>$error,'data'=>$dataArray));
    }
}

?>