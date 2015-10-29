<?php
include 'auth.php';
include 'lib.php'; 

$estado	= request("estado");
$valorfreteuf	= request("valorfreteuf");
$fretehabuf	= request("fretehabuf");

if ($estado != "0"){
    if (!$valorfreteuf) $valorfreteuf = 0;
    $valorfreteuf = str_replace(",",".",$valorfreteuf);
    
    $str = "UPDATE estados_frete SET ST_FRETEGRATIS_EFRC = '$fretehabuf', VL_VALOR_EFRC = $valorfreteuf WHERE DS_SIGLA_EFRC = '$estado'";
    $st = mysql_query($str);
    
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou estado $estado - $fretehabuf - $valorfreteuf");
}

mysql_close($con);

Header("Location: config.php");
exit();
?>