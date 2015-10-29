<?php 
include 'auth.php';
include 'lib.php';

$ida = request("ida");
$pg = request("pg");
$idg= request("idg");

$sql = "DELETE FROM AssinanteGrupo WHERE IdAssinante = $ida";
$st = mysql_query($sql);

$sql = "DELETE FROM Assinante WHERE IdAssinante = $ida";
$st = mysql_query($sql);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou assinante $ida");

mysql_close($con);

if (!$idg) {
	Header("Location: newsletter.php?opt=4");
}else{
	Header("Location: newsletter_grpemail.php?idg=$idg&pagina_a=$pg");
}
?>