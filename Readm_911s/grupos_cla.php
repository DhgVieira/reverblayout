<?php 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$back = request("back");

$sql = "UPDATE produtos SET DS_CLASSIC_PRRC = 'S' WHERE NR_SEQ_PRODUTO_PRRC = $idp";
$st = mysql_query($sql);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou produto para classics $idp");

mysql_close($con);

if (!$back){
    Header("Location: grupos.php");
}else{
    Header("Location: index.php");
}
exit();
?>