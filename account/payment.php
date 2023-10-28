<?php 
require_once '../app/global/url.php'; 
include ROOT_PATH.'/app/global/sessions.php';
include ROOT_PATH.'/app/global/Gvariables.php';
include ROOT_PATH.'/db/db.php';

$order_no = 0;
if(isset($_GET['order_no'])){
    $order_no = $_GET['order_no'];
}
?>

        <html>
    <head>

    <input type="hidden" name="order_no" id="order_no" value="<?php echo $order_no ?>" >
    <?php require_once ROOT_PATH.'imports/js.php' ?>
        
        <script src="https://cbcmpgs.gateway.mastercard.com/checkout/version/57/checkout.js"
                data-error="errorCallback"
                data-cancel="cancelCallback">
        </script>
        <script type="text/javascript">
                    function errorCallback(error) {
                        console.log(JSON.stringify(error));
                    }
                    function cancelCallback() {
                        console.log('Payment cancelled');
                        window.location.href = ROOT_URL+"checkout";
                    }

                    function makePayment(){
                        // alert();
                        var orderId = $("#order_no").val();
                        $.ajax({
                            url: ROOT_URL+'account/class/paymentController.php',
                            type: 'POST',
                            data: {
                                'make_payment' : 'yes',
                                'orderid' : orderId,
                            },
                            dataType: 'json',
                            success:function(res){

                                if(res.result == 1){

                                    var sessionId = res.session_id;
                                    var amount = res.amount;
                                    var orderid = res.orderid;

                                    Checkout.configure({
                                        
                                        session: { 
                                            id: sessionId
                                        },
                                        order: {
                                            amount: amount,
                                            currency: 'LKR',
                                            description: 'Comfort world invoice',
                                            id: orderid
                                        },
                                        interaction: {
                                            merchant: {
                                                name: ' COMFORT WORLD INTERNATIONAL (PVT) LTD',
                                                address: {
                                                    // line1: '200 Sample St',
                                                    // line2: '1234 Example Town'
                                                }
                                            },
                                            displayControl : {
                                                billingAddress: 'HIDE', 
                                                customerEmail : 'OPTIONAL',
                                                orderSummary : 'SHOW',
                                                shipping : 'HIDE'
                                            },
                                        },
                                    });

                                    Checkout.showPaymentPage()

                                }else{
                                    // Redirect to the failed page

                                }

                            },
                            error:function(err){
                                console.log(err)
                                // Redirect to invoice page with 
                            }
                        })

                    } //makePayment

                    makePayment();

                    

        </script>
    </head>
    <body>
        <!-- Click one of below buttons to start payment process…
        <input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
        <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();"/> -->

    </body>
</html>