<?php
include 'auth.php';
include 'lib.php';

$nome_tip 	= request("nome_cat");
$idc        = request("idc");

if (!$ncm) $ncm = "null";

if (!$nome_tip){
	$msg = "Voce precisa informar o nome da Categoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "UPDATE arquivos_categoria SET DS_CATEGORIA_PCRC = '$nome_tip' WHERE NR_SEQ_CATEGPRO_PCRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou categoria de arquivo: $nome_tip");

mysql_close($con);

Header("Location: arquivos.php?aba=3");
exit();
?>