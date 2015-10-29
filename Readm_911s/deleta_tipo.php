<?php
include 'auth.php';
include 'lib.php';

$idp = request("id_tipo");




$str = "DELETE FROM tipos_pacote WHERE idtipo_pacote = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou tipo de pacote $idp");


mysql_close($con);

Header("Location: pacotes.php?pagina=$page");
?>