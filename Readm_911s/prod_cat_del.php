<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");

if ($SS_nivel > 100){

$sql = "SELECT NR_SEQ_CATEGORIA_PRRC from produtos WHERE NR_SEQ_CATEGORIA_PRRC = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM produtos_categoria WHERE NR_SEQ_CATEGPRO_PCRC = $idc";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou categoria de produto $idc");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar categoria de prod - $SS_logadm");
}

mysql_close($con);

Header("Location: grupos.php?aba=3");
?>