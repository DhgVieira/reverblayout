<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Camisetas com defeito</title>
</head>
<body>
<?php
	include 'lib.php';

	$data = request('data');

	$dataReferencia = date('m/Y', strtotime('-1 month'));

	$sql = "SELECT 
			    SUM(nr_qtde_ecrc), nr_seq_produto_prrc, DS_PRODUTO2_PRRC, vl_produto_prrc, vl_produto2_prrc, ds_obs_ecrc
			FROM
			    estoque_controle
			        INNER JOIN
			    produtos ON nr_seq_produto_prrc = nr_seq_produto_ecrc
			WHERE
			    ds_obs_ecrc LIKE '%def%'";

    if(!empty($data)){
    	$dataSql = explode('-', $data);
    	$dataReferencia = $dataSql[0] . '/' . $dataSql[1];
    	$dataSql = $dataSql[1] . '-' . $dataSql[0];

    	$sql .= " AND DATE_FORMAT(dt_acao_ecrc, '%Y-%m') = '".$dataSql."'";
    }else{
    	$sql .= " AND DATE_FORMAT(dt_acao_ecrc, '%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m')";
    }
	$sql .= " GROUP BY nr_seq_produto_ecrc";

	$query = mysql_query($sql);

	if (mysql_num_rows($query) > 0) {
		?>
			<h2 style="text-align: center;">Camisetas com defeito - <?php echo $dataReferencia ?></h2>
			<table align='center' width='40%'>
				<tr bgcolor='silver'>
					<td><strong style='font-size: 14px; font-family: Calibri, Helvetica, sans-serif;'>Produto</strong></td>
					<td><strong style='font-size: 14px; font-family: Calibri, Helvetica, sans-serif;'>Quantidade</strong></td>
					<td><strong style='font-size: 14px; font-family: Calibri, Helvetica, sans-serif;'>Preço custo</strong></td>
					<td><strong style='font-size: 14px; font-family: Calibri, Helvetica, sans-serif;'>Preço custo total</strong></td>
					<td><strong style='font-size: 14px; font-family: Calibri, Helvetica, sans-serif;'>Preço venda</strong></td>
					<td><strong style='font-size: 14px; font-family: Calibri, Helvetica, sans-serif;'>Preço venda total</strong></td>
					<td><strong style='font-size: 14px; font-family: Calibri, Helvetica, sans-serif;'>Motivo</strong></td>
				</tr>
		<?php
		$qtdTotal = 0;
		$custo = 0;
		$custoTotal = 0;
		$venda = 0;
		$vendaTotal = 0;
		while($row = mysql_fetch_row($query)) {
			$qtdTotal += $row[0];
			$custo += $row[4];
			$custoTotal += abs($row[0]) * $row[4];
			$venda += $row[3];
			$vendaTotal += abs($row[0]) * $row[3];
		?>
					<tr>
						<td>
							<a style='text-decoration:none; color : #000; font-family:Verdana;font-size:12px;' href='https://www.reverbcity.com/Readm_911s/grupos_alt.php?idp=<?php echo $row[1] ?>&pg=1'><?php echo utf8_encode($row[2]) ?></a>
						</td>
						<td>
							<span style='font-family:Verdana;font-size:12px;'><?php echo abs($row[0]) ?></span>
						</td>
						<td>
							<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format($row[4], 2, ",", ".") ?></span>
						</td>
						<td>
							<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format(abs($row[0]) * $row[4], 2, ",", ".") ?></span>
						</td>
						<td>
							<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format($row[3], 2, ",", ".") ?></span>
						</td>
						<td>
							<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format(abs($row[0]) * $row[3], 2, ",", ".") ?></span>
						</td>
						<td>
							<span style='font-family:Verdana;font-size:12px;'><?php echo $row[5] ?></span>
						</td>
					</tr>
		<?php
		}
		?>
			<tr>
				<td colspan="6"></td>
			</tr>
			<tr bgcolor='silver'>
				<td>
					<span style='font-family:Verdana;font-size:12px;'>Total</span>
				</td>
				<td>
					<span style='font-family:Verdana;font-size:12px;'><?php echo abs($qtdTotal) ?></span>
				</td>
				<td>
					<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format($custo, 2, ",", ".") ?></span>
				</td>
				<td>
					<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format($custoTotal, 2, ",", ".") ?></span>
				</td>
				<td>
					<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format($venda, 2, ",", ".") ?></span>
				</td>
				<td>
					<span style='font-family:Verdana;font-size:12px;'>R$ <?php echo number_format($vendaTotal, 2, ",", ".") ?></span>
				</td>
				<td></td>
			</tr>
		</table>
		<?php
	}
	//$body = IncluiPapelCarta("sistema",$body,'Camisetas com defeito - '. $dataReferencia); 
	//EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",'daniel.arbext@gmail.com',"","",'Camisetas com defeito - ' . $dataReferencia, $body);
?>
</body>
</html>