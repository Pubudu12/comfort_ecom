<?php 
require_once ROOT_PATH.'app/controllers/class/generalFunctionsClass.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

class productClass extends generalClasses{

    public $localhost;

    public function __construct($localhost){
        $this->localhost = $localhost;
    } // Constrcut

    public function getMiniProductsByCategory($catId, $imageTypeArray = ['thumb' => 1]){

        $productsList = array();

        $query = "SELECT pro.*
        FROM `products` AS pro
        WHERE pro.`sub_category` = '$catId' ORDER BY pro.`id` DESC ";
        $select = mysqli_query($this->localhost, $query);
        while($fetch = mysqli_fetch_array($select)){


            $imagesArray = $this->productImagesByTypeArray($fetch['id'], $imageTypeArray);

            $tempArray = [
                'id' => $fetch['id'],
                'name'=> $fetch['name'],
                'url_query' => 'id='.$fetch['id'].'&n='.$this->urlEncode($fetch['name']),
                'imagesArray' => $imagesArray,
            ];

            if(count($tempArray) > 0){
                array_push($productsList, $tempArray);
            }
        } // WHile end 

        return $productsList;

    } //getProductsByCategory

    
    public function getListOfBottomLevelCategoriesByCategoryId($parentCategoryId, $level)
    {

        $categoryIdArray = array();
        
        switch ($level) {
            case ($level == (CAT_MAX_LEVEL-1)):
                    
                    $select = mysqli_query($this->localhost, "SELECT `id` FROM `categories` WHERE `parent` = '$parentCategoryId' ");
                    while($fetch = mysqli_fetch_array($select)){
                        array_push($categoryIdArray, $fetch['id']);
                    }

                break;
            
            default:
                array_push($categoryIdArray, $parentCategoryId);
                break;
        }
        

        return $categoryIdArray;

    } //getListOfBottomLevelCategoriesByCategoryId()


    public function formProductFetchQuery($categoryArray, $filterArray, $sort, $ignoreArray = [])
    {
        // sql statement to get lowest price
        $masterQuery = " SELECT p.`id`, p.`name`, p.`min_order_qty`,price.`actual_price`, p.`active`,p.`approved`,price.`discount_type`,price.`discount`,
                        MIN(price.sale_price) as sale_price , MIN(price.dealer_price) AS dealer_price ,sc.`name` categoryname ,p.`3d_link`,p.`upwards_status`,p.`sub_category`
                        FROM products AS p 
                        INNER JOIN (SELECT ps.product_id FROM price ps GROUP BY ps.product_id ) pro ON pro.product_id = p.id 
                        INNER JOIN price ON price.product_id = p.id 
                        INNER JOIN `categories` sc ON sc.`id` = p.`sub_category` ";
        
        // -------------previous sql-------------------
        // "SELECT p.`id`, p.`name`, p.`min_order_qty`, 
        //                         price.`sale_price`, price.`actual_price`,price.`dealer_price`,
        //                         sc.`name` categoryname
        //                 FROM `products` p 
        //                 INNER JOIN `price` ON price.`product_id` = p.`id` 
        //                 INNER JOIN `categories` sc ON sc.`id` = p.`sub_category` ";
        
        $category_idsArray = [$categoryArray['category_id']];
        if($categoryArray['category_id'] > 0){
            
            $categoryLevel = $categoryArray['categoryLevel'];
            if($categoryLevel != CAT_MAX_LEVEL){ 
                $category_idsArray = array_merge($category_idsArray,$this->getListOfBottomLevelCategoriesByCategoryId($categoryArray['category_id'], $categoryLevel));
            }else{
                // $category_idsArray = [$categoryArray['category_id']];
            }

            $categoryIdList = implode("','", $category_idsArray);
            $masterQuery .= " AND sc.`id` IN ('$categoryIdList') ";
            
        }
        

        if(count($filterArray) > 0){
            //  If Filter Available

            foreach($filterArray as $key => $singleFilter){
                $singleFilterId = $singleFilter['id'];
                $masterQuery .= " INNER JOIN `ref_pro_one2one` refProFilter".$key." ON refProFilter".$key.".`product_id` = p.`id` AND refProFilter".$key.".`reference_id` = '$singleFilterId' ";
            }
        }

        


        $masterQuery .= " WHERE (p.`active` = '1' AND p.`approved` = '1') ";
        

        if(count($ignoreArray) > 0){
            
            if(isset($ignoreArray['product_id'])){

                $ignoreProId = $ignoreArray['product_id'];
                $masterQuery .= " AND p.`id` != '$ignoreProId' ";
                
            }

        }

        switch($sort){
            case 'latest':
                $sort_column = 'p.`product_order`';
                $sort_order = "ASC";
                break;
        
            case 'oldest':
                $sort_column = 'p.`product_order`';
                $sort_order = "DESC";
                break;
            
            case 'low_price':
                $sort_column = 'price.`sale_price`';
                $sort_order = "ASC";
                break;
        
            case 'high_price':
                $sort_column = 'price.`sale_price`';
                $sort_order = "DESC";
                break;
            
            case 'name_asc':
                $sort_column = 'p.`name`';
                $sort_order = "ASC";
                break;
        
            case 'name_desc':
                $sort_column = 'p.`name`';
                $sort_order = "DESC";
                break;
        
            default: 
                $sort_column = 'p.`id`';
                $sort_order = "DESC";
        
        } // switch end

        $masterQuery .= "GROUP BY p.id ORDER BY $sort_column $sort_order ";
                
        return $masterQuery;

    } //formProductFetchQuery()


    public function getCategoryImagesByCode($category_id, $type, $count = 1, $replace = true){

        $imgArray = array();

        $query = "SELECT `name` FROM `categories_images` WHERE `category_id` = '$category_id' AND `type` = 'cover' ORDER BY `id` DESC LIMIT 0, $count ";
        $select = mysqli_query($this->localhost, $query);
        if(mysqli_num_rows($select) > 0){
            
            while($fetch = mysqli_fetch_array($select)){
                $imgUrl = $this->checkImage(CAT_IMG_FOLDER, $fetch['name']);
                array_push($imgArray, $imgUrl);
            }
        }

        if($replace == true){

            $differenceInImagesCount = $count-count($imgArray);
            if($differenceInImagesCount != 0){
                $dummyImage = $this->categoryDummyImage();

                while ($differenceInImagesCount >= 1) {
                    array_push($imgArray, $dummyImage);
                    $differenceInImagesCount--;
                }
            }
        }

        return $imgArray;

    } //getCategoryImagesByCode

    public function categoryImagesByCodeArray($category_id, $imageTypeArray, $replace = true){

        $imagesArray = Array();

        if(count($imageTypeArray) > 0){
            foreach ($imageTypeArray as $type => $count) {
                
                $imagesArray[$type] = $this->getCategoryImagesByCode($category_id, $type, $count, $replace);

            }
        }

        return $imagesArray;
        
 
    } //fetchCategoryImages


    public function listOfCategoriesByLevel(Int $level )
    {

        $listCategoriesArray = array();
        $select = mysqli_query($this->localhost, "SELECT * FROM `categories` WHERE `level` = '$level' ");
        if(mysqli_num_rows($select) > 0){

            while($fetch = mysqli_fetch_array($select)){

                array_push($listCategoriesArray, array(
                    'id' => $fetch['id'],
                    'name' => $fetch['name'],
                    'url_query'=> 'id='.$fetch['id'].'&n='.$this->urlEncode($fetch['name']),
                ));

            } // while end

        } // No Of rows

        return $listCategoriesArray;
    } //listOfCategoriesByLevel

    public function getCategoriesListByParentid($categoryId, $catlevel)
    {
        
        $categoriesArray = array();
        $selectQuery = '';
        if($catlevel >= CAT_MAX_LEVEL){
            
            $selectQuery = "SELECT subCat.* 
                            FROM `categories` AS subCat
                            INNER JOIN `categories` AS mainCat ON mainCat.`id` = '$categoryId'
                            WHERE subCat.`parent` = mainCat.`parent` ";
             
        }else{
            $selectQuery = "SELECT * FROM `categories` WHERE `parent` = '$categoryId' ";
        }
        
        $select = mysqli_query($this->localhost, $selectQuery);
        
        if(mysqli_num_rows($select) > 0){
            while($fetch = mysqli_fetch_array($select)){
                $imagesArray = $this->categoryImagesByCodeArray($fetch['id'], array('cover' => 1), $replace = false);
                array_push($categoriesArray, [
                    'id' => $fetch['id'],
                    'name' => $fetch['name'],
                    'level' => $fetch['level'],
                    'url_query' => 'id='.$fetch['id'].'&n='.$this->urlEncode($fetch['name']),
                    'catgeory_images'=>$imagesArray
                ]);

            }
        }

        return $categoriesArray;

    }//getCategoriesListByParentid()


    public function categoryDetailsById(Int $category_id){

        $categoryDetailsArray = array();

        $query = "SELECT cat.* FROM `categories` AS cat WHERE cat.`id` = '$category_id' ";

        $select = mysqli_query($this->localhost, $query);
        if(mysqli_num_rows($select) > 0){

            $fetch = mysqli_fetch_array($select);

            $url_query = 'id='.$fetch['id'].'&n='.$this->urlEncode($fetch['name']);
            $id = $fetch['id'];
            $name = $fetch['name'];
            $code = $fetch['code'];
            $level = $fetch['level'];
            $imagesArray = $this->categoryImagesByCodeArray($fetch['id'], array('cover' => 1, 'thumb' => 1), $replace = false);

        }else{

            $url_query = '#';
            $id = 0;
            $name = 'All Products';
            $code = '';
            $level = 0;
            $imagesArray = '';

        }

        $categoryDetailsArray = array(
            'url_query' => $url_query,
            'id' => $id,
            'name' => $name,
            'code' => $code,
            'level' => $level,
            'imagesArray' => $imagesArray,
        );

        return $categoryDetailsArray;

    } //categoryDetailsById

    public function menuListByCode($parent, $startLevel, $maxLevel, $products = 1, $code = NULL, $imgTypeArray = array('thumb'=>1, 'default' => 3, 'cover' => 1)){

        $CategoriesArray = array();

        $query = "SELECT cat.`id`, cat.`name`, cat.`code`,cat.`slug`
                    FROM `categories` AS cat 
                    LEFT JOIN `categories_images` AS cim ON cim.`category_id`=cat.`id`
                    WHERE cat.`level` = '$startLevel' AND cat.`parent` = '$parent' ";
        if($code != NULL){
            $query .= " AND cat.`code` = '$code' ";
        }

        $select = mysqli_query($this->localhost, $query);
        $control = 1;
        while($fetch = mysqli_fetch_array($select)){

            $class = 'col-lg-3 col-md-3';
            switch ($control) {
                case 1:
                    $class = 'col-lg-6 col-md-6';
                    break;
                case 2:
                    $class = 'col-lg-6 col-md-6';
                    break;
                case 3:
                    $class = 'col-lg-3 col-md-3';
                    break;
                case 4:
                    $class = 'col-lg-6 col-md-6';
                    break;
                case 5:
                    $class = 'col-lg-3 col-md-3';
                    break;
                case 6:
                    $class = 'col-lg-4 col-md-4';
                    break;
                case 7:
                    $class = 'col-lg-4 col-md-4';
                    break;
                default:
                    $class = 'col-lg-4 col-md-4';
                    break;
            }

            $tempArray = array();
            $tempArray['url_query'] = 'id='.$fetch['id'].'&n='.$this->urlEncode($fetch['name']);
            $tempArray['slug_url'] = $fetch['slug'];
            $tempArray['id'] = $fetch['id'];
            $tempArray['name'] = $fetch['name'];
            $tempArray['code'] = $fetch['code'];
            $tempArray['class'] = $class;
            $tempArray['imagesArray'] = $this->categoryImagesByCodeArray($fetch['id'], $imgTypeArray);

            if($startLevel <= $maxLevel){
                $tempArray['subCat'] = $this->menuListByCode($fetch['id'], $startLevel+1, $maxLevel, $products);
            }else if($products == 1){
                
                $tempArray['products'] = $this->getMiniProductsByCategory($fetch['id']);

            }

            if(count($tempArray) > 0){
                array_push($CategoriesArray, $tempArray);
            }
            $control++;
        } // WHile End 

        return $CategoriesArray;

    } //menuListByCode


    // Products Side
    public function getProductImagesByType($product_id, $type, $count = 1){

        $imgArray = array();

        $query = "SELECT `name` FROM `product_images` WHERE `product_id` = '$product_id' AND `type` = '$type' ORDER BY `id` DESC ";

        if($count != 0){
            $query .= " LIMIT 0, $count ";
        }

        $select = mysqli_query($this->localhost, $query);
        if(mysqli_num_rows($select) > 0){
            
            while($fetch = mysqli_fetch_array($select)){
                $imgUrl = $this->checkImage(PRO_IMG_FOLDER, $fetch['name']);
                array_push($imgArray, $imgUrl);
            }
        }

        if($count > 0){
            $differenceInImagesCount = $count-count($imgArray);
            if($differenceInImagesCount != 0){
                $dummyImage = $this->productDummyImage();
    
                while ($differenceInImagesCount >= 1) {
                    array_push($imgArray, $dummyImage);
                    $differenceInImagesCount--;
                }
            }
        }

        return $imgArray;

    } //getCategoryImagesByCode

    public function productImagesByTypeArray($product_id, $imageTypeArray){

        $imagesArray = Array();

        if(count($imageTypeArray) > 0){
            foreach ($imageTypeArray as $type => $count) {
                
                $imagesArray[$type] = $this->getProductImagesByType($product_id, $type, $count);

            }
        }

        return $imagesArray;
        

    } //fetchCategoryImages

    // Prodi=ucts Fetch
    public function fetchProductsClass($query){

        $productsArray = array();

        $select = mysqli_query($this->localhost, $query);
        $numofProducts = mysqli_num_rows($select);

        if($numofProducts > 0){

            while($fetch = mysqli_fetch_array($select)){

                $offerText = '';
                $offerTextArray = $this->productDiscountList($fetch['id']);
                if(count($offerTextArray) > 0){
                    $offerText = $offerTextArray[0]['name'];
                }

                $imagesArray = $this->productImagesByTypeArray($fetch['id'], array('cover' => 2))['cover'];

                $gump = new GUMP();
                $productsList = $gump->sanitize($fetch); 
                $sanitized_query_data = $gump->run($productsList);
                $name = $sanitized_query_data['name'];
               
                $tempArray = array(
                    'id' => $fetch['id'],
                    'name' => $name,
                    'category_id'=>$fetch['sub_category'],
                    'category' => $fetch['categoryname'],
                    'sale_price' => $fetch['sale_price'],
                    'dealer_price' => $fetch['dealer_price'],
                    'actual_price' => $fetch['actual_price'],
                    'min_order_qty' => $fetch['min_order_qty'],
                    'offer_text' => $offerText,
                    'discount'=>$fetch['discount'],
                    'discount_type'=>$fetch['discount_type'],
                    '3d_link'=>$fetch['3d_link'],
                    'upwards_status'=>$fetch['upwards_status'],
                    'thumbArray' => $imagesArray,
                    'url_query' => 'q='.$fetch['id'].'&'.urlencode(strtolower(trim($fetch['name']))),
                );

                array_push($productsArray, $tempArray);

            }// WHile end 

        } // Row num end


        return array('count' => $numofProducts, 'productsArray' => $productsArray);

    } //fetchProducts

    public function pagination($query, $pageNo, $limit)
    {

        $paginationArray = array();
        $paginationDetails = array();
        
        $select = mysqli_query($this->localhost, $query);
        $totalRows = mysqli_num_rows($select);

        $totalPages = ceil(($totalRows/$limit));

        $currentStart = ($pageNo-1)*$limit;
        $currentEnd = $currentStart+$limit;

        $showingProductsStart = ($currentStart+1);
        $showingProductsEnd = $currentEnd;
        if($totalRows == 0){
            $showingProductsStart = 0;
        }
        if($totalRows <= $currentEnd){
            $showingProductsEnd = $totalRows;
        }

        $paginationDetails = [
            'showingProductsStart' => $showingProductsStart,
            'showingProductsEnd' => $showingProductsEnd,
            'currentpage' => $pageNo,
            'totalRows' => $totalRows,
            'totalPages' => $totalPages,
        ];

        $query .= " LIMIT $currentStart, $currentEnd ";

        $paginationArray['query'] = $query;
        $paginationArray['details'] = $paginationDetails;

        return $paginationArray;

    } //pagination()

    public function getProductsList($dataFilter, $sort, $pageNo){

        $select_query = "SELECT  p.`id`, p.`name`, p.`min_order_qty`,price.`discount`,price.`discount_type`,
                        price.`sale_price`, price.`actual_price`,price.`dealer_price`,p.`3d_link`,p.`upwards_status`,p.`sub_category`,
                        sc.`name` categoryname
                        FROM `products` p 
                        INNER JOIN `price` ON price.`product_id` = p.`id` 
                        INNER JOIN `categories` sc ON sc.`id` = p.`sub_category`  ";

        if(isset($dataFilter['category_id'])){
            $category_id = $dataFilter['category_id'];
            if($category_id > 0){
                // Filter by sub cat
                $select_query .= " AND sc.`id` = '$category_id' ";
            }
        }

        $select_query .= " WHERE (p.`active` = '1' AND p.`approved` = '1') ";

        if(isset($dataFilter['search'])){
            $search = $dataFilter['search'];
            $select_query .= " AND p.`name` LIKE '%$search%' OR sc.`name` LIKE '%$search%' ";
        }

        switch($sort){
            case 'latest':
                $sort_column = 'p.`id`';
                $sort_order = "DESC";
                break;
        
            case 'oldest':
                $sort_column = 'p.`id`';
                $sort_order = "ASC";
                break;
            
            case 'low_price':
                $sort_column = 'price.`sale_price`';
                $sort_order = "ASC";
                break;
        
            case 'high_price':
                $sort_column = 'price.`sale_price`';
                $sort_order = "DESC";
                break;
            
            case 'name_asc':
                $sort_column = 'p.`name`';
                $sort_order = "ASC";
                break;
        
            case 'name_desc':
                $sort_column = 'p.`name`';
                $sort_order = "DESC";
                break;
        
            default: 
                $sort_column = 'p.`id`';
                $sort_order = "DESC";
        
        } // switch end

        $select_query .= "GROUP BY price.`product_id`  ORDER BY $sort_column $sort_order ";

        $paginationArray = $this->pagination($select_query, $pageNo, $limit = 24);

        $select_query = $paginationArray['query'];

        $productArray = $this->fetchProductsClass($select_query);
        $productArray['pagination'] = $paginationArray['details'];

        return $productArray;

    } //fetchproducts

    public function singleProImages($productId){
        $images_array = array();
        $select_all_images = mysqli_query($this->localhost,"SELECT * FROM `product_images` WHERE `product_id`='$productId' ORDER BY `id` DESC ");
        if(mysqli_num_rows($select_all_images) > 0){
            while($fetch_all_images = mysqli_fetch_array($select_all_images)){
                // array_push($images_array, URL.PRO_IMG_PATH.$fetch_all_images['name']);
                $imgUrl = $this->checkImage(PRO_IMG_FOLDER, $fetch_all_images['name']);
                array_push($images_array, $imgUrl);
            }
        }else {
            array_push($images_array,'https://via.placeholder.com/1500x1500/d3d3d3/FFFFFF/?text=Comfort World');
        }
       
        return $images_array;
    }

    // Single Product Details
    public function getSingleProductDetails(Int $productId, $informative = false )
    {

        $productsDetailsArray = array();

        $query = "SELECT p.*, 
                    price.`actual_price`, price.`discount`, price.`sale_price`, price.`discount_type`,price.`dealer_price`,
                    cat.`name` categoryName,cat.`slug`,refone.`name` refName,refone.`image_name` refImage
                    FROM `products` AS p
                    INNER JOIN `price` ON price.`product_id` = p.`id`
                    INNER JOIN `categories` AS cat ON cat.`id` = p.`sub_category`
                    LEFT JOIN `ref_pro_one2one` AS refpro ON refpro.`product_id` = p.`id`
                    LEFT JOIN `ref_one_dimension` AS refone ON refone.`id` = refpro.`reference_id`
                    WHERE p.`id` = '$productId' AND p.`approved` = '1' AND p.`active` = '1' AND p.`modified_approval`='1' AND p.`onsale` = '1' ";

        if($informative == true){
            $query = "SELECT p.*,  cat.`name` categoryName,cat.`slug`,refone.`name` refName, refone.`image_name` refImage
                        FROM `products` AS p
                        INNER JOIN `categories` AS cat ON cat.`id` = p.`sub_category`
                        LEFT JOIN `ref_pro_one2one` AS refpro ON refpro.`product_id` = p.`id`
                        LEFT JOIN `ref_one_dimension` AS refone ON refone.`id` = refpro.`reference_id`
                        WHERE p.`id` = '$productId' AND p.`approved` = '1' AND p.`active` = '1' AND p.`modified_approval`='1' ";
        }

        
        $select = mysqli_query($this->localhost, $query);
        $fetch = mysqli_fetch_array($select);

        $FB_common_link = 'https://www.facebook.com/comfortwi/photos/';
        $Twitter_common_link = 'https://www.facebook.com/comfortwi/photos/';
        $productsDetailsArray['name'] = $fetch['name'];
        $productsDetailsArray['fb_link'] = $FB_common_link.'?p='.urlencode(strtolower(trim($fetch['name'])));
        $productsDetailsArray['onsale'] = $fetch['onsale'];    
        $productsDetailsArray['item_code'] = $fetch['item_code'];
        $productsDetailsArray['categoryName'] = $fetch['categoryName'];
        $productsDetailsArray['category_id'] = $fetch['sub_category'];
        $productsDetailsArray['slug'] = $fetch['slug'];

        $productsDetailsArray['description'] = $fetch['description'];
        $productsDetailsArray['3d_link'] = $fetch['3d_link'];

        if(isset($fetch['actual_price'])){
            $productsDetailsArray['price'] = [
                'actual_price' => $fetch['actual_price'],
                'discount' => $fetch['discount'],
                'discount_type' => $fetch['discount_type'],
                'sale_price' => $fetch['sale_price'],
            ];
        }
        if (isset($fetch['dealer_price'])) {
            $productsDetailsArray['dealer_price'] = $fetch['dealer_price'];
        }

        if (isset($fetch['refName'])) {
            $productsDetailsArray['refName'] = $fetch['refName'];
            $productsDetailsArray['refImage'] = $fetch['refImage'];
        }

        $productsDetailsArray['minOrderQty'] = $fetch['min_order_qty'];
        $productsDetailsArray['qty'] = $this->getProductQty($productId,2);

        // Images Fetch
        $imageTypeArray = ['thumb' => 1, 'cover' => 1, 'default' => 0];
        // $productsDetailsArray['productsImagesArray'] = $this->productImagesByTypeArray($productId, $imageTypeArray);
        $productsDetailsArray['productsImagesArray'] = $this->singleProImages($productId);
              
        return $productsDetailsArray;

    } //getSingleProductDetails

    public function getProductQty(Int $productId,$size_id)
    {
        
        // Check Wheather Track Stock or not
        $select = mysqli_query($this->localhost, "SELECT `track_stock` FROM `products` WHERE `id` = '$productId' AND `track_stock` = '0' ");
        if(mysqli_num_rows($select) == 1){

            // If stock Infinite 
            $totalQty = 2000;

        }else{

            $select = mysqli_query($this->localhost, " SELECT SUM(s.`qty`) totalQty FROM `price` AS p
                                                    INNER JOIN `stock` AS s ON s.`price_id` = p.`id` 
                                                    WHERE p.`product_id` = '$productId' AND p.`size_id`='$size_id' GROUP BY s.`price_id` ");
        
            $fetch = mysqli_fetch_array($select);

            if(isset($fetch['totalQty'])){
                $totalQty = $fetch['totalQty'];
            }else{
                $totalQty = 0;
            }

        }

        return $totalQty;

    } //getProductQty

    public function productDiscountList(Int $productId)
    {
        $discountArray = array();

        $select = mysqli_query($this->localhost, "SELECT * FROM `pro_discounts` WHERE `product_id` = '$productId' ORDER BY `min_qty` ASC ");
        if(mysqli_num_rows($select) > 0){

            while($fetch = mysqli_fetch_array($select)){

                $name = trim($fetch['name']);
                if(strlen($name) == 0){
                    if($fetch['discount_type'] == '/'){
                        $disText = "flat ".number_format($fetch['discount_value']).' off';
                    }else{
                        $disText = number_format($fetch['discount_value']).'% off';
                    }
                    $name = "Order minimum ".$fetch['min_qty']." qty to get ".$disText;
                }

                array_push($discountArray, [
                    'name' => $name,
                    'min_qty' => $fetch['min_qty'],
                    'discount_type' => $fetch['discount_type'],
                    'discount_value' => $fetch['discount_value'],
                ]);

            } // While End 

        }

        return $discountArray;
    }

    public function fetchTrends($limit){
        $productsArray = array();
        $select = mysqli_query($this->localhost,"SELECT p.`id`, p.`name`, p.`min_order_qty`, MIN(price.sale_price) as sale_price 
                                                    ,pim.`name` AS 'image' 
                                                    FROM `products` p 
                                                    LEFT JOIN `product_images` AS pim ON pim.`product_id`=p.`id` 
                                                    INNER JOIN (SELECT ps.product_id FROM price ps GROUP BY ps.product_id ) pro ON pro.product_id = p.id 
                                                    INNER JOIN `price` ON price.`product_id` = p.`id` 
                                                    WHERE pim.`type`='cover' AND p.`active`='1'
                                                    GROUP BY pim.`product_id` 
                                                    ORDER BY p.`id` ASC
                                                    LIMIT $limit ");

        // SELECT p.`id`, p.`name`, p.`min_order_qty`,price.`actual_price`, p.`active`,p.`approved`,price.`discount_type`,price.`discount`,
        // MIN(price.sale_price) as sale_price , MIN(price.dealer_price) AS dealer_price ,sc.`name` categoryname 
        // FROM products AS p 
        // INNER JOIN (SELECT ps.product_id FROM price ps GROUP BY ps.product_id ) pro ON pro.product_id = p.id 
        // INNER JOIN price ON price.product_id = p.id 
        // INNER JOIN `categories` sc ON sc.`id` = p.`sub_category` 
        $controlVariable = 1;
        while($fetch = mysqli_fetch_array($select)){
            // $imagesArray = $this->productImagesByTypeArray($fetch['id'], array('cover' => 2))['cover'];
            $image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=Comfort World";
            // if(file_exists(ADMIN_UPLOADS_PATH.PRO_IMG_FOLDER.$image) && (strlen($image) > 0) ){
            //     $thumbnail_image = ADMIN_UPLOADS_URL.PRO_IMG_FOLDER.$image;
            // }
            
            if ($fetch['image'] != null) {
                    $image = ADMIN_UPLOADS_URL.PRO_IMG_FOLDER.$fetch['image'];
            }

            $gump = new GUMP();
            $fetch = $gump->sanitize($fetch); 
            $sanitized_query_data = $gump->run($fetch);
            $name = $sanitized_query_data['name'];
            
            $tempArray = array(
                'id' => $fetch['id'],
                'name' => $name,
                'sale_price' => $fetch['sale_price'],
                'min_order_qty' => $fetch['min_order_qty'],
                'thumbArray' => $image,
                'url_query' =>  URL.'shop/pro?q='.$fetch['id'].'&'.urlencode(strtolower(trim($fetch['name']))),            
            );
            $controlVariable++;
            
            array_push($productsArray, $tempArray);
        }
        return $productsArray;
    }

} //productClass

?>