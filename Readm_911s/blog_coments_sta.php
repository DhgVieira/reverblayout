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

$str = "UPDATE blog_coments SET DS_STATUS_CBRC = '$status' where NR_SEQ_COMENTARIO_CBRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Mudou status do comentario $idc $status");

mysql_close($con);

Header("Location: blog_coments.php?idp=$idp");
?>