<?php
include '../adm/lib.php';

$nome = request("nome");
$email = request("email");
$assunto = request("titulo");
$corpo = request("FCKeditor1");
$idav = request("idav");

$str = "update aviseme set ST_AVISO_AVRC = 'S' where NR_SEQ_AVISEME_AVRC = $idav";
$st = mysql_query($str);

$emailsender='contato@reverbcity.com'; // Substitua essa linha pelo seu e-mail@seudominio

if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
 
$nomeremetente     = "Reverbcity";
$emailremetente    = "atendimento@reverbcity.com";
$emaildestinatario = $email;

$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
$headers .= "From: ".$emailsender.$quebra_linha;
$headers .= "Return-Path: " . $emailsender . $quebra_linha;
$headers .= "Reply-To: ".$emailremetente.$quebra_linha;
mail($emaildestinatario, $assunto, $corpo, $headers);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou email de niver para $nome");
?>
<script language="JavaScript">
   alert('Email de aviso enviado com Sucesso!');
   window.location.href=('grupos_aviso.php');
</script>