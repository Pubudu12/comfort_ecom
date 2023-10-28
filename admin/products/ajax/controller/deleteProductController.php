<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

include ROOT_PATH.'products/ajax/class/productsCalss.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_product'){

            $pro_id = (int)trim($_POST['id']);
            $deletepro = $productClassObj->deleteProduct($pro_id);
            $auditArr = array(
                'action' => 'Delete Product',
                'description' => $deletepro['message']
            );
            $dbOpertionsObj->auditTrails($auditArr);
            echo json_encode($deletepro);
        }

        if($_POST['delete'] == 'delete_pro_file'){
            $result = 0;
            $message = "Failed to delete the the product";
            $error = 0;

            $pro_id = $_POST['id'];

            $select = mysqli_query($localhost, "SELECT `file_name` FROM `pro_downloads` WHERE `id` = '$pro_id' ");
            $fetch = mysqli_fetch_array($select);
            $filePath = ROOT_PATH.PRO_DOWNLOAD_PATH.$fetch['file_name'];

            if(file_exists($filePath)){
                unlink($filePath);
            }

            // Delete from product
            $DBResult = $dbOpertionsObj->delete('pro_downloads', array('id'=>$pro_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "File has been deleted successfully !";

                $auditArray = array(
                    'action' => 'delete file',
                    'description' =>$message
                    );
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the product";
                $error = $DBResult;
            }
            // $dbOpertionsObj->auditTrails($auditArr);
            echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));

        } //delete_pro_file

        if($_POST['delete'] == 'delete_product_price'){

            $id = $_POST['id'];
            $deletePrice = $productClassObj->deleteProSinglePrice($id);
            echo json_encode($deletePrice);

        } //delete_product_stock

        if($_POST['delete'] == "delete_product_discount"){

            $id = $_POST['id'];
            $deletePrice = $productClassObj->deleteProSingleDiscount($id);
            echo json_encode($deletePrice);

        } // delete_product_discount



        // delete the Price Stock
        if($_POST['delete'] == 'delete_price_stock'){

            $result = 0;
            $error = 0;
            $message = "Failed to delete stock";
            $redirectUrl = null;

            $stock_id = $_POST['id'];


            $select_product_details = mysqli_query($localhost, "SELECT s.`qty`, price.`id` price_id, p.`name` product
                                                            FROM `stock` s 
                                                            INNER JOIN `price` ON price.`id` = s.`price_id`
                                                            INNER JOIN `products` AS p ON price.`product_id` = p.`id`
                                                            WHERE s.`id` = '$stock_id' ");
                
            $fetch_product_details = mysqli_fetch_array($select_product_details);
            $qty = $fetch_product_details['qty'];

            $whereArray = array(
                'id' => $stock_id
            );
            $DBResult = $dbOpertionsObj->delete('stock', $whereArray);

            if($DBResult['result']){

                $result = 1;
                $message = $fetch_product_details['product'].' product stock has been deleted which is contain '.$qty;

                $auditArr = array(
                    'action' => 'Delete Product Stock',
                    'description' => $message
                );

                // $dbOpertionsObj->auditTrails($auditArr);

            }// db check result end

            echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'price_id' => $fetch_product_details['price_id'] ) );

        } //delete_price_stock


    }

    if(isset($_POST['deleteSec'])){

        $result = 0;
        $message = "Failed to delete the the details";
        $error = 0;
        $row_id = $_POST['rowId'];

        // Delete from product
        $DBResult = $dbOpertionsObj->delete('product_body', array('id'=>$row_id));

        if ($DBResult['result'] == 1) {
            $result = 1;
            $message = "Product details has been deleted!";

            $auditArray = array(
                'action' => 'delete details',
                'description' =>$message
                );
        } else {
            $result = 0;
            $message = "Sorry! Failed to delete the product";
            $error = $DBResult;
        }
        // $dbOpertionsObj->auditTrails($auditArr);
        echo json_encode(array('result'=>$result,'message'=>$message,'error'=>$error));

    } //deleteSec

    if(isset($_POST['deletePackThumb'])){


        $result = 0;
        $message = "Please fill the required fields";
        
        $imageId = trim($_POST['imageId']);

        $select = mysqli_query($localhost, "SELECT `name` FROM `product_images` WHERE `id` = '$imageId' ");
        if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_array($select);

            $image_name = URL.PRO_IMG_PATH.$fetch['name'];

            $fullPath = ROOT_PATH.PRO_IMG_PATH.$fetch['name'];
            if(file_exists($fullPath)){
                unlink($fullPath);
            }

            $DBResult = $dbOpertionsObj->delete('product_images', array('id' => $imageId) );

            if($DBResult['result'] == 1){
                $result = 1;
                $message = "Package images has been removed";
            }
        }


        echo json_encode(array("result"=>$result,"message"=>$message));

    } //deletePackThumb

} // Post

?>