<?php
include 'auth.php';
include 'lib.php';

$dados = request("cestaitens");
$dados = substr($dados,0,strlen($dados)-1);

$novo_vl_promo = request("valor");
$fretegratis   = request("fretegratis");

$novo_vl_promo = str_replace("r$","",$novo_vl_promo);
$novo_vl_promo = str_replace("R$","",$novo_vl_promo);
$novo_vl_promo = str_replace("$","",$novo_vl_promo);
$novo_vl_promo = str_replace(" ","",$novo_vl_promo);

if (!$novo_vl_promo) $novo_vl_promo = 0;

$novo_vl_promo = str_replace(",",".",$novo_vl_promo);

$splitcesta = explode("|", $dados);

foreach ($splitcesta as $cesta){
    $itens = explode(";", $cesta);
    $idprod = $itens[0];
    $dataini = $itens[3];
    $valoratual = $itens[2];
    $fretegratual = $itens[5];
    $promoatual = $itens[4];
}

if (!$promoatual) $promoatual = 0;

$promoatual = str_replace(",",".",$promoatual);

$dataini = table2mysql($dataini.":00");

$str = "INSERT INTO banners_agendados (
            NR_SEQ_LOCAL_BARC, NR_SEQ_PRODUTO_BARC, DT_PUBLICACAO_BARC, ST_AGENDAMENTO_BARC,
            VL_NOVOVALOR_BARC, DS_FRETEGRATIS_BARC, VL_PROMOATUAL_BARC, DS_FRETEGRATUAL_BARC)
        values (1, $idprod, '$dataini', 'A', $novo_vl_promo, '$fretegratis', $promoatual, '$fretegratual')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Agendou novo produto do dia $idprod");

Header("Location: banners_proddia.php");
exit();

function table2mysql($datarec) {
     $data = explode("/", $datarec);
     $ano = substr($data[2],0,4);
     $hora = str_replace("$ano ","",$data[2]);
     $novadata = $ano."-".$data[1]."-".$data[0]." ".$hora;
     return $novadata;
}

mysql_close($con);
?>