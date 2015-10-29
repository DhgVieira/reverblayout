<?php 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$pagina = request("pg");

if ($SS_nivel > 100){
    
$str = "DELETE FROM imprensa WHERE idimprensa = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou Imprensa $idp");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar Impresa - $SS_logadm");
}

mysql_close($con);

Header("Location: imprensa.php?aba=2");
?>