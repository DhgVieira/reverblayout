<?php
include 'auth.php';
include 'lib.php';

$largura = 880;
$x=0;

$salario = 1200;

$primrodiacomp = date("Y-m-d", strtotime("-7 days"))." 00:00:00";

$ultimodiacomp = date("Y-m-d")." 23:59:59";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatorio</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 12px;
    }
    	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:18px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
</head>
<body>
<table width="<?php echo $largura; ?>" >
	<tr><td>&nbsp;</td>
    	<td align="right">&nbsp;</td>
    	<td align="right">&nbsp;</td>
        <td  align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table width="<?php echo $largura; ?>" >
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Vendas de Atacado M&ecirc;s <?php echo date("d/m",strtotime($primrodiacomp));?> Até <?php echo date("d/m",strtotime($ultimodiacomp));?></strong><br /><font size="-1">Loja: Londrina/Internet</font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table cellpadding="2" cellspacing="2" width="<?php echo $largura; ?>">
    <tr bgcolor="silver">
        <td align="center">&nbsp;</td>
        <td align="center"><strong>NR.COMPRA</strong></td>
        <td align="center"><strong>DATA COMPRA</strong></td>
        <td align="center"><strong>FORMA DE PGTO.</strong></td>
        <td align="center"><strong>PARCELAS</strong></td>
        <td align="center"><strong>VALOR</strong></td>
        <td align="center"><strong>FRETE</strong></td>
        <td align="center"><strong>CUSTO FRETE</strong></td>
        <td align="center"><strong>TAXAS</strong></td>
        <td align="center"><strong>IMPOSTOS</strong></td>
        <td align="center"><strong>CUSTO</strong></td>
        <td align="center"><strong>COMISS&Atilde;O (4%)</strong></td>
        <td align="center"><strong>VLR.L&Iacute;QUIDO</strong></td>
    </tr>
<?php
$str = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, NR_PARCELAS_COSO, VL_TOTAL_COSO, VL_FRETE_COSO,
        if (VL_FRETECUSTO_COSO>0,VL_FRETECUSTO_COSO,VL_FRETE_COSO)
        from compras, cadastros where
        	NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND 
        	TP_CADASTRO_CACH = 1 and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) AND
        	ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' AND NR_SEQ_LOJA_COSO = 1
        	and day(DT_COMPRA_COSO) >= ".date("d",strtotime($primrodiacomp))." and day(DT_COMPRA_COSO) <= ".date("d",strtotime($ultimodiacomp)) . " AND month(DT_COMPRA_COSO) = ". date("m", strtotime($primrodiacomp)) ." and year(DT_COMPRA_COSO) = " . date("Y", strtotime($primrodiacomp));

          
        
if ($boleto=="S"){
    $str .= " and DS_FORMAPGTO_COSO = 'boleto' ";
}

$str .= " ORDER BY DT_COMPRA_COSO";

$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
    
    $tot_vlr_total = 0;
    $tot_vlr_frete = 0;
    $tot_vlr_fretecusto = 0;
    $tot_taxas = 0;
    $tot_impostos = 0;
    $tot_custo = 0;
    $tot_comissao = 0;
    $tot_vlr_liquido = 0;
    
    $tot_vlr_total2 = 0;
    $tot_vlr_frete2 = 0;
    $tot_vlr_fretecusto2 = 0;
    $tot_taxas2 = 0;
    $tot_impostos2 = 0;
    $tot_custo2 = 0;
    $tot_comissao2 = 0;
    $tot_vlr_liquido2 = 0;
    
    while($row = mysql_fetch_row($st)) {
		$nrcompra	   	= $row[0];
		$dt_compra		= $row[1];
        $ds_formpgto	= $row[2];
        $nr_parcelas	= $row[3];
        $vlr_total		= $row[4];
        $vlr_frete		= $row[5];
        $vlr_fretecusto	= $row[6];
        
        
        $taxas = CalculaCusto($vlr_total,$ds_formpgto,$nr_parcelas);
        $impostos = ($vlr_total*0.0565)+($vlr_total*0.07);
        $custo = ($vlr_total-$vlr_frete)*40/100;
        $comissao = ($vlr_total-$vlr_fretecusto)*4/100;
        $vlr_liquido = $vlr_total-$vlr_fretecusto-$taxas-$impostos-$custo-$comissao;
        
        $tot_vlr_total += $vlr_total;
        $tot_vlr_frete += $vlr_frete;
        $tot_vlr_fretecusto += $vlr_fretecusto;
        $tot_taxas += $taxas;
        $tot_impostos += $impostos;
        $tot_custo += $custo;
        $tot_comissao += $comissao;
        $tot_vlr_liquido += $vlr_liquido;
        
        $tot_vlr_total2 += $vlr_total;
        $tot_vlr_frete2 += $vlr_frete;
        $tot_vlr_fretecusto2 += $vlr_fretecusto;
        $tot_taxas2 += $taxas;
        $tot_impostos2 += $impostos;
        $tot_custo2 += $custo;
        $tot_comissao2 += $comissao;
        $tot_vlr_liquido2 += $vlr_liquido;
        ?>
        <tr>
            <td align="center">&nbsp;</td>
            <td align="center"><a target="_blank" href="http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=<?php echo $nrcompra; ?>"><?php echo $nrcompra; ?></a></td>
            <td align="center"><?php echo date("d/m/Y g:i",strtotime($dt_compra)); ?></td>
            <td align="center"><?php echo $ds_formpgto; ?></td>
            <td align="center"><?php echo $nr_parcelas; ?></td>
            <td align="right">R$ <?php echo number_format($vlr_total,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($vlr_frete,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($vlr_fretecusto,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($taxas,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($impostos,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($custo,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($comissao,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($vlr_liquido,2,",","."); ?></td>
        </tr>
        <?php
    }
}

?>
<tr bgcolor="#DFDFDF">
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_total,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_frete,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_fretecusto,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_taxas,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_impostos,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_custo,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_comissao,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_liquido,2,",","."); ?></strong></td>
</tr>
<tr><td colspan="9">&nbsp;</td></tr>
<tr bgcolor="#DFDFDF">
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_total2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_frete2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_fretecusto2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_taxas2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_impostos2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_custo2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_comissao2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_liquido2,2,",","."); ?></strong></td>
</tr>
</table>
<table width="<?php echo $largura; ?>" >
    <tr><td height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table width="<?php echo $largura; ?>" >
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Vendas de Atacado SP M&ecirc;s <?php echo date("d/m",strtotime($primrodiacomp));?> Até <?php echo date("d/m",strtotime($ultimodiacomp));?></strong><br /><font size="-1">Loja: Pocket Store SP</font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table cellpadding="2" cellspacing="2" width="<?php echo $largura; ?>">
    <tr bgcolor="silver">
        <td align="center">&nbsp;</td>
        <td align="center"><strong>NR.COMPRA</strong></td>
        <td align="center"><strong>DATA COMPRA</strong></td>
        <td align="center"><strong>FORMA DE PGTO.</strong></td>
        <td align="center"><strong>PARCELAS</strong></td>
        <td align="center"><strong>VALOR</strong></td>
        <td align="center"><strong>FRETE</strong></td>
        <td align="center"><strong>CUSTO FRETE</strong></td>
        <td align="center"><strong>TAXAS</strong></td>
        <td align="center"><strong>IMPOSTOS</strong></td>
        <td align="center"><strong>CUSTO</strong></td>
        <td align="center"><strong>COMISS&Atilde;O (4%)</strong></td>
        <td align="center"><strong>VLR.L&Iacute;QUIDO</strong></td>
    </tr>
<?php
$tot_vlr_total = 0;
$tot_vlr_frete = 0;
$tot_vlr_fretecusto = 0;
$tot_taxas = 0;
$tot_impostos = 0;
$tot_custo = 0;
$tot_comissao = 0;
$tot_vlr_liquido = 0;

$tot_vlr_total2 = 0;
$tot_vlr_frete2 = 0;
$tot_vlr_fretecusto2 = 0;
$tot_taxas2 = 0;
$tot_impostos2 = 0;
$tot_custo2 = 0;
$tot_comissao2 = 0;
$tot_vlr_liquido2 = 0;

$str = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, NR_PARCELAS_COSO, VL_TOTAL_COSO, VL_FRETE_COSO,
        if (VL_FRETECUSTO_COSO>0,VL_FRETECUSTO_COSO,VL_FRETE_COSO)
        from compras, cadastros where
        	NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_LOJA_COSO = 2 AND 
        	TP_CADASTRO_CACH = 1 and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) AND
        	ST_COMPRA_COSO <> 'C'
        	and day(DT_COMPRA_COSO) >= ".date("d",strtotime($primrodiacomp))." and day(DT_COMPRA_COSO) <= ".date("d",strtotime($ultimodiacomp)) . " AND month(DT_COMPRA_COSO) = ". date("m", strtotime($primrodiacomp)) ." and year(DT_COMPRA_COSO) = " . date("Y", strtotime($primrodiacomp));

if ($boleto=="S"){
    $str .= " and DS_FORMAPGTO_COSO = 'boleto' ";
}

$str .= " ORDER BY DT_COMPRA_COSO";

$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
    
    $tot_vlr_total = 0;
    $tot_vlr_frete = 0;
    $tot_vlr_fretecusto = 0;
    $tot_taxas = 0;
    $tot_impostos = 0;
    $tot_custo = 0;
    $tot_comissao = 0;
    $tot_vlr_liquido = 0;
    
    $tot_vlr_total2 = 0;
    $tot_vlr_frete2 = 0;
    $tot_vlr_fretecusto2 = 0;
    $tot_taxas2 = 0;
    $tot_impostos2 = 0;
    $tot_custo2 = 0;
    $tot_comissao2 = 0;
    $tot_vlr_liquido2 = 0;
    
    while($row = mysql_fetch_row($st)) {
		$nrcompra	   	= $row[0];
		$dt_compra		= $row[1];
        $ds_formpgto	= $row[2];
        $nr_parcelas	= $row[3];
        $vlr_total		= $row[4];
        $vlr_frete		= $row[5];
        $vlr_fretecusto	= $row[6];
        
        $taxas = CalculaCusto($vlr_total,$ds_formpgto,$nr_parcelas);
        $impostos = ($vlr_total*0.0565)+($vlr_total*0.07);
        $custo = ($vlr_total-$vlr_frete)*40/100;
        $comissao = ($vlr_total-$vlr_fretecusto)*4/100;
        $vlr_liquido = $vlr_total-$vlr_fretecusto-$taxas-$impostos-$custo-$comissao;
        
        $tot_vlr_total += $vlr_total;
        $tot_vlr_frete += $vlr_frete;
        $tot_vlr_fretecusto += $vlr_fretecusto;
        $tot_taxas += $taxas;
        $tot_impostos += $impostos;
        $tot_custo += $custo;
        $tot_comissao += $comissao;
        $tot_vlr_liquido += $vlr_liquido;
        
        $tot_vlr_total2 += $vlr_total;
        $tot_vlr_frete2 += $vlr_frete;
        $tot_vlr_fretecusto2 += $vlr_fretecusto;
        $tot_taxas2 += $taxas;
        $tot_impostos2 += $impostos;
        $tot_custo2 += $custo;
        $tot_comissao2 += $comissao;
        $tot_vlr_liquido2 += $vlr_liquido;
        ?>
        <tr>
            <td align="center">&nbsp;</td>
            <td align="center"><a target="_blank" href="http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=<?php echo $nrcompra; ?>"><?php echo $nrcompra; ?></a></td>
            <td align="center"><?php echo date("d/m/Y g:i",strtotime($dt_compra)); ?></td>
            <td align="center"><?php echo $ds_formpgto; ?></td>
            <td align="center"><?php echo $nr_parcelas; ?></td>
            <td align="right">R$ <?php echo number_format($vlr_total,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($vlr_frete,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($vlr_fretecusto,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($taxas,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($impostos,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($custo,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($comissao,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($vlr_liquido,2,",","."); ?></td>
        </tr>
        <?php
    }
}

?>
<tr bgcolor="#DFDFDF">
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_total,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_frete,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_fretecusto,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_taxas,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_impostos,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_custo,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_comissao,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_liquido,2,",","."); ?></strong></td>
</tr>
<tr><td colspan="9">&nbsp;</td></tr>
<tr bgcolor="#DFDFDF">
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_total2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_frete2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_fretecusto2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_taxas2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_impostos2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_custo2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_comissao2,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_liquido2,2,",","."); ?></strong></td>
</tr>
</table>
<table width="<?php echo $largura; ?>" >
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia/Mes', 'Vlr Total'],
          <?php
            $str = "SELECT day(DT_COMPRA_COSO), month(DT_COMPRA_COSO), sum(VL_TOTAL_COSO)
                            from compras, cadastros where
                            	NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND 
                            	TP_CADASTRO_CACH = 1 and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) AND
                            	ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'
                                and day(DT_COMPRA_COSO) >= ".date("d",strtotime($primrodiacomp))." and day(DT_COMPRA_COSO) <= ".date("d",strtotime($ultimodiacomp)) . " AND month(DT_COMPRA_COSO) = ". date("m", strtotime($primrodiacomp)) ." and year(DT_COMPRA_COSO) = " . date("Y", strtotime($primrodiacomp)) ."
                     GROUP BY  day(DT_COMPRA_COSO), month(DT_COMPRA_COSO)
                    order by DT_COMPRA_COSO desc limit 7";

                    
            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {
                while($row = mysql_fetch_row($st)) {
          ?>
          ['<?php echo $row[1];?>/<?php echo $row[0];?>', <?php echo number_format($row[2],2,".","");?>],
          <?php
                }
          }
          ?>
        ]);

        var options = {
          title: 'Vendas Ultimos 7 dias',
          chartArea: {left: 60, width: "100%", height: "80%"},
          legend: 'none',
          hAxis : {direction: -1}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div" style="width: <?php echo $largura; ?>px; height: 400px;"></div> 
</body>
</html>
<?php
function getWeeks($date, $rollover)
{
    $cut = substr($date, 0, 8);
    $daylen = 86400;

    $timestamp = strtotime($date);
    $first = strtotime($cut . "00");
    $elapsed = ($timestamp - $first) / $daylen;

    $i = 1;
    $weeks = 1;

    for($i; $i<=$elapsed; $i++)
    {
        $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
        $daytimestamp = strtotime($dayfind);

        $day = strtolower(date("l", $daytimestamp));

        if($day == strtolower($rollover))  $weeks ++;
    }

    return $weeks;
}


mysql_close($con);
?>