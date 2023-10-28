<?php 

require_once ROOT_PATH.'app/controllers/class/productsClass.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';
class productControllerClass extends productClass{

    public $localhost;
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
            if(!isset($_COOKIE[GUEST_CART_COOKIE_NAME])) {
                setcookie(GUEST_CART_COOKIE_NAME, rand().date("Ymdh"), time() + (86400 * 30), "/"); // 86400 = 1 day
            }
            $this->user_id = isset($_COOKIE[GUEST_CART_COOKIE_NAME]) ? $_COOKIE[GUEST_CART_COOKIE_NAME] : 0;
            $this->userType = 'guest';
        }
    } // Constrcut
    

    public function getCategoriesListArray($parent, $startLevel, $maxLevel, $products, $code, $imgTypeArray ){

        return $this->menuListByCode($parent, $startLevel, $maxLevel, $products, $code, $imgTypeArray);

    } //getAutoOperatorsCategories

    public function getSelectedCategoryData($category_id){
        return $categoryDetailsArray = $this->categoryDetailsById($category_id);
    } //getSelectedCategoryData()

    public function getListOfCategoriesByParentId($slugURL = 0, $catlevel)
    {
        $categoryId = $this->fetchCategoryIdBySlugURL($slugURL);
        return $this->getCategoriesListByParentid($categoryId, $catlevel);
    } //getListOfCategoriesByParentId


    public function producHtmlContainer($productArray)
    {   
        $productSingleContainer = file_get_contents(ROOT_PATH.'store/container/singleProductContainer.html');

        // to display the discount of a product
        $discount = 0;
        $discount_type = '%';
        $discount_display = 'discount-display';
        if ($productArray['discount'] != 0) {
            $discount = $productArray['discount'];
            $discount_type = $productArray['discount_type'];
            $discount_display = '';
        }

        $productSingleContainer = str_replace('{{ URL }}', URL.'shop/pro?'.$productArray['url_query'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ PRODUCT_ID }}', $productArray['product_id'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ NAME }}', $productArray['name'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ PRICE }}', number_format($productArray['sale_price'],2), $productSingleContainer);
        $productSingleContainer = str_replace('{{ CURRENCY }}', CURRENCY, $productSingleContainer);
        $productSingleContainer = str_replace('{{ MIN_ORDER_QTY }}', $productArray['min_order_qty'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ CATEGORY }}', $productArray['category'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ IMG_1 }}', $productArray['thumbArray'][0], $productSingleContainer);
        $productSingleContainer = str_replace('{{ OFFER_TEXT }}', $productArray['offer_text'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ DISCOUNT }}', number_format($discount,0), $productSingleContainer);
        $productSingleContainer = str_replace('{{ DISCOUNT_TYPE }}', $discount_type, $productSingleContainer);
        $productSingleContainer = str_replace('{{ DISCOUNT_DISPLAY }}', $discount_display, $productSingleContainer);
        $productSingleContainer = str_replace('{{ DISPLAY_HIDDEN }}', $productArray['display_none_class'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ UPWARDS_STATUS }}', $productArray['upwards'], $productSingleContainer);
        $productSingleContainer = str_replace('{{ 3D_DISPLAY }}', $productArray['3d_display'], $productSingleContainer);

        return $productSingleContainer;
    } //producHtmlContainer()

    // Store
    
    public function searchStrePro($search, $sort = 'latest', $pageNo = 1)
    {
        $productsList = $this->getProductsList(['search'=>$search], $sort, $pageNo);

        $productHtmlContainerArray = array();

        foreach ($productsList['productsArray'] as $key => $productArray) {
            
            $display_none_class = '';
            if (($productArray['category'] == 6) | ($productArray['category'] == 8)) {
                $display_none_class = 'display-hidden';
            }

            $_3dDisplay = 'display-hidden';
            if ($productArray['3d_link'] != '0') {
                $_3dDisplay = '';
            }

            $upwards = '';
            if ($productArray['upwards_status'] == 1) {
                $upwards = 'Upwards';
            }

            $tempContainer = $this->producHtmlContainer(
                [
                    'url_query' => $productArray['url_query'],
                    'name' => $productArray['name'],
                    'product_id' => $productArray['id'],
                    'min_order_qty' => $productArray['min_order_qty'],
                    'sale_price' => $productArray['sale_price'],
                    'dealer_price' => $productArray['dealer_price'],
                    'category' => $productArray['category'],
                    'thumbArray' => $productArray['thumbArray'],
                    'discount'=>$productArray['discount'],
                    'discount_type'=>$productArray['discount_type'],
                    'offer_text' => $productArray['offer_text'],
                    'display_none_class' => $display_none_class,
                    '3d_display' => $_3dDisplay,
                    'upwards' => $upwards,
                ]
            );

            array_push($productHtmlContainerArray, $tempContainer);
        }

        return [
            'productHtmlContainerArray' => $productHtmlContainerArray,
            'pagination' => $productsList['pagination'],
        ];
    }

    public function fetchStoreProductList($categoryArray = [], $filterArray = [], $pageNo, $sort = 'latest')
    {
        $category_id = 0;

        $category_id = $this->fetchCategoryIdBySlugURL($categoryArray['slug']);
        
        $categoryLevel = 1; // 1 => very bottom, 2=> just before last
        if(count($categoryArray) > 0){
            $category_id = $category_id;
            $categoryLevel = $categoryArray['categoryLevel'];
        }        

        $getProductQuery = $this->formProductFetchQuery([
            'category_id' => $category_id,
            'categoryLevel' => $categoryLevel,
        ], $filterArray, $sort );

        
        $paginationArray = $this->pagination($getProductQuery, $pageNo, $limit = 30);
        $pagination = $paginationArray['details'];

        $select_query = $paginationArray['query'];
        $productArray = $this->fetchProductsClass($select_query);

        $fetchListOfCategories = $this->getListOfCategoriesByParentId($categoryArray['slug'], $categoryLevel);
        
        $productHtmlContainerArray = array();

        $catgArray = array();

        foreach ($productArray['productsArray'] as $key => $productArray) {
                     
            array_push($catgArray,$productArray['category_id']);
            
            $price = $productArray['sale_price'];
            if ($this->userType == 'dealer') {
                $price = $productArray['dealer_price'];
            } 
            
            $gump = new GUMP();
            $productArray = $gump->sanitize($productArray); 
            $sanitized_query_data = $gump->run($productArray);
            $name = $sanitized_query_data['name'];

            $display_none_class = '';
            if (($category_id == 6) | ($category_id == 8)) {
                $display_none_class = 'display-hidden';
            }

            $_3dDisplay = 'display-hidden';
            
            if ($productArray['3d_link'] != '0') {
                $_3dDisplay = '';
            }

            $upwards = '';
            if ($productArray['upwards_status'] == 1) {
                $upwards = 'Upwards';
            }
            
            $tempContainer = $this->producHtmlContainer(
                [
                    'url_query' => $productArray['url_query'],
                    'name' => $name,
                    'discount'=>$productArray['discount'],
                    'discount_type'=>$productArray['discount_type'],
                    'product_id' => $productArray['id'],
                    'min_order_qty' => $productArray['min_order_qty'],
                    'sale_price' => $price,
                    'category' => $productArray['category'],
                    'thumbArray' => $productArray['thumbArray'],
                    'offer_text' => $productArray['offer_text'],
                    'display_none_class' => $display_none_class,
                    '3d_display' => $_3dDisplay,
                    'upwards' => $upwards,
                ]
            );

            array_push($productHtmlContainerArray, $tempContainer);
        }

        return [
            'category_array'=>$catgArray,
            'productHtmlContainerArray' => $productHtmlContainerArray,
            'pagination' => $pagination,
        ];
    }

    public function getTrendingProducts($sort, $pageNo)
    {

        $category_id = 0;
        $categoryLevel = 1; // 1 => very bottom, 2=> just before last

        $getProductQuery = $this->formProductFetchQuery([
            'category_id' => $category_id,
            'categoryLevel' => $categoryLevel,
        ], [], $sort );

        $paginationArray = $this->pagination($getProductQuery, $pageNo, $limit = 30);
        
        $select_query = $paginationArray['query'];
        $productArray = $this->fetchProductsClass($select_query);

        $productHtmlContainerArray = array();
        foreach ($productArray['productsArray'] as $key => $productArray) {
            $display_none_class = '';
            if (($productArray['category'] == 6) | ($productArray['category'] == 8)) {
                $display_none_class = 'display-hidden';
            }

            $_3dDisplay = 'display-hidden';
            if ($productArray['3d_link'] != '0') {
                $_3dDisplay = '';
            }

            $upwards = '';
            if ($productArray['upwards_status'] == 1) {
                $upwards = 'Upwards';
            }

            $tempContainer = $this->producHtmlContainer(
                [
                    'url_query' => $productArray['url_query'],
                    'name' => $productArray['name'],
                    'product_id' => $productArray['id'],
                    'min_order_qty' => $productArray['min_order_qty'],
                    'sale_price' => $productArray['sale_price'],
                    'category' => $productArray['category'],
                    'thumbArray' => $productArray['thumbArray'],
                    'discount'=>$productArray['discount'],
                    'discount_type'=>$productArray['discount_type'],
                    'offer_text' => $productArray['offer_text'],
                    'display_none_class' => $display_none_class,
                    '3d_display' => $_3dDisplay,
                    'upwards' => $upwards,
                ]
            );
            array_push($productHtmlContainerArray, $tempContainer);
            // array_push($productHtmlContainerArray, [
            //     'url_query' => URL.'shop/pro?'.$productArray['url_query'],
            //     'name' => $productArray['name'],
            //     'product_id' => $productArray['id'],
            //     'min_order_qty' => $productArray['min_order_qty'],
            //     'sale_price' => $productArray['sale_price'],
            //     'category' => $productArray['category'],
            //     'thumbArray' => $productArray['thumbArray'][0],
            //     // 'thumbArray' => $productArray['thumbArray'],
            //     'offer_text' => $productArray['offer_text']
            // ]);
        }

        return $productHtmlContainerArray;

    } //getTrendingProducts($sort)

    public function getStoreSimilarProductList($product_id, $category_id, $pageNo = 1)
    {
        
        $getProductQuery = $this->formProductFetchQuery([
            'category_id' => $category_id,
            'categoryLevel' => CAT_MAX_LEVEL,
        ], [], 'latest', $ignoreArray = ['product_id' => $product_id]);

        $paginationArray = $this->pagination($getProductQuery, $pageNo, $limit = 30);
        $select_query = $paginationArray['query'];
        $productArray = $this->fetchProductsClass($select_query);

        $productHtmlContainerArray = array();
        $gump = new GUMP();

        foreach ($productArray['productsArray'] as $key => $productArray) {

            $productArray = $gump->sanitize($productArray); 
            $sanitized_query_data = $gump->run($productArray);
            $name = $sanitized_query_data['name'];
            $display_none_class = '';
            if (($productArray['category'] == 6) | ($productArray['category'] == 8)) {
                $display_none_class = 'display-hidden';
            }

            $_3dDisplay = 'display-hidden';
            if ($productArray['3d_link'] != '0') {
                $_3dDisplay = '';
            }

            $upwards = '';
            if ($productArray['upwards_status'] == 1) {
                $upwards = 'Upwards';
            }

            $tempContainer = $this->producHtmlContainer(
                [
                    'url_query' => $productArray['url_query'],
                    'name' => $name,
                    'product_id' => $productArray['id'],
                    'min_order_qty' => $productArray['min_order_qty'],
                    'sale_price' => $productArray['sale_price'],
                    'category' => $productArray['category'],
                    'thumbArray' => $productArray['thumbArray'],
                    'discount'=>$productArray['discount'],
                    'discount_type'=>$productArray['discount_type'],
                    'offer_text' => $productArray['offer_text'],
                    'display_none_class' => $display_none_class,
                    '3d_display' => $_3dDisplay,
                    'upwards' => $upwards,
                ]
            );
            array_push($productHtmlContainerArray, $tempContainer);
        }

        return $productHtmlContainerArray;

    } //getStoreSimilarProductList

    
    public function fetchCategoryIdBySlugURL($slugURL){
        $select = mysqli_query($this->localhost,"SELECT `id` FROM `categories` WHERE `slug` = '$slugURL' ");
        $fetch = mysqli_fetch_array($select);
        
        return $fetch['id'];
        
    }//fetchCategoryIdBySlugURL

    public function getStoreSelectedCategoryDetails($slugURL){

        $category_id = 0;
        if (isset($slugURL)) {
            $category_id = $this->fetchCategoryIdBySlugURL($slugURL);
        }
        $category_id = 0;
        $categoryDetailsArray = $this->categoryDetailsById($category_id);

        $level = 3;
        // $listOfCategories = $this->listOfCategoriesByLevel($level);

        return array('categoryDetailsArray' => $categoryDetailsArray);


    } //getStoreSelectedCategoryDetails

    public function productAddToCartHtmlContainer($proId, $minQty, $description, $availableQty,$stockStatus)
    {

        $erromessage = '';
        $addToCartContainer = file_get_contents(ROOT_PATH.'store/container/addToCartContainer.html');
        $addToCartContainer = str_replace('{{ AVAILABLE_QTY }}', $availableQty, $addToCartContainer);
        $addToCartContainer = str_replace('{{ STOCK_STATUS }}', $stockStatus['stock_status'], $addToCartContainer);
        $addToCartContainer = str_replace('{{ STOCK_STATUS_CLASS }}', $stockStatus['class'], $addToCartContainer);
        // $addToCartContainer = str_replace('{{ CURRENCY }}', CURRENCY, $addToCartContainer);
        $addToCartContainer = str_replace('{{ MIN_ORDER_QTY }}', $minQty, $addToCartContainer);
        $addToCartContainer = str_replace('{{ PRODUCT_ID }}', $proId, $addToCartContainer);
        $addToCartContainer = str_replace('{{ DESCRIPTION }}', $description, $addToCartContainer);
        $addToCartContainer = str_replace('{{ ERROR_MESSAGE }}', $erromessage, $addToCartContainer);
        

        return $addToCartContainer;

    } //productAddToCartHtmlContainer()

    public function getStoreSingleProductBySizeAndPro($size,$productId){
        // $productDetailsArray = $this->getSingleProductDetails($productId);
        $productDetailsArray = array();
        $select = mysqli_query($this->localhost, "SELECT p.* ,s.`name` sname,pro.`min_order_qty`,pro.`description`,s.`id` s_id
                                                  FROM `price` p
                                                  INNER JOIN `sizes` s ON p.`size_id` = s.`id`
                                                  INNER JOIN `products` pro ON pro.`id` = p.`product_id`
                                                  WHERE p.`size_id` = '$size' AND p.`product_id`='$productId' ");
        $fetch = mysqli_fetch_array($select);
        $productDetailsArray['qty'] = $this->getProductQty($productId,$size);


        $imagesArray = array();
        $productDetailsArray['imagesArray'] = $imagesArray;

        // Price Modification
        if (isset($productDetailsArray['dealer_price'])) {
            $productDetailsArray['dealer_price'] = CURRENCY.' '.number_format($fetch['dealer_price'], 2);
        } 

        $productDetailsArray['discount'] = [
            'discount' => number_format($fetch['discount']),
            'discount_type' => $fetch['discount_type'],
        ];

        $productDetailsArray['sale_price'] = CURRENCY.' '.number_format($fetch['sale_price'], 2);
        if($fetch['actual_price'] == $fetch['sale_price']){
            $productDetailsArray['actual_price'] = '';
        }else{
            $productDetailsArray['actual_price'] = CURRENCY.' '.number_format($fetch['actual_price'], 2);
            $productDetailsArray['discount'] = [
                'discount' => number_format($fetch['discount']),
                'discount_type' => $fetch['discount_type'],
            ];
        }

        $productDetailsArray['minOrderQty'] = $fetch['min_order_qty'];
        $stockStatus = 'In Stock';
        $class = 'in-stock-status';
        if ($productDetailsArray['qty'] == 0) {
            $stockStatus = 'Out of Stock';
            $class = 'out-stock-status';
        } 
        $productDetailsArray['description'] = $fetch['description'];
        $productDetailsArray['productAddToCart'] = $this->productAddToCartHtmlContainer($productId, $productDetailsArray['minOrderQty'],$productDetailsArray['description'],$productDetailsArray['qty'],array('stock_status'=>$stockStatus,'class'=>$class));

        return array('prosec'=>$productDetailsArray,'dealer'=>$fetch['dealer_price'],'acprice'=>$fetch['sale_price'],'currency'=>CURRENCY,'discount'=>$productDetailsArray['discount']);
    }

    public function getStoreSingleProductDetails($productId){
        $productDetailsArray = $this->getSingleProductDetails($productId);

        $imagesArray = array();
        // if(count($productDetailsArray['productsImagesArray']['default']) > 0){
        //     foreach ($productDetailsArray['productsImagesArray']['default'] as $key => $img) {
        //         array_push($imagesArray, $img);
        //    }
        // }else{
        //     array_push($imagesArray, $productDetailsArray['productsImagesArray']['thumb'][0]);
        // }
        $productDetailsArray['imagesArray'] = $imagesArray;


        if (isset($productDetailsArray['refName'])) {
            $productDetailsArray['refName'] = $productDetailsArray['refName'];
            $imgUrl = "https://via.placeholder.com/48x33/d3d3d3/FFFFFF/?text=Comfort World";
                if(file_exists(ADMIN_UPLOADS_PATH.BRAND_IMG_FOLDER.$productDetailsArray['refImage']) && (strlen($productDetailsArray['refImage']) > 0) ){
                    $imgUrl = ADMIN_UPLOADS_URL.BRAND_IMG_FOLDER.$productDetailsArray['refImage'];
                }
            $productDetailsArray['refImage'] = $imgUrl;
        }

        // Price Modification
        if (isset($productDetailsArray['dealer_price'])) {
            $productDetailsArray['dealer_price'] = CURRENCY.' '.number_format($productDetailsArray['dealer_price'], 2);
        } 

        
        $productDetailsArray['sale_price'] = CURRENCY.' '.number_format($productDetailsArray['price']['sale_price'], 2);
        if($productDetailsArray['price']['actual_price'] == $productDetailsArray['price']['sale_price']){
            $productDetailsArray['actual_price'] = '';
        }else{
            $productDetailsArray['actual_price'] = CURRENCY.' '.number_format($productDetailsArray['price']['actual_price'], 2);
            $productDetailsArray['discount'] = [
                'discount' => number_format($productDetailsArray['price']['discount']),
                'discount_type' => $productDetailsArray['price']['discount_type'],
            ];
        }

        $stockStatus = 'In Stock';
        $class = 'in-stock-status';
        if ($productDetailsArray['qty'] == 0) {
            $stockStatus = 'Out of Stock';
            $class = 'out-stock-status';
        } 
        
        $productDetailsArray['productAddToCart'] = $this->productAddToCartHtmlContainer($productId, $productDetailsArray['minOrderQty'],$productDetailsArray['description'],$productDetailsArray['qty'],array('stock_status'=>$stockStatus,'class'=>$class));

        return $productDetailsArray;
    }

    public function fetchSliderProducts($slugURL){
        $category_id = $this->fetchCategoryIdBySlugURL($slugURL);
        $productArray = array();
        $select = mysqli_query($this->localhost, "SELECT * FROM `products` WHERE `sub_category` = '$category_id' LIMIT 5 ");
        while($fetch = mysqli_fetch_array($select)){
            $imagesArray = $this->productImagesByTypeArray($fetch['id'], array('thumb' => 2))['thumb'];
            
            array_push($productArray, array(
                'id'=>$fetch['id'],
                'name' => $fetch['name'],
                'thumbArray' => $imagesArray[0],
                'url_query' =>  URL.'shop/pro?q='.$fetch['id'].'&'.urlencode(strtolower(trim($fetch['name']))),
            ));
        }
        return $productArray;
    }//fetchSliderProducts


    public function fetchReviews($product_id){
        $reviewArray = array();
        $select = mysqli_query($this->localhost, "SELECT * FROM `user_reviews` WHERE `product_id` = '$product_id' ");
        if (mysqli_num_rows($select) > 0) {
            while($fetch = mysqli_fetch_array($select)){
            
                array_push($reviewArray, array(
                    'name' => $fetch['name'],
                    'message' => $fetch['message'],
                    'email' => $fetch['email'],
                    'rate' => $fetch['rate'],
                    'created' => $fetch['created'],
                ));
            }
        }
        
        return $reviewArray;
    }


    public function getProOtherContent(Int $productId)
    {
        $contentArray = array();
        $select = mysqli_query($this->localhost, "SELECT * FROM `product_body` WHERE `product_id` = '$productId' ");
        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_array($select);
            $detail = $this->reverse_mysqli_real_escape_string($fetch['details']);
            
            $contentArray = array(
                'title' => $fetch['title'],
                'details' => $detail
                );
        }
        
        return $contentArray;

    } //getProOtherContent()

    public function reverse_mysqli_real_escape_string($str) {
        return strtr($str, [
            '\0'   => "\x00",
            '\n'   => "\n",
            '\r'   => "\r",
            '\\\\' => "\\",
            "\'"   => "'",
            '\"'   => '"',
            '\Z' => "\x1a"
        ]);
    }//reverse_mysqli_real_escape_string

    public function getProDiscountsList(Int $productId)
    {
        
        return $this->productDiscountList($productId);

    } //getProDiscountsList


    public function fetchCategories(){
        $categoryArr = array();
        $select = mysqli_query($this->localhost,"SELECT * FROM `categories` LIMIT 4 ");
        while($fetch = mysqli_fetch_array($select)){
            array_push($categoryArr,array(
                'id'=>$fetch['id'],
                'name'=>$fetch['name'],
                'slug'=>$fetch['slug'],
                'code'=>$fetch['code'],
            ));
        }
        return $categoryArr;
    }

    public function fetchAllCategories(){
        $categoryArr = array();
        $select = mysqli_query($this->localhost,"SELECT * FROM `categories` ");
        while($fetch = mysqli_fetch_array($select)){
            array_push($categoryArr,array(
                'id'=>$fetch['id'],
                'name'=>$fetch['name'],
                'slug'=>$fetch['slug'],
                'code'=>$fetch['code'],
            ));
        }
        return $categoryArr;
    }

    public function trendingProducts($limit){
        $trendingProducts = $this->fetchTrends($limit);
        
        return $trendingProducts;
    }
  
} //productControllerClass

$productControllerObj = new productControllerClass($localhost);

?>