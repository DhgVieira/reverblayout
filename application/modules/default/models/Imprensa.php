<?php

/**
 * Modelo da tabela de Imprensa
 *
 * @name user_Model_Imprensa
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Imprensa extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "imprensa";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idimprensa";
	
}

