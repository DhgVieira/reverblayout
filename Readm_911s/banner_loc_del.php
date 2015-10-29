<?php 
include 'auth.php';
include 'lib.php';

$idl = request("idl");

$sql = "SELECT NR_SEQ_LOCAL_BARC from banners WHERE NR_SEQ_LOCAL_BARC = $idl";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM banners_locais WHERE NR_SEQ_BANLOCAL_BLRC = $idl";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou local de banner $idl");

mysql_close($con);

Header("Location: banners.php?aba=3");
?>