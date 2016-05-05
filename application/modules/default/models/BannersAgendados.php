<?php

/**
 * Modelo da tabela de Banners Agendados
 *
 * @name user_Model_Banners
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_BannersAgendados extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "banners_agendados";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_AGENDAMENTO_BARC";

	public function getBannersAgendados() {
		$objSelect = $this->select()
			->from($this->_name);
		return $this->fetchRow($objSelect);
	}
	
}

