<?php
/**
 * Custom Fields Permalink 2.
 *
 * @package
 * @author
 * @copyright
 * @license
 * 
 */

$checkAccess = $dbOpertionsObj->checkLogin($checkArr);

if($checkAccess == 1){
    //Process further to chec auth access
    
    define("BLOG_USERNAME", $_SESSION['admin_name']);
    define("BLOG_USER_ID", $_SESSION['admin_user_id']);
    define("BLOG_USER_LEVEL", $checkAccess['admin_level']);

}else{
    // Rediret to the login page without any further notification
    // Redirect Code

    $redirect_here = URL.'admin/account/login.php';
    redirect($redirect_here, false);
    Exit(404);
}

?>