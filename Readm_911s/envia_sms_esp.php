<?php
include 'auth.php';
include 'lib.php';

$msg = request("msg");
$celular = request("celular");
$tiralista = request("tiralista");

$celular = str_replace("(","",$celular);
$celular = str_replace(")","",$celular);
$celular = str_replace("-","",$celular);
$celular = str_replace(".","",$celular);
$celular = str_replace("/","",$celular);
$celular = str_replace("=","",$celular);
$celular = str_replace(" ","",$celular);

$celularcomp = $celular;                      
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
cont.value = 140-msg.value.length;
var limite = 0;
if ((140-msg.value.length) <= limite) {
 		msg.value = msg.value.substring(0, 140);
 	}
}
</script>
</head>
<body>
<form action="envia_sms_esp2.php" method="post">
<input name="tiralista" type="hidden" value="<?php echo $tiralista; ?>" />
<input name="celular" type="hidden" value="<?php echo $celularcomp; ?>" />
<table width="390" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8">Enviando SMS para: <strong><?php echo $cliente; ?> <?php echo $celularcomp; ?></strong></td>
  </tr>
  <tr>
    <td height="80" bgcolor="#EBEBEB" align="center">
    	<textarea name="msg" id="msg" cols="50" rows="5" class="frm_pesq" style="width:350px;" onKeyUp="javascript:cont();"><?php echo $msg ?></textarea>
    </td>
  </tr>
  <tr>
    <td>Caracteres restantes: <input name="contador" id="contador" type="text" value="140" size="6" class="input-cycle" style="width:30px;" /></td>
  </tr>
  <tr>
    <td bgcolor="#EBEBEB" align="center">
    	<input type="submit" value="Enviar SMS" class="frm_pesq" style="width:130px;" />
    </td>
  </tr>
</table>
</form>
</body>
</html>
<?php mysql_close($con);?>