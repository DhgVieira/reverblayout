<?php

/**
 * Modelo da tabela de Buscas
 *
 * @name user_Model_Buscas
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Buscas extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "buscas";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idbusca";
	
}

