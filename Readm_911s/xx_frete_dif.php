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
$tot = 0;

$anorequ = request("ano");
$mesrequ = request("mes");
$diarequ = request("dia");

if ($anorequ && $mesrequ){
    BuscaAno($anorequ,$mesrequ,$diarequ);
}

function BuscaAno($byano,$bymes,$bydia){
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
        $total_diffrete = 0;
        while($row = mysql_fetch_row($st)) {
    		$dia	   	= $row[0];
    		$mes		= $row[1];
            $vlr_bruto	= $row[2];
            $vlr_frete	= $row[3];
            $vlr_fretec	= $row[4];
            $parcelas   = $row[5];
            $forma      = $row[6];
            $idcompra   = $row[7];
            
            $diffrete   = $vlr_frete - $vlr_fretec;
            
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
                        <td align="right">R$ <?php echo number_format($total_fretec,2,",","."); ?></td>
                        <td align="right"><strong>R$ <?php echo number_format($total_diffrete,2,",","."); ?></strong></td>
                    </tr>
                    <?php
                    $total_bruto = 0;
                    $total_fretec = 0;
                    $total_tarifas = 0;
                    $total_custo = 0;
                    $total_sfrete = 0;
                    $total_diffrete = 0;
                }
                ?>
                <tr><td colspan="7">&nbsp;</td></tr>
                <tr bgcolor="silver">
                    <td align="center"><strong>DIA/M&Ecirc;S</strong></td>
                    <td align="center"><strong>COMPRA</strong></td>
                    <td align="right"><strong>VLR TOTAL</strong></td>
                    <td align="right"><strong>VLR FRETE</strong></td>
                    <td align="right"><strong>CUSTO FRETE</strong></td>
                    <td align="right"><strong>DIF. FRETE</strong></td>
                </tr>
                <?php
                $mesatual = $mes;
            }
            $total_bruto += $vlr_bruto;
            $total_frete += $vlr_frete;
            $total_fretec += $vlr_fretec;
            $total_tarifas += $tarifasdia;
            $total_diffrete += $diffrete;
            
            $custo = ($vlr_bruto - $vlr_fretec)*40/100;
            $total_custo += $custo;
            
            $vlr_sem_frete = $vlr_bruto - $vlr_frete;
            $total_sfrete += $vlr_sem_frete;
            $cor = "black";
            if (($diffrete < 0) && $vlr_frete > 0) $cor = "red";
            if ($vlr_frete == 0) $cor = "blue";
            ?>
             <tr style="color: <?php echo $cor; ?>;">
                <td align="center"><strong><?php echo str_pad($dia,2,"0",STR_PAD_LEFT); ?>/<?php echo str_pad($mes,2,"0",STR_PAD_LEFT); ?></strong></td>
                <td align="center"><strong><a href="http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=<?php echo $idcompra; ?>"><?php echo $idcompra; ?></a></strong></td>
                <td align="right">R$ <?php echo number_format($vlr_bruto,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_frete,2,",","."); ?></td>
                <td align="right">R$ <?php echo number_format($vlr_fretec,2,",","."); ?></td>
                <td align="right"><strong>R$ <?php echo number_format($diffrete,2,",","."); ?></strong></td>
             </tr>
             <?php
        }
    }
    if ($total_bruto > 0){
    ?>
    <tr bgcolor="#E8E7E6">
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">R$ <?php echo number_format($total_bruto,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_frete,2,",","."); ?></td>
        <td align="right">R$ <?php echo number_format($total_fretec,2,",","."); ?></td>
        <td align="right"><strong>R$ <?php echo number_format($total_diffrete,2,",","."); ?></strong></td>
    </tr>
    <?php
    $total_bruto = 0;
    $total_fretec = 0;
    $total_tarifas = 0;
    $total_custo = 0;
    $total_sfrete = 0;
    $total_diffrete = 0;
}
}
?>
</table>
</body>
</html>