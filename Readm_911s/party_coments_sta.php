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

$str = "UPDATE party_coments SET DS_STATUS_PCRC = '$status' where NR_SEQ_COMENTARIO_PCRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status de comentario de party $idc");

mysql_close($con);

Header("Location: party_coments.php?idp=$idp");
?>