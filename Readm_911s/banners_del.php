<?php 
include 'auth.php';
include 'lib.php';

$idb = request("idb");
$ext = request("ext");

$str = "DELETE FROM banners WHERE NR_SEQ_BANNER_BARC = $idb";
$st = mysql_query($str);

if (file_exists("../images/banners/$idb.$ext")) unlink("../images/banners/$idb.$ext");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou banner $idb");

mysql_close($con);

Header("Location: banners.php?aba=2");
?>