<?php
// error_reporting(E_ALL); 
// ini_set("display_errors", 1);

$nome = $_POST['nome'];
$email= $_POST['email'];
$mensagem= $_POST['mensagem'];
$to = "lucas.nishi@hotmail.com";
$assunto = 'Email do site: '.$_POST['assunto'];


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
//Load composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions


    //Server settings
    // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    // $mail->Debugoutput = 'html';                            //Ask for HTML-friendly debug output
    
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'lucas.rossi.nishimura@gmail.com';                 // SMTP username
    $mail->Password = 'hzahiabuyrvlmtbw';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //Recipients
    $mail->setFrom($email, $nome);
    $mail->addAddress($to, 'Lucas Rossi Nishimura');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('lucas.nishimura@hotmail.com', 'Lucas Rossi Nishimura');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $assunto;
    $mail->Body    = '<b>Nome da pessoa que entrou em contato:</b> '.$nome.' <br> <b>Email da pessoa que entrou em contato: </b>'.$email.'<br><br>'.$mensagem;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->CharSet = 'UTF-8';
    
    $enviar = $mail->send();
    
    if($enviar){
        // header("Location: https://lucasnishi.herokuapp.com/obrigado.html");
        http_response_code(200);
        exit;
    }else{     
        http_response_code(500);
        exit;
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    // echo 'Message has been sent';
?>