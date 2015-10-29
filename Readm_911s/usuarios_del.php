<? 
include 'auth.php';
include 'lib.php';

$idu = request("idu");
$page = request("pg");

$str = "DELETE FROM permissoes WHERE NR_SEQ_USUARIO_PERC = $idu";
$st = mysql_query($str);

$str = "DELETE FROM usuarios WHERE NR_SEQ_USUARIO_USRC = $idu";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou usuario $idu");

mysql_close($con);

Header("Location: usuarios.php?pagina=$page");
?>