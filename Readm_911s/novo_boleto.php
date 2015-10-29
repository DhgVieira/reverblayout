<?php
include 'auth.php';
include 'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>2a via Boleto</title>
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
.fonte1 {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#000000
}
-->
</style>
</head>
<body>    	
<div id="Criar">
<?php
$idc = request("idc");
$sql = "SELECT DS_TID_COSO FROM compras
		WHERE NR_SEQ_COMPRA_COSO = $idc";
$st = mysql_query($sql);

require '../library/Reverb/Library/pagarme/Pagarme.php';
Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

$row = mysql_fetch_row($st);
if($row[0]){
	$transaction = PagarMe_Transaction::findById($row[0]);
	$urlBoleto = $transaction->getBoletoUrl();
}else{
	
}
mysql_close($con); ?>
<a href="<?php echo $urlBoleto ?>" target="_blank">Gerar</a>
</div>
</body>
</html>