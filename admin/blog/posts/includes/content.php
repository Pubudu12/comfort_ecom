
<div class="col-12">
<br><br>

    <div class="col-12" id="editorjs"> </div>

    <div class="col-12 text-center">
        <button class="btn btn-success btn-block saveButton" 
            id="editorSaveButton" 
            data-url="<?php echo URL ?>blog/posts/ajax/controller/viewPostController.php" 
            data-key="blog_content" 
            data-id="<?php echo $post_id ?>"> Save 
        </button>

        <input type="hidden" 
                id="load_editor_data"
                data-url="<?php echo URL.'blog/posts/ajax/controller/viewPostController.php' ?>"
                data-load_key='load_blog_content'
                data-id="<?php echo $post_id ?>" >

    </div>

</div>
