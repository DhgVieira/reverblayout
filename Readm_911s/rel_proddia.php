<?php
include 'lib.php';
include 'auth.php';

$largura = 700;
$primrodiacomp = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")))." 00:00:00";
$ultimodiacomp = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y")))." 23:59:59";
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
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio Vendas Produto do Dia - M&ecirc;s <?php echo date("m",strtotime($primrodiacomp));?></strong><br /><font size="-1">Loja: Londrina/Internet</font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table style="padding: 4px; width: <?php echo $largura; ?>px;">
<tr>
    <td style="text-align: center;"><strong>Data</strong></td>
    <td><strong>Produto</strong></td>
    <td style="text-align: center;"><strong>Qtde.</strong></td>
    <td style="text-align: center;"><strong>Vlr.Unit.</strong></td>
    <td style="text-align: center;"><strong>Vlr. Total</strong></td>
    <td style="text-align: center;">Frete</td>
</tr>
<?php
$str = "select NR_SEQ_AGENDAMENTO_BARC, DS_PRODUTO2_PRRC, DT_PUBLICACAO_BARC, VL_NOVOVALOR_BARC, DS_FRETEGRATIS_BARC,
          VL_PROMOATUAL_BARC, DS_FRETEGRATUAL_BARC, NR_SEQ_PRODUTO_BARC
          from banners_agendados, produtos
          WHERE (DT_PUBLICACAO_BARC BETWEEN '$primrodiacomp' and '$ultimodiacomp') and
          NR_SEQ_PRODUTO_BARC = NR_SEQ_PRODUTO_PRRC order by DT_PUBLICACAO_BARC desc";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
    $x = 0;
    $dataant = "";
    
    $totaluni = 0;
    $totalvlr = 0;
    while($row = mysql_fetch_row($st)) {
     $id_loca	   = $row[0];
     $nm_prod	   = $row[1];
     $dt_agen	   = $row[2];
     $valorpro	   = $row[3];
     $fretegra	   = $row[4];
     $valoratu	   = $row[5];
     $freteatu	   = $row[6];
     $idprod	   = $row[7];
     $cor = "";
       
     if (!$dataant){
        $datefim_my = $ultimodiacomp;
        $dataant = $datefim_my;
     }else{
        $datefim_my = $dataant;
     }
     
     if ($x==0){
        $cor = "#ffffff";
        $x = 1;
     }else{
        $cor = "#E9E9E9";
        $x = 0;
     }
     
     $sql2 = "SELECT SUM(NR_QTDE_CESO) from compras, cestas, cadastros
      where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
      and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' AND NR_SEQ_PRODUTO_CESO = $idprod AND NR_SEQ_LOJA_COSO = 1 
      and (DT_COMPRA_COSO BETWEEN '".date("Y-m-d H:i:s",strtotime($dt_agen))."' and '$datefim_my')
      and TP_CADASTRO_CACH <> 1";
     $st2 = mysql_query($sql2);
     $row2 = mysql_fetch_row($st2);
     $totalvend = $row2[0];
     
     $totaluni += $totalvend;
     $totalvlr += ($totalvend*$valorpro);
     
     $valor = number_format(($totalvend*$valorpro),2,",",".");
     
     if ($valor > 0){
        $valor = "R$ $valor";
     }else{
        $valor = "&nbsp;";
     }
    ?>
    <tr style="background-color: <?php echo $cor; ?>;">
    <td><?php echo date("d/m/Y H:i",strtotime($dt_agen));?></td>
    <td><strong><?php echo $nm_prod;?></strong></td>
    <td style="text-align: center;"><?php echo $totalvend;?></td>
    <td style="text-align: right;">R$ <?php echo number_format($valorpro,2,",","");?></td>
    <td style="text-align: right;"><strong><?php echo $valor;?></strong></td>
    <td style="text-align: center;"><?php echo $fretegra;?></td>
    </tr>
    <?php
    $dataant = date("Y-m-d H:i:s",strtotime($dt_agen));
    }
  }
?>
<tr style="background-color: #D3D3D3;">
    <td><strong>TOTAL</strong></td>
    <td>&nbsp;</td>
    <td style="text-align: center;"><?php echo $totaluni;?></td>
    <td style="text-align: right;">&nbsp;</td>
    <td style="text-align: right;"><strong>R$ <?php echo number_format($totalvlr,2,",",".");?></strong></td>
    <td style="text-align: center;">&nbsp;</td>
    </tr>
</table>

</body>
</html>
<?php mysql_close($con); ?>