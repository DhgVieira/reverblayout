<?php

/**
 * Modelo da tabela de Fotoscomentariosme
 *
 * @name user_Model_Fotoscomentariosme
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Fotoscomentariosme extends Zend_Db_Table_Abstract {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "me_fotos_coments";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_COMENTARIO_MCRC";
	
}

