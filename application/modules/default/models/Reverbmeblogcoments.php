<?php

/**
 * Modelo da tabela de Reverbmeblogcoments
 *
 * @name user_Model_Reverbmeblogcoments
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Reverbmeblogcoments extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_blog_coments";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idme_blog_coment";
	
}

