<?php 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$pg = request("pg");

$sql = "INSERT INTO producao_fora (NR_SEQ_PRODUTO_PORC) values ($idp)";
$st = mysql_query($sql);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Removou da lista de previsao de producao produto $idp");

mysql_close($con);

Header("Location: producao.php?pagina=$pg");
exit();
?>