<?php
include 'auth.php';
include 'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerando Boleto</title>
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
$sql = "SELECT DT_COMPRA_COSO, DT_STATUS_COSO, DS_IP_COSO, VL_TOTAL_COSO, ST_COMPRA_COSO, DS_FORMAPGTO_COSO,
        DS_OBS_COSO, DT_VCTOBOLETO_COSO FROM compras
		WHERE NR_SEQ_COMPRA_COSO = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	
	$dt_compra	   = $row[0];
	$dt_status	   = $row[1];
	$ip_compra	   = $row[2];
	$valor		   = $row[3];
	$st_compra	   = $row[4];
	$forma_pgto	   = $row[5];
	$obs_compra	   = $row[6];
    $vcto_boleto   = $row[7];
?>
      <!-- GERAR BOLETO-->                
<?php                
                $data_atual = date("Y-m-d");
                if ($forma_pgto == "boleto") {
					$compra =$idc;
				// DADOS DO BOLETO PARA O SEU CLIENTE
					$dias_de_prazo_para_pagamento = 3;
					
                    if (!$vcto_boleto){
                        $data_venc = date("d/m/Y", strtotime($dt_compra) + ($dias_de_prazo_para_pagamento * 86400));
                    }else{
                        $data_venc = date("d/m/Y", strtotime($vcto_boleto));                  
                    }
                    $valor_cobrado = $valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
					$valor_cobrado = str_replace(",", ".",$valor_cobrado);
					$valor_boleto=number_format($valor_cobrado, 2, ',', '');
					
					$refTran = "1500893";
									$totdig = strlen($compra);
									$meio = "";
									for ($f=0;$f<10-$totdig;$f++){
										$meio .= "0";
									}
									$refTran .= $meio.$compra;
					
					$dadosboleto["nosso_numero"] = $compra;;
					$dadosboleto["numero_documento"] = $refTran;	// Num do pedido ou do documento
					$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
					$dadosboleto["data_documento"] = date("d/m/Y",strtotime($data_atual) ); // Data de emissão do Boleto
					$dadosboleto["data_processamento"] = date("d/m/Y",strtotime($data_atual) ); // Data de processamento do boleto (opcional)
					$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
					
					// DADOS DO SEU CLIENTE
					$dadosboleto["sacado"] = $nome;
					$dadosboleto["endereco1"] = $endereco.', '.$numero;
					$dadosboleto["endereco2"] = $cidade.'-'.$estado.'-'.$cep;
					
					// INFORMACOES PARA O CLIENTE
					$dadosboleto["demonstrativo1"] = "Voce fez uma reverb-compra";
					$dadosboleto["demonstrativo2"] = "";
					$dadosboleto["demonstrativo3"] = "";
					
					// INSTRUÇÕES PARA O CAIXA
					$dadosboleto["instrucoes1"] = "";
					$dadosboleto["instrucoes2"] = "";
					$dadosboleto["instrucoes3"] = "";
					$dadosboleto["instrucoes4"] = "";
					
					// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
					$dadosboleto["quantidade"] = "";
					$dadosboleto["valor_unitario"] = "";
					$dadosboleto["aceite"] = "N";		
					$dadosboleto["especie"] = "R$";
					$dadosboleto["especie_doc"] = "";
					
					
					// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
					
					
					// DADOS DA SUA CONTA - BANCO DO BRASIL
					$dadosboleto["agencia"] = "2755"; // Num da agencia, sem digito
					$dadosboleto["conta"] = "22693"; 	// Num da conta, sem digito
					
					// DADOS PERSONALIZADOS - BANCO DO BRASIL
					$dadosboleto["convenio"] = "1500893";  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
					$dadosboleto["contrato"] = "17944377"; // Num do seu contrato
					$dadosboleto["carteira"] = "18";
					$dadosboleto["variacao_carteira"] = "";  // Variação da Carteira, com traço (opcional)
					
					// TIPO DO BOLETO
					$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
					$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos
					
									
					// SEUS DADOS
					$dadosboleto["identificacao"] = "O pagamento deste boleto tamb&eacute;m poder&aacute; ser efetuado pelo Gerenciador Financeiro, pelo Auto-Atendimento BB
					Internet ou pelos Terminais de Auto-Atendimento.";
					$dadosboleto["cpf_cnpj"] = "08345875/0001-37";
					$dadosboleto["endereco"] = "";
					$dadosboleto["cidade_uf"] = "";
					$dadosboleto["cedente"] = "ANTONIO M. DIAS - CONFECCAO";
					
					// NÃO ALTERAR!
					include("bb/funcoes_bb.php"); 
				?>	

				<table align="center" width="90%" class="textosver">
			    <tr>
                	<td bgcolor="#CACCE8" align="left" ><strong>Instruções para gerar a 2ª via do boleto:</strong> </td>
                </tr>
                <tr>
                	<td bgcolor="#EBEBEB" align="left">
                    <ol>
                    <li>Acesso o site do Banco do Brasil, através do botão <font color="#FF0000"> <strong>"GERAR 2ª VIA"</strong></font>.</li>
                    <li>Informe os campos da linha digital com os dados abaixo: </li><br /> <strong><font color="#FF0000" style="font-size:14px">  <?php echo $dadosboleto["linha_digitavel"]; ?></font></strong> 
                    <br />          <br />
                    <li>Digite os dados da imagem no campo indicado pelo site, e click em  <strong>"Confirmar"</strong>.</li>
                    <li>Em seguida escolha a compra que deseja gerar a 2ª via do boleto e click em  <strong>"Visualizar"</strong>.</li>
                    <li>Depois escolha umas das opções oferecidas no site da pagina do boleto.
                    </ol>
                     </td>
                </tr>
                <tr>
                	<td bgcolor="#EBEBEB" align="center">
                    <?php
                    $refTran = "1500893";
                    $nr_pedido = $idc;
                    
                    $str = "select * from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO = $nr_pedido";
                    $st = mysql_query($str);
                    
                    if (mysql_num_rows($st) > 0) {
                        $row = mysql_fetch_array($st);
                        $total_fim     = $row["VL_TOTAL_COSO"];
                        $nome		   = $row["DS_NOME_CASO"];
                    	$endereco	   = $row["DS_ENDERECO_CASO"];
                    	$numero		   = $row["DS_NUMERO_CASO"];
                    	$cidade		   = $row["DS_CIDADE_CASO"];
                    	$estado		   = $row["DS_UF_CASO"];
                    	$cep		   = $row["DS_CEP_CASO"];
                        $datacompra	   = $row["DT_COMPRA_COSO"];
                    }else{
                        exit();
                    }
                    
                    $data_atual = date("Y-m-d g:i:s");
                    
                    $totdig = strlen($nr_pedido);
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
                    
                    $t=mysql_datetime_para_timestamp($data_atual);
                    $numOfDays = 3;
                    $offSet = 86400 * $numOfDays;
                    $t += $offSet;
                    
                    $strvisa = "<form action=\"https://www16.bancodobrasil.com.br/site/mpag/\" method=\"post\" name=\"pagamento\">\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"idConv\" value=\"303990\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"refTran\" value=\"$refTran\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"valor\" value=\"$vlTran\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"dtVenc\" value=\"".str_replace("/","",$data_venc)."\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"tpPagamento\" value=\"21\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"urlRetorno\" value=\"/\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"urlInforma\" value=\"RecBol.aspx\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"nome\" value=\"$nome\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"endereco\" value=\"$endereco, $numero\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"cidade\" value=\"$cidade\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"uf\" value=\"$estado\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"cep\" value=\"$cep\" />\n";
                    $strvisa .= "      <input type=\"hidden\" name=\"msgLoja\" value=\"Voce fez uma reverb-compra\" />\n";
                    $strvisa .= "      <button type=\"button\" class=\"btlaranja\" style=\"width: 200px\" onClick=\"submit();return false;\">GERAR BOLETO</button>\n";
                    $strvisa .= "    </form>";
                    
                    echo $strvisa;
                    ?>
                    </td>
                </tr>
                </table>
        
     <?php      }  ?>        
  <!-- GERAR BOLETO FIM -->
<?php 
}
?>
</div>
</body>
</html>
<?php 
function mysql_datetime_para_timestamp($dt) { 
    $yr=strval(substr($dt,0,4)); 
    $mo=strval(substr($dt,5,2)); 
    $da=strval(substr($dt,8,2)); 
    $hr=strval(substr($dt,11,2)); 
    $mi=strval(substr($dt,14,2)); 
    $se=strval(substr($dt,17,2)); 
    return mktime($hr,$mi,$se,$mo,$da,$yr); 
} 
mysql_close($con); ?>