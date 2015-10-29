<?php
include 'lib.php';

$nome = request("nome");
$idc = request("idc");
$email = request("email");
$subject = request("titulo");
$corpo = request("FCKeditor1");

$tipocad = 0;

$sqltipo = "SELECT TP_CADASTRO_CACH from cadastros where DS_EMAIL_CASO = '$email'";
$sttipo = mysql_query($sqltipo); 
if (mysql_num_rows($sttipo) > 0) {
    $rowtipo = mysql_fetch_row($sttipo);
    $tipocad = $rowtipo[0];
}

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: atendimento@reverbcity.com (Reverbcity)\r\n";
$headers .= "Return-Path: atendimento@reverbcity.com\r\n";

if ($tipocad == 1){
    mail("vendas@reverbcity.com", $subject." - $nome - Compra:$idc", str_replace("\n","",$corpo), $headers);
}

// mail($email, $subject, str_replace("\n","",$corpo), $headers);
  EnviaMailer("atendimento@reverbcity.com","Reverbcity",$email,$nome,"",$subject,$corpo);
//mail("compras@reverbcity.com", $subject, str_replace("\n","",$corpo), $headers);
?>
<script language="JavaScript">
   alert('Email enviado com Sucesso!');
   window.location.href=('compras_ver.php?idc=<?php echo $idc ?>');
</script>