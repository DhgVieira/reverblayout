<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$idp = request("idp");
$zoomalt = request("zoomalt");

$str = "UPDATE fotos SET ZOOM_FORC = $zoomalt where NR_SEQ_FOTO_FORC = $idf";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou ordem da foto $idf");

mysql_close($con);

Header("Location: grupos_fotos.php?idp=$idp");
?>