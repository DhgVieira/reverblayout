<?php
include 'auth.php';
include 'lib.php';

$idc     = request("idc");
$celular = request("celular");
$msg     = request("msg");
$enviar     = request("enviar");

if (substr($celular,0,1) == "0"){
    $celular = substr($celular,1,strlen($celular));
}

if ($enviar == "S") EnviaSMS($SS_logadm,$idc,$celular,$msg);
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
</head>
<body>
<table width="390" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8">&nbsp;</td>
  </tr>
  <tr>
    <td height="80" bgcolor="#EBEBEB" align="center">
    	<strong>SMS Enviado para <?php echo $celular ?></strong>
    </td>
  </tr>
  <tr>
    <td bgcolor="#EBEBEB" align="center">
    	&nbsp;
    </td>
  </tr>
</table>
</body>
</html>