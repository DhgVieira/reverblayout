<?php

/**
 * Modelo da tabela de Indicacoes
 *
 * @name user_Model_Indicacoes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Indicacoes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "indicacoes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idindicacao";
	
}

