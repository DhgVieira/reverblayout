<?php 
include 'auth.php';
include 'lib.php';

$idl = request("idl");

$str = "DELETE FROM banners_agendados WHERE NR_SEQ_AGENDAMENTO_BARC = $idl";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou agendamento de produto do dia");

mysql_close($con);

Header("Location: banners_proddia.php");
exit();
?>