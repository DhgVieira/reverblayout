<?php
if ($SS_logadm){
    $sqll = "select ST_STATUS_USRC, NR_SEQ_FUNC_USRC from usuarios WHERE NR_SEQ_USUARIO_USRC  = $SS_logadm";
    $stl = mysql_query($sqll);
    $nrfunc = 0;
    if (mysql_num_rows($stl) > 0) {
      	$rowl = mysql_fetch_row($stl);
        $stlog = $rowl[0];
        $nrfunc = $rowl[1];
        if ($stlog != 'A'){
            $_SESSION["SS_sessao"] = "";
            $_SESSION["SS_logadm"] = "";
            $_SESSION["SS_login"] = "";
            $_SESSION["SS_acesso"] = "";
            $_SESSION["SS_nivel"] = "";
            $_SESSION["SS_loja"] = "";
            
            setcookie("ck_sessao", "", time() - 3600, "/");
            setcookie("ck_logadm", "", time() - 3600, "/");
            setcookie("ck_login", "", time() - 3600, "/");
            setcookie("ck_nivel", "", time() - 3600, "/");
            setcookie("ck_acesso", "", time() - 3600, "/");
            setcookie("ck_loja", "", time() - 3600, "/");
            
            Header("Location: login.php");
            exit();
        }
    }
}

// $sqlf = "select NR_SEQ_FUNCIONARIO_JUPO from funcionarios_ponto_just where NR_SEQ_FUNCIONARIO_JUPO = $nrfunc and ST_JUSTIFICADO_JUPO = 'N'";
// $stf = mysql_query($sqlf);
// if (mysql_num_rows($stf) > 0) {
//     $_SESSION["SS_nrfunc"] = $nrfunc;
//     Header("Location: ponto_justifica.php");
//     exit();
// }

// $diasemana = date("w");
// $campo = "";

// switch($diasemana){
//     case 0:
//         $campo = "NR_HORAS_DOM_FURC";
//         break;
//     case 1:
//         $campo = "NR_HORAS_SEG_FURC";
//         break;
//     case 2:
//         $campo = "NR_HORAS_TER_FURC";
//         break;
//     case 3:
//         $campo = "NR_HORAS_QUA_FURC";
//         break;
//     case 4:
//         $campo = "NR_HORAS_QUI_FURC";
//         break;
//     case 5:
//         $campo = "NR_HORAS_SEX_FURC";
//         break;
//     case 6:
//         $campo = "NR_HORAS_SAB_FURC";
//         break;
// }

// $sqlf = "select $campo, HR_ENTRADA1_FURC, HR_SAIDA2_FURC from funcionarios where NR_SEQ_FUNCIONARIO_FURC = $nrfunc";
// $stf = mysql_query($sqlf);
// if (mysql_num_rows($stf) > 0) {
//     $rowhoras = mysql_fetch_row($stf);
    
//     $horasdia = $rowhoras[0];
//     $hentrada = $rowhoras[1];
//     $hsaida = $rowhoras[2];
// }

$sqlsms = "select sum(NR_QTDE_CSRC) from sms_controle";
$stsms = mysql_query($sqlsms);
if (mysql_num_rows($stsms) > 0) {
  	$rowsms = mysql_fetch_row($stsms);
    $saldosms = $rowsms[0];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Reverb City Adm</title>
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
<script type="text/javascript" src="scripts/abas.js"></script>
<link href="css/aba.css" media="all" rel="stylesheet" type="text/css" />

<?php 
mb_internal_encoding("UTF-8");
mb_http_output( "iso-8859-1" );  
ob_start("mb_output_handler");   
header("Content-Type: text/html; charset=ISO-8859-1",true);

?>


<script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="scripts/thickbox-compressed.js"></script>
<script src="scripts/jquery.periodicalupdater.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript">
//$(document).ready(function(){
//   $.PeriodicalUpdater({
//      url : 'renova.php',
//      minTimeout : 120000
//   },
//   function(data){
//      var myHtml = data;
//      $('#userlogado').html(myHtml);
//   });
//})
</script>
</head>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<?php if(empty(request("rvbview"))) : ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#361a0f">
    <td width="820"><img src="img/logo.gif" /></td>
    <td width="40">&nbsp;</td>
    <td style="font-family: Verdana; font-size: 11px; color: #b59589;">
        Usuário: <strong><?php echo $_SESSION["SS_login"];?> <span id="userlogado"><?php echo @$HTTP_COOKIE_VARS["ujr73jfw93"] ?></span></strong><br />
        Último Acesso: <strong><?php echo $_SESSION["SS_acesso"];?></strong><br />
        Saldo SMS: <strong><?php echo $saldosms ?></strong>
    </td>
  </tr>
  <tr>
    <td height="70" colspan="3">
    	<?php include 'menu_princ.php'; ?>
    </td>
  </tr>
  <tr>
  	<td colspan="3">

    <?php endif; ?>