<?php

/**
 * Modelo da tabela de Forum
 *
 * @name user_Model_Forum
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Forum extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "foruns";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_FORUM_FOSO";
	
}

