<?php

/**
 * Modelo da tabela de Cestas
 *
 * @name user_Model_Cestas
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Cestas extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "cestas";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CESTA_CESO";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_CADASTRO_CESO", "Cliente");
		$this->setCampo("NR_SEQ_COMPRA_CESO", "Compra");
		$this->setCampo("NR_SEQ_PRODUTO_CESO", "Codigo do Produto");
		$this->setCampo("NR_SEQ_ESTOQUE_CESO", "Estoque");
		$this->setCampo("NR_SEQ_TAMANHO_CESO", "Tamanho");
		$this->setCampo("NR_QTDE_CESO", "Quantidade");
		$this->setCampo("VL_PRODUTO_CESO", "Valor do Produto");
		$this->setCampo("DT_INCLUSAO_CESO", "Data de inclusao");
		$this->setCampo("DS_OBS_CESO", "Observação");
		$this->setCampo("VL_PRODUTOCHEIO_CESO", "Valor do produto cheio");
	
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_OBS_CESO");
		
		// Seta os modificadores
		$this->setModifier("path", array(
				'type' => "file",
				'preview' => "arquivos/uploads/teste",
				'destination' => APPLICATION_PATH . "/../arquivos/uploads/teste"
		));
		
		// Continua o carregamento do model
		parent::init();
	}
}

