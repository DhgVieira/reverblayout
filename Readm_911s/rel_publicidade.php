<?php
setlocale(LC_TIME, 'portuguese');
include 'lib.php';
include 'auth.php';

$largura = 830;
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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="scripts/thickbox-compressed.js"></script>
    <link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
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
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio Publicidade M&ecirc;s <?php echo date("m",strtotime($primrodiacomp));?></strong><br /><font size="-1">Loja: Londrina/Internet</font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table style="padding: 4px; width: <?php echo $largura; ?>px;">
<tr><td valign=top>
    <table style="padding: 4px;">
    <tr>
        <td style="text-align: center;padding: 4px;"><strong>Data</strong></td>
        <td style="padding: 4px;"><strong>Cliente</strong></td>
        <td style="text-align: center;padding: 4px;"><strong>Compra</strong></td>
        <td style="text-align: center;padding: 4px;"><strong>Vlr. Total</strong></td>
    </tr>
    <?php
    $totalgeral = 0;
    $str = "select DS_NOME_CASO, NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, VL_TOTAL_COSO
            from compras, cadastros where
            NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
            ST_COMPRA_COSO <> 'C'
            and month(DT_COMPRA_COSO) = ".date("n",strtotime($primrodiacomp))." and year(DT_COMPRA_COSO) = ".date("Y",strtotime($primrodiacomp))."
            and NR_SEQ_CADASTRO_COSO = 8074
            ORDER BY DT_COMPRA_COSO;";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $x = 0;
        $dataant = "";
        
        $totaluni = 0;
        $totalvlr = 0;
        while($row = mysql_fetch_row($st)) {
         $dsnome	   = $row[0];
         $nrcompra	   = $row[1];
         $dt_compra	   = $row[2];
         $valorcomp	   = $row[3];
    
         $cor = "";
                
         if ($x==0){
            $cor = "#ffffff";
            $x = 1;
         }else{
            $cor = "#E9E9E9";
            $x = 0;
         }
         
         $totalvlr += $valorcomp;
         
        ?>
        <tr style="background-color: <?php echo $cor; ?>;">
        <td><?php echo date("d/m/Y H:i",strtotime($dt_compra));?></td>
        <td style="padding: 2px;"><strong><?php echo $dsnome;?></strong></td>
        <td style="text-align: center;"><a href="compras_ver.php?idc=<?php echo $nrcompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $nrcompra;?>" class="thickbox"><?php echo $nrcompra;?></a></td>
        <td style="text-align: right;">R$ <?php echo number_format($valorcomp,2,",","");?></td>
        </tr>
        <?php
        $totaluni++;
        $dataant = date("Y-m-d H:i:s",strtotime($dt_agen));
        }
      }
    ?>
    <tr style="background-color: #D3D3D3;">
        <td><strong>TOTAL</strong></td>
        <td>&nbsp;</td>
        <td style="text-align: center;"><?php echo $totaluni;?></td>
        <td style="text-align: right;"><strong>R$ <?php echo number_format($totalvlr,2,",",".");?></strong></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4"><strong>CR&Eacute;DITOS REALIZADOS PARA PERMUTAS/PROMO&Ccedil;&Otilde;ES</strong></td></tr>
    <tr>
        <td style="text-align: center;padding: 4px;"><strong>Data</strong></td>
        <td style="padding: 4px;"><strong>Cliente</strong></td>
        <td style="text-align: center;padding: 4px;"><strong>Descritivo</strong></td>
        <td style="text-align: center;padding: 4px;"><strong>Vlr. Total</strong></td>
    </tr>
    <?php
    $totalgeral += $totalvlr;
    $str = "select DS_NOME_CASO, NR_SEQ_CADASTRO_CRSA, DT_LANCAMENTO_CRSA, VL_LANCAMENTO_CRSA from contacorrente, cadastros
            where NR_SEQ_CADASTRO_CRSA = NR_SEQ_CADASTRO_CASO
            AND month(DT_LANCAMENTO_CRSA) = ".date("n",strtotime($primrodiacomp))." and year(DT_LANCAMENTO_CRSA) = ".date("Y",strtotime($primrodiacomp))."
            and VL_LANCAMENTO_CRSA > 0
            and DS_OBSERVACAO_CRSA not like 'pedido%'";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $x = 0;
        $dataant = "";
        
        $totaluni = 0;
        $totalvlr = 0;
        while($row = mysql_fetch_row($st)) {
         $dsnome	   = $row[0];
         $nrcompra	   = $row[1];
         $dt_compra	   = $row[2];
         $valorcomp	   = $row[3];
    
         $cor = "";
                
         if ($x==0){
            $cor = "#ffffff";
            $x = 1;
         }else{
            $cor = "#E9E9E9";
            $x = 0;
         }
         
         $totalvlr += $valorcomp;
         
        ?>
        <tr style="background-color: <?php echo $cor; ?>;">
        <td><?php echo date("d/m/Y H:i",strtotime($dt_compra));?></td>
        <td style="padding: 2px;"><strong><?php echo $dsnome;?></strong></td>
        <td style="text-align: center;"><a href="compras_ver_cred.php?idcli=<?php echo $nrcompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Lancamentos Me <?php echo $nrcompra;?>" class="thickbox"><?php echo $nrcompra;?></a></td>
        <td style="text-align: right;">R$ <?php echo number_format($valorcomp,2,",","");?></td>
        </tr>
        <?php
        $totaluni++;
        $dataant = date("Y-m-d H:i:s",strtotime($dt_agen));
        }
      }
      
      $totalgeral += $totalvlr;
    ?>
    <tr style="background-color: #D3D3D3;">
        <td><strong>TOTAL</strong></td>
        <td>&nbsp;</td>
        <td style="text-align: center;"><?php echo $totaluni;?></td>
        <td style="text-align: right;"><strong>R$ <?php echo number_format($totalvlr,2,",",".");?></strong></td>
    </tr>
    </table>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
    <?php
    $str = "SELECT
				FORMAT(sum(VL_PRODUTO_CESO*NR_QTDE_CESO), 2) as VlrTotal
            from 
            				cestas, compras, produtos, produtos_tipo 
            WHERE 
            				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND 
            				ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND
            				NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC 
                            AND month(DT_COMPRA_COSO) = ".date("n",strtotime($primrodiacomp))." and year(DT_COMPRA_COSO) = ".date("Y",strtotime($primrodiacomp))."
            				AND NR_SEQ_LOJAS_PRRC = 1 
            				AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
    $st = mysql_query($str);
    $row = mysql_fetch_row($st);
    $vlrtotvend = $row[0];
    
    $percpermutaP = ($totalgeral*100/$vlrtotvend)/1000;
    $percpermutaV = 100 - $percpermutaP;
    ?>
    <p>&nbsp;</p>
    Total de Investido no M&ecirc;s <?php echo date("m",strtotime($primrodiacomp));?>: <strong>R$ <?php echo number_format($totalgeral,2,",",".");?></strong>
    <br />
    Percentual investido sobre vendas do m&ecirc;s: <strong><?php echo number_format($percpermutaP,1,",",".");?>%</strong>
    <br />
    <br /><br />
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Vendas', 'Permuta'],
          ['Vendas',     <?php echo number_format($percpermutaV,1,".","");?>],
          ['Permuta',     <?php echo number_format($percpermutaP,1,".","");?>],
        ]);

        var options = {
          title: 'Percentual investido x Venda Produtos',
          pieSliceText: 'label',
          chartArea: {left: 10, top: 30, width: "100%", height: "80%"},
          slices: {  1: {offset: 0.2},
                    2: {offset: 0.4},
          },
        };                

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="piechart" style="width: 300px; height: 280px;"></div>   
</td>
</tr>
</table>
</body>
</html>
<?php mysql_close($con); ?>