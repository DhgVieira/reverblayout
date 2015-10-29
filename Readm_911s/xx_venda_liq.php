<?php
include 'lib.php';
include 'auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reverbcity</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 12px;
    }
</style>
</head>
<body>
<table align="center">
    <tr>
        <td colspan="10">
            <img src="../arquivos/default/images/logo.png" style="float: left;">
            <h2 style="text-align: center; vertical-align: middle; line-height: 58px;">Relatório de vendas</h2>
        </td>
    </tr>
<?php
$tot = 0;

$anorequ = request("ano");
$mesrequ = request("mes");

if ($anorequ && $mesrequ){
    BuscaAno($anorequ,$mesrequ);
}

function BuscaAno($byano,$bymes){
    $str = "SELECT
            	count(*),
                day(DT_PAGAMENTO_COSO), 
            	month(DT_PAGAMENTO_COSO),	
            	sum(VL_TOTAL_COSO), 
            	sum(VL_FRETE_COSO), 
            	sum(VL_FRETECUSTO_COSO)
            from compras where
            	ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND NR_SEQ_LOJA_COSO = 1 and
            	YEAR(DT_PAGAMENTO_COSO) = $byano AND MONTH(DT_PAGAMENTO_COSO) = $bymes AND
                NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
            group by day(DT_PAGAMENTO_COSO), month(DT_PAGAMENTO_COSO)
            order by month(DT_PAGAMENTO_COSO), day(DT_PAGAMENTO_COSO)";
            // sum(if (VL_FRETECUSTO_COSO>0,VL_FRETECUSTO_COSO,VL_FRETE_COSO))
           // echo $str;die();
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $mesatual = "";
        $total_bruto = 0;
        $total_sfrete = 0;
        $total_frete = 0;
        $total_fretec = 0;
        $total_tarifas = 0;
        $total_qtde = 0;
        $total_custo = 0;
        $total_impostos = 0;
        while($row = mysql_fetch_row($st)) {
            $qtde       = $row[0];
    		$dia	   	= $row[1];
    		$mes		= $row[2];
            $vlr_bruto	= $row[3];
            $vlr_frete	= $row[4];
            $vlr_fretec	= $row[5];
            
            $tarifasdia = 0;
            
            $sqlt = "SELECT VL_TOTAL_COSO, DS_FORMAPGTO_COSO, NR_PARCELAS_COSO from compras where day(DT_PAGAMENTO_COSO) = $dia and month(DT_PAGAMENTO_COSO) = $mes and year(DT_PAGAMENTO_COSO) = $byano
                     and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'  AND NR_SEQ_LOJA_COSO = 1 and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
            $st2 = mysql_query($sqlt); 
            if (mysql_num_rows($st2) > 0) {
                while($row2 = mysql_fetch_row($st2)) {
                    $vltotal  = $row2[0];
                    $forma    = $row2[1];
                    $parcelas = $row2[2];
                    $custo = CalculaCusto($vltotal,$forma,$parcelas,$loja=0);
                    $tarifasdia += $custo;
                }
            }
            
            $impostos = ($vlr_bruto*6.09/100);

            if ($mesatual != $mes){
                if ($total_bruto > 0){
                    ?>
                    <tr bgcolor="#E8E7E6">
                        <td align="center">&nbsp;</td>
                        <td align="center"><?php echo $total_qtde; ?></td>
                        <td align="center">&nbsp;</td>
                        <td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>
                        <td align="right">R$ <?php echo number_format($total_sfrete,2,",","."); ?></td>
                        <!--<td align="right">R$ <?php echo number_format($total_custo,2,",","."); ?></td>-->
                        <td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>
                        <td align="right">R$ <?php echo number_format($total_fretec,2,",","."); ?></td>
                        <td align="right">R$ <?php echo number_format($total_impostos,2,",","."); ?></td>
                        <td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas-$total_fretec-$total_impostos,2,",","."); ?></strong></td>
                        <td align="right">R$ <?php echo number_format($total_bruto/$total_qtde,2,",","."); ?></td>
                    </tr>
                    <?php
                    $total_bruto = 0;
                    $total_fretec = 0;
                    $total_tarifas = 0;
                    $total_qtde = 0;
                    $total_custo = 0;
                    $total_sfrete = 0;
                    $total_frete = 0;
                    $total_frete = 0;
                    $total_impostos = 0;
                }
                ?>
                <tr><td colspan="7">&nbsp;</td></tr>
                <tr bgcolor="silver">
                    <td align="center"><strong>DIA/M&Ecirc;S</strong></td>
                    <td align="center"><strong>QTDE.</strong></td>
                    <td align="right"><strong>VLR TOTAL</strong></td>
                    <td align="right"><strong>VLR FRETE</strong></td>
                    <td align="right"><strong>VLR S/FRETE</strong></td>
                    <!--<td align="right"><strong>CUSTO(40%)</strong></td>-->
                    <td align="right"><strong>TARIFAS</strong></td>
                    <td align="right"><strong>CUSTO FRETE</strong></td>
                    <td align="right"><strong>IMPOSTOS</strong></td>
                    <td align="right"><strong>VLR L&Iacute;QUIDO</strong></td>
                    <td align="right"><strong>TICKET M&Eacute;DIO</strong></td>
                </tr>
                <?php
                $mesatual = $mes;
            }
            $total_bruto += $vlr_bruto;
            $total_fretec += $vlr_fretec;
            $total_qtde += $qtde;
            $total_tarifas += $tarifasdia;
            $total_frete += $vlr_frete;
            
            $custo = ($vlr_bruto - $vlr_fretec)*40/100;
            $total_custo += $custo;
            
            $vlr_sem_frete = $vlr_bruto - $vlr_frete;
            $total_sfrete += $vlr_sem_frete;
            
            $total_impostos += $impostos;
            ?>
             <tr>
                <td align="center"><strong><?php echo str_pad($dia,2,"0",STR_PAD_LEFT); ?>/<?php echo str_pad($mes,2,"0",STR_PAD_LEFT); ?></strong></td>
                <td align="center"><?php echo $qtde; ?></td>
                <td align="right">R$ <?php echo number_format($vlr_bruto,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_frete,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_sem_frete,2,",","."); ?></td>
                <!--<td align="right">R$ <?php echo number_format($custo,2,",","."); ?></td>-->
                <td align="right">R$ <?php echo number_format($tarifasdia,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_fretec,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($impostos,2,",","."); ?></td>
                <td align="right"><strong>R$ <?php echo number_format($vlr_bruto-$tarifasdia-$vlr_fretec-$impostos,2,",","."); ?></strong></td>
                <td align="right">R$ <?php echo number_format($vlr_bruto/$qtde,2,",","."); ?></td>
             </tr>
             <?php
        }
    }
    if ($total_bruto > 0){
    ?>
    <tr bgcolor="#E8E7E6">
        <td align="center">&nbsp;</td>
        <td align="center"><?php echo $total_qtde; ?></td>
        <td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_frete,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_sfrete,2,",","."); ?></td>
        <!--<td align="right">R$ <?php echo number_format($total_custo,2,",","."); ?></td>-->
        <td align="right">R$ <?php echo number_format($total_tarifas,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_fretec,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_impostos,2,",","."); ?></td>
        <td align="right"><strong>R$ <?php echo number_format($total_bruto-$total_tarifas-$total_fretec-$total_impostos,2,",","."); ?></strong></td>
        <td align="right">R$ <?php echo number_format($total_bruto/$total_qtde,2,",","."); ?></td>
    </tr>
    <?php
    $total_bruto = 0;
    $total_fretec = 0;
    $total_tarifas = 0;
    $total_qtde = 0;
    $total_custo = 0;
    $total_sfrete = 0;
    $total_impostos = 0;
}
}
?>
</table>
</body>
</html>