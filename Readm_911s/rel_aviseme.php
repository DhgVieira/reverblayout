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
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Compras Avise-me do M&ecirc;s <?php echo date("m",strtotime($primrodiacomp));?></strong><br /><font size="-1">Loja: Londrina/Internet</font></td>
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
    $str = "select DT_COMPRA_COSO, DS_NOME_CASO, NR_SEQ_COMPRA_COSO, sum(VL_TOTAL_COSO) from aviseme, cadastros, compras, cestas where 
            NR_SEQ_CADASTRO_AVRC = NR_SEQ_CADASTRO_CASO
            and NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
            and ST_COMPRA_COSO <> 'C' and NR_SEQ_LOJA_CASO = 1 and TP_CADASTRO_CACH <> 1
            and (DT_COMPRA_COSO between '$primrodiacomp' and '$ultimodiacomp')
            and NR_SEQ_PRODUTO_AVRC = NR_SEQ_PRODUTO_CESO
            GROUP BY NR_SEQ_CADASTRO_AVRC
            order by DT_COMPRA_COSO";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $x = 0;
        $dataant = "";
        
        $totaluni = 0;
        $totalvlr = 0;
        while($row = mysql_fetch_row($st)) {
         $dsnome	   = $row[1];
         $nrcompra	   = $row[2];
         $dt_compra	   = $row[0];
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
        <td style="white-space: nowrap;"><?php echo date("d/m/Y H:i",strtotime($dt_compra));?></td>
        <td style="padding: 2px;"><strong><?php echo $dsnome;?></strong></td>
        <td style="text-align: center;"><a href="compras_ver.php?idc=<?php echo $nrcompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $nrcompra;?>" class="thickbox"><?php echo $nrcompra;?></a></td>
        <td style="text-align: right;white-space: nowrap;">R$ <?php echo number_format($valorcomp,2,",","");?></td>
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
        <td style="text-align: right;white-space: nowrap;"><strong>R$ <?php echo number_format($totalvlr,2,",",".");?></strong></td>
        </tr>
    </table>
    <?php
    $str = "select count(DISTINCT(NR_SEQ_CADASTRO_AVRC)) from aviseme where
            MONTH(DT_SOLICITACAO_AVRC) = ".date("n",strtotime($primrodiacomp))."
            and NR_SEQ_CADASTRO_AVRC is not null";
    $st = mysql_query($str);
    $row = mysql_fetch_row($st);
    $totalnivers = $row[0];
    ?>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
    <p>&nbsp;</p>
    Total de Compradores do M&ecirc;s <?php echo date("m",strtotime($primrodiacomp));?>: <strong><?php echo $totaluni;?></strong>
    <br />
    Total em Compras: <strong>R$ <?php echo number_format($totalvlr,2,",",".");?></strong>
    <br />
    Ticket M&eacute;dio: <strong>R$ <?php echo number_format($totalvlr/$totaluni,2,",",".");?></strong>
    <br />
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Total', 'Realizadas'],
          ['Total',     <?php echo $totalnivers;?>],
          ['Realizadas',     <?php echo $totaluni;?>],
        ]);

        var options = {
          title: 'Total Socilitado x Realizadas',
          pieSliceText: 'label',
          chartArea: {left: 20, top: 60, width: "100%", height: "100%"},
          slices: {  1: {offset: 0.2},
                    2: {offset: 0.4},
          },
        };                

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="piechart" style="width: 350px; height: 280px;"></div>    
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Compras'],
          <?php
          for ($f=1;$f<=date("j",strtotime($ultimodiacomp));$f++){
              $sql = "select count(DISTINCT(NR_SEQ_COMPRA_COSO)) from aviseme, cadastros, compras, cestas where 
                    NR_SEQ_CADASTRO_AVRC = NR_SEQ_CADASTRO_CASO
                    and NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                    and ST_COMPRA_COSO <> 'C' and NR_SEQ_LOJA_CASO = 1 and TP_CADASTRO_CACH <> 1
                    and day(DT_COMPRA_COSO) = ".$f." 
                    and month(DT_COMPRA_COSO) = ".date("n",strtotime($primrodiacomp))."
                    and year(DT_COMPRA_COSO) = ".date("Y",strtotime($primrodiacomp))."
                    and NR_SEQ_PRODUTO_AVRC = NR_SEQ_PRODUTO_CESO";
              $st = mysql_query($sql);
              $totaldia = 0;
              if (mysql_num_rows($st) > 0) {
                while($row = mysql_fetch_row($st)) {
                    $totaldia = $row[0];
                    if (!$totaldia) $totaldia = 0;
          ?>
          ['Dia <?php echo $f;?>', <?php echo $totaldia;?>],
          <?php
                }
             }
          }
          ?>
        ]);

        var options = {
          title: 'Compras de Avise-me por Dia',
          chartArea: {left: 30, top:25, width: "100%", height: "70%"},
          legend: 'none'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div" style="width: 400px; height: 400px;"></div> 
        
</td>
</tr>
</table>
</body>
</html>
<?php mysql_close($con); ?>