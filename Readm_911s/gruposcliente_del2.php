<?php 
include 'auth.php';
include 'lib.php';

$idg = request("idg");
$idcli = request ("idcli");

$sql = "delete from cadastros_grupocad where NR_SEQ_GRUPO_CADGP = '$idg' and NR_SEQ_CADASTRO_CADGP = '$idcli'";
$st = mysql_query($sql);

//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou grupo e assinantes");

mysql_close($con);

Header("Location: clientes.php?aba=2");
?>