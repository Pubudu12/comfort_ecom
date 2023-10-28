<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_product'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create the Product";
        $redirectURL = URL.'products/products.php';

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name' => 'required',
            'min_ord_qty' => 'required',
        ));
        
        $gump->filter_rules(array(            
            'name' => 'trim',
            'min_ord_qty' => 'trim',
            'description' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {
            $select_last_id = mysqli_query($localhost, "SELECT `id` FROM `products` ORDER BY `id` DESC LIMIT 0,1 ");
            $fetch_last_id = mysqli_fetch_array($select_last_id);

            $subCatArr = $_POST['sub_category'];
            $count = count($subCatArr);
            $subCategory_id = $subCatArr[$count-1];
            

            $product_code = ($fetch_last_id['id']+1);
            $product_code = 'PR000/'.$product_code;
            $threeD = $validated_data['3d_link'];
            if ($validated_data['3d_link'] == '') {
                $threeD = 0;
            }

            $insertData = array(
                'name' => $validated_data['name'],
                'min_order_qty' => $validated_data['min_ord_qty'],
                'sub_category' => $subCategory_id,
                'description' => $validated_data['description'],
                'item_code' => $product_code,
                'active' => 1,
                '3d_link'=>$threeD,
                'exclusive' => 0,
                'track_stock' => 1,
                'weight_g' => 0,
                'upwards_status'=>$validated_data['upwards'],
                'general' => 0,
                'approved' => 1,
            );
            
            $DBResult = $dbOpertionsObj->insert('products', $insertData);
            
            $error = $DBResult;
            if($DBResult['result']){

                $result = 1;
                $message = 'New Product '.$validated_data['name'].' has been created';

                $redirectURL = URL.'products/products.php?id='.$DBResult['id'];
                // $redirectURL = URL.'products/upload_images.php?id='.$DBResult['id'];

                $auditArr = array(
                    'action' => 'Create Product',
                    'description' => $message
                );
                $dbOpertionsObj->auditTrails($auditArr);

            }// db check result end
        }
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));
    }//add Product


    if(isset($_POST['upload_image'])){

        $result = 0;
        $message = "Failed to changes the product thumb";
        $error = 0;
        $imgBox = '';

        $product_id = $_POST['upload_image'];
        $img_type = $_POST['img_type'];
        $imageFile = $_FILES['img_name'];

        switch ($img_type) {
            case 'thumb':
                $newWidth = 1500;
                break;

            case 'cover':
                $newWidth = 1500;
                break;

            case 'default':
                $newWidth = 1500;
                break;
            
            default:
                $newWidth = 1500;
                break;
        }

        if(isset($imageFile['name']) ) {

            if(strlen($imageFile['name']) > 0 ) {
                
                $path = ROOT_PATH.PRO_IMG_PATH;
                
                $pass_parm = storeUploadedImage($path, $imageFile, $newWidth, null,'default-');

                if($pass_parm['error'] == 0){
                    
                    $result = 1;
                    $message = "Product images has been uploaded";
                    $file_to_save = $pass_parm['filename'];

                    // Insert new Pic
                    $insertData = array(
                        'product_id' => $product_id,
                        'name' => $file_to_save,
                        'type' => $img_type
                    );

                    $DBResult = $dbOpertionsObj->insert('product_images', $insertData);
                    
                    if($DBResult['result']){

                        $result = 1;
                        $message = 'Product image has been changed';

                        $imgBoxContainer = file_get_contents(ROOT_PATH.'products/container/imgUploadCardContainer.html');
                        
                        $imgBoxContainer = str_replace('{{ IMG_NAME }}', URL.PRO_IMG_PATH.$file_to_save,  $imgBoxContainer);
                        $imgBoxContainer = str_replace('{{ IMG_ID }}', $DBResult['id'],  $imgBoxContainer);
                        $imgBoxContainer = str_replace('{{ IMGTYPE }}', $img_type,  $imgBoxContainer);

                        $imgBox = $imgBoxContainer;

                        $auditArr = array(
                            'action' => 'Upload Product Default Image',
                            'description' => $message
                        );


                    }// db check result end


                }else{
                    $message = $pass_parm['message'];
                }

            } // If Issey

        } // If end 


        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'imgBox'=>$imgBox) );

    } // upload_image


    if(isset($_POST['upload_document'])){

        $result = 0;
        $message = "Failed to upload the file";
        $error = 0;

        $product_id = $_POST['upload_document'];
        $name = trim($_POST['name']);
        if(strlen($name)==0){
            $name = "Document";
        }


        // name of the uploaded file
        $uploadedFileArray = $_FILES['pdf_document'];
        $filename = rand().date("Ymdhi").'pro_download.pdf';

        $target_dir = ROOT_PATH.PRO_DOWNLOAD_PATH;

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // destination of the file on the server
        $destination = $target_dir.$filename;

        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // the physical file on a temporary uploads directory on the server
        $file = $uploadedFileArray['tmp_name'];
        $size = $uploadedFileArray['size'];

        if (!in_array($extension, ['pdf', 'docx'])) {

            $message = "You file extension must be .pdf or .docx";

        } elseif ($uploadedFileArray['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
            $message = "File too large! it should be less than 10MB";
        } else {
            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination)) {

                $dataArray = [
                    'name' => $name,
                    'product_id' => $product_id,
                    'file_name' => $filename,
                ];

                $DBResult = $dbOpertionsObj->insert('pro_downloads', $dataArray);
                if($DBResult['result'] == 1){

                    $result = 1;
                    $message = "File has been uploaded successfully";

                }

            } else {
                $message = "Failed to upload file.";
            }
        }


        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error) );

    } //upload_document

    //product price creation
    if(isset($_POST['create_product_price'])){

        $result = 0;
        $error = 0;
        $DBResult = 0;
        $message = "Failed to create the package";
        $redirectUrl = '';

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'create_product_price' => 'required|numeric',
            'pro_actual_price' => 'required|numeric',
            'pro_price_dis_type' => 'required',
            'pro_discount_value' => 'required',
            'pro_dealer_price' => 'required',
            'pro_sale_price' => 'required',
        ));
        
        $gump->filter_rules(array(
            'create_product_price' => 'trim',
            'pro_actual_price' => 'trim',
            'pro_price_dis_type' => 'trim',
            'pro_dealer_price' => 'trim',
            'pro_discount_value' => 'trim',
            'pro_sale_price' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {

            $product_id = $validated_data['create_product_price'];

           
            $sizeArray = $_POST['sizes'];
            foreach ($sizeArray as $key => $value) {
    
                $select = mysqli_query($localhost, "SELECT `id` FROM `price` 
                                                    WHERE `product_id` = '$product_id' AND `size_id`='$value' ");
                $fetch = mysqli_fetch_array($select);
                if (mysqli_num_rows($select) > 0) {
                    $result = 0;
                    $message = 'Price already exists for this size!';
                }else{

                    $sale_price = $_POST['pro_sale_price'];
                    $insertData = array(
                        'product_id' => $product_id,
                        'size_id'=>$value,
                        'actual_price' => $validated_data['pro_actual_price'],
                        'discount_type' => $validated_data['pro_price_dis_type'],
                        'discount' => $validated_data['pro_discount_value'],
                        'sale_price' => $validated_data['pro_sale_price'],
                        'dealer_price' => $validated_data['pro_dealer_price'],
                        'memo' => null
                    );
            
                    $DBResult = $dbOpertionsObj->insert('price', $insertData);
                    $error = $DBResult;
                        
                }
                
            }
            $redirectUrl = URL.'products/view_product.php?id='.$product_id;
            if(isset($DBResult)){
                if($DBResult['result']==1){
                    $result = 1;
                    $message = 'New product price package has been created';
                    $redirectUrl = URL.'products/view_product.php?id='.$product_id;
        
                    $auditArr = array(
                        'action' => 'Create Product Price Package',
                        'description' => $message
                    );
        
                    $dbOpertionsObj->auditTrails($auditArr);
        
                }// db check result end
            }
            // $DBResult = $dbOpertionsObj->insert('price', $insertData);
            
            // $error = $DBResult;
            // if($DBResult['result']){

            //     $result = 1;
            //     $message = 'New product price package has been created';

            //     $auditArr = array(
            //         'action' => 'Create Product Price Package',
            //         'description' => $message
            //     );
            //     // $dbOpertionsObj->auditTrails($auditArr);

            // }// db check result end
        }
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectUrl));

    }//add Product

    if(isset($_POST['create_product_discount'])){

        
        $result = 0;
        $error = 0;
        $message = "Failed to create the package";

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'create_product_discount' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'create_product_discount' => 'trim',
            'name' => 'trim',
            'min_qty' => 'trim',
            'discount_type' => 'trim',
            'discount_value' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {

            $product_id = $validated_data['create_product_discount'];

            $name = $validated_data['name'];
                if(strlen($name) == 0){
                    if($validated_data['discount_type'] == '/'){
                        $disText = "flat ".number_format($validated_data['discount_value']).' off';
                    }else{
                        $disText = number_format($validated_data['discount_value']).'% off';
                    }
                    $name = "Order minimum ".$validated_data['min_qty']." qty to get ".$disText;
                }

            $insertData = array(
                'product_id' => $product_id,
                'name' => $name,
                'min_qty' => $validated_data['min_qty'],
                'discount_type' => $validated_data['discount_type'],
                'discount_value' => $validated_data['discount_value'],
                'description' => ''
            );
            
            $DBResult = $dbOpertionsObj->insert('pro_discounts', $insertData);
            
            $error = $DBResult;
            if($DBResult['result']){

                $result = 1;
                $message = 'New product discount has been created';

                $auditArr = array(
                    'action' => 'Create Product Discount Package',
                    'description' => $message
                );
                // $dbOpertionsObj->auditTrails($auditArr);

            }// db check result end
        }
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error));

    } //create_product_discount

    // Stock Management
    if(isset($_POST['add_pro_new_stock'])){

        $result = 0;
        $error = 0;
        $message = "Failed to add the stock";
        $redirectUrl = null;

        $product_id = $_POST['add_pro_new_stock'];
        $warehouse = $_POST['warehouse'];
        $qty = $_POST['qty'];


        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'add_pro_new_stock' => 'required|numeric',
            'warehouse' => 'required|alpha_numeric',
            'qty' => 'required|alpha_numeric|min_len,1'
        ));
        
        $gump->filter_rules(array(
            'add_pro_new_stock' => 'trim|sanitize_numbers',
            'warehouse' => 'trim|sanitize_numbers',
            'qty' => 'trim|sanitize_numbers'
        ));
        
        $validated_data = $gump->run($_POST);

        if($validated_data === false) {
            
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";

        }else{
            // validation end insert data
            $insertData = $validated_data;

            $insertData = array(
                'price_id' => $validated_data['add_pro_new_stock'],
                'warehouse' => $validated_data['warehouse'],
                'qty' => $validated_data['qty'],
                'min_alert' => 10,
                'out_stock' => 0,
                'warehouse_down' => 0
            );

            $countCheck = $dbOpertionsObj->count('stock', array(
                'price_id' => $validated_data['add_pro_new_stock'],
                'warehouse' => $validated_data['warehouse']
            ));

            if($countCheck == 0){


                $DBResult = $dbOpertionsObj->insert('stock', $insertData);


                if($DBResult['result']){

                    //fetch details of product
                    $price_id = $validated_data['add_pro_new_stock'];
                    $select_product_details = mysqli_query($localhost, "SELECT p.`name` product FROM `price` 
                                                            INNER JOIN `products` AS p ON price.`product_id` = p.`id`
                                                            WHERE price.`id` = '$price_id' ");
                    $fetch_product_details = mysqli_fetch_array($select_product_details);


                    $result = 1;
                    $message = 'New stock '.$validated_data['qty'].' has been added to the product '.$fetch_product_details['product'];

                    $auditArr = array(
                        'action' => 'Create Product Stock',
                        'description' => $message
                    );

                    // $dbOpertionsObj->auditTrails($auditArr);

                }// db check result end


            }else{
                $message = "This packages already have stock in the warehouse you added. Please update the stock in the below table";
            }

            


        } // validation check

        
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error) );


    }// isset add_pro_new_stock


    // assign serial numbers to products
    if (isset($_POST['assign_serial_numbers'])) {
        $result = 0;
        $error = 0;
        $message = "Failed to assign the serial number";
        $product_id = $_POST['product_id'];
        $redirectUrl = URL.'products/assignSerialNumbers.php?id='.$product_id;
      
        $serialNumArray = $_POST['serialNumbers'];
        $DBResult = 0;
        foreach ($serialNumArray as $key => $value) {
            $select = mysqli_query($localhost, "SELECT `id` FROM `product_serial` 
                                                WHERE `product_id` = '$product_id' AND `serial_id`='$value' ");
            $fetch = mysqli_fetch_array($select);
            if ($fetch == null) {
                $DBResult = $dbOpertionsObj->insert('product_serial', array('product_id' => $product_id,'serial_id' => $value));
            }else{
                $result = 0;
                $message = 'Serial Numbers already exists for the product!';
            }
        }
        if ($DBResult['result']) {
            $result = 1;
            $message = 'Serial Number assigned for this product';
        }

        $auditArr = array(
            'action' => 'Add serial number to the product',
            'description' => $message
        );
        // $dbOpertionsObj->auditTrails($auditArr);

        echo json_encode(array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectUrl));
    }

    //delete serial Numbers
    if (isset($_POST['delete_serial_numbers'])) {
        $result = 0;
        $error = 0;
        $message = "Failed to add the serial number";
        $product_id = $_POST['product_id'];
        $redirectUrl = URL.'products/assignSerialNumbers.php?id='.$product_id;

        $pro_serial_id = $_POST['pro_serial_id']; 
    
        $DBResult = $dbOpertionsObj->delete('product_serial', array('id'=>$pro_serial_id));

        if($DBResult['result']){
            $result = 1;
            $message = 'Serial number deleted';

            $auditArr = array(
                'action' => 'Delete serial number to the product',
                'description' => $message
            );
            // $dbOpertionsObj->auditTrails($auditArr);
        }// db check result end
        echo json_encode(array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectUrl));
    }

    //assign dealer to product
    if (isset($_POST['assign_dealers'])) {
        $result = 0;
        $error = 0;
        $message = "Failed to assign the Dealer";
        $product_id = $_POST['product_id'];
        $redirectUrl = URL.'products/assignDealers.php?id='.$product_id;

        $dealerArray = $_POST['dealers'];
        $DBResult = 0;
        foreach ($dealerArray as $key => $value) {
            $select = mysqli_query($localhost, "SELECT `id` FROM `product_dealers` 
                                                WHERE `product_id` = '$product_id' AND `dealer_id`='$value' ");
            $fetch = mysqli_fetch_array($select);
            if ($fetch == null) {
                $DBResult = $dbOpertionsObj->insert('product_dealers', array('product_id' => $product_id,'dealer_id' => $value));
            }else{
                $result = 0;
                $message = 'Dealers already exists for the product!';
            }
        }
        if ($DBResult['result']) {
            $result = 1;
            $message = 'Dealer assigned for this product';
        }

        $auditArr = array(
            'action' => 'Assign Dealer to the product',
            'description' => $message
        );
        // $dbOpertionsObj->auditTrails($auditArr);
        echo json_encode(array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectUrl));
    }

     //assign dealer to product
     if (isset($_POST['assign_sizes'])) {
        $result = 0;
        $error = 0;
        $message = "Failed to assign the Dealer";
        $product_id = $_POST['product_id'];
        $redirectUrl = URL.'products/assignDealers.php?id='.$product_id;

        $dealerArray = $_POST['dealers'];
        $DBResult = 0;
        foreach ($dealerArray as $key => $value) {
            $select = mysqli_query($localhost, "SELECT `id` FROM `product_dealers` 
                                                WHERE `product_id` = '$product_id' AND `dealer_id`='$value' ");
            $fetch = mysqli_fetch_array($select);
            if ($fetch == null) {
                $DBResult = $dbOpertionsObj->insert('product_dealers', array('product_id' => $product_id,'dealer_id' => $value));
            }else{
                $result = 0;
                $message = 'Dealers already exists for the product!';
            }
        }
        if ($DBResult['result']) {
            $result = 1;
            $message = 'Dealer assigned for this product';
        }

        $auditArr = array(
            'action' => 'Assign Dealer to the product',
            'description' => $message
        );
        // $dbOpertionsObj->auditTrails($auditArr);
        echo json_encode(array('result'=>$result, 'message'=>$message, 'error'=>$error,'redirectURL'=>$redirectUrl));
    }

    //delete dealers from product
    if (isset($_POST['delete_dealer'])) {
        $result = 0;
        $error = 0;
        $message = "Failed to delete the dealer";
        $redirectUrl = null;

        $pro_dealer_id = $_POST['pro_dealer_id'];
    
        $DBResult = $dbOpertionsObj->delete('product_dealers', array('id'=>$pro_dealer_id));

        if($DBResult['result']){
            $result = 1;
            $message = 'Dealer deleted';

            $auditArr = array(
                'action' => 'Delete Dealer from the product',
                'description' => $message
            );
            // $dbOpertionsObj->auditTrails($auditArr);
        }// db check result end
        echo json_encode(array('result'=>$result, 'message'=>$message, 'error'=>$error));
    }
} // POST

?>