<?php
require '../../../app/global/url.php';
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';

require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'shopController/class/cartClass.php';
require_once ROOT_PATH.'shopController/class/shippingClass.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['add_to_cart'])){

        $product_id = NumberValidation($localhost, $_POST['product_id']);
        $qty = NumberValidation($localhost,$_POST['qty']);
        $pro_size = NumberValidation($localhost,$_POST['pro_size']);

        $credentials['product_id'] = $product_id;
        $credentials['qty'] = $qty;
        $credentials['size'] = $pro_size;

        $guest_id = $_COOKIE[GUEST_CART_COOKIE_NAME];

        $result = 0;
        $title = "Sorry!";
        $message = "Please try again";

        // $checkStock = $cartObj->checkProductAvailability($product_id, $qty,$pro_size);

        // if($checkStock['result'] == 1){
        //     $productStock = 1;
        // }else{
        //     $productStock = 0;
        //     $message = $checkStock['message'];
        // }

        $productStock = 1;
        if($productStock == 1 ){
            // Everything available to add

            $getUserType = checkUserAccess();

            if($getUserType['access'] == 1 | $getUserType['access'] == 2){
                // Standard user having account

                $user_id = $_SESSION['user_id'];
                $credentials['user_id'] = $user_id;

                $add_std_cart = $cartObj->addStdCart($credentials);

                // successfull message from added std cart products
                $result = $add_std_cart['result'];
                $title = $add_std_cart['title'];
                $message = $add_std_cart['message'];
            }else{
                //guest user no account use ip address to add products

                $message = "Please sign in !";
                $credentials['guest_id'] = $guest_id;
                $add_guest_cart = $cartObj->addGuestCart($credentials);

                // successfull message from added std cart products
                $result = $add_guest_cart['result'];
                $title = $add_guest_cart['title'];
                $message = $add_guest_cart['message'];
            }
        } // check user product , size, color variableb values  if end 

        echo json_encode( array('title' => $title, 'message'=>$message,"result"=>$result) );

    } // add to cart end

    if(isset($_POST['refresh_cart'])){
        // echo "here";
        $getUserType = checkUserAccess();
        $cartItemsArray = $cartObj->fetchCartItemsFromOut();
        $menuCartListFile = file_get_contents(ROOT_PATH.'shopController/container/cartSingleItem.html');
        if( count($cartItemsArray['itemsArray']) > 0){

            $menuCartList = '';

            foreach ($cartItemsArray['itemsArray'] as $key => $cartSingleItemArray) {

                $tempList = $menuCartListFile;
                $tempList = str_replace("{{ NAME }}", $cartSingleItemArray['name'], $tempList);
                $tempList = str_replace("{{ PRICE }}", CURRENCY.' '.number_format($cartSingleItemArray['price'], 2), $tempList);
                $tempList = str_replace("{{ QTY }}", $cartSingleItemArray['qty'], $tempList);
                $tempList = str_replace("{{ IMG }}", $cartSingleItemArray['image'], $tempList);
                $tempList = str_replace("{{ URL }}", $cartSingleItemArray['url'], $tempList);
                $tempList = str_replace("{{ ROW_ID }}", $cartSingleItemArray['row_id'], $tempList);

                $menuCartList .= $tempList;
                
            } // foreach End
        }else{
            $menuCartList = '<p class="text-center">Add some items to the cart</p>';
        }
        echo json_encode(array("list"=>$menuCartList, 'totalItems'=>$cartItemsArray['totalRows'], 'grand_total' => CURRENCY.' '.number_format($cartItemsArray['grand_total'], 2) ));
    }// isset

    // delete cart items
    if(isset($_POST['delete_cart_items'])){
        
        $row_id = $_POST['row_id'];
        
        $getUserType = checkUserAccess();

        if(($getUserType['access'] == 1) | ($getUserType['access'] == 2)){

            // if user is std user and logged in
            $user_id = $_SESSION['user_id'];
            $resultObj = $cartObj->deleteStdUserCartItem($user_id, $row_id);

        }else{

            // if user not logged in and guest user
            $guest_id = $_COOKIE[GUEST_CART_COOKIE_NAME];
            $resultObj = $cartObj->deleteGuestUserCartItem($guest_id, $row_id);

        } // check user type if end

        echo json_encode($resultObj);

    }// isset of delete cart items

    // -------------------------------------------------------------------------------------
    // Wishlist-------------------------------------------------------------------------------

    if(isset($_POST['add_to_wishlist'])){
        
        $product_id = NumberValidation($localhost,$_POST['product_id']);
        
        $cartObj = new cartController($database,$localhost,$product_id);

        $result = 0;
        $title = "Sorry!";
        $message = "Please try again";

        $credentials['product_id'] = $product_id;
        $credentials['user_id'] = $user_id = $_SESSION['user_id'];

        $add_guest_cart = $cartObj->addWishlist($credentials);

        $result = $add_guest_cart['result'];
        $title = $add_guest_cart['title'];
        $message = $add_guest_cart['message'];

        echo json_encode( array('title' => $title, 'message'=>$message) );
        
    } // add to wish list end 


    if(isset($_POST['check_promo_code_avalilability'])){
        
        $coupon_code = $_POST['coupon_code'];
        $discountedAmount = 0;

        $guest_id = $_COOKIE[GUEST_CART_COOKIE_NAME];

        $result = 0;
        $message = "Please try again";

        $promoAvailability = $cartObj->checkAvaliabilityOnPromoCode($coupon_code);
        $shippingChargesArray = $checkoutObj->getShippingCharges();
        $totalAfterDiscount = $promoAvailability['totalAfterDiscount'];
        
        if($promoAvailability['result'] == 1){
            $result = $promoAvailability['result'];
            $discountedAmount = $promoAvailability['discountedAmount'];
            $totalAfterDiscount = $promoAvailability['totalAfterDiscount'];
        }else{
            $discountedAmount = $promoAvailability['discountedAmount'];
            $message = $promoAvailability['message'];
        }
        $totalAfterShippingCharge = $totalAfterDiscount + $shippingChargesArray['shipping_charges'];
        
        echo json_encode(array('message'=>$promoAvailability['message'],"result"=>$promoAvailability['result'],'discountedAmount'=>$discountedAmount,'totalAfterDiscount'=>$totalAfterDiscount,'totalAfterShippingCharge'=>$totalAfterShippingCharge) );

    } // check coupon

    // ----------------------------------------------------------------------------------------------------
    // check login or guest
    if(isset($_POST['check_login'])){

        $getUserType = checkUserAccess();

        echo json_encode(array("access"=>$getUserType['access'],"user_type"=>$getUserType['user_type']));

    }// check_login end 

} // request method end 



?>