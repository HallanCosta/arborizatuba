<?php
if (empty($_POST['txtEmail']) || empty($_POST['txtAssunto']) || empty($_POST['txtNome']) || empty($_POST['txtMensagem'])) {
	$message ='<script>window.alert("Preencha todos os campos");window.location.href="contato.html"</script>';
	print($message);
} elseif (filter_input(INPUT_POST, 'txtEmail', FILTER_VALIDATE_EMAIL) == 'arborizatuba@hotmail.com' || filter_input(INPUT_POST, 'txtEmail', FILTER_VALIDATE_EMAIL) == 'contato@arborizatuba.com') {
	$message ='<script>window.alert("Não tente enviar uma messagem para nosso proprio email");window.location.href="contato.html"</script>';
	print($message);
} elseif (!filter_input(INPUT_POST, 'txtEmail', FILTER_VALIDATE_EMAIL)) {
	$message ='<script>window.alert("Email Inválido: Digite um email válido porfavor");window.location.href="contato.html"</script>';
	print($message);
} else {
	$mail = filter_input(INPUT_POST, 'txtEmail', FILTER_VALIDATE_EMAIL);
	$subject = filter_input(INPUT_POST, 'txtAssunto', FILTER_SANITIZE_STRING);
	$name = filter_input(INPUT_POST, 'txtNome', FILTER_SANITIZE_STRING);
	$message = filter_input(INPUT_POST, 'txtMensagem', FILTER_SANITIZE_STRING);
	$and = '&';
	header("location: ../mail.php?mail={$mail}{$and}subject={$subject}{$and}name={$name}{$and}message={$message}");
}