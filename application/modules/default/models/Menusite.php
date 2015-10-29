<?php

/**
 * Modelo da tabela de Menusite
 *
 * @name user_Model_Menusite
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Menusite extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "menu_site";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idmenu";
	
}

