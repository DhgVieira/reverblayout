<?php
include 'lib.php';

$subject = "Atualização no status de envio de sua ReverbCompra!";
$bccParceiro = "system_3b0d831f35737@inbound.trustedcompany.com";

$sqlnf = "SELECT ST_COMPRA_COSO, DS_RASTREAMENTO_COSO, DS_NOME_CASO, DS_EMAIL_CASO, NR_SEQ_COMPRA_COSO
from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO 
AND ST_COMPRA_COSO = 'V' ORDER BY DT_COMPRA_COSO";
$stnf = mysql_query($sqlnf);


if (mysql_num_rows($stnf) > 0) {
    $x = 0;
    $result = "";
    while ($rownf = mysql_fetch_row($stnf)) {
        $stcompra = $rownf[0];
        $codrast = $rownf[1];
        $nome = $rownf[2];
        $emaildest = $rownf[3];
        $nrcompra = $rownf[4];

        $tembr = strpos($codrast, "BR");

        if ($codrast && $tembr > 0) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://websro.correios.com.br/sro_bin/txect01$.QueryList');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'P_ITEMCODE=&P_LINGUA=001&P_TESTE=&P_TIPO=001&P_COD_UNI=' . $codrast);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $content = curl_exec($ch);

            curl_close($ch);

            $lines = explode("\n", $content);


            $get = false;

            $data = "";
            $local = "";
            $status = "";
            $registro = "";

            $temenvio = false;

            // $con2 = mysql_connect("reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com","reverb","reverbserver2014") or die("Conex�o Falhou!");
            // mysql_select_db("reverb_amazon",$con) or die("Database Inv�lido");

            foreach ($lines as $line) {
                $linhaorig = $line;
                if (strpos($line, '<table  border cellpadding=1 hspace=10>') !== false) {
                    $get = true;
                }
                if ($get) {
                    $line = str_replace("</td><td>", "|", $line);
                    $line = str_replace("</td><tr>", "|", $line);
                    $line = trim(strip_tags($line));
                    $line = str_replace("\n", "", $line);
                    $line = str_replace("\r", "", $line);
                    $line = str_replace("  ", "", $line);

                    $posicao = explode("|", $line);


                    $local = "";
                    $status = "";

                    if (count($posicao) > 0) {

                        if (count($posicao) == 3) {
                            $splitdados1 = explode("|", $line);
                            $data = $splitdados1[0];
                            $local = $splitdados1[1];
                            $status = $splitdados1[2];


                            $sdatamy = explode("/", str_replace(" " . substr($data, 11, 5), "", $data));
                            $datamy = $sdatamy[2] . "-" . $sdatamy[1] . "-" . $sdatamy[0] . " " . substr($data, 11, 5);

                            if ($status == "Entrega Efetuada") {
                                $str = "UPDATE compras SET ST_COMPRA_COSO = 'E', DT_STATUS_COSO = sysdate(), ST_NOVOPGTO_COSO = null WHERE NR_SEQ_COMPRA_COSO = $nrcompra";
                                $st = mysql_query($str);
                                $str = "INSERT INTO controle_rast (NR_SEQ_COMPRA_CRRC, DT_REGISTRO_CRRC, DS_REGISTRO_CRRC,
									DS_STATUS_CRRC, ST_ENVIO_CRRC) VALUES ($nrcompra, '$datamy', '$local', '$status', 'S')";
                                $st = mysql_query($str);

                                $corpo = '<table align="center"><tr><td>
								<table width="600" border="0" cellpadding="0" cellspacing="0">
								<tr><td colspan="2" height="4"><img src="http://www.reverbcity.com/imgrast/line1.gif" width="600" height="4" /></td></tr>
								<tr>
								<td align="left" height="75"><a href="http://www.reverbcity.com"><img border="0" src="http://www.reverbcity.com/imgrast/logo.gif" width="235" height="75" /></a></td>
								<td align="right" height="75">
								<table width="150" cellpadding="0" cellspacing="0" height="25" border="0">
								<tr>
								<td><a href="http://www.reverbcity.com/rss/rss.php"><img border="0" src="http://www.reverbcity.com/imgrast/rss.gif" width="26" height="25" /></a></td>
								<td><a href="https://www.facebook.com/Reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/fb.gif" width="26" height="25" /></a></td>
								<td><a href="https://twitter.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/twi.gif" width="26" height="25" /></a></td>
								<td><a href="http://pinterest.com/reverbcity/pins/"><img border="0" src="http://www.reverbcity.com/imgrast/pin.gif" width="26" height="25" /></a></td>
								</tr>
								</table>
								</td>
								</tr>
								<tr><td colspan="2" height="5"><img src="http://www.reverbcity.com/imgrast/line2.gif" width="600" height="5" /></td></tr>
								</table>
								<table border="0" cellpadding="0" cellspacing="0">
								<tr><td><img src="http://www.reverbcity.com/imgrast/chamada.gif" width="599" height="44" /></td></tr>
								<tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
								</table>
								<div style="font-family:Verdana;font-size:11px;color: #646464; padding: 0 25px 25px 25px; width: 550px;">
								Pronto para o Rock and Roll, <strong>' . utf8_encode($nome) . '</strong>?
								<br /><br />
								A turnê da sua camiseta saiu daqui da Reverbcity e <strong>chegou em sua casa</strong>! Última atualização fornecida pelos Correios:
								<br /><br />
								Pedido número: <strong>' . $nrcompra . '</strong>
								</div>    
								<div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
								' . $data . ' - ' . utf8_encode($local) . ' - ' . utf8_encode($status) . '
								</div>
								<a href="mailto:compras@reverbcity.com"><img src="http://www.reverbcity.com/imgrast/rodape.gif" width="598" height="212" border="0" /></a>
								</td></tr></table>';
                                EnviaMailer("atendimento@reverbcity.com", "Reverbcity", $emaildest, $nome, "", $subject, $corpo, $bccParceiro);
                                $x++;

                                $temenvio = false;
                                $get = false;
                                break;
                            } else {
                                $sql1 = "SELECT ST_ENVIO_CRRC FROM controle_rast WHERE NR_SEQ_COMPRA_CRRC = $nrcompra AND
								DT_REGISTRO_CRRC = '$datamy'";
                                $st1 = mysql_query($sql1);
                                if (mysql_num_rows($st1) <= 0) {
                                    $str = "INSERT INTO controle_rast (NR_SEQ_COMPRA_CRRC, DT_REGISTRO_CRRC, DS_REGISTRO_CRRC,
										DS_STATUS_CRRC, ST_ENVIO_CRRC) VALUES ($nrcompra, '$datamy', '$local', '$status', 'S')";
                                    $st = mysql_query($str);
                                    $temenvio = true;
                                    $registro .= $data . " - " . $local . " - " . $status . "<br />";
                                }
                            }
                        } else {
                            if (strpos($linhaorig, "colspan") > 0) {

                                // $con3 = mysql_connect("reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com","reverb","reverbserver2014") or die("Conex�o Falhou!");
                                // mysql_select_db("reverb_amazon",$con) or die("Database Inv�lido");

                                $sql1 = "SELECT ST_ENVIO_CRRC FROM controle_rast WHERE NR_SEQ_COMPRA_CRRC = $nrcompra AND
							DT_REGISTRO_CRRC = '$datamy' and DS_REGISTRO_CRRC = '$line'";
                                $st1 = mysql_query($sql1);
                                if (mysql_num_rows($st1) <= 0) {
                                    $str = "INSERT INTO controle_rast (NR_SEQ_COMPRA_CRRC, DT_REGISTRO_CRRC, DS_REGISTRO_CRRC,
									ST_ENVIO_CRRC) VALUES ($nrcompra, '$datamy', '$line', 'S')";
                                    $st = mysql_query($str);
                                    $temenvio = true;
                                    $registro .= "$data - " . $line . "<br />";
                                }
                            }
                        }
                    }

                    if (strpos($line, '</TABLE>') !== false) {
                        $get = false;
                        break;
                    }
                }


            }

            if ($temenvio) {
                $corpo = '<table align="center"><tr><td>
	<table width="600" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan="2" height="4"><img src="http://www.reverbcity.com/imgrast/line1.gif" width="600" height="4" /></td></tr>
	<tr>
	<td align="left" height="75"><a href="http://www.reverbcity.com"><img border="0" src="http://www.reverbcity.com/imgrast/logo.gif" width="235" height="75" /></a></td>
	<td align="right" height="75">
	<table width="150" cellpadding="0" cellspacing="0" height="25" border="0">
	<tr>
	<td><a href="http://www.reverbcity.com/rss/rss.php"><img border="0" src="http://www.reverbcity.com/imgrast/rss.gif" width="26" height="25" /></a></td>
	<td><a href="https://www.facebook.com/Reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/fb.gif" width="26" height="25" /></a></td>
	<td><a href="https://twitter.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/twi.gif" width="26" height="25" /></a></td>
	<td><a href="http://pinterest.com/reverbcity/pins/"><img border="0" src="http://www.reverbcity.com/imgrast/pin.gif" width="26" height="25" /></a></td>
	</tr>
	</table>
	</td>
	</tr>
	<tr><td colspan="2" height="5"><img src="http://www.reverbcity.com/imgrast/line2.gif" width="600" height="5" /></td></tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr><td><img src="http://www.reverbcity.com/imgrast/chamada.gif" width="599" height="44" /></td></tr>
	<tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
	</table>
	<div style="font-family:Verdana;font-size:11px;color: #646464; padding: 0 25px 25px 25px; width: 550px;">
	Pronto para o Rock and Roll, <strong>' . utf8_encode($nome) . '</strong>?
	<br /><br />
	A turnê da sua camiseta saiu daqui da Reverbcity e em breve se apresentará em sua casa. Acompanhe por onde ela tem passado através dos dados fornecidos pelos Correios:
	<br /><br />
	Pedido número: <strong>' . $nrcompra . '</strong>
	</div>    
	<div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
	' . utf8_encode($registro) . '
	</div>
	<a href="mailto:compras@reverbcity.com"><img src="http://www.reverbcity.com/imgrast/rodape.gif" width="598" height="212" border="0" /></a>
	</td></tr></table>';

                EnviaMailer("atendimento@reverbcity.com", "Reverbcity", $emaildest, $nome, "", $subject, $corpo);
                $x++;
            }
        }
    }
}
mysql_close($con);
?>