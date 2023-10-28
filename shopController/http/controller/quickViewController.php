<?php
require '../../../app/global/url.php';
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';

require_once ROOT_PATH.'imports/functions.php';

require_once ROOT_PATH.'app/controllers/productsControllerClass.php';

if($_SERVER['REQUEST_METHOD'] == "POST" ) {

    if(isset($_POST['quick_view'])){

        $productId = (int)trim($_POST['product_id']);

        $productDetailsArray = $productControllerObj->getStoreSingleProductDetails($productId);
        $productsDiscountArray = $productControllerObj->getProDiscountsList($productId);

        $name = $productDetailsArray['name'];
        
        $salePrice = $productDetailsArray['sale_price'];
        $category_name = $productDetailsArray['categoryName'];
        $desc = $productDetailsArray['description'];
        
        $thumb = $productDetailsArray['productsImagesArray']['thumb'][0];

        $addToCart = $productDetailsArray['productAddToCart'];

        $discountList = '';

        if(count($productsDiscountArray) > 0){
                                
            $discountList .= '<div class="border-product">';
                
                foreach ($productsDiscountArray as $key => $disArray) {
                    $discountList .= '<p>'.$disArray['name'].'</p>';

                    $discountList .= '<input type="hidden" 
                                        class="productDiscountDetailsList"
                                        value="'.$disArray['discount_value'].'" 
                                        data-discountType="'.$disArray['discount_type'].'" 
                                        data-minQty="'.$disArray['min_qty'].'" >';
                                                
                }

            $discountList .= '</div>';
        }


        $quickViewContainer = file_get_contents(ROOT_PATH.'store/container/quickViewModalDetailsContainer.html');

        $quickViewContainer = str_replace('{{ NAME }}', $name, $quickViewContainer);
        $quickViewContainer = str_replace('{{ SALE_PRICE }}', $salePrice, $quickViewContainer);
        $quickViewContainer = str_replace('{{ SALE_PRICE_ORIGINAL }}', $productDetailsArray['price']['sale_price'], $quickViewContainer);
        
        $quickViewContainer = str_replace('{{ DESC }}', $desc, $quickViewContainer);
        $quickViewContainer = str_replace('{{ ADD_TO_CART }}', $addToCart, $quickViewContainer);
        $quickViewContainer = str_replace('{{ THUMB }}', $thumb, $quickViewContainer);
        $quickViewContainer = str_replace('{{ DISCOUNTLIST }}', $discountList, $quickViewContainer);
        

        echo json_encode(['container'=>$quickViewContainer]);

    } // Quick View End

} // Request Methd end 
?>

