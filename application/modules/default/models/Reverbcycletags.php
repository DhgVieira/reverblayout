<?php

/**
 * Modelo da tabela de Reverbcycle tags
 *
 * @name user_Model_Reverbcycle tags
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Reverbcycletags extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "reverbcycle_tags";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idreverbcycle_tag";
	
}

