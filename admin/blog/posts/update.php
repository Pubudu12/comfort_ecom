<?php
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';


$tab = "post";

if(isset($_GET['tab'])){
    $tab = trim($_GET['tab']);
}

switch ($tab) {
    case 'post':
        $tab_file = 'post.php';
        break;

    case 'images':
        $tab_file = 'images.php';
        break;

    case 'content':
        $tab_file = 'content.php';
        break;

    default:
        $tab_file = 'post.php';
        break;
}


$post_id = 0;
if(isset($_GET['id'])){
    $_GET['id'] = trim($_GET['id']);
    if(is_numeric($_GET['id'])){
        $post_id = $_GET['id'];
    }
}
$select_post = mysqli_query($localhost, "SELECT * FROM `blog_posts` WHERE `id` = '$post_id' ");
$fetch_post = mysqli_fetch_array($select_post);
$heading = $fetch_post['heading'];
$blog_type = $fetch_post['post_type'];

$select_blog_type = mysqli_query($localhost, "SELECT `type` FROM `blog_type` WHERE `id` = '$blog_type' ");
$fetch_blog_type = mysqli_fetch_array($select_blog_type);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Update Post - ';
    $meta_single_page_desc = 'Update Post - ';
    include_once ROOT_PATH.'app/meta/meta_more_details.php'; 
    
    include_once ROOT_PATH.'imports/css.php';
    ?>
</head>
<body>

    <!-- page-wrapper Start-->
    <div class="page-wrapper">

        <!-- Page Header Start-->
        <?php include_once ROOT_PATH.'imports/header.php'?>
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            <?php include_once ROOT_PATH.'imports/sidebar.php'?>

            <div class="page-body">

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3> <?php echo $heading ?>
                                        <small>Update Post</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-lg-12 text-right">
                                            <a href="<?php echo URL ?>blog/post" class="btn btn-primary"> <i class="fa fa-arrow-alt-circle-left"></i> Back</a>
                                        </div>
                                    </div>

                                    <br>
                                    
                                    <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">

                                        <li class="nav-item">
                                            <a class="nav-link <?php echo doactive("post", $tab) ?>" id="pills-post-tab" href="<?php echo URL ?>blog/post/update?id=<?php echo $post_id ?>">Post</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo doactive("images", $tab) ?>" id="pills-images-tab" href="<?php echo URL ?>blog/post/update?id=<?php echo $post_id ?>&tab=images">Images</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo doactive("content", $tab) ?>" id="pills-content-tab" href="<?php echo URL ?>blog/post/update?id=<?php echo $post_id ?>&tab=content">Content</a>
                                        </li>

                                    </ul>

                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active">
                                            <?php include_once ROOT_PATH.'blog/posts/includes/'.$tab_file ?>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- Card End -->
                        </div>

                    </div>
                </div>
                <!-- Container-fluid Ends-->

            </div>

            <!-- footer start-->
        <?php include_once ROOT_PATH.'imports/footer.php'?>
            <!-- footer end-->
        </div>

    </div>
    <?php include_once ROOT_PATH.'imports/js.php'?>
    <?php require_once ROOT_PATH.'imports/editor_js.php' ?> 
    <script src="<?php echo URL ?>assets/js/pages/post.js"></script>

    </body>
</html>
