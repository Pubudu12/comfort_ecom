<?php 
include_once '../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['category'])){
        $category_id = $_POST['category'];

        $sub_category_option = "";

        $select_category = mysqli_query($localhost,"SELECT * FROM `ref_sub_categories` WHERE `parent`='$category_id' "); 
        while($fetch_categories = mysqli_fetch_array($select_category)){ 


            $sub_category_option .= '<option value="'.$fetch_categories['id'].'"> '.$fetch_categories['name'] .'</option>';


        }// while

        echo json_encode(array("result"=>$sub_category_option));

    }// isset

    // Product Description
    if(isset($_POST['key'])){
        if($_POST['key'] == "product_content"){

            $result = 0;
            $message = 'Failed to update the content';
            $redirectURL = '';

            $product_id = $_POST['id'];
            $content = mysqli_real_escape_string($localhost, serialize($_POST['data']));
            // $content = json_encode($_POST['data']);

            $dataarray = array(
                'title' => 'content',
                'details' => $content,
                'product_id' => $product_id,
            );

            // Check
            $select = mysqli_query($localhost, "SELECT `id` FROM `product_body` WHERE `product_id` = '$product_id' ");
            if( mysqli_num_rows($select) == 0){
                $DBresult = $dbOpertionsObj->insert('product_body', $dataarray);
            }else{
                $DBresult = $dbOpertionsObj->update('product_body', $dataarray, array('product_id'=>$product_id));
            }

            if($DBresult){
                $result = 1;
                $message = 'Content has been updated successfully';
                $redirectURL = '';
            }
            
            echo json_encode(array("result"=>$result,"message"=>$message, "redirectURL"=>$redirectURL, $DBresult));

        } //csr_content
    } // ISSET KEY

    if(isset($_POST['editor_loadKey'])){
        if($_POST['editor_loadKey'] == 'load_product_content'){

            $id = $_POST['dataId'];

            $select = mysqli_query($localhost, "SELECT `details` FROM `product_body` WHERE `product_id` = '$id' ");
            
            if(mysqli_num_rows($select) > 0){

                $fetch = mysqli_fetch_array($select);

                function reverse_mysqli_real_escape_string($str) {
                    return strtr($str, [
                        '\0'   => "\x00",
                        '\n'   => "\n",
                        '\r'   => "\r",
                        '\\\\' => "\\",
                        "\'"   => "'",
                        '\"'   => '"',
                        '\Z' => "\x1a"
                    ]);
                }
        
                $content = reverse_mysqli_real_escape_string($fetch['details']);
                $content = unserialize($content);
                $content = $content['blocks'];

            }else{
                $content = array();
            }

            echo json_encode(array('data'=>$content));

        }
    }
    // Section Products Details
    if(isset($_POST['addNewSec'])){

        $contentHtmlFile = file_get_contents(ROOT_PATH.'products/container/productDetailsSectionBox.html');
        $contentHtmlFile = str_replace('{{ ROW_ID }}', 0, $contentHtmlFile);
        $contentHtmlFile = str_replace('{{ TITLE }}', '', $contentHtmlFile);
        $contentHtmlFile = str_replace('{{ ORDER }}', 0, $contentHtmlFile);
        $contentHtmlFile = str_replace('{{ CONTENT }}', '', $contentHtmlFile);

        echo json_encode(array('file'=>$contentHtmlFile));

    } // Add new Sec


    if(isset($_POST['get_price_basic_details'])){

        $price_id = $_POST['get_price_basic_details'];

        $select_product_details = mysqli_query($localhost, "SELECT p.`name` product, 
                                                            price.`actual_price`, price.`discount_type`, price.`discount`, price.`sale_price`,price.`dealer_price`,
                                                            s.`name` AS sname,s.`id` s_id
                                                            FROM `price` 
                                                            INNER JOIN `products` AS p ON price.`product_id` = p.`id`
                                                            INNER JOIN `sizes` AS s ON price.`size_id` = s.`id`
                                                            WHERE price.`id` = '$price_id' ");
        $fetch_product_details = mysqli_fetch_array($select_product_details);
        
        $editFormContainer = file_get_contents(ROOT_PATH.'products/container/priceEditForm.html');
        $editFormContainer = str_replace('{{ PRODUCT_NAME }}', $fetch_product_details['product'], $editFormContainer);
        $editFormContainer = str_replace('{{ FORM_URL }}', URL.'products/ajax/controller/updateProductController.php', $editFormContainer);
        $editFormContainer = str_replace('{{ PRICE_ID }}', $price_id, $editFormContainer);
        $editFormContainer = str_replace('{{ PRODUCT_SIZE }}', $fetch_product_details['sname'], $editFormContainer);
        $editFormContainer = str_replace('{{ SIZE_ID }}', $fetch_product_details['s_id'], $editFormContainer);
        $editFormContainer = str_replace('{{ ACTUAL_PRICE }}', $fetch_product_details['actual_price'], $editFormContainer);
        $editFormContainer = str_replace('{{ DEALER_PRICE }}', $fetch_product_details['dealer_price'], $editFormContainer);
        $editFormContainer = str_replace('{{ DISCOUNT_AMOUNT }}', $fetch_product_details['discount'], $editFormContainer);
        $editFormContainer = str_replace('{{ SALE_PRICE }}', $fetch_product_details['sale_price'], $editFormContainer);

        echo json_encode([
            'formContainer' => $editFormContainer
        ]);

    } //get_price_basic_details

    if( isset($_POST['get_price_min_stock_details']) ){

        $price_id = $_POST['get_price_min_stock_details'];
        $p_s_details_arr = array();

        $select_stock = mysqli_query($localhost, "SELECT s.`id` stock_id, s.`qty`, wh.`name` warehouse, wh.`id` warehouse_id 
                                                    FROM `stock` s 
                                                    INNER JOIN `warehouses` AS wh ON wh.`id` = s.`warehouse` 
                                                    WHERE s.`price_id` = '$price_id' ");
        while($fetch_stock = mysqli_fetch_array($select_stock)){
            array_push($p_s_details_arr, array(
                'stock_id' => $fetch_stock['stock_id'],
                'qty' => $fetch_stock['qty'],
                'warehouse' => $fetch_stock['warehouse'],
                'warehouse_id' => $fetch_stock['warehouse_id']
            ));
        }

        echo json_encode( array('stock_details' => $p_s_details_arr) );


    }// get product Stock Min Details


    if(isset($_POST['view_price_discount'])){

        $discountId = trim($_POST['discountId']);
        $select = mysqli_query($localhost, " SELECT * FROM  `pro_discounts` WHERE `id` = '$discountId' ");
        $fetch = mysqli_fetch_array($select);

        $name = $fetch['name'];
        $min_qty = $fetch['min_qty'];
        $discount_type = $fetch['discount_type'];
        $discount_value = $fetch['discount_value'];

        $url = URL.'products/ajax/controller/updateProductController.php';

        $editFormContainer = file_get_contents(ROOT_PATH.'products/container/discountEditForm.html');
        $editFormContainer = str_replace('{{ NAME }}', $name, $editFormContainer);
        $editFormContainer = str_replace('{{ MIN_QTY }}', $min_qty, $editFormContainer);
        $editFormContainer = str_replace('{{ DISCOUNT_TYPE }}', $discount_type, $editFormContainer);
        $editFormContainer = str_replace('{{ DISCOUNT_VALUE }}', $discount_value, $editFormContainer);
        
        $editFormContainer = str_replace('{{ URL }}', $url, $editFormContainer);
        $editFormContainer = str_replace('{{ DISCOUNT_ID }}', $discountId, $editFormContainer);
        
        echo json_encode(['formHtml' => $editFormContainer]);

    } //view_price_discount


} // Post End 

?>