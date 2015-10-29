<?php

/**
 * Modelo da tabela de Imprensa
 *
 * @name user_Model_Imprensa
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Imprensa extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "imprensa";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idimprensa";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("data_post", "Data da postagem");
		$this->setCampo("imagem_path", "Imagem");
		$this->setCampo("titulo", "Tĩtulo do post");
		$this->setCampo("post", "Post");
	
		// Seta o campo de descrição da tabela
		$this->setDescription("titulo");
		
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

