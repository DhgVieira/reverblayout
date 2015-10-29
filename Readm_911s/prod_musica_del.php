<?php 
include 'auth.php';
include 'lib.php';

$idm = request("idm");

$sql = "SELECT NR_SEQ_MUSICA_PRRC from produtos WHERE NR_SEQ_MUSICA_PRRC = $idm";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM produtos_musica WHERE NR_SEQ_MUSICA_MURC = $idm";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou musica $idm");

mysql_close($con);

Header("Location: grupos.php?aba=5");
?>