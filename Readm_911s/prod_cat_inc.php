<?php
include 'auth.php';
include 'lib.php';

$nome_cat 	= request("nome_cat");
$ncm        = request("ncm");

if (!$ncm) $ncm = "null";

if (!$nome_cat){
	$msg = "Voce precisa informar o nome da Categoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO produtos_categoria (DS_CATEGORIA_PCRC, DT_CADASTRO_PCRC, NR_SEQ_LOJA_PCRC, DS_NCM_PCRC)
         VALUES ('$nome_cat',sysdate(),$SS_loja, $ncm)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu nova categoria para produtos");

mysql_close($con);

Header("Location: grupos.php?aba=3");
exit();
?>