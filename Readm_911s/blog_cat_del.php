<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");

$sql = "SELECT NR_SEQ_CATEGORIA_BLRC from blog WHERE NR_SEQ_CATEGORIA_BLRC = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM blog_categorias WHERE NR_SEQ_BLOGCAT_BCRC = $idc";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou a categoria $idc do blog");

mysql_close($con);

Header("Location: blog.php?aba=4");
?>