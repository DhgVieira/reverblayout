<?php
setlocale(LC_TIME, 'portuguese');
include 'lib.php';
include 'auth.php';

$largura = 960;
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
    
    <script type="text/javascript" src="scripts/jquery.vmap.js"></script>
    <script type="text/javascript" src="scripts/jquery.vmap.brazil.js"></script>
    
    <link href="scripts/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
    
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
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Venda por Estados - M&ecirc;s <?php echo date("m",strtotime($primrodiacomp));?></strong><br /><font size="-1">Loja: Londrina/Internet</font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table style="padding: 4px; width: <?php echo $largura; ?>px;">
<tr><td valign=top>
    <?php
    $str = "SELECT
            				DS_UF_CASO, sum(VL_TOTAL_COSO) as total, count(*)
            from 
            				compras, cadastros
            WHERE 
            				NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
            				and ST_COMPRA_COSO <> 'C'
            				AND month(DT_COMPRA_COSO) = ".date("n",strtotime($primrodiacomp))." and year(DT_COMPRA_COSO) = ".date("Y",strtotime($primrodiacomp))."
            				AND NR_SEQ_LOJA_COSO = 1 and TP_CADASTRO_CACH <> 1
            				AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
            GROUP BY DS_UF_CASO
            order by total desc";
    $st = mysql_query($str);
    $strmapa = "";
    $strmapa2 = "";
    while($row = mysql_fetch_row($st)){
        $estado = $row[0];
        $vendas = $row[1];
        $qtdevd = $row[2];
        
        $strmapa .= 'if (label[0].innerHTML == "'.$estado.'") label[0].innerHTML = label[0].innerHTML + " - '.$qtdevd.' vendas - R$ '.number_format($vendas,2,",",".").'";'."\n";
        $strmapa2 .= "['$estado',  ".number_format($vendas,2,".","")."],";
    }
        ?>
    <script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#vmap').vectorMap({
		    map: 'brazil_br',
		    enableZoom: false,
            backgroundColor: '#ffffff',
		    showTooltip: true,
            onLabelShow: function(event, label, code) {
                <?php echo $strmapa; ?>
            }
            //onRegionClick: function(element, code, region)
//            {
//                var message = 'You clicked "'
//                    + region
//                    + '" which has the code: '
//                    + code.toUpperCase();
//        
//                alert(message);
//            }
		});
	});
	</script>
    <div id="vmap" style="width: 680px; height: 600px;"></div>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
    <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Estado', 'Vendas'],
          <?php echo $strmapa2; ?>
        ]);

        var options = {
          title: 'Estados com Maior Valor de Vendas',
          chartArea: {left: 30, top:40, width: "100%", height: "80%"},
          legend: 'none'
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div" style="width: 350px; height: 550px; margin-left: -100px;"></div>
</td>
</tr>
</table>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Estado', 'Camisetas'],
          <?php
            $str = "SELECT
                    				DS_UF_CASO, sum(NR_QTDE_CESO) as total
                    from 
                    				cestas, produtos, compras, cadastros
                    WHERE 
                    				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO
                    				and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                    				AND NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                    				and ST_COMPRA_COSO <> 'C' and NR_SEQ_TIPO_PRRC = 6
                    				and month(DT_COMPRA_COSO) = ".date("n",strtotime($primrodiacomp))." and year(DT_COMPRA_COSO) = ".date("Y",strtotime($primrodiacomp))."
                    				AND NR_SEQ_LOJA_COSO = 1 and TP_CADASTRO_CACH <> 1
                    				AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
                    GROUP BY DS_UF_CASO
                    order by total desc";
            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {
                while($row = mysql_fetch_row($st)) {
              ?>
              ['<?php echo $row[0];?>', <?php echo $row[1];?>],
              <?php
                    }
              }
              ?>
        ]);

        var options = {
          title: 'Quantidade de Camisetas por Estado',
          chartArea: {left: 50, width: "100%", height: "80%"},
          legend: 'none'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div2" style="width: <?php echo $largura; ?>px; height: 400px;"></div>
     
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
</body>
</html>
<?php mysql_close($con); ?>