<?php 
include 'auth.php';
include 'lib.php';
$idt = request("idt");
$idf = request("idf");
$idm = request("idm");
$page = request("pg");

if ($SS_nivel > 100){

$str = "DELETE from msgs WHERE NR_SEQ_MSG_MESO = $idm";
$st2 = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou mensagem do forum");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar msg - $SS_logadm");
}

mysql_close($con);

Header("Location: msgs.php?pagina=$page&idf=$idf&idt=$idt");
?>