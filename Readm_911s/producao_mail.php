<?php
include 'auth.php';
include 'lib.php';

$html = request("html");

$email = request("email");

if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
 

$emaildestinatario = $email;

$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
$headers .= "From: news@reverbcity.com".$quebra_linha;
$headers .= "Return-Path: news@reverbcity.com". $quebra_linha;
$headers .= "Reply-To: news@reverbcity.com".$quebra_linha;
mail($emaildestinatario, "Reverbcity - Previsao de Producao", utf8_decode($html), $headers);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou email de previsa de producao para $nome");


?>
<script language="JavaScript">
   alert('Email enviado com Sucesso!');
   window.close();
</script>