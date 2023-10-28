function verifySerial(){
    serial_number = $('#serial_number').val();
    pro_id = $('#pro_id').val();
    // order_no = $('#order_no').val();
    var url = ROOT_URL+'account/ajax/controller/verifySerial.php';
    
    $.ajax({
        url : url,
        method : 'POST',
        dataType : 'json',
        data : { 
            'verify_serial':'yes',
            serial_number:serial_number,
            pro_id:pro_id  ,
            // order_no:order_no
        },
        success:function(ret){
            console.log(ret);
            if (ret.result == 1) {
                showSuccessToast(ret.message);
                // $('#detail-section').html(ret.option);
            }else{
                showDangerToast(ret.message)
            }
            setTimeout(function(){
                window.location = window.location;
            }, 5000);
        
        },
        error:function(err){
            showDangerToast(ret.message)
            console.log(err);
        }
    }); // ajax end
}

function fetchSerialProduct(){
    serial_number = $('#serial_number').val();
    var url = ROOT_URL+'account/ajax/controller/verifySerial.php';
    
    $.ajax({
        url : url,
        method : 'POST',
        dataType : 'json',
        data : { 
            'fetch_serial_products':'yes',
            serial_number:serial_number,
        },
        success:function(ret){
            console.log(ret);
            if (ret.result == 1) {
                $('#pro_name').html(ret.product);
                $("button.hide").removeClass("hide");
                // $("p.error_message").addClass("text-success");
                // $( "#button-verify" ).removeClass( "myClass yourClass" )
                // $('#button-verify').html('<button class="btn btn--lg btn--black" data-toggle="modal" type="button" data-target="#verifyModal">Verify</button>')
                $('#pro_id').val(ret.pro_id);
            }else{
                showDangerToast(ret.message)
            }
        },
        error:function(err){
            showDangerToast(err.message)
            console.log(err);
        }
    }); // ajax end
}

