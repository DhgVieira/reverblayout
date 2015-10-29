<?php

/**
 * Modelo da tabela de Banners
 *
 * @name user_Model_Banners
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Banners extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "banners";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_BANNER_BARC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_LOCAL_BARC", "Local d0 Banner");
		$this->setCampo("NR_POSICAO_BARC", "Posição do Banner");
		$this->setCampo("DS_DESCRICAO_BARC", "Descrição do banner");
		$this->setCampo("DS_LINK_BARC", "Link do banner");
		$this->setCampo("DS_TEXT_BARC", "Texto");
		$this->setCampo("DS_EXT_BARC", "Extenção do Arquivo");
		$this->setCampo("ST_BANNER_BARC", "Status do banner");
		$this->setCampo("DT_CADASTRO_BARC", "Data em que o banner foi cadastrado");
	
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_DESCRICAO_BARC");
		
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

