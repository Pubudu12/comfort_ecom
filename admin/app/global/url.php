<?php 
    require_once 'config.php';
    define('PROTOCOL', (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://');
    $G_parts = explode('/', $_SERVER['REQUEST_URI']);
    
    $G_global_url = $_SERVER['SERVER_NAME'].'/';
    $documentRoot = $_SERVER['DOCUMENT_ROOT'].'/';
    if (DOMAIN_START_PATH != 0) {
        
        for ($pathNo=1; $pathNo <= DOMAIN_START_PATH; $pathNo++) { 
            $G_global_url .= $G_parts[$pathNo].'/';
            $documentRoot .= $G_parts[$pathNo].'/';
        }
    }
    $G_global_url = PROTOCOL.$G_global_url;
    
    Define("URL", $G_global_url);
    define('ROOT_PATH', $documentRoot);

    function redirect($url, $permanent = false) 
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        Exit();
    }
?>