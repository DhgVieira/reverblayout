<?php
include 'auth.php';
include 'lib.php';
$idc = request("idc");

$sql = "select NR_FORMA_PGTO_CORC, VL_CONTA_CORC from contas where NR_SEQ_CONTA_CORC = $idc";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
    $forma = $row[0];
    $valor = $row[1];
}
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
<form action="contas_baixa2.php" method="post">
<input name="idc" type="hidden" value="<?php echo $idc; ?>" />
<table width="290" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8"><strong>Pago em:</strong></td>
    <td><input type="text" class="frm_pesq" name="dta_pgto" style="width:130px;" value="<?php echo date("d/m/Y");?>" /></td>
  </tr>
  <tr>
    <td bgcolor="#CACCE8"><strong>Forma de Pgto.:</strong></td>
    <td>
        <select name="forma">
        	<option value="1"<?php if ($forma == 1) echo " selected"; ?>>Boleto</option>
            <option value="2"<?php if ($forma == 2) echo " selected"; ?>>Cheque</option>
            <option value="3"<?php if ($forma == 3) echo " selected"; ?>>Dinheiro</option>
            <option value="4"<?php if ($forma == 4) echo " selected"; ?>>Cartão Visa</option>
            <option value="5"<?php if ($forma == 5) echo " selected"; ?>>Cartão Master</option>
            <option value="6"<?php if ($forma == 6) echo " selected"; ?>>Transferência</option>
            <option value="7"<?php if ($forma == 7) echo " selected"; ?>>Depósito Cheque</option>
            <option value="8"<?php if ($forma == 8) echo " selected"; ?>>Depósito Dinheiro</option>
            <option value="9"<?php if ($forma == 9) echo " selected"; ?>>Débito Automático</option>
        </select>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CACCE8"><strong>Valor:</strong></td>
    <td><input type="text" class="frm_pesq" name="valor" style="width:80px;" value="<?php echo number_format($valor,2,",","");?>" /></td>
  </tr>
  <tr>
    <td bgcolor="#CACCE8"><strong>Conta Movimento:</strong></td>
    <td><select name="conta" style="width:130px;">
        <option value="1">Banco do Brasil</option>
        <option value="2">Santander</option>
        <option value="3">Conta Física</option>
    </select></td>
  </tr>
  <tr>
    <td bgcolor="#EBEBEB" align="center" colspan="2">
    	<input type="submit" value="Dar Baixa" class="frm_pesq" style="width:130px;" />
    </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
mysql_close($con);
?>