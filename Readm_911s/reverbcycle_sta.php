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

$str = "UPDATE reverbcycle SET ST_CYCLE_RCRC = '$status' where NR_SEQ_REVERBCYCLE_RCRC = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status de reverbcycle $idp $status");

mysql_close($con);

Header("Location: reverbcycle.php?pagina=$pg");
?>