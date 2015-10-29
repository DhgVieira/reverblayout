<?php
include 'auth.php';
include 'lib.php';

$nome_subcat 	= request("nome_subcat");
$categoria		= request("categoria");

if (!$nome_subcat){
	$msg = "Voce precisa informar o nome da SubCategoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO contas_subcategorias (DS_SUBCATEGORIA_SCRC, NR_SEQ_CATCONTA_SCRC) VALUES ('$nome_subcat', $categoria)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu subcategoria no contas");

mysql_close($con);

Header("Location: contas_subcategorias.php");
exit();
?>