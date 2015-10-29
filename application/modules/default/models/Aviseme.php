<?php

/**
 * Modelo da tabela de Aviseme
 *
 * @name user_Model_Aviseme
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Aviseme extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "aviseme";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_AVISEME_AVRC";
	
}

