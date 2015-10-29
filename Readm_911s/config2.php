<?php
include 'auth.php';
include 'lib.php'; 

$valorfrete	= request("valorfrete");
$fretehab	= request("fretehab");

if (!$valorfrete) $valorfrete = 0;
$valorfrete = str_replace(",",".",$valorfrete);

$str = "UPDATE config_gerais SET ST_FRETEGRATIS_GESA = '$fretehab', VL_FRETEGRATIS_GESA = $valorfrete WHERE NR_SEQ_CONFIG_GESA = 1";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou Config gerais");

mysql_close($con);

Header("Location: config.php");
?>
