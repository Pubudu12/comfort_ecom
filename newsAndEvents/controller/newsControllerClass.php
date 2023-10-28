<?php
require_once ROOT_PATH.'newsAndEvents/class/newsClass.php';

class newsControllerClass extends newsClass{

    public $localhost;

    public function __construct($localhost){
        $this->localhost = $localhost;
    } // Constrcut
    
    public function fetchAllNews($pageNo = 1,$limit = null)
    {
        $newsArray = array();
        $newsArray = $this->getNewsList($pageNo,$limit);
        return $newsArray;
    }

    public function fetchSingleNews($newsId)
    {
        $newsArray = array();
        $newsArray = $this->getSingleNewsDetails($newsId);
        return $newsArray;
    }

    public function recentPosts($limit){
        $recentPostArray = array();
        $recentPostArray = $this->getRecentPosts($limit);
        return $recentPostArray;
    }

    public function recentPostsInNewsSingle($newsId){
        $recentPostArray = array();
        $recentPostArray = $this->getRecentPostsForNewsSingle($newsId);
        return $recentPostArray;
    }

}
$newsControllerObj = new newsControllerClass($localhost);
?>