<?php
class PaymentClass{

    // private $merchant = 'TESTCOMFORTNOLKR'; 
    // private $apiUsername = 'merchant.TESTCOMFORTNOLKR';
    // private $apiPassword = 'dd09640e2ae2c0693cfbf7ec1a23323b';

    
    private $merchant = 'COMFORTNOLKR';
    private $apiUsername = 'merchant.COMFORTNOLKR';
    private $apiPassword = 'dd6dedd8867092fc1a5cbeb92b43855d';

    private $return_url = URL.'payment/status';

    private $currency = 'LKR';
    
    private $order_id, $amount;

    private $localhost;


    private function updateTheInvoicePaymentStatus($orderId, $onlyChck = true){
        
        $result = 0;
        $query = "SELECT `order_no`, `total`, `payment` FROM `orders` o  WHERE o.`order_no`='$orderId' ";
        $select = mysqli_query($this->localhost, $query);
        if(mysqli_num_rows($select) > 0){
            
            $fetch = mysqli_fetch_array($select);
            $total = $fetch['total'];
            $payment = $fetch['payment'];
            $balance = $total - $payment;
        
            if($onlyChck){
            
                if($balance == 0){
                    $result = 1;
                }
    
            }else{
    
                $paymentDate = Date("Y-m-d");
                $update = mysqli_query($this->localhost, "UPDATE `orders` SET `payment`='$total', `payment_date`='$paymentDate', `payment_method`='card' WHERE `order_no`='$orderId' ");
                if($update){
                    $result = 1;
                }
    
            }

        }

        return $result;

        

    }//updateTheInvoicePaymentStatus

    public function response($resultIndicator, $orderId, $localhost){
        $this->localhost = $localhost;

        $paymentData = $this->getSession();

        if($resultIndicator == $paymentData->successIndicator){
            // Both are same
            // Payment Success
            // Update the Order
            $result = $this->updateTheInvoicePaymentStatus($orderId, false);

        }else{
            // Payment Failure
            // Already Updated or First time checking
            $result = $this->updateTheInvoicePaymentStatus($orderId, true);

        }


        if($result == 1){
            return [
                'result' => 1,
                'message' => 'Your payment has been received successfully',

            ];
        }else{
            return [
                'result' => 0,
                'message' => 'Payment transaction failure',

            ];
        }
        
    }

    public function setSession($sessionValue){

        $session_name = 'successIndicators';
        $sessionValue = json_encode($sessionValue);
        $_SESSION[$session_name] = $sessionValue;
    }

    public function getSession($sessionName = 'successIndicators'){

        $sessionValue = null;
        if(isset($_SESSION[$sessionName])) {
            
            $sessionValue = json_decode($_SESSION[$sessionName]);
        }

        return $sessionValue;
    }

    private function process(){


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cbcmpgs.gateway.mastercard.com/api/nvp/version/57',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'apiOperation=CREATE_CHECKOUT_SESSION&apiPassword='.$this->apiPassword.'&apiUsername='.$this->apiUsername.'&merchant='.$this->merchant.'&interaction.operation=PURCHASE&order.id='.$this->order_id.'&order.amount='.$this->amount.'&order.currency='.$this->currency.'&interaction.returnUrl='.$this->return_url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
            ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
        

    }

    public function request($data){

        $this->order_id = $data['order_id'];
        $this->amount = $data['amount'];
        $this->return_url = $this->return_url.'?order_no='.$this->order_id;

        // $response = 'merchant=TESTCOMFORTNOLKR&result=SUCCESS&session.id=SESSION0002663432544J37502155E8&session.updateStatus=SUCCESS&session.version=bbdb1a4601&successIndicator=7427021aeab74c15';
        // $response = 'error.cause=INVALID_REQUEST&error.explanation=Authenticated+entity+not+authorised+to+perform+operation+for+target+entity&result=ERROR'; 
        
        $response = $this->process();
        parse_str($response, $responseArray);

        // echo "<br>";
        // print_r($responseArray);

        $resultArray = array(
            'result' => 0,
            'message' => 'Failed to process the payment session',
        );

        if(isset($responseArray['result'])){

            if($responseArray['result'] == 'SUCCESS' ){
                // Create Session Success
                $resultArray['result'] = 1;

                $resultArray['message'] = 'Session has been created';
                $resultArray['amount'] = $this->amount;
                $resultArray['orderid'] = $this->order_id;

                $resultArray['session_id'] = $responseArray['session_id'];
                $resultArray['session_version'] = $responseArray['session_version'];
                $resultArray['successIndicator'] = $responseArray['successIndicator'];

                $this->setSession([
                    'session_id' => $responseArray['session_id'],
                    'session_version' => $responseArray['session_version'],
                    'successIndicator' => $responseArray['successIndicator'],
                ]);

            }else if($responseArray['result'] == 'ERROR' ){
                $resultArray['error_msg'] = $responseArray['error_explanation'];
                $resultArray['error_cause'] = $responseArray['error_cause'];
            }

        } // IF end

        return $resultArray;

    }

}

$paymentObj = new PaymentClass;
// $paymentObj->request(['order_id'=>rand(), 'amount' => rand()]);

?>