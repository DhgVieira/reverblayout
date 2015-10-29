<? 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$page = request("pg");
$ext = request("ext");

$str = "DELETE FROM reverbcycle WHERE NR_SEQ_REVERBCYCLE_RCRC = $idp";
$st = mysql_query($str);

if (file_exists("../images/reverbcycle/$idp.$ext")) unlink("../images/reverbcycle/$idp.$ext");
if (file_exists("../images/reverbcycle/".$idp."p.$ext")) unlink("../images/reverbcycle/".$idp."p.$ext");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou reverbcycle");

mysql_close($con);

Header("Location: reverbcycle.php?pagina=$page");
?>