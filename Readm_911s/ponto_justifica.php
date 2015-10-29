<?php
include 'auth.php';
include 'lib.php';

$SS_func = (isset($_SESSION["SS_nrfunc"])) ? $_SESSION["SS_nrfunc"] : 0;

$dias_semana = array('Domingo', 'Segunda', 'Ter&ccedil;a','Quarta', 'Quinta', 'Sexta', 'S&aacute;bado');

$sqlf = "select DT_PONTO_JUPO, NR_SEGUNDOS_JUPO from funcionarios_ponto_just where
         NR_SEQ_FUNCIONARIO_JUPO = $SS_func and ST_JUSTIFICADO_JUPO = 'N'
         order by DT_JUSTIFICATIVA_JUPO asc limit 1";
$stf = mysql_query($sqlf);
if (mysql_num_rows($stf) > 0) {
    $rowf = mysql_fetch_row($stf);
    $data = $rowf[0];
    $tempo = $rowf[1];
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
    function Semjustificar(tipoval){
        document.myfrm.tipo.value = tipoval;
        document.myfrm.submit();
    }
</script>

</head>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#361a0f">
    <td width="820"><img src="img/logo.gif" /></td>
    <td width="40">&nbsp;</td>
    <td style="font-family: Verdana; font-size: 11px; color: #b59589;">
        Usu&aacute;rio: <strong><?php echo $_SESSION["SS_login"];?> <span id="userlogado"><?php echo @$HTTP_COOKIE_VARS["ujr73jfw93"] ?></span></strong><br />
        &Uacute;ltimo Acesso: <strong><?php echo $_SESSION["SS_acesso"];?></strong><br />
    </td>
  </tr>
  <tr>
  	<td colspan="3">
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Hora Extra</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Justificativa</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                    
                	<form action="ponto_justifica2.php" method="post" name="myfrm" id="myfrm">
                    <input type="hidden" value="S" name="tipo" id="tipo" />
                    <input type="hidden" value="<?php echo $data; ?>" name="data" id="data" />
                         <fieldset>
                             <ul class="formularios">
                            <table style="width: 340px; margin-left: 100px;">
                                <tr><td colspan="4">
                                    <p>Voc&ecirc; possui na data abaixo um tempo excedente a sua jornada normal de trabalho.</p>
                                    <p>Para continuar utilizando a ADM, justifique este tempo ou clique em "Continuar sem Justificar" para deixar esta data sem justificativa.</p> 
                                </td></tr>
                                <tr><td colspan="4">&nbsp;</td></tr>
                                <tr style="font-size: 14px;">
                                    <td align="left"><strong>Data:</strong></td>
                                    <td align="left"><strong><?php echo date("d/m/Y",strtotime($data)); ?></strong></td>
                                    <td align="left"><strong>Extra:</strong></td>
                                    <td align="left"><strong style="color: blue;"><?php echo sec_to_time($tempo);?></strong></td>
                                </tr>
                                <tr style="font-size: 14px;">
                                    <td align="left" colspan="2"><strong>Dia da Semana:</strong></td>
                                    <td align="left"><strong><?php echo $dias_semana[date("w",strtotime($data))]; ?></strong></td>
                                    <td align="left">&nbsp;</td>
                                </tr>
                                <tr><td colspan="4">&nbsp;</td></tr>
                                <tr>
                                    <td align="left"><strong>Justificativa:</strong></td>
                                    <td align="left" colspan="3"><textarea class="form01" name="just" style="width:340px;height:80px;"></textarea></td>
                                </tr>
                                <tr>
                                    <td align="left">&nbsp;</td>
                                    <td align="left">&nbsp;<!--<input type="button" onclick="Semjustificar('S');" value="Continuar sem Justificar" class="form01" style="width:160px;height:25px; cursor: pointer;" />--></td>
                                    <td align="left">&nbsp;</td>
                                    <td align="right"><input type="button" onclick="Semjustificar('N');" value="Justificar" class="form01" style="width:120px;height:25px; cursor: pointer;" /></td>
                                </tr>
                                <tr><td colspan="4">&nbsp;</td></tr>
                                <tr><td colspan="4">&nbsp;</td></tr>
                            </table>
                             </ul>
                         </fieldset>
                    </form>

                    </div> <!-- /ver -->
                    
                 

                    <script>
					  defineAba("abaVer","Ver");
					  defineAbaAtiva("abaVer");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php
mysql_close($con);
include 'rodape.php'; ?>