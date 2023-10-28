<?php 
include_once '../../../../app/global/url.php';
include_once ROOT_PATH.'app/global/global.php';
require_once ROOT_PATH.'/assets/vendor/validation/gump.class.php';

require_once ROOT_PATH.'assets/vendor/php/imageUploads.php';



if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_blog_post'])){

        $result = 0;
        $error = 0;
        $message = "Failed to create post";
        $redirectURL = null;

        $gump = new GUMP();
        $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'heading' => 'required',
            'post_date' => 'required',
            'category' => 'required',
        ));
        
        $gump->filter_rules(array(
            'heading' => 'trim',
            'post_date' => 'trim',
            'published_date' => 'trim',
            'category' => 'trim',
            'description' => 'trim',
        ));
        
        $validated_data = $gump->run($_POST);
        
        if($validated_data === false) {
            $error = $gump->get_errors_array(true);
            $message = "Please fill all the required fields";
        }else{

            $dataArray = array(
                'heading' => $validated_data['heading'],
                'post_date' => Date("Y-m-d", strtotime($validated_data['post_date'])),
                'published_date' => Date("Y-m-d", strtotime($validated_data['published_date'])),
                'category' => $validated_data['category'],
                'description' => $validated_data['description'],
                'post_type' => $validated_data['post_type'],
                'cover' => 0,
                'thumb' => 0,
                'hide' => 0,
                'exclusive' => 0,
            );

            $DBResult = $dbOpertionsObj->insert('blog_posts', $dataArray);

            if($DBResult['result'] == 1){

                $post_id = $DBResult['id'];
                $result = 1;
                $message = 'New post '.$validated_data['heading'].' has been created';

                $redirectURL = URL.'blog/post/update?id='.$post_id.'&tab=images';

                $auditArr = array(
                    'action' => 'Create Post',
                    'description' => $message
                );
                // $dbOpertionsObj->auditTrails($auditArr);

            }else{
                $error = $DBResult;
            }// db check result end
            

        } // Validation end 

        echo json_encode( array('result'=>$result, 'message'=>$message, 'error'=>$error, 'redirectURL'=>$redirectURL));


    }// isset


} // Post End 


if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['create_post'])){
        
        $result = 0;
        $message = "Please fill the fields";
        $redirectURL = '';

        $heading = mysqli_real_escape_string($localhost, trim($_POST['heading']));
        $category = $_POST['category'];
        $post_date = Date("Y-m-d", strtotime($_POST['post_date']));

        $post_type = (int)$_POST['post_type'];
        $published_date = Date("Y-m-d", strtotime($_POST['published_date']));

        $description = mysqli_real_escape_string($localhost, $_POST['description']);

        if(strlen($heading) > 0){

            $insertData = array(
                
            );
    
            $DBresult = $dbOpertionsObj->insertData('blog_posts', $insertData);
    
            if($DBresult['result'] == 1){
                $post_id = $DBresult['inserted_id'];
                $result = 1;
                $message = "New post has been created successfully";
                $redirectURL = URL.'admin/posts/update.php?id='.$post_id.'&tab=images';
            }else{
                $message = 'Failed to save the post';
            }
        }else{
            $message = "Please write someting";
        }

        echo json_encode(array('result' => $result, 'message'=>$message, 'redirectURL' => $redirectURL));

    } //isset

}// Post Method

?>