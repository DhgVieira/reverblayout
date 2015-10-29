<?php

/**
 * Modelo da tabela de Cidadestam
 *
 * @name user_Model_Cidadestam
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Cidadestam extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "cidades_tam";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idcidade_tam";
	
}

