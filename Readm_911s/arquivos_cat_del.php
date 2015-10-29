<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");

$sql = "SELECT NR_SEQ_ARQUIVO_AQRC from arquivos WHERE NR_SEQ_CATEGORIA_AQRC = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM arquivos_categoria WHERE NR_SEQ_CATEGPRO_PCRC = $idc";
	$st = mysql_query($str);
    
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou categoria de arquivos $idc");
}

mysql_close($con);

Header("Location: arquivos.php?aba=3");
?>