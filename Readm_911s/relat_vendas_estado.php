<?php
include 'auth.php';
include 'lib.php';
	$aba = request("aba");
$corpo="";
$largura = 820;
$x=0;
$anorequ = request("ano");
$mesrequ = request("mes");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatorio</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 15px;
    }
    	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:20px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:14px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
</head>
<body>
<table width="<?php echo $largura; ?>" >
	<tr><td>&nbsp;</td>
    	<td align="right">&nbsp;</td>
    	<td align="right">&nbsp;</td>
        <td  align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Vendas por Estados</strong><br /><font size="-1">M&ecirc;s <?php echo $mesrequ?>/<?php echo $anorequ?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table cellpadding="2" cellspacing="2" width="<?php echo $largura; ?>">
<?php
$tot = 0;

if ($anorequ && $mesrequ){
    BuscaAno($anorequ,$mesrequ);
}

function BuscaAno($byano,$bymes){
    $largura = 820;
    $totais = array();
    $totalgeral = 0;
    $str = "select
            	count(*),
            	day(DT_PAGAMENTO_COSO), 
                month(DT_PAGAMENTO_COSO)
            from compras where
            	ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND NR_SEQ_LOJA_COSO = 1 and
            	YEAR(DT_PAGAMENTO_COSO) = $byano AND MONTH(DT_PAGAMENTO_COSO) = $bymes AND
                NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
            group by day(DT_PAGAMENTO_COSO), month(DT_PAGAMENTO_COSO)
            order by month(DT_PAGAMENTO_COSO), day(DT_PAGAMENTO_COSO)";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $mesatual = "";
        ?>
        <tr bgcolor="silver">
            <td align="center"><strong>DIA/M&Ecirc;S</strong></td>
            <?php
            $sql = "DESCRIBE fretes";
            $stpai = mysql_query($sql);
            $t=0;
            while($rowpai = mysql_fetch_row($stpai)) {
                $estado = $rowpai[0];
                if ($estado != "NR_SEQ_FRETE_FRRC" && $estado != "NR_FAIXAPESO_FRRC"){ ?>
                <td align="center"><strong><?php echo $estado ?></strong></td>
            <?php
                $totais[$t]=0;
                $t++;
                }
            }
            ?>
            <td align="center"><strong>QTDE TOTAL.</strong></td>
        </tr>
        <tr><td colspan="30" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
        <?php
        
        while($row = mysql_fetch_row($st)) {
            $qtde       = $row[0];
    		$dia	   	= $row[1];
    		$mes		= $row[2];
            
            $t=0;+
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
                $x=0;
                while($rowpai = mysql_fetch_row($stpai)) {
                    $estado = $rowpai[0];
                    if ($estado != "NR_SEQ_FRETE_FRRC" && $estado != "NR_FAIXAPESO_FRRC"){ 
                        $qtdeest = 0;
                        if ($estado == "LONDRINA"){
                            $sql2 = "SELECT 
                                        SUM(NR_QTDE_CESO)
                                    FROM
                                        compras
                                            INNER JOIN
                                        cadastros ON NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                                            INNER JOIN
                                        cestas ON NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                            INNER JOIN
                                        produtos ON NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                    WHERE
                                        ST_COMPRA_COSO <> 'C'
                                            AND ST_COMPRA_COSO <> 'A'
                                            AND NR_SEQ_LOJA_COSO = 1
                                            AND YEAR(DT_PAGAMENTO_COSO) = $byano
                                            AND MONTH(DT_PAGAMENTO_COSO) = $mes
                                            AND DAY(DT_PAGAMENTO_COSO) = $dia
                                            AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364)
                                            AND DS_CIDADE_CASO LIKE '%".$estado."%'
                                            AND DS_UF_CASO = 'PR'";
                            $st2 = mysql_query($sql2);
                            $row2 = mysql_fetch_row($st2);
                            $qtdeest = $row2[0];
                        }else if ($estado == "PR"){
                            $sql2 = "SELECT 
                                        SUM(NR_QTDE_CESO)
                                    FROM
                                        compras
                                            INNER JOIN
                                        cadastros ON NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                                            INNER JOIN
                                        cestas ON NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                            INNER JOIN
                                        produtos ON NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                    WHERE
                                        ST_COMPRA_COSO <> 'C'
                                            AND ST_COMPRA_COSO <> 'A'
                                            AND NR_SEQ_LOJA_COSO = 1
                                            AND YEAR(DT_PAGAMENTO_COSO) = $byano
                                            AND MONTH(DT_PAGAMENTO_COSO) = $mes
                                            AND DAY(DT_PAGAMENTO_COSO) = $dia
                                            AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364)
                                            AND DS_CIDADE_CASO <> 'Londrina'
                                            AND DS_UF_CASO = 'PR'";
                            $st2 = mysql_query($sql2);
                            $row2 = mysql_fetch_row($st2);
                            $qtdeest = $row2[0];
                        }else{
                            $sql2 = "SELECT 
                                        SUM(NR_QTDE_CESO)
                                    FROM
                                        compras
                                            INNER JOIN
                                        cadastros ON NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                                            INNER JOIN
                                        cestas ON NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                            INNER JOIN
                                        produtos ON NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                    WHERE
                                        ST_COMPRA_COSO <> 'C'
                                            AND ST_COMPRA_COSO <> 'A'
                                            AND NR_SEQ_LOJA_COSO = 1
                                            AND YEAR(DT_PAGAMENTO_COSO) = $byano
                                            AND MONTH(DT_PAGAMENTO_COSO) = $mes
                                            AND DAY(DT_PAGAMENTO_COSO) = $dia
                                            AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364)
                                            AND DS_UF_CASO = '".$estado."'";
                            $st2 = mysql_query($sql2);
                            $row2 = mysql_fetch_row($st2);
                            $qtdeest = $row2[0];
                        }
                        if (!$qtdeest) $qtdeest = 0;
                        $total_qtde += $qtdeest;
                        $totalgeral += $qtdeest;
                        $totais[$t] += $qtdeest;
                        $t++;
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
    <tr><td height="1" colspan="30"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
    <tr bgcolor="#E8E7E6" style="font-weight: bold;">
        <td align="center">&nbsp;</td>
        <?php foreach ($totais as $estadost) { ?>
        <td align="center"><strong><?php echo $estadost; ?></strong></td>
        <?php } ?>
        <td align="center"><strong><?php echo $totalgeral; ?></strong></td>
    </tr>
    <?php
    //}
}
?>
</table>
<table width="<?php echo $largura; ?>" >
	<tr><td height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
</body>
</html>