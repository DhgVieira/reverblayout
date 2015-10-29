<?php

/**
 * Modelo da tabela de Blog
 *
 * @name user_Model_Blog
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Blog extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "blog";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_BLOG_BLRC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_CATEGORIA_BLRC", "Categoria do Post");
		$this->setCampo("NR_SEQ_COLUNISTA_BLRC", "Id do colunista");
		$this->setCampo("DS_TITULO_BLRC", "Tĩtulo do post");
		$this->setCampo("DT_CADASTRO_BLRC", "Data do Post");
		$this->setCampo("DS_STATUS_BLRC", "Status do post");
		$this->setCampo("DS_EXT_BLRC", "Extensao da foto");
		$this->setCampo("DS_YOUTUBE_BLRC", "Link Youtube");
		$this->setCampo("DS_TEXTO_BLRC", "Postagem");
		$this->setCampo("DS_TEMP_BLRC", "Temporario");
		$this->setCampo("DS_LINKIMAGEM_BLRC", "Link de imagem integrada");
		$this->setCampo("DT_PUBLICACAO_BLRC", "Publicacao");
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_TITULO_BLRC");
		
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

