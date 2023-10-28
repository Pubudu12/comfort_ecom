<?php
include_once '../../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){


    // Delete Pack Image
    if(isset($_POST['deletePackThumb'])){

        $result = 0;
        $message = "Please fill the required fields";
        
        $post_id = trim($_POST['post_id']);

        $select = mysqli_query($localhost, "SELECT `thumb` FROM `blog_posts` WHERE `id` = '$post_id' ");
        if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_array($select);

            if(strlen(trim($fetch['thumb'])) > 0 ){
                $image_name = ROOT_PATH.BLOG_IMG_PATH.$fetch['thumb'];
                $dbOpertionsObj->deleteImage($image_name);
            }

            $DBResult = $dbOpertionsObj->update('blog_posts', array('thumb'=>0), array('id'=>$post_id));

            if($DBResult['result'] == 1){
                $result = 1;
                $message = "image has been removed";
            }
        }


        echo json_encode(array("result"=>$result,"message"=>$message));

    } // deletePackThumb


    if(isset($_POST['delete'])){

        if($_POST['delete'] == "delete_post"){

            $result = 0;
            $message = "Failed to delete the post";

            $post_id = $_POST['id'];

            
            // Delete Cover
            $select = mysqli_query($localhost, "SELECT `cover`, `thumb` FROM `blog_posts` WHERE `id` = '$post_id' ");
            $fetch = mysqli_fetch_array($select);
            if(strlen($fetch['cover']) > 0){
                $old_img = ROOT_PATH.BLOG_IMG_PATH.$fetch['cover'];
                $dbOpertionsObj->deleteImage($old_img);
            }

            if(strlen($fetch['thumb']) > 0){
                $old_img = ROOT_PATH.BLOG_IMG_PATH.$fetch['thumb'];
                $dbOpertionsObj->deleteImage($old_img);
            }


            $DBResult = $dbOpertionsObj->delete('blog_post_contents', array('post_id' => $post_id));

            $whereArr = array('id' => $post_id);
            $DBResult = $dbOpertionsObj->delete('blog_posts', $whereArr);

            if($DBResult['result'] == 1){
                $result = 1;
                $message = "Post has been deleted successfully";
            }

            echo json_encode(array('result' => $result, 'message'=>$message));

        }

    } // delete_cat

    
}// Post Method

?>