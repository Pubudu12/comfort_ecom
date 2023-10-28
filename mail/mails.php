<?php
// include_once '../app/global/url.php';
// include_once ROOT_PATH.'/app/global/sessions.php';
// include_once ROOT_PATH.'/app/global/Gvariables.php';
// include_once ROOT_PATH.'/db/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ROOT_PATH.'mail/vendors/phpmailer/src/Exception.php';
require ROOT_PATH.'mail/vendors/phpmailer/src/PHPMailer.php';
require ROOT_PATH.'mail/vendors/phpmailer/src/SMTP.php';


class Emails{

    public $phpMailer;
    public $fromEmailAddress = 'mail@domain.com';

    public function __construct($phpMailer){
      $this->phpMailer = $phpMailer;
    } // constructor


    private function send(){

      $result = 0;
      $message = "Failed to send mail";

      //Server settings
      try {
        $this->phpMailer->send();
        
        $result = 1;
        $message = "Mail has been sent successfully";

      } catch (Exception $e) {

        $message = $this->phpMailer->ErrorInfo;

      }

      return array('result' => $result, 'message' => $message);

    }

    // protected function setMailConfiguration($mailDetails){

    //   // TO,Title, CC, BCC, Replay_to, Subject, Body

    //   $to = $mailDetails['to']; // Array
    //   $title = $mailDetails['title'];
      
    //   $cc = $mailDetails['cc']; // Array
    //   $bcc = $mailDetails['bcc']; // Array
    //   $reply_to = $mailDetails['reply_to']; // Single

    //   $subject = $mailDetails['subject'];
    //   $body = $mailDetails['body'];


    //   // $this->phpMailer->IsSMTP();
    //   $this->phpMailer->CharSet = 'UTF-8';

    //   // $this->phpMailer->Host = 'mail.goodsale.lk';// Specify main and backup server
    //   // $this->phpMailer->SMTPAuth = true;// Enable SMTP authentication
    //   // $this->phpMailer->Username = 'info@goodsale.lk';// SMTP username
    //   // $this->phpMailer->Password = 'saleiro123';// SMTP password
    //   // $this->phpMailer->SMTPSecure = 'ssl';// Enable encryption, 'ssl' also accepted
    //   // $this->phpMailer->Port       = 465; 

    //   $this->phpMailer->setFrom($this->fromEmailAddress, $title);

    //   foreach($to as $value){
    //     $this->phpMailer->addAddress($value);// Add a recipient
    //   }
      
    //   if(count($cc) > 0){
    //     foreach($cc as $value){
    //       $this->phpMailer->addCC($value);
    //     }
    //   }

    //   if(count($bcc) > 0){
    //     foreach($bcc as $value){
    //       $this->phpMailer->addBCC($value);
    //     }
    //   }
      
    //   $this->phpMailer->addReplyTo($reply_to);

    //   //Content
    //   $this->phpMailer->isHTML(true);
    //   $this->phpMailer->Subject = $subject;
    //   $this->phpMailer->Body    = $body;
    //   // $this->phpMailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //   return $this->send();

    // } //setMailObjects

    protected function setMailConfiguration($mailDetails){

      // TO,Title, CC, BCC, Replay_to, Subject, Body

      $to = $mailDetails['to']; // Array
      $title = $mailDetails['title'];
      
      $cc = $mailDetails['cc']; // Array
      $bcc = $mailDetails['bcc']; // Array
      $reply_to = $mailDetails['reply_to']; // Single

      $subject = $mailDetails['subject'];
      $body = $mailDetails['body'];


      $this->phpMailer->IsSMTP();
      $this->phpMailer->CharSet = 'UTF-8';

      
      $this->phpMailer->SMTPDebug = false;
      $this->phpMailer->Host = 'creativehub.website';// Specify main and backup server
      $this->phpMailer->SMTPAuth = true;// Enable SMTP authentication
      $this->phpMailer->Username = 'server@creativehub.website';// SMTP username
      $this->phpMailer->Password = 'eb6oeWfHXv;L';// SMTP password
      $this->phpMailer->SMTPSecure = 'ssl';// Enable encryption, 'ssl' also accepted
      $this->phpMailer->Port       = 465;
      
      $this->phpMailer->smtpConnect(
        array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        )
    );

    if (isset($mailDetails['from'])) {
      $this->phpMailer->setFrom($mailDetails['from'], $title);
    } else {
      $this->phpMailer->setFrom($this->fromEmailAddress, $title);
    }
    
      // $this->phpMailer->setFrom($this->fromEmailAddress, $title);

      foreach($to as $value){
        $this->phpMailer->addAddress($value);// Add a recipient
      }
      
      if(count($cc) > 0){
        foreach($cc as $value){
          $this->phpMailer->addCC($value);
        }
      }

      if(count($bcc) > 0){
        foreach($bcc as $value){
          $this->phpMailer->addBCC($value);
        }
      }
      
      $this->phpMailer->addReplyTo($reply_to);

     //Content
      $this->phpMailer->isHTML(true);
      $this->phpMailer->Subject = $subject;
      // $this->phpMailer->Body    = $body;
      $this->phpMailer->MsgHTML($body);
      // $this->phpMailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
      // echo $body;
      return $this->send();

    } //setMailObjects



} // End Emails Class

class eCommerceMail extends Emails{

  public $localhost;

  public $defaultToAddress = 'info@domain.lk';

  public function __construct($localhost){
    $this->localhost = $localhost;
  }//Constructor


  public function registrationTemplate(){

    $template = file_get_contents(ROOT_PATH.'mail/templates/registration/tem.html');

    $template = str_replace('{{ FB_IMG }}', URL.'mail/templates/registration/images/facebook2x.png', $template);
    $template = str_replace('{{ INSTA_IMG }}', URL.'mail/templates/registration/images/instagram2x.png', $template);
    $template = str_replace('{{ SHOP_LINK }}', URL.'shop', $template);
    $template = str_replace('{{ MY_ACC_LINK }}', URL.'my_account', $template);
    $template = str_replace('{{ LOGO_IMG }}', URL.'assets/img/logo/logo-sm-Copy.png', $template);
    $template = str_replace('{{ WELCOME_IMG }}', URL.'mail/templates/registration/images/illo_welcome_1.png', $template);
    
    return $template;

  } //registrationTemplate


  public function passwordResetTemplate($details){

    $template = file_get_contents(ROOT_PATH.'mail/templates/resetPassword/tem.html');

    $template = str_replace('{{ FB_IMG }}', URL.'mail/templates/resetPassword/images/facebook2x.png', $template);
    $template = str_replace('{{ INSTA_IMG }}', URL.'mail/templates/resetPassword/images/instagram2x.png', $template);
    $template = str_replace('{{ PASSWORD_LINK }}', $details['link'], $template);
    $template = str_replace('{{ LOGO_IMG }}', URL.'assets/img/logo/logo-sm-Copy.png', $template);
    $template = str_replace('{{ WELCOME_IMG }}', URL.'mail/templates/resetPassword/images/illo_welcome_1.png', $template);
    
    return $template;

  } //registrationTemplate


  public function registration($user_id){

    $select = mysqli_query($this->localhost, "SELECT `name`,`email` FROM `users` WHERE `id`='$user_id' ");
    $fetch = mysqli_fetch_array($select);

    $username = $fetch['name'];
    $useremail = $fetch['email'];

    $body = $this->registrationTemplate();
    $body = str_replace('{{ USERNAME }}', strtoupper($username), $body);

    $title = 'Welcome '.$username.' | Comfort World Online Shopping';
    $subject = 'Registration Successfull';

    $to = array($useremail);
    $cc = array();
    $bcc = array();
    $reply_to = $this->fromEmailAddress;

    $maildetails = array('subject'=>$subject,'body'=>$body,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);
    // print_r($maildetails);
    return $this->setMailConfiguration($maildetails);

  } //registration()


  public function sendPasswordResetMail($details){
    $email = $details['email'];
    $returnArray = array('result'=>0,'message'=>'Mail is not sent!');
    $select = mysqli_query($this->localhost, "SELECT `id`,`name` FROM `users` WHERE `email`='$email' ");
    if (mysqli_num_rows($select) > 0 ) {
      $fetch = mysqli_fetch_array($select);
      
      $name = $fetch['name'];

      $body = $this->passwordResetTemplate($details);
      $body = str_replace('{{ USERNAME }}', strtoupper($name), $body);

      $title = 'Welcome to Comfort World Online Shopping';
      $subject = 'Reset Password';

      $to = array($email);
      $cc = array();
      $bcc = array();
      $reply_to = $this->fromEmailAddress;

      $maildetails = array('subject'=>$subject,'body'=>$body,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);
      // print_r($maildetails);
      $returnArray = $this->setMailConfiguration($maildetails);
    }
    
    return $returnArray;
  }//sendPasswordResetMail


  // InvoiceTemplate
  public function invoiceTemplate(){

    $template = file_get_contents(ROOT_PATH.'mail/templates/invoice/temp.html');

    $template = str_replace('{{ LOGO_IMG }}', URL.'assets/img/logo/logo-sm-Copy.png', $template);
    $template = str_replace('{{ CHECK_IMG }}', URL.'mail/templates/invoice/images/ecommerce-template_order-confirmed-icon.jpg', $template);
    $template = str_replace('{{ YEAR }}', Date("Y"), $template);

    return $template;

  } ///invoiceTemplate

    // enquireTemlate
    public function enquireTemplate($maildetails){

      $template = file_get_contents(ROOT_PATH.'mail/templates/inquire/temp.html');
  
      $template = str_replace('{{ DATE }}', $maildetails['date'], $template);
      $template = str_replace('{{ TIME }}', $maildetails['time'], $template);

      $template = str_replace('{{ LOGO_IMG }}', URL.'mail/templates/inquire/images/image-4.png', $template);
      $template = str_replace('{{ FB_IMG }}', URL.'mail/templates/inquire/images/image-1.png', $template);
      $template = str_replace('{{ INSTA_IMG }}', URL.'mail/templates/inquire/images/image-3.png', $template);
      $template = str_replace('{{ LINKEDIN_IMG }}', URL.'mail/templates/inquire/images/image-2.png', $template);
      $template = str_replace('{{ YEAR }}', Date("Y"), $template);

      $template = str_replace('{{ NAME }}', $maildetails['name'], $template);
      $template = str_replace('{{ MESSAGE }}', $maildetails['message'], $template);
      $template = str_replace('{{ TERMS }}', URL.'terms', $template);

      return $template;
  
    } ///enquireTemlate


    // customPricerequestTemlate
    public function requestCustomPriceTemplate($maildetails){
      $pro_id = $maildetails['pro_id'];
      $select = mysqli_query($this->localhost,"SELECT `name`
                                                    FROM `products` 
                                                    WHERE `id`='$pro_id' ");
      $fetch = mysqli_fetch_array($select);

      $template = file_get_contents(ROOT_PATH.'mail/templates/customSizeInquire/temp.html');
      $templateMailContent = file_get_contents(ROOT_PATH.'mail/templates/customSizeInquire/mailContent.html');
  
      $template = str_replace('{{ LOGO_IMG }}', URL.'mail/templates/inquire/images/image-4.png', $template);
      $template = str_replace('{{ FB_IMG }}', URL.'mail/templates/inquire/images/image-1.png', $template);
      $template = str_replace('{{ INSTA_IMG }}', URL.'mail/templates/inquire/images/image-3.png', $template);
      $template = str_replace('{{ LINKEDIN_IMG }}', URL.'mail/templates/inquire/images/image-2.png', $template);
      $template = str_replace('{{ YEAR }}', Date("Y"), $template);
      $template = str_replace('{{ TERMS }}', URL.'terms', $template);

      $template = str_replace('{{ NAME }}', $maildetails['name'], $template);
      $template = str_replace('{{ CUSTOM_WIDTH }}', $maildetails['requested_width'], $template);
      $template = str_replace('{{ CUSTOM_LENGTH }}', $maildetails['requested_length'], $template);
      $template = str_replace('{{ CUSTOM_HEIGHT }}', $maildetails['requested_height'], $template);
      $template = str_replace('{{ PRODUCT_NAME }}', $fetch['name'], $template);
      $template = str_replace('{{ MESSAGE }}', $maildetails['message'], $template);
  
      $template = str_replace('{{ MAIL_CONTENT }}', $templateMailContent, $template);
      return $template;
  
    } ///customPricerequestTemlate

  public function invoiceProductsListTemplate($orderItemsDetails){

    $listOfItems = '';

    $template = file_get_contents(ROOT_PATH.'mail/templates/invoice/temp_products_list.html');

    foreach ($orderItemsDetails as $key => $itemsInner) {
      $tempTemplate = $template;

      $tempTemplate = str_replace('{{ NAME }}', $itemsInner['name'], $tempTemplate);
      $tempTemplate = str_replace('{{ QTY }}', $itemsInner['qty'], $tempTemplate);
      $tempTemplate = str_replace('{{ PRO_LINK }}', $itemsInner['pro_url'], $tempTemplate);
      $tempTemplate = str_replace('{{ PRICE }}', CURRENCY.' '.$itemsInner['total'], $tempTemplate);

      $listOfItems .= $tempTemplate;

    } //

    return $listOfItems;

  } //invoiceProductsListTemplate

  public function invoiceSummaryListTemplate($orderSummary){


    $listOfItems = '';

    $template = file_get_contents(ROOT_PATH.'mail/templates/invoice/temp_summary_list.html');

    foreach ($orderSummary as $key => $value) {
      $tempTemplate = $template;

      $tempTemplate = str_replace('{{ TITLE }}', $key, $tempTemplate);
      $tempTemplate = str_replace('{{ AMOUNT }}', CURRENCY.' '.$value, $tempTemplate);

      $listOfItems .= $tempTemplate;

    } //

    return $listOfItems;


  } //invoiceSummaryListTemplate

   // enquireTemlate
   public function contactUsTemplate($maildetails){

    $template = file_get_contents(ROOT_PATH.'mail/templates/contactUsMail/temp.html');
    $templateMailContent = file_get_contents(ROOT_PATH.'mail/templates/contactUsMail/mailContent.html');

    $template = str_replace('{{ LOGO_IMG }}', URL.'mail/templates/contactUsMail/images/image-4.png', $template);
    $template = str_replace('{{ FB_IMG }}', URL.'mail/templates/contactUsMail/images/image-1.png', $template);
    $template = str_replace('{{ INSTA_IMG }}', URL.'mail/templates/contactUsMail/images/image-3.png', $template);
    $template = str_replace('{{ LINKEDIN_IMG }}', URL.'mail/templates/contactUsMail/images/image-2.png', $template);
    $template = str_replace('{{ YEAR }}', Date("Y"), $template);

    $template = str_replace('{{ NAME }}', $maildetails['name'], $template);
    $template = str_replace('{{ MESSAGE }}', $maildetails['message'], $template);
    $template = str_replace('{{ TERMS }}', URL.'terms', $template);
    // $template = str_replace('{{ NAME }}', $maildetails['name'], $template);

    // $templateMailContent = str_replace('{{ NAME }}', $maildetails['name'], $templateMailContent);
    // $templateMailContent = str_replace('{{ MESSAGE }}', $maildetails['message'], $templateMailContent);

    // $template = str_replace('{{ MAIL_CONTENT }}', $templateMailContent, $template);
    return $template;

  } ///contactUsTemplate

  public function sendContactUsMail($details){

    $title = 'Comfort World Online Shopping';
    $subject = $details['subject'];

    $inner_mail_details = array('name'=>$details['name'],'message'=>$details['message']);
    $template = $this->contactUsTemplate($inner_mail_details);

    $user_email = $details['email'];
    $to = array($this->defaultToAddress);
    $cc = array($this->defaultToAddress);
    $bcc = array();
    $reply_to = $this->defaultToAddress;

    $maildetails = array('subject'=>$subject,'body'=>$template,'from'=>$user_email,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);

    // print_r($maildetails);
    return $this->setMailConfiguration($maildetails);
    
  } //sendContactUsMail


  public function sendEnquire($details){

    $title = 'Comfort World Online Shopping';
    $subject = 'Enquire';

    $inner_mail_details = array('name'=>$details['name'],'date'=>$details['date'],'time'=>$details['time'],'message'=>$details['message']);
    $template = $this->enquireTemplate($inner_mail_details);

    $user_email = $details['email'];
    $to = array($this->defaultToAddress);
    $cc = array($this->defaultToAddress);
    $bcc = array();
    $reply_to = $this->defaultToAddress;

    $maildetails = array('subject'=>$subject,'body'=>$template,'from'=>$user_email,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);

    // print_r($maildetails);
    return $this->setMailConfiguration($maildetails);
    
  } //sendEnquire

  public function sendCustomSizeRequest($details){

    $title = 'Comfort World Online Shopping';
    $subject = 'Request For a Custom Size';

    $inner_mail_details = array('name'=>$details['name'],'pro_id'=>$details['pro_id'],'requested_width'=>$details['requested_width'],'requested_length'=>$details['requested_length'],'requested_height'=>$details['requested_height'],'message'=>$details['message']);
    $template = $this->requestCustomPriceTemplate($inner_mail_details);

    $user_email = $details['email'];
    $to = array($this->defaultToAddress);
    $cc = array($this->defaultToAddress);
    $bcc = array();
    $reply_to = $this->defaultToAddress;

    $maildetails = array('subject'=>$subject,'body'=>$template,'from'=>$user_email,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);

    return $this->setMailConfiguration($maildetails);
    
  } //invoice


  public function sendCashOnDeliveryMail($orderNo){

    $title = 'Comfort World Online Shopping';
    $subject = 'Request For a Cash On Delivery';

    $this->invoice($orderNo);

    $select_order = mysqli_query($this->localhost,"SELECT o.*,dd.*
                                                    FROM `orders` o 
                                                    INNER JOIN `delivery_details` AS dd ON dd.`order_no` = o.`order_no` 
                                                    WHERE o.`order_no`='$orderNo' ");
    $fetch_order = mysqli_fetch_array($select_order);

    $user_name = $fetch_order['name'];
    $user_email = $fetch_order['email'];

    $inner_mail_details = array('name'=>$user_name,'mobile'=>$fetch_order['mobile_no'],'door_no'=>$fetch_order['door_no'],'city'=>$fetch_order['city'],'district'=>$fetch_order['district'],'state'=>$fetch_order['state']);
    
    $template = file_get_contents(ROOT_PATH.'mail/templates/cashDeliveryMail/temp.html');

    $template = str_replace('{{ LOGO_IMG }}', URL.'mail/templates/cashDeliveryMail/images/image-4.png', $template);
    $template = str_replace('{{ FB_IMG }}', URL.'mail/templates/cashDeliveryMail/images/image-1.png', $template);
    $template = str_replace('{{ INSTA_IMG }}', URL.'mail/templates/cashDeliveryMail/images/image-3.png', $template);
    $template = str_replace('{{ LINKEDIN_IMG }}', URL.'mail/templates/cashDeliveryMail/images/image-2.png', $template);
    $template = str_replace('{{ YEAR }}', Date("Y"), $template);
    $template = str_replace('{{ TERMS }}', URL.'terms', $template);    

    $template = str_replace('{{ NAME }}', $user_name, $template);
    $template = str_replace('{{ ORDER_NO }}', $orderNo, $template);
    $template = str_replace('{{ MOBILE }}', $fetch_order['mobile_no'], $template);
    $template = str_replace('{{ DOOR_NO }}', $fetch_order['door_no'], $template);
    $template = str_replace('{{ CITY }}', $fetch_order['city'], $template);
    $template = str_replace('{{ DISTRICT }}', $fetch_order['district'], $template);
    $template = str_replace('{{ STATE }}', $fetch_order['state'], $template);
    $template = str_replace('{{ ZIP }}', $fetch_order['zip_code'], $template); 

    $user_email = $user_email;
    $to = array($this->defaultToAddress);
    $cc = array($this->defaultToAddress);
    $bcc = array();
    $reply_to = $this->defaultToAddress;

    $maildetails = array('subject'=>$subject,'body'=>$template,'from'=>$user_email,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);

    return $this->setMailConfiguration($maildetails);

  }//sendCashOnDeliveryMail


  public function invoice($orderNo){

    $template = $this->invoiceTemplate();
    

    $select_order = mysqli_query($this->localhost,"SELECT o.*,dd.*
                                      FROM `orders` o 
                                      INNER JOIN `delivery_details` AS dd ON dd.`order_no` = o.`order_no` 
                                      WHERE o.`order_no`='$orderNo' ");

    $fetch_order = mysqli_fetch_array($select_order);

    $user_name = $fetch_order['name'];
    $user_email = $fetch_order['email'];

    $invoiceLink = URL.'view_order?email='.$user_email.'&order_no='.$orderNo;

    $template = str_replace('{{ INVOICE_DATE }}', Date("M d, Y"), $template);
    $template = str_replace('{{ ORDER_NO }}', $orderNo, $template);
    $template = str_replace('{{ NAME }}', $user_name, $template);
    $template = str_replace('{{ INVOICE_LINK }}', $invoiceLink, $template);

    $orderItemsDetails = array();
    $select_products = mysqli_query($this->localhost,"SELECT oi.*,p.`name`,p.`id` product_id
                                        FROM `order_items` oi 
                                        INNER JOIN `products` p ON p.`id`=oi.`product_id`
                                        WHERE oi.`order_no`='$orderNo' ");

    while($fetch_products = mysqli_fetch_array($select_products)){

        array_push($orderItemsDetails, array(
            'name' => $fetch_products['name'],
            'pro_url' => URL.'product?q='.$fetch_products['product_id'].'&product='.urlencode(strtolower(trim($fetch_products['name']))),
            'qty' => $fetch_products['qty'],
            'total' => number_format($fetch_products['amount'],2)
        ));

    } // While

    $products_list = $this->invoiceProductsListTemplate($orderItemsDetails);


    $orderSummary = array();
    if( $fetch_order['delivery_charges'] > 0){
        $orderSummary['Cart total'] = number_format($fetch_order['cart_total'],2);
        $orderSummary['Shipping'] = number_format($fetch_order['delivery_charges'],2);
    }

    $orderSummary['Total'] = number_format($fetch_order['total'], 2);
    
    if( $fetch_order['payment'] > 0){ 
        $orderSummary['Paid'] = $fetch_order['payment'];
    }

    if($fetch_order['refaund_amount'] > 0){ 
        $orderSummary['Refunded'] = $fetch_order['refaund_amount'];
    }

    $summary_list = $this->invoiceSummaryListTemplate($orderSummary);

    $template = str_replace('{{ PRODUCTS_LIST }}', $products_list, $template);
    $template = str_replace('{{ SUMMARY_LIST }}', $summary_list, $template);
    
    $body = $template;

    $title = 'Order '.$orderNo.' Confirmation | Comfort World Online Shopping';
    $subject = 'Order Confirmation';

    $to = array($user_email);
    $cc = array();
    $bcc = array();
    $reply_to = $this->fromEmailAddress;

    $maildetails = array('subject'=>$subject,'body'=>$body,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);

    return $this->setMailConfiguration($maildetails);
    

  } //invoice

  // public function sendEnquiryMail($config){

  //   $this->config = $config;

  //   $message = $this->config['message'];

  //   // Sedn mail to ADMIN
  //   $to = array('rest@comfortwi.lk');
  //   $cc = array();
  //   $bcc = array();
  //   // $reply_to = Emails::$replyEmail;
  //   $title = 'Website Enquiry';
  //   $subject = 'Comfort World Shop Website Enquiry';
  //   $body = $message;

  //   $this->maildetails = array('subject'=>$subject,'body'=>$body,'to'=>$to,'cc'=>$cc,'bcc'=>$bcc,'title'=>$title,'reply_to'=>$reply_to);
  //   // $mes = Emails::configureMail($this->maildetails,"info");
  //   return $this->setMailConfiguration($this->maildetails);

  //   // return $mes;

  // } //sendEnquiryMail

} // class end

$phpMailer = new PHPMailer(true);

$eCommerceMailObj = new eCommerceMail($localhost);
$eCommerceMailObj->phpMailer = $phpMailer;
$eCommerceMailObj->fromEmailAddress = 'maalik@comfortwi.lk';
$eCommerceMailObj->defaultToAddress = 'maalik@comfortwi.lk';

// $registrationMail = $eCommerceMailObj->registration(2);maalik@comfortwi.lk
// $invoiceMail = $eCommerceMailObj->invoice(102425);rest@comfortwi.lk


?>