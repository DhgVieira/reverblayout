<?php

/**
 * Modelo da tabela de Monitoramento
 *
 * @name user_Model_Monitoramento
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Monitoramento extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "monitoramento_tees";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idmonitoramento_tee";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("idproduto", "Codigo do Produto");
		$this->setCampo("vl_investido", "Valor Investido");
		$this->setCampo("quantidade_estimada", "Quantidade Estimada");
		$this->setCampo("data_inicio", "Data de Inicio");
		$this->setCampo("data_fim", "Data Fim");
		$this->setCampo("status", "Status 1 - Ativo 0 - Inativo");

		
		// Seta o campo de descrição da tabela
		$this->setDescription("vl_investido");
		
		// Continua o carregamento do model
		parent::init();
	}
}

