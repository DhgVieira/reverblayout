<?php

/**
 * Modelo da tabela de Monitoraclientes
 *
 * @name user_Model_Monitoraclientes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Monitoraclientes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "monitora_clientes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idmonitora_cliente";
	
}

