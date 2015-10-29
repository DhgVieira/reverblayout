<?php

/**
 * Modelo da tabela de Estoquecontrole
 *
 * @name user_Model_Estoquecontrole
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Estoquecontrole extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "estoque_controle";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_ESTCONTROLE_ECRC";
	
}

