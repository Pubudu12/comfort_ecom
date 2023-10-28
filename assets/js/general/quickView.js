
function productQuickView(proId){

    var modalId = $("#quick-view");
    modalId.modal('show');

    var replaceHere = $("#quickViewModalDetails");
    replaceHere.html('');

    var fetchURL = ROOT_URL+'shopController/http/controller/quickViewController.php';
    var payloads = {
        'product_id' : proId,
        'quick_view' : 'yes',
    }

    $.ajax({
        type: 'POST',
        url: fetchURL,
        data: payloads,
        dataType: 'json',
        success:function(res) {
            replaceHere.html(res.container);
        },
        error:function(err) {
            console.error(err);
        }
    })

} //productQuickView()