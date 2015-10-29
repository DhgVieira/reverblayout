<?php
include 'auth.php';
include 'lib.php';
$idc = request("idc");
$tid = request("tid");

$str4 = "UPDATE compras SET DS_TID_COSO = '$tid' WHERE NR_SEQ_COMPRA_COSO = $idc";
$st4 = mysql_query($str4); 

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou TID compra $idc");

mysql_close($con);
Header("Location: compras_ver.php?idc=$idc");
exit();
?>