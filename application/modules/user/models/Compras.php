<?php

/**
 * Modelo da tabela de Compras
 *
 * @name user_Model_Compras
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Compras extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "compras";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_COMPRA_COSO";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_LOJA_COSO", "Codigo da Loja");
		$this->setCampo("NR_SEQ_CADASTRO_COSO", "Comprador");
		$this->setCampo("NR_SEQ_BILHETE_COSO", "Código do bilhete");
		$this->setCampo("DT_COMPRA_COSO", "Data da compra");
		$this->setCampo("DT_STATUS_COSO", "Data de atualização do status");
		$this->setCampo("DS_IP_COSO", "Ip do comprador");
		$this->setCampo("VL_TOTAL_COSO", "Valor total");
		$this->setCampo("VL_FRETE_COSO", "Valor Frete");
		$this->setCampo("ST_COMPRA_COSO", "Status da compra");
		$this->setCampo("DS_FORMAPGTO_COSO", "Forma de pagamento");
		$this->setCampo("NR_PARCELAS_COSO", "Numero de parcelas");
		$this->setCampo("DS_RETORNO_COSO", "Retorno");
		$this->setCampo("DS_OBS_COSO", "Observação");
		$this->setCampo("DS_TID_COSO", "TID");
		$this->setCampo("TP_ENDERECO_COSO", "Tipo de endereço");
		$this->setCampo("VL_FRETECUSTO_COSO", "Custo do Frete");
		$this->setCampo("VL_CUSTOPAGTO_COSO", "Custo do pagamento");
		$this->setCampo("DS_RASTREAMENTO_COSO", "Código de Rastreamento");
		$this->setCampo("DT_PAGAMENTO_COSO", "Pagamento");
		$this->setCampo("VL_DESCONTO_COSO", "Valor do desconto");
		$this->setCampo("VL_PAGO_COSO", "Valor Pago");
		$this->setCampo("VL_TROCO_COSO", "Valor Troco");
		$this->setCampo("DS_FORMACARTAO_COSO", "Forma do Cartao");
		$this->setCampo("DS_NRBANCO_COSO", "Numero do banco");
		$this->setCampo("DS_AGENCIA_COSO", "Agência");
		$this->setCampo("DS_CONTACORR_COSO", "Conta Corrente");
		$this->setCampo("DS_CHEQUE1_COSO", "Cheque 1");
		$this->setCampo("DS_CHEQUE2_COSO", "Cheque 2");
		$this->setCampo("DS_CHEQUE3_COSO", "Cheque 3");
		$this->setCampo("VL_CHEQUE1_COSO", "Valor do Cheque 1");
		$this->setCampo("VL_CHEQUE2_COSO", "Valor do Cheque 2");
		$this->setCampo("VL_CHEQUE3_COSO", "Valor do Cheque 3");
		$this->setCampo("DT_CHEQUE1_COSO", "Data do Cheque 1");
		$this->setCampo("DT_CHEQUE2_COSO", "Data do Cheque 2");
		$this->setCampo("DT_CHEQUE3_COSO", "Data do Cheque 3");
		$this->setCampo("VL_DESCPROMO_COSO", "Descricao da promoção");
		$this->setCampo("NR_SEQ_VENDEDOR_COSO", "Vendedor");
		$this->setCampo("ST_NOVOPGTO_COSO", "Status do pagamento");
		$this->setCampo("ST_SEPARADO_COSO", "Status separado");
		$this->setCampo("NR_SEQ_PROMO_COSO", "Código da promoção");
		$this->setCampo("DT_VCTOBOLETO_COSO", "Data de Vencimento do boleto");


	
		// Seta o campo de descrição da tabela
		$this->setDescription("VL_TOTAL_COSO");
		
		// Seta os modificadores
		$this->setModifier("path", array(
				'type' => "file",
				'preview' => "arquivos/uploads/teste",
				'destination' => APPLICATION_PATH . "/../arquivos/uploads/teste"
		));
		
		// Continua o carregamento do model
		parent::init();
	}
}

