<?php
include 'auth.php';
include 'lib.php';

$posicao = request("posicao");
$idb = request("idb");

$str = "UPDATE banners SET NR_POSICAO_BARC = $posicao where NR_SEQ_BANNER_BARC = $idb";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou posicao do banner $idb");

mysql_close($con);

Header("Location: banners.php?aba=4");
?>