<?php 
    require '../app/global/url.php';
	include ROOT_PATH.'/app/global/sessions.php';
	include ROOT_PATH.'/app/global/Gvariables.php';
	include ROOT_PATH.'/db/db.php';
    require_once ROOT_PATH.'app/controllers/headerController.php';
    require_once ROOT_PATH.'app/controllers/productsControllerClass.php';
    require_once ROOT_PATH.'imports/functions.php';
    require_once ROOT_PATH.'shopController/class/cartClass.php';
    require_once ROOT_PATH.'assets/vendor/validation/gump.class.php';

    $gump = new GUMP();

    $getUserType = checkUserAccess();

    //if( $getUserType['access'] == 0 ){ ?>
            
    <!-- <script>
        window.location = "<?php echo URL ?>login";
    </script> -->
    <?php 
   // }else{
    $productsArray = $productControllerObj->getTrendingProducts('latest', 1);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
    
        if(isset($_POST['update_cart']) && isset($_POST['row_id'])  && isset($_POST['cart_qty']) ){
    
            $getUserType = checkUserAccess();
    
            $row_id = $_POST['row_id'];
            $qty = $_POST['cart_qty'];
            $productId = $_POST['product_id'];
    
            //select table of cart
            if($getUserType['access'] == 1){
                $table_name = "cart";   
            }else{
                $table_name = "guest_cart";
            }
            
            $row_count = count($row_id);
            // check the count of rows
            if($row_count > 0){
                for($i=0;$i<$row_count;$i++){
    
                    //check qty if zero delete the row

                    $single_pro_id = $productId[$i];

                    $selectPro = mysqli_query($localhost, "SELECT `min_order_qty` FROM `products` WHERE `id` = '$single_pro_id' ");
                    $fetchpro = mysqli_fetch_array($selectPro);
                    $min_order_qty = $fetchpro['min_order_qty'];

                    
                    if( $qty[$i] <= $min_order_qty){
                        $rowQty = $min_order_qty;
                    }else{
                        $rowQty = $qty[$i];
                    }

    
                    if($qty[$i] < 1 && is_numeric($qty[$i]) ){
    
                        // delete the row of the table
                        $delete = mysqli_query($localhost,"DELETE FROM `$table_name` WHERE `id`='$row_id[$i]' ");
    
                    }else{
                        // update the row with new qty
                        $update = mysqli_query($localhost,"UPDATE `$table_name` SET `qty` = '$rowQty' WHERE `id`='$row_id[$i]' ");
                    }
                }// for loop end 
            } // if end 
        }// isset
    } // request method
	$cartItemsArray = $cartObj->fetchCartItemsFromOut();
    $cartItemsArray = $gump->sanitize($cartItemsArray); 
    $sanitized_query_data = $gump->run($cartItemsArray);
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<?php require_once ROOT_PATH.'app/analytics/analytics_head.php';
        require_once ROOT_PATH.'app/meta/meta.php';
        $meta_single_page_title = 'Cart | ';
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

    <!-- CSS
        ============================================ -->
        <?php require_once ROOT_PATH.'imports/css.php' ?>
</head>
<body class="">
    <!--====================  header area ====================-->
    <?php include_once ROOT_PATH.'imports/header3.php'; ?>

    <!--====================  End of header area  ====================-->

      <!-- breadcrumb-area start -->
      <div class="breadcrumb-area section-space--pt_80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title colour-brown"><b>Cart</b></h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo URL?>">Home</a></li>
                                <li class="breadcrumb-item active">Cart</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

   
    <div class="site-wrapper-reveal border-bottom">

        <!-- cart start -->
        <div class="cart-main-area section-space--ptb_90">
        <div class="container">
                <form action="<?php echo URL ?>cart" METHOD="POST" class="cart-table">
                    <div class="table-responsive cartTable row header-color-gray">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Image</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($sanitized_query_data['itemsArray'])>0) {
                                    foreach ($sanitized_query_data['itemsArray'] as $key => $singleItemArray) { ?>
                                    <tr class="alert" role="alert">
                                        <td class="product-img image-center"><img class="image-resize" src="<?php echo $singleItemArray['image'] ?>" alt="<?php echo $singleItemArray['name'] ?>"></td>
                                        <td class="product-name">
                                            <h6 class="heading"> <a href="<?php echo $singleItemArray['url'] ?>"><?php echo $singleItemArray['name'] ?></a></h6>
                                            <?php if($singleItemArray['availability']['result'] == 0){ ?>
                                                <br> <small class="text-danger"><?php echo $singleItemArray['availability']['message'] ?></small>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $singleItemArray['size_name']?></td>
                                        <td class="price"><?php echo CURRENCY.' '.number_format($singleItemArray['price'], 2) ?></td>
                                        <td class="cart-quality">
                                            <div class="quickview-quality quality-height-dec2">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" type="text" name="cart_qty[]" value="<?php echo $singleItemArray['qty'] ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="price-total"><?php echo CURRENCY.' '.number_format($singleItemArray['row_total'], 2) ?></td>
                                        <td><a href="#" onclick="removeCartItems(<?php echo $singleItemArray['row_id'] ?>, true)"><i class="icon-cross2"></i></a></td>

                                        <input type="hidden" name="row_id[]" value="<?php echo $singleItemArray['row_id'] ?>">
                                        <input type="hidden" name="product_id[]" value="<?php echo $singleItemArray['product_id'] ?>">
                                    </tr>
                                    <?php } ?>
                               <?php } else {?>
                                    <tr>
                                        <td colspan="6" class="text-center">Add items to the cart</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="shoping-update-area row">
                        <div class="continue-shopping-butotn col-6 mt-30">
                            <a href="<?php echo URL?>shop" class="btn btn--lg btn--black"><i class="icon-arrow-left"></i> Continue Shopping </a>
                        </div>
                        <div class="update-cart-button col-6 text-right mt-30">
                            <button class="btn btn--lg btn--border_1" name="update_cart" type="submit">Update cart</button>
                        </div>
                    </div>
                    <div class="cart-buttom-area">
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <div class="cart_totals section-space--mt_60 ml-md-auto">
                                    <div class="grand-total-wrap">
                                        <div class="grand-total-content">
                                            <ul>
                                                <li>Subtotal <span> <?php echo CURRENCY.' '.number_format($cartItemsArray['grand_total'], 2) ?></span></li>
                                                <li>Total <span><?php echo CURRENCY.' '.number_format($cartItemsArray['grand_total'], 2) ?></span> </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="grand-btn mt-30">
                                        <a href="<?php echo URL?>checkout" class="btn--black btn--full text-center btn--lg">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- cart end -->
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
</body>
</html>
<?php //}?>