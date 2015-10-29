<?php

/**
 * Modelo da tabela de Modelostamanhos
 *
 * @name user_Model_Modelostamanhos
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Modelostamanhos extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "modelos_has_tamanhos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idmodelo_has_tamanho";
	
}

