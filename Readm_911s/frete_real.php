<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$frete = request("frete");

if (!$frete){
    $str = "update compras SET VL_FRETECUSTO_COSO = 0 where NR_SEQ_COMPRA_COSO = $idc";
    $stp = mysql_query($str);
    $frete = 0;
}else{
    //$frete = number_format($frete,2,".","");
    $frete = str_replace(",",".",$frete);
    $str = "update compras SET VL_FRETECUSTO_COSO = $frete where NR_SEQ_COMPRA_COSO = $idc";
    $stp = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou frete custo da compra $idc para $frete");

Header("Location: compras_ver.php?idc=$idc");
exit();
?>