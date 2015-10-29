<?php
include '../adm/lib.php';

$email = request("email");
$subject = request("titulo");
$corpo = request("FCKeditor1");

$para = "contato@reverbcity.com";

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: contato@reverbcity.com\r\n";
$headers .= "Return-Path: contato@reverbcity.com\r\n";
$headers .= 'Bcc:'.$email."\r\n";

mail($para, $subject, str_replace("\n","",$corpo), $headers);
//mail("compras@reverbcity.com", $subject, str_replace("\n","",$corpo), $headers);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou email de aviso para $nome");
?>
<script language="JavaScript">
   alert('Email de aviso enviado com Sucesso!');
   window.location.href=('topicos.php');
</script>