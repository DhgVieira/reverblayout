<? 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$page = request("pg");
$ext = request("ext");

$str = "DELETE FROM me_fotos_coments WHERE NR_SEQ_FOTO_MCRC = $idp";
$st = mysql_query($str);

$str = "DELETE FROM me_fotos WHERE NR_SEQ_FOTO_FORC = $idp";
$st = mysql_query($str);

if (file_exists("../images/me/fotos/$idp.$ext")) unlink("../images/me/fotos/$idp.$ext");
if (file_exists("../images/me/fotos/".$idp."p.$ext")) unlink("../images/me/fotos/".$idp."p.$ext");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou foto do people $idp");

mysql_close($con);

Header("Location: people.php?pagina=$page");
?>