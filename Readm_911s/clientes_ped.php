<?php
include 'auth.php';
include 'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalhamento Pedido</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="615" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8"><strong>Histórico de Pedidos do Cliente:</strong></td>
  </tr>
  <tr>
    <td><table height="30" cellspacing="0" cellpadding="0" width="100%" border="0">
      <tr bgcolor="#CACCE8">
        <td width="6%" align="center"><strong>NR</strong></td>
        <td width="22%" height="20" align="middle"><strong>Data</strong></td>
        <td width="14%" align="center"><strong>Qtde</strong></td>
        <td width="14%" align="center"><strong>Forma de Pgto</strong></td>
        <td width="14%" align="center"><strong>Vlr.Total</strong></td>
        <td width="14%" align="center"><strong>Status</strong></td>
      </tr>
      <?php
	    $idcli = request("idc");

		$sql = "SELECT NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DT_STATUS_COSO, VL_TOTAL_COSO, ST_COMPRA_COSO, DS_FORMAPGTO_COSO
				FROM compras WHERE NR_SEQ_CADASTRO_COSO = $idcli order by DT_COMPRA_COSO desc";
		$st = mysql_query($sql);
		
		if (mysql_num_rows($st) > 0) {
			$x = 0;
            $total_g = 0;
			while($row = mysql_fetch_row($st)) {
				$nr_compra	   = $row[0];
				$dt_compra	   = $row[1];
				$dt_status	   = $row[2];
				$valor		   = $row[3];
				$st_compra	   = $row[4];
				$forma_pgto	   = $row[5];
                
                if ($st_compra != 'A' && $st_compra != 'C') $total_g += $valor;
				
				switch ($st_compra) {
					case "A":
						$st_compra = "Em Aberto";
						break;
					case "P":
						$st_compra = "Paga";
						break;
                    case "V":
						$st_compra = "Enviada";
						break;
					case "C":
						$st_compra = "Cancelada";
						break;
				}

				if ($x == 0) {
					$bg = "#FFFFFF";
					$x = 1;
				}else{
					$bg = "#EEEEEE";
					$x = 0;
				}
				
				$cotas = 0;
				$sql2 = "SELECT sum(NR_QTDE_CESO) from cestas where NR_SEQ_COMPRA_CESO = $nr_compra";
				$st2 = mysql_query($sql2);
				if (mysql_num_rows($st2) > 0) {
					$row2 = mysql_fetch_row($st2);
					$cotas = $row2[0];
				}
				if (!$cotas) $cotas = 0;
                
                
				?>
                <tr bgcolor="<?php echo $bg; ?>">
                    <td align="center"><a href="compras_ver.php?idc=<?php echo $nr_compra; ?>"><strong><?php echo $nr_compra; ?></strong></a></td>
                    <td height="20" align="middle"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
                    <td align="center"><?php echo $cotas; ?></td>
                    <td align="center"><?php echo $forma_pgto; ?></td>
                    <td align="center">R$ <?php echo number_format($valor,2,",","."); ?></td>
                    <td align="center"><?php echo $st_compra; ?></td>
                  </tr>
                <?php
			}
		}
		?>
        <tr bgcolor="#CACCE8">
            <td align="center">&nbsp;</td>
            <td height="20" align="middle">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">Total Confirmadas:</td>
            <td align="center"><strong>R$ <?php echo number_format($total_g,2,",","."); ?></strong></td>
            <td align="center">&nbsp;</td>
        </tr>
        <?php
		mysql_close($con);
      ?>
    </table></td>
  </tr>
</table>
</body>
</html>

