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

$str = "UPDATE me_fotos_coments SET DS_STATUS_MCRC = '$status' where NR_SEQ_COMENTARIO_MCRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status do comentario do people $idc");

mysql_close($con);

Header("Location: people_coments.php?idp=$idp");
?>