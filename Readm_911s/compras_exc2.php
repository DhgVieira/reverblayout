<?php
include 'auth.php';
include 'lib.php';

$iditem = request("iditem");
$idc = request("idc");
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
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<input name="idc" type="hidden" value="<?php echo $idc; ?>" />
<table width="615" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8">Excluíndo item da Compra <span class="style1">NR <?php echo $idc; ?></span></strong></td>
  </tr>
  <tr>
    <td>
    	<table height="30" cellspacing="0" cellpadding="0" width="615" border="0">
        <tr bgcolor="#EEEEEE">
          <td bgcolor="#CACCE8" class="style1">IMG</td>
          <td bgcolor="#CACCE8" class="style1">Poduto</td>
          <td bgcolor="#CACCE8" class="style1">Ref.</td>
          <td bgcolor="#CACCE8" class="style1"><div align="center">Size</div></td>
          <td bgcolor="#CACCE8" class="style1"><div align="center">Valor Unit.</div></td>
          <td bgcolor="#CACCE8" class="style1"><div align="center">Valor Total</div></td>
          <td bgcolor="#CACCE8" class="style1"><div align="center">Qtd.</div></td>
          <td bgcolor="#CACCE8" class="style1">&nbsp;</td>
        </tr>
        <?php
        $sql = "SELECT DS_PRODUTO2_PRRC, DS_REFERENCIA_PRRC, DS_TAMANHO_TARC, VL_PRODUTO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO,
                DS_EXT_PRRC FROM cestas, produtos, tamanhos
				WHERE NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC AND
                NR_SEQ_CESTA_CESO = $iditem";
		$st = mysql_query($sql);
		
		$vl_geral = 0;
		$ct_total = 0;
			
		if (mysql_num_rows($st) > 0) {
			$x = 0;
			$bg = "#FFFFFF";
			$row = mysql_fetch_row($st);
			$vl_total = 0;
			
			$ds_prod	   = $row[0];
			$ds_refe	   = $row[1];
			$ds_tama	   = $row[2];
			$vl_prod	   = $row[3];
			$qt_prod	   = $row[4];
			$id_prod	   = $row[5];
			$ex_prod	   = $row[6];

			$vl_total += ($vl_prod*$qt_prod);
			$vl_geral += $vl_total;
			$ct_total += $qt_prod;
			
			if ($x == 0) {
				$bg = "#FFFFFF";
				$x = 1;
			}else{
				$bg = "#EEEEEE";
				$x = 0;
			}				
			?>
            <form action="compras_exc.php" method="post">
            <input type="hidden" value="<?php echo $idc; ?>" name="idc" />
            <input type="hidden" value="<?php echo $iditem; ?>" name="iditem" />
            <tr>
                <td colspan="8" height="30"><strong>VOLTAR ITEM AO ESTOQUE?</strong> (clique no X novamente para excluir o item da compra)</td>
            </tr>
            <tr>
                <td colspan="8" bgcolor="#EEEEEE" align="left" height="40">
                    <input type="radio" name="exce" value="S" checked="checked" /><strong>SIM</strong>
                    &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="exce" value="N" /><strong>NÃO</strong>
                </td>
            </tr>
            <tr>
                <td colspan="8" bgcolor="#CACCE8"><strong>Caso o produto não seja retornado ao estoque, informe o motivo:</strong></td>
              </tr>
              <tr>
                <td colspan="8" height="80" bgcolor="#EBEBEB" align="center">
                	<textarea name="motivo" cols="50" rows="7" class="frm_pesq" style="width:350px;"></textarea>
                </td>
              </tr>
            <tr bgcolor="<?php echo $bg; ?>">
              <td height="80" align="center">
              		<?php if ($ex_prod == "swf") {?>
                      <object data="../arquivos/uploads/produtos/<?php echo $id_prod ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="65" height="75">
                        <param name="quality" value="high" />
                        <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                        <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" />
                        <param name="wmode" value="opaque" />
                      </object>
                    <?php }else{ ?>
                    <img src="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" width="65" height="75" />
                    <?php } ?>
              </td>
              <td align="left"><?php echo $ds_prod; ?></td>
              <td align="left"><?php echo $ds_refe; ?></td>
              <td align="center"><?php echo $ds_tama; ?></td>
              <td align="center">R$ <?php echo number_format($vl_prod,2,",","."); ?></td>
              <td align="center">R$ <?php echo number_format($vl_total,2,",","."); ?></td>
              <td align="center"><?php echo $qt_prod ?></td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" height="50" align="center"><input type="submit" value="Confirmar Exclusao do Item" /></td>
            </tr>
            </form>
		<?php
	 }
     ?>
   </table>
   </td></tr>
</table>
</form>
</body>
</html>

