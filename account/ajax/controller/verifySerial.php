<?php 
require_once '../../../app/global/url.php';
require_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'/mail/mails.php';

// Page scripts
if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['verify_serial'])){

        $pro_id  = $_POST['pro_id'];
        $serial_number = $_POST['serial_number']; 
        $user_id = $_SESSION['user_id'];
        // $order_no = $_POST['order_no'];
        
        $result = 0;
        $message = "Failed to Search for the serial";
        $serial_id = 0;
        $assignedSerialNumbers = array();
        $select_serial = mysqli_query($localhost, "SELECT sn.*
                                                    FROM `serial_numbers` sn
                                                    INNER JOIN `product_serial` ps ON ps.`serial_id`=sn.`id`
                                                    WHERE ps.`product_id`='$pro_id' ");
        
        $count = mysqli_num_rows($select_serial);
        if ($count != 0) {
            while($fetch_serial = mysqli_fetch_array($select_serial)){
                // array_push($assignedSerialNumbers,array(
                //     'id'=>$fetch_serial['id'],
                //     'serial'=>$fetch_serial['serial_number'],
                //     'verified_status'=>$fetch_serial['verified_status'],
                // ));
                if ($fetch_serial['verified_status'] == 1) {
                    $message = 'This serial number is alerady verified!';
                    $result = 0;
                } else {
                    $serial_id = $fetch_serial['id'];
                    $DBResult['result'] = mysqli_query($localhost,"UPDATE `serial_numbers` SET `order_no`='',`verified_status`= 1,`verified_user`=$user_id WHERE `id`='$serial_id' ");   
    
                    if ($DBResult['result'] == 1) {
                        $result = 1;
                        $message = 'Verification done!';
                    } else {
                        $message = $DBResult;
                    }
                }
            }
        } else {
            $message = 'This product has no serial number!';
        }

        echo json_encode (array("result"=>$result,"message"=>$message));

    } // isset of search_serial_number


    if (isset($_POST['fetch_serial_products'])) {
        $pro_id = 0;
        $serial_number = $_POST['serial_number']; 
        
        $result = 0;
        $message = "Failed to serach for products!";
        $serial_id = 0;
        $assignedSerialNumbers = array();
        $product = 0;
        $verified_status = 0;

        $select = mysqli_query($localhost, "SELECT id FROM `serial_numbers` 
                                                    WHERE `serial_number`='$serial_number' ");
        
        if (mysqli_num_rows($select) > 0) {
            $select_serial = mysqli_query($localhost, "SELECT sn.verified_status,p.`name` AS proname,p.id AS pid
                                                        FROM `serial_numbers` sn
                                                        INNER JOIN `product_serial` ps ON ps.`serial_id`=sn.`id`
                                                        INNER JOIN `products` p ON p.`id`=ps.`product_id`
                                                        WHERE sn.`serial_number`='$serial_number' ");

            $count = mysqli_num_rows($select_serial);
            if ($count != 0) {
                $result = 1;
                $fetch_serial = mysqli_fetch_array($select_serial);
                $pro_id = $fetch_serial['pid'];
                $product = $fetch_serial['proname'];
                $verified_status = $fetch_serial['verified_status'];
            } else {
                $message = 'This serial number has no products!';
            }
        } else {
            $message = 'Please enter a valid serial number!';
        }

        echo json_encode (array("result"=>$result,"message"=>$message,'product'=>$product,'status'=>$verified_status,'pro_id'=>$pro_id));
    }
} // request method

?>