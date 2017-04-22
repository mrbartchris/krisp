<?php
date_default_timezone_set('Europe/Malta');
require 'PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer; 	//Create a new PHPMailer instance
$mail->isSMTP(); 		//Tell PHPMailer to use SMTP

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html'; 								//Ask for HTML-friendly debug output
$mail->Host = 'smtp.gmail.com';								//Set the hostname of the mail server
$mail->Port = 587;											//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission - 587 or 465
$mail->SMTPSecure = 'tls';									//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPAuth = true;										//Whether to use SMTP authentication
$mail->Username = "minikrisp@gmail.com";					//Username to use for SMTP authentication - use full email address for gmail
$mail->Password = 'pa$$word98';								//Password to use for SMTP authentication
$mail->setFrom('noreply@minikrisp.com', 'MINIKRISP');		//Set who the message is to be sent from
//$mail->addAddress('gfarrug@gmail.com', 'Gabriel Farrugia');	//Set who the message is to be sent to
$mail->addAddress($emailRec, '');
$mail->addReplyTo('noreply@krisp.com', 'mini krisp');		//Set an alternative reply-to address
$mail->Subject = 'MINIKRISP Invite';							//Set the subject line
//$mail->msgHTML(file_get_contents('mail/contents.html'), dirname(__FILE__));
$mail->msgHTML('<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset="utf-8">
  <title>MINIKRISP Invite</title>
</head>
<body>
<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 20px;">
  <h1>Someone sent you an invite!</h1>
  <div align="center">
    <a href="localhost/KrispFiles/?register">'.$usern.' invited you to join MINIKRISP!</a>
  </div>
  <p>This e-mail was sent using an automated system.<BR>Minikrisp Games</p>
</div>
</body>
</html>');
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

//$mail->AltBody = 'This is a plain-text message body';//Replace the plain text body with one created manually
//$mail->addAttachment('images/phpmailer_mini.png');//Attach an image file

$mail->smtpConnect(
    array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
        )
    )
);

if (!$mail->send()) { //send the message, check for errors
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
