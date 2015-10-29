<?php
include 'auth.php';
include 'lib.php';

$nome_tip 	= request("nome_cat");
$ncm        = request("ncm");
$idc        = request("idc");

$title 			= request("title");
$description 	= request("description");
$keywords 		= request("keywords");

if (!$ncm) $ncm = "null";

if (!$nome_tip){
	$msg = "Voce precisa informar o nome da Categoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "UPDATE produtos_categoria SET DS_CATEGORIA_PCRC = '$nome_tip', DS_NCM_PCRC = $ncm, title = '$title', description = '$description', keywords = '$keywords' WHERE NR_SEQ_CATEGPRO_PCRC = $idc";

$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou categoria de produto $nome_tip");

mysql_close($con);

Header("Location: grupos.php?aba=3");
exit();
?>