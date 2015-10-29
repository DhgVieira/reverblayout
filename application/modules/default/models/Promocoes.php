<?php

/**
 * Modelo da tabela de Promocoes
 *
 * @name user_Model_Promocoes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Promocoes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "promocoes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idpromocao";
	
}
