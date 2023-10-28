<?php 
    require_once '../app/global/url.php';
    include_once ROOT_PATH.'/app/global/sessions.php';
    include_once ROOT_PATH.'/app/global/Gvariables.php';
	include_once ROOT_PATH.'/db/db.php';
	
    require_once ROOT_PATH.'app/controllers/headerController.php';
    require_once ROOT_PATH.'blog/controller/blogControllerClass.php';

    $blogId = 0;
    if(isset($_GET['q'])){
        if(is_numeric($_GET['q'])){
            $blogId = trim(mysqli_real_escape_string($localhost, $_GET['q']));
        }
    }

    function reverse_mysqli_real_escape_string($str) {
        return strtr($str, [
            '\0'   => "\x00",
            '\n'   => "\n",
            '\r'   => "\r",
            '\\\\' => "\\",
            "\'"   => "'",
            '\"'   => '"',
            '\Z' => "\x1a"
        ]);
    }

    $blogDetailsArray = $blogControllerObj->fetchSingleBlog($blogId);

    $blogContentArray = '';
    if ( isset($blogDetailsArray['content'])) {
    $blogContentArray = reverse_mysqli_real_escape_string($blogDetailsArray['content']);

    $blogContentArray = preg_replace_callback(
        '!s:(\d+):"(.*?)";!', 
        function($m) { 
            return 's:'.strlen($m[2]).':"'.$m[2].'";'; 
        }, 
        $blogContentArray);
    
    // var_dump(unserialize($blogContentArray));

    $blogContentArray = unserialize($blogContentArray);


    // echo $blogContentArray;
    }
?>