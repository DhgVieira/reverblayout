<?php

/**
 * Classe de envio de emails
 * 
 * @name Reverb_Mail
 */
class Reverb_Mail extends Zend_Mail {
	/**
	 * Armazena o transporte do email
	 *
	 * @access private 
	 * @name _transport
	 * @var Zend_Mail_Transport_Smtp
	 */
	private $_transport = NULL;
	
	/**
	 * Método de inicialização da classe
	 * 
	 * @name init
	 * @param string $encode Codificação do email
	 */
	public function __construct($encode=NULL) {
		// Busca as configurações
		$config = Zend_Registry::get("config");
		
		// Verifica as configurações padrão
		$ssl = "ssl";
		if(isset($config->Reverb->email->ssl)) {
			$ssl = $config->Reverb->email->ssl;
		}
		
		$port = "465";
		if(isset($config->Reverb->email->port)) {
			$port = $config->Reverb->email->port;
		}
		
		$auth = "login";
		if(isset($config->Reverb->email->auth)) {
			$auth = $config->Reverb->email->auth;
		}
		
		if(isset($config->Reverb->email->encode)) {
			$encode = $config->Reverb->email->encode;
		}
		
		// Constroi o parent
		parent::__construct($encode);
		
		// Cria a configuração do email
		$email_conf = array(
			'auth' => $auth,
			'username' => $config->Reverb->email->username,
			'password' => $config->Reverb->email->password,
			'ssl' => $ssl,
			'port' => $port
		);
		
		// Cria o objeto de transport
		$this->_transport = new Zend_Mail_Transport_Smtp($config->Reverb->email->smtp, $email_conf);
		
		// Verifica se possui email e nome default
		if((isset($config->Reverb->email->default->email)) && (isset($config->Reverb->email->default->nome))) {
			parent::setFrom($config->Reverb->email->default->email, $config->Reverb->email->default->nome);
		}
	}
	
	/**
	 * Método para enviar o email
	 * 
	 * @name send
	 */
	public function send() {
		// Envia o email
		parent::send($this->_transport);
	}
	
	/**
	 * Adiciona imagens ao corpo do email
	 * 
	 * @name addEmbeddedImage
	 * @param string $image Imagem á ser anexada
	 * @param string $id ID da imagem
	 * @param string $path Caminho relativo usado no email
	 */
	public function addEmbeddedImage($image, $id, $path) {
		$attach = parent::createAttachment(
			file_get_contents($image),
			"image/png",
			Zend_Mime::DISPOSITION_INLINE,
			Zend_Mime::ENCODING_BASE64,
			$path
		);
		
		$attach->id = $id;
		
		return $this;
	}
}
