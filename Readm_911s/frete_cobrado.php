<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$frete = request("frete");

$frete = str_replace(".","",$frete);

if (!$frete){
    $str = "update compras SET VL_FRETE_COSO = 0 where NR_SEQ_COMPRA_COSO = $idc";
    $stp = mysql_query($str);
    $frete = 0;
}else{
    //$frete = number_format($frete,2,".","");
    $frete = str_replace(",",".",$frete);
    $str = "update compras SET VL_FRETE_COSO = $frete where NR_SEQ_COMPRA_COSO = $idc";
    $stp = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou frete da compra $idc para $frete");

$sqlc = "select * from compras WHERE NR_SEQ_COMPRA_COSO = $idc";
$stc = mysql_query($sqlc);

if (mysql_num_rows($stc) > 0) {
    $rowc = mysql_fetch_array($stc);
    
    $frete = $rowc["VL_FRETE_COSO"];
    if (!$frete) $frete = 0;
    
    $desconto = $rowc["VL_DESCONTO_COSO"];
    if (!$desconto) $desconto = 0;
    
    $desconto2 = $rowc["VL_DESCPROMO_COSO"];
    if (!$desconto2) $desconto2 = 0;
    
    $desconto += $desconto2;
    
    $vlbil = 0;
    $sqlb = "SELECT VL_BILHETE_BIRC from bilhetes where NR_SEQ_COMPRAUTIL_BIRC = $idc";
	$stb = mysql_query($sqlb);
	if (mysql_num_rows($stb) > 0) {
		$rowb = mysql_fetch_row($stb);
		$vlbil = $rowb[0];
    }
    
    $vlcreditos = 0;
    $sqlb = "SELECT VL_LANCAMENTO_CRSA from contacorrente where NR_SEQ_COMPRA_CRSA = $idc";
	$stb = mysql_query($sqlb);
	if (mysql_num_rows($stb) > 0) {
		$rowb = mysql_fetch_row($stb);
		$vlcreditos = $rowb[0];
    }
    
    $vl_geral = 0;
    $sql = "select NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_CESTA_CESO, VL_PRODUTO_CESO FROM cestas 
            WHERE NR_SEQ_COMPRA_CESO = $idc";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
    	while($row = mysql_fetch_row($st)) {
            $id_tamanho = $row[0];
            $nr_qtde    = $row[1];
            $nr_produto = $row[2];
            $item       = $row[3];
            $vl_prod	= $row[4];
            
            $vl_geral += ($vl_prod*$nr_qtde);
        }
        
        $vl_geral += $frete;
        $vl_geral -= $vlbil;
        $vl_geral -= $vlpontos;
        $vl_geral -= $desconto;
        $vl_geral += $vlcreditos;
        
        $vl_geral = str_replace(",",".",$vl_geral);
        
        $str = "UPDATE compras SET VL_TOTAL_COSO = $vl_geral WHERE NR_SEQ_COMPRA_COSO = $idc";
        $stUp = mysql_query($str);
    }
}

Header("Location: compras_ver.php?idc=$idc");
exit();
?>