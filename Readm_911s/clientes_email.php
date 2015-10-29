<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$acao = request("ac");
$pg = request("pg");

if ($acao == "B"){
    $status = "S";
}else{
    $status = "N";
}

$str = "UPDATE cadastros SET ST_BLOQUEIOMAIL_CACH = '$status' where NR_SEQ_CADASTRO_CASO = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status de envio de mails para o cadastro $idc - $status");

mysql_close($con);

Header("Location: clientes.php?pagina=$pg");
exit();
?>