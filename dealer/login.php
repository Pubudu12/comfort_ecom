<?php 
    require_once '../app/global/url.php';
    include_once ROOT_PATH.'/app/global/sessions.php';
    include_once ROOT_PATH.'/app/global/Gvariables.php';
	include_once ROOT_PATH.'/db/db.php';
	require_once ROOT_PATH.'app/controllers/headerController.php';

	require_once ROOT_PATH.'imports/functions.php';
    require_once ROOT_PATH.'mail/mails.php';
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Dealer Sign In | ';
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
                        <img class="login-img1" src="<?php echo URL?>assets/img/1_login.jpg">
                    </div>
                    <div class="col-lg-6 col-md-7 ml-auto mr-auto">
                        <div class="myaccount-box-wrapper">
                            <div class="helendo-tabs mob-tab-responsive">
                                <ul class="nav" role="tablist">
                                    <li class="tab__item nav-item active">
                                        <a class="nav-link active" data-toggle="tab" href="#tab_list_06" role="tab">Dealer Sign In</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content content-modal-box m-t-responsive">
                                <div class="tab-pane fade show active" id="tab_list_06" role="tabpanel">
                                    <form class="account-form-box"
                                            id="login_form"
                                            data-action-after=2
                                            data-redirect-url="<?php echo URL?>shop"
                                            method="POST"
                                            action="<?php echo URL ?>dealer/ajax/controller/accountController.php">
                                        <!-- <h6>Login your account</h6> -->
                                        <div class="single-input">
                                            <input type="email" id="login_form_email" name="login_form_email" placeholder="Email Address" />
                                        </div>
                                        <div class="single-input">
                                            <input type="password" id="login_form_password" name="login_form_password" placeholder="Password" />
                                        </div>
                                        <div class="checkbox-wrap mt-10">
                                            <!-- <a href="#" class=" mt-10">Forgot password?</a> -->
                                        </div>
                                        <div class="button-box mt-25">
                                            <input type="hidden" name="login_dealer">
                                            <button class="btn btn--full btn--black btn btn-solid submit_form_no_confirm login-btn1" data-notify_type=2 data-validate=1 type="submit">Sign In</button>
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

    <!-- Ajax Form Submission -->
    <script src="<?php echo URL ?>assets/js/form/form_ajax_submission.js"></script>
</body>
</html>