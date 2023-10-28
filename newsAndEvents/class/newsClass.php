<?php 
require_once ROOT_PATH.'app/controllers/class/generalFunctionsClass.php';

class newsClass extends generalClasses{

    public $localhost;

    public function __construct($localhost){
        $this->localhost = $localhost;
    } // Constrcut

    public function pagination($query, $pageNo, $limit){
        $paginationArray = array();
        $paginationDetails = array();
        
        $select = mysqli_query($this->localhost, $query);
        $totalRows = mysqli_num_rows($select);

        $totalPages = ceil(($totalRows/$limit));

        $currentStart = ($pageNo-1)*$limit;
        $currentEnd = $currentStart+$limit;

        $showingProductsStart = ($currentStart+1);
        $showingProductsEnd = $currentEnd;
        if($totalRows == 0){
            $showingProductsStart = 0;
        }
        if($totalRows <= $currentEnd){
            $showingProductsEnd = $totalRows;
        }

        $paginationDetails = [
            'showingProductsStart' => $showingProductsStart,
            'showingProductsEnd' => $showingProductsEnd,
            'currentpage' => $pageNo,
            'totalRows' => $totalRows,
            'totalPages' => $totalPages,
        ];

        $query .= " LIMIT $currentStart, $currentEnd ";

        $paginationArray['query'] = $query;
        $paginationArray['details'] = $paginationDetails;

        return $paginationArray;

    } //pagination()

    public function fetchNewsClass($query){

        $newsArray = array();
        $select = mysqli_query($this->localhost, $query);
        $numofBlogs = mysqli_num_rows($select);
        $cover = '';
        if($numofBlogs > 0){
            while($fetch = mysqli_fetch_array($select)){
                if ($fetch['cover'] == '0') {
                    $cover = "https://via.placeholder.com/570x370/d3d3d3/FFFFFF/?text=Comfort World";
                    // $cover = $this->blogDummyImage();
                }else{
                    $cover = $this->checkImage(BLOG_IMG_FOLDER, $fetch['cover']);
                }

                $imageSize = 'height: 350px; width: 500px;';
                $width = 500;
                // $height = rand(300,500);
                $height = 300;
                $imageSize = 'height: '.$height.'px; width: '.$width.'px;';

                $tempArray = array(
                    'id' => $fetch['id'],
                    'heading' => $fetch['heading'],
                    'category' => $fetch['categoryname'],
                    'cover' => $cover,
                    'imageSize'=>$imageSize,
                    'published_date' => $fetch['post_date'],
                    'url_query' => URL.'news_detail?q='.$fetch['id'].'&'.urlencode(strtolower(trim($fetch['heading']))),
                );
                array_push($newsArray, $tempArray);
            }// WHile end 
        } // Row num end
        return array('count'=>$numofBlogs, 'newsArray' => $newsArray);
    } //fetchNewsClass


    public function getNewsList($pageNo,$limit){

        $select_query = "SELECT  bp.`id`, bp.`heading`, bp.`post_date`,
                        bp.`category`, bp.`cover`,bp.`thumb`, bc.`name` categoryname
                        FROM `blog_posts` bp
                        INNER JOIN `blog_categories` bc ON bc.`id` = bp.`category` 
                        WHERE bp.`hide` = '0' AND (bp.`post_type`='3' OR bp.`post_type`='4') AND bc.`type`='news' ";

        if($limit != 0){
            // $select_query .= " LIMIT 0, $limit ";
        }

        $paginationArray = $this->pagination($select_query, $pageNo, $limit = 24);

        $select_query = $paginationArray['query'];

        $blogArray = $this->fetchNewsClass($select_query);
        // 'url_query' => 'q='.$fetch['id'].'&'.urlencode(strtolower(trim($fetch['name']))),
        $blogArray['pagination'] = $paginationArray['details'];

        return $blogArray;

    } //getNewsList


    public function fetchPostContents($blogId){
        $blogContentArr = array();

        $select = mysqli_query($this->localhost,"SELECT * FROM `blog_post_contents` WHERE `post_id` = '$blogId' AND `type`='news' ");

        $fetch = mysqli_fetch_array($select);
        $blogContentArr = [
            'id'=>$fetch['id'],
            'content'=>$fetch['content']
        ];
        return $blogContentArr;
    }//fetchPostContents

    public function fetchPostTags($blogId){
        $blogTagsArr = array();

        $select = mysqli_query($this->localhost,"SELECT bpt.*, tag.`name` tagName,tag.`id` tagId
                    FROM `blog_post_tags` AS bpt
                    INNER JOIN `blog_tags` AS tag ON tag.`id` = bpt.`tag_id`
                    WHERE bpt.`post_id` = '$blogId' AND bpt.`type` = 'news' AND tag.`type`='news' ");

        while($fetch = mysqli_fetch_array($select)){
            array_push($blogTagsArr,array(
                'id'=>$fetch['id'],
                'tag_id'=>$fetch['tagId'],
                'tag_name'=>$fetch['tagName'],
            ));
        }
        return $blogTagsArr;
    }//fetchPostTags

    // Single Blog Details
    public function getSingleNewsDetails(Int $newsId){

        $blogDetailsArray = array();

        $query = "  SELECT p.*, cat.`name` categoryName
                    FROM `blog_posts` AS p
                    INNER JOIN `blog_categories` AS cat ON cat.`id` = p.`category`
                    WHERE p.`id` = '$newsId' AND (p.`post_type`='3' OR p.`post_type`='4') AND cat.`type`='news' ";

        $select = mysqli_query($this->localhost, $query);
        $fetch = mysqli_fetch_array($select);

        $postTags = $this->fetchPostTags($newsId);
        $postContents = $this->fetchPostContents($newsId);
        $cover = '';
        if ($fetch['cover'] == null ) {
            $cover = "https://via.placeholder.com/870x500/d3d3d3/FFFFFF/?text=Comfort World";
            // $cover = $this->blogDummyImage();
        }else{
            $cover = $this->checkImage(BLOG_IMG_FOLDER, $fetch['cover']);
        }

        $blogDetailsArray['heading'] = $fetch['heading'];
        $blogDetailsArray['description'] = $fetch['description'];    
        $blogDetailsArray['published_date'] = $fetch['post_date'];
        $blogDetailsArray['categoryName'] = $fetch['categoryName'];
        $blogDetailsArray['cover'] = $cover;
        

        if(count($postTags) != 0){
            $blogDetailsArray['tags'] = $postTags;
        }

        if(count($postContents) != 0){
            $blogDetailsArray['content'] = $postContents['content'];
        }

        return $blogDetailsArray;
    } //getSingleNewsDetails

    public function getRecentPosts($limit){
        $recentPosts = array();

        $select = mysqli_query($this->localhost,"SELECT *
                                                FROM `blog_posts` 
                                                WHERE `hide` = '0' AND (`post_type`='3' OR `post_type`='4') ORDER BY `post_date` DESC LIMIT $limit ");
        $control = 1;
        $class = 'col-lg-4';
        while($fetch = mysqli_fetch_array($select)){
            if ($fetch['cover'] != null) {
                $image = ADMIN_UPLOADS_URL.BLOG_IMG_FOLDER.$fetch['cover'];
            }
            
            switch ($control) {
                case 1:
                    $class = 'col-lg-8';
                    break;
                case 2:
                    $class = 'col-lg-4';
                    break;
                case 3:
                    $class = 'col-lg-4';
                    break;
                case 4:
                    $class = 'col-lg-8';
                    break;
                default:
                    $class = 'col-lg-8';
                    break;
            }
            array_push($recentPosts,array(
                'id'=> $fetch['id'],
                'heading'=> $fetch['heading'],
                'published_date'=> $fetch['post_date'],
                'cover'=> $image,
                'url_query' => URL.'news_detail?q='.$fetch['id'].'&'.urlencode(strtolower(trim($fetch['heading']))),
                // 'class' => $class
            ));
            $control++;
        }
        return $recentPosts;
    }

    public function getRecentPostsForNewsSingle($newsId){
        $recentPosts = array();

        $select = mysqli_query($this->localhost,"SELECT *
                                                FROM `blog_posts` 
                                                WHERE `hide` = '0' AND (`post_type`='3' OR `post_type`='4') AND `id` != '$newsId'
                                                ORDER BY `post_date` DESC LIMIT 4 ");
        $control = 1;
        $class = 'col-lg-4';
        while($fetch = mysqli_fetch_array($select)){
            if ($fetch['cover'] != null) {
                $image = ADMIN_UPLOADS_URL.BLOG_IMG_FOLDER.$fetch['cover'];
            }
            
            array_push($recentPosts,array(
                'id'=> $fetch['id'],
                'heading'=> $fetch['heading'],
                'published_date'=> $fetch['post_date'],
                'cover'=> $image,
                'url_query' => URL.'news_detail?q='.$fetch['id'].'&'.urlencode(strtolower(trim($fetch['heading']))),
                'class' => $class
            ));
            $control++;
        }
        return $recentPosts;
    }
}
?>