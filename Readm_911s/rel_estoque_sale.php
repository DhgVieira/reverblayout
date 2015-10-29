<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" />
<meta charset="utf-8" /> 
<title>Estoque SALE até R$ 24,90</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 14px;
    }
</style>
</head>
<body>
<table>
    <tr>
        <td colspan="10"><h2>Estoque SALE até R$ 24,90</h2></td>
    </tr>
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
        <td align="right"><strong>CUSTO UNIT.</strong></td>
    </tr>
<?php
include 'lib.php';
include 'auth.php';

$tam = request("tam");
$data = request('data');

if(!empty($data)){
    $whereData = "AND DT_ACAO_ECRC <= '". addslashes($data) ." 23:59:59'";
}

$tot = 0;
$str = "SELECT 
            DS_CATEGORIA_PTRC,
            DS_CATEGORIA_PCRC,
            DS_PRODUTO2_PRRC,
            DS_TAMANHO_TARC,
            NR_QTDE_ESRC,
            VL_PRODUTO_PRRC,
            VL_PROMO_PRRC,
            ST_PRODUTOS_PRRC,
            VL_PRODUTO2_PRRC,
            NR_SEQ_PRODUTO_PRRC
        from
            estoque,
            produtos,
            produtos_tipo,
            tamanhos,
            produtos_categoria
        where
            NR_SEQ_PRODUTO_ESRC = NR_SEQ_PRODUTO_PRRC
                AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
                AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
                AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC
                AND NR_QTDE_ESRC > 0
                AND DS_CLASSIC_PRRC = 'N'
                AND NR_SEQ_PRODUTO_PRRC <> 2001
                and ST_PRODUTOS_PRRC = 'A'
                AND NR_SEQ_LOJAS_PRRC = 1
                AND NR_SEQ_TIPO_PRRC = 6
                AND NR_SEQ_CATEGPRO_PTRC NOT IN(4,140)
                AND TP_DESTAQUE_PRRC = 2 
                AND VL_PROMO_PRRC <= '24.9' ";

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
    $total_cus = 0;
    $tot_custo = 0;
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
                    <td align="right"><strong>R$ <?php echo number_format($total_cus,2,",","."); ?></strong></td>
                </tr>
                
               

                <?php
            }
            $total_cus = 0;
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
                        <td align="right"><strong>R$ <?php echo number_format($tot_cus,2,",","."); ?></strong></td>
                    </tr>
                    <?php
                }
                $total_geral += $tot_vlr;
                $total_geral_cus += $tot_vlr_custo;
                $tot_est = 0;
                $tot_vlr = 0; 
                $tot_vlr_custo = 0;
                $tot_custo = 0;
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
        $total_cus += $valorcus;
        $tot_cus += $total_cus;
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
            <td align="right">R$ <?php echo number_format($valorcus,2,",","."); ?></td>
            
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

</body>
</html>
<?php mysql_close($con); ?>