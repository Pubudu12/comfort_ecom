<?php 

require_once ROOT_PATH.'shopController/class/cartClass.php';
require_once ROOT_PATH.'shopController/class/shippingClass.php';
require_once ROOT_PATH.'shopController/class/checkoutClass.php';
require_once ROOT_PATH.'/mail/mails.php';

if($_SERVER['REQUEST_METHOD'] == "POST" ) {

    if(isset($_POST['checkout'])){

        // initiaze class of order
        $checkoutClassObj = new checkoutClass($localhost);

        $orderDetails['name'] = NumberValidation($localhost,$_POST['billing-form-name']);
        $orderDetails['phone'] = NumberValidation($localhost,$_POST['billing-form-phone']);
        $orderDetails['email'] = NumberValidation($localhost,$_POST['billing-form-email']);

        $orderDetails['door_no'] = NumberValidation($localhost,$_POST['billing-form-door_no']);
        $orderDetails['city'] = NumberValidation($localhost,$_POST['billing-form-city']);
        $orderDetails['district'] = NumberValidation($localhost,$_POST['billing-form-district']);
        $orderDetails['state'] = NumberValidation($localhost,$_POST['billing-form-state']);
        $orderDetails['country'] = NumberValidation($localhost,$_POST['billing-form-country']);
        $orderDetails['zip_code'] = NumberValidation($localhost,$_POST['billing-form-zip_code']);

        $orderDetails['memo'] = NumberValidation($localhost, $_POST['shipping-form-memo']);
        $orderDetails['shipping_method'] = NumberValidation($localhost,$_POST['shipping_method']);
        
        $cartItemsArray = $cartObj->fetchCartItemsFromOut();
        $allItemsAvailable = 1;
        foreach ($cartItemsArray['itemsArray'] as $key => $avaiCheck) {
            if($avaiCheck['availability']['result'] == 0){
                $allItemsAvailable = $allItemsAvailable*0;
            }
        }
        $orderDetails['orderedItems'] = $cartItemsArray['itemsArray'];

        $orderDetails['cart_total'] = $cartItemsArray['grand_total'];

        if ($_POST['apply_promo_status'] == '1') {
            if (isset($_POST['coupon_code'])) {
                $orderDetails['coupon_code'] = NumberValidation($localhost,$_POST['coupon_code']);
                $orderDetails['discount_of_promo'] = $_POST['discount_of_promo'];
                $orderDetails['cart_total'] = $cartItemsArray['grand_total']-$orderDetails['discount_of_promo'];
            }
        }

        $orderDetails['delivery_charges'] = $checkoutObj->getShippingCharges()['shipping_charges']; // From App/Class/calculateOtherCharges.php

        $payment = 0;
        $orderDetails['payment_method'] = NumberValidation($localhost,$_POST['payment_option']);

        $result = 0;
        $title = "Failed";
        $message = "It may subjected to an unavailability of the product at the time of order placing";
        $order_no = 0;
        $place_order = 0;
        if( (trim($orderDetails['cart_total']) > 0) && ($allItemsAvailable == 1) ){

            $place_order = $checkoutClassObj->placeOrder($orderDetails);

            $result = $place_order['result'];
            $title = $place_order['title'];
            $message = $place_order['message'];
            $order_no = $place_order['order_no'];
            
            
        } // if end for check total 

        // $url = URL."account/view_order.php?order_no=".$order_no."&email=".$orderDetails['email'];

        if( strtolower($orderDetails['payment_method']) != "cod" ){
            $url = URL."payment/processing?order_no=".$order_no;
            
        }

        if($result == 1){

            if( strtolower($orderDetails['payment_method']) == "cod" ){
                // send the mail now
                // its COD 
                $config = array(
                'order_no' => $order_no
                );
                $result = $eCommerceMailObj->sendCashOnDeliveryMail($order_no);
                // $result = $eCommerceMailObj->invoice($order_no);

                $url = URL."account/view_order.php?order_no=".$order_no."&email=".$orderDetails['email'];
            }else{
               $url = URL."payment/processing?order_no=".$order_no;
               $result = $eCommerceMailObj->invoice($order_no);

               $payment_status = $checkoutClassObj->checkPaymentStatus($order_no);
               if($payment_status != '0'){
                    // Clear Cart
                    $cartObj->clearCart();
                }
               
            //   $url = URL."account/view_order.php?order_no=".$order_no."&email=".$orderDetails['email']; //temporarily
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