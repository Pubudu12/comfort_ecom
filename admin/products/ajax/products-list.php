<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

/* Database connection start */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$sub_category = (int)$_POST['sub_category'];

$no = 1;
$columns = array( 
// datatable column index  => database column name
    0 => 'id',
    1 => 'thumb',
    2 => 'name',
	3 => 'id'
);

// getting total number records without any search
$sql =" SELECT * FROM `products` WHERE `active`='1' ";

// $sql .= " WHERE 1=1 ";

if($sub_category > 0){
    $sql .= " AND `sub_category` = '$sub_category' ";
}

// echo $sql;

$query = mysqli_query($localhost, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

    $search = $requestData['search']['value'];

    $sql.=" AND ( `name` LIKE '%$search%' )";
}

$query=mysqli_query($localhost, $sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query=mysqli_query($localhost, $sql);

$data = array();
$no = $requestData['start']+1;

while( $row = mysqli_fetch_array($query) ) {
    $gump = new GUMP();
    $row = $gump->sanitize($row); // You don't have to sanitize, but it's safest to do so.
    
    $sanitized_query_data = $gump->run($row);
        $nestedData=array();
        $product_id = $sanitized_query_data['id'];
        $select = mysqli_query($localhost, "SELECT `name` 
                                            FROM `product_images` 
                                            WHERE `type`='cover' AND `product_id` = '$product_id' ");
     
        $fetch = mysqli_fetch_array($select);

        $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=".CLIENT_NAME;
        if(isset($fetch['name']) ){
            if(file_exists(ROOT_PATH.PRO_IMG_PATH.$fetch['name']) ){
                $thumbnail_image = URL.PRO_IMG_PATH.$fetch['name'];
            }
        }

        $thumbnail_image = '<img src="'.$thumbnail_image.'" class="product_img w-40">';

        $assignSerialBtn = '<a href="'.URL.'products/assignSerialNumbers.php?id='.$product_id.'" class="btn btn-primary fa fa-list-alt" target="_blank" title="Assign Serial Numbers"></a>';
        $assignDealerBtn = '<a href="'.URL.'products/assignDealers.php?id='.$product_id.'" class="btn btn-primary fa fa-users" target="_blank" title="Assign Dealers"></a>';
        $edit_btn = '<a href="'.URL.'products/edit_product.php?id='.$product_id.'" class="btn btn-primary fa fa-edit" target="_blank" title="Edit Product"></a>';
        $upload_img_btn = '<a href="'.URL.'products/upload_images.php?id='.$product_id.'" class="btn btn-default fa fa-upload" target="_blank" title="Upload Images"></a>';
        $delete_btn = '<button  class="btn btn-sm btn-danger fa fa-trash-o"
                        onclick="deleteItem(this)"
                        data-after-success=1
                        data-id="'.$product_id.'" 
                        data-refresh='.URL.'" 
                        data-url="'.URL.'products/ajax/controller/deleteProductController.php" 
                        data-key="delete_product"></button>';
        $action_btn = $edit_btn.' '.$assignSerialBtn.' '.$assignDealerBtn.' '.$upload_img_btn.' '.$delete_btn;
        $action_btn = $assignSerialBtn.' '.$assignDealerBtn.' '.$edit_btn.' '.$upload_img_btn.' '.$delete_btn;
        $name = $sanitized_query_data['name'];

        $nestedData[] = $no;
        $nestedData[] = $thumbnail_image;
        $nestedData[] = '<a href="'.URL.'products/view_product.php?id='.$product_id.'" > '.$name.' </a>';
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
