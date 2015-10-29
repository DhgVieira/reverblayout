<?php

/**
 * Modelo da tabela de Mensagens
 *
 * @name user_Model_Mensagens
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Naocurtiram extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "nao_curtiram";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CURTIU_CURC";
	
}

