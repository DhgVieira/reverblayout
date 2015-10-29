<?php

/**
 * Modelo da tabela de enquetesopcoes
 *
 * @name user_Model_enquetesopcoes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Enquetesopcoes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "enquetes_opcoes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idenquete_opcao";
	
}

