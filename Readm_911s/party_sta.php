<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$status = request("st");
$pg = request("pg");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE partys SET ST_PARTY_PARC = '$status' where NR_SEQ_PARTY_PARC = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status de party $idp $status");

mysql_close($con);

Header("Location: party.php?pagina=$pg");
?>