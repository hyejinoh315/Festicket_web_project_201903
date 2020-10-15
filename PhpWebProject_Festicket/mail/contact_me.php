<?php
//// Check for empty fields
//if(empty($_POST['name'])      ||
//   empty($_POST['email'])     ||
//   empty($_POST['phone'])     ||
//   empty($_POST['message'])   ||
//   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
//   {
//   echo "No arguments Provided!";
//   return false;
//   }
//
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = "clia315@gmail.com"; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "※ $name 님이 FESTICKET에 의견을 보냈습니다 ※";
$email_body = "※ FESTICKET 의견함 ※\n\n"."Details:\n\n발신인: $name\n\nE-mail: $email_address\n\n전화번호: $phone\n\n내용:\n$message";
$headers = "From: $email_address";

mail($to,$email_subject,$email_body,$headers);