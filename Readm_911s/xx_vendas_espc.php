<?php
include 'lib.php';
include 'auth.php';
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
<table>
<?php
$anoreq = request("ano");
$mesreq = request("mes");
$tot = 0;

    $str = "select
                day(DT_COMPRA_COSO), 
            	month(DT_COMPRA_COSO),
                VL_PRODUTO_CESO,
                IF(VL_PRODUTO2_PRRC>0,VL_PRODUTO2_PRRC*NR_QTDE_CESO,(VL_PRODUTO_PRRC*30/100)*NR_QTDE_CESO),
                (VL_PRODUTO_PRRC*NR_QTDE_CESO)*5.65/100,
                NR_PARCELAS_COSO,
                DS_FORMAPGTO_COSO,
                NR_SEQ_COMPRA_COSO,
                DS_CATEGORIA_PTRC, 
                DS_CATEGORIA_PCRC,
                DS_PRODUTO2_PRRC,
                NR_QTDE_CESO
            from compras, cestas, produtos, produtos_tipo, produtos_categoria where
                NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND
                NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC AND
            	ST_COMPRA_COSO = 'C' AND NR_SEQ_LOJA_COSO = 1 and
            	(DT_COMPRA_COSO BETWEEN '2013-02-01 00:00:01' and '2013-02-03 23:59:59') and
                NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) 
            order by month(DT_COMPRA_COSO), day(DT_COMPRA_COSO)";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $diaatual = "";
        $total_bruto = 0;
        $total_sfrete = 0;
        $total_fretec = 0;
        $total_tarifas = 0;
        $total_custo = 0;
        $total_prod_custo = 0;
        $total_comiss_rvb = 0;
        $total_prod_impos = 0;
        $total_quantidade = 0;
        while($row = mysql_fetch_row($st)) {
    		$dia	   	= $row[0];
    		$mes		= $row[1];
            $vlr_bruto	= $row[2];
            $vlr_prod_custo	= $row[3];
            $vlr_prod_imposto	= $row[4];
            $parcelas   = $row[5];
            $forma      = $row[6];
            $idcompra   = $row[7];
            
            $dsprod     = $row[10];
            $dstipo     = $row[8];
            $dscateg    = $row[9];
            
            $quantidade    = $row[11];
            
            $tarifasdia = 0;
            
            $vlr_bruto = $vlr_bruto*$quantidade;
            
            $comiss_rvb = $vlr_bruto*35/100;
            
            $custo = CalculaCusto($vlr_bruto,$forma,$parcelas,$loja=0);
            $tarifasdia += $custo;
            

            if ($diaatual != $dia){
                if ($total_bruto > 0){
                    ?>
                    <tr bgcolor="#E8E7E6">
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center"><?php echo $total_quantidade; ?></td>
                        <td align="center">&nbsp;</td>
                        <td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>
                        <!--<td align="center">R$ <?php echo number_format($comiss_rvb,2,",","."); ?></td>-->
                        <!--<td align="right">R$ <?php echo number_format($total_prod_custo,2,",","."); ?></td>-->
                        <!--<td align="right">R$ <?php echo number_format($total_prod_impos,2,",","."); ?></td>-->
                        <!--<td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>-->
                        <!--<td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas-$total_prod_custo-$total_prod_impos,2,",","."); ?></strong></td>-->
                    </tr>
                    <?php
                    $total_bruto = 0;
                    $total_tarifas = 0;
                    $total_prod_custo = 0;
                    $total_prod_impos = 0;
                    $total_quantidade = 0;
                }
                ?>
                <tr><td colspan="7">&nbsp;</td></tr>
                <tr bgcolor="silver">
                    <td align="center"><strong>DIA/M&Ecirc;S</strong></td>
                    <td align="center"><strong>COMPRA</strong></td>
                    <td align="left"><strong>TIPO</strong></td>
                    <td align="left"><strong>CATEGORIA</strong></td>
                    <td align="left"><strong>PRODUTO</strong></td>
                    <td align="center"><strong>QTDE.</strong></td>
                    <td align="center"><strong>FORMA PGTO.</strong></td>
                    <td align="right"><strong>VLR TOTAL</strong></td>
                    <!--<td align="right"><strong>Com.35%</strong></td>
                    <td align="right"><strong>VLR CUSTO</strong></td>
                    <td align="right"><strong>VLR IMPOSTOS</strong></td>
                    <td align="right"><strong>TARIFAS</strong></td>
                    <td align="right"><strong>VLR L&Iacute;QUIDO</strong></td>-->
                </tr>
                <?php
                $diaatual = $dia;
            }
            $total_bruto += $vlr_bruto;
            $total_tarifas += $tarifasdia;
            $total_prod_custo += $vlr_prod_custo;
            $total_prod_impos += $vlr_prod_imposto;
            $total_quantidade += $quantidade;
            $total_comiss_rvb += $comiss_rvb;
            ?>
             <tr>
                <td align="center"><strong><?php echo str_pad($dia,2,"0",STR_PAD_LEFT); ?>/<?php echo str_pad($mes,2,"0",STR_PAD_LEFT); ?></strong></td>
                <td align="center"><strong><?php echo $idcompra; ?></strong></td>
                <td align="left"><strong><?php echo $dstipo; ?></strong></td>
                <td align="left"><strong><?php echo $dscateg; ?></strong></td>
                <td align="left"><strong><?php echo $dsprod; ?></strong></td>
                <td align="center"><strong><?php echo $quantidade; ?></strong></td>
                <td align="center"><strong><?php echo $forma; ?></strong></td>
                <td align="right">R$ <?php echo number_format($vlr_bruto,2,",","."); ?></td>
                <!--<td align="right">R$ <?php echo number_format($total_comiss_rvb,2,",","."); ?></td>-->
                <!--<td align="right">R$ <?php echo number_format($vlr_prod_custo,2,",","."); ?></td>-->
                <!--<td align="right">R$ <?php echo number_format($vlr_prod_imposto,2,",","."); ?></td>-->
                <!--<td align="right">R$ <?php echo number_format($tarifasdia,2,",","."); ?></td>-->
                <!--<td align="right"><strong>R$ <?php echo number_format($vlr_bruto-$tarifasdia-$vlr_prod_custo-$vlr_prod_imposto,2,",","."); ?></strong></td>-->
             </tr>
             <?php
        }
    }
    if ($total_bruto > 0){
    ?>
    <tr bgcolor="#E8E7E6">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><?php echo $total_quantidade; ?></td>
        <td align="center">&nbsp;</td>
        <td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>
        <!--<td align="right">R$ <?php echo number_format($total_comiss_rvb,2,",","."); ?></td>-->
        <!--<td align="right">R$ <?php echo number_format($total_prod_custo,2,",","."); ?></td>-->
        <!--<td align="right">R$ <?php echo number_format($total_prod_impos,2,",","."); ?></td>-->
        <!--<td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>-->
        <!--<td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas-$total_prod_custo-$total_prod_impos,2,",","."); ?></strong></td>-->
    </tr>
    <?php
    $total_bruto = 0;
    $total_tarifas = 0;
    $total_prod_custo = 0;
    $total_prod_impos = 0;
    $total_quantidade = 0;
}

?>
</table>
</body>
</html>