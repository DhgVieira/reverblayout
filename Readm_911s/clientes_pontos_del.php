<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$idc = request("idc");
  
$str = "DELETE from pontos WHERE NR_SEQ_PONTOS_PORC = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"DELETOU pontos do cliente $idc");

mysql_close($con);

Header("Location: clientes_pontos.php?idc=$idc");
exit();
?>
