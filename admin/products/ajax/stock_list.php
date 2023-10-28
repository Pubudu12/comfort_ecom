<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
/* Database connection start */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$product_id = 0;
if(isset($_POST['product_id'])){
    $product_id = (int)$_POST['product_id'];
}


$no = 1;
$columns = array( 
// datatable column index  => database column name
    0 => 'id',
    1 => 'id',
    2 => 'actual_price',
    3 => 'discount',
    4 => 'sale_price',
    5 => 'sale_price',
    6 => 'id'
    
);

$sql =" SELECT p.*,s.`name` sname FROM  `price` p 
        INNER JOIN `sizes` s ON s.`id` = p.`size_id`
        WHERE p.`product_id` = '$product_id' ";

$query = mysqli_query($localhost, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

    $search = $requestData['search']['value'];

	$sql.=" OR ( `actual_price` LIKE '%$search%' ";

	$sql.=" OR `id` LIKE '%$search%' )";
}

$query=mysqli_query($localhost, $sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$query=mysqli_query($localhost, $sql);

$data = array();
$no = $requestData['start']+1;

while( $row=mysqli_fetch_array($query) ) {

        

        $price_id = $row['id'];

        $stock = 0;
        $select_stock = mysqli_query($localhost, "SELECT SUM(`qty`) stock FROM `stock` WHERE `price_id` = '$price_id'  ");
        if(mysqli_num_rows($select_stock) > 0){
            $fetch_stock = mysqli_fetch_array($select_stock);
            $stock = $fetch_stock['stock'];
        }


        $stock_btn = '<a class="text-primary" href="#" onclick="editStockQty('.$price_id.')" > Stock ('.$stock.') </a>';

        $edit_btn = '<a class="btn btn-sm text-primary" href="#" onclick="editPrice('.$price_id.')" ><i class="fa fa-edit"></i></a>';

        $delete_btn = '<button class="btn btn-sm text-danger fa fa-trash-o"
                        onclick="deleteItem(this)"
                        data-after-success=1
                        data-id="'.$price_id.'" 
                        data-refresh='.URL.'" 
                        data-url="'.URL.'products/ajax/controller/deleteProductController.php" 
                        data-key="delete_product_price"></button>';
        
        $action_btn = $edit_btn.' | '.$delete_btn;

        $nestedData=array();
        $nestedData[] = $row['sname'];
        $nestedData[] = number_format($row['actual_price'],2);
        $nestedData[] = number_format($row['discount']).$row['discount_type'];
        $nestedData[] = number_format($row['sale_price'], 2);
        $nestedData[] = number_format($row['dealer_price'], 2);
        // $nestedData[] = $stock_btn;
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
