<?php

/**
 * Modelo da tabela de Mescraps
 *
 * @name user_Model_Mescraps
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Mescraps extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_scraps";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_SCRAP_SBRC";
	
}

