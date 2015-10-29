<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$idt = request("idt");
$nome = request("nome");

if (!$nome){
	Header("Location: topicos.php?idf=$idf");
    exit();
}

$str = "UPDATE topicos SET DS_TOPICO_TOSO = '$nome' WHERE NR_SEQ_TOPICO_TOSO = $idt";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou topico $idt");

mysql_close($con);

Header("Location: topicos.php?idf=$idf");

?>
