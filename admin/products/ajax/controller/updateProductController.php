<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['update_product'])){

        $result = 0;
        $error = 0;
        $message = "Failed to Update the Product";
        $redirectUrl = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'update_product' => 'required|numeric',
            'min_ord_qty' => 'required|numeric',
            'name' => 'required',
            'product_code' => 'required',
        ));
        
        $gump->filter_rules(array(
            'update_product' => 'trim|sanitize_numbers',
            'min_ord_qty' => 'trim|sanitize_numbers',
            'name' => 'trim',
            'description' => 'trim',
            'product_code' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {

            $threeD = $validated_data['3d_link'];
            if ($validated_data['3d_link'] == '') {
                $threeD = 0;
            }

            $dataArray = array(
                'min_order_qty' => $validated_data['min_ord_qty'],
                'name' => $validated_data['name'],
                'description' => $validated_data['description'],
                'item_code' => $validated_data['product_code'],
                'sub_category'=>$validated_data['sub_category'],
                '3d_link'=>$threeD,
                'upwards_status'=>$validated_data['upwards'],
            );
            
            // if(isset($_POST['change_category_checkbox'])){
                
            //     $subCatArr = $_POST['sub_category'];
            //     $count = count($subCatArr);
            //     $subCategory_id = $subCatArr[$count-1];
            //     $dataArray['sub_category'] = $subCategory_id;

            // }

            $product_id = $validated_data['update_product'];
            $whereArr = array('id' => $product_id);

            $DBResult = $dbOpertionsObj->update('products', $dataArray , $whereArr);
            if($DBResult['result']){

                $result = 1;
                $message = 'Product '.$validated_data['name'].' has been updated';
                
                $redirectURL = URL.'products/view_product.php?id='.$product_id;

                $auditArr = array(
                    'action' => 'Update Product',
                    'description' => $message
                );

                $dbOpertionsObj->auditTrails($auditArr);

            }// db check result end
        }

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));

    }//update Product


    if(isset($_POST['addSection'])){

        $content = $_POST['summerNoteContent'];

        $result = 0;
        $error = 0;
        $message = "Failed to Update the Product";
        $redirectURL = null;
        $rowId = 0;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'title' => 'required',
            'productId' => 'required|numeric',
            'rowId' => 'required|numeric',
            'order' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'title' => 'trim',
            'productId' => 'trim|sanitize_numbers',
            'rowId' => 'trim|sanitize_numbers',
            'order' => 'trim|sanitize_numbers',
            'summerNoteContent' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {

            $product_id = $validated_data['productId'];
            $order = $validated_data['order'];
            $rowId = $validated_data['rowId'];
            $title = $validated_data['title'];

            $dataArray = array(
                'product_id' => $product_id,
                'title' => $title,
                'order' => $order,
                'details' => $content,
            );

            if($rowId != 0){
                $DBResult = $dbOpertionsObj->update('product_body', $dataArray, [
                    'id' => $rowId
                ]);
            }else{
                $DBResult = $dbOpertionsObj->insert('product_body', $dataArray);
                $rowId = $DBResult['id'];
            }
            
            if($DBResult['result'] == 1){

                $result = 1;
                $message = 'Product content has been updated';
                
                $redirectURL = URL.'products/view_product.php?id='.$product_id;

                $auditArr = array(
                    'action' => 'Update Product Details',
                    'description' => $message
                );

                // $dbOpertionsObj->auditTrails($auditArr);

            }else{// db check result end
                $error = $DBResult;
            }

        } //Validations
 

        echo json_encode( array('result'=>$result, 'id' => $rowId, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));

    } //update_product_details

    if(isset($_POST['update_product_discount'])){

        
        $result = 0;
        $error = 0;
        $message = "Failed to create the package";

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'update_product_discount' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
        ));
        
        $gump->filter_rules(array(
            'update_product_discount' => 'trim',
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

            $discount_id = $validated_data['update_product_discount'];

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
                'name' => $name,
                'min_qty' => $validated_data['min_qty'],
                // 'discount_type' => $validated_data['discount_type'],
                'discount_value' => $validated_data['discount_value'],
                'description' => ''
            );
            
            $DBResult = $dbOpertionsObj->update('pro_discounts', $insertData, ['id'=>$discount_id]);
            
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

    if(isset($_POST['product_image_type'])){

        $result = 0;
        $error = 0;
        $message = "Failed to update image type!";

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'imgType' => 'required',
        ));
        
        $gump->filter_rules(array(
            'imgType' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else {
            $img_id = $validated_data['image_id'];

            $updateData = array(
                'type' => $validated_data['imgType'],
            );
            
            $DBResult = $dbOpertionsObj->update('product_images', $updateData, ['id'=>$img_id]);
            
            $error = $DBResult;
            if($DBResult['result']){

                $result = 1;
                $message = 'Image type changed!';

                $auditArr = array(
                    'action' => 'Image type changed!',
                    'description' => $message
                );
                // $dbOpertionsObj->auditTrails($auditArr);

            }// db check result end
        }
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error));

    } //create_product_discount

    // Price & Stock
    // Update Price Here
    if(isset($_POST['create_product_price'])){

        $result = 0;
        $message = "Failed to create the package";
        $error = 0;
        $redirectUrl = null;

        $product_id = $_POST['create_product_price'];

        $price = $_POST['price'];
        $discount_type = $_POST['pro_price_dis_type'];
        $discount_val = $_POST['pro_discount_value'];
        $sizeArray = array();
        foreach ($sizeArray as $key => $value) {
            // $select = mysqli_query($localhost, "SELECT `id` FROM `price` 
            //                                     WHERE `product_id` = '$product_id' AND `size_id`='$value' ");
            // $fetch = mysqli_fetch_array($select);
            // if (mysqli_num_rows($select) > 0) {
            //     $result = 0;
            //     $message = 'Price already exists for this size!';
            // }else{

                $sale_price = $_POST['pro_sale_price'];
                $dataArray = array(
                    'product_id' => $product_id,
                    'size_id' => $value,
                    'actual_price' => $price,
                    'discount_type' => $discount_type,
                    'discount' => $discount_val,
                    'sale_price' => $sale_price,
                    'memo' => null
                );
        
                $DBResult = 0;
                if($countCheck == 0){
                    $DBResult = $dbOpertionsObj->insertData('price', $dataArray);
                    $error = $DBResult;
                }
                // $DBResult = $dbOpertionsObj->insert('price', array('product_id' => $product_id,'size_id' => $value));
            // }
            
        }
        if(isset($DBResult)){
                    if($DBResult['result']==1){
                        $result = 1;
                        $message = 'New product price package has been created';
            
                        $auditArr = array(
                            'action' => 'Create Product Price Package',
                            'description' => $message
                        );
            
                        $dbOpertionsObj->auditTrails($auditArr);
            
                    }// db check result end
                }
        
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error) );

    }// update Price Isset End


    // Update the price of the row
    if(isset($_POST['edit_product_price_id'])){

        $result = 0;
        $error = 0;
        $message = "Failed to update price of the stock";
        $redirectUrl = null;

        $price_id = $_POST['edit_product_price_id'];
        $actual_price = $_POST['actual_price'];
        $discount_type = $_POST['pro_price_dis_type'];
        $dealer_price = $_POST['dealer_price'];
        $discount = $_POST['discount'];
        
        $sale_price = $_POST['sale_price'];

        $select_product_details = mysqli_query($localhost, "SELECT p.`name` product, p.`id` product_id FROM `price` 
                                                INNER JOIN `products` AS p ON price.`product_id` = p.`id`
                                                WHERE price.`id` = '$price_id' ");
        $fetch_product_details = mysqli_fetch_array($select_product_details);


        $updateData = array(
            'actual_price' => $actual_price,
            'discount_type' => $discount_type,
            'discount' => $discount,
            'sale_price' => $sale_price,
            'dealer_price' => $dealer_price
        );

        if(isset($_POST['update_all_rows'])){
            $whereArray = array(
                'product_id' => $fetch_product_details['product_id']
            );
        }else{
            $whereArray = array(
                'id' => $price_id
            );
        }


        $DBResult = $dbOpertionsObj->update('price', $updateData, $whereArray);

        $error = $whereArray;
        if($DBResult['result']){

            $result = 1;
            $message = $fetch_product_details['product'].' product price has been updated';

            $auditArr = array(
                'action' => 'Update Product Price',
                'description' => $message
            );

            // $dbOpertionsObj->auditTrails($auditArr);

        }// db check result end

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error,  'price_id' => $price_id) );

    } //edit_product_price_id
    
    // delete the Price
    if(isset($_POST['delete_price_row'])){

        $result = 0;
        $error = 0;
        $message = "Failed to delete price";
        $redirectUrl = null;

        $price_id = $_POST['delete_price_row'];


        $select_product_details = mysqli_query($localhost, "SELECT p.`name` product, p.`id` product_id FROM `price` 
                                                INNER JOIN `products` AS p ON price.`product_id` = p.`id`
                                                WHERE price.`id` = '$price_id' ");
        $fetch_product_details = mysqli_fetch_array($select_product_details);

        //check the stock table
        $countCheck = $dbOpertionsObj->numbRows('stock', array(
            'price_id' => $price_id,
            'qty' => 0
        ));

        $check_stock = mysqli_query($localhost, "SELECT * FROM `stock` WHERE `price_id` = '$price_id' AND `qty` > 0 ");
        if(mysqli_num_rows($check_stock) > 0){

            // it has some stocjk please delete that stock first
            $message = "Please delete the available stock of this price package";

        }else{

            $whereArray = array(
                'price_id' => $price_id
            );
            $DBResult = $dbOpertionsObj->deleteBYId('stock', $whereArray);

            $whereArray = array(
                'id' => $price_id
            );
            $DBResult = $dbOpertionsObj->deleteBYId('price', $whereArray);
    
            $error = $DBResult;
    
            if($DBResult['result']){
    
                $result = 1;
                $message = $fetch_product_details['product'].' product price has been deleted.';
    
                $auditArr = array(
                    'action' => 'Delete Product Price',
                    'description' => $message
                );
    
                $dbOpertionsObj->auditTrails($auditArr);
    
            }// db check result end
    

        }


        
        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'price_id' => $price_id ) );

    } //delete_price_stock



    if(isset($_POST['update_stock_id'])){

        $result = 0;
        $error = 0;
        $message = "Failed to update stock qty";
        $redirectUrl = null;

        $stock_id = $_POST['update_stock_id'];
        $qty = $_POST['qty'];

        $select_product_details = mysqli_query($localhost, "SELECT s.`qty`, price.`id` price_id, p.`name` product
                                                        FROM `stock` s 
                                                        INNER JOIN `price` ON price.`id` = s.`price_id`
                                                        INNER JOIN `products` AS p ON price.`product_id` = p.`id`
                                                        WHERE s.`id` = '$stock_id' ");
        $fetch_product_details = mysqli_fetch_array($select_product_details);

        $old_qty = $fetch_product_details['qty'];
        $new_qty = $qty;

        $updateData = array(
            'qty' => $new_qty
        );
        $whereArray = array(
            'id' => $stock_id
        );


        $DBResult = $dbOpertionsObj->update('stock', $updateData, $whereArray);

        $error = $DBResult;
        if($DBResult['result']){

            $result = 1;
            $message = $fetch_product_details['product'].' product stock quantity has been updated from '.$old_qty.' to '.$new_qty;

            $auditArr = array(
                'action' => 'Update Product Stock',
                'description' => $message
            );

            // $dbOpertionsObj->auditTrails($auditArr);

        }// db check result end

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error,  'price_id' => $fetch_product_details['price_id']) );

    } //update_price_stock


    if(isset($_POST['update_verification'])){

        $id = $_POST['id'];

        $select = mysqli_query($localhost, "SELECT `active`, `id`, `name` FROM `products` WHERE `id` = '$id' ");
        $fetch = mysqli_fetch_array($select);

        $result = 0;
        $message = "Failed to chnage verification of ".$fetch['name'];
        
        $approved = 1;
        if($fetch['active'] == 1){
            $approved = 0;
        }
        $updateData = array(
            'active' => $approved,
        );
        $whereArray = array(
            'id' => $id
        );
        $DBResult = $dbOpertionsObj->update('products', $updateData, $whereArray);

        $error = $DBResult;
        if($DBResult['result']){

            $result = 1;
            $message = "Product ".$fetch['name']." approval update has been done";

        }// db check result end


        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error) );

    } //update_verification
    

    if(isset($_POST['update_pro_references'])){

        $productId = $_POST['productId'];
        $refId = $_POST['refId'];

        $data = array(
            'product_id' => $productId,
            'reference_id' => $refId,
        );

        $whereArray = array(
            'product_id' => $productId,
            'reference_id' => $refId,
        );


        $select = mysqli_query($localhost, "SELECT rOD2.`id` FROM `references_master_list` AS rML
                                            INNER JOIN `ref_one_dimension` AS rOD ON rOD.`master_id` = rML.`id` AND rOD.`id` = '$refId' 
                                            RIGHT JOIN `ref_one_dimension` AS rOd2 ON rOd2.`master_id` = rML.`id`
                                            WHERE rOD.`master_id` = rML.`id` ");
        $relatedRefIdsArray = array();
        while($fetch = mysqli_fetch_array($select)){
            array_push($relatedRefIdsArray, $fetch['id']);
        }

        $referenceReIdString = join(',',$relatedRefIdsArray);
        $deleteQuery = "DELETE FROM `ref_pro_one2one` WHERE `product_id` = '$productId' AND `reference_id` IN ($referenceReIdString) ";
        $delete = mysqli_query($localhost, $deleteQuery);

        $DBResult = $dbOpertionsObj->insert('ref_pro_one2one', $data);


        $error = $DBResult;
        if($DBResult['result']){

            $result = 1;
            $message = "Brand has been updated";

        }// db check result end


        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error) );

    } //update_pro_references

}