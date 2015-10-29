<?php

/**
 * Modelo da tabela de Enquetecomentarios
 *
 * @name user_Model_Enquetecomentarios
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Enquetecomentarios extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "enquete_comentarios";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idenquete_comentario";
	
}

