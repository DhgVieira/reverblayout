<?php
include 'auth.php';
include 'lib.php';

$nome_estilo 		= request("nome_estilo");

if (!$nome_estilo){
	$msg = "Voce precisa informar o nome do Estilo!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO produtos_estilo (DS_MUSICA_ESRC, DT_CADASTRO_ESRC, NR_SEQ_LOJA_ESRC) VALUES ('$nome_estilo',sysdate(),$SS_loja)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inlcuiu novo estilo de produto");

mysql_close($con);

Header("Location: grupos.php?aba=6");

?>