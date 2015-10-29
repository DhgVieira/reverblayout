<?php

/**
 * Modelo da tabela de Assinante
 *
 * @name user_Model_Assinante
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Assinantes extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "newsletter";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_NEWSLETTER_NLRC";
	
}

