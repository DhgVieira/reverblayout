<?php

/**
 * Modelo da tabela de Estoque
 *
 * @name user_Model_Estoque
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Estoque extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "estoque";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_ESTOQUE_ESRC";
	
}

