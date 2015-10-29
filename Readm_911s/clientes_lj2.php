<?php
include 'auth.php';
include 'lib.php';

$idcli = request("idcli");
$desconto = request("desconto");

//fechado, mudanca na regra de negocio
$qtdemin = request("qtdemin");
$qtdemin2 = request("qtdemin2");
$qtdemin = 0;
$qtdemin2 = 0;

$valormin = request("valormin");
$desconto_boleto = request("desconto_boleto");
$fretegratis = request("fretegratis");
$minrepos = request("minrepos");

$valormin = str_replace("R$ ","",$valormin);
$valormin = str_replace(".","",$valormin);
$valormin = str_replace(",",".",$valormin);
$valormin = str_replace(" ","",$valormin);

$minrepos = str_replace("R$ ","",$minrepos);
$minrepos = str_replace(".","",$minrepos);
$minrepos = str_replace(",",".",$minrepos);
$minrepos = str_replace(" ","",$minrepos);

$desconto = str_replace("%","",$desconto);
$desconto_boleto = str_replace("%","",$desconto_boleto);

if ($valormin == "") $valormin = 850;
if ($minrepos == "") $minrepos = 650;
if (!$desconto) $desconto = 50;
if ($desconto_boleto == "") $desconto_boleto = 5;
if (!$fretegratis) $fretegratis = "N";

$str = "UPDATE cadastros SET VL_DESCONTO_CACH = $desconto, NR_QTDEMINIMA_CACH = $qtdemin, VL_ATAC_MINREPOS_CACH = $minrepos, 
        NR_QTDEMINBUTTONS_CACH = $qtdemin2, NR_ATAC_VLRMIN_CACH = $valormin, VL_ATAC_DESCBOLETO_CACH = $desconto_boleto,
        ST_ATAC_FRETEGRATIS_CACH = '$fretegratis' where NR_SEQ_CADASTRO_CASO = $idcli";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou valores do lojista $idcli: $desconto $valormin $minrepos $desconto_boleto $parcelas $fretegratis");

mysql_close($con);

Header("Location: clientes_lj.php");
?>