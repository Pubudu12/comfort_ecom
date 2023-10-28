<?php 

require_once ROOT_PATH.'app/controllers/class/generalFunctionsClass.php';
require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';
class galleryControllerClass  extends generalClasses{

    public $localhost;

    public function __construct($localhost){
        $this->localhost = $localhost;
    } // Constrcut

    public function fetchGalleryItems(){
        $galleryArray = array();
        $count = 0;
       
        $select = mysqli_query($this->localhost, "SELECT gl.`category` ,gc.`name`
                                                  FROM `gallery` AS gl 
                                                  INNER JOIN `gallery_category` AS gc ON gl.`category`= gc.`id`
                                                  GROUP BY gl.`category` ");
        if (mysqli_num_rows($select) > 0) {
            while($fetch = mysqli_fetch_array($select)){
                $galleryArray[$count] = array();
                $galleryArray[$count]['details'] = array();
                $c_id = $fetch['category'];
                
                $selectItems = mysqli_query($this->localhost, " SELECT gl.`gallery_media`,gl.`caption`,gl.`type`
                                                                FROM `gallery` AS gl 
                                                                WHERE gl.`category`='$c_id' ");
              
                array_push($galleryArray[$count],array(
                    'category'=>$fetch['name'],
                ));

                while ($fetchItems = mysqli_fetch_array($selectItems)) {
                    $media = $fetchItems['gallery_media'];
                    if ($fetchItems['type'] == 'image') {
                        
                        $media = "https://via.placeholder.com/48x33/d3d3d3/FFFFFF/?text=Comfort World";
                        if(file_exists(ADMIN_UPLOADS_PATH.GALLERY_IMG_FOLDER.$fetchItems['gallery_media']) && (strlen($fetchItems['gallery_media']) > 0) ){
                            $media = ADMIN_UPLOADS_URL.GALLERY_IMG_FOLDER.$fetchItems['gallery_media'];
                        }
                    }
                    array_push($galleryArray[$count]['details'],array(
                        'type'=>$fetchItems['type'],
                        'media'=>$media,
                        'caption'=>$fetchItems['caption'],
                    ));
                }
                $count++;
            }
        }
        
        return $galleryArray;
    }
}
$galleryControllerObj = new galleryControllerClass($localhost);
?>