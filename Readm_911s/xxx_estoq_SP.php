<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 14px;
    }
</style>
</head>
<body>
<table>
    <tr bgcolor="silver">
        <td align="left"><strong>TIPO</strong></td>
        <td align="left"><strong>CATEGORIA</strong></td>
        <td align="center"><strong>ESTOQUE</strong></td>
<!--        <td align="right"><strong>TOTAL</strong></td> -->
<!--        <td align="right"><strong>CUSTO</strong></td> -->
    </tr>
<?php
include 'lib.php';
include 'auth.php';

$tot = 0;
$str = "select DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, DS_TAMANHO_TARC, NR_QTDE_ESRC, VL_PRODUTO_PRRC, VL_PROMO_PRRC, 
ST_PRODUTOS_PRRC from estoque, produtos, produtos_tipo, tamanhos, produtos_categoria
where NR_SEQ_PRODUTO_ESRC = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
	AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
  AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC AND NR_QTDE_ESRC > 0 AND DS_CLASSIC_PRRC = 'N'
  AND ST_PRODUTOS_PRRC = 'A'
	AND NR_SEQ_LOJAS_PRRC = 2 ORDER BY DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, DS_TAMANHO_TARC desc";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
	$cat = utf8_encode("Acessórios");
    $tip = "Buttons";
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
        $promo		= $row[6];
        $status	    = $row[7];
        
        $cat2 = $dscat;
        
        if ($cat2 != $cat){
            ?>
            <tr bgcolor="#DFDFDF">
                <td align="left"><?php echo $tip; ?></td>
                <td align="left"><?php echo $cat; ?></td>
                <td align="center"><strong><?php echo $tot_est; ?></strong></td>
 <!--               <td align="right"><strong>R$ <?php echo number_format($tot_vlr,2,",","."); ?></strong></td> -->
 <!--               <td align="right"><strong>R$ <?php echo number_format($tot_vlr_custo,2,",","."); ?></strong></td>-->
            </tr>
            <?php
            $cat = $dscat;
            $tip = $dstip;
            //echo "\t\t\t\t".$tot_est."\t\t\t".number_format($tot_vlr,2,",","")."\n";
            $total_geral += $tot_vlr;
            $total_geral_cus += $tot_vlr_custo;
            $tot_est = 0;
            $tot_vlr = 0; 
            $tot_vlr_custo = 0;
        }
        
        if ($promo > 0){
            $total = $promo*$estoq; 
            $tot_vlr += $total; 
        }else{
            $total = $valor*$estoq; 
            $tot_vlr += $total; 
        }
        $custo = ($valor*40/100)*$estoq; 
        $tot_vlr_custo += $custo;
        $tot_est += $estoq;
        ?>
        <!--
        <tr<?php if ($status == "I") echo " bgcolor=\"#FDEBDF\" "; ?>>
            <td align="left"><?php echo $dstip; ?></td>
            <td align="left"><?php echo $dscat; ?></td>
            <td align="left"><?php echo $dspro; ?></td>
            <td align="center"><?php echo $dstam; ?></td>
            <td align="center"><?php echo $estoq; ?></td>
            <td align="right">R$ <?php echo number_format($valor,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($promo,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($total,2,",","."); ?></td>
            <td align="right">R$ <?php echo number_format($custo,2,",","."); ?></td>
        </tr>
        -->
        <?php
        //echo $dstip."\t".$dscat."\t".$dspro."\t".$dstam."\t".$estoq."\t".number_format($valor,2,",","")."\t".number_format($promo,2,",","")."\t".number_format($total,2,",","")."\n";
        
  }
}

$total_geral += $tot_vlr;
?>

</table>
</body>
</html>