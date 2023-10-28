<?php

if($_SERVER['REQUEST_METHOD']){
	

	if(isset($_POST['email'])){
		

		$result = 0;

		if(!isset($_POST['token'])){
			echo '<h2>Please check the the captcha form.</h2>';
			exit;
		}

		$captcha = $_POST['token'];

		$secretKey = "6Le5QZkaAAAAAAIn0niPjMh7OyCTpH1prQ162Wa3";
		$ip = $_SERVER['REMOTE_ADDR'];

		// post request to server
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array('secret' => $secretKey, 'response' => $captcha);

		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$response = file_get_contents($url, false, $context);
		$responseKeys = json_decode($response,true);
		header('Content-type: application/json');
		if($responseKeys["success"]) {
			// Success

			$to = "pubudu.creativehub@gmail.com";
			$from = $_REQUEST['email'];
			$name = $_REQUEST['name'];
			$csubject = $_REQUEST['subject'];
			$cmessage = $_REQUEST['message'];

			$headers = "From: $from";
			$headers = "From: " . $from . "\r\n";
			$headers .= "Reply-To: ". $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$subject = "You have received enquiry from VW Shipping Website.";

			$logo = '#';

			$body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Website Enquiry Mail</title></head><body>";
			$body .= "<table style='width: 100%;'>";
			$body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'><a href='#'><img src='{$logo}' alt=''></a></td></tr></thead><tbody>";
			$body .= "<tr><td style='border:none;'>{$name}</td><td style='border:none;'>Sender: {$from}</td></tr>";
			$body .= "<tr><td></td></tr>";
			$body .= "<tr><td style='border:none;'>{$cmessage}</td></tr>";
			$body .= "</tbody></table>";
			$body .= "<p>FROM WEBSITE Comfort World.com</p>";
			$body .= "</body></html>";

			if($send = mail($to, $subject, $body, $headers)){
				$result = 1;
			}
		}

		echo json_encode(array('result'=>$result));
	}
    
}

?>