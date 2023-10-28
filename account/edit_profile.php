
<?php 
require_once '../app/global/url.php'; 
include_once ROOT_PATH.'/app/global/sessions.php';
include_once ROOT_PATH.'/app/global/Gvariables.php';
include_once ROOT_PATH.'/db/db.php';
require_once ROOT_PATH.'app/controllers/headerController.php';

require_once ROOT_PATH.'imports/functions.php';
require_once ROOT_PATH.'/account/ajax/class/accountClass.php';
$checkuser = checkUserAccess();

    if( $checkuser['access'] == 0 ){  ?>
    <script>
        window.location = "<?php echo URL ?>login";
    </script>
    <?php 
    }else{
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['update_profile'])){

                $credentials['name'] = $_POST['name'];
                $credentials['mobile_no'] = $_POST['mobile_no'];
                $credentials['contact_no'] = $_POST['contact_no'];
                // $credentials['email'] = $_POST['email'];

                $credentials['p_door_no'] = $_POST['p_door_no'];
                $credentials['p_city'] = $_POST['p_city'];
                $credentials['p_state'] = $_POST['p_state'];
                $credentials['p_zip_code'] = $_POST['p_zip_code'];

                $credentials['t_door_no'] = $_POST['t_door_no'];
                $credentials['t_city'] = $_POST['t_city'];
                $credentials['t_state'] = $_POST['t_state'];
                $credentials['t_zip_code'] = $_POST['t_zip_code'];

                $credentials['default_address'] = $_POST['address_default'];

                $credentials['user_id'] = $_SESSION['user_id'];
                
                $update_user = $myaccountObj->updateUsers($credentials);

            } // isset
        } // request method


        $user_id = $_SESSION['user_id'];
        $select_user = mysqli_query($localhost,"SELECT * FROM `users` WHERE `id`='$user_id' ");
        $fetch_users = mysqli_fetch_array($select_user);
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Update My Account | ';
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
                            <h2 class="breadcrumb-title colour-brown"><b>Update My Account</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">Update My Account</li>
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
        <div class="blog-page-wrapper section-space--pt_60 section-space--pb_120">
            <div class="container">
                <div class="contact-us-info-area mt-30 section-space--mb_60">
                    <div class="row">
                        <div class="col-12">
                            <div id="account-details">
                                <h3>Account details </h3>
                                <div class="login">
                                    <div class="login-form-container">
                                        <div class="account-login-form">
                                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST"> 
                                                <div class="row billing-info-wrap">
                                                    <div class="billing-info mb-25 col-12 col-sm-12 col-md-6">
                                                        <label> Name </label>
                                                        <input type="text" name="name" value="<?php echo $fetch_users['name'] ?>">
                                                    </div>

                                                    <div class="billing-info mb-25 col-12 col-sm-12 col-md-6">
                                                        <label>Email</label>
                                                        <input type="email" name="email-name" required placeholder="Email Id" readonly value="<?php echo $fetch_users['email'] ?>">
                                                    </div>

                                                    <div class="billing-info mb-25 col-12 col-sm-12 col-md-6">
                                                        <label>Mobile No</label>
                                                        <input type="text" name="mobile_no" placeholder="Mobile Number" value="<?php echo $fetch_users['mobile_no'] ?>">
                                                    </div>

                                                    <div class="billing-info mb-25 col-12 col-sm-12 col-md-6">
                                                        <label>Contact No</label>
                                                        <input type="text" name="contact_no" placeholder="Contact Number" value="<?php echo $fetch_users['contact_no'] ?>">
                                                    </div>

                                                    <div class="billing-info mb-25 col-12 col-sm-12 col-md-6">
                                                        <br><br>

                                                        <h4>Permanent Address</h4>
                                                        <div class="row">
                                                            <div class="billing-info mb-25 col-12">
                                                                <label>Address Line </label>
                                                                <input placeholder="Address Line" type="text" name="p_door_no" value="<?php echo $fetch_users['p_door_no'] ?>">
                                                            </div>

                                                            <div class="billing-info mb-25 col-12">
                                                                <label>City</label>
                                                                <input  type="text" placeholder="City" name="p_city" value="<?php echo $fetch_users['p_city'] ?>">
                                                            </div> 
                                                            <div class="billing-info mb-25 col-12">
                                                                <label>County </label>
                                                                <input type="text" placeholder="Country" name="p_state" value="<?php echo $fetch_users['p_state'] ?>">
                                                            </div>

                                                            <div class="billing-info mb-25 col-12">
                                                                <label>Postal code </label>
                                                                <input type="text" placeholder="Postal code" name="p_zip_code" value="<?php echo $fetch_users['p_zip_code'] ?>">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="billing-info mb-25 col-12 col-sm-12 col-md-6">
                                                    <br><br>
                                                        <h4>Temporary Address</h4>
                                                        <div class="row">
                                                            <div class="billing-info mb-25 col-12">
                                                                <label>Address Line </label>
                                                                <input placeholder="Address Line" type="text" name="t_door_no" value="<?php echo $fetch_users['t_door_no'] ?>">
                                                            </div>

                                                            <div class="billing-info mb-25 col-12">
                                                                <label>City</label>
                                                                <input  type="text" placeholder="City" name="t_city" value="<?php echo $fetch_users['t_city'] ?>">
                                                            </div> 
                                                            <div class="billing-info mb-25 col-12">
                                                                <label>County </label>
                                                                <input type="text" placeholder="Country" name="t_state" value="<?php echo $fetch_users['t_state'] ?>">
                                                            </div>

                                                            <div class="billing-info mb-25 col-12">
                                                                <label>postal code </label>
                                                                <input type="text" placeholder="Postal code" name="t_zip_code" value="<?php echo $fetch_users['t_zip_code'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row billing-info-wrap">
                                                    <div class="billing-info mb-25 col-12">
                                                        <label>Select default address for orders</label>
                                                        <select name="address_default" class="form-control">
                                                            <option value="p" <?php  if($fetch_users['default_address'] == "p"){ echo "selected"; }?> >Permanent Address</option>
                                                            <option value="t" <?php  if($fetch_users['default_address'] == "t"){ echo "selected"; }?> >Temporary Address</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn--full btn--black" name="update_profile" type="submit">Save</button>
                                                    </div>
                                                </div>
                                            </form>
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