<?php

/**
 * Modelo da tabela de produtos
 *
 * @name user_Model_produtos
 * @see Zend_Db_Table_Abstract
 */
class user_Model_produtos extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "produtos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_PRODUTO_PRRC";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_LOJAS_PRRC", "Código da Loja");
		$this->setCampo("NR_SEQ_TIPO_PRRC", "Código do Tipo");
		$this->setCampo("NR_SEQ_CATEGORIA_PRRC", "Código da Categoria");
		$this->setCampo("NR_SEQ_ESTILO_PRRC", "Código do Estilo");
		$this->setCampo("NR_SEQ_MUSICA_PRRC", "Código da Música");
		$this->setCampo("DS_PRODUTO_PRRC", "Descricao do produto");
		$this->setCampo("VL_PRODUTO_PRRC", "Valor do Produto na venda");
		$this->setCampo("DT_CADASTRO_PRRC", "Data de cadastro do produto");
		$this->setCampo("NR_VISITAS_PRRC", "Número de acessos no produto");
		$this->setCampo("NR_PESOGRAMAS_PRRC", "Peso do produto");
		$this->setCampo("DS_GARANTIA_PRRC", "Garantia do Produto");
		$this->setCampo("DS_EXT_PRRC", "Extensao do thumb do produto");
		$this->setCampo("DS_EXTTAM_PRRC", "Extensao dos tamanhos das imagens");
		$this->setCampo("DS_CLASSIC_PRRC", "Produto é classic?");
		$this->setCampo("DS_INFORMACOES_PRRC", "Informacoes do produto");
		$this->setCampo("TP_DESTAQUE_PRRC", "Tipo de Destaque","Normal = 0, New = 1, Sale = 2, Reprint = 3 Pre-venda = 4");
		$this->setCampo("DS_FRETEGRATIS_PRRC", "Frete Gratis?");
		$this->setCampo("VL_PROMO_PRRC", "Valor promocional do Produto");
		$this->setCampo("ST_PRODUTOS_PRRC", "Status do Produto");
		$this->setCampo("VL_PRODUTO2_PRRC", "Valor do produto (CUSTO)");
		$this->setCampo("NR_ORDEM_PRRC", "Ordenacao do produto");
		$this->setCampo("NR_ORDEM_LCTO_PRRC", "Ordenacao do produto lancamento");
		$this->setCampo("NR_CODIGOLOJA_PRRC", "Código de loja");
		$this->setCampo("NR_ORDEM_SALE_PRRC", "Ordenacao do produto Sale");
		$this->setCampo("ST_MARCA_PRRC", "Código de loja");
		$this->setCampo("NR_ORDEM_CLAS_PRRC", "Ordenacao do produto Classica");
		$this->setCampo("NR_ORDEM_REPR_PRRC", "Ordenacao do produto Reprint");
		$this->setCampo("NR_QTDEMINIMA_PRRC", "Quantida Mínima");
		$this->setCampo("DS_TEXTO_PRRC", "Texto");
		$this->setCampo("ST_DESCONTO_LOJA_PRRC", "Desconto da loja");
		$this->setCampo("ST_PART_PROMO_PRRC", "Produto participa da promocao?");
		$this->setCampo("NR_LINKPROD_PRRC", "Link da Promocao");
		$this->setCampo("DS_NCM_PRRC", "Produto participa da promocao?");
		$this->setCampo("NR_TEMPLIXO_PROMO_PRRC", "Produto participa da promocao?");
		$this->setCampo("NR_ORDEM_HOME_PRRC", "Ordenacao Produto Home");
		$this->setCampo("VL_DESCONTOADIC_PRRC", "Produto participa da promocao?");
		$this->setCampo("DT_PREVENDA_PRRC", "Data Pre-venda");

		
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_PRODUTO_PRRC");
		
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

