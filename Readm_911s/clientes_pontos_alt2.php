<?php
include 'auth.php';
include 'lib.php';

$idc 		= request("idc");
$idp 		= request("idp");
$pontos 	= request("pontos");
$refere		= request("refere");
$compra 	= request("compra");
$compruti	= request("compruti");
$status		= request("status");

if (!$pontos) $pontos = 0;
if (!$compra) {
	$compra = "null";
}
if (!$compruti) {
	$compruti = "null";
}
  
$str = "UPDATE pontos SET NR_SEQ_REFERENCIA_PORC = $refere, NR_SEQ_COMPRA_PORC = $compra, NR_QTDE_PORC = $pontos, ST_PONTOS_PORC = '$status', NR_SEQ_COMPRAUTIL_PORC = $compruti
		WHERE NR_SEQ_PONTOS_PORC = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"alterou pontos para o cliente $idc");

mysql_close($con);

Header("Location: clientes_pontos.php?idc=$idc");
exit();
?>
