function orderListDatatable(){

    var tableName = 'orders_list_table';
    var actionUrl = $('#'+tableName).data('url');

    var subCategoryId = $("#sub_category_id").val();        
    var order_status = $('#order_status').val();
    var customer_type = $('#customer_type').val();
    var payment_status = $('#payment_status').val();
    var postData = { 
        'productList': 'yes',
        'order_status' : order_status,
        'customer_type' : customer_type,
        'payment_status' : payment_status,
    };

    ajaxDataTableLoad(tableName, actionUrl, postData);
}

orderListDatatable();

// change status
function changeStatus(e){

    var url = ROOT_URL+'orders/ajax/change_status.php';
    var status = $(e).val();
    var id = $(e).parents("tr").find(".order_id_row").data('value');

    $.ajax({
        url : url,
        method : 'POST',
        dataType : 'json',
        data : { order_status : status, id : id },
        success:function(ret){
            console.log(ret);
            if(ret['result'] == 1){
                // Notifications(ret.message, "success");
                showSuccessToast(ret.message);
                // dataTables();
            }else{
                // Notifications(ret.message, "danger");
                showDangerToast(ret.message)
                setTimeout(function(){
                    window.location = window.location;
                }, 1000);
            }
            
        },
        error:function(err){
            console.log(err);
        }
    }); // ajax end

} //changeStatus

function changePayment(e){

    var url = ROOT_URL+'orders/ajax/change_status.php';

    var status = $(e).val();
    var id = $(e).parents("tr").find(".order_id_row").data('value');

    $.ajax({
        url : url,
        method : 'POST',
        dataType : 'json',
        data : { payment_status : status, id : id },
        success:function(ret){
            if(ret['result'] == 1){
                // Notifications(ret.message, "success");
                showSuccessToast(ret.message);
                // dataTables();
            }else{
                // Notifications(ret.message, "danger");
                showDangerToast(ret.message)
                setTimeout(function(){
                    window.location = window.location;
                }, 1000);
            }
            
        }
    }); // ajax end

} // changePayment


// delete functions
function deleteorder(e){

    var url = ROOT_URL+'orders/ajax/delete_order.php';

    var orderNo = $(e).val();

    var row = $(e).parents("tr");

    $.confirm({
        title: 'Confirm! #'+orderNo,
        content: 'This action cannot be reversible!',
        buttons: {
            Delete: {
                text: 'Delete',
                btnClass: 'btn-green',
                keys: ['enter', 'shift'],
                action: function(){
                    
                    // Deleting actions
                    $.ajax({
                        url : url,
                        method : 'POST',
                        dataType: 'json',
                        data: { or_del_id : orderNo },
                        success:function(ret){
                            
                            if(ret.result == 1){
                                // success
                                row.remove();
                                $.confirm({

                                    title: 'Successful',
                                    theme: 'material',
                                    content: ret.message,
                                    autoClose: 'ok|1000'
                                    
                                });
                            }else{
                                // failed
                                $.confirm({

                                    title: 'Failed',
                                    theme: 'material',
                                    content: ret.message,
                                    autoClose: 'ok|2000'

                                });
                            }

                        }
                    });

                }
            },
            cancel: function () {
                backgroundDismiss: true // this will just close the modal
            }
        }
    });

}// deleteorder




function refund(e){


    var url = ROOT_URL+'orders/ajax/change_status.php';

    var orderNo = $(e).val();

    var row = $(e).parents("tr");

    var amount = $(e).data('amount');

    $.confirm({
        title: 'Confirm Refaund! #'+orderNo,
        content: 
            '<div class="form-group">' +
                '<label>Enter amount to refaund</label>' +
                '<input type="text" placeholder="Amount to refaund" id="refund_amt" value="'+amount+'" class="name form-control text-right" required />' +
            '</div>',
        buttons: {
            Delete: {
                text: 'Refaund',
                btnClass: 'btn-green',
                keys: ['enter', 'shift'],
                action: function(){
                    ref_amount = $('#refund_amt').val();
                    
                    // Refaunding actions
                    $.ajax({
                        url : url,
                        method : 'POST',
                        dataType: 'json',
                        data: { refund_id : orderNo, refaund_amount : ref_amount },
                        success:function(ret){
                            
                            if(ret.result == 1){

                                // dataTables();
                                // success
                                $.confirm({

                                    title: 'Successful',
                                    theme: 'material',
                                    content: ret.message
                                    // autoClose: 'ok|1000'
                                    
                                });
                            }else{
                                // failed
                                $.confirm({

                                    title: 'Failed',
                                    theme: 'material',
                                    content: ret.message
                                    // autoClose: 'ok|2000'

                                });
                            }

                        }
                    });

                }
            },
            cancel: function () {
                backgroundDismiss: true // this will just close the modal
            }
        }
    });



}// refund();


function searchSerial(){
    serial_number = $('#serial_number').val();
    order_no = $('#order_no').val();
    var url = ROOT_URL+'orders/ajax/verifySerial.php';

    $.ajax({
        url : url,
        method : 'POST',
        dataType : 'json',
        data : { 
            'search_serial_number':'yes',
            serial_number:serial_number,
            order_no:order_no  
        },
        success:function(ret){
            console.log(ret);
            // Notifications(ret.message, "danger");
            setTimeout(function(){
                window.location = window.location;
            }, 1000);
        
        },
        error:function(err){
            console.log(err);
        }
    }); // ajax end
    
}