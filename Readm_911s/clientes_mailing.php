
<?php 
include 'auth.php';
include 'lib.php';

$idcliente = $_POST["idcliente"];

$subject = "ReverbCity - REMINDER!";

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: contato@reverbcity.com\r\n";
$headers .= "Return-Path: contato@reverbcity.com\r\n";

$corpo = "Hey dear, honey... </br></br>

Estamos com saudades suas! </br></br>

Faz um tempão que seu carrinho está vazio...Boraaa voltar a encheê-lo com boa música! </br></br>

Abraços. </br></br>";




$corpo = IncluiPapelCarta("sistema",utf8_decode($corpo),utf8_decode($subject)); 

foreach ($idcliente as $key => $cliente) {

	

    $sql = "SELECT DS_NOME_CASO, DS_EMAIL_CASO FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $cliente" ;

    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
	    $row = mysql_fetch_row($st);
	    $nome = $row[0];
	    $email = $row[1];
   	}
   

   
	EnviaEmailNovo("news@reverbcity.com","Reverbcity",$email,"","",utf8_decode($subject), $corpo);

	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou email de aviso para $nome");
}

Header("Location: index.php");
?>

<script language="JavaScript">
   alert('Email de aviso enviado com Sucesso!');
   window.location.href=('index.php');
</script>