<?php

/**
 * Modelo da tabela de Configuracaoes
 *
 * @name user_Model_Configuracaoes
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Configuracoes extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "config_gerais";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CONFIG_GESA";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("DS_FRASE1_GESA", "Frase 1");
		$this->setCampo("DS_FRASE2_GESA", "Frase 2");
		$this->setCampo("DS_FRASE3_GESA", "Frase 3");
		$this->setCampo("DS_FRASE4_GESA", "Frase 4");
		$this->setCampo("ST_FRETEGRATIS_GESA", "Status do frete gratis");
		$this->setCampo("VL_FRETEGRATIS_GESA", "Valor para frete gratis");
		$this->setCampo("DS_STATUS_GEHD", "Status ");
		$this->setCampo("DT_ENVIOEMAIL_ULTCAD_GESA", "Data de ultimo envio");
		$this->setCampo("ST_PROMO_PASCOA_GESA", "Status promo pascoa");

		// Seta o campo de descrição da tabela
		$this->setDescription("DS_FRASE1_GESA");
		
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

