<?php
include '../Readm_911s/lib.php';
$compra = request("compra");
echo '@'.$compra.'#<br>';

$sql = "SELECT DT_COMPRA_COSO, DT_STATUS_COSO, DS_IP_COSO, VL_TOTAL_COSO, ST_COMPRA_COSO, DS_FORMAPGTO_COSO, DS_OBS_COSO, DS_LOGIN_CASO, DS_NOME_CASO,
		DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO, DS_EMAIL_CASO, DT_NASCIMENTO_CASO,
		DS_CPFCNPJ_CASO, DS_DDDFONE_CASO, DS_FONE_CASO, DS_DDDCEL_CASO, DS_CELULAR_CASO, DT_CADASTRO_CASO, VL_FRETE_COSO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO,
		TP_CADASTRO_CACH FROM compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO = $compra";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	foreach($row as $rr){echo $rr.'<br>';}
	
	$dt_compra	   = $row[0];
	$dt_status	   = $row[1];
	$ip_compra	   = $row[2];
	$valor		   = $row[3];
	$st_compra	   = $row[4];
	$forma_pgto	   = $row[5];
	$obs_compra	   = $row[6];
	
	$login		   = $row[7];
	$nome		   = $row[8];
	$endereco	   = $row[9];
	$numero		   = $row[10];
	$complem	   = $row[11];
	$bairro		   = $row[12];
	$cidade		   = $row[13];
	$estado		   = $row[14];
	$cep		   = $row[15];
	$email		   = $row[16];
	$dt_nasc	   = $row[17];
	$documento	   = $row[18];
	$dddfone	   = $row[19];
	$fone		   = $row[20];
	$dddcel		   = $row[21];
	$celular	   = $row[22];
	$dt_cadastro   = $row[23];
	
	$frete		   = $row[24];
	
	$nrseqcad	   = $row[25];
	$parcelas	   = $row[26];
	$tipocli	   = $row[27];
		
	switch ($st_compra) {
		case "A":
			$st_compra = "Em Aberto";
			break;
		case "F":
			$st_compra = "Finalizada";
			break;
		case "C":
			$st_compra = "Cancelada";
			break;
	}
}

$refTran = "1500893";
$nr_pedido = $compra;
				/*$totdig = strlen($nr_pedido);
				$meio = "";
				for ($f=0;$f<10-$totdig;$f++){
					$meio .= "0";
				}
				$refTran .= $meio.$nr_pedido;
				
				$valor = number_format($total_fim,2,"","");
				$vlTran = "";
				$totdigv = strlen($valor);
				$meio = "";
				for ($f=0;$f<15-$totdigv;$f++){
					$meio .= "0";
				}
				$vlTran .= $meio.$valor;
				
				$t=time();
				$numOfDays = 3;
				$offSet = 86400 * $numOfDays;
				$t += $offSet;*/
				$strvisa = "<form action=\"http://www21.bb.com.br/portalbb/boletoCobranca/HC21,2,10343.bbx\" method=\"post\" name=\"pagamento\">\n";
				$strvisa .= "      <input type=\"hidden\" name=\"lnDigtvlCampo1\" value=\"$compra\" />\n";
				 /*$strvisa .= "      <input type=\"hidden\" name=\"idConv\" value=\"303990\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"refTran\" value=\"$refTran\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"valor\" value=\"$vlTran\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"dtVenc\" value=\"".date("dmY",$t)."\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"tpPagamento\" value=\"2\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"urlRetorno\" value=\"/\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"urlInforma\" value=\"RecBol.aspx\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"nome\" value=\"$nome\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"endereco\" value=\"$endereco, $numero\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"cidade\" value=\"$cidade\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"uf\" value=\"$estado\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"cep\" value=\"$cep\" />\n";
				$strvisa .= "      <input type=\"hidden\" name=\"msgLoja\" value=\"Voce fez uma reverb-compra\" />\n"; */
				$strvisa .= "      <button type=\"button\" class=\"btlaranja\" style=\"width: 250px\" onClick=\"submit();return false;\">GERAR BOLETO</button>\n";
				$strvisa .= "    </form>";
?>
<table width="700" border="0" cellpadding="3" cellspacing="0" style="margin: 10px 0 10px 0">
          		<tr>
                	<td align="right"><?php echo $strvisa; ?></td>
                </tr>
          </table>