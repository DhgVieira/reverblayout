<?php
include 'auth.php';
include 'lib.php';

$nome_tip 	= request("nome_tip");
$ncm        = request("ncm");

if (!$ncm) $ncm = "null";

if (!$nome_tip){
	$msg = "Voce precisa informar o nome do Tipo!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO produtos_tipo (DS_CATEGORIA_PTRC, DT_CADASTRO_PTRC, NR_SEQ_LOJA_PTRC, DS_NCM_PTRC)
         VALUES ('$nome_tip',sysdate(),$SS_loja,$ncm)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu novo tipo de produto $nome_tip");

mysql_close($con);

Header("Location: grupos.php?aba=4");
exit();
?>