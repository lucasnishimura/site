<?php
error_reporting(E_ALL); 
ini_set("display_errors", 1);

$nome = $_POST['nome'];
$email= $_POST['email'];
$mensagem= $_POST['mensagem'];
$to = "lucas.nishi@hotmail.com";
$assunto = 'Nome: '.$nome.'<br>Email:'.$email.'<br><br>'.$_POST['assunto'];
$headers = "From:{$email}" . "\r\n" .
"CC: lucas.nishimura@hotmail.com";

if (mail($to,$assunto,$mensagem,$headers)) {
    echo("Message successfully sent");
} else {
    echo("Message sending failed");
}

die();

header("Location: https://lucasnishi.herokuapp.com/obrigado.html");
die();
?>