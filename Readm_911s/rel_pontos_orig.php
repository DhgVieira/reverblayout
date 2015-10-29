<?php
include 'auth.php';
include 'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatório</title>
<style>
	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:24px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:16px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
</head>
<body>
<table width="820">
	<tr><td colspan="3" align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Pontos dos Clientes</strong></td>
        <td class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<table width="820" class="font12">
	<tr>
        <td align="left" width="100"><strong>Cliente</strong></td>
        <td align="left" width="100"><strong>Pontos</strong></td>
       
    </tr>
   	<tr><td colspan="2" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
    <?php
	$aba = request("aba");
	
	
	$sql = "SELECT DS_NOME_CASO, NR_SEQ_CADASTRO_CASO
			from cadastros
			  order by DS_NOME_CASO";

	$st = mysql_query($sql);
	
	//echo $sql;
	//exit();
	
	if (mysql_num_rows($st) > 0) {
		$vtot = 0;
		while($row = mysql_fetch_row($st)) {
			$ds_nome   = $row[0];
			$nr_cad	   = $row[1];
			
			$sql2 =  "Select sum(NR_QTDE_PORC)
			from pontos
			WHERE ST_PONTOS_PORC = 'E' and
				NR_SEQ_CADASTRO_PORC = '$nr_cad' ";
			
			$st2 = mysql_query($sql2);
			
			if (mysql_num_rows($st2) > 0){
				while ($row = mysql_fetch_row($st2)){
					$ponts = $row[0];
			if ($ponts != 0) {			
					$vtot += $ponts;
					?>
			<tr>
				<td align="left"><?php echo $ds_nome; ?></td>
				<td align="left"><?php echo $ponts; ?></td>
			</tr>
			<?
            }
				}
			}
			
		}
		?>
        	<tr><td colspan="2" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
       		<tr>
				<td align="left"><strong>Total Pontos</strong></td>
				<td align="left"><strong><?php echo $vtot; ?></strong></td>
			</tr>
        <?php
	}

?>
    <tr><td colspan="2" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
</body>
</html>
