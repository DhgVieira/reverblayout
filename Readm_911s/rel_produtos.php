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
        <td class="font16" align="center" height="70"><strong>Relat&oacute;rio de Vendas de Produtos M&ecirc;s <?php echo date("m",strtotime($primrodiacomp));?></strong><br /><font size="-1">Loja: Londrina/Internet</font></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="<?php echo $largura; ?>" /></td></tr>
</table>
<table style="padding: 4px; width: <?php echo $largura; ?>px;">
<tr><td valign=top>
    <table style="padding: 4px;">
    <tr>
        <td style="padding: 4px;"><strong>Tipo</strong></td>
        <td style="padding: 4px;"><strong>Categoria</strong></td>
        <td style="text-align: center;padding: 4px;"><strong>Qtde.</strong></td>
        <td style="text-align: center;padding: 4px;"><strong>Vlr. Total</strong></td>
    </tr>
    <?php
    $tot = 0;
    
    $str = "SELECT
				DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC,
				sum(NR_QTDE_CESO) as total, 
				sum(VL_PRODUTO_CESO*NR_QTDE_CESO)
            from 
    			cestas, compras, cadastros, produtos, produtos_tipo, produtos_categoria
            WHERE 
				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
				and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
				ST_COMPRA_COSO <> 'C'	AND ST_COMPRA_COSO <> 'A'	AND
				NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
				NR_SEQ_LOJAS_PRRC = 1 AND TP_CADASTRO_CACH <> 1 and NR_SEQ_TIPO_PRRC <> 137 AND
				(DT_COMPRA_COSO between '$primrodiacomp' and '$ultimodiacomp') AND
				NR_SEQ_CADASTRO_COSO <> 8074
            GROUP BY NR_SEQ_TIPO_PRRC, NR_SEQ_CATEGORIA_PRRC
            ORDER BY NR_SEQ_TIPO_PRRC, NR_SEQ_CATEGORIA_PRRC;";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $x = 0;
        $totalvlr = 0;
        while($row = mysql_fetch_row($st)) {
         $dstipo	   = $row[0];
         $dscat 	   = $row[1];
         $qtde  	   = $row[2];
         $vlrtotal     = $row[3]; 
    
         $cor = "";
                
         if ($x==0){
            $cor = "#ffffff";
            $x = 1;
         }else{
            $cor = "#E9E9E9";
            $x = 0;
         }
         
         $totalvlr += $vlrtotal;
        ?>
        <tr style="background-color: <?php echo $cor; ?>;">
        <td style="padding: 2px;"><strong><?php echo $dstipo;?></strong></td>
        <td style="padding: 2px;"><strong><?php echo $dscat;?></strong></td>
        <td style="text-align: center;"><?php echo $qtde; ?></td>
        <td style="text-align: right;white-space:nowrap;"><strong>R$ <?php echo number_format($vlrtotal,2,",","."); ?></strong></td>
        </tr>
        <?php
        }
      }
    ?>
    <tr style="background-color: #D3D3D3;">
        <td><strong>TOTAL</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align: right;"><strong>R$ <?php echo number_format($totalvlr,2,",",".");?></strong></td>
        </tr>
    </table>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
    <table style="padding: 5px; font-size: 12px; width: 450px;">
    <tr>
        <td colspan="2"><strong>10 Camisetas mais Vendidas:</strong></td>
    </tr>
    <?php
    $sql = "SELECT
            				DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_CESO) as total
            from 
            				cestas, compras, produtos, cadastros, produtos_tipo, produtos_categoria 
            WHERE 
            				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND 
            			  NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
            				AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC
            				AND ST_COMPRA_COSO <> 'C'
            				AND DT_COMPRA_COSO > '$primrodiacomp' and DT_COMPRA_COSO < '$ultimodiacomp'
            				AND NR_SEQ_LOJAS_PRRC = 1 and NR_SEQ_TIPO_PRRC = 6
            				AND NR_SEQ_CADASTRO_COSO <> 8074
            				AND TP_CADASTRO_CACH <> 1 
            GROUP BY 
            				NR_SEQ_PRODUTO_CESO
            ORDER BY total desc LIMIT 10;";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        $x = 0;
        while($row = mysql_fetch_row($st)){
            if ($x==0){
                $cor = "#ffffff";
                $x = 1;
             }else{
                $cor = "#E9E9E9";
                $x = 0;
             }
            ?>
            <tr style="background-color: <?php echo $cor; ?>;">
                <td><?php echo $row[0];?>/<?php echo $row[1];?></td>
                <td><strong><?php echo $row[2];?></strong></td>
                <td style="width: 20px; text-align: center;"><strong><?php echo $row[3];?></strong></td>
            </tr>
            <?php
        }
    }
    ?>
    </table>
    <p>&nbsp;</p>
    <table style="padding: 5px; font-size: 12px; width: 450px;">
    <tr>
        <td colspan="2"><strong>10 Buttons mais Vendidos:</strong></td>
    </tr>
    <?php
    $sql = "SELECT
            				DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_CESO) as total
            from 
            				cestas, compras, produtos, cadastros, produtos_tipo, produtos_categoria 
            WHERE 
            				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND 
            			  NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
            				AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC
            				AND ST_COMPRA_COSO <> 'C'
            				AND DT_COMPRA_COSO > '$primrodiacomp' and DT_COMPRA_COSO < '$ultimodiacomp'
            				AND NR_SEQ_LOJAS_PRRC = 1 and NR_SEQ_TIPO_PRRC = 4
            				AND NR_SEQ_CADASTRO_COSO <> 8074
            				AND TP_CADASTRO_CACH <> 1 
            GROUP BY 
            				NR_SEQ_PRODUTO_CESO
            ORDER BY total desc LIMIT 10;";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        $x = 0;
        while($row = mysql_fetch_row($st)){
            if ($x==0){
                $cor = "#ffffff";
                $x = 1;
             }else{
                $cor = "#E9E9E9";
                $x = 0;
             }
            ?>
            <tr style="background-color: <?php echo $cor; ?>;">
                <td><?php echo $row[0];?>/<?php echo $row[1];?></td>
                <td><strong><?php echo $row[2];?></strong></td>
                <td style="width: 20px; text-align: center;"><strong><?php echo $row[3];?></strong></td>
            </tr>
            <?php
        }
    }
    ?>
    </table>
</td>
</tr>
</table>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Camisetas'],
          <?php
            $str = "SELECT
                    				DAY(DT_COMPRA_COSO), sum(NR_QTDE_CESO) as total
                    from 
                    				cestas, compras, cadastros, produtos, produtos_tipo, produtos_categoria
                    WHERE 
                    				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                    				and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
                    				ST_COMPRA_COSO <> 'C'	AND ST_COMPRA_COSO <> 'A'	AND
                    				NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
                    				NR_SEQ_LOJAS_PRRC = 1 AND TP_CADASTRO_CACH <> 1 and NR_SEQ_TIPO_PRRC = 6 AND
                    				(DT_COMPRA_COSO between '$primrodiacomp' and '$ultimodiacomp') AND
                    				NR_SEQ_CADASTRO_COSO <> 8074
                    GROUP BY DAY(DT_COMPRA_COSO)
                    ORDER BY DT_COMPRA_COSO";
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
          title: 'Camisetas Vendidas por Dia Mes <?php echo date("m",strtotime($primrodiacomp)); ?>',
          chartArea: {left: 45, width: "100%", height: "80%"},
          legend: 'none'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div" style="width: 821px; height: 400px;"></div> 
</body>
</html>
<?php mysql_close($con); ?>