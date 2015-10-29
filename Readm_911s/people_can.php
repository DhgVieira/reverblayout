<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");

$str = "update me_fotos set ST_PEOPLE_FORC = 'C' WHERE NR_SEQ_FOTO_FORC = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Tirou foto do people da index $idp");

mysql_close($con);

Header("Location: index.php#me_fotos");
?>