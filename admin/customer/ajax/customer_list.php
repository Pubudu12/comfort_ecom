<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$no = 1;
$columns = array( 
// datatable column index  => database column name
	0 => 'name',
	1 => 'email',
    2 => 'contact_no',
    3 => 'mobile_no',
	// 4 => 'permanent_address',
    4 => 'active',
    5 => 'id'
);

// getting total number records without any search
$sql = "SELECT * FROM `users` ";

$query = mysqli_query($localhost, $sql) or die("No Data");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT u.*, l.`active` FROM `users` AS u INNER JOIN `login` AS l ON l.`access_token` = u.`access_token` WHERE 1=1  ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( u.`name` LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR u.`email` LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.`contact_no` LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.`mobile_no` LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($localhost, $sql) or die("No Data");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($localhost, $sql) or die("No Data");

$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$active = "";
		if($row["active"] == 1){
			$active = '<i class="text-success fa fa-circle"></i>';
		}else{
			$active = '<i class="text-danger fa fa-circle"></i>';
		}

		$p_address = $row['p_door_no'].", ".$row['p_city'].", ".$row['p_state'].", ".$row['p_zip_code'];
		$t_address = $row['t_door_no'].", ".$row['t_city'].", ".$row['t_state'].", ".$row['t_zip_code'];

		$address = '
		<div class="dropdown">
			<button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Address
			<span class="caret"></span></button>
			<ul class="dropdown-menu">
			<li><a> <b> Permanent: </b> '.$p_address.' </a></li>
			<li><a> <b> Temporary: </b> '.$t_address.' </a></li>
			</ul>
		</div> ';

		$user_id = $row['id'];
		$select_total_orders = mysqli_query($localhost,"SELECT SUM(o.`total`) AS total, COUNT(uh.`id`) counts 
														FROM `user_std_order_history` AS uh 
														INNER JOIN `orders` o ON o.`order_no` = uh.`order_no` 
														   WHERE uh.`user_id`='$user_id' ");
		$fetch_total_orders = mysqli_fetch_array($select_total_orders);
		$total_orders = $fetch_total_orders['counts'];

		$delete_btn = '<button  class="btn btn-sm btn-danger fa fa-trash-o"
                        onclick="deleteItem(this)"
                        data-after-success=1
                        data-id="'.$user_id.'" 
                        data-refresh='.URL.'" 
                        data-url="'.URL.'customer/ajax/controller/deleteCustomerController.php" 
                        data-key="delete_product"></button>';

		$action = $delete_btn;
	
        $nestedData[] = '<a href="profile.php?id='.$user_id.'" target="_blank" >'.$active." ".$row["name"].'</a>';
        $nestedData[] = $row["email"];
		$nestedData[] = $row["contact_no"];
		$nestedData[] = $row["mobile_no"];
		// $nestedData[] = $address;
		$nestedData[] = number_format($fetch_total_orders['total'],2)." <small> ( ".$total_orders." )</small>";
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
