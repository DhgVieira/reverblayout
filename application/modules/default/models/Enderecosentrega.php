<?php

/**
 * Modelo da tabela de Enderecosentrega
 *
 * @name user_Model_Enderecosentrega
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Enderecosentrega extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "enderecos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_ENDERECO_ENRC";
	
}

