<?php

/**
 * Modelo da tabela de Monitoramentodias
 *
 * @name user_Model_Monitoramentodias
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Monitoramentodias extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "monitoramento_dias";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idmonitoramento_dia";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("idmonitoramento_tee", "Codigo do monitoramento");
		$this->setCampo("dia", "Dia monitorado");
		$this->setCampo("mes", "Mes monitorado");
		$this->setCampo("ano", "Ano monitorado");
		$this->setCampo("media", "media prevista");
		$this->setCampo("total_vendido", "Total vendido no dia");
		$this->setCampo("passado", "Se o dia já passou 0 = não 1 = sim");
		

		
		// Seta o campo de descrição da tabela
		$this->setDescription("dia");

		// $this->setAutocomplete("idmonitoramento_tee", "user_Model_Monitoramento");
		$this->setAutocomplete(array("idmonitoramento_tee", "idmonitoramento_tee"), "user_Model_Monitoramento", 'dias');

		// Continua o carregamento do model
		parent::init();
	}
}

