<?php
include 'auth.php';
include 'lib.php';

$idc	= request("idc");
$nome	= request("nome");
$endereco	= request("endereco");
$numero	= request("numero");
$bairro	= request("bairro");
$cidade	= request("cidade");
$uf	= request("uf");
$cep	= request("cep");
$complem	= request("complem");
$pais	= request("pais");
$fone	= request("fone");

$str = "INSERT INTO enderecos (
        NR_SEQ_COMPRA_ENRC,
        DS_DESTINATARIO_ENRC,
        DS_ENDERECO_ENRC,
        DS_NUMERO_ENRC,
        DS_COMPLEMENTO_ENRC,
        DS_BAIRRO_ENRC,
        DS_CEP_ENRC,
        DS_CIDADE_ENRC,
        DS_UF_ENRC,
        DS_PAIS_ENRC,
        DS_FONE_ENRC,
        DT_CADASTRO_ENRC
) VALUES (
        $idc,
        '$nome',
        '$endereco',
        '$numero',
        '$complem',
        '$bairro',
        '$cep',
        '$cidade',
        '$uf',
        '$pais',
        '$fone',
        sysdate()
)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu endereco de entrega na compra $idc");

mysql_close($con);

Header("Location: compras_ver.php?idc=$idc");
exit();
?>