<?php 
include 'auth.php';
include 'lib.php';

$idg = request("idg");

if ($SS_nivel > 100){

$str = "DELETE FROM AssinanteGrupo WHERE IdGrupo = $idg";
$st = mysql_query($str);

$str = "DELETE FROM Grupo WHERE IdGrupo = $idg";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou grupo de assinantes");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar grupo - $SS_logadm");
}

mysql_close($con);

Header("Location: newsletter.php?aba=3");
?>