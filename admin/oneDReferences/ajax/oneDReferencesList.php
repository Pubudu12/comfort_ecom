<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
/* Database connection start */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$ref_id = 0;

if(isset($_POST['ref_id'])){
    $ref_id = (int)$_POST['ref_id'];
}

$no = 1;
$columns = array( 
// datatable column index  => database column name
    0 => 'id',
    1 => 'name',
    1 => 'id',
	2 => 'id'
);

// getting total number records without any search
$sql ="SELECT * FROM `ref_one_dimension` WHERE `master_id` = '$ref_id' ";
   
// echo $sql;
$query = mysqli_query($localhost, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $search = $requestData['search']['value'];
	$sql.=" AND ( `name` LIKE '%$search%' ";
	$sql.=" OR `id` LIKE '%$search%' )";
}

$query=mysqli_query($localhost, $sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	



$query=mysqli_query($localhost, $sql);

$data = array();
$no = $requestData['start']+1;
while( $row = mysqli_fetch_array($query) ) {  // preparing an array


        $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=".CLIENT_NAME;
        if(file_exists(ROOT_PATH.BRAND_IMG_PATH.$row['image_name']) && (strlen($row['image_name']) > 0) ){
            $thumbnail_image = URL.BRAND_IMG_PATH.$row['image_name'];
        }
        $thumbnail_image = '<img src="'.$thumbnail_image.'" class="product_img w-50">';
        
        $nestedData=array();

        $reference_id = $row['id'];
        $name = $row['name'];

        $edit_btn = '<a href="'.URL.'ref/1d/update?id='.$reference_id.'" class="btn btn-primary fa fa-edit" title="Edit Reference"></a>';
        $upload_img_btn = '<a href="'.URL.'ref/1d/image?id='.$reference_id.'" class="btn btn-primary fa fa-upload" title="Updates Images"></a>';
        $delete_btn = ' <button  class="btn btn-sm btn-danger fa fa-trash-o"
                        onclick="deleteItem(this)"
                        data-after-success=3
                        data-id="'.$reference_id.'"
                        data-refresh=dataTableRefresh
                        data-url="'.URL.'oneDReferences/ajax/controller/deleteOneDReferencesController.php"
                        data-key="delete_1d_reference"></button>';
        $action_btn = $edit_btn.' | '.$upload_img_btn.' | '.$delete_btn;

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
