<?php
include 'auth.php';
include 'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerar boleto</title>
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
$sql = "SELECT VL_TOTAL_COSO, NR_SEQ_CADASTRO_COSO FROM compras
		WHERE NR_SEQ_COMPRA_COSO = $idc";
$st = mysql_query($sql);
$row = mysql_fetch_row($st);

$sql = "SELECT DS_NOME_CASO, DS_CPFCNPJ_CASO, DS_EMAIL_CASO FROM cadastros
		WHERE NR_SEQ_CADASTRO_CASO = '". $row[1] ."'";
$st = mysql_query($sql);
$rowUser = mysql_fetch_row($st);

require '../library/Reverb/Library/pagarme/Pagarme.php';
Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

if($row[0]){
	date_default_timezone_set('America/Sao_Paulo');

	$valor_final = number_format((float) $row[0], 2, '', '');
	$vencimentoBoleto = date(DATE_ISO8601, strtotime("+3 days"));
    //$vencimentoBoleto = '2015-02-15T15:15:49-0200';
    //var_dump($vencimentoBoleto);
	$transaction = new PagarMe_Transaction(array(
        'payment_method' => 'boleto',
        'amount' => $valor_final,
        //'postback_url' => 'http://requestb.in/143jb281',
        'postback_url' => 'https://www.reverbcity.com/checkout2/status-boleto',
        'boleto_expiration_date' => $vencimentoBoleto,
        'customer' => array(
            'name' => $rowUser[0],
            'document_number' => $rowUser[1],
            'email' => $rowUser[2]
        ),
        'metadata' => array('id_pedido' => $idc)
    ));

    try{
        $transaction->charge();
        $tid = $transaction->id;
        $urlBoleto = $transaction->getBoletoUrl();

        $sql = "UPDATE compras SET DS_TID_COSO = '".$tid."' WHERE NR_SEQ_COMPRA_COSO = '".$idc."'";
        mysql_query($sql);
    } catch (Exception $ex) {
        die($ex->getMessage());
    }

}else{
	
}
mysql_close($con); ?>
<a href="<?php echo $urlBoleto ?>" target="_blank">Gerar</a>
</div>
</body>
</html>