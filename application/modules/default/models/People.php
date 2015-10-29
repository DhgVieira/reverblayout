<?php

/**
 * Modelo da tabela de People
 *
 * @name user_Model_People
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_People extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_fotos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_FOTO_FORC";
	
}

