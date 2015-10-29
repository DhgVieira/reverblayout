<?php
include 'auth.php';
include 'lib.php';
$idc = request("idcli");
$msg = request("msg");
$sql = "SELECT DS_NOME_CASO, DS_DDDCEL_CASO, DS_CELULAR_CASO, ST_ENVIOSMS_CACH FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $idc";
$st = mysql_query($sql);
$obs = "";
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $cliente = $row[0];
    $celddd = $row[1];
    $celular = $row[2];
    $enviar = $row[3];
}

$celddd = str_replace("(", "", $celddd);
$celddd = str_replace(")", "", $celddd);
$celddd = str_replace(" ", "", $celddd);

$celular = str_replace("-", "", $celular);
$celular = str_replace(".", "", $celular);
$celular = str_replace("/", "", $celular);
$celular = str_replace("=", "", $celular);
$celular = str_replace(" ", "", $celular);

$celularcomp = $celddd . $celular;

if (substr($celularcomp, 0, 1) == "0") {
    $celularcomp = substr($celularcomp, 1, strlen($celularcomp));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Enviando SMS</title>
        <link href="css/estilos.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <form action="envia_sms2.php" method="post">
            <input name="idc" type="hidden" value="<?php echo $idc; ?>" />
            <input name="enviar" type="hidden" value="<?php echo $enviar; ?>" />
            <input name="celular" type="hidden" value="<?php echo $celularcomp; ?>" />
            <table width="390" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
                <tr>
                    <td bgcolor="#CACCE8">Enviando SMS para: <strong><?php echo $cliente; ?> <?php echo $celularcomp; ?></strong></td>
                </tr>
                <tr>
                    <td height="80" bgcolor="#EBEBEB" align="center">
                        <textarea name="msg" id="msg" cols="50" rows="5" class="frm_pesq" style="width:350px;" onKeyUp="javascript:cont();"><?php echo utf8_encode($msg) ?></textarea>
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
        <script type="text/javascript" language="javascript">
            function cont() {
                var msg = document.getElementById('msg');
                var cont = document.getElementById('contador');
                cont.value = 140 - msg.value.length;
                var limite = 0;
                if ((140 - msg.value.length) <= limite) {
                    msg.value = msg.value.substring(0, 140);
                }
            }
        </script>
    </body>
</html>