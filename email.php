<?php
header("Location: /");
die();
$nome = $_POST['nome'];
$email= $_POST['email'];
$mensagem= $_POST['mensagem'];
$to = "lucas.nishi@hotmail.com";
$assunto = 'Nome: '.$nome.'<br>Email:'.$email.'<br><br>'.$_POST['assunto'];
$headers = "From:{$email}" . "\r\n" .
"CC: lucas.nishimura@hotmail.com";

mail($to,$assunto,$mensagem,$headers);

?>