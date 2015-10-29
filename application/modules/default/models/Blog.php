<?php

/**
 * Modelo da tabela de Blog
 *
 * @name user_Model_Blog
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Blog extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "blog";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_BLOG_BLRC";
	
}

