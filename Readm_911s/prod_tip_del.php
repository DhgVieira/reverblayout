<?php 
include 'auth.php';
include 'lib.php';

$idt = request("idt");

if ($SS_nivel > 100){

$sql = "SELECT NR_SEQ_TIPO_PRRC from produtos WHERE NR_SEQ_TIPO_PRRC = $idt";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM produtos_tipo WHERE NR_SEQ_CATEGPRO_PTRC = $idt";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou tipo de produto $idt");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar tipo de produto - $SS_logadm");
}

mysql_close($con);

Header("Location: grupos.php?aba=4");
?>