<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$status = request("st");
$pg = request("pg");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE foruns SET ST_FORUM_FOSO = '$status' where NR_SEQ_FORUM_FOSO = $idf";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Status de forum alterado $idf $status");

mysql_close($con);

Header("Location: foruns.php?pagina=$pg");
?>