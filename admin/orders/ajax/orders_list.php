<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$order_status = $_POST['order_status'];
$payment_status = $_POST['payment_status'];


if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
}

$no = 1;
$columns = array( 
// datatable column index  => database column name
	0 => 'id',
        1 => 'order_no',
	2 => 'customer',
        3 => 'checkout_date',
	4 => 'total',
        5 => 'delivery_status',
        6 => 'id',
        7 => 'id',
        8 => 'refaund_amount'
);

// getting total number records without any search
$sql ="SELECT o.*,dd.`name` customer FROM `orders` AS o INNER JOIN `delivery_details` AS dd ON dd.`order_no` = o.`order_no` ";

if(isset($user_id)){
        $sql .= " INNER JOIN `user_std_order_history` AS uh ON uh.`user_id`='$user_id' AND uh.`order_no`=o.`order_no` ";
}

$sql .= " WHERE 1=1 ";

///order status
if($order_status != "all"){
        $sql .= " AND o.`delivery_status`='$order_status' ";
}

// payment status
if($payment_status == "paid"){
        $sql .= " AND o.`payment` != '0' ";
}else if($payment_status == "unpaid"){
        $sql .= " AND o.`payment` = '0' ";
}

// customer type filter
if (isset($_POST['customer_type'])) {
        $customer_type = $_POST['customer_type'];
        if($customer_type == "std"){
                $sql .= " AND o.`user_type`='std' ";
        }else if($customer_type == "guest"){
                $sql .= " AND o.`user_type`='guest' ";
        }else if($customer_type == "dealer"){
                $sql .= " AND o.`user_type`='dealer' ";
        }
}

$query = mysqli_query($localhost, $sql) or die("../payments.php: get GRN Invoices");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// query to the shwn data
$sql = $sql;


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( o.`id` LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR o.`order_no` LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR dd.`name` LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR o.`checkout_date` LIKE '".$requestData['search']['value']."%' ";

	$sql.=" OR o.`id` LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($localhost, $sql) or die("../payments.php: get GRN Invoices");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY `created` DESC ,". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($localhost, $sql) or die("../payments.php: get GRN Invoices");

$data = array();
$no = $requestData['start']+1;
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

        
	$nestedData=array(); 
        $order_no = $row['order_no'];
        $row_id = $row['id'];

        $delivery_status = $row['delivery_status'];

        if(strtolower($delivery_status) == "pending"){

                $delivery_status_select =       '<select onchange="changeStatus(this)">
                                                        <option value="'.$delivery_status.'" selected class="text-capitalize"> Pending </option>
                                                        <option value="processing">Processing</option>
                                                        <option value="delivered">Delivered</option>
                                                        <option value="cancelled">Cancelled</option>
                                                        <option value="returned">Returned</option>
                                                </select>';
        }else if(strtolower($delivery_status) == "processing"){

                $delivery_status_select =       '<select onchange="changeStatus(this)">
                                                        <option value="pending">Pending</option>
                                                        <option value="'.$delivery_status.'" selected class="text-capitalize"> Processing </option>
                                                        <option value="delivered">Delivered</option>
                                                        <option value="cancelled">Cancelled</option>
                                                        <option value="returned">Returned</option>
                                                </select>';

        }else if(strtolower($delivery_status) == "delivered"){

                $delivery_status_select =       '<select onchange="changeStatus(this)">
                                                        <option value="pending">Pending</option>
                                                        <option value="processing">Processing</option>
                                                        <option value="'.$delivery_status.'" selected class="text-capitalize"> Delivered </option>
                                                        <option value="cancelled">Cancelled</option>
                                                        <option value="returned">Returned</option>
                                                </select>';

        }else if(strtolower($delivery_status) == "cancelled"){

                $delivery_status_select =       '<select onchange="changeStatus(this)" disabled>
                                                        <option value="pending">Pending</option>
                                                        <option value="processing">Processing</option>
                                                        <option value="delivered">Delivered</option>
                                                        <option value="'.$delivery_status.'" selected class="text-capitalize"> Cancelled </option>
                                                        <option value="returned">Returned</option>
                                                </select>';

        }else if(strtolower($delivery_status) == "returned"){

                $delivery_status_select =       '<select onchange="changeStatus(this)">
                                                        <option value="pending">Pending</option>
                                                        <option value="processing">Processing</option>
                                                        <option value="delivered">Delivered</option>
                                                        <option value="cancelled">Cancelled</option>
                                                        <option value="'.$delivery_status.'" selected class="text-capitalize"> Returned </option>
                                                </select>';

        }else{
                $delivery_status_select =       '<select onchange="changeStatus(this)">
                                                        <option value="all">Nothing</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="processing">Processing</option>
                                                        <option value="delivered">Delivered</option>
                                                        <option value="cancelled">Cancelled</option>
                                                        <option value="returned">Returned</option>
                                                </select>';
        }


        if($row['payment'] == 0){
                $payment_status_select = '<select onchange="changePayment(this)">
                                                <option value="paid">Paid</option>
                                                <option value="unpaid" selected>Unpaid</option>
                                        </select>';
        }else{
                $payment_status_select = '<select onchange="changePayment(this)">
                                                <option value="paid" selected>Paid</option>
                                                <option value="unpaid">Unpaid</option>
                                        </select>';
        }

        $action_btn = "<button class='btn btn-danger btn-sm fa fa-trash-o' value='".$order_no."' onclick='deleteorder(this)' ></button>";

        $refaund_status = "<label>Payment Pending</label> ";
        if( ($row['payment'] > 0 ) &&  ($row['refaund_amount'] == 0 ) ){
                
                $payments = $row['payment'];

                $refaund_status = "<button class='btn btn-primary btn-sm fa fa-undo' value='".$row_id."' onclick='refund(this)' data-amount='".$payments."' > Refund</button>";

        }else if( $row['refaund_amount'] > 0  ){
                $refaund_status = "<label>Refunded<br>(".$row['refaund_amount']." LKR)</label> ";
        }
        $userType = 'Standard';
        if ($row['user_type'] == 'guest') {
             $userType = 'Guest';
        } 
        if ($row['user_type'] == 'dealer') {
                $userType = 'Dealer';
        } 
        
        $nestedData[] = $no;
        $nestedData[] = '<a href="'.URL.'orders/view_order.php?order_no='.$order_no.'" target="_blank" data-value="'.$row['id'].'" class="order_id_row" >'. $order_no .'</a>';
        $nestedData[] = $row['customer'];
        $nestedData[] = $userType;
        $nestedData[] = date("d M Y", strtotime($row['checkout_date']));
        $nestedData[] = '<a title="'.$row['payment_method'].'" href="#">'.number_format($row['total'],2).'</a>';
        $nestedData[] = $delivery_status_select;
        $nestedData[] = $payment_status_select;
        
        $nestedData[] = $action_btn;
        $nestedData[] = $refaund_status;
	
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
