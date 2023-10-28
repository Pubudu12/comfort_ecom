<?php 
    require_once '../app/global/url.php';
    include_once ROOT_PATH.'/app/global/sessions.php';
    include_once ROOT_PATH.'/app/global/Gvariables.php';
	include_once ROOT_PATH.'/db/db.php';
	
    require_once ROOT_PATH.'app/controllers/headerController.php';
    require_once ROOT_PATH.'newsAndEvents/controller/newsControllerClass.php';

    $newsId = 0;
    if(isset($_GET['q'])){
        if(is_numeric($_GET['q'])){
            $newsId = trim(mysqli_real_escape_string($localhost, $_GET['q']));
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

    $newsDetailsArray = $newsControllerObj->fetchSingleNews($newsId);
    $recentPostArray = $newsControllerObj->recentPosts(4);

    $recentPostsInNewsSinglePage = $newsControllerObj->recentPostsInNewsSingle($newsId);
// print_r($newsDetailsArray['content']);
    $newsContentArray = '';
    if ( isset($newsDetailsArray['content'])) {
        $newsContentArray = reverse_mysqli_real_escape_string($newsDetailsArray['content']);

        $newsContentArray = preg_replace_callback(
            '!s:(\d+):"(.*?)";!', 
            function($m) { 
                return 's:'.strlen($m[2]).':"'.$m[2].'";'; 
            }, 
            $newsContentArray);

        $newsContentArray = unserialize($newsContentArray);
    } 
?>