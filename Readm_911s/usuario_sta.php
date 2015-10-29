<?php
include 'auth.php';
include 'lib.php';

$idu = request("idu");
$status = request("st");
$pg = request("pg");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE usuarios SET ST_STATUS_USRC = '$status' where NR_SEQ_USUARIO_USRC = $idu";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status de usuario $idu $status");

mysql_close($con);

Header("Location: usuarios.php?pagina=$pg");
?>