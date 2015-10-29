<?php 
include 'auth.php';
include 'lib.php';

$idc  = request("idc");
$iditem = request("iditem");
$qtde = request("qtde");
$valor = request("valor");
$idprod = request("idprod");
$id_tama = request("id_tama");
$qtde_ant = request("qtde_ant");
$id_estoq = request("id_estoq");

$valor = str_replace("R$","",$valor);
$valor = str_replace(".","",$valor);
$valor = str_replace(",",".",$valor);
$valor = str_replace(" ","",$valor);

$altera = false;

$sql2 = "SELECT NR_QTDE_ESRC FROM estoque WHERE NR_SEQ_PRODUTO_ESRC = $idprod and NR_SEQ_TAMANHO_ESRC = $id_tama";
$st2 = mysql_query($sql2); 
if (mysql_num_rows($st2) > 0) {
	$row2 = mysql_fetch_row($st2);
	$to_est = $row2[0];
    
    $checadiff = $qtde - $qtde_ant;
    
    $corpo = "Compra: $idc <br /><br />";
    $corpo .= "Saldo: $to_est <br />";
    $corpo .= "Qtde anterior: $qtde_ant <br />";
    $corpo .= "Qtde Nova: $qtde <br />";
    $corpo .= "nova qtde: ".$checadiff." <br /><br />";
    
    //echo "Saldo: $to_est <br />";
    //echo "Qtde anterior: $qtde_ant <br />";
    //echo "Qtde Nova: $qtde <br />";
    //echo "nova qtde: ".$checadiff." <br /><br />";
    
    $str = "UPDATE cestas SET VL_PRODUTO_CESO = $valor WHERE NR_SEQ_CESTA_CESO = $iditem";
    $st = mysql_query($str);
    
    $corpo .= $str ."<br />";
    
    if (($qtde - $qtde_ant) > 0){
        if (($to_est - $checadiff)>=0){
            $str = "UPDATE cestas SET NR_QTDE_CESO = $qtde WHERE NR_SEQ_CESTA_CESO = $iditem";
            $st = mysql_query($str);
            
            $corpo .= $str ."<br />";
            
            $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC - ".$checadiff." WHERE 
                     NR_SEQ_PRODUTO_ESRC = $idprod and NR_SEQ_TAMANHO_ESRC = $id_tama";
            $st4 = mysql_query($str4);
            
            $corpo .= $st4 ."<br />";
            
            GravaLogEstoque($SS_logadm,$idprod,$id_tama,"Removeu ".$checadiff,"Alterou prod na Compra Nr $idc",$checadiff*-1);
        }
    }else if ((($qtde - $qtde_ant) < 0) && $qtde != 0){
        $diff = $qtde_ant - $qtde;
        
        $str = "UPDATE cestas SET NR_QTDE_CESO = $qtde WHERE NR_SEQ_CESTA_CESO = $iditem";
        $st = mysql_query($str);
        
        $corpo .= $str ."<br />";
        
        $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC + ".$diff." WHERE 
                     NR_SEQ_PRODUTO_ESRC = $idprod and NR_SEQ_TAMANHO_ESRC = $id_tama";
        $st4 = mysql_query($str4);
        
        $corpo .= $st4 ."<br />";
        
        GravaLogEstoque($SS_logadm,$idprod,$id_tama,"Adicionou ".$diff," Alterou prod na Compra Nr $idc",$diff);
    }
    
    $sqlc = "select * from compras WHERE NR_SEQ_COMPRA_COSO = $idc";
    $stc = mysql_query($sqlc);
    
    if (mysql_num_rows($stc) > 0) {
        $rowc = mysql_fetch_array($stc);
        
        $frete = $rowc["VL_FRETE_COSO"];
        if (!$frete) $frete = 0;
        
        $desconto = $rowc["VL_DESCONTO_COSO"];
        if (!$desconto) $desconto = 0;
        
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
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou produto $iditem na compra $idc - $qtde - $valor");
mysql_close($con);

Header("Location: compras_alt.php?idc=$idc");
exit();
?>