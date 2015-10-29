<?php 
include 'auth.php';
include 'lib.php';
$idc = request("idc");
$page = request("pg");

$str = "DELETE from campanhas WHERE NR_SEQ_CAMPANHA_CARC = $idc";
$st2 = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou campanha $idc");

mysql_close($con);

Header("Location: campanhas.php?pagina=$page");
exit();
?>