<?php

/**
 * Modelo da tabela de Compras
 *
 * @name user_Model_Compras
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Compras extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "compras";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_COMPRA_COSO";
	
}

