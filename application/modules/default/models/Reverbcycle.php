<?php

/**
 * Modelo da tabela de Reverbcylce
 *
 * @name user_Model_Reverbcylce
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Reverbcycle extends Zend_Db_Table_Abstract {
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
	
}

