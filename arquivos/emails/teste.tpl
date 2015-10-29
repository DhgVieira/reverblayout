<?php // Busca a configuração
$config = Zend_Registry::get("config");
 
// Cria o objeto de e-mail
$mail = new Avadora_Mail();
 
$estado_select = $estados_model->select()
->from(array('e'=>'estados'), array('*'))
->where("e.idestado = ?", $data['estado'])
->setIntegrityCheck(FALSE);
 
$estado = $estados_model->fetchRow($estado_select);
 
// Cria a mensagem
$mensagem = "
	<table width=\"500\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
		<tr><td height=\"30\" width=\"115\"><b>Nome:</b></td><td>" . $data['nome'] . "</td></tr>
		<tr><td height=\"30\"><b>Email:</b></td><td>" . $data['email'] . "</td></tr>
		<tr><td height=\"30\"><b>Telefone:</b></td><td>" . $data['telefone'] . "</td></tr>
		<tr><td height=\"30\"><b>Cidade:</b></td><td>" . $data['cidade'] . "</td></tr>
		<tr><td height=\"30\"><b>Estado:</b></td><td>" . $estado->nome . "</td></tr>
		<tr><td height=\"30\" valign=\"top\"><b>Comentário:</b></td><td>" . nl2br($data['mensagem']) . "</td></tr>
	</td></tr></table>
";
 
// Busca o conteudo
$contents = file_get_contents(APPLICATION_PATH . "/../common/email/padrao.html");
 
// Substitui o conteudo
$contents = str_replace("{\$mensagem}", $mensagem, $contents);
 
// Configura o envio para Tribo Urbana
$mail->addTo($config->avadora->email->default->email, $config->avadora->email->default->nome)
->setSubject("Tribo Urbana - Cadastro de franquia")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/topo.jpg", "topo", "common/email/img/topo.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/rodape.jpg", "rodape", "common/email/img/rodape.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/esq.jpg", "esq", "common/email/img/esq.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/dir.jpg", "dir", "common/email/img/dir.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/tribo-urbana.jpg", "tribo-urbana", "common/email/img/tribo-urbana.jpg")
->setReplyTo($data["email"], "Tribo Urbana")
->setBodyHtml($contents)
->send();
 
// Cria o objeto de e-mail
$mail = new Avadora_Mail();
 
// Configura o envio para usuario
$mail->addTo($data["email"], "Tribo Urbana")
->setSubject("Tribo Urbana - Confirmação de cadastro de franquia")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/topo.jpg", "topo", "common/email/img/topo.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/rodape.jpg", "rodape", "common/email/img/rodape.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/esq.jpg", "esq", "common/email/img/esq.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/dir.jpg", "dir", "common/email/img/dir.jpg")
->addEmbeddedImage(APPLICATION_PATH . "/../common/email/img/tribo-urbana.jpg", "tribo-urbana", "common/email/img/tribo-urbana.jpg")
->setReplyTo($config->avadora->email->default->email, $config->avadora->email->default->nome)
->setBodyHtml($contents)
->send();
 
// Exibe a mensagem
$messages->success = "Cadastro efetuado com sucesso.";
 
// Redireciona para a página de pendências
$this->_redirect($_SERVER['HTTP_REFERER']);

?>