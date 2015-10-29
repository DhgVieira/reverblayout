<?php 
include 'auth.php';
include 'lib.php';

$item = request("imageSearch");
$idc  = request("idc");
$qtde = request("qtdeadd");
$valoradd = request("valoradd");

$spliprod = explode(",", $item);

$spliprodid = explode(".", $spliprod[0]);

$id_prod = $spliprodid[0];
$id_tam = $spliprod[5];


if (!$valoradd){
    $vlr_prod = $spliprod[2];
}else{
    $vlr_prod = $valoradd;
    $vlr_prod = str_replace("R$","",$vlr_prod);
    $vlr_prod = str_replace(".","",$vlr_prod);
    $vlr_prod = str_replace(",",".",$vlr_prod);
    $vlr_prod = str_replace(" ","",$vlr_prod);
}

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
    
    $vlpontos = 0;
    $sqlp = "SELECT SUM(NR_QTDE_PORC) from pontos where NR_SEQ_COMPRAUTIL_PORC = $idc";
	$stp = mysql_query($sqlp);
	if (mysql_num_rows($stp) > 0) {
		$rowp = mysql_fetch_row($stp);
		$vlpontos = $rowp[0];
    }
    
    $sql2 = "SELECT DS_TAMANHO_TARC, DS_SIGLA_TARC, NR_QTDE_ESRC, NR_SEQ_TAMANHO_TARC, NR_SEQ_ESTOQUE_ESRC FROM tamanhos, estoque
		 WHERE NR_SEQ_TAMANHO_TARC = NR_SEQ_TAMANHO_ESRC AND NR_SEQ_TAMANHO_TARC = $id_tam AND NR_QTDE_ESRC > 0
         AND NR_SEQ_PRODUTO_ESRC = $id_prod";
    $st2 = mysql_query($sql2); 
    if (mysql_num_rows($st2) > 0) {
    	$row2 = mysql_fetch_row($st2);
    	$ds_tam = $row2[0];
    	$ds_sig = $row2[1];
    	$to_est = $row2[2];
    	$id_tam = $row2[3];
        $nrseqest = $row2[4];
        
        if (($to_est - $qtde)>=0){
        	$str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC - ".$qtde." WHERE NR_SEQ_ESTOQUE_ESRC = $nrseqest";
        	$st4 = mysql_query($str4); 
            
            GravaLogEstoque($SS_logadm,$id_prod,$id_tam,"Removeu ".$qtde,"Alteração: Adicionou na Compra Nr $idc",$qtde*-1);
        
            $str = "INSERT INTO cestas (NR_SEQ_ESTOQUE_CESO, NR_SEQ_CADASTRO_CESO, NR_SEQ_COMPRA_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, VL_PRODUTO_CESO, DT_INCLUSAO_CESO)
                    VALUES ($nrseqest, ".$rowc["NR_SEQ_CADASTRO_COSO"].", $idc, $id_prod, $id_tam, $qtde, ".str_replace(",",".",$vlr_prod).", sysdate())";
            $st = mysql_query($str);
        }
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

        $vl_geral = str_replace(",",".",$vl_geral);
        
        $str = "UPDATE compras SET VL_TOTAL_COSO = $vl_geral WHERE NR_SEQ_COMPRA_COSO = $idc";
        $stUp = mysql_query($str);
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Adicionou produto $id_prod na compra $idc");
mysql_close($con);

Header("Location: compras_alt.php?idc=$idc");
exit();
?>