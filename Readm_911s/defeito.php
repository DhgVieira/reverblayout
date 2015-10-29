<?php 
include 'auth.php';
include 'lib.php'; 

$idp = request("idp");
$tam = request("tam");
$obs = request("obs");

$sql = "select NR_SEQ_ESTOQUE_ESRC, NR_QTDE_ESRC from estoque where NR_SEQ_PRODUTO_ESRC = $idp and NR_SEQ_TAMANHO_ESRC = $tam";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $idestoque = $row[0];
    $qtestoque = $row[1];
    
    if ($qtestoque == 0){
        $dsacao = "Deixou sem Sold Out";
        $str = "delete from estoque where NR_SEQ_ESTOQUE_ESRC = $idestoque";
        GravaLogEstoque($SS_logadm,$idp,$tam,$dsacao,$obs,0);
    }else{
        $dsacao = "Removeu 1 unidade";
        $str = "update estoque set NR_QTDE_ESRC = NR_QTDE_ESRC - 1 WHERE NR_SEQ_ESTOQUE_ESRC = $idestoque";
        GravaLogEstoque($SS_logadm,$idp,$tam,$dsacao,$obs,-1);
    }

    $st = mysql_query($str);   
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Defeito: Removeu uma unidade tamanho $tam produto $idp");
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

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="scripts/thickbox-compressed.js"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />

</head>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td colspan="3">
        <table class="textostabelas" width="400" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td>
            </tr>
            <tr>
            	<td align="left" height="68" align="center">
                	<table width="99%" bgcolor="#FFFFFF" align="center">
                    	<tr><td colspan="3">&nbsp;</td></tr>
                        <tr>
                        	<td align="center" width="140"><img src="img/logo_button.gif" width="107" height="107" /></td>
                            <td align="right">
                                <p><strong style="font-size: 15px;">PEÇA COM DEFEITO</strong></p>
                                <br />
                                <p style="font-size: 12px;">Removida em <?php echo date("d/m/Y G:i"); ?><br />
                                por: <strong><?php echo $SS_login ?></strong></p>
                            </td>
                            <td align="right" width="40">&nbsp;</td>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="400" /></td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3">
                            <table width="98%" align="center">
                                <tr>
                                    <td valign="top" width="110"><strong>MOTIVO:</strong></td>
                                    <td align="left">
                                    <?php echo $obs ?>
                                    </td>
                                </tr>
                            </table>
                        </td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="400" /></td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3">
                            <table width="98%" align="center">
                                <tr>
                                    <td valign="top" width="210"><strong>POSSIBILIDADE DE CONSERTO?</strong></td>
                                    <td align="left">[&nbsp;&nbsp;&nbsp;] <strong>SIM</strong></td>
                                    <td align="left">[&nbsp;&nbsp;&nbsp;] <strong>NÃO</strong></td>
                                </tr>
                            </table>
                        </td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="400" /></td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3">
                            <table width="98%" align="center">
                                <tr>
                                    <td valign="top" width="210"><strong>TAMANHO:</strong></td>
                                    <td align="left"><strong>
                                    <?php
                                    $sql = "select DS_TAMANHO_TARC, DS_SIGLA_TARC from tamanhos where NR_SEQ_TAMANHO_TARC = $tam";
                                    $st = mysql_query($sql);
                                    if (mysql_num_rows($st) > 0) {
                                        $row = mysql_fetch_row($st);
                                        $dstam = $row[0];
                                        $dssig = $row[1];
                                        echo $dstam."(".$dssig.")";
                                    }
                                    ?>
                                    </strong></td>
                                </tr>
                            </table>
                        </td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3" height="1"><img src="img/xb.gif" height="2" width="400" /></td></tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr><td colspan="3">
                            <table width="98%" align="center">
                                <tr>
                                    <td valign="top" width="150"><strong>USUARIO:</strong></td>
                                    <td align="left"><strong><?php echo $SS_login ?></strong></td>
                                </tr>
                                <tr>
                                    <td width="150" valign="botton" height="160"><strong>ASSINATURA:</strong></td>
                                    <td align="left" valign="botton" height="160">
                                        <img src="img/xb.gif" height="2" width="230" />
                                    </td>
                                </tr>
                            </table>
                        </td></tr>
                    </table>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>