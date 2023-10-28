<?php 

class productClass{

    public $localhost, $dbOpertionsObj;

    function __construct($localhost, $dbOpertionsObj)
    {
        $this->localhost = $localhost;
        $this->dbOpertionsObj = $dbOpertionsObj;
    }

    public function deleteProDownloads(Int $productId){

        $return = [
            'result' => 0,
            'message' => 'Sorry! Failed to delete the downloads',
        ];

        $select = mysqli_query($this->localhost, "SELECT `file_name` FROM `pro_downloads` WHERE `product_id` = '$productId' ");
        if(mysqli_num_rows($select) > 0){

            while($fetch = mysqli_fetch_array($select)){
                $filePath = ROOT_PATH.PRO_DOWNLOAD_PATH.$fetch['file_name'];
    
                if(file_exists($filePath)){
                    unlink($filePath);
                }
        
                // Delete from product
                $DBResult = $this->dbOpertionsObj->delete('pro_downloads', array('product_id'=>$productId));
                
                if ($DBResult['result'] == 1) {
                    $return['result'] = 1;
                    $return['message'] = "File has been deleted successfully !";
                } else {
                    $return['error'] = $DBResult;
                }
    
            }

        }else{
            $return = [
                'result' => 1,
                'message' => 'No Downloads',
            ];
        }

        return $return;

    } //deleteProDownloads

    public function deleteProImages(Int $productId){

        $return = [
            'result' => 0,
            'message' => 'Sorry! Failed to delete the downloads',
        ];

        $select = mysqli_query($this->localhost, "SELECT `name` FROM `product_images` WHERE `product_id` = '$productId' ");
        if(mysqli_num_rows($select) > 0){
            while($fetch = mysqli_fetch_array($select)){

                $fullPath = ROOT_PATH.PRO_IMG_PATH.$fetch['name'];
                if(file_exists($fullPath)){
                    unlink($fullPath);
                }

                $DBResult = $this->dbOpertionsObj->delete('product_images', array('product_id' => $productId) );

                if($DBResult['result'] == 1){
                    $return['result'] = 1;
                    $return['message'] = "Package images has been removed";
                }else{
                    $return['error'] = $DBResult;
                }

            } // While end 
        }else{
            $return = [
                'result' => 1,
                'message' => 'No Images',
            ];
        } // If end 

        return $return;

    } // deleteProImages

    public function deleteProSections(Int $productId){
        $return = [
            'result' => 0,
            'message' => 'Sorry! Failed to delete the product',
        ];

        $DBResult = $this->dbOpertionsObj->delete('product_body', array('product_id'=>$productId));
        if ($DBResult['result'] == 1) {
            $return['result'] = 1;
            $return['message'] = "Product details has been deleted!";
        } else {
            $error = $DBResult;
        }

        return $return;

    } //deleteProSections()

    public function deleteSingleStock($stockId){

        $return = [
            'result' => 1,
            'message' => 'Stock has been deleted',
        ];

        $this->dbOpertionsObj->delete('stock', array('id'=>$stockId));

        return $return;

    } //deleteSingleStock

    public function deleteProSinglePrice($priceId){

        $return = [
            'result' => 1,
            'message' => 'Price has been deleted',
        ];

        $select = mysqli_query($this->localhost, "SELECT * FROM `price` WHERE `id` = '$priceId' ");
        if(mysqli_num_rows($select) > 0){
            while($fetch = mysqli_fetch_array($select)){
                $priceId = $fetch['id'];
                // Delete Stock
                $this->dbOpertionsObj->delete('stock', array('price_id'=>$priceId));
            }

            $this->dbOpertionsObj->delete('price', array('id'=>$priceId));
        }

        return $return;

    } //deleteProSinglePrice()

    public function deleteProSingleDiscount($discountId){

        $return = [
            'result' => 1,
            'message' => 'Discount has been deleted',
        ];

        $select = mysqli_query($this->localhost, "SELECT * FROM `pro_discounts` WHERE `id` = '$discountId' ");
        if(mysqli_num_rows($select) > 0){

            $this->dbOpertionsObj->delete('pro_discounts', array('id'=>$discountId));
        }

        return $return;

    } //deleteProSingleDiscount

    public function deleteProPrices(Int $productId){

        $return = [
            'result' => 1,
            'message' => 'Price has been deleted',
        ];

        $select = mysqli_query($this->localhost, "SELECT * FROM `price` WHERE `product_id` = '$productId' ");
        if(mysqli_num_rows($select) > 0){
            while($fetch = mysqli_fetch_array($select)){
                $priceId = $fetch['id'];
                // Delete Stock
                $this->dbOpertionsObj->delete('stock', array('price_id'=>$priceId));
            }

            $this->dbOpertionsObj->delete('price', array('product_id'=>$productId));
        }

        return $return;
    } //deleteProPrices()

    public function deleteProduct(Int $productId){

        $return = [
            'result' => 0,
            'message' => 'Sorry! Failed to delete the product',
        ];

        $select = mysqli_query($this->localhost, "SELECT `name` FROM `products` WHERE `id` = '$productId' ");
        $fetch = mysqli_fetch_array($select);
        $name = $fetch['name'];

        $deleteDownloads = $this->deleteProDownloads($productId);
        if($deleteDownloads['result'] != 1){
            // Failed
            return $deleteDownloads;
        }

        $deleteProImages = $this->deleteProImages($productId);
        if($deleteProImages['result'] != 1){
            // Failed
            return $deleteProImages;
        }

        $deleteProSections = $this->deleteProSections($productId);
        if($deleteProSections['result'] != 1){
            // Failed
            return $deleteProSections;
        }

        $deleteProPrices = $this->deleteProPrices($productId);
        if($deleteProPrices['result'] != 1){
            // Failed
            return $deleteProPrices;
        }


        // Delete products
        $DBResult = $this->dbOpertionsObj->delete('products', array('id'=>$productId));

        if ($DBResult['result'] == 1) {
            $return['result'] = 1;
            $return['message'] = "Product ".$name." has been deleted successfully !";
        } else {
            $return['error'] = $DBResult;
        }

        return $return;

    } //deleteProduct

} //productClass

$productClassObj = new productClass($localhost, $dbOpertionsObj);

?>