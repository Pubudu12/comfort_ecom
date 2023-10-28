<?php 
require_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';

require_once ROOT_PATH.'app/controllers/headerController.php';
require_once ROOT_PATH.'app/controllers/productsControllerClass.php';

$meta_img = 'https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=Comfort World';


$page_full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$slug = '';
// Check if the URL contains special character &
if (strpos($page_full_url,'&') !== false) {
    $slug = strtok($page_full_url, '&');
    $slug = basename(parse_url($slug, PHP_URL_PATH));
} else {
    $slug = basename(parse_url($page_full_url, PHP_URL_PATH));
}

$categoryId = 0;
// if(isset($_GET['id'])){
//     if(is_numeric($_GET['id'])){
//         $categoryId = trim(mysqli_real_escape_string($localhost, $_GET['id']));        
//     } 
// }

$categoryId = $productControllerObj->fetchCategoryIdBySlugURL($slug);

if (isset($_POST['fetch_pro_detail_on_size'])) {
    $pro_details = $productControllerObj->getStoreSingleProductBySizeAndPro($_POST['size'],$_POST['product_id']);
    echo json_encode($pro_details);
}

if(isset($_GET['q'])){
    $search = trim(mysqli_real_escape_string($localhost, $_GET['q']));
    $search = strtolower($search);
}

$sort = 'latest';
if(isset($_GET['s'])){
    $sort = trim(mysqli_real_escape_string($localhost, $_GET['s']));
    $sort = strtolower($sort);
}

$page = 1;
if(isset($_GET['page'])){
    if(is_numeric($_GET['page'])){
        $page = trim(mysqli_real_escape_string($localhost, $_GET['page']));        
    }
} // check page if end 

// Filter Area
$filterArray = array();
$oneDimensionalRefeArray = array();

$selectMenuRef = mysqli_query($localhost, "SELECT * FROM `references_master_list` WHERE `dimension` = '1d' ");
if(mysqli_num_rows($selectMenuRef) > 0){ 
    while($fetchMenuRef = mysqli_fetch_array($selectMenuRef)){

        $tempMasterId = $fetchMenuRef['id'];
        $tempCode = $fetchMenuRef['code'];
        $selectRefOD = mysqli_query($localhost, "SELECT * FROM `ref_one_dimension` WHERE `master_id` = '$tempMasterId' ");
        if(mysqli_num_rows($selectRefOD) > 0){

            $tempArray = array();
            $selectedGetId = 0;

            if(isset($_GET[strtolower(trim($tempCode))])){
                $tempGetId = $_GET[strtolower(trim($tempCode))];
                
                if($tempGetId > 0){
                    $selectedGetId = $tempGetId;
                    array_push($filterArray, [
                        'id' => $selectedGetId,
                        'code' => $tempCode
                    ]);
                }

            } // Isset
            
            if(strlen(trim(parse_url($page_full_url, PHP_URL_QUERY))) <= 00){
                $filterUrl = URL."shop/";
            }else{
                parse_str(parse_url($page_full_url, PHP_URL_QUERY), $params);
                unset($params[$tempCode]);
                unset($params[$tempCode.'n']);
                $filterUrl = URL."shop/".http_build_query($params);
            }

            array_push($tempArray, [
                'id'=>0,
                'name'=>'All '.$fetchMenuRef['name'],
                'description'=>'',
                'code'=>'',
                'url' => $filterUrl,
                'selected' => $selectedGetId,
            ]);

            while($fetchRefOD = mysqli_fetch_array($selectRefOD)){
            

                array_push($tempArray, [
                    'id'=>$fetchRefOD['id'],
                    'name'=>$fetchRefOD['name'],
                    'description'=>$fetchRefOD['description'],
                    'code'=>$fetchRefOD['code'],
                    'url' => $filterUrl.'&'.$tempCode.'='.$fetchRefOD['id'].'&'.$tempCode.'n='.$productControllerObj->urlEncode($fetchRefOD['name']),
                    'selected' => $selectedGetId,
                ]);
            }

            $oneDimensionalRefeArray[$tempMasterId] = [
                'id' => $fetchMenuRef['id'],
                'name' => $fetchMenuRef['name'],
                'code' => strtolower($tempCode),
                'sub_list' => $tempArray,
            ];

        } // If num Rows End 

    } // Master While End 
} // Master If end 

$sortTypesArray = array(
    '0'=>[
        'code' => 'latest',
        'name' => 'Latest'
    ], 
    '1'=>[
        'code' => 'oldest',
        'name' => 'Oldest'
    ], 
    '2'=>[
        'code' => 'name_asc',
        'name' => 'Name (A - Z)'
    ],
    '3'=>[
        'code' => 'name_desc',
        'name' => 'Name (Z - A)'
    ], 
    '4'=>[
        'code'=>'low_price',
        'name'=>'Price (Low &gt; High)'
    ], 
    '5'=>[
        'code' => 'high_price',
        'name' => 'Price (High &gt; Low)'
    ]
);

$filterUrl = '';
$sortArray = array();
foreach ($sortTypesArray as $key => $singleSort) {
    $tempCode = $singleSort['code'];
    
    if(strlen(trim(parse_url($page_full_url, PHP_URL_QUERY))) <= 00){
        $filterUrl = URL."shop/".$slug;
        
    }else{
        parse_str(parse_url($page_full_url, PHP_URL_QUERY), $params);
        unset($params[$tempCode]);
        unset($params[$tempCode.'s']);
        $filterUrl = URL."shop/".$slug.http_build_query($params);
    }
    
    array_push($sortArray,array(
        'id' => $key,
        'name'=> $singleSort['name'],
        'code'=> $singleSort['code'],
        'url'=> $filterUrl.'&s='.$tempCode,
    ));
}

$otherDetails = $productControllerObj->getStoreSelectedCategoryDetails($slug);
$catlevel = $otherDetails['categoryDetailsArray']['level'];

$fetchPrductsForCategory = $productControllerObj->fetchSliderProducts($slug);

// $catlevel = 1;
$fetchListOfCategories = $productControllerObj->getListOfCategoriesByParentId($slug, $catlevel);

$productsAllArray = $productControllerObj->fetchStoreProductList(['slug'=>$slug, 'categoryLevel' => $catlevel], $filterArray, $page, $sort);

if(isset($search)){

    $productsAllArray = $productControllerObj->searchStrePro($search,$sort = 'latest', $page);
    $proArray = $productsAllArray['productHtmlContainerArray'];
    $paginationArray =  $productsAllArray['pagination'];

    $title = $search;
    $bredcrumb = "Search";

    $cover_img = '';

}else{

    $proArray = $productsAllArray['productHtmlContainerArray'];
    $paginationArray =  $productsAllArray['pagination'];
    // $productsAllArray['url'] = URL."shop/".'&page='.$tempCode;

    $title = $otherDetails['categoryDetailsArray']['name'];
    $bredcrumb = "The Sleep Shop";
    if(isset($otherDetails['categoryDetailsArray']['imagesArray']['cover'][0])){
        $cover_img = $otherDetails['categoryDetailsArray']['imagesArray']['cover'][0];
        $meta_img = $cover_img;
    }
}

$tempCode = $page;

if(strlen(trim(parse_url($page_full_url, PHP_URL_QUERY))) <= 00){
    $filterUrl = URL."shop/";
}else{
    parse_str(parse_url($page_full_url, PHP_URL_QUERY), $params);
    $filterUrl = URL."shop/".http_build_query($params);

}
$activePageURL = $filterUrl.'&page='.$tempCode;

$totalPages = $paginationArray['totalPages'];
$currentpage = $paginationArray['currentpage'];

?>