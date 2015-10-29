<?
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$id = request("id");
$legenda = request("legenda");

$str = "UPDATE fotos SET DS_LEGENDA_FORC = '$legenda' where NR_SEQ_FOTO_FORC = $id";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou legenda foto $id");

mysql_close($con);

Header("Location: grupos_fotos.php?idp=$idp");
?>