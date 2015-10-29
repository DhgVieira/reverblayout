<?php

/**
 * Modelo da tabela de Reverbpeole
 *
 * @name user_Model_Reverbpeole
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Reverbpeole extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_fotos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_FOTO_FORC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_CADASTRO_FORC", "Perfil do usuario");
		$this->setCampo("DS_NOME_FORC", "Nome");
		$this->setCampo("DS_EXT_FORC", "Extensao");
		$this->setCampo("DT_CADASTRO_FORC", "Data do Cadastro");
		$this->setCampo("ST_PEOPLE_FORC", "Status da foto");
		$this->setCampo("DS_PEOPLE_FORC", "Status");
		$this->setCampo("NR_SEQ_CATEGORIA_FORC", "Categoria");
		$this->setCampo("NR_VIEWS_FORC", "Número de vizualizacao");
		$this->setCampo("NR_POSICAO_FORC", "Número da posicao");
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_NOME_FORC");
		
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

