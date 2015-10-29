<?php
include 'auth.php';
include 'lib.php';
$idc = request("idcli");
$sql = "SELECT DS_OBS_CACH FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $idc";
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
<title>Enviando SMS</title>
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
<script type="text/javascript" language="javascript">
function cont(){
var msg = document.getElementById('msg');
var cont = document.getElementById('contador');
cont.value = 900-msg.value.length;
var limite = 0;
if ((900-msg.value.length) <= limite) {
 		msg.value = msg.value.substring(0, 900);
 	}
}
</script>
</head>
<body>
<form action="clientes_obs2.php" method="post">
<input name="idc" type="hidden" value="<?php echo $idc; ?>" />
<table width="390" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8"><strong>Observa&ccedil;&atilde;o no Cadastro do Cliente</strong></td>
  </tr>
  <tr>
    <td height="80" bgcolor="#EBEBEB" align="center">
    	<textarea name="msg" id="msg" cols="50" rows="5" class="frm_pesq" style="width:350px;" onKeyUp="javascript:cont();"><?php echo $obs ?></textarea>
    </td>
  </tr>
  <tr>
    <td>Caracteres restantes: <input name="contador" id="contador" type="text" value="900" size="6" class="input-cycle" style="width:30px;" /></td>
  </tr>
  <tr>
    <td bgcolor="#EBEBEB" align="center">
    	<input type="submit" value="Alterar/Inserir" class="frm_pesq" style="width:130px;" />
    </td>
  </tr>
</table>
</form>
</body>
</html>