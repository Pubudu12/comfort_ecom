<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

    class updateStock{

        public $result,$message,$title;
        public $db,$localhost;

        public function __construct($localhost,$db){
            $this->con = $localhost;
            $this->db = $db;
        } // constructor


        public function checkPriceExist($product_id, $size_id, $color_id){

            $select_price = mysqli_query($this->con, "SELECT `id` FROM `price` WHERE `product_id` = '$product_id' AND `size` = '$size_id' AND `color` = '$color_id' ");

            $count = mysqli_num_rows($select_price);
            $fetch_price = mysqli_fetch_array($select_price);

            if($count == 0){
                $price_availability = array('result' => 0, 'price_id' => 0 );
            }else{
                $price_availability = array('result' => 1, 'price_id' => $fetch_price['id'] );
            }

            return $price_availability;

        }//checkPriceExist

        public  function updateStockAfterPriceCheck($price_id, $qty){
            
            $select_stock = mysqli_query($this->con, "SELECT `id` FROM `stock` WHERE `price_id` = '$price_id' AND `warehouse_down` = 0 ORDER BY `id` DESC LIMIT 0, 1 ");
            if(mysqli_num_rows($select_stock) > 0){
                $fetch_stock = mysqli_fetch_array($select_stock);
                $stock_id = $fetch_stock['id'];

                $update_stock = mysqli_query($this->con, " UPDATE `stock` SET `qty` = qty+$qty WHERE `id` = '$stock_id' ");

            }else{

                // create Warehouse And Update the stock
                $select_warehouse = mysqli_query($this->con, "SELECT `id` FROM `warehouses` WHERE `active` = 1 ORDER BY `id` DESC LIMIT 0,1 ");
                if(mysqli_num_rows($select_warehouse) == 0){
                    $select_warehouse = mysqli_query($this->con, "SELECT `id` FROM `warehouses` ORDER BY `id` DESC LIMIT 0,1 ");
                }
                $fetch_warehouse = mysqli_fetch_array($select_warehouse);

                $warehouse_id = $fetch_warehouse['id'];

                //create Stock
                $update_stock = mysqli_query($this->con, "INSERT INTO `stock` (`price_id`, `warehouse`, `qty`, `min_alert`, `out_stock`, `warehouse_down`) VALUES('$price_id', '$warehouse_id', '$qty', '10', '0', '0') ");

            }

            if($update_stock){
                return true;
            }else{
                return false;
            }

        } //updateStockAfterPriceCheck();

        public function updateStockOnCancel($orderNo){

            $result = 0;
            $message = "Failed to cancel the order";
            

            // Check already Cancelled or not
            $select_order = mysqli_query($this->con, "SELECT * FROM `orders` WHERE `order_no` = '$orderNo' ");
            $fetch_order = mysqli_fetch_array($select_order);

            // check if it already cancelled or not
            if($fetch_order['delivery_status'] != "cancelled"){

                // Order not cancelld Already So process to cancell
                $select_order_items = mysqli_query($this->con, "SELECT * FROM `order_items` WHERE `order_no` = '$orderNo' ");
                $ordersArray = array();

                while($fetch_order_items = mysqli_fetch_array($select_order_items)){

                    
                    $product_id = $fetch_order_items['product_id'];
                    $size_id = $fetch_order_items['size'];
                    $color_id = $fetch_order_items['color'];
                    $qty = $fetch_order_items['qty'];

                    $checkPrice = $this->checkPriceExist($product_id, $size_id, $color_id);
                    
                    $check_success = 1;
                    if($checkPrice['result'] == 1){
                        // This price package availabel so update the stock there
                        array_push($ordersArray, array(
                            'product_id' => $product_id,
                            'size_id' => $size_id,
                            'color_id' => $color_id,
                            'qty' => $qty,
                            'price_id' => $checkPrice['price_id']
                        ));

                    }else{
                        // if this price package not available Please tell them to create the price package to cancell the order
                        $message = "Some of the products dosent have any price package to reverse the stock. Please create the price packages first";
                        $check_success = $check_success*0;
                    }
                    // check this item exits or not

                } // while end 

                
                if($check_success == 1){
                    
                    foreach ($ordersArray as $innerArr) {
                        $updateStock = $this->updateStockAfterPriceCheck($innerArr['price_id'], $innerArr['qty']);
                    }

                    if($updateStock){
                        $result = 1;
                        $message = "Order has been cancelled successfully";
                    }else{
                        mysqli_error($this->con);
                    }
                }

            }else{

                $result = 1;
                $message = "Already Cancelled";

            }

            


            return array('result' => $result, 'message' => $message);

        } //updateStockOnCancel

    } //updateStock

    $updateStockObj = new updateStock($localhost, $database);

?>
