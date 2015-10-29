<?php

/**
 * Modelo da tabela de Topicos
 *
 * @name user_Model_Topicos
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Topicos extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "topicos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_TOPICO_TOSO";
	
}

