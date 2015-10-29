<?php

/**
 * Modelo da tabela de Autorizacoes
 *
 * @name user_Model_Autorizacoes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Autorizacoes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "autorizacoes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_AUT_AURC";
	
}

