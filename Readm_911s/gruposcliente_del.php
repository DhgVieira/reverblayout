<?php 
include 'auth.php';
include 'lib.php';

$idg = request("idg");

$sql = "delete from cadastros_grupocad where NR_SEQ_GRUPO_CADGP = $idg";
$st = mysql_query($sql);

$str = "delete from grupocad where NR_SEQ_GRUPO_GPCAD = $idg";
$st = mysql_query($str);

//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou grupo e assinantes");

mysql_close($con);

Header("Location: clientes.php?aba=2");
?>