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
                <div class="row text-center">
                    <div class="col-lg-3 col-md-3 ml-auto mr-auto">
                    </div>
                    <div class="col-lg-6 col-md-6 ml-auto mr-auto">
                        <div class="myaccount-box-wrapper">
                            <h2 class="text-center">Reset Your Password</h2>
                            <div class="tab-content content-modal-box m-t-responsive mt-25">
                                <div class="" id="tab_list_06" role="tabpanel">
                                    <form class="account-form-box "
                                            id="login_form"
                                            data-action-after=2
                                            data-redirect-url=""
                                            method="POST"
                                            action="<?php echo URL ?>account/ajax/controller/accountController.php">
                                        
                                            <div class="row billing-info-wrap">
                                                <div class="billing-info mb-25 col-12 col-sm-12 col-md-12">
                                                    <!-- <label> Name </label> -->
                                                    <input type="email" id="reset_email" name="reset_email" placeholder="Email Address">
                                                </div>
                                                <div class="billing-info mb-15 col-12 col-sm-12 col-md-12">
                                                    <!-- <label> Name </label> -->
                                                    <input type="password" id="reset_password" name="reset_password" placeholder="New Password">
                                                </div>
                                                <div class="billing-info mb-15 col-12 col-sm-12 col-md-12">
                                                    <!-- <label> Name </label> -->
                                                    <input type="password" id="reset_confirm_password" name="reset_confirm_password" placeholder="Confirm New Password">
                                                </div>
                                            </div>

                                        <div class="button-box mt-3">
                                            <input type="hidden" name="reset_customer_password">
                                            <button class="btn btn--full btn--brown btn btn-solid submit_form_no_confirm " data-notify_type=2  type="button">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 ml-auto mr-auto">
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

</body>
</html>