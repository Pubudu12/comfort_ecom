<?php 
require_once '../../app/global/url.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['set_cookie'])){

        $cookie_name = "cw_popup_cookie";
        $cookie_value = rand().Date("smYdhis").rand();
        setcookie($cookie_name, $cookie_value, time()+3600, "/");
        
        echo json_encode(array('result'=>'1'));

    } // Set Cookies

    if(isset($_POST['check_cookie'])){

        $cookie_name = "cw_popup_cookie";

        $result = 0;
        $message = "Not Set";

        if(isset($_COOKIE[$cookie_name])) {
            $result = 1;
            $message = "Set";
        }

        $cookie_name = "cw_popup_cookie";
        $cookie_value = rand().Date("smYdhis").rand();
        setcookie($cookie_name, $cookie_value, time()+86400, "/");

        echo json_encode(array('result' => $result, 'message' => $message));

    } // Check Cookie

} // Post Method

?>