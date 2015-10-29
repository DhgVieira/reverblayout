<?php

/**
 * Modelo da tabela de Reverbmeblog
 *
 * @name user_Model_Reverbmeblog
 * @see Zend_Db_Table_Abstract
 */ 
class Default_Model_Reverbmeblog extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_blog";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idme_blog";
	
}

