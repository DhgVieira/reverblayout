<?php
include 'auth.php';
include 'lib.php';
$marca = request("m");
if (!$marca) $marca = "K";

$volta = "grupos_marcados2.php";

if ($marca == "O") {
    $marca = "N";
}

if ($marca == "M") {
    $marca = "N";
    $volta = "grupos_marcados.php";
}

$idp = request("idp");

$str = "UPDATE produtos SET ST_MARCA_PRRC = '$marca' where NR_SEQ_PRODUTO_PRRC = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Marcou produto $idp $marca");

mysql_close($con);

if ($marca == "K"){
    Header("Location: grupos_marcados.php");
}else{
    Header("Location: $volta");
}

exit();
?>