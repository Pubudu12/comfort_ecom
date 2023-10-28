<?php
require_once ROOT_PATH.'app/controllers/class/productsClass.php';
class cartClass extends productClass{

    public $localhost, $result, $message;
    public $user_id = 0;
    public $userType;

    public function __construct($localhost){
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

    } // construction end


    public function checkProductAvailability($productId, $orderedQty,$size_id){

        $result = 1;
        $title = "Sorry!";
        $message = "We are out of stock";

        $totalQty = $this->getProductQty($productId,$size_id);

        if($totalQty != 0){
            
            if( $totalQty < $orderedQty ){
                $message = "We are having few items left in the stock";
            }else{
                $result = 1;
                $title = "In Stock";
                $message = "Stock Available";
            }

        }

        return array("result"=>$result, 'message' => $message, 'title' => $title );
    }


    public function addStdCart($data){

        $user_id = $data['user_id'];
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $size = $data['size'];

        $result = 0;
        $title = "Sorry!";
        $message = "Failed to add product to the cart";

        $checkSelect = mysqli_query($this->localhost,"SELECT `id` FROM `cart` WHERE `user_id`='$user_id' AND `product_id`='$product_id' AND `size_id`='$size' ");
        
        if(mysqli_num_rows($checkSelect) == 0){
            
            $query = "INSERT INTO `cart`(`user_id`,`product_id`,`size_id`,`qty`) VALUES('$user_id','$product_id','$size','$qty') ";

        }else{

            $query = " UPDATE `cart` SET `qty`=qty+$qty WHERE `user_id`='$user_id' AND `product_id`='$product_id' AND `size_id`='$size' ";

        }

        $insert = mysqli_query($this->localhost, $query);


        if($insert){
            $result = 1;
            $title = "Success!";
            $message = "Product has been added to the cart";
        }else{
            $message = mysqli_error($this->localhost);
        }

        return array("result"=>$result,"title"=>$title,"message"=>$message);

    } // addGuestCart


    public function addGuestCart($data){
        
        $user_id = $data['guest_id'];
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $size = $data['size'];

        $result = 0;
        $insert = 0;
        $title = "Sorry!";
        $message = "Failed to add product to the cart";

        $checkSelect = mysqli_query($this->localhost,"SELECT `id` FROM `guest_cart` WHERE `ip_id`='$user_id' AND `product_id`='$product_id' AND `size_id`='$size' ");
        
        if(mysqli_num_rows($checkSelect) == 0){
            
            $insert = mysqli_query($this->localhost,"INSERT INTO `guest_cart`(`ip_id`,`product_id`,`size_id`,`qty`) VALUES('$user_id','$product_id','$size','$qty') ");

        }else{

            $insert = mysqli_query($this->localhost,"UPDATE `guest_cart` SET `qty`=qty+$qty WHERE `ip_id`='$user_id' AND `product_id`='$product_id' AND `size_id`='$size' ");

        }

        if($insert){
            $result = 1;
            $title = "Success!";
            $message = "Product has been added to the cart";
        }else{
            $message = mysqli_error($this->localhost);
        }

        return array("result"=>$result,"title"=>$title,"message"=>$message);

    } // addGuestbag


    public function addWishlist($data){

        $user_id = $data['user_id'];
        $product_id = $data['product_id'];

        $result = 0;
        $title = "Sorry!";
        $message = "Failed to add product to the wishlist";


        $checkSelect = mysqli_query($this->localhost,"SELECT `id` FROM `wishlist` WHERE `user_id`='$user_id' AND `product_id`='$product_id' ");
        
        if(mysqli_num_rows($checkSelect) == 0){
            
            $insert = mysqli_query($this->localhost,"INSERT INTO `wishlist`(`user_id`,`product_id`) VALUES('$user_id','$product_id') ");

        }else{
            $message = "Product already added to the wishlist";
        }

        if($insert){
            $result = 1;
            $title = "Success!";
            $message = "Product has been added to the wishlist";
        }

        return array("result"=>$result,"title"=>$title,"message"=>$message);

    } // addWishlist end 

    public function checkAvaliabilityOnPromoCode($promo)
    {
        $discountedAmount = 0;
        $message = '';
        $result = 0;
        $fetchCartItems = $this->fetchCartItemsFromOut();
        
        $coupon_code = $promo;
        $today = date('Y-m-d');
        $totalAfterDiscount = 0;
        
        $select_promo = mysqli_query($this->localhost,"SELECT * 
                                                FROM `promo_codes` 
                                                WHERE `code`='$coupon_code' AND `end_date`>'$today' ");
        $fetch_promo = mysqli_fetch_array($select_promo);
        if (mysqli_num_rows($select_promo) > 0 ) {
            $query = "SELECT * ,COUNT(`id`) AS promo_count
                      FROM `promocode_usage`  
                      WHERE `promo_code`='$coupon_code' AND `customer_id`='$this->user_id' ";

            $select = mysqli_query($this->localhost, $query);
            $fetch = mysqli_fetch_array($select);
            if ($fetch_promo['max_usage'] > $fetch['promo_count'] ) {
                $discountedAmount = $this->calculateLineDiscount($fetchCartItems['grand_total'], [ 'type' => $fetch_promo['discount_type'], 'value' => $fetch_promo['amount'] ]);
                $totalAfterDiscount = $fetchCartItems['grand_total']-$discountedAmount;
                $result = 1;
                $message = 'Promo code discount has beed applied!';
            } else {
                $message = 'Promo code maximum usage limit has reached! Cannot be used!';
            }
        } else {
            $message = 'Please enter a valid promo code !';
        }
        
        return array('discountedAmount'=>$discountedAmount,'message'=>$message,'result'=>$result,'totalAfterDiscount'=>$totalAfterDiscount);
    } //checkAvaliabilityOnPromoCode()
    

    public function calculateLineDiscount($price, $discountArray)
    {
        
        $discountedAmount = 0;

        $price = (float)$price;
        $discountValue = (float)$discountArray['value'];

        if($discountArray['type'] == '/'){

            $discountedAmount = $price-$discountValue;

        }else if ($discountArray['type'] == '%'){

            $discountedAmount = ($price*$discountValue)/100;

        }

        return $discountedAmount;

    } //calculateLineDiscount()

    public function fetchLineDiscount($proId, $qty)
    {

        $discountAmount = 0;

        $query = "SELECT pro.`id`, pro.`min_order_qty`, price.`sale_price` price 
                    FROM  `products` AS pro
                    INNER JOIN `price` AS price ON price.`product_id` = pro.`id` 
                    WHERE pro.`id`='$proId' ";

        $select = mysqli_query($this->localhost, $query);
        $fetch = mysqli_fetch_array($select);
        $price = $fetch['price']*$qty;

        $disQue = "SELECT * FROM `pro_discounts` WHERE `product_id` = '$proId' AND `min_qty` <= '$qty' ORDER BY `min_qty` DESC LIMIT 0, 1 ";
        $select = mysqli_query($this->localhost, $disQue);

        if(mysqli_num_rows($select) > 0){

            $fetch = mysqli_fetch_array($select);

            $discountAmount = $this->calculateLineDiscount($price, [ 'type' => $fetch['discount_type'], 'value' => $fetch['discount_value'] ]);

        }

        return $discountAmount;

    } //fetchLineDiscount

    // Fetch Cart
    private function getCartItems($query){

        $cartItemsArray = array();

        $select = mysqli_query($this->localhost, $query);
        $total_products = mysqli_num_rows($select);
        $grand_total = 0;

        if($total_products > 0){

            while($fetch = mysqli_fetch_array($select)){
                $gump = new GUMP();
                $productsList = $gump->sanitize($fetch); 
                $sanitized_query_data = $gump->run($productsList);
                
                $total_price = $fetch['price']*$fetch['qty'];

                $discount = $this->fetchLineDiscount($fetch['id'], $fetch['qty']);
                $lineGrand = $total_price-$discount;

                $grand_total += $lineGrand;

                $thumb = $this->productImagesByTypeArray($fetch['id'], ['cover' => 1])['cover'][0];
                $url = URL.'shop/pro?q='.$fetch['id'].'&='.urlencode(strtolower(trim($fetch['name'])));

                $tempArray = array(
                    'row_id' => $fetch['row_id'],
                    'product_id' => $fetch['id'],
                    'name' => $sanitized_query_data['name'],
                    'image' => $thumb,
                    'price' => $fetch['price'],
                    'size_name'=>$fetch['sname'],
                    's_id'=>$fetch['s_id'],
                    'qty' => $fetch['qty'],
                    'discount' => $discount,
                    'row_total' => $total_price,
                    'lineGrand' => $lineGrand,
                    'availability' => $this->checkProductAvailability($fetch['id'], $fetch['qty'],$fetch['s_id']),
                    'url' => $url,
                );

                array_push($cartItemsArray, $tempArray);
                
            } // fetch end 

        } // IF END

        return [
            'itemsArray' => $cartItemsArray,
            'grand_total' => $grand_total,
            'totalRows' => $total_products
        ];

    } //getCartItems

    
    public function fetchCartItemsFromOut()
    {
        // $this->transferGuestItemsToUserCart();

        if($this->userType == 'std'){

            $query = "SELECT cart.`qty`, cart.`id` row_id, pro.`id`, pro.`name`, price.`sale_price` price, s.`id` s_id, s.`name` sname
                    FROM `cart` AS cart 
                    INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id` AND price.`size_id` = cart.`size_id`
                    LEFT JOIN `sizes` AS s ON cart.`size_id` = s.`id` 
                    INNER JOIN `products` AS pro ON pro.`id` = cart.`product_id`
                    WHERE cart.`user_id`='$this->user_id' ";

        }elseif($this->userType == 'dealer'){

            $query = "SELECT cart.`qty`,cart.`id` row_id ,pro.`id`,pro.`name`, price.`dealer_price` price,s.`id` s_id,s.`name` sname
                    FROM `cart` AS cart 
                    INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id` AND price.`size_id` = cart.`size_id`
                    LEFT JOIN `sizes` AS s ON cart.`size_id` = s.`id` 
                    INNER JOIN `products` AS pro ON pro.`id` = cart.`product_id`
                    WHERE cart.`user_id`='$this->user_id' ";

        }else{
            $query = "SELECT cart.`qty`,cart.`id` row_id ,pro.`id`,pro.`name`, price.`sale_price` price,s.`id` s_id,s.`name` sname
                    FROM `guest_cart` AS cart 
                    INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id` AND price.`size_id` = cart.`size_id`
                    LEFT JOIN `sizes` AS s ON cart.`size_id` = s.`id` 
                    INNER JOIN `products` AS pro ON pro.`id`= cart.`product_id`
                    WHERE cart.`ip_id`='$this->user_id' ";

// SELECT cart.`qty`,cart.`id` row_id ,pro.`id`,pro.`name`, pro.`item_code`, price.`sale_price` price,size.`name` AS size FROM `guest_cart` AS cart INNER JOIN `price` AS price ON price.`product_id` = cart.`product_id` AND price.`size_id` = cart.`size_id` INNER JOIN `products` AS pro ON pro.`id`=cart.`product_id` LEFT JOIN `sizes` AS size ON size.`id`=cart.`size_id` WHERE `ip_id`='10886334892021041209' 
        }

        return $this->getCartItems($query);

    } //fetchCartItemsFromOut()

    private function deleteCartItem($query){

        $delete = mysqli_query($this->localhost, $query);
        if($delete){
            return array('result' => 1, 'Cart item has been removed successfully');
        }else{
            return array('result' => 0, 'Failed to remove cart item successfully');
        }

    } //deleteCartItem

    public function deleteStdUserCartItem(Int $userId, Int $rowId)
    {
        $query = "DELETE FROM `cart` WHERE `user_id`='$userId' AND `id`='$rowId'  ";
        return $this->deleteCartItem($query);
    } //deleteStdUserCartItem

    public function deleteGuestUserCartItem($guestId, Int $rowId)
    {
        $query = "DELETE FROM `guest_cart` WHERE `ip_id`='$guestId' AND `id`='$rowId' ";
        return $this->deleteCartItem($query);
    } //deleteGuestUserCartItem


    public function clearCart(){

        if(($this->userType == 'std') | ($this->userType == 'dealer')){

            $query = "DELETE FROM `cart` WHERE `user_id`='$this->user_id' ";

        }else{
            // if user not logged in and guest user
            $query = "DELETE FROM `guest_cart` WHERE `ip_id`='$this->user_id' ";

        } // check user type if end

        $delete = mysqli_query($this->localhost, $query);
        if($delete){
            return 1;
        }else{
            return 0;
        }

    } //clearCart()


} // Cartcontroller class 

$cartObj = new cartClass($localhost);


?>