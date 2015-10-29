<?php 
include 'auth.php';
include 'lib.php';
$idt = request("idt");
$idf = request("idf");
$page = request("pg");

$str = "DELETE from msgs WHERE NR_SEQ_TOPICO_MESO = $idt";
$st2 = mysql_query($str);
	
$str = "DELETE from topicos WHERE NR_SEQ_TOPICO_TOSO = $idt";
$st3 = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou topico $idt");

mysql_close($con);

Header("Location: topicos.php?pagina=$page&idf=$idf");
?>