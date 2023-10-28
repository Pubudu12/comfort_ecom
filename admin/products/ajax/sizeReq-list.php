<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

/* Database connection start */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$no = 1;
$columns = array( 
// datatable column index  => database column name
    0 => 'id',
    1 => 'name',
    2 => 'name',
	3 => 'id',
    4 => 'id',
    5 => 'id',
    6 => 'id',
);

// getting total number records without any search
$sql =" SELECT * FROM `custom_size_requests` WHERE 1=1 ";

// echo $sql;

$query = mysqli_query($localhost, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

    $search = $requestData['search']['value'];

    $sql.=" AND ( `customer_name` LIKE '%$search%' )";
}

$query=mysqli_query($localhost, $sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY  `created` DESC, ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query=mysqli_query($localhost, $sql);

$data = array();
$no = $requestData['start']+1;

while( $row = mysqli_fetch_array($query) ) {
    $gump = new GUMP();
    $row = $gump->sanitize($row); // You don't have to sanitize, but it's safest to do so.
    
    $sanitized_query_data = $gump->run($row);
        $nestedData=array();
        $product_id = $sanitized_query_data['product_id'];
        $select = mysqli_query($localhost, "SELECT `name` 
                                            FROM `products` 
                                            WHERE `id` = '$product_id' ");
     
        $fetch = mysqli_fetch_array($select);

        $view = '<a href="'.URL.'products/viewReq.php?id='.$sanitized_query_data['id'].'" class="btn btn-primary fa fa-eye" target="_blank" title="View Request"></a>';
        
        $reqSize = '';
        if ($sanitized_query_data['requested_width'] != null) {
            $reqSize .= 'W-'.$sanitized_query_data['requested_width'];
        }
        if (isset($sanitized_query_data['requested_length'])) {
            $reqSize .= ' L-'.$sanitized_query_data['requested_length'];
        }
        if (isset($sanitized_query_data['requested_height'])) {
            $reqSize .= ' H-'.$sanitized_query_data['requested_height'];
        }
        
        $contact = '';
        if (isset($row['contact_no'])) {
            $contact = $row['contact_no'];
        }

        $nestedData[] = $no;
        $nestedData[] = $sanitized_query_data['customer_name'];
        $nestedData[] = $fetch['name'];
        $nestedData[] = $row['email'];
        $nestedData[] = $contact;
        $nestedData[] = date("F j, Y, g:i A",strtotime($row['created']));
        $nestedData[] = $reqSize;
        $nestedData[] = $view;
	
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
