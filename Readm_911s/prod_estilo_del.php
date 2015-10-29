<?php 
include 'auth.php';
include 'lib.php';

$idm = request("idm");

$sql = "SELECT NR_SEQ_ESTILO_PRRC from produtos WHERE NR_SEQ_ESTILO_PRRC = $idm";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM produtos_estilo WHERE NR_SEQ_ESTILO_ESRC = $idm";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou estilo de produto");

mysql_close($con);

Header("Location: grupos.php?aba=6");
?>