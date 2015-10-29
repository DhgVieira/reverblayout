<?php

/**
 * Modelo da tabela de Contas Corrente
 *
 * @name user_Model_Contas Corrente
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Contascorrente extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "contacorrente";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CONTA_CRSA";
	
}

