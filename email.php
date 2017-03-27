<?php

require 'libs/PHPMailer/PHPMailerAutoload.php';

function mail_only($mailto, $mailcc, $from_mail, $from_name, $replyto, $subject, $message) {
    $mail = new PHPMailer;
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'localhost';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = false; // Enable SMTP authentication
    $mail->Username = ''; // SMTP username
    $mail->Password = ''; // SMTP password
    // $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25; // TCP port to connect to

    $mail->setFrom($from_mail, $from_name);
    $mail->addAddress($mailto); // Add a recipient
    $mail->addReplyTo($replyto);
    $mail->addCC($mailcc);

    $mail->isHTML(false); // NOT HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    if(!$mail->send()) {
        return false;
    } else {
        return true;
    }      
}

function mail_attachment($filename, $path, $dispfilename, $mailto, $mailcc, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
    
    $mail = new PHPMailer;
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'localhost';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = false; // Enable SMTP authentication
    $mail->Username = ''; // SMTP username
    $mail->Password = ''; // SMTP password
    // $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25; // TCP port to connect to

    $mail->setFrom($from_mail, $from_name);
    $mail->addAddress($mailto); // Add a recipient
    $mail->addReplyTo($replyto);
    $mail->addCC($mailcc);

    $mail->addAttachment($file, $dispfilename); // Optional name
    $mail->isHTML(false); // NOT HTML

    $mail->Subject = $subject;
    $mail->Body    = $message;

    if(!$mail->send()) {
        return false;
    } else {
        return true;
    }  
}
?>