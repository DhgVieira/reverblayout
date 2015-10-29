<?php

/**
 * Modelo da tabela de Contato
 *
 * @name user_Model_Contato
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Contato extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "contatos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idcontato";
	
}

