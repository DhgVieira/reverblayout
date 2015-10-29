<?php

/**
 * Modelo da tabela de Reverbcylce
 *
 * @name user_Model_Reverbcylce
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Reverbcycle extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "reverbcycle";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_REVERBCYCLE_RCRC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_CADASTRO_RCRC", "Perfil do usuario");
		$this->setCampo("NR_SEQ_CATEGREV_RCRC", "Categoria");
		$this->setCampo("DS_OBJETO_RCRC", "Descricao do Produto");
		$this->setCampo("DS_EXT_RCRC", "Extensao");
		$this->setCampo("DS_CARACTERISTICAS_RCRC", "Caracteristicas");
		$this->setCampo("DS_INTERESSE_RCRC", "Interesse no anuncio");
		$this->setCampo("DS_DADOSCONTATO_RCRC", "Dados para contato");
		$this->setCampo("DT_CADASTRO_RCRC", "Data do Cadastro");
		$this->setCampo("ST_CYCLE_RCRC", "Status do anuncio, A = Ativo, I = Inativo");
		$this->setCampo("ST_CLIENTE_RCRC", "Status do anuncio para visivel ou nao");
		$this->setCampo("NR_VIEWS_RCRC", "Número de vizualizacao");
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_OBJETO_RCRC");
		
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

