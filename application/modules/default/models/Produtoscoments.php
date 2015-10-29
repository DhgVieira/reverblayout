<?php

/**
 * Modelo da tabela de Produtoscomments
 *
 * @name user_Model_Produtoscomments
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Produtoscoments extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "produtos_coments";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_PRODCOMENT_PCRC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_CADASTRO_PCRC", "Codigo de quem enviou o comentario");
		$this->setCampo("NR_SEQ_PRODUTO_PCRC", "Usuário que avaliou");
		$this->setCampo("DS_AUTOR_PCRC", "Nome do autor");
		$this->setCampo("DS_EMAIL_PCRC", "E-mail");
		$this->setCampo("DS_COMENTARIO_PCRC", "Comentário");
		$this->setCampo("DT_COMENT_PCRC", "Data do comentario");
		$this->setCampo("DS_STATUS_PCRC", "Status");
		$this->setCampo("DS_IP_PCRC", "IP");
		$this->setCampo("NR_SEQ_REPLY_PCRC", "Mensagem Pai");
		$this->setCampo("NR_CURTIRAM_PCRC", "Total Curtidas");
		$this->setCampo("NR_NAOCURTIRAM_PCRC", "Total Nao Curtidas");

	
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_AUTOR_PCRC");

		$this->setAutocomplete(array("NR_SEQ_REPLY_PCRC", "NR_SEQ_PRODCOMENT_PCRC"), "Default_Model_Produtoscoments", 'mensagem_filhas');
		$this->setAutocomplete("NR_SEQ_CADASTRO_CASO", "Default_Model_Reverbme");
		
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

