<?php
include 'auth.php';
include 'lib.php';

$str_perm  = request("str_perm");

$sql = "DELETE FROM atacado_tipos";
$st = mysql_query($sql);

$i = 0;

$arr_perm = explode("\|", $str_perm);

for ($i=0; $i < count($arr_perm); $i++) {
  $sql = "INSERT INTO atacado_tipos (NR_SEQ_TIPO_TARC) VALUES (" . $arr_perm[$i] . ")";
  $st = mysql_query($sql);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou tipos liberados para Lojistas");

mysql_close($con);

Header("Location: clientes_lj.php");
exit();
?>