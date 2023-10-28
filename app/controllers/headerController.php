<?php
require_once ROOT_PATH.'app/controllers/class/productsClass.php';

class headerClass extends productClass{

    public $localhost;

    public function __construct($localhost){
        $this->localhost = $localhost;
    } // Constrcut


    public function getFullListMenu(){

        $products = 1;
        $startLevel = 1;
        $maxLevel = 3;
        $imgTypeArray = array('thumb'=>1); //array('thumb'=>1, 'default' => 3, 'cover' => 1)
        return $this->menuListByCode(0, $startLevel, $maxLevel, $products, '', $imgTypeArray);

    } //getDoorHardwareMenu
    
    public function metaBlock($metaDataArray){

        $title = $metaDataArray['title'] . ' Shop - Ultimate online wholesale market destination | eCommerce';
        $description = $metaDataArray['desc']. ' Shop - Ultimate online wholesale market destination | eCommerce';
        $image = $metaDataArray['img'];
        $page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $metaHtmlSec = file_get_contents(ROOT_PATH.'app/meta/meta.html');

        // Meta favicon
        $metaHtmlSec = str_replace('{{ apple-touch-ico }}', URL.'assets/images/meta/favicon/apple-touch-icon.png', $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ icon_32 }}', URL.'assets/images/meta/favicon/favicon-32x32.png', $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ icon_16 }}', URL.'assets/images/meta/favicon/favicon-16x16.png', $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ manifest }}', URL.'assets/images/meta/favicon/site.webmanifest', $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ copyright }}', Date("Y"), $metaHtmlSec);
        

        $metaHtmlSec = str_replace('{{ TITLE }}', $title, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ DESC }}', $description, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ IMAGE }}', $image, $metaHtmlSec);
        
        // OG
        $metaHtmlSec = str_replace('{{ OG:TITLE }}', $title, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ OG:DESC }}', $description, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ OG:IMAGE }}', $image, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ OG:URL }}', $page_url, $metaHtmlSec);

        // Twitter
        $metaHtmlSec = str_replace('{{ TWITTER:TITLE }}', $title, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ TWITTER:DESC }}', $description, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ TWITTER:IMAGE }}', $image, $metaHtmlSec);
        $metaHtmlSec = str_replace('{{ TWITTER:URL }}', $page_url, $metaHtmlSec);

        echo $metaHtmlSec;

    } //metaBlock


} //headerClass

$headerClassOBJ = new headerClass($localhost);
$menuFullListArray = $headerClassOBJ->getFullListMenu();
?>