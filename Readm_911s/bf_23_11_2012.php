<?php
setlocale(LC_TIME, 'portuguese');
include 'lib.php';
include 'auth.php';

$largura = 830;
$codigopromo = 10;
$primrodiacomp = "2012-11-23 00:00:00";
$ultimodiacomp = "2012-11-24 11:00:00";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resumo de Vendas de Promo&ccedil;&atilde;o</title>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="scripts/thickbox-compressed.js"></script>
    <link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
    
    <link href="../css/shopmenu.css" rel="stylesheet" type="text/css" />
    <link href="../css/shop_new.css" rel="stylesheet" type="text/css" />
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
    <style>
#shop .produto {
	width:120px;
	float:left;
	height:121px;
	background:#FFFFFF;
	border: solid 1px #6b4922;
	padding: 4px;
	margin: 0 0 10px 0;
}

	#shop .produto img {
		margin:0;
		padding:0;
	}

#shop .preco-produto {
	float:left;
	width:30px;
	margin:10px 0 0 0;
	padding:0;
}

#shop .desc-produto {
	float:left;
	margin: 10px 0 0 10px;
	padding:0;
}
</style>
</head>
<body>
<p>&nbsp;</p>
<table>
    <?php
    $str = "select count(*), sum(VL_TOTAL_COSO), sum(VL_TOTAL_COSO)/count(*) from compras
            where NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and NR_SEQ_LOJA_COSO = 1
            and ST_COMPRA_COSO <> 'C' and NR_SEQ_PROMO_COSO = $codigopromo;";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
        $row = mysql_fetch_row($st);
        $qtdtotal = $row[0];
        $vlrtotal = $row[1];
        $ticketmedio = $row[2];
    }
                       
    ?>
    <tr>
        <td valign=top style="font-size: 12px; padding: 10px;" colspan="3">
            <strong>PROMO&Ccedil;&Atilde;O BLACK FRIDAY</strong>
            <p>&nbsp;</p>
            <strong>Per&iacute;odo da Promo:</strong> 23/11/2012 00:00 a 24/11/2012 11:00<br />
            <strong>Quantidade Total de Vendas: </strong><?php echo $qtdtotal;?><br />
            <strong>Valor Total de Vendas: </strong>R$ <?php echo number_format($vlrtotal,2,",",".");?><br />
            <strong>Ticket M&eacute;dio: </strong>R$ <?php echo number_format($ticketmedio,2,",",".");?>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td valign=top>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Em Aberto', 'Pagas'],
                  <?php
                    $str = "select ST_COMPRA_COSO, count(*), sum(VL_TOTAL_COSO) from compras
                    where NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and NR_SEQ_LOJA_COSO = 1
                    and ST_COMPRA_COSO <> 'C' and NR_SEQ_PROMO_COSO = $codigopromo
                    GROUP BY ST_COMPRA_COSO ORDER BY ST_COMPRA_COSO desc;";
                    $st = mysql_query($str);
                    if (mysql_num_rows($st) > 0) {
                        while($row = mysql_fetch_row($st)) {
                  ?>
                  ['<?php echo $row[0];?> - R$ <?php echo number_format($row[2],2,",",".");?>', <?php echo $row[1];?>],
                  <?php
                        }
                  }
                  ?>
                ]);
        
                var options = {
                  title: 'Vendas Totais Pagas x Em Aberto - Total: R$ <?php echo number_format($vlrtotal,2,",",".");?>',
                  pieSliceText: 'label',
                  chartArea: {left: 40, top: 30, width: "100%", height: "80%"},
                  slices: {  1: {offset: 0.05},
                            2: {offset: 0.05},
                            3: {offset: 0.05},
                  },
                };                
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
              }
            </script>
            
            <div id="piechart" style="width: 400px; height: 280px;"></div>   
        </td>
        <td valign=top>&nbsp;</td>
        <td valign=top style="font-size: 12px;">
            <?php
            $str = "SELECT
                    				sum(NR_QTDE_CESO) as total
                    from 
                    				cestas, compras, cadastros, produtos, produtos_tipo, produtos_categoria
                    WHERE 
                    				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                    				and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
                    				ST_COMPRA_COSO <> 'C' AND
                    				NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
                    				NR_SEQ_LOJAS_PRRC = 1 AND TP_CADASTRO_CACH <> 1 and NR_SEQ_TIPO_PRRC = 6 AND
                    				(NR_SEQ_PROMO_COSO = $codigopromo) AND
                    				NR_SEQ_CADASTRO_COSO <> 8074;";
            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {
                $row = mysql_fetch_row($st);
                $totaln = $row[0];
            }
            
            $str = "SELECT
                    				sum(NR_QTDE_CESO) as total
                    from 
                    				cestas, compras, cadastros, produtos, produtos_tipo, produtos_categoria
                    WHERE 
                    				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                    				and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
                    				ST_COMPRA_COSO <> 'C' AND
                    				NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
                    				NR_SEQ_LOJAS_PRRC = 1 AND TP_CADASTRO_CACH <> 1 and NR_SEQ_TIPO_PRRC = 6 AND
                    				(NR_SEQ_PROMO_COSO = $codigopromo) AND
                                    (VL_PRODUTO_CESO = 45 or VL_PRODUTO_CESO = 65) and
                    				NR_SEQ_CADASTRO_COSO <> 8074;";
            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {
                $row = mysql_fetch_row($st);
                $totalp = $row[0];
            }
            ?>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Normais','Podrinhas'],
                  ['Normais', <?php echo ($totaln-$totalp);?>],
                  ['Podrinhas', <?php echo $totalp;?>],
                ]);
        
                var options = {
                  title: 'Podrinhas x Normais',
                  pieSliceText: 'label',
                  chartArea: {left: 40, top: 30, width: "100%", height: "80%"},
                  slices: {  1: {offset: 0.05},
                            2: {offset: 0.05},
                            3: {offset: 0.05},
                  },
                };                
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart4'));
                chart.draw(data, options);
              }
            </script>
            
            <div id="piechart4" style="width: 400px; height: 280px;"></div>   
        </td>
    </tr>
    <tr>
        <td valign=top>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Dia', 'Total'],
                  <?php
                    $str = "SELECT
                    				DAY(DT_COMPRA_COSO), count(*), sum(VL_TOTAL_COSO)
                    from 
                    				compras
                    WHERE 
                    				ST_COMPRA_COSO <> 'C'	AND
                    				(NR_SEQ_PROMO_COSO = $codigopromo) AND
                    				NR_SEQ_LOJA_COSO = 1 and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
                    GROUP BY DAY(DT_COMPRA_COSO)
                    ORDER BY DT_COMPRA_COSO";
                    $st = mysql_query($str);
                    if (mysql_num_rows($st) > 0) {
                        while($row = mysql_fetch_row($st)) {
                  ?>
                  ['<?php echo $row[0];?>/10 - R$ <?php echo number_format($row[2],2,",",".");?>', <?php echo $row[1];?>],
                  <?php
                        }
                  }
                  ?>
                ]);
        
                var options = {
                  title: 'Vendas por Dia Promo',
                  chartArea: {left: 45, width: "100%", height: "80%"},
                  legend: 'none',
                  colors: ['red','green']
                };
        
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
              }
            </script>
            
            <div id="chart_div" style="width: 421px; height: 200px;"></div> 
        </td>
        <td valign=top>&nbsp;</td>
        <td valign=top>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Dia', 'Camisetas'],
                  <?php
                    $camtot = 0;
                    $str = "SELECT
                            				DAY(DT_COMPRA_COSO), sum(NR_QTDE_CESO) as total
                            from 
                            				cestas, compras, cadastros, produtos, produtos_tipo, produtos_categoria
                            WHERE 
                            				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                            				and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
                            				ST_COMPRA_COSO <> 'C' AND
                            				NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
                            				NR_SEQ_LOJAS_PRRC = 1 AND TP_CADASTRO_CACH <> 1 and NR_SEQ_TIPO_PRRC = 6 AND
                            				(NR_SEQ_PROMO_COSO = $codigopromo) AND
                            				NR_SEQ_CADASTRO_COSO <> 8074
                            GROUP BY DAY(DT_COMPRA_COSO)
                            ORDER BY DT_COMPRA_COSO";
                    $st = mysql_query($str);
                    if (mysql_num_rows($st) > 0) {
                        while($row = mysql_fetch_row($st)) {
                            $camtot += $row[1];
                  ?>
                  ['<?php echo $row[0];?>/10', <?php echo $row[1];?>],
                  <?php
                        }
                  }
                  ?>
                ]);
        
                var options = {
                  title: 'Camisetas Vendidas por Dia Promo - Total: <?php echo $camtot; ?>',
                  chartArea: {left: 45, width: "100%", height: "80%"},
                  legend: 'none'
                };
        
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
                chart.draw(data, options);
              }
            </script>
            
            <div id="chart_div2" style="width: 421px; height: 200px;"></div> 
        </td>
    </tr>
    <tr>
        <td valign=top>
            <?php
                $str = "select count(*), sum(VL_TOTAL_COSO) from compras
                where NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and NR_SEQ_LOJA_COSO = 1
                and ST_COMPRA_COSO <> 'C' and (NR_SEQ_PROMO_COSO = $codigopromo)
                and VL_TOTAL_COSO >= 260;";
                $st = mysql_query($str);
                if (mysql_num_rows($st) > 0) {
                    $row = mysql_fetch_row($st);
                    $tot260 = $row[0];
                    $tot260v = $row[1];
                }
             ?>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['R$260','Outras'],
                  ['R$260 - R$ <?php echo number_format($tot260v,2,",",".");?>', <?php echo $tot260;?>],
                  ['Outras - R$ <?php echo number_format($vlrtotal-$tot260v,2,",",".");?>', <?php echo $qtdtotal-$tot260;?>],
                ]);
        
                var options = {
                  title: 'Compras de R$ 260,00 (ou mais) x Total',
                  pieSliceText: 'label',
                  chartArea: {left: 40, top: 30, width: "100%", height: "80%"},
                  slices: {  1: {offset: 0.05},
                            2: {offset: 0.05},
                  },
                };                
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                chart.draw(data, options);
              }
            </script>
            
            <div id="piechart2" style="width: 400px; height: 280px;"></div> 
        </td>
        <td valign=top>&nbsp;</td>
        <td valign=top>
           <?php
                $str = "select count(*), sum(VL_TOTAL_COSO) from compras, cadastros
                where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and
                NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and NR_SEQ_LOJA_COSO = 1
                and ST_COMPRA_COSO <> 'C' and (NR_SEQ_PROMO_COSO = $codigopromo)
                AND DS_SEXO_CACH in ('F','Feminino')";
                $st = mysql_query($str);
                if (mysql_num_rows($st) > 0) {
                    $row = mysql_fetch_row($st);
                    $totMulher = $row[0];
                    $totMulherv = $row[1];
                    $totHomem = $qtdtotal - $totMulher;
                    $totHomemv = $vlrtotal - $totMulherv;
                }
             ?>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Homens','Mulheres'],
                  ['Homens - R$ <?php echo number_format($totHomemv,2,",",".");?>', <?php echo $totHomem;?>],
                  ['Mulheres - R$ <?php echo number_format($totMulherv,2,",",".");?>', <?php echo $totMulher;?>],
                ]);
        
                var options = {
                  title: 'Compras de Homens x Mulheres',
                  pieSliceText: 'label',
                  chartArea: {left: 40, top: 30, width: "100%", height: "80%"},
                  slices: {  1: {offset: 0.1},
                            2: {offset: 0.1},
                  },
                };                
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
                chart.draw(data, options);
              }
            </script>
            
            <div id="piechart3" style="width: 400px; height: 280px;"></div> 
        </td>
    </tr>
</table>

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Cadastros', 'Compraram'],
          <?php
            $str = "select DAY(DT_CADASTRO_CASO), count(*), DT_CADASTRO_CASO from
             cadastros where (DT_CADASTRO_CASO BETWEEN '$primrodiacomp' and '$ultimodiacomp')
             and TP_CADASTRO_CACH <> 1 and ST_CADASTRO_CASO = 'A' and NR_SEQ_LOJA_CASO = 1
                GROUP BY DAY(DT_CADASTRO_CASO)
                order by DT_CADASTRO_CASO";
            $st = mysql_query($str);
            $novostot = 0;
            $novostotv = 0;
            if (mysql_num_rows($st) > 0) {
                while($row = mysql_fetch_row($st)) {
                    $str2 = "select count(*), sum(VL_TOTAL_COSO)
                            from compras, cadastros where
                            NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                            ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' AND 
                            day(DT_CADASTRO_CASO) = day(DT_COMPRA_COSO) and month(DT_CADASTRO_CASO) = month(DT_COMPRA_COSO) and year(DT_CADASTRO_CASO) = year(DT_COMPRA_COSO) and 
                            day(DT_COMPRA_COSO) = ".$row[0]." and month(DT_COMPRA_COSO) = ".date("n",strtotime($primrodiacomp))." and year(DT_COMPRA_COSO) = ".date("Y",strtotime($primrodiacomp))."
                            AND TP_CADASTRO_CACH <> 1
                            and NR_SEQ_LOJA_CASO = 1";
                    $st2 = mysql_query($str2);
                    $row2 = mysql_fetch_row($st2);
                    
                    $novostot += $row2[0];
                    $novostotv += $row2[1];
          ?>
          ['Dia <?php echo $row[0];?>', <?php echo $row[1];?>, <?php echo $row2[0];?>],
          <?php
                }
          }
          ?>
        ]);

        var options = {
          title: 'Cadastros por Dia x Primeira Compra (<?php echo $novostot;?> com compras - R$ <?php echo number_format($novostotv,2,",",".");?> - Ticket Medio: R$ <?php echo number_format($novostotv/$novostot,2,",",".");?>)',
          chartArea: {left: 30, width: "100%", height: "80%"},
          legend: 'none'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div5'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div5" style="width: 841px; height: 400px;"></div> 

<script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Hora', 'Total'],
                  <?php
                    $str = "SELECT
                    				DT_COMPRA_COSO, HOUR(DT_COMPRA_COSO), count(*)
                    from 
                    				compras
                    WHERE 
                    				ST_COMPRA_COSO <> 'C'	AND
                    				(NR_SEQ_PROMO_COSO = $codigopromo) AND
                    				NR_SEQ_LOJA_COSO = 1 and NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)
                    GROUP BY day(DT_COMPRA_COSO), HOUR(DT_COMPRA_COSO)
                    ORDER BY DT_COMPRA_COSO;";
                    $st = mysql_query($str);
                    if (mysql_num_rows($st) > 0) {
                        while($row = mysql_fetch_row($st)) {
                  ?>
                  ['<?php echo date("H",strtotime($row[0]));?>:00', <?php echo $row[2];?>],
                  <?php
                        }
                  }
                  ?>
                ]);
        
                var options = {
                  title: 'Vendas por Hora',
                  chartArea: {left: 45, width: "100%", height: "80%"},
                  legend: 'none'
                };
        
                var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));
                chart.draw(data, options);
              }
            </script>
            <div id="chart_div3" style="width: 841px; height: 400px;"></div> 
 <br />           
<br />
<p style="font-size: 16px;">&nbsp;&nbsp;<strong>Camisetas Mais Vendidas</strong></p>
<br />
<br />
<div id="shop" style="background-color: white;">
<div id="listaprodutos" style="width: 990px;">
                
							<?php
                            $totalest = 0;
                            
                            $num_por_pagina = 1000;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                                    
        
                             $sql = "SELECT NR_SEQ_PRODUTO_PRRC, VL_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC, TP_DESTAQUE_PRRC, 
                                    DS_FRETEGRATIS_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PTRC, SUM(NR_QTDE_CESO) as total from compras, cestas, produtos, produtos_tipo where 
                                    NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND
                                    NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND
                                    NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND                                    
                                    NR_SEQ_CADASTRO_COSO not in (8074, 6605, 22364) and 
                                    ST_COMPRA_COSO <> 'C' AND NR_SEQ_TIPO_PRRC = 6 and 
                                    (NR_SEQ_PROMO_COSO = $codigopromo) 
                                    and NR_SEQ_LOJAS_PRRC = 1
                                    GROUP BY NR_SEQ_PRODUTO_CESO ORDER by total desc";
                            
                            
                            $st = mysql_query($sql);
                            if (mysql_num_rows($st) > 0) {
                                $marg_es = 10;
                                $marg_to = 0;
                                $totp = 0;
                                $qtde_total = 0;
                                while($row = mysql_fetch_row($st)) {
                                    $id_prod	   = $row[0];
                                    $vl_prod	   = Valor_Produto($row[0],$SS_logado);
                                    $ds_prod	   = $row[2];
                                    $ds_ext		   = $row[3];
                                    $destaque	   = $row[4];
                                    $fretegratis   = $row[5];
                                    $vlrpromo	   = $row[6];
                                    $ds_categoria  = $row[7];
                                    $qtde_estoq    = $row[8];
                                    
                                    $qtde_total += $qtde_estoq;
                                    
                                    switch ($destaque) {
                                        case 0:
                                            $destaque = "";
                                            break;
                                        case 1:
                                            $destaque = "n";
                                            break;
                                        case 2:
                                            $destaque = "s";
                                            break;
                                        case 3:
                                            $destaque = "r";
                                            break;
                                    }
                                    ?>
                                    <div class="produto"  style="margin: 0 0 7px 6px;position: relative; z-index:1; height: 185px;width: 160px;text-align: center;">
                                    <div style="text-align: center;"><strong><?php echo $qtde_estoq ?></strong></div>
                                  	  <?php if ($ds_ext == "swf") {?>
                                      <object data="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                        <param name="quality" value="high" />
                                        <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                        <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" />
                                        <param name="wmode" value="opaque" />
                                    </object>
                                      <?php }else{ 
                                      $ds_categoria = str_replace("&","e;",$ds_categoria);
                                      $ds_prod_url = str_replace("&","e;",$ds_prod);
                                      ?>
                                      <a target="_blank" href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="120" /></a>
                                      <?php } ?>
                                     
                                      <div>                                        <p><a target="_blank" style="color: black;" href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><?php echo $ds_prod; ?></a>
                                        <?php if ($fretegratis == "S") echo "<span class=\"promocao\" style=\"margin:0;padding:0\"><strong>FRETE GRÁTIS</strong></span>"; ?>
                                        </p>
                                      </div>
                                      
                                      </div>
                                      
                                      <?php
                                      }
                                     }
                                     ?>
                                </div>
                                </div>
</body>
</html>
<?php mysql_close($con); ?>