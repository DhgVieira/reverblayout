<?php 
include 'auth.php';
include 'lib.php';

$iditem = request("iditem");
$idc = request("idc");
$excestoque = request("exce");
$motivo = request("motivo");

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
    
    $vl_geral = 0;
    $sql = "select NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_CESTA_CESO, VL_PRODUTO_CESO, DS_CATEGORIA_PTRC, DS_PRODUTO2_PRRC
             FROM cestas, produtos, produtos_tipo WHERE NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC 
             and NR_SEQ_COMPRA_CESO = $idc";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
    	while($row = mysql_fetch_row($st)) {
            $id_tamanho = $row[0];
            $nr_qtde    = $row[1];
            $nr_produto = $row[2];
            $item       = $row[3];
            $vl_prod	= $row[4];
            $ds_categ	= $row[5];
            $ds_produ	= $row[6];
            
            if ($item == $iditem){
                $str = "DELETE FROM cestas WHERE NR_SEQ_CESTA_CESO = $iditem";
                $stUp = mysql_query($str);
                
                if ($excestoque == "S"){
                    $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC + ".$nr_qtde." WHERE NR_SEQ_TAMANHO_ESRC = $id_tamanho AND NR_SEQ_PRODUTO_ESRC = $nr_produto";
                    $st4 = mysql_query($str4); 
                    GravaLogEstoque($SS_logadm,$nr_produto,$id_tamanho,"Adicionou $nr_qtde","Alteração: Exclusão item Compra Nr $idc",$nr_qtde);
                }else{
                    $corpo = "<table width=\"557\" height=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
                    $corpo .= "<tr><td width=\"557\" height=\"87\" valign=\"bottom\" colspan=\"3\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" width=\"557\" height=\"87\"></td>";
                    $corpo .= "</tr><tr>";
                    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
                    $corpo .= "<td><table width=\"100%\" cellpadding=\"3\" cellspacing=\"3\">";
                    $corpo .= "<tr><td style=\"font-family:Arial, Helvetica, sans-serif;\" width=\"555\">";
                    $corpo .= "<strong>Exclusão de item SEM VOLTA ao estoque</strong>";
                    $corpo .= "<br /><br />";
                    $corpo .= "O usuário <strong>$SS_login</strong> removeu um item de compra sem retorná-lo ao estoque, detalhes:";
                    $corpo .= "<br /><br />";
                    $corpo .= "<strong>Compra:</strong> <a href=http://reverbcity.com/Readm_911s/compras.php?nrpedido=$idc>$idc</a><br />";
                    $corpo .= "<strong>Data:</strong> ".date("d/m/Y G:i")."<br />";
                    $corpo .= "<strong>Produto:</strong> $ds_categ - $ds_produ<br />";
                    $corpo .= "<strong>Quantidade:</strong> $nr_qtde<br />";
                    if ($motivo){
                        $corpo .= "<strong>Motivo:</strong> $motivo<br />";
                    }
                    $corpo .= "<br /><br />";
                    $corpo .= "Esta ação implica na sobra do produto em estoque uma vez que o seu saldo não foi debitado.";
                    $corpo .= "<br /><br />";
                    $corpo .= "Reverbcity Skynet System<br />";
                    $corpo .= "www.reverbcity.com";
                    $corpo .= "</td></tr>";
                    $corpo .= "</table></td>";
                    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
                    $corpo .= "</tr><tr>";
                    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
                    $corpo .= "<td height=\"1\">&nbsp;</td>";
                    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
                    $corpo .= "</tr><tr><td width=\"557\" height=\"26\" colspan=\"3\" valign=\"top\"><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" width=\"557\" height=\"26\" border=0></td>";
                    $corpo .= "</tr></table>";
                    
                    EnviaMailer("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","Tony","","Exclusao de Produto sem volta ao estoque",$corpo);

                    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Excluiu item $nr_produto da compra $idc mas nao permitiu a volta ao estoque");
                }
            }else{
                $vl_geral += ($vl_prod*$nr_qtde);
            }
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

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou item da compra $idc");
mysql_close($con);

Header("Location: compras_alt.php?idc=$idc");
exit();
?>