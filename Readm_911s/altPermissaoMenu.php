<?php
include 'auth.php';
include 'lib.php';

$idusuario = request("idu");
$str_perm  = request("str_perm");

$sql = "DELETE FROM permissoes WHERE NR_SEQ_USUARIO_PERC = $idusuario";
$st = mysql_query($sql);

$i = 0;

$arr_perm = explode("|", $str_perm);

for ($i=0; $i < count($arr_perm); $i++) {
  $sql = "INSERT INTO permissoes (NR_SEQ_USUARIO_PERC, NR_SEQ_MENU_PERC) VALUES (" . $idusuario . ", " . $arr_perm[$i] . ")";
  $st = mysql_query($sql);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou permissoes de Usuario $idusuario");

mysql_close($con);

Header("Location: usuarios.php");
exit();
?>