<?php

/**
 * Modelo da tabela de Tamanhos
 *
 * @name user_Model_Tamanhos
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Tamanhos extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "tamanhos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_TAMANHO_TARC";
	
}

