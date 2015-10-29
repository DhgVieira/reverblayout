<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$idp = request("idp");

$str = "DELETE FROM me_fotos_coments WHERE NR_SEQ_COMENTARIO_MCRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou comentario $idc do people");

mysql_close($con);

Header("Location: people_coments.php?idp=$idp");
?>