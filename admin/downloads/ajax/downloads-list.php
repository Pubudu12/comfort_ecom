<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
/* Database connection start */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$no = 1;
$columns = array( 
// datatable column index  => database column name
    0 => 'id',
    1 => 'file',
    2 => 'image',
    3 => 'description',
    4 => 'created',
    5 => 'id'
    
);

$sql =" SELECT * FROM  `downloads` ";

$query = mysqli_query($localhost, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

    $search = $requestData['search']['value'];

	$sql.=" OR ( `name` LIKE '%$search%' ";

	$sql.=" OR `id` LIKE '%$search%' )";
}

$query=mysqli_query($localhost, $sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$query=mysqli_query($localhost, $sql);

$data = array();
$no = $requestData['start']+1;

while( $row=mysqli_fetch_array($query) ) {

        

        $id = $row['id'];

        $downloadLink = URL.PRO_DOWNLOAD_PATH.$row['file_name'];
        $name = $row['name'].'.pdf';
        $edit_btn = '<a class="text-primary" href="'.$downloadLink.'" download="'.$name.'" ><i class="fa fa-download"></i></a>';

        $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=".CLIENT_NAME;
        if(file_exists(ROOT_PATH.PRO_DOWNLOAD_PATH.$row['image']) && (strlen($row['image']) > 0) ){
            $thumbnail_image = URL.PRO_DOWNLOAD_PATH.$row['image'];
        }
        $thumbnail_image = '<img src="'.$thumbnail_image.'" class="product_img w-20">';

        $delete_btn = '<a  class="text-danger fa fa-trash-o"
                        href="#"
                        onclick="deleteItem(this)"
                        data-after-success=1
                        data-id="'.$id.'" 
                        data-refresh='.URL.'" 
                        data-url="'.URL.'downloads/ajax/controller/deleteDownloadsController.php" 
                        data-key="delete_download"></a>';

        $action_btn = $edit_btn.' | '.$delete_btn;

        $nestedData=array();
        $nestedData[] = $row['name'];
        $nestedData[] = $row['description'];
        $nestedData[] = $thumbnail_image;
        $nestedData[] = Date("d M, Y", strtotime($row['created']));
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
