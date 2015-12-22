<?php

/**
 * Modelo da tabela de Cadastro
 *
 * @name user_Model_Cadastro
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Cadastro extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "cadastros";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CADASTRO_CASO";
	
}

