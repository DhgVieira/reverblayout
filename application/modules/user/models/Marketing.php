<?php

/**
 * Modelo da tabela de Marketing
 *
 * @name user_Model_Marketing
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Marketing extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "campanhas_hist";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_ACOMPCAMP_ACRC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_CAMPANHA_ACRC", "Codigo da Campanha");
		$this->setCampo("NR_SEQ_TIPO_ACRC", "Tipo de campanha");
		$this->setCampo("NR_SEQ_CADASTRO_ACRC", "Codigo do comprador");
		$this->setCampo("DS_IP_ACRC", "IP Campanha");
		$this->setCampo("DT_REGISTRO_ACRC", "Data de Registro");
		$this->setCampo("DS_OBS_ACRC", "Código da Compra");
		
	
		// Seta o campo de descrição da tabela
		$this->setDescription("DT_REGISTRO_ACRC");
		
		
		
		// Continua o carregamento do model
		parent::init();
	}
}

