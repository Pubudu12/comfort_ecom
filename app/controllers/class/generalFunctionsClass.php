<?php 

class generalClasses{

    public function checkImage($folder, $image){

        $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=Comfort World";
        if(file_exists(ADMIN_UPLOADS_PATH.$folder.$image) && (strlen($image) > 0) ){
            $thumbnail_image = ADMIN_UPLOADS_URL.$folder.$image;
        }

        return $thumbnail_image;

    }

    public function categoryDummyImage(){
        return $thumbnail_image = "https://via.placeholder.com/200x250/d3d3d3/FFFFFF/?text=Comfort World";
    } //categoryDummyImage

    public function productDummyImage(){
        return $thumbnail_image = "https://via.placeholder.com/548x550/d3d3d3/FFFFFF/?text=Comfort World";
    } //categoryDummyImage

    public function blogDummyImage(){
        return $thumbnail_image = "https://via.placeholder.com/548x550/d3d3d3/FFFFFF/?text=Comfort World";
    } //categoryDummyImage

    public function newsDummyImage(){
        return $thumbnail_image = "https://via.placeholder.com/548x550/d3d3d3/FFFFFF/?text=Comfort World";
    } //categoryDummyImage


    public function urlEncode($urlString){
        return urlencode(strtolower(trim($urlString)));
    }

} //generalClasses


?>