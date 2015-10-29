<?php
include 'auth.php';
include 'lib.php'; 

$frase	= request("frase");
$frase2	= request("frase2");
$frase3	= request("frase3");
$frase4	= request("frase4");

$str = "UPDATE config_gerais SET DS_FRASE1_GESA = '$frase', DS_FRASE2_GESA = '$frase2', DS_FRASE3_GESA = '$frase3', DS_FRASE4_GESA = '$frase4' WHERE NR_SEQ_CONFIG_GESA = 1";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou texto do Banner");

mysql_close($con);

Header("Location: banners.php?aba=5");
?>
