<?php
header('Content-Type: text/html; charset=ISO-8859-1', TRUE);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/language/phpmailer.lang-pt_br.php';
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.live.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'arborizatuba@hotmail.com';                     // SMTP username
    $mail->Password   = 'arboriza123';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($mail->Username , 'Arborizatuba Contato');
    $mail->addAddress($mail->Username , 'Sistema Arborizatuba - Contato');   // Add a recipient
    $mail->AddReplyTo(filter_input(INPUT_GET, 'mail', FILTER_VALIDATE_EMAIL), filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING));

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject =  filter_input(INPUT_GET, 'subject', FILTER_SANITIZE_STRING);
    $mail->Body    =  filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);
    $mail->CharSet = "UTF-8";

    if ($mail->send()) {
    	$message = '<script>';
    		$message .= 'window.alert("Email enviado com sucesso");';
    		$message .= 'window.location.href="inicio/contato.html"';
    	$message .= '</script>';
    	print($message);
    } else {
    	$message = '<script>';
    		$message .= 'window.alert("Falha ao enviar o email");';
    	$message .= '</script>';
    	print($message);
    }
} catch (Exception $e) {
	echo "Falha ao enviar o email: {$mail->ErrorInfo}";
}