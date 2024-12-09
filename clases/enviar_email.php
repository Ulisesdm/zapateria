<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = MAIL_HOST;                  //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = MAIL_USER;                     //SMTP username
    $mail->Password   = MAIL_PASS;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = MAIL_PORT;                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(MAIL_USER, 'Zapateria Adonay');
    $mail->addAddress('aleemenera28@gmail.com', 'Contacto Zapatería Adonay');     //Add a recipient
    
    //Para mandar imágenes
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalles de su compra';
    $cuerpo = '<h4>¡Gracias por comprar en Zapatería Adonay!</h4>';
    $cuerpo .= '<p>El id de su compra es <b>'. $id_transaccion .'<b/></p>';
    $cuerpo = '<p>No olvides que puedes ver el detalle de la compra desde tu cuenta.</p>';
    $cuerpo ='<p>¡Te avisaremos cuando tu pedido esté listo para ser enviado!</p>';

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail->setLanguage('phpmailer.lang-es','../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
} catch (Exception $e) {
    echo "Error al envíar el correo electrónico de la compra: {$mail->ErrorInfo}";
    //exit;
}