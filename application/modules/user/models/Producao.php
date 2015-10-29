<?php

/**
 * Modelo da tabela de Producao
 *
 * @name user_Model_Producao
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Producao extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "producao";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idproducao";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("idproduto", "Código do Produto");
		$this->setCampo("data_insercao", "Data de inserção");
		$this->setCampo("tempo_gasto", "Tempo para produçao");
		
		// Seta o campo de descrição da tabela
		$this->setDescription("data_insercao");

		$this->setAutocomplete("idproduto", "user_Model_Produtos");
		
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

