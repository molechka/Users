<?php
 

#Класс работы с почтой
class SMTPClient
{
function SMTPClient ( $to, $subject, $body)
{
$this->SmtpServer = NoiCore::app()->site_data['email_conf']['host'];
$this->SmtpUser = base64_encode (NoiCore::app()->site_data['email_conf']['login']);
$this->SmtpPass = base64_encode (NoiCore::app()->site_data['email_conf']['password']);
$this->from = NoiCore::app()->site_data['email_conf']['login'];
$this->to = $to;
$this->subject = $subject;
$this->body = $body;
$this->PortSMTP = 25;
}
function SendMail ()
{

//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
require PATH_TO_ENGINE.'/extensions/phpmailer/PHPMailerAutoload.php';
 
$mail             = new PHPMailer();
$mail->CharSet = 'utf-8';
$body             =$this->body;


$mail->IsSMTP(); // telling the class to use SMTP
$mail->IsHTML(true);
$mail->Host       = NoiCore::app()->site_data['email_conf']['host']; // SMTP server
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = NoiCore::app()->site_data['email_conf']['host']; // sets the SMTP server
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = NoiCore::app()->site_data['email_conf']['login']; // SMTP account username
$mail->Password   = NoiCore::app()->site_data['email_conf']['password'];        // SMTP account password

$mail->SetFrom(NoiCore::app()->site_data['email_conf']['login'], 'Robot '.$_SERVER['HTTP_HOST']);


$mail->Subject    = $this->subject;



$mail->MsgHTML($body);

$address = $this->to;
$mail->AddAddress($address, " ");



if(!$mail->Send()) {
 //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //echo "Message sent!";
}

}
}

?>