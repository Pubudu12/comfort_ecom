// Product Page
function calculateProductPrice(){
    var actualPrice = $("#actual_price").val();
    var discountType = $("#price_dis_type").val();
    var discountVal = $("#discount_value").val();

    proSalePrice = 0;

    var percentageValue = 0;
    if(discountType == "%"){
        percentageValue = parseFloat((actualPrice/100) * discountVal);
    }else if(discountType == "/"){
        percentageValue = parseFloat(discountVal);
    }else{
        percentageValue = parseFloat((actualPrice/100) * discountVal);
    }
    
    // calculating final discount subtotal
    proSalePrice = parseFloat(actualPrice - percentageValue) ;
    $("#pro_sale_price").val(proSalePrice);

} //calculateProductPrice

function modalCalculateProductPrice(){

    var actualPrice = $("#price_update_actual_price_form").val();
    var discountType = $("#price_update_discount_type_form").val();
    var discountVal = $("#price_update_discount_form").val();

    proSalePrice = 0;

    // calculating final discount Per
    var percentageValue = 0;
    if(discountType == "%"){
        percentageValue = parseFloat((actualPrice/100) * discountVal);
    }else if(discountType == "/"){
        percentageValue = parseFloat(discountVal);
    }else{
        percentageValue = parseFloat((actualPrice/100) * discountVal);
    }
    
    // calculating final discount subtotal
    proSalePrice =  parseFloat(actualPrice - percentageValue) ;
    $("#price_update_sale_price_form").val(proSalePrice);

} //modalCalculateProductPrice



// Stock Details
function productPriceListDatatable(){

    var tableName = 'products_stock_list-table';
    var actionUrl = $('#'+tableName).data('url');

    var productId = $("#product_id").val();        
    var postData = { 
        'productList': 'yes',
        'product_id': productId
    };

    ajaxDataTableLoad(tableName, actionUrl, postData);

} //productPriceListDatatable
productPriceListDatatable();

function productDiscountListDatatable(){

    var tableName = 'products_discountList-table';
    var actionUrl = $('#'+tableName).data('url');

    var productId = $("#product_id").val();        
    var postData = { 
        'productList': 'yes',
        'product_id': productId
    };

    ajaxDataTableLoad(tableName, actionUrl, postData);

} //productDiscountListDatatable
productDiscountListDatatable();

function editDiscount(discountId){

    $("#discount_edit_modal").modal('show');

    // Load Data
    $.ajax({

        type: 'POST',
        url: ROOT_URL+'products/ajax/controller/viewProductController.php',
        data: {
            'discountId': discountId,
            'view_price_discount': 'yes',
        },
        dataType: 'json',
        success:function(res){
            $("#discountEditModalForm").html(res.formHtml);
        },
        error:function(err){
            console.log(err)
        }

    });

} //editDiscount

// Price Area
function displayProductPriceDetails(priceId){
    var priceId = priceId;
    $("#edit_product_price_id").val(priceId);
    var url = ROOT_URL+'products/ajax/controller/viewProductController.php';

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            'get_price_basic_details' : priceId
        },
        success:function(ret){
            $('#updateModalFormView').html(ret.formContainer);
        },
        error:function(err){
            console.log(err);
        }
    });

} //displayProductPriceDetails

// function displayDealerPriceDetails(priceId) {
//     var priceId = priceId;
//     $("#edit_product_price_id").val(priceId);
//     var url = ROOT_URL+'dealerAccount/products/ajax/controller/viewProductController.php';
//     dealer_id = 3;
//     $.ajax({
//         type: 'POST',
//         url: url,
//         dataType: 'json',
//         data: {
//             'dealer_id':dealer_id,
//             'get_dealer_price_details' : priceId
//         },
//         success:function(ret){
//             $('#updateModalFormView').html(ret.formContainer);
//         },
//         error:function(err){
//             console.log(err);
//         }
//     });
// }//displayDealerPriceDetails

function editPrice(priceId){
    $("#priceUpdateModal").modal('show');
    displayProductPriceDetails(priceId);
}


// Stock Update
function editStockQty(priceId){
    $("#price_edit_modal").modal('show');
    $("#add_new_product_price_id").val(priceId);
    displayPriceStockDetails();
}


function displayPriceStockDetails(){
    var priceId = $("#add_new_product_price_id").val();
    var url = ROOT_URL+'products/ajax/controller/viewProductController.php';

    $loading = $("#modal_stock_details_table");
    showDomLoading($loading);

    var tbody = $("#modal_stock_details_table_tbody");

    var singleTrClone = tbody.find('tr:first-child').clone();
    //remove all other Rows
    tbody.find('tr').remove();
    tbody.append(singleTrClone);

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            'get_price_min_stock_details' : priceId
        },
        success: function(ret){

            var stockDetailsArray = ret.stock_details;
            
            if(stockDetailsArray.length > 0){
                
                $.each(stockDetailsArray, function(key, index){
                    
                    var appendThis = tbody.find('tr:first-child').clone();
                    appendThis.find('.table_warehouse_name').text(index.warehouse);
                    appendThis.find('.product_single_qty_form').val(index.qty);
    
                    appendThis.find('.product_single_btn_update_form').val(index.stock_id);
                    appendThis.find('.product_single_btn_delete_form').attr( 'data-id',index.stock_id);
    
                    tbody.append(appendThis);

                });
                

            }else{
                // No stock were added show show some message
                var appendThis = tbody.find('tr:first-child').clone();
                appendThis.find('.table_warehouse_name').text('Please add some stock to update');
                appendThis.find('.product_single_qty_form').val(0);

                appendThis.find('.product_single_btn_update_form').val(0);
                appendThis.find('.product_single_btn_delete_form').val(0);

                tbody.append(appendThis);
            }

            
            // After clone done remove this 
            tbody.find('tr:first-child').remove();
            hideDomLoading($loading);

        },
        error:function(err){
            console.error(err);
            hideDomLoading($loading);
        }
    });

} //displayStockDetails

function updateProStock(e){

    var stockId = $(e).val();
    var url = ROOT_URL+'products/ajax/controller/updateProductController.php';
    var qty = $(e).parents('.product_single_qty_group_form').find('.product_single_qty_form').val();

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            'update_price_stock' : stockId,
            'qty' : qty
        },
        success:function(ret){
            console.log(ret);

            Notifications('Stock has been updated', 'success');

            var priceId = ret.price_id;
            displayPriceStockDetails(priceId);

        },//success
        error:function(err){
            console.log(err);
            Notifications('Failed to update the stock', 'error');
        } //error
    });

} //updateProStock


function changeProductVerification(e){


    var pId = $(e).val();
    var url = ROOT_URL+'products/ajax/controller/updateProductController.php';

    $.ajax({

        type: 'POST',
        url: url,
        data:{
            'id' : pId,
            'update_verification' : 'yes'
        },
        dataType: 'json',
        success:function(res){
            // console.log(res);
            if(res.result == 1){
                // Success msg
                // notifyMessage(res['message'],"Success", 1);
            }else{
                // failed message
                notifyMessage(res['message'],"Failed", 0);
            }
        },
        error:function(err){
            console.error(err);
            // Failed message
            notifyMessage("Failed to updated the product","Failed", 0);
        }

    });// ajax end 

} //changeProductVerification


function updateOneReference(e, productId){

    var refId = $(e).val();

    var url = ROOT_URL+'products/ajax/controller/updateProductController.php';

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            'refId' : refId,
            'productId' : productId,
            'update_pro_references' : 'yes',
        },
        success:function(ret){
            console.log(ret);

            showSuccessToast('Brand has been updated');

        },//success
        error:function(err){
            console.log(err);
            showDangerToast('Failed to update the Brand');
        } //error
    });


} //updateOneReference
