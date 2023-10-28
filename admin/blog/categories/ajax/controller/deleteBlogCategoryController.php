<?php 
include_once '../../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete_blog_category'){

            $result = 0;
            $message = "Failed to delete the the blog category";
            $error = 0;

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            $catg_id = (int)$_POST['id'];

            $select_catg = mysqli_query($localhost, "SELECT `name` FROM `blog_categories` WHERE `id` = '$catg_id' ");
            $fetch_catg = mysqli_fetch_array($select_catg);
            $name = $fetch_catg['name'];


            $count = $dbOpertionsObj->count('blog_posts', array('category'=>$catg_id));
            if($count != 0){
                $resultArray['message'] = "This category have posts";
                echo json_encode($resultArray);
                Exit(403);
            }

            // Delete from category
            $DBResult = $dbOpertionsObj->delete('blog_categories', array('id'=>$catg_id));

            if ($DBResult['result'] == 1) {
                $result = 1;
                $message = "Blog category ". $name ." has been deleted successfully !";

                $auditArray = array(
                    'action' => 'delete Blog Category',
                    'description' =>$message
                    );
            } else {
                $result = 0;
                $message = "Sorry! Failed to delete the Blog Category";
                $error = $DBResult;
            }

            $resultArray = array(
                'result' => $result,
                'message' => $message,
                'error' => $error,
            );

            echo json_encode($resultArray);
        }
    } // Isset Delete



} // Post End 