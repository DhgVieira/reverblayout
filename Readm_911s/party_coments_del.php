<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$idp = request("idp");

$str = "DELETE FROM party_coments WHERE NR_SEQ_COMENTARIO_PCRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou comentario da party $idp $idc");

mysql_close($con);

Header("Location: party_coments.php?idp=$idp");
?>