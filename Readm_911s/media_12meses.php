<?php 
	 include 'auth.php';
     include 'lib.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatorio Média 12 meses</title>
<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 15px;
        width: 960px;
    }

    h2{
    	font-size: 16px;
    	font-family:Calibri, Helvetica, sans-serif;
    	font-weight: bold;
    	line-height: 20px;
    	background-color: #414042;
    	color: #FFF;
    	text-align: center;
    	width: 400px
    }

    .divisoria{
    	border-top: 3px dotted #414042;
    	width: 400px;
    	
    	margin-top: 15px;
    	margin-bottom: 15px;
    }
 
</style>
</head>
<body>

	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-04-01' and DT_COMPRA_COSO <= '2014-04-30'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			    DT_COMPRA_COSO >= '2013-04-24' and DT_COMPRA_COSO <= '2014-04-24'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	

	<h2>Média 12 Últimos meses</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>




	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-04-01' and DT_COMPRA_COSO <= '2013-04-30'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-04-01' and DT_COMPRA_COSO <= '2013-04-30'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Abril 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>


	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-05-01' and DT_COMPRA_COSO <= '2013-05-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-05-01' and DT_COMPRA_COSO <= '2013-05-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Maio 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>




	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-06-01' and DT_COMPRA_COSO <= '2013-06-30'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-06-01' and DT_COMPRA_COSO <= '2013-06-30'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Junho 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>

	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-07-01' and DT_COMPRA_COSO <= '2013-07-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-07-01' and DT_COMPRA_COSO <= '2013-07-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Julho 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>



	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-07-01' and DT_COMPRA_COSO <= '2013-07-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-07-01' and DT_COMPRA_COSO <= '2013-07-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<h2>Média Agosto 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>


	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-09-01' and DT_COMPRA_COSO <= '2013-09-30'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-09-01' and DT_COMPRA_COSO <= '2013-09-30'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Setembro 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>


	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-10-01' and DT_COMPRA_COSO <= '2013-10-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-10-01' and DT_COMPRA_COSO <= '2013-10-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Outubro 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>



	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-11-01' and DT_COMPRA_COSO <= '2013-11-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-11-01' and DT_COMPRA_COSO <= '2013-11-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Novembro 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>


	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2013-12-01' and DT_COMPRA_COSO <= '2013-12-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2013-12-01' and DT_COMPRA_COSO <= '2013-12-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Dezembro 2013</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>


	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2014-01-01' and DT_COMPRA_COSO <= '2014-01-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2014-01-01' and DT_COMPRA_COSO <= '2014-01-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Janeiro 2014</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>


	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2014-02-01' and DT_COMPRA_COSO <= '2014-02-28'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2014-02-01' and DT_COMPRA_COSO <= '2014-02-28'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Fevereiro 2014</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>





	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2014-03-01' and DT_COMPRA_COSO <= '2014-03-31'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2014-03-01' and DT_COMPRA_COSO <= '2014-03-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Março 2014</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>


	<?php 

	$query_12 = "SELECT 
			    SUM(VL_TOTAL_COSO) as Soma,
			    COUNT(NR_SEQ_COMPRA_COSO) as Total,
			    (SELECT 
			            SUM(VL_TOTAL_COSO) / COUNT(NR_SEQ_COMPRA_COSO)
			        from
			            compras
			        where
			            DT_COMPRA_COSO >= '2014-04-01' and DT_COMPRA_COSO <= '2014-04-30'
			                AND ST_COMPRA_COSO <> 'C'
			                AND ST_COMPRA_COSO <> 'A') as Media
			from
			    compras
			where
			     DT_COMPRA_COSO >= '2014-04-01' and DT_COMPRA_COSO <= '2014-04-31'
			        AND ST_COMPRA_COSO <> 'C'
			        AND ST_COMPRA_COSO <> 'A'";

	 $st_12 = mysql_query($query_12);

	 if (mysql_num_rows($st_12) > 0) {
	 	$row_12 = mysql_fetch_row($st_12);

	 	$itens_12 = $row_12[1];
	 	$total_12 = $row_12[0];
	 	$media_12 = $row_12[2];

	 }
               
                               
	?>

	<div class="divisoria"></div>

	<h2>Média Abril 2014</h2>
	<table width="400px" style="text-align: center;">
		<tr>
			<td>Total de Pedidos Pagos </td>
			<td><?php echo $itens_12; ?> </td>
		</tr>
		<tr>
			<td>Valor Total Recebido </td>
			<td>R$ <?php echo number_format($total_12, 2, ",", "."); ?> </td>
		</tr>
		<tr style="background-color: #5fbf98; color: #414042; text-align: center; font-weight: bold">
			<td>Media Por Pedido </td>
			<td>R$ <?php echo number_format($media_12, 2, ",", "."); ?> </td>
		</tr>
	</table>

</body>
