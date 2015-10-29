<?php

/**
 * Modelo da tabela de Wishlist
 *
 * @name user_Model_Wishlist
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Wishlist extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_wishlist";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_WISHLIST_WLRC";
	
}

