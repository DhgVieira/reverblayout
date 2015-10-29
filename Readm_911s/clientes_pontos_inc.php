<?php
include 'auth.php';
include 'lib.php';

$idc 		= request("idc");
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
  
$str = "INSERT INTO pontos (NR_SEQ_CADASTRO_PORC, NR_SEQ_REFERENCIA_PORC, NR_SEQ_COMPRA_PORC, NR_QTDE_PORC, DT_INCLUSAO_PORC, ST_PONTOS_PORC, NR_SEQ_COMPRAUTIL_PORC)
				 VALUES ($idc, $refere, $compra, $pontos, sysdate(), '$status', $compruti)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inlcuiu pontos para o cliente $idc");

mysql_close($con);

Header("Location: clientes_pontos.php?idc=$idc");
exit();
?>
