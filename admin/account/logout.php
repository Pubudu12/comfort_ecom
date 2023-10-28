<?php
include_once '../app/global/url.php';
include_once ROOT_PATH.'/app/global/global.php';
include_once ROOT_PATH.'/db/db.php';

session_destroy();
header('location:login.php');
?>