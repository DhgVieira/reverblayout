<?php 
include 'auth.php';
include 'lib.php';

$ida = request("arq");
$ext = request("ext");

$str = "DELETE FROM arquivos_historico WHERE NR_SEQ_ARQ_HIST_AHRC = $ida";
$st = mysql_query($str);
       
if (file_exists("arquivos/historico/$ida.$ext")) unlink("arquivos/historico/$ida.$ext");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou o arquivo $ida.$ext do historico");

mysql_close($con);

Header("Location: arquivos.php");
exit();
?>