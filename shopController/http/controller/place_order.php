<?php 

class order{
    
    public $result,$message,$title;
    public $db,$localhost;
    public $select,$fetch,$insert,$num,$order_no;

    public function __construct($localhost,$db){
        $this->localhost = $localhost;
        $this->db = $db;
    } // constructor

    private function generateOrderId(){
        $this->select = mysqli_query($this->localhost,"SELECT `id` FROM `orders` ORDER BY `id` DESC LIMIT 0,1 ");
        $this->fetch = mysqli_fetch_array($this->select);
        $this->order_no = $this->fetch['id']+1020;
        $this->order_no .= date("d");

        return $this->order_no;
    }// generateOrderId


    private function insertUserOrderHistory($user_id,$order_no){
        $user_id = $user_id;
        $this->order_no = $order_no;

        $this->insert = mysqli_query($this->localhost,"INSERT `user_std_order_history` (`user_id`,`order_no`) VALUES('$user_id','$this->order_no') ");

    } //insertUserOrderHistory


    public function updateMainStock($data){

        $product_id = $data['product_id'];
        $qty = $data['qty'];

        $select_stock = mysqli_query($this->localhost, "SELECT s.`id`, s.`qty`
                                                    FROM `price` AS price
                                                    INNER JOIN `stock` AS s ON s.`price_id` = price.`id` AND s.`out_stock` = 0 AND s.`warehouse_down` = 0 AND s.`qty` > 0
                                                    WHERE price.`product_id` = '$product_id' ");

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


            if($update_qty == 0){
            }

        }// while end 
        
        if($update_qty == 0){
            return true;
        }else{
            return false;
        }

    }//updateMainStock

    public function placeOrder($orderDetails){

        $this->result = 0;
        $this->title = "Failed";
        $this->message = "Failed to place the order";

        $name = $orderDetails['name'];
        $phone = $orderDetails['phone'];
        $email = $orderDetails['email'];

        $door_no = $orderDetails['door_no'];
        $city = $orderDetails['city'];
        $district = $orderDetails['district'];
        $state = $orderDetails['state'];
        $country = $orderDetails['country'];
        $zip_code = $orderDetails['zip_code'];

        $memo = $orderDetails['memo'];

        $user_type = $orderDetails['user_type'];

        $cart_total = $orderDetails['cart_total'];
        $payment = 0;
        $payment_method = $orderDetails['payment_method'];

        $shipping_method = $orderDetails['shipping_method'];
        
        $delivery_charges = $orderDetails['delivery_charges'];
        

        $delivery_status = "pending";
        $checkout_date = date("Y-m-d");


        // Total Order Amount
        $total = $cart_total+$delivery_charges;

        $this->order_no = order::generateOrderId();

        // insert orders into this 
        $this->insert = mysqli_query($this->localhost,"INSERT INTO `orders` (`order_no`,`user_type`,`cart_total`, `delivery_charges`, `total`, `payment`,`payment_method`,`delivery_status`,`checkout_date`) 
                                                        VALUES('$this->order_no','$user_type','$cart_total', '$delivery_charges', '$total', '$payment','$payment_method','$delivery_status','$checkout_date') ");
        
        if($this->insert){
            

            if( $orderDetails['user_access'] == 1 ){
                // stdanadard user
                $user_id = $orderDetails['user_id'];

                $items_fetch_query = "SELECT cart.`id`, cart.`product_id`, cart.`qty`, price.`sale_price` price
                                FROM `cart` AS cart 
                                INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id`
                                WHERE `user_id`='$user_id' ";

                order::insertUserOrderHistory($user_id,$this->order_no);

                // Delete shoud happen after inserted items on order items table
                $delete_cart_products_query = "DELETE FROM `cart` WHERE `user_id`='$user_id' ";

            }else{
                // guest user
                $guest_id = $orderDetails['guest_id'];

                $items_fetch_query = "SELECT cart.`id`, cart.`product_id`, cart.`qty`, price.`sale_price` price
                                FROM `guest_cart` AS cart 
                                INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id`
                                WHERE `ip_id`='$guest_id' ";

                // Delete shoud happen after inserted items on order items table
                $delete_cart_products_query = "DELETE FROM `guest_cart` WHERE `guest_id`='$guest_id' ";

            }

            $select_cart_products = mysqli_query($this->localhost, $items_fetch_query);
            while( $fetch_items = mysqli_fetch_array($select_cart_products) ){

                $product_id = $fetch_items['product_id'];
                
                $qty = $fetch_items['qty'];
                $rate = $fetch_items['price'];
                $personalized_text = '';

                $amount = $qty*$rate;

                // Reduce the order QTY from the Main Stock Here
                $update_stock = $this->updateMainStock(array(
                    'product_id' => $product_id,
                    'qty' => $qty,
                ));

                if($update_stock){
                    $insert_order_items_query = "INSERT INTO `order_items` ( `order_no`, `product_id`, `qty`, `rate`, `amount`, `personalized_text`) VALUES('$this->order_no','$product_id','$qty','$rate','$amount', '$personalized_text') ";
                    $insert_order_items = mysqli_query($this->localhost,$insert_order_items_query);
                }
                


            } // while end for fetch cart items

            if($insert_order_items){
                mysqli_query($this->localhost,$delete_cart_products_query);
                $inserd_dd = mysqli_query($this->localhost,"INSERT INTO `delivery_details` (`order_no`,`name`,`mobile_no`,`email`,`door_no`,`city`,`district`,`state`,`country`,`zip_code`,`memo`, `shipping_method`) 
                                                        VALUES('$this->order_no','$name','$phone','$email','$door_no','$city','$district','$state','$country','$zip_code','$memo', '$shipping_method') ");
                $this->result = 1;
                $this->title = "Success";
                $this->message = "Order has been placed successfully";


                if($inserd_dd){

                }else{
                    $this->result = 0;
                    $this->message = mysqli_error($this->localhost)."<br>". "INSERT INTO `delivery_details` (`order_no`,`name`,`mobile_no`,`email`,`door_no`,`city`,`district`,`state`,`country`,`zip_code`,`memo`, `shipping_method`) 
                    VALUES('$this->order_no','$name','$phone','$email','$door_no','$city','$district','$state','$country','$zip_code','$memo', '$shipping_method') ";
                }

            }else{
                mysqli_error($this->localhost);
            }

            

        }// insert order if end
        

        return array("result"=>$this->result, "title"=>$this->title, "message"=>$this->message,"order_no"=>$this->order_no);


    } //placeOrder

} // order class end 

require_once ROOT_PATH.'ajax/controllers/validateCartClass.php';

if($_SERVER['REQUEST_METHOD'] == "POST" ) {

    if(isset($_POST['checkout'])){

        // initiaze class of order
        $order_obj = new order($localhost,$database);

        $orderDetails['name'] = NumberValidation($localhost,$_POST['name']);
        $orderDetails['phone'] = NumberValidation($localhost,$_POST['phone']);
        $orderDetails['email'] = NumberValidation($localhost,$_POST['email']);

        $orderDetails['door_no'] = NumberValidation($localhost,$_POST['door_no']);
        $orderDetails['city'] = NumberValidation($localhost,$_POST['city']);
        $orderDetails['district'] = NumberValidation($localhost,$_POST['district']);
        $orderDetails['state'] = NumberValidation($localhost,$_POST['state']);
        $orderDetails['country'] = NumberValidation($localhost,$_POST['country']);
        $orderDetails['zip_code'] = NumberValidation($localhost,$_POST['zip_code']);

        $orderDetails['memo'] = NumberValidation($localhost, $_POST['memo']);
        $orderDetails['shipping_method'] = NumberValidation($localhost,$_POST['shipping_method']);
        

        $getUserType = checkUserAccess();

        $orderDetails['user_type'] = $getUserType['user_type'];
        $orderDetails['user_access'] = $getUserType['access'];

        $validate_user_type = 'guest';
        $validate_user_id = 0;

        if($orderDetails['user_access'] == 1){
            
            $user_id = $_SESSION['user_id'];
            $orderDetails['user_id'] = $user_id;

            $validate_user_type = 'std';
            $validate_user_id = $user_id;

            $items_fetch_query = "SELECT SUM(price.`sale_price`*cart.`qty`) AS total
            FROM `cart` AS cart 
            INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id`
            WHERE `user_id`='$user_id' ";
        
        }elseif($orderDetails['user_access'] == 2){
            
            $user_id = $_SESSION['user_id'];
            $orderDetails['user_id'] = $user_id;

            $validate_user_type = 'dealer';
            $validate_user_id = $user_id;

            $items_fetch_query = "SELECT SUM(price.`dealer_price`*cart.`qty`) AS total
            FROM `cart` AS cart 
            INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id`
            WHERE `user_id`='$user_id' ";

        }else{

            $guest_id = $_COOKIE[GUEST_CART_COOKIE_NAME];
            $orderDetails['guest_id'] = $guest_id;

            $validate_user_type = 'guest';
            $validate_user_id = $guest_id;

            $items_fetch_query = "SELECT SUM(price.`sale_price`*cart.`qty`) AS total
            FROM `guest_cart` AS cart 
            INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id`
            WHERE `ip_id`='$guest_id' ";
        }

        $select_products = mysqli_query($localhost, $items_fetch_query);
        $fetch_products = mysqli_fetch_array($select_products);

        $orderDetails['cart_total'] = $fetch_products['total'];

        $orderDetails['delivery_charges'] = $shipping_charges_array['shipping_charges']; // From App/Class/calculateOtherCharges.php

        $payment = 0;
        $orderDetails['payment_method'] = NumberValidation($localhost,$_POST['payment_option']);

        $result = 0;
        $title = "Failed";
        $message = "It may subjected to an unavailability of the product at the time of order placing";
        $order_no = 0;

        if( trim($orderDetails['cart_total']) > 0 ){

            $validateCartObj = new validateCart($database, $localhost, $validate_user_type, $validate_user_id);
            $validate = $validateCartObj->validateCartItems();

            if($validate['error'] == 0){
                $place_order = $order_obj->placeOrder($orderDetails);

                $result = $place_order['result'];
                $title = $place_order['title'];
                $message = $place_order['message'];
                $order_no = $place_order['order_no'];

            }else{

                $result = 0;
                $title = 'Failed';
                $message = 'Please check the cart before place the order';

            }
            
            
        } // if end for check total 


        if($getUserType['access'] == 1){
            $url = URL."account/view_order.php?order_no=".$order_no;
        }else{
            $url = URL."account/view_order.php?order_no=".$order_no."&email=".$orderDetails['email'];
        }

        if( strtolower($orderDetails['payment_method']) != "cod" ){
            $url .= "&paynow=".$orderDetails['payment_method'];
        }

        if($result == 1){

            if( strtolower($orderDetails['payment_method']) == "cod" ){
                // send the mail now
                // its COD 
                $config = array(
                'order_no' => $order_no
                );
                $result = $eCommerceMailObj->invoice($order_no);
                
            }else{
                // $url = URL."account/payment_processing.php?paynow=card&order_no=".$order_no;
            }

            // order placed successfully send mail

            ?>
            <script>
                window.location = '<?php echo $url ?>';
            </script>
            <?php

        }else{
            $checkout_failed = $message;
        } // check result if end
        

    }// isset end 

}// request method


?>