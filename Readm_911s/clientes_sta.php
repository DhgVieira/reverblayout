<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$status = request("st");
$pg = request("pg");
$tipo = request("tp");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

$str = "UPDATE cadastros SET ST_CADASTRO_CASO = '$status' where NR_SEQ_CADASTRO_CASO = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status do cadastro $idc $status");

mysql_close($con);

if (!$tipo) {
	Header("Location: clientes.php?pagina=$pg");
}else{
	Header("Location: clientes_lj.php?pagina=$pg");
}
?>