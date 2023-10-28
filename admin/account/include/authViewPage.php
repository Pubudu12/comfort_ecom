<?php

$checkAccess = $dbOpertionsObj->checkLogin($checkArr);

if($checkAccess == 1){
    //Process further to chec auth access
    
    define("ADMIN_USERNAME", $_SESSION['admin_name']);
    define("ADMIN_USER_ID", $_SESSION['admin_user_id']);

}else{
    // Rediret to the login page without any further notification
    // Redirect Code

    $redirect_here = URL.'account/login.php';
    redirect($redirect_here, false);
    Exit(404);
}

?>