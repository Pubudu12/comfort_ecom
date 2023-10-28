<?php 
include_once '../../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){


    if(isset($_POST['key'])){
        if($_POST['key'] == "blog_content"){

            $result = 0;
            $message = 'Failed to update the content';
            $redirectURL = '';

            $post_id = $_POST['id'];
            $content = mysqli_real_escape_string($localhost, serialize($_POST['data']));
            
            $select_post = mysqli_query($localhost, "SELECT * FROM `blog_posts` WHERE `id` = '$post_id' ");
            $fetch_post = mysqli_fetch_array($select_post);
            $blog_type = $fetch_post['post_type'];

            $select_blog_type = mysqli_query($localhost, "SELECT `type` FROM `blog_type` WHERE `id` = '$blog_type' ");
            $fetch_blog_type = mysqli_fetch_array($select_blog_type);
            // $content = json_encode($_POST['data']);

            $dataarray = array(
                'content' => $content,
                'type'=> $fetch_blog_type['type'],
                'post_id' => $post_id,
            );

            // Check
            $select = mysqli_query($localhost, "SELECT `id` FROM `blog_post_contents` WHERE `post_id` = '$post_id' ");
            if( mysqli_num_rows($select) == 0){
                $DBresult = $dbOpertionsObj->insert('blog_post_contents', $dataarray);
            }else{
                $DBresult = $dbOpertionsObj->update('blog_post_contents', $dataarray, array('post_id'=>$post_id));
            }

            if($DBresult){
                $result = 1;
                $message = 'Content has been updated successfully';
                $redirectURL = '';
            }
            
            echo json_encode(array("result"=>$result,"message"=>$message, "redirectURL"=>$redirectURL, $DBresult));

        } //csr_content
    } // ISSET KEY

    if(isset($_POST['editor_loadKey'])){
        if($_POST['editor_loadKey'] == 'load_blog_content'){

            $id = $_POST['dataId'];

            $select = mysqli_query($localhost, "SELECT `content` FROM `blog_post_contents` WHERE `post_id` = '$id' ");
            
            if(mysqli_num_rows($select) > 0){

                $fetch = mysqli_fetch_array($select);

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
        
                $content = reverse_mysqli_real_escape_string($fetch['content']);

                $content = preg_replace_callback(
                    '!s:(\d+):"(.*?)";!', 
                    function($m) { 
                        return 's:'.strlen($m[2]).':"'.$m[2].'";'; 
                    }, 
                    $content);

                $content = unserialize($content);
                $content = $content['blocks'];

            }else{
                $content = array();
            }

            echo json_encode(array('data'=>$content));

        }
    }

    if (isset($_POST['fetchCategories'])) {
        $result = 0;
        $message = 'Failed to update the content';
        $redirectURL = '';

        $post_type = $_POST['post_type'];

        // Check
        $select = mysqli_query($localhost, "SELECT `type` FROM `blog_type` WHERE `id` = '$post_type' ");
        $fetch = mysqli_fetch_array($select);
        $type = $fetch['type'];
        $option = '<option value = "0" disabled selected>Select Category </option>';
     
        $categoryArray = array();
        $select_categories = mysqli_query($localhost, "SELECT `id`,`name` FROM `blog_categories` WHERE `type` = '$type' ");
        while($fetch_categories = mysqli_fetch_array($select_categories)){
             $option .= '<option value="'.$fetch_categories['id'].'"> '.$fetch_categories['name'].' </option>';
        }

        echo json_encode($option); 
    }
} // POST ISSET

?>