<?php
include 'auth.php';
include 'lib.php';

$idp = request("id_pacote");




$str = "DELETE FROM pacotes WHERE idpacote = $idp";
die($str);
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou o pacote $idp");


mysql_close($con);

Header("Location: pacotes.php?pagina=$page");
?>