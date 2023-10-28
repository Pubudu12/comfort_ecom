<?php 
include_once '../../../app/global/url.php';
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
    1 => 'name',
	2 => 'id'
);

// getting total number records without any search
$sql ="SELECT * FROM `blog_categories` WHERE 1=1 ";
   
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

        
        $nestedData=array();

        $category_id = $row['id'];
        $name = $row['name'];

        $edit_btn = '<a href="'.URL.'blog/category/edit?id='.$category_id.'" class="btn btn-primary fa fa-edit" title="Edit Category"></a>';
        $delete_btn = ' <button  class="btn btn-sm btn-danger fa fa-trash-o"
                        onclick="deleteItem(this)"
                        data-after-success=3
                        data-id="'.$category_id.'"
                        data-refresh=dataTableRefresh
                        data-url="'.URL.'blog/categories/ajax/controller/deleteBlogCategoryController.php"
                        data-key="delete_blog_category"></button>';
        $action_btn = $edit_btn.'|'.$delete_btn;

        $nestedData[] = $no;
        $nestedData[] = $name;
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
