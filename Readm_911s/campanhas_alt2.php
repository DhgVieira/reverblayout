<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$nome = request("nome");

if (!$nome){
	Header("Location: campanhas.php");
    exit();
}

$str = "UPDATE campanhas SET DS_CAMPANHA_CARC = '$nome' WHERE NR_SEQ_CAMPANHA_CARC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou campanha $idc");

mysql_close($con);

Header("Location: campanhas.php");
exit();
?>