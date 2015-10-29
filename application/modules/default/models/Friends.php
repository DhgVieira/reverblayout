<?php

/**
 * Modelo da tabela de Friends
 *
 * @name user_Model_Friends
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Friends extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_friends";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_FRIEND_FRRC";
	
}

