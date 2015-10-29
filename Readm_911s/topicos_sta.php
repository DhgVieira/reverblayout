<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$idt = request("idt");
$status = request("st");
$pg = request("pg");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE topicos SET ST_TOPICO_TOSO = '$status' where NR_SEQ_TOPICO_TOSO = $idt";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status do topico $idt $status");

mysql_close($con);

Header("Location: topicos.php?idf=$idf&pagina=$pg");
?>