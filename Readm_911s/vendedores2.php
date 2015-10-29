<?php
include 'auth.php';
include 'lib.php';

$idcli = request("idcli");
$desconto = request("desconto");

$desconto = str_replace(",",".",$desconto);

$str = "UPDATE cadastros SET VL_DESCONTO_CACH = $desconto where NR_SEQ_CADASTRO_CASO = $idcli";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou valores do vendedor $idcli: $desconto");

mysql_close($con);

Header("Location: vendedores.php");
exit();
?>