<?php
include 'auth.php';
include 'lib.php';

$nome = request("nome");

if (!$nome){
	Header("Location: campanhas.php");
    exit();
}

$str = "INSERT INTO campanhas (DS_CAMPANHA_CARC, DT_CRIACAO_CARC) VALUES ('$nome',sysdate())";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu nova campanha: $nome");

mysql_close($con);

Header("Location: campanhas.php");

?>
