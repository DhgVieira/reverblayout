<?php

/**
 * Modelo da tabela de Cestas
 *
 * @name user_Model_Cestas
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Carrinho extends Zend_Db_Table_Abstract {
    /**
     * Armazena o nome da tabela
     *
     * @access protected
     * @name $_name
     * @var string
     */
    protected $_name = "carrinho";

    /**
     * Armazena o nome do campo da tabela primaria
     *
     * @access protected
     * @name $_primary
     * @var string
     */
    protected $_primary = "carrinho_id";

}

