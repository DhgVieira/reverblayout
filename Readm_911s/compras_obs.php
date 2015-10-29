<?php
include 'auth.php';
include 'lib.php';
$idc = request("idc");
$sql = "SELECT DS_OBS_COSO FROM compras WHERE NR_SEQ_COMPRA_COSO = $idc";
$st = mysql_query($sql);
$obs = "";
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$obs = $row[0];
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
<form action="compras_obs2.php" method="post">
<input name="idc" type="hidden" value="<?php echo $idc; ?>" />
<table width="615" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8">Inserindo Observação para o pedido: <strong><?php echo $idc; ?></strong></td>
  </tr>
  <tr>
    <td height="80" bgcolor="#EBEBEB" align="center">
    	<textarea name="obs" cols="50" rows="7" class="frm_pesq" style="width:350px;"><?php echo $obs; ?></textarea>
    </td>
  </tr>
  <tr>
    <td bgcolor="#EBEBEB" align="center">
    	<input type="Button" value="Voltar" onClick="document.location.href=('compras_ver.php?idc=<? echo $idc;?>');" class="frm_pesq" style="width:45px;">
        &nbsp;&nbsp;
    	<input type="submit" value="Inserir Oberva&ccedil;&atilde;o" class="frm_pesq" style="width:130px;" />
    </td>
  </tr>
</table>
</form>
</body>
</html>

