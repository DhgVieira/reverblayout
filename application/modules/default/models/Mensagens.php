<?php

/**
 * Modelo da tabela de Mensagens
 *
 * @name user_Model_Mensagens
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Mensagens extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "msgs";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_MSG_MESO";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_TOPICO_MESO", "Topico da mensagem");
		$this->setCampo("NR_SEQ_CADASTRO_CASO", "Codigo de quem publicou");
		$this->setCampo("DT_CADASTRO_MESO", "Data de cadastro");
		$this->setCampo("ST_MSG_MESO", "Status da mensagem");
		$this->setCampo("DS_MSG_MESO", "Mensagem");
		$this->setCampo("DS_IP_MESO", "IP de quem publicou");
		$this->setCampo("NR_CURTIRAM_MESO", "Número de curtidas");
		$this->setCampo("NR_NAOCURTIRAM_MESO", "Número de não curtidas");
		$this->setCampo("NR_REPLY_MESO", "ID da mensagem que esta sendo respondida, padrao vazio = mensagem nova");
	
		// Seta o campo de descrição da tabela
		$this->setDescription("NR_SEQ_MSG_MESO");
		
		$this->setAutocomplete(array("NR_REPLY_MESO", "NR_SEQ_MSG_MESO"), "Default_Model_Mensagens", 'mensagem_filhas');
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

