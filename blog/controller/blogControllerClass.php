<?php
require_once ROOT_PATH.'blog/class/blogClass.php';

class blogControllerClass extends blogClass{

    public $localhost;

    public function __construct($localhost){
        $this->localhost = $localhost;
    } // Constrcut
    
    public function fetchAllBlogs($pageNo = 1)
    {
        $blogArray = array();
        $blogArray = $this->getBlogList($pageNo);
        return $blogArray;
    }

    public function fetchSingleBlog($blogId)
    {
        $blogArray = array();
        $blogArray = $this->getSingleBlogDetails($blogId);
        return $blogArray;
    }

    public function recentBlogPosts($limit){
        $blogArray = array();
        $blogArray = $this->getRecentBlogs($limit);
        return $blogArray;
    }

}
$blogControllerObj = new blogControllerClass($localhost);
?>