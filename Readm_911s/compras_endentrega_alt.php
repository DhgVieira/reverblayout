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

$str = "UPDATE enderecos SET 
        DS_DESTINATARIO_ENRC = '$nome',
        DS_ENDERECO_ENRC = '$endereco',
        DS_NUMERO_ENRC = '$numero',
        DS_COMPLEMENTO_ENRC = '$complem',
        DS_BAIRRO_ENRC = '$bairro',
        DS_CEP_ENRC = '$cep',
        DS_CIDADE_ENRC = '$cidade',
        DS_UF_ENRC = '$uf',
        DS_PAIS_ENRC = '$pais',
        DS_FONE_ENRC = '$fone'
WHERE
        NR_SEQ_COMPRA_ENRC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou endereco de entrega na compra $idc");

mysql_close($con);

Header("Location: compras_ver.php?idc=$idc");
exit();
?>