<?php
class shippingClass{

    public $localhost, $shipping_method;

    private $shipping_base = 0;
    private $shipping_addon_kg = 0;

    public function __construct($localhost){
        $this->localhost = $localhost;
    } // constructor

    public function assignShippingFares($shipper_code = "dd"){

        $this->shipping_base = 0;
        $this->shipping_addon_kg = 0;
        $this->shipping_method = $shipper_code;
        
        if($this->shipping_method == "dd"){ // if Door Delivery
            $select = mysqli_query($this->localhost, "SELECT * FROM `shippers` WHERE `code` = '$shipper_code' ");
            $fetch = mysqli_fetch_array($select);

            $this->shipping_base = $fetch['base_charge'];
            $this->shipping_addon_kg = $fetch['addon_kg'];

        }

        return array(
            'base_charge' => $this->shipping_base,
            'addon_kg' => $this->shipping_addon_kg,
        );

    } //assignShippingFares

    public function shippingCalculation($itemArray){

        $this->assignShippingFares(); // Assign Charges

        // array have nested array
        // array(array( 'pro_id' => '', 'weight' => '', 'qty' => '' ));

        $shipping_charge = $this->shipping_base;

        $total_weight = 0;
        $totalPrice = 0;
        foreach ($itemArray as $key => $innerArr) {
            $total_weight += trim($innerArr['weight'])*trim($innerArr['qty']);
            $totalPrice += trim($innerArr['price'])*trim($innerArr['qty']);
        }

        $total_weight_in_KG = ($total_weight/1000);

        $addon_charges = 0;
        if($total_weight_in_KG > 1){
            $addon_kg = ceil($total_weight_in_KG-1);
            $addon_charges = $addon_kg*$this->shipping_addon_kg;
        }

        $shipping_charge += $addon_charges;
        

        return [
             'totalPrice' => $totalPrice,
             'shipping_charge' => $shipping_charge
        ];

    } //shippingCalculation

    public function getShippingCharges($method = "dd"){

        $this->shipping_method = $method;

        // Check the Weather Guest Cart of Registered User Cart

        $getUserType = checkUserAccess();

        if($getUserType['access'] == 1){
            
            $user_id = $_SESSION['user_id'];
            $orderDetails['user_id'] = $user_id;


            $items_fetch_query = "SELECT c.`qty`, c.`product_id`, pro.`weight_g`, price.`sale_price` price 
                                    FROM `cart` as c 
                                    INNER JOIN `products` AS pro ON pro.`id` = c.`product_id`
                                    INNER JOIN `price` AS price ON price.`product_id` = c.`product_id` 
                                    WHERE c.`user_id`='$user_id' ";

        }else{

            $guest_id = $_COOKIE[GUEST_CART_COOKIE_NAME];
            $orderDetails['guest_id'] = $guest_id;

            $items_fetch_query = "SELECT c.`qty`, c.`product_id`, pro.`weight_g`, price.`sale_price` price
                                    FROM `guest_cart` AS c 
                                    INNER JOIN `products` AS pro ON pro.`id` = c.`product_id`
                                    INNER JOIN `price` AS price ON price.`product_id` = c.`product_id` 
                                    WHERE c.`ip_id`='$guest_id' ";
        }

        $products_array = array();
        $select_items = mysqli_query($this->localhost, $items_fetch_query);
        while($fetch_items = mysqli_fetch_array($select_items)){
            array_push($products_array, array(
                'pro_id' => $fetch_items['product_id'],
                'weight' => $fetch_items['weight_g'],
                'qty' => $fetch_items['qty'],
                'price' => $fetch_items['price'],
            ));
        }
        

        $shipping_chargesArray = $this->shippingCalculation($products_array);
        $shipping_charge = $shipping_chargesArray['shipping_charge'];
        $totalCartprice = $shipping_chargesArray['totalPrice'];

        if($totalCartprice >= 2000){
            $shipping_charge = 0;
        }

        $displayShippingCharges = "Free";
        if($shipping_charge > 0){
            $displayShippingCharges = CURRENCY.' '.number_format($shipping_charge, 2);
        }
        

        return array(
            'shipping_charges' => $shipping_charge,
            'display_shipping_charges' => $displayShippingCharges,
        );


    } //getShippingCharges

} //calculateShippingCharges

$checkoutObj = new shippingClass($localhost);
?>