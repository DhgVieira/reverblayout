<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" />
<title>Estoque Sale</title>
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
        <td align="left"><strong>DESCRI&Ccedil;&Atilde;O</strong></td>
        <td align="center"><strong>TAMANHO</strong></td>
        <td align="center"><strong>ESTOQUE</strong></td>
        <td align="right"><strong>VLR UNIT.</strong></td>
        <td align="right"><strong>VALOR PRO</strong></td>
        <td align="right"><strong>TOTAL</strong></td>
        <td align="right"><strong>CUSTO</strong></td>
    </tr>
<?php
include 'lib.php';
include 'auth.php';

$tam = request("tam");

$tot = 0;
$str = "SELECT DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, DS_TAMANHO_TARC, NR_QTDE_ESRC, VL_PRODUTO_PRRC, VL_PROMO_PRRC, 
ST_PRODUTOS_PRRC, VL_PRODUTO2_PRRC, NR_SEQ_PRODUTO_PRRC from estoque, produtos, produtos_tipo, tamanhos, produtos_categoria
where NR_SEQ_PRODUTO_ESRC = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
	AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
  AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC AND NR_QTDE_ESRC > 0 AND DS_CLASSIC_PRRC = 'N'
  AND NR_SEQ_PRODUTO_PRRC <> 2001 and ST_PRODUTOS_PRRC = 'A' and TP_DESTAQUE_PRRC <> 4
   AND (TP_DESTAQUE_PRRC = 2)
	AND NR_SEQ_LOJAS_PRRC = 1 AND NR_SEQ_TIPO_PRRC NOT IN(4 , 24, 139, 140, 65, 59)";
if ($tam) $str .= " AND NR_SEQ_TAMANHO_ESRC = $tam ";
$str .= "ORDER BY DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, DS_TAMANHO_TARC desc";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
	$cat = "Brincos / Earrings";
    $cat2 = "";
    $prod1 = 0;
    $prod2 = "";
    $tot_est = 0;
    $tot_est_prod = 0;
    $tot_vlr = 0;
    $tot_vlr_prod = 0;
    $tot_vlr_custo = 0;
    $tot_vlr_custo_prod = 0;
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
        $valorcus   = $row[8];
        $idproduto  = $row[9];
        
        $cat2 = $dscat;
        $prod2 = $idproduto;

        if($prod2 != $prod){
            
            $prod = $idproduto;
            $tot_prod += $tot_est_prod;
            $total_geral_cus_prod += $tot_vlr_custo_prod;
            
            if($tot_prod >0){
                ?>

                <tr bgcolor="#8d8d8d" style="color:#FFF">
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><strong><?php echo $tot_est_prod; ?></strong></td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_prod,2,",","."); ?></strong></td>
                    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_custo_prod,2,",","."); ?></strong></td>
                </tr>
                
               

                <?php
            }
            $tot_est_prod = 0;
            $total_geral_prod += $tot_vlr_prod;
            $tot_vlr_prod = 0;
            $tot_vlr_custo_prod = 0;

            if ($cat2 != $cat){
                $cat = $dscat;
                $tot += $tot_est;
                if($tot > 0){
                    ?>
                    <tr bgcolor="#DFDFDF">
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="center"><strong><?php echo $tot_est; ?></strong></td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="right"><strong>R$ <?php echo number_format($tot_vlr,2,",","."); ?></strong></td>
                        <td align="right"><strong>R$ <?php echo number_format($tot_vlr_custo,2,",","."); ?></strong></td>
                    </tr>
                    <?php
                }
                $total_geral += $tot_vlr;
                $total_geral_cus += $tot_vlr_custo;
                $tot_est = 0;
                $tot_vlr = 0; 
                $tot_vlr_custo = 0;
            }
        }
        
        if ($promo > 0){
            $total = $promo*$estoq; 
            $tot_vlr += $total; 
            $tot_vlr_prod += $total;
        }else{
            $total = $valor*$estoq; 
            $tot_vlr += $total; 
            $tot_vlr_prod += $total;
        }
        
        if ($valorcus > 0 && $valorcus < $valor){
            $custo = $valorcus*$estoq;
        }else{
            $custo = ($valor*40/100)*$estoq; 
        }
        
        $tot_vlr_custo += $custo;
        $tot_vlr_custo_prod += $custo;
        $tot_est += $estoq;
        $tot_est_prod += $estoq;
        ?>
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
        <?php
        
  }
}

$total_geral += $tot_vlr_prod;
$total_geral_prod += $total;
$tot += $tot_est;
?>
<tr bgcolor="#DFDFDF">
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><strong><?php echo $tot_est; ?></strong></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr,2,",","."); ?></strong></td>
    <td align="right"><strong>R$ <?php echo number_format($tot_vlr_custo,2,",","."); ?></strong></td>
</tr>
<tr bgcolor="#DFDFDF">
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><strong><?php echo $tot; ?></strong></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
</tr>
<tr><td colspan="8">&nbsp;</td></tr>
<tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right" colspan="4"><strong>TOTAL GERAL</strong></td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong>R$ <?php echo number_format($total_geral,2,",","."); ?></strong></td>
    <td align="right"><strong style="color: red;">R$ <?php echo number_format($total_geral_cus,2,",","."); ?></strong></td>
</tr>
<tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right" colspan="4"><strong>LUCRO BRUTO</strong></td>
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
    <td align="right" colspan="4"><strong>LUCRO L&Iacute;QUIDO LONDRINA (depois de impostos)</strong></td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong style="color: blue;">R$ <?php echo number_format($lucroliq,2,",","."); ?></strong></td>
</tr>
<tr>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" colspan="4"><strong>% LUCRO L&Iacute;QUIDO (depois de impostos)</strong></td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong style="color: blue;"><?php echo number_format($lucroliq*100/$total_geral,2,",","."); ?>%</strong></td>
</tr>
<tr><td colspan="8">&nbsp;</td></tr>
</table>

<h2>Total Camisetas Por Tamanho / Sexo</h2>
<?php 


$str_total = "SELECT
            SUM(NR_QTDE_ESRC) as total_tamanho,
            DS_SIGLA_TARC,
            NR_SEQ_TAMANHO_ESRC
        FROM 
            estoque
        INNER JOIN tamanhos on tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC 
        WHERE NR_SEQ_TAMANHO_ESRC in (1,2,3,4,5,6,7,8,9,10,33,47)
        GROUP BY NR_SEQ_TAMANHO_ESRC
        ORDER BY NR_ORDEM_TARC ASC";
$st_tamanho = mysql_query($str_total);
if (mysql_num_rows($st_tamanho) > 0) {

    while($row_t = mysql_fetch_row($st_tamanho)) {
            $total = $row_t[0];
            $sigla   = $row_t[1];
            $idtamanho = $row_t[2];

          
            ?>
            <table>
                <tr>
                    <td>
                      <?php  if(($idtamanho >= 1 AND $idtamanho <= 5) or $idtamanho == 33){
               
                                echo "<b> MASC </b> - " . $sigla ." - ". $total; echo "</br>";
                        }else{
                                echo "<b> FEM </b>- " . $sigla ." - ". $total;  "</br>";
                        } ?>
                    </td>
                </tr>
            </table>
            <?php

    }

}

?>
</body>
</html>
<?php mysql_close($con); ?>