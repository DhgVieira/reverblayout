<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");

$sql = "SELECT NR_SEQ_COLUNISTA_BLRC from blog WHERE NR_SEQ_COLUNISTA_BLRC = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM colunistas WHERE NR_SEQ_COLUNISTA_CORC = $idc";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou colunista $idc");

mysql_close($con);

Header("Location: blog.php?aba=3");
?>