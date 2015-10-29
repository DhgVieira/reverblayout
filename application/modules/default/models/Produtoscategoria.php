<?php

/**
 * Modelo da tabela de Fretes
 *
 * @name user_Model_Fretes
 * @see Zend_Db_Table_Abstract
 */
class Default_Model_Produtoscategoria extends Zend_Db_Table_Abstract {
    /**
     * Armazena o nome da tabela
     *
     * @access protected
     * @name $_name
     * @var string
     */
    protected $_name = "produtos_categoria";

    /**
     * Armazena o nome do campo da tabela primaria
     *
     * @access protected
     * @name $_primary
     * @var string
     */
    protected $_primary = "NR_SEQ_CATEGPRO_PCRC";

}

