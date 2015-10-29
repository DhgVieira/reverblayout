<?php
include 'auth.php';
include 'lib.php'; 

$valor1	= request("valor1");
$valor2	= request("valor2");
$valor3	= request("valor3");

$percen1	= request("percen1");
$percen2	= request("percen2");
$percen3	= request("percen3");

$valor1 = str_replace(",",".",$valor1);
$valor2 = str_replace(",",".",$valor2);
$valor3 = str_replace(",",".",$valor3);

$percen1 = str_replace(",",".",$percen1);
$percen2 = str_replace(",",".",$percen2);
$percen3 = str_replace(",",".",$percen3);

$totalfunc	= request("totalfunc");
$totalequip	= request("totalequip");

if (!$totalfunc) $totalfunc = 1;
if (!$totalequip) $totalequip = 1;

$str = "DELETE FROM comissoes_config WHERE NR_SEQ_LOJA_CORC = $SS_loja";
$st = mysql_query($str);

$str = "INSERT INTO comissoes_config (
        VL_COMISSAO1_CORC,
        VL_COMISSAO2_CORC,
        VL_COMISSAO3_CORC,
        VL_PERCENT1_CORC,
        VL_PERCENT2_CORC,
        VL_PERCENT3_CORC,
        NR_TOTALFUNC_CORC,
        NR_TOTALEQUIP_CORC,
        NR_SEQ_LOJA_CORC, DT_ATUALIZACAO_CORC, NR_SEQ_ADM_CORC) 
        VALUES ($valor1, $valor2, $valor3,
                $percen1, $percen2, $percen3,
                $totalfunc, $totalequip, $SS_loja, SYSDATE(), $SS_logadm)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou configurações de comissões");

mysql_close($con);

Header("Location: config.php?aba=2");
exit();
?>