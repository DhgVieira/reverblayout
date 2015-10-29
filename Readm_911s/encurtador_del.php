<?php 
include 'auth.php';
include 'lib.php';

$idu = request("idu");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou uma url encurtada: $idu");

mysql_close($con);

$con2 = mysql_connect("reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com","reverb","reverbserver2014") or die("Conexão Falhou!");
mysql_select_db("rvbla",$con2) or die("Database Inválido");

$str = "DELETE FROM urls WHERE NR_SEQ_URL_URDB = $idu";
$stb = mysql_query($str);

mysql_close($con);

Header("Location: encurtador.php");
exit();
?>