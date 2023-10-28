<?php 

class checkoutClass{
    
    public $localhost;
    public $user_id = 0;
    public $userType;

    public function __construct($localhost){
        $this->localhost = $localhost;

        $this->localhost = $localhost;

        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $select_user = mysqli_query($this->localhost,"SELECT `user_type` FROM `users` WHERE `id`='$this->user_id' ");
            $fetch_user = mysqli_fetch_array($select_user);
            $this->userType = $fetch_user['user_type'];
        }else{
            $this->user_id = $_COOKIE[GUEST_CART_COOKIE_NAME];
            $this->userType = 'guest';
        }

    } // constructor

    private function generateOrderId(){
        $select = mysqli_query($this->localhost,"SELECT `id` FROM `orders` ORDER BY `id` DESC LIMIT 0,1 ");
        $fetch = mysqli_fetch_array($select);
        $order_no = $fetch['id']+1020;
        $order_no .= date("d");

        return $order_no;
    }// generateOrderId


    private function insertUserOrderHistory($user_id,$order_no){
        $user_id = $user_id;

        $insert = mysqli_query($this->localhost,"INSERT `user_std_order_history` (`user_id`,`order_no`) VALUES('$user_id','$order_no') ");

    } //insertUserOrderHistory


    public function updateMainStock($data){

        $product_id = $data['product_id'];
        $qty = $data['qty'];

        $query = "SELECT s.`id`, s.`qty`
                    FROM `price` AS price
                    INNER JOIN `products` AS pro ON pro.`id` = price.`product_id` AND pro.`track_stock` = '1'
                    INNER JOIN `stock` AS s ON s.`price_id` = price.`id` AND s.`out_stock` = 0 AND s.`warehouse_down` = 0 AND s.`qty` > 0
                    WHERE price.`product_id` = '$product_id' ";

        $select_stock = mysqli_query($this->localhost, $query);

        $update_qty = $qty;
        while($fetch_stock = mysqli_fetch_array($select_stock)){

            $stock_id = $fetch_stock['id'];
            $current_available_qty = $fetch_stock['qty'];

            if($current_available_qty > $update_qty){
                $update = mysqli_query($this->localhost, "UPDATE `stock` SET `qty` = qty-$update_qty WHERE `id` = '$stock_id' ");
                if($update){
                    $update_qty -= $update_qty;
                }
            }else{
                $update = mysqli_query($this->localhost, "UPDATE `stock` SET `qty` = qty-$current_available_qty WHERE `id` = '$stock_id' ");
                if($update){
                    $update_qty -= $current_available_qty;
                }
            }

        }// while end 
        
        return true;

    }//updateMainStock

    public function insertOrderedItems($orderNo, $orderdItemsArray)
    {

        $result = 0;
        $message = "Order failed to placed";

        foreach ($orderdItemsArray as $key => $singleItemArray) {
        
            $product_id = $singleItemArray['product_id'];
            
            $qty = $singleItemArray['qty'];
            $rate = $singleItemArray['price'];
            $personalized_text = '';
            $size_id = $singleItemArray['s_id'];

            $discount = $singleItemArray['discount'];
            $amount = $singleItemArray['lineGrand'];

            $update_stock = $this->updateMainStock(array(
                'product_id' => $product_id,
                'qty' => $qty,
            ));
    
            if($update_stock){
                
                $insert_order_items_query = "INSERT INTO `order_items` ( `order_no`, `product_id`, `qty`, `size_id`, `discount`, `rate`, `amount`, `personalized_text`) 
                                                VALUES('$orderNo','$product_id','$qty', '$size_id', '$discount','$rate', '$amount', '$personalized_text') ";

                $insert_order_items = mysqli_query($this->localhost, $insert_order_items_query);

                if($insert_order_items){
                    if($this->userType == "std"){
                        // Std User
                        $this->insertUserOrderHistory($this->user_id,$orderNo);
                    }
                    if($this->userType == "dealer"){
                        // Std User
                        $this->insertUserOrderHistory($this->user_id,$orderNo);
                    }

                    $result = 1;
                    $message = "Order has been placed successfully";

                }else{
                    $message = mysqli_error($this->localhost);
                } // Insert checl

            } // Update stockdone
            
        } // Foreach

        return [
            'result' => $result,
            'message' => $message
        ];


    } //insertOrderedItems

    public function placeOrder($orderDetails){

        $result = 0;
        $title = "Failed";
        $message = "Failed to place the order";

        $name = $orderDetails['name'];
        $phone = $orderDetails['phone'];
        $email = $orderDetails['email'];

        $door_no = $orderDetails['door_no'];
        $city = $orderDetails['city'];
        $district = $orderDetails['district'];
        $state = $orderDetails['state'];

        $country = 'Sri Lanka';
        if (isset($orderDetails['country'])) {
            $country = $orderDetails['country'];
        }
        
        $zip_code = $orderDetails['zip_code'];
        $memo = $orderDetails['memo'];

        $cart_total = $orderDetails['cart_total'];
        $payment = 0;
        $payment_method = $orderDetails['payment_method'];
        $discount_of_promo = 0;
        $shipping_method = $orderDetails['shipping_method'];
        $promo = '';
        $delivery_charges = $orderDetails['delivery_charges'];
        if (isset($orderDetails['coupon_code'])) {
            $promo = $orderDetails['coupon_code'];
            $discount_of_promo = $orderDetails['discount_of_promo'];
        }
        

        $delivery_status = "pending";
        $checkout_date = date("Y-m-d");

        $userType = $this->userType;

        // Total Order Amount
        $total = $cart_total+$delivery_charges;

        $order_no = $this->generateOrderId();
        $today = date('Y-m-d');
        $payment_status = 0;

        // insert orders into this 
        $insert = mysqli_query($this->localhost,"INSERT INTO `orders` (`order_no`,`user_type`,`cart_total`, `delivery_charges`, `total`, `payment`,`payment_method`,`delivery_status`,`checkout_date`) 
                                                        VALUES('$order_no','$userType','$cart_total', '$delivery_charges', '$total', '$payment','$payment_method','$delivery_status','$checkout_date') ");
       
        if($insert){

            $insertItems = $this->insertOrderedItems($order_no, $orderDetails['orderedItems']);

            if($insertItems['result'] == 1){

                $inserd_dd = mysqli_query($this->localhost,"INSERT INTO `delivery_details` (`order_no`,`name`,`mobile_no`,`email`,`door_no`,`city`,`district`,`state`,`country`,`zip_code`,`memo`, `shipping_method`) 
                                                            VALUES('$order_no','$name','$phone','$email','$door_no','$city','$district','$state','$country','$zip_code','$memo', '$shipping_method') ");
                
                $insert_promo = mysqli_query($this->localhost,"INSERT INTO `promocode_usage` (`order_no`,`customer_id`,`promo_code`,`date`,`discounted_amount`) 
                 VALUES('$order_no','$this->user_id','$promo','$today','$discount_of_promo') ");
              
                if($inserd_dd){

                    $result = 1;
                    $title = "Success";
                    $message = "Order has been placed successfully";

                }else{
                    $this->result = 0;
                    $this->message = mysqli_error($this->localhost)."<br>". "INSERT INTO `delivery_details` (`order_no`,`name`,`mobile_no`,`email`,`door_no`,`city`,`district`,`state`,`country`,`zip_code`,`memo`, `shipping_method`) 
                                    VALUES('$order_no','$name','$phone','$email','$door_no','$city','$district','','$country','$zip_code','$memo', '$shipping_method') ";
                }

                $select = mysqli_query($this->localhost,"SELECT `payment` FROM `orders` WHERE `order_no`='$order_no' ");
                $fetch = mysqli_fetch_array($select);
                $payment_status = $fetch['payment'];
                // print_r($payment_status);

            }else{
                $message = $insertItems['message'];
            }

        }// insert order if end
        

        return array("result"=>$result, "title"=>$title, "message"=>$message,"order_no"=>$order_no,'payment_status'=>$payment_status);


    } //placeOrder

    //checkPaymentStatus
    public function checkPaymentStatus($order_no){
        $select = mysqli_query($this->localhost,"SELECT `payment` FROM `orders` WHERE `order_no`='$order_no' ");
        $fetch = mysqli_fetch_array($select);
        $payment_status = $fetch['payment'];
        
        return $payment_status;
        // print_r($payment_status);
    }//checkPaymentStatus
} // checkoutClass

?>