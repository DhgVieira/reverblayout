<?php

/**
 * Modelo da tabela de Produtosnotas
 *
 * @name user_Model_Produtosnotas
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Produtosnotas extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "produtos_notas";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idprodutos_nota";
	
}

