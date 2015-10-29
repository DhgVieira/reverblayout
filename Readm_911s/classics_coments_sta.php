<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$idp = request("idp");
$status = request("st");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE classics_coments SET DS_STATUS_CLRC = '$status' where NR_SEQ_COMENTARIO_CLRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status do comentario do classics $idc");

mysql_close($con);

Header("Location: classics_coments.php?idp=$idp");
?>