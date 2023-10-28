<?php 
include_once '../../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){


    if(isset($_POST['update_post'])){

        $result = 0;
        $message = "Please fill the fields";
        $redirectURL = '';

        $post_id = trim($_POST['update_post']);

        $heading = mysqli_real_escape_string($localhost, trim($_POST['heading']));
        $category = $_POST['category'];
        $post_date = Date("Y-m-d", strtotime($_POST['post_date']));

        $published_date = Date("Y-m-d", strtotime($_POST['published_date']));

        $description = mysqli_real_escape_string($localhost, $_POST['description']);

        if(strlen($heading) > 0){

            $insertData = array(
                'heading' => $heading,
                'post_date' => $post_date,
                'published_date' => $published_date,
                'category' => $category,
                'description' => $description,
            );
    
            $DBresult = $dbOpertionsObj->update('blog_posts', $insertData, array('id' => $post_id));
    
            if($DBresult['result'] == 1){
                $result = 1;
                $message = "Post has been updated successfully";
                $redirectURL = URL.'blog/post/update?id='.$post_id.'&tab=images';
            }
        }else{
            $message = "Please write someting";
        }

        echo json_encode(array('result' => $result, 'message'=>$message, 'redirectURL' => $redirectURL));

    } //update_post'


    if(isset($_POST['update_post_thumb'])){

        $post_id = $_POST['update_post_thumb'];

        $result = 0;
        $message = "Please fill the required fields";
        $imageBox = 0;


        // Cover Image
        if(isset($_FILES['thumb_img']['name']) ){

            $error_image = 0;

            // Img Upload
            $uploadedImage = $_FILES['thumb_img'];
            $path = ROOT_PATH.BLOG_IMG_PATH;

            if(strlen($uploadedImage['name']) ) {

                $newWidth = 400;
                //$newHeight = 100; //Optional ---> If need fixed size
                $pass_parm = storeUploadedImage($path, $uploadedImage, $newWidth);
                if($pass_parm['error'] == 0){

                    $file_name = $pass_parm['filename'];
                    $error_image = 0;

                    // Insert Sub Cat Images
                    $DBResult = $dbOpertionsObj->update('blog_posts', array('thumb' => $file_name), array('id'=>$post_id));

                    if($DBResult['result'] == 1){
                        $result = 1;
                        $message = "Upload Done";

                        $imageURL = URL.BLOG_IMG_PATH.$file_name;

                        $imageBox = file_get_contents(ROOT_PATH.'blog/posts/container/pack_img_single_container.html');
                        $imageBox = str_replace("{{ IMAGE_URL }}", $imageURL, $imageBox);
                        $imageBox = str_replace("{{ IMAGE_ID }}", $post_id, $imageBox);

                    }

                }else{
                    $error_image = 1;
                    $message = $pass_parm['message'];
                    $cover_image_message = $message;
                }

            }

        }// if end for check strlen


        echo json_encode(array("result"=>$result,"message"=>$message, 'image_box' => $imageBox));


    } // update_post_thumb


    if(isset($_POST['update_post_cover'])){

        $post_id = $_POST['update_post_cover'];

        $result = 0;
        $message = "Please fill the required fields";
        $imageBox = 0;


        // Cover Image
        if(isset($_FILES['cover_img']['name']) ){

            $error_image = 0;

            // Img Upload
            $uploadedImage = $_FILES['cover_img'];
            $path = ROOT_PATH.BLOG_IMG_PATH;

            if(strlen($uploadedImage['name']) ) {

                $newWidth = 1500;
                //$newHeight = 100; //Optional ---> If need fixed size
                $pass_parm = storeUploadedImage($path, $uploadedImage, $newWidth);

                if($pass_parm['error'] == 0){

                    $file_name = $pass_parm['filename'];
                    $error_image = 0;

                    $select = mysqli_query($localhost, "SELECT `heading`,`cover` FROM `blog_posts` WHERE `id` = '$post_id' ");
                    $fetch = mysqli_fetch_array($select);
                    if(strlen($fetch['cover']) > 0){
                        $old_img = ROOT_PATH.BLOG_IMG_PATH.$fetch['cover'];
                        $dbOpertionsObj->deleteImage($old_img);
                    }

                    // Insert Sub Cat Images
                    $DBResult = $dbOpertionsObj->update('blog_posts', array('cover' => $file_name), array('id' => $post_id));

                    if($DBResult['result'] == 1){
                        $result = 1;
                        $message = "Upload Done";

                        $imageURL = URL.BLOG_IMG_PATH.$file_name;

                        $imageBox = file_get_contents(ROOT_PATH.'blog/posts/container/pack_cover_img.html');
                        $imageBox = str_replace("{{ IMAGE_URL }}", $imageURL, $imageBox);

                    }

                }else{
                    $error_image = 1;
                    $message = $pass_parm['message'];
                    $cover_image_message = $message;
                }

            }

        }// if end for check strlen


        echo json_encode(array("result"=>$result,"message"=>$message, 'image_box' => $imageBox));

    } //update_post_cover
    

}// Post Method

?>