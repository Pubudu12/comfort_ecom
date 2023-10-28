<?php 
session_start();

// Set Guest Cart Id
define("GUEST_CART_COOKIE_NAME","tur_guest_cart_id");
if(!isset($_COOKIE[GUEST_CART_COOKIE_NAME])) {
    setcookie(GUEST_CART_COOKIE_NAME, rand().date("Ymdh"), time() + (86400 * 30), "/"); // 86400 = 1 day
}
?>