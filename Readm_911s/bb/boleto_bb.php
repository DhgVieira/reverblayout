<?php

include '../Readm_911s/lib.php';
$compra = request("compra");
//echo '@'.$compra.'#<br>';

$sql = "SELECT DT_COMPRA_COSO, DS_IP_COSO, VL_TOTAL_COSO, ST_COMPRA_COSO,  DS_LOGIN_CASO, DS_NOME_CASO,
		DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO, 
		DS_CPFCNPJ_CASO, DT_CADASTRO_CASO, VL_FRETE_COSO, NR_SEQ_CADASTRO_COSO 
		
		FROM compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO = $compra";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	//foreach($row as $rr){echo $rr.'<br>';}
	
	$dt_compra	   = $row[0];
	
	$ip_compra	   = $row[1];
	$valor		   = $row[2];
	$st_compra	   = $row[3];	
	$login		   = $row[4];
	$nome		   = $row[5];
	$endereco	   = $row[6];
	$numero		   = $row[7];
	$complem	   = $row[8];
	$bairro		   = $row[9];
	$cidade		   = $row[10];
	$estado		   = $row[11];
	$cep		   = $row[12];
	$documento	   = $row[13];	
	$dt_cadastro   = $row[14];	
	$frete		   = $row[15];	
	$nrseqcad	   = $row[16];

		
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
 

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 3;
$taxa_boleto = 2.95;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$data_venc = date("d/m/Y", strtotime($dt_compra) + ($dias_de_prazo_para_pagamento * 86400));
$valor_cobrado = $valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
//$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
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
$dadosboleto["data_documento"] = date("d/m/Y",strtotime($dt_compra) ); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y",strtotime($dt_compra) ); // Data de processamento do boleto (opcional)
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

/*
#################################################
DESENVOLVIDO PARA CARTEIRA 18

- Carteira 18 com Convenio de 8 digitos
  Nosso número: pode ser até 9 dígitos

- Carteira 18 com Convenio de 7 digitos
  Nosso número: pode ser até 10 dígitos

- Carteira 18 com Convenio de 6 digitos
  Nosso número:
  de 1 a 99999 para opção de até 5 dígitos
  de 1 a 99999999999999999 para opção de até 17 dígitos

#################################################
*/


// SEUS DADOS
$dadosboleto["identificacao"] = "O pagamento deste boleto tamb&eacute;m poder&aacute; ser efetuado pelo Gerenciador Financeiro, pelo Auto-Atendimento BB
Internet ou pelos Terminais de Auto-Atendimento.";
$dadosboleto["cpf_cnpj"] = "08345875/0001-37";
$dadosboleto["endereco"] = "";
$dadosboleto["cidade_uf"] = "";
$dadosboleto["cedente"] = "ANTONIO M. DIAS - CONFECCAO";

// NÃO ALTERAR!
include("funcoes_bb.php"); 
//include("layout_bb.php");
echo $dadosboleto["linha_digitavel"];
?>
