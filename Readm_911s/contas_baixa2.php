<?php
include 'auth.php';
include 'lib.php';

$idc 		= request("idc");
$data 		= request("dta_pgto");
$forma   	= request("forma");
$valor      = request("valor");
$conta   	= request("conta");

if (!$valor) $valor = 0;
$valor = str_replace(",",".",$valor);

$str = "update contas SET VL_PAGO_CORC = $valor, DS_CONTAMOVIMENTO_CORC = '$conta', ST_CONTA_CORC = 'B',
     DT_PGTO_CORC = sysdate(), NR_FORMA_PGTO_CORC = $forma WHERE NR_SEQ_CONTA_CORC = $idc";
$st = mysql_query($str);
        
GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deu baixa na conta $idc");

mysql_close($con);
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<title>Fechando</title>
   <script type="text/javascript">
        setTimeout("self.parent.linha_baixada(\"linha<?php echo $idc; ?>\");",100);
        setTimeout("self.parent.tb_remove();",200);
   </script>
</head>
<body>
</body>
</html>