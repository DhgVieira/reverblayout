<?php
include 'auth.php';
include 'lib.php';

$idc	= request("idc");
$obs	= request("obs");

if ($obs) {
	$str = "UPDATE compras SET DS_OBS_COSO = '$obs' WHERE NR_SEQ_COMPRA_COSO = $idc";
	$st = mysql_query($str);
}else{
	$str = "UPDATE compras SET DS_OBS_COSO = null WHERE NR_SEQ_COMPRA_COSO = $idc";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou observacao da compra $idc");

mysql_close($con);

Header("Location: compras_ver.php?idc=$idc");

?>
