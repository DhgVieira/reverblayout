<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$idt = request("idt");
$idm = request("idm");
$status = request("st");
$pg = request("pg");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE msgs SET ST_MSG_MESO = '$status' where NR_SEQ_MSG_MESO = $idm";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status de msg do topico $idt");

mysql_close($con);

Header("Location: msgs.php?idt=$idt&idf=$idf&pagina=$pg");
?>