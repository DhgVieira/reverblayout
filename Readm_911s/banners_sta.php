<?php
include 'auth.php';
include 'lib.php';

$idb = request("idb");
$status = request("st");
$pg = request("pg");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE banners SET ST_BANNER_BARC = '$status' where NR_SEQ_BANNER_BARC = $idb";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status do banner $idb $status");

mysql_close($con);

Header("Location: banners.php?pagina=$pg");
?>