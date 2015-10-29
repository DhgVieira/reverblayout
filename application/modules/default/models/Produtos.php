<?php

/**
 * Modelo da tabela de produtos
 *
 * @name user_Model_produtos
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_produtos extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "produtos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_PRODUTO_PRRC";
	
}

