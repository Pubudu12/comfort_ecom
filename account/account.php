
<?php 
require_once '../app/global/url.php'; 
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';

require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'/account/ajax/class/accountClass.php';

$checkuser = checkUserAccess();

    if( $checkuser['access'] == 0 ){ ?>
        
    <script>
       window.location = "<?php echo URL ?>login";
    </script>

    <?php
    // dont allow
   }else{ 

        $user_id = $_SESSION['user_id'];
        $select_user = mysqli_query($localhost,"SELECT * FROM `users` WHERE `id`='$user_id' ");
        $fetch_users = mysqli_fetch_array($select_user);
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'My Account | ';
        $meta_single_page_desc = '';
        $meta_arr = array(
            'title' => $meta_single_page_title,
            'description' => $meta_single_page_desc,
            'image' => URL.'assets/images/meta/home.jpg',
            
            'og:title' => $meta_single_page_title,
            'og:image' => URL.'assets/images/meta/home.jpg',
            'og:description' => $meta_single_page_desc,

            'twitter:image' => URL.'assets/images/meta/home.jpg',
            'twitter:title' => $meta_single_page_title,

        );
        require_once ROOT_PATH.'app/meta/meta_more_details.php'; 
        ?>

    <!-- CSS
        ============================================ -->

        <?php require_once ROOT_PATH.'imports/css.php' ?>

</head>
<body class="">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->

       <!-- breadcrumb-area start -->
       <div class="breadcrumb-area section-space--pt_80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title mobile-mt-responsive colour-brown"><b>My Account</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">My Account</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

    <div class="site-wrapper-reveal border-bottom">
        <!-- Blog Page Area Start -->
        <div class="blog-page-wrapper section-space--pt_40 mobile-inner-res section-space--pb_120">
            <div class="container">
                <div class="contact-us-info-area mt-30 section-space--mb_60">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="dashboard-left">
                                    <div class="block-content">
                                        <ul>
                                            <li class="active detail-padding link-effect"><i class="fa fa-user-circle mr-3"></i><a href="#">Account Info</a></li>

                                            <li class="detail-padding link-effect"><i class="fa fa-shopping-bag mr-3"></i><a href="<?php echo URL?>my_orders">My Orders</a></li>

                                            <li class="detail-padding link-effect"><i class="fa fa-edit mr-3"></i><a href="<?php echo URL?>edit_profile">Edit Account</a></li>
                                            
                                            <?php if ($_SESSION['user_type'] == 'std') {?>
                                                <li class="detail-padding link-effect"><i class="fa fa-check-circle mr-3"></i><a href="<?php echo URL?>verify">Verified Products</a></li>
                                            <?php }?>
                                            <li class="last detail-padding link-effect"><i class="fa fa-sign-out mr-3"></i><a href="<?php echo URL?>logout">Log Out</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 account-section-border">
                                <div class="dashboard-right">
                                    <div class="dashboard">
                                        <div class="page-title">
                                            <h2 class="h2-font-resize mobile-name-responsive t-res">Hello, <span class="h2-span"><?php echo $fetch_users['name'] ?>!</h2>
                                        </div>
                                        <div>
                                            <div class="row">
                                                <h2 class="col-md-6 h2-font-resize-2 mt-4 mobile-name-responsive t-res fm-size">Contact Information</h2>
                                                <a href="<?php echo URL?>edit_profile" class="col-md-6 text-right mt-4">edit</a>
                                            </div>
                                            <hr>
                                            <div class="billing-info-wrap mr-100">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info mb-25">
                                                            <label> Email </label>
                                                            <input type="text" id="billing-form-name" disabled value="<?php echo $fetch_users['email'] ?>" placeholder="Name" name="billing-form-name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info mb-25">
                                                            <label> Contact Number </label>
                                                            <input type="text" id="billing-form-name" disabled value="<?php echo $fetch_users['contact_no']?>" name="billing-form-name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <h2 class="h2-font-resize-2 mt-4">Address</h2>
                                            </div>
                                            <hr>
                                            <div class="billing-info-wrap mr-100">
                                                <div class="row">
                                                    <div class="col-6">
                                                        Temporary Address
                                                        <div class="billing-info mt-25 mb-25">
                                                            <input type="text" id="billing-form-name" disabled value="<?php 
                                                                echo $fetch_users['t_door_no'].', '.$fetch_users['t_city'].', '.$fetch_users['t_state'].', '.$fetch_users['t_zip_code'];
                                                                ?>"  placeholder="Name" name="billing-form-name">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        Permanent Address
                                                        <div class="billing-info mt-25 mb-25">
                                                            <input type="text" id="billing-form-name" disabled name="billing-form-name" value=" <?php 
                                                                echo $fetch_users['p_door_no'].', '.$fetch_users['p_city'].', '.$fetch_users['p_state'].', '.$fetch_users['p_zip_code'];
                                                                ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Page Area End -->

    </div>
    <!--====================  footer area ====================-->
    <?php require_once ROOT_PATH.'imports/footer.php' ?>
    <!--====================  End of footer area  ====================-->
    <!--====================  scroll top ====================-->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top icon-arrow-up"></i>
        <i class="arrow-bottom icon-arrow-up"></i>
    </a>
    <!--====================  End of scroll top  ====================-->
    <!-- JS
    ============================================ -->
    <?php require_once ROOT_PATH.'imports/js.php' ?>
</body>
</html>
<?php } ?>