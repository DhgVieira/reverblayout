<?php

/**
 * Modelo da tabela de Lojistas
 *
 * @name user_Model_Lojistas
 * @see Zend_Db_Table_Abstract
 */
class user_Model_Lojistas extends Reverb_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "cadastros";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "NR_SEQ_CADASTRO_CASO";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("NR_SEQ_LOJA_CASO", "Loja que esta cadastro");
		$this->setCampo("DS_LOGIN_CASO", "Login");
		$this->setCampo("DS_SENHA_CASO", "Senha");
		$this->setCampo("DS_NOME_CASO", "Nome");
		$this->setCampo("DS_ENDERECO_CASO", "Endereco");
		$this->setCampo("DS_NUMERO_CASO", "Número");
		$this->setCampo("DS_COMPLEMENTO_CASO", "Complemento");
		$this->setCampo("DS_BAIRRO_CASO", "Bairro");
		$this->setCampo("DS_CIDADE_CASO", "Cidade");
		$this->setCampo("DS_CEP_CASO", "CEP");
		$this->setCampo("DS_UF_CASO", "Uf");

		$this->setCampo("DS_UFOPC_CASO", "Estado internacional");
		$this->setCampo("DS_EMAIL_CASO", "E-mail");
		$this->setCampo("DT_NASCIMENTO_CASO", "Data de nascimento");
		$this->setCampo("DS_CPFCNPJ_CASO", "CPF / CNPJ");
		$this->setCampo("DS_DDDCOM_CASO", "DDD Tel");
		$this->setCampo("DS_FONECOM_CASO", "Telefone");
		$this->setCampo("DS_DDDCEL_CASO", "DDD Cel");
		$this->setCampo("DS_CELULAR_CASO", "Celular");
		$this->setCampo("DT_CADASTRO_CASO", "Data de cadastro");
		$this->setCampo("ST_CADASTRO_CASO", "Status do cadastro");
		$this->setCampo("NR_NIVELSEG_CASO", "Nivel de seguranca - Nao usa mais"); 

		$this->setCampo("DS_VALIDACAO_CASO", "Nao usa mais");
		$this->setCampo("DS_CONHECEU_CASO", "Como conheceu o site");
		$this->setCampo("ST_ENVIO_CASO", "Controle de envio de newsletter - Nao usa mais");
		$this->setCampo("DS_TIPO_CASO", "Pessoa fisica ou juridica");
		$this->setCampo("ST_SPAM_CACH", "Controle de envio de newsletter - Nsao tem mais");
		$this->setCampo("DS_SEXO_CACH", "Sexo");
		$this->setCampo("DS_OCUPACAO_CACH", "Ocupacao");
		$this->setCampo("DS_WEBPAGE_CACH", "URL Do site");
		$this->setCampo("DS_IMS_CACH", "Nao usa mais");
		$this->setCampo("DS_PLAYLIST_CACH", "Playlist");
		$this->setCampo("DS_IMEEM_CACH", "Nao usa mais");

		$this->setCampo("DS_EXT_CACH", "Extensao");
		$this->setCampo("DS_PAIS_CACH", "País");
		$this->setCampo("TP_CADASTRO_CACH", "Tipo de cadastro 0 = comun 1 = atacadista");
		$this->setCampo("VL_DESCONTO_CACH", "Valor de desconto");
		$this->setCampo("NR_QTDEMINIMA_CACH", "Quantidade minima");
		$this->setCampo("DS_FAZENDO_CACH", "O que esta fazendo (perfil)");
		$this->setCampo("DS_ORKUT_CACH", "Perfil Orkut");
		$this->setCampo("DS_TWITTER_CACH", "Perfil Twitter");
		$this->setCampo("DS_PROFILE_CACH", "Se é publico(P) ou privado(A)");
		$this->setCampo("DS_OPERADORA_CACH", "Operadora do celular");
		$this->setCampo("DS_OBS_CACH", "Observacoes");

		$this->setCampo("DS_QTDEMINBUTTONS_CACH", "Quantidade minima de buttons");
		$this->setCampo("ST_ENVIOSMS_CACH", "Autoriza o envio de sms");
		$this->setCampo("NR_SEQ_USERCONVITE_CACH", "Solicitacao de amizade");
		$this->setCampo("DS_COD_SESSAO_CACH", "Manter logado no site");
		$this->setCampo("DS_TEMPITER_CACH", "Twitter");
		$this->setCampo("NR_ATAC_VLRMIN_CACH", "Número minimo de pecas de atacado");
		$this->setCampo("VL_ATAC_DESCBOLETO_CACH", "Complemento");
		$this->setCampo("ST_ATAC_FRETEGRATIS_CACH", "Frete Gratis");
		$this->setCampo("DS_NOMEFANTASIA_CACH", "Nome fantasia");
		$this->setCampo("DS_CONTATO_CACH", "Nome do contato");
		$this->setCampo("DS_INSCRICAO_CACH", "Inscricao");
		$this->setCampo("DS_EMAILINDICA_CACH", "Email de quem indicou");
		$this->setCampo("VL_ATAC_MINREPOS_CACH", "Valor minimo para a segunda compra");
		$this->setCampo("ST_BLOQUEIOMAIL_CACH", "Status bloquei email");
		$this->setCampo("DS_CODCIDADE_CACH", "Codigo da cidade (nota fiscal)");
		$this->setCampo("NR_IDFACEBOOK_CASO", "Codigo do facebook");
		$this->setCampo("DS_PRIVADO_CASO", "Perfil privado? 0 = não 1 = sim");
		$this->setCampo("DS_PINTEREST_CASO", "Pinterest");
		$this->setCampo("DT_ACESSO_CASO", "Ultimo Acesso");
		$this->setCampo("ST_CADASTRO_COMPLETO_CASO", "Status de cadastro completo = 0 Não e 1 = sim");
		// Seta o campo de descrição da tabela
		$this->setDescription("DS_NOME_CASO");
		
	 
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

