<?php

/**
 * Modelo da tabela de Blogcategorias
 *
 * @name user_Model_Blogcategorias
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Blogcategorias extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "blog_categorias";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_BLOGCAT_BCRC";

}

