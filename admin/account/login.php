<?php 
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include_once ROOT_PATH.'app/meta/meta.php';

    $meta_single_page_title = 'Login - ';
    $meta_single_page_desc = 'Login - ';
    include_once ROOT_PATH.'app/meta/meta_more_details.php'; 

    include_once ROOT_PATH.'imports/css.php';
    ?>
</head>
<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">
    <div class="authentication-box">
        <div class="container">
            <div class="row">
                <div class="col-md-5 p-0 card-left">
                    <div class="card bg-primary">
                        <!-- card-body -->
                        <?php include_once ROOT_PATH.'account/include/card.php'?>

                        <div class="single-item">
                            <div>
                                <div>
                                    <h3>Admin Dashboard</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 p-0 card-right login-white-mt">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="top-profile-tab" data-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><span class="icon-user mr-2"></span>Login</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel" aria-labelledby="top-profile-tab">

                                    <form class="form-horizontal auth-form" id="sign_in_form"
                                            data-action-after=2
                                            data-redirect-url="<?php echo URL ?>"
                                            method="POST"
                                            action="<?php echo URL ?>account/ajax/controller/loginController.php">
                                    
                                        <div class="form-group">
                                            <input required="" name="username" type="text" class="form-control" placeholder="Username" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group">
                                            <input required="" name="password" type="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-button">
                                            <input type="hidden" name="admin_login">

                                            <button type="button" class="btn btn-lg btn-primary btn-block submit_form_no_confirm" 
                                                data-notify_type=2 
                                                data-validate=0 > Sign in</button>

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

<?php include_once ROOT_PATH.'imports/js.php'?>
</body>
</html>
