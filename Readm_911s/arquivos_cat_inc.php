<?php
include 'auth.php';
include 'lib.php';

$nome_cat 	= request("nome_cat");

if (!$nome_cat){
	$msg = "Voce precisa informar o nome da Categoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO arquivos_categoria (DS_CATEGORIA_PCRC, DT_CADASTRO_PCRC)
         VALUES ('$nome_cat',sysdate())";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu nova categoria para arquivos");

mysql_close($con);

Header("Location: arquivos.php?aba=3");
exit();
?>