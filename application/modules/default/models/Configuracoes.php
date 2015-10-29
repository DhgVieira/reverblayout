<?php

/**
 * Modelo da tabela de Configuracaoes
 *
 * @name user_Model_Configuracaoes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Configuracoes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "config_gerais";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CONFIG_GESA";
	
}

