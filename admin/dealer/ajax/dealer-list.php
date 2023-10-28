<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$no = 1;
$columns = array( 
// datatable column index  => database column name
	0 => 'id',
	1 => 'username',
    2 => 'created',
    3 => 'id',
);

// getting total number records without any search
$sql = "SELECT * FROM `users` WHERE `user_type`='dealer' ";

$query = mysqli_query($localhost, $sql) or die("Sure No Data");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = $sql;

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( `username` LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR `created` LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($localhost, $sql) or die("No Data");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($localhost, $sql) or die("No Data");

$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$user_id = $row['id'];
		

		$delete_btn = '<button  class="btn btn-sm btn-danger fa fa-trash-o"
                        onclick="deleteItem(this)"
                        data-after-success=1
                        data-id="'.$user_id.'" 
                        data-refresh='.URL.'" 
                        data-url="'.URL.'dealer/ajax/controller/deleteDealerController.php" 
						data-key="delete_dealer"></button>';
						
		$change_pswd = '<a href="'.URL.'dealer/update_password.php?id='.$user_id.'" class="btn btn-inverse-warning btn-sm">Change Password</a>';

		$action = $change_pswd.$delete_btn;

        $nestedData[] = $no;
        $nestedData[] = $row["name"];
		$nestedData[] = date("d M Y", strtotime($row["created"]));
		$nestedData[] = $action;
        
	
		$data[] = $nestedData;
    
}




$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
