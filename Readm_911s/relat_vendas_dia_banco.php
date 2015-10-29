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
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Vendas Di&aacute;rias</strong><br /><font size="-1">Vendas totais brutas do m&ecirc;s <?php echo $mesrequ?>/<?php echo $anorequ?></font></td>
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
    $str = "select
            	count(*),
                day(DT_PAGAMENTO_COSO), 
            	month(DT_PAGAMENTO_COSO),	
            	sum(VL_TOTAL_COSO), 
            	sum(VL_FRETE_COSO), 
            	sum(if (VL_FRETECUSTO_COSO>0,VL_FRETECUSTO_COSO,VL_FRETE_COSO))
            from compras where
            	ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND NR_SEQ_LOJA_COSO = 1 and
            	YEAR(DT_PAGAMENTO_COSO) = $byano AND MONTH(DT_PAGAMENTO_COSO) = $bymes AND
                NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
            group by day(DT_PAGAMENTO_COSO), month(DT_PAGAMENTO_COSO)
            order by month(DT_PAGAMENTO_COSO), day(DT_PAGAMENTO_COSO)";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $mesatual = "";
        
        $total_bruto = 0;
        $total_bruto_boleto = 0;
        $total_bruto_cartao = 0;
        $total_bruto_outras = 0;
        $total_custoboleto = 0;
        $total_custocartoes = 0;
        $total_tarifas = 0;
        $total_qtde = 0;
        $total_qtde_boleto = 0;
        $total_qtde_cartao = 0;
        $total_qtde_outras = 0;
        
        while($row = mysql_fetch_row($st)) {
            $qtde       = $row[0];
    		$dia	   	= $row[1];
    		$mes		= $row[2];
            $vlr_bruto	= $row[3];
            $vlr_frete	= $row[4];
            $vlr_fretec	= $row[5];
            
            $tarifasdia = 0;
            
            $custoboleto = 0;
            $custocartoes = 0;
            $qtdeboleto = 0;
            $qtdecartao = 0;
            $qtdeoutras = 0;
            $vlr_bruto_boleto = 0;
            $vlr_bruto_cartao = 0;
            $vlr_bruto_outras = 0;
            
            $sqlt = "select VL_TOTAL_COSO, DS_FORMAPGTO_COSO, NR_PARCELAS_COSO from compras where day(DT_PAGAMENTO_COSO) = $dia and month(DT_PAGAMENTO_COSO) = $mes and year(DT_PAGAMENTO_COSO) = $byano
                     and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'  AND NR_SEQ_LOJA_COSO = 1 and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
            $st2 = mysql_query($sqlt); 
            if (mysql_num_rows($st2) > 0) {
                while($row2 = mysql_fetch_row($st2)) {
                    $vltotal  = $row2[0];
                    $forma    = $row2[1];
                    $parcelas = $row2[2];
                    $custo = CalculaCusto($vltotal,$forma,$parcelas,$loja=0);
                    if ($forma == "boleto"){
                        $custoboleto += $custo;
                        $vlr_bruto_boleto += $vltotal;
                        $qtdeboleto ++;
                    }else if ($forma == "visa" || $forma == "master" || $forma == "mastercard" || $forma == "diners" || $forma == "debitovisa" || $forma == "debitomaster"){
                        $custocartoes += $custo;
                        $vlr_bruto_cartao += $vltotal;
                        $qtdecartao++;
                    }else{
                        $vlr_bruto_outras += $vltotal;
                        $qtdeoutras++;
                    }
                    
                    
                    $tarifasdia += $custo;
                }
            }
            

            if ($mesatual != $mes){
                if ($total_bruto > 0){
                    ?>
                    <tr bgcolor="#E8E7E6" style="font-weight: bold;">
                        <td align="center">&nbsp;</td>
                        <td align="center"><?php echo $total_qtde_boleto; ?></td>
                        <!--<td align="right">R$ <?php echo number_format($total_bruto_boleto,2,",","."); ?></td>-->
                        <!--<td align="right">R$ <?php echo number_format($total_custoboleto,2,",","."); ?></td>-->
                        <td align="right"><strong>R$ <?php echo number_format($total_bruto_boleto-$total_custoboleto,2,",","."); ?></strong></td>
                        <td align="center"><?php echo $total_qtde_cartao; ?></td>
                        <!--<td align="right">R$ <?php echo number_format($total_bruto_cartao,2,",","."); ?></td>-->
                        <!--<td align="right">R$ <?php echo number_format($total_custocartoes,2,",","."); ?></td>-->
                        <td align="right"><strong>R$ <?php echo number_format($total_bruto_cartao-$total_custocartoes,2,",","."); ?></strong></td>
                        <td align="center"><?php echo $total_qtde_outras; ?></td>
                        <td align="right">R$ <?php echo number_format($total_bruto_outras,2,",","."); ?></td>
                        <td align="center"><?php echo $total_qtde; ?></td>
                        <!--<td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>-->
                        <!--<td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>-->
                        <td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas,2,",","."); ?></strong></td>
                    </tr>
                    <?php
                    $total_bruto = 0;
                    $total_tarifas = 0;
                    $total_qtde = 0;
                    $total_custoboleto = 0;
                    $total_custocartoes = 0;
                    $total_bruto_boleto = 0;
                    $total_bruto_cartao = 0;
                    $total_qtde_boleto = 0;
                    $total_qtde_cartao = 0;
                    $total_qtde_outras = 0;
                }
                ?>
                <tr bgcolor="silver">
                    <td align="center"><strong>DIA/M&Ecirc;S</strong></td>
                    <td align="center"><strong>TOTAL BOLETO</strong></td>
                    <!--<td align="right"><strong>VLR TOTAL BOLETO</strong></td>-->
                    <!--<td align="right"><strong>TARIFAS BOLETO</strong></td>-->
                    <td align="right" nowrap="nowrap"><strong>L&Iacute;QUIDO BOLETO</strong></td>
                    <td align="center"><strong>TOTAL CARTAO</strong></td>
                    <!--<td align="right"><strong>VLR TOTAL CARTAO</strong></td>-->
                    <!--<td align="right"><strong>TARIFAS CARTOES</strong></td>-->
                    <td align="right" nowrap="nowrap"><strong>L&Iacute;QUIDO CARTOES</strong></td>
                    <td align="center"><strong>TOTAL OUTROS</strong></td>
                    <td align="right"><strong>TOTAL OUTROS</strong></td>
                    <td align="center"><strong>QTDE TOTAL.</strong></td>
                    <!--<td align="right"><strong>VLR TOTAL</strong></td>-->
                    <!--<td align="right"><strong>TARIFAS TOTAL</strong></td>-->
                    <td align="right" nowrap="nowrap"><strong>VLR L&Iacute;QUIDO</strong></td>
                </tr>
                <tr><td colspan="9" height="2"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
                <?php
                $mesatual = $mes;
            }
            $total_bruto += $vlr_bruto;
            $total_qtde += $qtde;
            $total_tarifas += $tarifasdia;
            $total_custoboleto += $custoboleto;
            $total_custocartoes += $custocartoes;
            $total_bruto_boleto += $vlr_bruto_boleto;
            $total_bruto_cartao += $vlr_bruto_cartao;
            $total_bruto_outras += $vlr_bruto_outras;
            $total_qtde_boleto += $qtdeboleto;
            $total_qtde_cartao += $qtdecartao;
            $total_qtde_outras += $qtdeoutras;
            ?>
             <tr>
                <td align="center"><strong><?php echo str_pad($dia,2,"0",STR_PAD_LEFT); ?>/<?php echo str_pad($mes,2,"0",STR_PAD_LEFT); ?></strong></td>
                <td align="center" bgcolor="#E9E9E9"><strong><?php echo $qtdeboleto; ?></strong></td>
                <!--<td align="right">R$ <?php echo number_format($vlr_bruto_boleto,2,",","."); ?></td>-->
                <!--<td align="right">R$ <?php echo number_format($custoboleto,2,",","."); ?></td>-->
                <td align="right">R$ <?php echo number_format($vlr_bruto_boleto-$custoboleto,2,",","."); ?></td>
                <td align="center" bgcolor="#E9E9E9"><strong><?php echo $qtdecartao; ?></strong></td>
                <!--<td align="right">R$ <?php echo number_format($vlr_bruto_cartao,2,",","."); ?></td>-->
                <!--<td align="right">R$ <?php echo number_format($custocartoes,2,",","."); ?></td>-->
                <td align="right">R$ <?php echo number_format($vlr_bruto_cartao-$custocartoes,2,",","."); ?></td>
                <td align="center" bgcolor="#E9E9E9"><strong><?php echo $qtdeoutras; ?></strong></td>
                <td align="right">R$ <?php echo number_format($vlr_bruto_outras,2,",","."); ?></td>
                <td align="center" bgcolor="#E9E9E9"><strong><?php echo $qtde; ?></strong></td>
                <!--<td align="right" bgcolor="#E9E9E9">R$ <?php echo number_format($vlr_bruto,2,",","."); ?></td>-->
                <!--<td align="right" bgcolor="#E9E9E9">R$ <?php echo number_format($tarifasdia,2,",","."); ?></td>-->
                <td align="right" bgcolor="#E9E9E9">R$ <?php echo number_format($vlr_bruto-$tarifasdia,2,",","."); ?></td>
             </tr>
             <?php
        }
    }
    if ($total_bruto > 0){
    ?>
    <tr><td colspan="9" height="2"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
    <tr bgcolor="#E8E7E6" style="font-weight: bold;">
        <td align="center">&nbsp;</td>
        <td align="center"><?php echo $total_qtde_boleto; ?></td>
        <!--<td align="right">R$ <?php echo number_format($total_bruto_boleto,2,",","."); ?></td>-->
        <!--<td align="right">R$ <?php echo number_format($total_custoboleto,2,",","."); ?></td>-->
        <td align="right"><strong>R$ <?php echo number_format($total_bruto_boleto-$total_custoboleto,2,",","."); ?></strong></td>
        <td align="center"><?php echo $total_qtde_cartao; ?></td>
        <!--<td align="right">R$ <?php echo number_format($total_bruto_cartao,2,",","."); ?></td>-->
        <!--<td align="right">R$ <?php echo number_format($total_custocartoes,2,",","."); ?></td>-->
        <td align="right"><strong>R$ <?php echo number_format($total_bruto_cartao-$total_custocartoes,2,",","."); ?></strong></td>
        <td align="center"><?php echo $total_qtde_outras; ?></td>
        <td align="right">R$ <?php echo number_format($total_bruto_outras,2,",","."); ?></td>
        <td align="center"><?php echo $total_qtde; ?></td>
        <!--<td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>-->
        <!--<td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>-->
        <td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas,2,",","."); ?></strong></td>
    </tr>
    <?php
    $total_bruto = 0;
    $total_tarifas = 0;
    $total_qtde = 0;
    $total_custoboleto = 0;
    $total_custocartoes = 0;
    $total_bruto_boleto = 0;
    $total_bruto_cartao = 0;
    $total_qtde_boleto = 0;
    $total_qtde_cartao = 0;
    $total_qtde_outras = 0;
}
}
?>
</table>
<table width="<?php echo $largura; ?>" >
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
</body>
</html>