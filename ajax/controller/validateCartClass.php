<?php  



class validateCart{

    public $result, $message, $title;
    public $user_id, $qty, $guest_id, $product_id;
    public $validateArray;

    public function __construct($db,$localhost, $user_type, $user_id){
        $this->db = $db;
        $this->con = $localhost;
        $this->user_id = $user_id;
        $this->user_type = $user_type;
    } // constructor

    public function validateItem($product_id, $qty){

        $this->product_id = $product_id;
        $this->qty = $qty;

        $select = mysqli_query($this->con, "SELECT `id` FROM `price` WHERE `product_id` = '$this->product_id' ");
        $fetch = mysqli_fetch_array($select);

        if(mysqli_num_rows($select) > 0){

            $price_id = $fetch['id'];
            $select = mysqli_query($this->con,"SELECT SUM(`qty`) totalQty FROM `stock` WHERE `price_id`='$price_id' AND `out_stock` = 0 AND `warehouse_down` = 0 ");

            $fetch = mysqli_fetch_array($select);
            $total_qty = $fetch['totalQty'];

            $error = 1;
            $availableQty = $total_qty;
            $message = "We are out of stock";

            if($total_qty == 0){
                
            }else if( $total_qty < $this->qty ){
                
                $message = "We are having ".$total_qty." item left in the stock";

            }else{
                
                $error = 0;
                $message = '';//"Stock Available";
            }
            
            return array('error'=>$error, 'available_qty' => $availableQty, 'message'=>$message);


        }// check num rows


    } //validateItem();


    // Validate Cart Before Place Order Functions
    public function validateCartItems(){

        $this->validateArray = array();

        if($this->user_type == 'std'){

            $select_query = "SELECT cart.`id`, cart.`product_id`, cart.`qty`
                            FROM `cart` AS cart 
                            INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id` 
                            WHERE `user_id`='$this->user_id' ";
        }else{

            // if user not logged in and guest user
            $select_query = "SELECT cart.`id`, cart.`product_id`, cart.`qty`
                            FROM `guest_cart` AS cart 
                            INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id` 
                            WHERE `ip_id`='$this->user_id' ";

        } // check user type if end

        $error = 0;

        $select = mysqli_query($this->con, $select_query);
        while($fetch = mysqli_fetch_array($select)){

            $validateItem = $this->validateItem($fetch['product_id'], $fetch['qty']);

            if($validateItem['error'] == 1){
                $error = 1; 
            }

            array_push($this->validateArray, array(
                'cart_id' => $fetch['id'],
                'product_id' => $fetch['product_id'],
                'qty' => $fetch['qty'],
                'available_qty' => $validateItem['available_qty'],
                'error' => $validateItem['error'],
                'message' => $validateItem['message']
            ));

        } // fetch query


        return array('error'=>$error, 'details' =>$this->validateArray);
    } //validateCartItems

} // validateCart Class End

?>