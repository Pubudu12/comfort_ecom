<?php 
    require_once '../app/global/url.php';
    include_once ROOT_PATH.'/app/global/sessions.php';
    include_once ROOT_PATH.'/app/global/Gvariables.php';
	include_once ROOT_PATH.'/db/db.php';
	require_once ROOT_PATH.'app/controllers/headerController.php';

	require_once ROOT_PATH.'imports/functions.php';
    require_once ROOT_PATH.'mail/mails.php';
  
    $tab = 'login';
    if(isset($_GET['q'])){
        $tab = trim($_GET['q']);
    }
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Sign In | ';
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

    <!-- CSS ============================================ -->
        <?php require_once ROOT_PATH.'/imports/css.php' ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"/>
    <link rel="stylesheet" href="<?php echo URL?>assets/js/form/waitme/waitMe.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body class="">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>
    <!--====================  End of header area  ====================-->


    <div class="section-space--pt_60 site-wrapper-reveal border-bottom">
        <div class="my-account-page-warpper section-space--ptb_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7 ml-auto mr-auto">
                        <img class="login-img1" src="<?php echo URL?>assets/img/1we.jpg">
                    </div>
                    <div class="col-lg-6 col-md-7 ml-auto mr-auto">
                        <div class="myaccount-box-wrapper">
                            <div class="helendo-tabs mob-tab-responsive">
                                <ul class="nav" role="tablist">
                                    <li class="tab__item nav-item nav-link <?php echo doactive('login', $tab) ?> ">
                                        <a class="nav-link <?php echo doactive('login', $tab) ?> font-brown-light tab-inactive-clr" data-toggle="tab" href="#tab_list_06" role="tab">Sign In</a>
                                    </li>
                                    <li class="tab__item nav-item nav-link <?php echo doactive('register', $tab) ?> ">
                                        <a class="nav-link <?php echo doactive('register', $tab) ?> font-brown-light tab-inactive-clr" data-toggle="tab" href="#tab_list_07" role="tab">Sign Up</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="tab-content content-modal-box m-t-responsive mt-25">
                                <div class="tab-pane fade show <?php echo doactive('login', $tab) ?>" id="tab_list_06" role="tabpanel">
                                    <form class="account-form-box "
                                            id="login_form"
                                            data-action-after=2
                                            data-redirect-url="<?php echo URL?>shop"
                                            method="POST"
                                            action="<?php echo URL ?>account/ajax/controller/accountController.php">
                                        
                                            <div class="row billing-info-wrap">
                                                <div class="billing-info mb-25 col-12 col-sm-12 col-md-12">
                                                    <!-- <label> Name </label> -->
                                                    <input type="email" id="login_form_email" name="login_form_email" placeholder="Email Address">
                                                </div>
                                                <div class="billing-info mb-15 col-12 col-sm-12 col-md-12">
                                                    <!-- <label> Name </label> -->
                                                    <input type="password" id="login_form_password" name="login_form_password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="call-to-pro">
                                                <a  data-target="#passwordReset" data-toggle="modal" class="mb-10">Lost your password?</a>
                                            </div>

                                        <div class="button-box ">
                                            <input type="hidden" name="login_customer">
                                            <button class="btn btn--full btn--brown btn btn-solid submit_form_no_confirm " data-notify_type=2 data-validate=1 type="submit">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade <?php echo doactive('register', $tab) ?>" id="tab_list_07" role="tabpanel">
                                    <form class="account-form-box"  id="register_form"
                                            data-action-after=2
                                            data-redirect-url="<?php echo URL ?>"
                                            method="POST"
                                            action="<?php echo URL ?>account/ajax/controller/accountController.php">
                                   
                                        <div class="row billing-info-wrap">
                                            <div class="billing-info mb-25 col-12 col-sm-12 col-md-12">
                                                <!-- <label> Name </label> -->
                                                <input type="text" name="register_form_name" placeholder="Name" required>
                                            </div>
                                            <div class="billing-info mb-25 col-12 col-sm-12 col-md-12">
                                                <!-- <label> Name </label> -->
                                                <input type="email" placeholder="Email Address" name="register_form_email" id="register_form_email"  required>
                                            </div>
                                            <div class="billing-info mb-25 col-12 col-sm-12 col-md-12">
                                                <!-- <label> Name </label> -->
                                                <input type="text" placeholder="Phone Number" name="register_form_phone" required>
                                            </div>
                                            <div class="billing-info mb-25 col-12 col-sm-12 col-md-12">
                                                <!-- <label> Name </label> -->
                                                <input type="password" placeholder="Password" name="register_form_password" required>
                                            </div>
                                            <div class="billing-info mb-25 col-12 col-sm-12 col-md-12">
                                                <!-- <label> Name </label> -->
                                                <input type="password" placeholder="Confirm Password" name="register_form_repassword" required>
                                            </div>
                                        </div>
                                        
                                        <div class="button-box mt-25">
                                            <input type="hidden" name="register_customer">
                                            <button class="btn btn--full btn--brown submit_form_no_confirm" 
                                                data-notify_type=2
                                                data-validate=1
                                                type="submit">Sign Up</button>
                                                
                                            <!-- <button class="btn btn--full btn--brown btn btn-solid submit_form_no_confirm " data-notify_type=2 data-validate=1 type="submit">Sign In</button> -->
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
    <!-- modal start -->
    <div class="header-login-register-wrapper modal fade" id="passwordReset" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-box-wrapper">
                    <div class="tab-content content-modal-box">
                        <div class="tab-pane fade show active" role="tabpanel">
                            <h2 class="text-center font-brown-light fg-pwd">Reset Password</h2>
                            <form  data-action-after=2
                                    data-redirect-url=""
                                    method="POST"
                                    action="<?php echo URL ?>account/ajax/controller/accountController.php" class="account-form-box">
                                <p>Please enter your email address and we'll send you a link to reset your password.</p>

                                <div class="single-input">
                                    <input type="text" name="email" placeholder="Email">
                                </div>
                                <div class="button-box mt-25">
                                    <input type="hidden" name="sendPasswordResetMail">
                                    <a type="button" class="btn btn--full btn--brown submit_form_no_confirm" style="color: white;
font-weight: bold;" data-notify_type=2 >Send</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- model end -->

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
    <script src="<?php echo URL?>assets/js/form/waitme/waitMe.min.js"></script>
    <script src="<?php echo URL?>assets/js/form/waitme/waitMeCustom.js"></script>

    <!-- Jquery Confirm -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <script src="<?php echo URL ?>assets/js/form/toast.js"></script>

    <!-- validate js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="<?php echo URL?>assets/js/validation/register.js"></script>
    <script src="<?php echo URL?>assets/js/validation/login.js"></script>

</body>
</html>