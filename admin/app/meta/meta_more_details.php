
<!-- Example Code -->

<?php #endregion
$meta_arr = array(
    'title' => $meta_single_page_title,
    'description' => $meta_single_page_desc,
    'image' => 'assets/images/meta/default.png',
);
?>

<!-- Example Code End -->
<?php 
$general_title_sub = CLIENT_NAME.' | eCommerce Dashboard';
$general_desc_sub = CLIENT_NAME.' | eCommerce Backend';

$full_current_page_actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 

$meta_author = "www.CreativeHub.lk";
$meta_content_type = "eCommerce Backend";

?>

<title><?php echo $meta_arr['title'].$general_title_sub ?>  </title>

<meta name="description" content="<?php echo $meta_arr['description'].$general_desc_sub ?>">
<meta name="image" content="<?php echo URL ?><?php echo $meta_arr['image'] ?>" />
<meta name="author" content="<?php $meta_author ?>">
<meta name="copyright" content="<?php echo Date("Y") ?>">
