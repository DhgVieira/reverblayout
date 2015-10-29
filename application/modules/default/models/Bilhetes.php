<?php

/**
 * Modelo da tabela de Bilhetes
 *
 * @name user_Model_Bilhetes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Bilhetes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "bilhetes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_BILHETES_BIRC";
	
}

