<?php

/**
 * Modelo da tabela de Comentariosblog
 *
 * @name user_Model_Comentariosblog
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Comentariosblog extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "blog_coments";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_COMENTARIO_CBRC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_CADASTRO_CASO", "ID Usuario");
		$this->setCampo("NR_SEQ_BLOG_CBRC", "Codigo do Post");
		$this->setCampo("DT_CADASTRO_CBRC", "Data do comentario");
		$this->setCampo("DS_STATUS_CBRC", "Status do comentario");
		$this->setCampo("DS_TEXTO_CBRC", "Comentario");
		$this->setCampo("DS_TEMP_CBRC", "Temporario");
		$this->setCampo("DS_TEMPMAIL_CBRC", "Temporario");
		$this->setCampo("DS_IP_CBRC", "Ip do usuario");
		$this->setCampo("NR_CURTIRAM_CBRC", "Numero de curtidas");
		$this->setCampo("NR_NAOCURTIRAM_CBRC", "Número de não Curtidas");
		$this->setCampo("NR_SEQ_REPLY_CBRC", "Mensagem Pai");
		
		$this->setDescription("DS_TEXTO_CBRC");


		$this->setAutocomplete(array("NR_SEQ_REPLY_CBRC", "NR_SEQ_COMENTARIO_CBRC"), "Default_Model_Comentariosblog", 'mensagem_filhas');
		$this->setAutocomplete("NR_SEQ_CADASTRO_CASO", "Default_Model_Reverbme", "usuario");

		
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

