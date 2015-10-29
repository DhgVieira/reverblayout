<?php

/**
 * Modelo da tabela de Enquetes
 *
 * @name user_Model_Enquetes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Enquetes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "enquetes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idenquete";
	
}

