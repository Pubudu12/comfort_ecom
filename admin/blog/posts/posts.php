<?php 
include_once '../../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';

$checkArr = array(
    'page_level_code' => 2
);
require_once ROOT_PATH.'account/include/authViewPage.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once ROOT_PATH.'app/meta/meta.php';
    
    $meta_single_page_title = 'Blog Posts - ';
    $meta_single_page_desc = 'Blog Posts - ';
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
                                        <h3>Posts
                                            <!-- <small>News & Events</small> -->
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->

                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="col-md-12 card">
                            <div class="col-md-12 card-body"> 

                                <div class="row">

                                    <div class="col-xs-12 col-md-12 col-lg-12 text-right">
                                        <a href="<?php echo URL ?>blog/post/create" class="btn btn-secondary create-btn1"> Create Post</a>
                                        <br>&nbsp;
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <table class="dataTableCall" 
                                                id="products-list_table" 
                                                data-url='<?php echo URL ?>blog/posts/ajax/posts_list.php'
                                                onchange="postsListDatatable()">
                                            <thead>
                                                <tr>
                                                    <th id="sort">#</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Date</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->

                </div>

                <input type="hidden" id="dataTableRefresh" onclick="postsListDatatable()">

                <!-- footer start-->
            <?php include_once ROOT_PATH.'imports/footer.php'?>
                <!-- footer end-->
            </div>

        </div>
        <?php include_once ROOT_PATH.'imports/js.php'?>

        <script>
        function postsListDatatable(){

            var tableName = 'products-list_table';
            var actionUrl = $('#'+tableName).data('url');

            var catLevel = $("#category_level").val();        
            var postData = { 
                'categoryList': 'yes',
                'cat_level': catLevel
            };

            ajaxDataTableLoad(tableName, actionUrl, postData);

        } //categoryListDatatable

        postsListDatatable();
        </script>

    </body>
</html>