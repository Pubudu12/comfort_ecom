
<?php 
$selected_tag_id_array = array();
$selected_tag = mysqli_query($localhost, "SELECT * FROM `blog_post_tags` WHERE `post_id` = '$post_id' ");
while($fetch_selected_tag = mysqli_fetch_array($selected_tag)){

    array_push($selected_tag_id_array, $fetch_selected_tag['tag_id']);
}

$contents = '';
$select_content = mysqli_query($localhost, "SELECT * FROM `blog_post_contents` WHERE `post_id` = '$post_id' ");
if(mysqli_num_rows($select_content) > 0){
    $fetch_content = mysqli_fetch_array($select_content);
    $contents = $fetch_content['content'];
}

$select_type = mysqli_query($localhost, "SELECT * FROM `blog_type` WHERE `id`='$blog_type' ");
$fetch_type = mysqli_fetch_array($select_type);
$type = $fetch_type['type'];

$category_arr = array();
$select = mysqli_query($localhost, "SELECT * FROM `blog_categories` WHERE `type`='$type' ");
while($fetch = mysqli_fetch_array($select)){
    array_push($category_arr, array(
        'id' => $fetch['id'],
        'name' => $fetch['name']
    ));
}


?>
<div class="col-12">
    <br><br>
    <form
        class="form"
        data-action-after=2
        data-redirect-url="pills-images-tab"
        method="POST"
        action="<?php echo URL ?>blog/posts/ajax/controller/updatePostController.php">
        <div class="row">

            <div class="form-group col-8">
                <label>Heading</label>
                <input type="text" class="form-control" value="<?php echo $fetch_post['heading'] ?>" name="heading" placeholder="Post Heading">
            </div>

            <div class="form-group col-2">
                <label>Post Type</label>
                <input type="text" class="form-control" readonly value="<?php echo $fetch_type['type'] ?>" name="" placeholder="Type">
            </div>

            <div class="form-group col-2">
                <label for="">Categories</label>
                <select name="category" id="category_list" class="form-control custom-select select2" required="">
                    <option value="0" selected disabled>Select Category</option>
                        <?php foreach ($category_arr as $key => $value) { ?>
                            <option value="<?php echo $value['id'] ?>" <?php echo comboboxSelected($value['id'], $fetch_type['id']) ?>> <?php echo $value['name'] ?> </option>
                        <?php } ?>
                </select>
            </div>

            <div class="form-group col-12">
                <label>Description</label>
                <textarea name="description" max-length="300" class="form-control" cols="30" rows="5" placeholder="Description"><?php echo $fetch_post['description'] ?></textarea>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="form-group col-4">
                        <div class="row">
                            <label for="" class="col-5">Published Date</label>
                            <input type="date" class="form-control col-7 datepicker" value="<?php echo Date("d-m-Y", strtotime($fetch_post['published_date'])) ?>" name="published_date" placeholder="Published date">
                        </div>
                    </div>
                    <div class="form-group col-4">
                        <div class="row">
                            <label for="" class="col-5">Post Date</label>
                            <input type="date" class="form-control datepicker col-7" value="<?php echo Date("d-m-Y", strtotime($fetch_post['post_date'])) ?>" name="post_date" placeholder="Post date"  required="">
                        </div>
                    </div>
                    <div class="col-4 form-group">
                        <input type="hidden" name="update_post" value="<?php echo $post_id ?>">
                        <button type="submit" class="btn btn-primary float-right submit_form_no_confirm" 
                                data-notify_type=2 
                                data-validate=0 > Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>