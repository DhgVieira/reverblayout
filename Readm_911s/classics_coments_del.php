<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$idp = request("idp");

$str = "DELETE FROM classics_coments WHERE NR_SEQ_COMENTARIO_CLRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou comentario do classics $idc");

mysql_close($con);

Header("Location: classics_coments.php?idp=$idp");
?>