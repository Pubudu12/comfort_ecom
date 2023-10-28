referehCart(); 
function confirmModel(Title, Message){
    $.confirm({
        title: Title,
        theme: 'material',
        content: '<h4>'+Message+'</h4>',
        buttons: {
            
            close: {
                text: 'Close', // With spaces and symbols
                
            }
            
        }
    });
}

function referehCart(){
    var url = ROOT_URL+'shopController/http/controller/cartController.php';
    var cartTotalItems = $("#menu-total_items");
    var totalCartAmount = $("#menu-totalCartAmount");
    var cartItems = $("#menu-cart_items");
    
    $.ajax({
        url : url,
        method: 'POST',
        dataType: 'json',
        data: { refresh_cart : 'refresh_cart' },
        success:function(ret){
            // console.log(ret);
            totalCartAmount.html(ret.grand_total);
            cartItems.html(ret.list);
            cartTotalItems.html(ret.totalItems);
        },
        error:function(err){
            console.error('refresh method error')
            // console.error(err);
        }
    }); // ajax end 
    
} // referehCart end 



$('.remove_cart').on('click',function(){
    alert();
});
    
function removeCartItems(rowId, reload = false){

    event.preventDefault();

    var url = ROOT_URL+'shopController/http/controller/cartController.php';

    $.ajax({
        url : url,
        method: 'POST',
        dataType: 'json',
        data: { 
                'row_id' : rowId, 
                'delete_cart_items' : 'delete' 
            },
        success:function(ret){
            
            if(ret.result == 1){

                if(reload == true){
                    
                    window.location = window.location;
                }else{
                    referehCart();
                }

            }
        }, 
        error:function(err) {
            
            console.error(err);

        } // Err
    });

}//

function checkCartBeforeCheckout(){

    var url = ROOT_URL+'ajax/validate_cart.php';

    var tbody = $('.checkout_tbody tr');

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            'validate_cart' : 1
        },
        success:function(ret){

            console.log(ret);

            if(ret.error == 1){
                $(".error_alert").show();
            }else{
                $(".error_alert").hide();
            }

            var row = 0;
            $.each(ret.details, function(key, index){

                if(index.error == 1){
                    appendThis = '<p>'+index.message+'</p>'
                    tbody.eq(row).find('.checkout_td_qty').append(appendThis);
                }else{
                    tbody.eq(row).find('.checkout_td_qty p').remove();
                }
                

                row++;
            });// foreach end

        },
        error:function(err){
            console.log("Error");
            console.log(err);
        }
    });

} //checkCartBeforeCheckout


// Adding Item In Cart
function addToCart(product_id, r_qty = 1, size = 0){
    var productId = product_id;
    var qty = r_qty;
    var pro_size = size;
    
    $.confirm({
    
        title: 'Add to cart!',
        bgOpacity: 100,
        theme: 'material', // 'material', 'bootst
        
        content: function () {
            
            var self = this;
            return $.ajax({
                method: 'POST',
                url: ROOT_URL+'shopController/http/controller/cartController.php',
                dataType: 'json',
                data: { 'product_id' : productId,
                        'qty' : qty,
                        'pro_size':pro_size,
                        'add_to_cart' : 'add_to_cart' }
                
            }).done(function (response) {

                if( Number(response.result) == 1){
                    self.setTitle(response.title);
                    self.setContent(response.message);
                    self.setType('success') 
                    referehCart();
                }else{
                    self.setTitle(response.title);
                    self.setContent(response.message);
                    self.setType('red') 
                }

            }).fail(function(err){
                console.error(err)
                self.setType('red') 
                self.setContent('Something went wrong.');

            });
        },

        buttons: {
            ok: {
                text: 'Continue Shopping',
                action: function () {
                    // backgroundDismiss: true; // this will ju
                    window.location = ROOT_URL+'shop';
                }
            },
                
            checkout: {
                text: 'Checkout',
                action: function(){
                    window.location = ROOT_URL+'checkout';
                }
            }
        }

    });

} // addToCart function end 



function addToWishlist(product_id){
    var productId = product_id;
    fbq('track', 'AddToWishlist');

    $.confirm({
    
        title: 'Add to wishlist!',
        theme: 'material',
        
        content: function () {
            var self = this;
            return $.ajax({
                method: 'post',
                url: 'ajax/add_to_cart.php',
                dataType: 'json',
                data: { product_id : productId, add_to_wishlist : 'add_to_wishlist' }
                
            }).done(function (response) {
                
                self.setTitle(response.title);
                self.setContent(response.message );

            }).fail(function(){
                
                self.setContent('Something went wrong.');

            });
        },

        autoClose: 'ok|2000',
        buttons: {
            ok: function () {
                
                backgroundDismiss: true;
            }
        }

    });

} // addToWishlist function end 


function checkLogin(product_id){
    var productId = product_id;

    //check weathert login or not
    $.ajax({
        method : 'POST',
        url: 'ajax/add_to_cart.php',
        dataType: 'json',
        data: { check_login : 'check_login' },
        success:function(ret){
            
            if(Number(ret['access']) == 1){

                addToWishlist(productId);

            }else{


                // please login to add wishlist alert 
                $.confirm({
                    title: 'Failed!',
                    theme: 'material',
                    content: '<h3>Please login to add wishlist</h3>',
                    buttons: {
                        
                        ok: {
                            text: 'Login', // With spaces and symbols
                            action: function () {
                                window.location = ROOT_URL+'/account/login.php';
                            },
                        },
                        close:{
                            text: 'Cancel',
                            action: function(){
                                backgroundDismiss: true;
                            }
                        }
                        
                    }
                });

            } // if end of check login 
        } // success end 
    });

}


// add to cart and wish list from the Item Single page 
// add to cart

function callAddToCart(e){
    
    var addToCartParentBox = $(e).parents('.addToCartParentBox');
    var errorMessageField = addToCartParentBox.find('.error_message');
    

    var errorMessage = '';
    var minQty = Number(addToCartParentBox.find('.addToCartqty').attr('min'));
    var qty = Number(addToCartParentBox.find('.addToCartqty').val());

    if(qty >= minQty){
        
        var pro_size = Number($("#pro_size").val());

        var productId = Number($(e).data('value'));
        // alert(pro_size)
        
        addToCart(productId, qty, pro_size);

    }else{
        errorMessage = 'Please select minimum '+minQty+' items ';
    }

    errorMessageField.html(errorMessage);

} //callAddToCart


$('.add-to-wishlist-details').on('click',function(e){
    e.preventDefault();
    var productId = $(this).data('value');

    if(Number(productId) ){
        // every possible checking end 
        checkLogin(productId);
    }else{
        
        // something went wrong message
        
    } // if end for check validate


}); // add-to-wishlist-details end 


// product page add cart and wishlist
// add to cart scripts
$('.add-to-shopping-cart').on('click',function(e){
    e.preventDefault();
    let productId = $("#qm-product_id").val();
    var qty = 1;

    addToCart(productId,qty);

}); // add-to-shopping-cart end 


// add to wishlist scripts
$('.add-to-wishlist').on('click',function(e){
    e.preventDefault();
    var qty = 1;    
    var productId = $(this).data('value');
    // addToCart(productId, qty);
}) ; // add-to-wishlist end 

function calculateDiscountAmount(discountMethod, total, idisper ){

    let discountAmount = (()=>{
        
        var percentageValue;
        
        if(discountMethod == "%"){
            percentageValue = parseFloat((total/100) * idisper);
        }else if(discountMethod == "/"){
            percentageValue = parseFloat(idisper);
        }else{
            percentageValue = parseFloat((total/100) * idisper);
        }

        return percentageValue;

    })();

    let grandTotal = parseFloat(total)-parseFloat(discountAmount);
    
    return  {'grandTotal' : grandTotal, 'discountAmount' : discountAmount};
}

function priceDynamicManipulation(currentQty, productsDetailsManipulationparentBox){

    var displayTotalAmountDiv = productsDetailsManipulationparentBox.find('.displayTotalAmount');
    var currentSalePriceDiv = productsDetailsManipulationparentBox.find('.salePrice');
    var delPriceDiv = productsDetailsManipulationparentBox.find('.delPrice');

    var currentSalePrice = currentSalePriceDiv.attr('data-price');
    
    if(productsDetailsManipulationparentBox.find('.productDiscountDetailsList').length ){

        // class exists
        // do something

        var productDiscountDetailsList = productsDetailsManipulationparentBox.find('.productDiscountDetailsList');
        var totalClasses = productDiscountDetailsList.length;
        
        var tempDisValue = 0;
        var tempDisType = '/';
        var tempDisMinQty = 0;

        for(i=0; i<totalClasses; i++){
            var tempDiscountDetail = productDiscountDetailsList.eq(i);

            if(tempDiscountDetail.attr('data-minQty') <= currentQty){
                tempDisValue = tempDiscountDetail.val();
                tempDisType = tempDiscountDetail.attr('data-discountType');
                tempDisMinQty = tempDiscountDetail.attr('data-minQty');
            }
        }

        var calculatedDiscountValue = calculateDiscountAmount(tempDisType, currentSalePrice, tempDisValue);

        var newSaleprice = calculatedDiscountValue['grandTotal'];
        var discountedAmount = calculatedDiscountValue['discountAmount'];

        var newGrandTotal = newSaleprice*currentQty;

        if(newSaleprice == currentSalePrice){
            currentSalePriceDiv.html('LKR '+currencyFormat(newSaleprice,2))
            delPriceDiv.html('');
        }else{
            currentSalePriceDiv.html('LKR '+currencyFormat(newSaleprice,2))
            delPriceDiv.html('LKR '+currencyFormat(currentSalePrice, 2));
        }
        

        displayTotalAmountDiv.html('Total amount: <b>'+ currencyFormat(newGrandTotal, 2) +'</b>')


    }

} //priceDynamicManipulation

// Add to cart
function stockmanipulation(e, sign){
    // e.preventDefault();

    var addCartQtyParent = $(e).parents('.addCartQtyParent');
    var errorField = addCartQtyParent.parents('.addToCartParentBox').find('.error_message');

    var inputField = addCartQtyParent.find('.addToCartqty');
    var currentValue = Number(inputField.val());
    var minimumQty = Number(inputField.attr('min'));

    if(sign == "+"){
        var updatedValue = currentValue+1;
    }else if(sign == "-"){
        var updatedValue = currentValue-1;
    }else{
        var updatedValue = currentValue;   
    }

    if(isNaN(currentValue)){
        updatedValue = minimumQty;
    }
    
    if(updatedValue <= (minimumQty-1)){
        updatedValue = minimumQty;
        errorField.html('Please select minimum '+minimumQty+' qty');
    }else{
        errorField.html('');
        var productsDetailsManipulationparentBox = addCartQtyParent.parents('.productsDetailsManipulationparentBox');
        priceDynamicManipulation(updatedValue, productsDetailsManipulationparentBox);
    }
    inputField.val(updatedValue);

} //addCartQtyParent

function applyCoupon() {
    coupon_code = $('#coupon_code').val();
    
    $.ajax({
        type: 'POST',
        url: ROOT_URL+'shopController/http/controller/cartController.php',
        data: {
            'check_promo_code_avalilability': 'yes', 
            'coupon_code': coupon_code,
        },
        dataType: 'json',

        success: function (response) {
            console.log(response);
            if( Number(response.result) == 1){
                $('#discount_of_promo').val(response['discountedAmount'])
                $('#total_after_pro_discount').val(response['totalAfterShippingCharge'])
                $('#apply_promo_status').val('1')
                $('#checkout_promo').val(coupon_code)
                $("p.error_message").removeClass("text-danger");
                $("p.error_message").addClass("text-success");
                $(".error_message").html(response.message);

                document.getElementById("final_total").innerHTML ='LKR '+currencyFormat(response['totalAfterShippingCharge'],2);

                $("div.display-change").removeClass("no-display");
                $("div.display-change").addClass("make-display");
                promo_discount = Number($('#discount_of_promo').val());
                document.getElementById("promo_discount").innerHTML ='LKR '+currencyFormat(promo_discount,2);
                // newdisplay = "<ul><li><strong>Promo Discount</strong> <span id=''>"+'LKR '+currencyFormat(promo_discount,2)+"</span></li></ul>";
            }else{
                $('#apply_promo_status').val('0')
                $("p.error_message").addClass("text-danger")
                $(".error_message").html(response.message);
            }
        },error:function (err) {
            console.log(err);
        }
    });
}

// function applyCoupon() {
//     if ($('#apply_promo_status').val() == 1) {
        
//         // .innerHTML ='LKR '+currencyFormat(discountedAmount);
//     } 
// }