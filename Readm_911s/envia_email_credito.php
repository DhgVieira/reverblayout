<?php
include 'lib.php';

$nome = request("nome");
$email = request("email");
$assunto = request("titulo");
$corpo = request("FCKeditor1");
$idc = request("idc");

$emailsender='atendimento@reverbcity.com'; // Substitua essa linha pelo seu e-mail@seudominio
$emailremetente    = "atendimento@reverbcity.com";

$nomeremetente     = "Reverbcity";

//if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
//elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
//else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
// $quebra_linha = "\n"; 
// $emaildestinatario = $email;

// $headers = "MIME-Version: 1.1".$quebra_linha;
// $headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
// $headers .= "From: ".$emailsender.$quebra_linha;
// $headers .= "Return-Path: " . $emailsender . $quebra_linha;
// $headers .= "Reply-To: ".$emailremetente.$quebra_linha;
// mail($emaildestinatario, $assunto, $corpo, $headers);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","",$assunto, $corpo);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou email de cr&eacute;dito para $nome");

$retorno = "sortecred_det.php?idc=$idc";
?>
<script language="JavaScript">
   alert('Email enviado com Sucesso!');
   window.location.href=('<?php echo $retorno; ?>');
</script>