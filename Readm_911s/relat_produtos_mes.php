<?php
include 'auth.php';
include 'lib.php';

$aba = request("aba");

$mes = request("mes");
$ano = request("ano");

if (!$mes) $mes = date('m');
if (!$ano) $ano = date('Y');
    
$corpo="";
$largura = 1020;
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
        font-size: 14px;
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
</table>
<table width="<?php echo $largura; ?>" >
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Produtos Vendidos no M&ecirc;s</strong><br /><font size="-1">M&ecirc;s: <?php echo $mes?>/<?php echo $ano?></font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table cellpadding="2" cellspacing="2" width="<?php echo $largura; ?>">
    <tr bgcolor="silver">
        <td align="left"><strong>TIPO</strong></td>
        <td align="left"><strong>CATEGORIA</strong></td>
        <td align="left"><strong>DESCRI&Ccedil;&Atilde;O</strong></td>
        <td align="center"><strong>TAMANHO</strong></td>
        <td align="center"><strong>QTDE</strong></td>
        <td align="right"><strong>VLR UNIT.</strong></td>
        <td align="right"><strong>TOTAL</strong></td>
        <td align="right"><strong>CUSTO</strong></td>
    </tr>
<?php
$tot = 0;
$str = "select DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, DS_TAMANHO_TARC, SUM(NR_QTDE_CESO), SUM(VL_PRODUTO_CESO), VL_PRODUTO_PRRC, 
        ST_PRODUTOS_PRRC, VL_PRODUTO2_PRRC, VL_PROMO_PRRC, VL_PRODUTO_CESO from compras, cestas, produtos, produtos_tipo, tamanhos, produtos_categoria
        where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
        	AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_CESO AND NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC
          AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and MONTH(DT_COMPRA_COSO) = $mes AND YEAR(DT_COMPRA_COSO) = $ano
          and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
          and ST_COMPRA_COSO <> 'C'
        GROUP BY NR_SEQ_PRODUTO_CESO	
        ORDER BY DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, DS_TAMANHO_TARC desc;";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
	$cat = "Brincos / Earrings";
    $cat2 = "";
    $tot_est = 0;
    $tot_vlr = 0;
    $tot_vlr_custo = 0;
    $total = 0;
    $custo = 0;
    $total_geral = 0;
    $total_geral_cus = 0;
    while($row = mysql_fetch_row($st)) {
		$dstip	   	= $row[0];
		$dscat		= $row[1];
        $dspro		= $row[2];
        $dstam		= $row[3];
        $estoq		= $row[4];
        $valor		= $row[5];
        $vlrprod	= $row[6];
        $status	    = $row[7];
        $valorcus   = $row[8];
        $promo      = $row[9];
        $vlrcesta   = $row[10];
        
        $cat2 = $dscat;
        
        if ($cat2 != $cat){
            $cat = $dscat;
            ?>
            <tr bgcolor="#DFDFDF">
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center"><strong><?php echo $tot_est; ?></strong></td>
                <td align="center">&nbsp;</td>
                <td align="right"><strong>R$ <?php echo number_format($tot_vlr,2,",","."); ?></strong></td>
                <td align="right"><strong>R$ <?php echo number_format($tot_vlr_custo,2,",","."); ?></strong></td>
            </tr>
            <?php
            //echo "\t\t\t\t".$tot_est."\t\t\t".number_format($tot_vlr,2,",","")."\n";
            $total_geral += $tot_vlr;
            $total_geral_cus += $tot_vlr_custo;
            $tot_est = 0;
            $tot_vlr = 0; 
            $tot_vlr_custo = 0;
        }
        
        $total = $valor; 
        $tot_vlr += $total;
        
        if ($valorcus > 0 && $valorcus < $valor){
            $custo = $valorcus*$estoq;
        }else{
            $custo = ($vlrprod*40/100)*$estoq; 
        }
                
        $tot_vlr_custo += $custo;
        $tot_est += $estoq;
        
        if ($vlrcesta == 0){
            $vlrcesta = $vlrprod;
            if ($promo > 0){
                $vlrcesta = $promo;
            }
        }
        ?>
        <tr<?php if ($status == "I") echo " bgcolor=\"#FDEBDF\" "; ?>>
            <td align="left"><?php echo $dstip; ?></td>
            <td align="left"><?php echo $dscat; ?></td>
            <td align="left"><?php echo $dspro; ?></td>
            <td align="center"><?php echo $dstam; ?></td>
            <td align="center"><?php echo $estoq; ?></td>
            <td align="right">R$ <?php echo number_format($vlrcesta,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($total,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($custo,2,",","."); ?></td>
        </tr>
        <?php
  }
}

$total_geral += $tot_vlr;
?>
<tr bgcolor="#DFDFDF">
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><strong><?php echo $tot_est; ?></strong></td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_custo,2,",","."); ?></strong></td>
</tr>
<?php
//echo "\t\t\t\t".$tot_est."\t\t\t".number_format($tot_vlr,2,",","")."\n";
?>
<tr><td colspan="8">&nbsp;</td></tr>
<tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right" colspan="3"><strong>TOTAL GERAL</strong></td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($total_geral,2,",","."); ?></strong></td>
    <td align="right"><strong style="color: red;">R$ <?php echo number_format($total_geral_cus,2,",","."); ?></strong></td>
</tr>
<tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right" colspan="3"><strong>LUCRO BRUTO</strong></td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($total_geral - $total_geral_cus,2,",","."); ?></strong></td>
</tr>
<?php
$lucroliq = (($total_geral - $total_geral_cus)-((($total_geral - $total_geral_cus)*0.0565)+(($total_geral - $total_geral_cus)*0.07)+(($total_geral - $total_geral_cus)*0.08)));
?>
<tr>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" colspan="3"><strong>LUCRO L&Iacute;QUIDO LONDRINA (depois de impostos)</strong></td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong style="color: blue;">R$ <?php echo number_format($lucroliq,2,",","."); ?></strong></td>
</tr>
<tr>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" colspan="3"><strong>% LUCRO L&Iacute;QUIDO (depois de impostos)</strong></td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong style="color: blue;"><?php echo number_format($lucroliq*100/$total_geral,2,",","."); ?>%</strong></td>
</tr>
<tr><td colspan="8">&nbsp;</td></tr>
</table>
<table width="<?php echo $largura; ?>" >
	<tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
</body>
</html>