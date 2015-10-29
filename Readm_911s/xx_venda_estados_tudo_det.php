<?php
include 'lib.php';
include 'auth.php';
$anorequ = request("ano");
$mesrequ = request("mes");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 12px;
    }
</style>
</head>
<body>
<strong>N&Uacute;MERO DE ITENS VENDIDOS POR DIA DO M&Ecirc;S <?php echo $mesrequ; ?>/<?php echo $anorequ; ?> (TODOS)</strong>
<table cellpadding="5">
<?php
$tot = 0;

if ($anorequ && $mesrequ){
    BuscaAno($anorequ,$mesrequ);
}

function BuscaAno($byano,$bymes){
    $str = "select
            	count(*),
            	day(DT_COMPRA_COSO), 
                month(DT_COMPRA_COSO)
            from compras where
            	ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND NR_SEQ_LOJA_COSO = 1 and
            	YEAR(DT_COMPRA_COSO) = $byano AND 
                NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
            group by day(DT_COMPRA_COSO), month(DT_COMPRA_COSO), year(DT_COMPRA_COSO)
            order by year(DT_COMPRA_COSO), month(DT_COMPRA_COSO), day(DT_COMPRA_COSO)";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $mesatual = "";
        $total_qtde = 0;
        ?>
        <tr><td colspan="7">&nbsp;</td></tr>
        <tr bgcolor="silver">
            <td align="center"><strong>DIA/M&Ecirc;S</strong></td>
            <?php
            $sql = "DESCRIBE fretes";
            $stpai = mysql_query($sql);
            while($rowpai = mysql_fetch_row($stpai)) {
                $estado = $rowpai[0];
                if ($estado != "NR_SEQ_FRETE_FRRC" && $estado != "NR_FAIXAPESO_FRRC"){ ?>
                <td align="center"><strong><?php echo $estado ?></strong></td>
            <?php
                }
            }
            ?>
            <td align="center"><strong>QTDE TOTAL</strong></td>
        </tr>
        <?php
        $x=0;
        while($row = mysql_fetch_row($st)) {
            $qtde       = $row[0];
    		$dia	   	= $row[1];
    		$mes		= $row[2];
            
            $total_qtde = 0;
            if ($x==0){
                $cor = "#ffffff";
                $x = 1;
            }else{
                $cor = "#E9E9E9";
                $x = 0;
            }
            ?>
             <tr bgcolor="<?php echo $cor; ?>">
                <td align="center"><strong><?php echo str_pad($dia,2,"0",STR_PAD_LEFT); ?>/<?php echo str_pad($mes,2,"0",STR_PAD_LEFT); ?></strong></td>
                <?php
                $sql = "DESCRIBE fretes";
                $stpai = mysql_query($sql);
                while($rowpai = mysql_fetch_row($stpai)) {
                    $estado = $rowpai[0];
                    if ($estado != "NR_SEQ_FRETE_FRRC" && $estado != "NR_FAIXAPESO_FRRC"){ 
                        $qtdeest = 0;
                        if ($estado == "LONDRINA"){
                            $sql2 = "select sum(NR_QTDE_CESO) from compras, cadastros, cestas, produtos where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                     NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                     and ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A'
                                     AND NR_SEQ_LOJA_COSO = 1 and YEAR(DT_PAGAMENTO_COSO) = $byano AND MONTH(DT_PAGAMENTO_COSO) = $mes
                                     AND DAY(DT_PAGAMENTO_COSO) = $dia
                                     AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) 
                                     AND DS_CIDADE_CASO like '%".$estado."%' AND DS_UF_CASO = 'PR'";
                            $st2 = mysql_query($sql2);
                            $row2 = mysql_fetch_row($st2);
                            $qtdeest = $row2[0];
                        }else if ($estado == "PR"){
                            $sql2 = "select sum(NR_QTDE_CESO) from compras, cadastros, cestas, produtos where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                     NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                     and ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A'
                                     AND NR_SEQ_LOJA_COSO = 1 and YEAR(DT_PAGAMENTO_COSO) = $byano AND MONTH(DT_PAGAMENTO_COSO) = $mes
                                     AND DAY(DT_PAGAMENTO_COSO) = $dia
                                     AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) 
                                     AND DS_CIDADE_CASO <> 'Londrina' AND DS_UF_CASO = 'PR'";
                            $st2 = mysql_query($sql2);
                            $row2 = mysql_fetch_row($st2);
                            $qtdeest = $row2[0];
                        }else{
                            $sql2 = "select sum(NR_QTDE_CESO) from compras, cadastros, cestas, produtos where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                     NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                     and ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A'
                                     AND NR_SEQ_LOJA_COSO = 1 and YEAR(DT_PAGAMENTO_COSO) = $byano AND MONTH(DT_PAGAMENTO_COSO) = $mes
                                     AND DAY(DT_PAGAMENTO_COSO) = $dia
                                     AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) 
                                     AND DS_UF_CASO = '".$estado."'";
                            $st2 = mysql_query($sql2);
                            $row2 = mysql_fetch_row($st2);
                            $qtdeest = $row2[0];
                        }
                        if (!$qtdeest) $qtdeest = 0;
                        $total_qtde += $qtdeest;
                    ?>
                    <td align="center"><strong><?php echo $qtdeest; ?></strong></td>
                <?php
                    }
                }
                ?>
                <td align="center" bgcolor="#E9E9E9"><strong><?php echo $total_qtde; ?></strong></td>
             </tr>
             <?php
        }
    }
    //if ($total_bruto > 0){
    ?>
    <!--
    <tr bgcolor="#E8E7E6" style="font-weight: bold;">
        <td align="center">&nbsp;</td>
        <td align="center"><?php echo $total_qtde; ?></td>
    </tr>
    -->
    <?php
    //}
}
?>
</table>
</body>
</html>