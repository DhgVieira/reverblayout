<?php
include 'auth.php';
include 'lib.php';

$nome_tip 	= request("nome_cat");
$ncm        = request("ncm");
$idc        = request("idc");

if (!$ncm) $ncm = "null";

if (!$nome_tip){
	$msg = "Voce precisa informar o nome do Tipo!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "UPDATE produtos_tipo SET DS_CATEGORIA_PTRC = '$nome_tip', DS_NCM_PTRC = $ncm WHERE NR_SEQ_CATEGPRO_PTRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou tipo de produto $nome_tip");

mysql_close($con);

Header("Location: grupos.php?aba=4");
exit();
?>