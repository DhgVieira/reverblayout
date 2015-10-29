<?php

/**
 * Modelo da tabela de Campanhas
 *
 * @name user_Model_Campanhas
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Campanhas extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "campanhas";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CAMPANHA_CARC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("DS_CAMPANHA_CARC", "Descrição da campanha");
		$this->setCampo("DT_CRIACAO_CARC", "Data de criação");
		$this->setCampo("DS_OBSERVACOES_CARC", "Observações");
	
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_CAMPANHA_CARC");
		
		
		
		// Continua o carregamento do model
		parent::init();
	}
}

