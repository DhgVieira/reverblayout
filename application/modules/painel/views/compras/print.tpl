<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Painel Reverbcity</title>
    {$this->headLink()}
    {$this->headMeta()}
    <style>

@media print {
  * {
    -webkit-print-color-adjust: exact !important;
  }

  .printed-table {
    width: 90%;
  }
  .printed-table.head-table {
    white-space: nowrap;
    border-bottom: 3px solid #2c2c2c;
  }
  .printed-table.head-table td {
    font-style: 16.6px;
  }
  .printed-table.head-table .print-title {
    font-size: 18px;
  }
  .printed-table.printed-table-produtos {
    border-collapse: collapse;
    text-indent: center;
    border-bottom: 3px solid #2c2c2c;
  }
  .printed-table.printed-table-produtos div {
    padding: 0px 10px;
  }
  .printed-table.printed-table-produtos .printed-table-prdutos-thead .printed-table-trow {
    border-bottom: 3px solid #c2c2c2;
  }
  .printed-table.printed-table-produtos .printed-table-theads {
    padding: 15px 0px 30px 0px;
    font-size: 14px;
  }
  .printed-table.printed-table-produtos .printed-table-theads div {
    text-align: center;
    background: #e9e9e9;
    height: 20px;
    line-height: 20px;
  }
  .printed-table.printed-table-produtos .printed-table-prdutos-items {
    font-size: 15px;
  }
  .printed-table.printed-table-produtos .printed-table-prdutos-items .printed-table-trow {
    border-bottom: 3px solid #c2c2c2;
  }
  .printed-table.printed-table-produtos .printed-table-prdutos-items .printed-table-tbody {
    text-align: center;
    padding: 3px 0px 3px 0px;
  }
  .printed-table.printed-table-produtos .printed-table-prdutos-tfoot .subtotal-cells {
    text-align: center;
    padding-top: 12px;
    font-size: 16px;
  }
  .printed-table.printed-table-produtos .printed-table-prdutos-tfoot .total-cells {
    text-align: center;
    padding-top: 15px;
    padding-bottom: 10px;
    font-size: 19px;
    height: 18px;
    line-height: 18px;
  }
  .printed-table.printed-table-produtos .printed-table-prdutos-tfoot .total-cells div {
    background: #e9e9e9;
  }
  .printed-table.printed-table-details {
    padding: 0 30px;
  }
  .printed-table.printed-table-details .printed-table-details-cells *,
  .printed-table.printed-table-details .printed-table-details-cells {
    font-size: 18px;
    white-space: nowrap;
    line-height: 18px;
    vertical-align: middle;
  }
  .printed-table.printed-table-details .printed-table-details-cells {
    padding: 0 2%;
  }
  .printed-table.printed-table-buyer {
    border-bottom: 3px solid #2c2c2c;
  }
  .printed-table.printed-table-buyer .buyer-detail-cells {
    font-size: 18px;
    line-height: 18px;
  }
  .printed-table.printed-table-buyer .buyer-details-blocks {
    padding: 10px 5px;
  }
  .printed-table.printed-table-buyer .buyer-details-separator {
    font-size: 17px;
    padding: 5px 5px;
  }
  .printed-table.printed-table-buyer .buyer-details-separator div {
    height: 20px;
    line-height: 20px;
    padding: 0px 10px;
  }
  .printed-table.printed-table-buyer .buyer-details-separator.gray div {
    background: #e9e9e9;
  }

  .printed-table-bottom {
    line-height: 90px;
  }
  .printed-table-bottom td {
    white-space: nowrap;
  }
	@import url(http://fonts.googleapis.com/css?family=Noto+Sans:400,700);
	
	.f1 {
	  font-family: 'Noto Sans', sans-serif;
	}

	.f2 {
	  font-family: 'Noto Sans', sans-serif;
	}

	.f3 {
	  font-family: 'Noto Sans', sans-serif;
	}

	.f4 {
	  font-family: 'Noto Sans', sans-serif;
	}

	.f5 {
	  font-family: 'Noto Sans', sans-serif;
	}

	.f6 {
	  font-family: 'Noto Sans', sans-serif;
	}
}
    </style>
</head>

<body>

<table class="printed-table head-table f3" align="center">
	<tr style="white-space: nowrap;">
		<td>Compra º {$dadosCompra->NR_SEQ_COMPRA_COSO} feita em {$dadosCompra->DT_COMPRA_COSO|date_format:"%d/%m/%Y %H:%M"}</td>
		<td width="100%">&nbsp;</td>
		<td> Gerado em {$smarty.now|date_format:"%d/%m/%Y %H:%M"}</td>
	</tr>
</table>
<table class="printed-table printed-table-produtos f3" align="center">
	<thead class="printed-table printed-table-prdutos-thead">
		<tr class="printed-table-trow">
			<td class="printed-table-theads"><div>IMAGEM</div></td>
			<td class="printed-table-theads"><div>PRODUTO</div></td>
			<td class="printed-table-theads"><div>REFERÊNCIA</div></td>
			<td class="printed-table-theads"><div>TAMANHO</div></td>
			<td class="printed-table-theads"><div>VALOR</div></td>
			<td class="printed-table-theads"><div>QTD.</div></td>
		</tr>
	</thead>
	<tbody class="printed-table printed-table-prdutos-items">
		{foreach from=$dadosCesta item=cesta}
			{assign var=qtdTotal value=$qtdTotal + $cesta->NR_QTDE_CESO}
			{if $cesta->VL_COM_DESCONTO}
				{assign var=subTotal value=$subTotal + $cesta->VL_COM_DESCONTO}
			{else}
				{assign var=subTotal value=$subTotal + $cesta->VL_PRODUTO_CESO}
			{/if}

			{assign var="fotos" value=$this->fotoproduto($cesta->NR_SEQ_PRODUTO_PRRC)}
			{assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
			{assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
			{assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

			<tr class="printed-table-trow">
				<td class="printed-table-tbody"><div><img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>90, 'altura'=>95, 'imagem'=>$foto_completa],"imagem", TRUE)}"></div></td>
				<td class="printed-table-tbody"><div>{$cesta->DS_PRODUTO2_PRRC}</div></td>
				<td class="printed-table-tbody"><div>{$cesta->DS_REFERENCIA_PRRC}</div></td>
				<td class="printed-table-tbody"><div>{$cesta->DS_TAMANHO_TARC}</div></td>
				<td class="printed-table-tbody"><div>R$ {if $cesta->VL_COM_DESCONTO}{$cesta->VL_COM_DESCONTO|number_format:2:",":"."}{else}{$cesta->VL_PRODUTO_CESO|number_format:2:",":"."}{/if}</div></td>
				<td class="printed-table-tbody"><div>{$cesta->NR_QTDE_CESO}</div></td>
			</tr>
		{/foreach}
		<tfoot class="printed-table printed-table-prdutos-tfoot">
			<tr class="printed-table-produtos-sub-total">
				<td class="subtotal-cells"  colspan="3"><div>&nbsp;</div></td>
				<td class="subtotal-cells" ><div>SUBTOTAL</div></td>
				<td class="subtotal-cells" ><div>R$ {$subTotal|number_format:2:",":"."}</div></td>
				<td class="subtotal-cells" ><div>{$qtdTotal}</div></td>
			</tr>
			<tr class="printed-table-produtos-sub-total">
				<td class="subtotal-cells"  colspan="3"><div>&nbsp;</div></td>
				<td class="subtotal-cells"><div>FRETE {$dadosCompra->DS_FORMAENVIO_COSO}</div></td>
				<td class="subtotal-cells" ><div>{$dadosCompra->VL_FRETE_COSO|number_format:2:",":"."}</div></td>
				<td class="subtotal-cells" ><div></div></td>
			</tr>
			<tr class="printed-table-produtos-total">
				<td class="total-cells"  colspan="3"><div>&nbsp;</div></td>
				<td class="total-cells" ><div>TOTAL</div></td>
				<td class="total-cells" colspan="2"><div>R$ {$dadosCompra->VL_TOTAL_COSO|number_format:2:",":"."}</div></td>
			</tr>
		</tfoot>
	</tbody>
</table>
<table class="printed-table printed-table-details f3" align="center">
	<tr class="printed-table-details-rows">
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>IP da Compra </td>
					<td style="width: 100%;"></td>
					<td>{$dadosCompra->DS_IP_COSO}</td>
				</tr>
			</table>
		</td>
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>Status</td>
					<td style="width: 100%;"></td>
					<td><div class="compras-balls-3 posr"><div class="compra-ball">{$dadosCompra->ST_COMPRA_COSO}</div></div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="printed-table-details-rows">
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>Forma de Pagamento</td>
					<td style="width: 100%;"></td>
					<td>
						{if $dadosCompra->DS_FORMAPGTO_COSO == 'master'}
							<img class="vmiddle" src="{$basePath}/arquivos/painel/images/master.png" alt="">
						{elseif $dadosCompra->DS_FORMAPGTO_COSO == 'visa'}
							<img class="vmiddle" src="{$basePath}/arquivos/painel/images/visa.png" alt="">
						{elseif $dadosCompra->DS_FORMAPGTO_COSO == 'amex'}
							<img class="vmiddle" src="{$basePath}/arquivos/painel/images/american-express.png" alt="">
						{elseif $dadosCompra->DS_FORMAPGTO_COSO == 'boleto'}
							<img class="vmiddle" src="{$basePath}/arquivos/painel/images/boleto.png" alt="">
						{/if}
					</td>
				</tr>
			</table>
		</td>
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>Mudança de Status</td>
					<td style="width: 100%;"></td>
					<td>{$dadosCompra->DT_STATUS_COSO|date_format:"%d/%m/%Y"}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="printed-table-details-rows">
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>Parcelas</td>
					<td style="width: 100%;"></td>
					<td>{$dadosCompra->NR_PARCELAS_COSO}</td>
				</tr>
			</table>
		</td>
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>Rastreamento</td>
					<td style="width: 100%;"></td>
					<td>{$dadosCompra->DS_RASTREAMENTO_COSO}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="printed-table-details-rows">
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>TID</td>
					<td style="width: 100%;"></td>
					<td>{$dadosCompra->DS_TID_COSO}</td>
				</tr>
			</table>
		</td>
		<td class="printed-table-details-cells">
			<table>
				<tr>
					<td>&nbsp;</td>
					<td style="width: 100%;"></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table class="printed-table printed-table-buyer f3" align="center">
	<thead>
		<tr class="printed-table-buyers-rows">
			<td colspan="2" class="buyer-details-separator gray">
				<div class="">DADOS PARA ENTREGA</div>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="buyer-details-blocks">
				<table>
					{if !empty($dadosCompra->DS_ENDERECO_ENRC)}
						<tr><td class="buyer-detail-cells"><div>Nome: {$dadosCompra->DS_DESTINATARIO_ENRC}</div> </td></tr>
						<tr><td class="buyer-detail-cells"><div>Endereço: {$dadosCompra->DS_ENDERECO_ENRC}, {$dadosCompra->DS_NUMERO_ENRC} - {$dadosCompra->DS_COMPLEMENTO_ENRC}</div> </td></tr>
						<tr><td class="buyer-detail-cells"><div>{$dadosCompra->DS_CIDADE_ENRC}/{$dadosCompra->DS_UF_ENRC}</div> </td></tr>
						<tr><td class="buyer-detail-cells"><div>CEP {$dadosCompra->DS_CEP_ENRC} - {$dadosCompra->DS_BAIRRO_ENRC}</div> </td></tr>
					{else}
						<tr><td class="buyer-detail-cells"><div>Nome: {$dadosCompra->DS_NOME_CASO}</div> </td></tr>
						<tr><td class="buyer-detail-cells"><div>Endereço: {$dadosCompra->DS_ENDERECO_CASO}, {$dadosCompra->DS_NUMERO_CASO} - {$dadosCompra->DS_COMPLEMENTO_CASO}</div> </td></tr>
						<tr><td class="buyer-detail-cells"><div>{$dadosCompra->DS_CIDADE_CASO}/{$dadosCompra->DS_UF_CASO}</div> </td></tr>
						<tr><td class="buyer-detail-cells"><div>CEP {$dadosCompra->DS_CEP_CASO} - {$dadosCompra->DS_BAIRRO_CASO}</div> </td></tr>
					{/if}
				</table>
			</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" class="buyer-details-separator gray">
				<div class="">DADOS DO CLIENTE</div>
			</td>
		</tr>
		<tr>
			<td class="buyer-details-blocks">
				<table>
					<tr><td class="buyer-detail-cells"><div>Nome: {$dadosCompra->DS_NOME_CASO}</div> </td></tr>
					<tr><td class="buyer-detail-cells"><div>Endereço: {$dadosCompra->DS_ENDERECO_CASO}, {$dadosCompra->DS_NUMERO_CASO} - {$dadosCompra->DS_COMPLEMENTO_CASO}</div> </td></tr>
					<tr><td class="buyer-detail-cells"><div>{$dadosCompra->DS_CIDADE_CASO}/{$dadosCompra->DS_UF_CASO}</div> </td></tr>
					<tr><td class="buyer-detail-cells"><div>CEP {$dadosCompra->DS_CEP_CASO} - {$dadosCompra->DS_BAIRRO_CASO}</div> </td></tr>
				</table>
			</td>
			<td class="buyer-details-blocks">
				<table>
					<tr><td class="buyer-detail-cells"><div>Nascimento: {$dadosCompra->DT_NASCIMENTO_CASO}</div> </td></tr>
					<tr><td class="buyer-detail-cells"><div>Documento: {$dadosCompra->DS_CPFCNPJ_CASO}</div> </td></tr>
					<tr><td class="buyer-detail-cells"><div>Email: {$dadosCompra->DS_EMAIL_CASO}</div> </td></tr>
					<tr><td class="buyer-detail-cells"><div>Fone: ({$dadosCompra->DS_DDDFONE_CASO|replace:")":""|replace:"(":""}) {$dadosCompra->DS_FONE_CASO}</div> </td></tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="2"></td></tr>
	</tbody>
</table>
{$this->headScript()}

</body>
</html>