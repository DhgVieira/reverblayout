<?php
include 'auth.php';
include 'lib.php';
	$aba = request("aba");
	$datadiavd = request("datadiavd");
$corpo="";
$largura = 820;
$x=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatorio</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 16px;
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
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Vendas L&iacute;quidas Di&aacute;rias</strong><br /><font size="-1"><?php echo $datadiavd?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table cellpadding="2" cellspacing="2" width="<?php echo $largura; ?>">
<?php
$tot = 0;

$dtarray = explode('/', $datadiavd);

$anorequ = $dtarray[2];
$mesrequ = $dtarray[1];
$diarequ = $dtarray[0];

//$anorequ = date("Y",strtotime($datadiavd));
//$mesrequ = date("d",strtotime($datadiavd));
//$diarequ = date("m",strtotime($datadiavd));

if ($anorequ && $mesrequ){
    BuscaAno($anorequ,$mesrequ,$diarequ);
}

function BuscaAno($byano,$bymes,$bydia){
    $largura = 820;
    $str = "select
                day(DT_PAGAMENTO_COSO), 
            	month(DT_PAGAMENTO_COSO),
                VL_TOTAL_COSO,
                VL_FRETE_COSO,
                if (VL_FRETECUSTO_COSO>0,VL_FRETECUSTO_COSO,VL_FRETE_COSO),
                NR_PARCELAS_COSO,
                DS_FORMAPGTO_COSO,
                NR_SEQ_COMPRA_COSO
            from compras where
            	ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND NR_SEQ_LOJA_COSO = 1 and
            	YEAR(DT_PAGAMENTO_COSO) = $byano AND MONTH(DT_PAGAMENTO_COSO) = $bymes AND day(DT_PAGAMENTO_COSO) = $bydia and
                NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
            order by month(DT_PAGAMENTO_COSO), day(DT_PAGAMENTO_COSO)";
    $st = mysql_query($str);
    
    if (mysql_num_rows($st) > 0) {
        $mesatual = "";
        $total_bruto = 0;
        $total_sfrete = 0;
        $total_fretec = 0;
        $total_tarifas = 0;
        $total_custo = 0;
        while($row = mysql_fetch_row($st)) {
    		$dia	   	= $row[0];
    		$mes		= $row[1];
            $vlr_bruto	= $row[2];
            $vlr_frete	= $row[3];
            $vlr_fretec	= $row[4];
            $parcelas   = $row[5];
            $forma      = $row[6];
            $idcompra   = $row[7];
            
            $tarifasdia = 0;
            
            $custo = CalculaCusto($vlr_bruto,$forma,$parcelas,$loja=0);
            $tarifasdia += $custo;
            

            if ($mesatual != $mes){
                if ($total_bruto > 0){
                    ?>
                    <tr bgcolor="#E8E7E6">
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>
                        <td align="right">R$ <?php echo number_format($total_frete,2,",","."); ?></td>
                        <td align="right">R$ <?php echo number_format($total_sfrete,2,",","."); ?></td>
                        <!--<td align="right">R$ <?php echo number_format($total_custo,2,",","."); ?></td>-->
                        <td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>
                        <td align="right">R$ <?php echo number_format($total_fretec,2,",","."); ?></td>
                        <td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas-$total_fretec,2,",","."); ?></strong></td>
                    </tr>
                    <?php
                    $total_bruto = 0;
                    $total_fretec = 0;
                    $total_tarifas = 0;
                    $total_custo = 0;
                    $total_sfrete = 0;
                }
                ?>
                <tr bgcolor="silver">
                    <td align="center"><strong>DIA/M&Ecirc;S</strong></td>
                    <td align="center"><strong>COMPRA</strong></td>
                    <td align="right"><strong>VLR TOTAL</strong></td>
                    <td align="right"><strong>VLR FRETE</strong></td>
                    <td align="right"><strong>VLR S/FRETE</strong></td>
                    <!--<td align="right"><strong>CUSTO(40%)</strong></td>-->
                    <td align="right"><strong>TARIFAS</strong></td>
                    <td align="right"><strong>CUSTO FRETE</strong></td>
                    <td align="right"><strong>VLR L&Iacute;QUIDO</strong></td>
                </tr>
                <tr><td colspan="9" height="2"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
                <?php
                $mesatual = $mes;
            }
            $total_bruto += $vlr_bruto;
            $total_frete += $vlr_frete;
            $total_fretec += $vlr_fretec;
            $total_tarifas += $tarifasdia;
            
            $custo = ($vlr_bruto - $vlr_fretec)*40/100;
            $total_custo += $custo;
            
            $vlr_sem_frete = $vlr_bruto - $vlr_frete;
            $total_sfrete += $vlr_sem_frete;
            ?>
             <tr>
                <td align="center"><strong><?php echo str_pad($dia,2,"0",STR_PAD_LEFT); ?>/<?php echo str_pad($mes,2,"0",STR_PAD_LEFT); ?></strong></td>
                <td align="center"><strong><?php echo $idcompra; ?></strong></td>
                <td align="right">R$ <?php echo number_format($vlr_bruto,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_frete,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_sem_frete,2,",","."); ?></td>
                <!--<td align="right">R$ <?php echo number_format($custo,2,",","."); ?></td>-->
                <td align="right">R$ <?php echo number_format($tarifasdia,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_fretec,2,",","."); ?></td>
                <td align="right"><strong>R$ <?php echo number_format($vlr_bruto-$tarifasdia-$vlr_fretec,2,",","."); ?></strong></td>
             </tr>
             <?php
        }
    }
    if ($total_bruto > 0){
    ?>
    <tr><td colspan="9" height="2"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
    <tr bgcolor="#E8E7E6">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_frete,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_sfrete,2,",","."); ?></td>
        <!--<td align="right">R$ <?php echo number_format($total_custo,2,",","."); ?></td>-->
        <td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_fretec,2,",","."); ?></td>
        <td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas-$total_fretec,2,",","."); ?></strong></td>
    </tr>
    <?php
    $total_bruto = 0;
    $total_fretec = 0;
    $total_tarifas = 0;
    $total_custo = 0;
    $total_sfrete = 0;
}
}
?>
</table>
<table width="<?php echo $largura; ?>" >
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
</body>
</html>