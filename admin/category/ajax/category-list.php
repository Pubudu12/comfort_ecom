<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
/* Database connection start */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$cat_level = 1;

if(isset($_POST['cat_level'])){
    $cat_level = (int)$_POST['cat_level'];
}

$no = 1;
$columns = array( 
// datatable column index  => database column name
    0 => 'id',
    1 => 'cat1',
    2 => 'thumb',
	3 => 'id'
);

// getting total number records without any search
$sql ="SELECT cat1.`name` cat1, cat1.`id`, thumb.`name` AS thumb ";

if($cat_level > 1){

    for ($i=2; $i <= $cat_level; $i++) { 
        $sql .= ", cat".$i.".`name` AS cat".$i." ";
    }
    
}

$sql .= "   FROM `categories` AS cat1
            LEFT JOIN `categories_images` AS thumb ON thumb.`category_id` = cat1.`id` AND thumb.`type` = 'cover' ";

if($cat_level > 1){

    for ($i=2; $i <= $cat_level; $i++) {
        $sql .= " LEFT JOIN `categories` AS cat".$i." ON cat".$i.".`id` = cat".($i-1).".`parent` ";
    }
    
}
   
$sql .= " WHERE cat1.`level` = '$cat_level' ";

// echo $sql;
$query = mysqli_query($localhost, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

    $search = $requestData['search']['value'];

	$sql.=" AND ( cat1.`name` LIKE '%$search%' ";
    

	$sql.=" OR cat1.`name` LIKE '%$search%' )";
}

$query=mysqli_query($localhost, $sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	



$query=mysqli_query($localhost, $sql);

$data = array();
$no = $requestData['start']+1;
while( $row = mysqli_fetch_array($query) ) {  // preparing an array

        
        $nestedData=array();

        $category_id = $row['id'];

        $sub_name = '';
        if($cat_level > 1){

            $sub_name .= "<br>";

            for ($i=2; $i <= $cat_level; $i++) {
                $temColName = "cat".$i; 
                $sub_name .= "<small> <i class='fa fa-chevron-left'></i> ".$row[$temColName]."</small>";
                $sql .= ", cat".$i.".`name` AS cat".$i." ";
            }
            
        }

        $name = $row['cat1'].$sub_name;

        $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=".CLIENT_NAME;
        if(file_exists(ROOT_PATH.CAT_IMG_PATH.$row['thumb']) && (strlen($row['thumb']) > 0) ){
            $thumbnail_image = URL.CAT_IMG_PATH.$row['thumb'];
        }
        $thumbnail_image = '<img src="'.$thumbnail_image.'" class="product_img w-20">';

        $edit_btn = '<a href="'.URL.'category/editCategory.php?id='.$category_id.'" class="btn btn-primary fa fa-edit" title="Edit Category"></a>';
        $upload_img_btn = '<a href="'.URL.'category/uploadImg.php?id='.$category_id.'" class="btn btn-default fa fa-upload" title="Updates Images"></a>';
        $delete_btn = ' <button  class="btn btn-sm btn-danger fa fa-trash-o"
                        onclick="deleteItem(this)"
                        data-after-success=3
                        data-id="'.$category_id.'"
                        data-refresh=dataTableRefresh
                        data-url="'.URL.'category/ajax/controller/deleteCategoryController.php"
                        data-key="delete_category"></button>';
        $action_btn = $edit_btn.' '.$upload_img_btn.' '.$delete_btn;

        $nestedData[] = $no;
        $nestedData[] = $name;
        $nestedData[] = $thumbnail_image;
        $nestedData[] = $action_btn;
	
	    $data[] = $nestedData;
        $no++;
}




$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
