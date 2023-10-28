<?php 

class cartController{

    public $result,$message,$title;
    public $db,$localhost,$product_id;
    public $select,$fetch,$insert,$num;

    public $user_id,$qty,$guest_id;

    public function __construct($db,$localhost, $product_id, $qty = 1){
        $this->db = $db;
        $this->localhost = $localhost;
        $this->product_id = $product_id;
        $this->qty = $qty;
    } // construction end


    public function checkProductAvailability(){

        $this->result = 0;
        $this->title = "Sorry!";
        $this->message = "We are out of stock";

        $select = mysqli_query($this->localhost, "SELECT `id` FROM `price` WHERE `product_id` = '$this->product_id' ");
        $fetch = mysqli_fetch_array($select);

        if(mysqli_num_rows($select) > 0){

            $price_id = $fetch['id'];
            $select = mysqli_query($this->localhost,"SELECT SUM(`qty`) totalQty FROM `stock` WHERE `price_id`='$price_id' AND `out_stock` = 0 AND `warehouse_down` = 0 ");

            $fetch = mysqli_fetch_array($select);
            $total_qty = $fetch['totalQty'];

            
            if($total_qty == 0){
                
            }else if( $total_qty < $this->qty ){
                
                $this->message = "We are having few items left in the stock";

            }else{
                
                $this->result = 1;
                $this->title = "In Stock";
                $this->message = "Stock Available";
            }


        }// check num rows

        return array("result"=>$this->result, 'message' => $this->message, 'title' => $this->title );
    }


    public function addStdCart($data){

        $this->user_id = $data['user_id'];

        $this->result = 0;
        $this->title = "Sorry!";
        $this->message = "Failed to add product to the cart";

        $checkSelect = mysqli_query($this->localhost,"SELECT `id` FROM `cart` WHERE `user_id`='$this->user_id' AND `product_id`='$this->product_id' ");
        
        if(mysqli_num_rows($checkSelect) == 0){
            
            $this->insert = mysqli_query($this->localhost,"INSERT INTO `cart`(`user_id`,`product_id`,`qty`) VALUES('$this->user_id','$this->product_id','$this->qty') ");

        }else{

            $this->insert = mysqli_query($this->localhost,"UPDATE `cart` SET `user_id`='$this->user_id',`product_id`='$this->product_id',`qty`=qty+$this->qty, WHERE `user_id`='$this->user_id' AND `product_id`='$this->product_id' ");

        }

        if($this->insert){
            $this->result = 1;
            $this->title = "Success!";
            $this->message = "Product has been added to the cart";
        }else{
            // $this->message = mysqli_error($this->localhost);
        }

        return array("result"=>$this->result,"title"=>$this->title,"message"=>$this->message);

    } // addGuestCart

    public function addGuestCart($data){
        
        $this->guest_id = $data['guest_id'];

        $this->result = 0;
        $this->title = "Sorry!";
        $this->message = "Failed to add product to the cart";

        $checkSelect = mysqli_query($this->localhost,"SELECT `id` FROM `guest_cart` WHERE `ip_id`='$this->guest_id' AND `product_id`='$this->product_id' ");
        
        if(mysqli_num_rows($checkSelect) == 0){
            
            $this->insert = mysqli_query($this->localhost,"INSERT INTO `guest_cart`(`ip_id`,`product_id`,`qty`) VALUES('$this->guest_id','$this->product_id','$this->qty') ");

        }else{

            $this->insert = mysqli_query($this->localhost,"UPDATE `guest_cart` SET `ip_id`='$this->guest_id',`product_id`='$this->product_id',`qty`=qty+$this->qty WHERE `ip_id`='$this->guest_id' AND `product_id`='$this->product_id' ");

        }

        if($this->insert){
            $this->result = 1;
            $this->title = "Success!";
            $this->message = "Product has been added to the cart";
        }else{
            $this->message = mysqli_error($this->localhost);
        }

        return array("result"=>$this->result,"title"=>$this->title,"message"=>$this->message);

    } // addGuestbag


    public function addWishlist($data){

        $this->user_id = $data['user_id'];

        $this->result = 0;
        $this->title = "Sorry!";
        $this->message = "Failed to add product to the wishlist";


        $checkSelect = mysqli_query($this->localhost,"SELECT `id` FROM `wishlist` WHERE `user_id`='$this->user_id' AND `product_id`='$this->product_id' ");
        
        if(mysqli_num_rows($checkSelect) == 0){
            
            $this->insert = mysqli_query($this->localhost,"INSERT INTO `wishlist`(`user_id`,`product_id`) VALUES('$this->user_id','$this->product_id') ");

        }else{

            $this->message = "Product already added to the wishlist";

        }

        if($this->insert){
            $this->result = 1;
            $this->title = "Success!";
            $this->message = "Product has been added to the wishlist";
        }

        return array("result"=>$this->result,"title"=>$this->title,"message"=>$this->message);

    } // addWishlist end 


} // Cartcontroller class 


class validateCart{

    public $result,$message,$title;
    public $user_id,$qty,$guest_id;

    public function __construct($db,$localhost){
        $this->db = $db;
        $this->localhost = $localhost;
    } // constructor

    // Validate Cart Before Place Order Functions
    public function validateCartItems(){

    } //validateCartItems

} // validateCart Class End


?>