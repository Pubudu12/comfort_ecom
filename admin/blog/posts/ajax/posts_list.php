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
$sql = "SELECT p.*, btype.`type` as bType FROM `blog_posts` AS p 
		INNER JOIN `blog_type` AS btype ON btype.`id` = p.`post_type`
		WHERE p.`hide` = 0 ";
   
// echo $sql;
$query = mysqli_query($localhost, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( p.`id` LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.`heading` LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.`created` LIKE '".$requestData['search']['value']."%' ";

	$sql.=" OR p.`id` LIKE '".$requestData['search']['value']."%' )";
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
	$id = $row['id'];
	$post_url = URL.'blog/post/update?id='.$id;


	$edit_button = '<a href="'.URL.'blog/post/update?id='.$id.'" class="btn btn-sm btn-outline-primary"> <i class="fa fa-edit"></i> </a>';
	$delete_button = '<button class="btn btn-outline-danger btn-sm" 
						onclick="deleteItem(this)" 
						data-id="'.$id.'" 
						data-after-success = 3
						data-refresh="dataTableRefresh" 
						data-url="'.URL.'blog/posts/ajax/controller/deletePostController.php" 
						data-key="delete_post">
						<i class="fa fa-trash"></i> </button>';
	
	$nestedData[] = $no;
	$nestedData[] = '<a href="'.$post_url.'" target="_blank">'.$row['heading'].'</a>';
	$nestedData[] = $row['bType'];
	$nestedData[] = Date("d M, Y", strtotime($row['created']));
	$nestedData[] = $edit_button.' | '.$delete_button;
	

	$data[] = $nestedData;
	$no++;

}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data
			);

echo json_encode($json_data);

?>