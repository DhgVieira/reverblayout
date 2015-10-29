<?php

/**
 * Modelo da tabela de Cupons
 *
 * @name user_Model_Cupons
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Cupons extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "cupons";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CUPOM_CURC";
	
}

