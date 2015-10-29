<?php
include 'auth.php';
include 'lib.php';

$nome_cat 		= request("nome_cat");

if (!$nome_cat){
	$msg = "Voce precisa informar o nome da Categoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO contas_categorias (DS_CATEGORIA_CCRC) VALUES ('$nome_cat')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inlcuiu categoria no contas $nome_cat");

mysql_close($con);

Header("Location: contas_categorias.php");

?>