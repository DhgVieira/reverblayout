<?php

/**
*
*/
class ReverbcycleController extends Zend_Controller_Action {
	/**
	 *
	 */
	public function init() {
	/* Initialize action controller here */
	$captcha = new Zend_Captcha_Image(); // Este é o nome da classe, no secrets...
              $captcha->setWordlen( 3 ) // quantidade de letras, tente inserir outros valores
                      ->setImgDir( APPLICATION_PATH. '/../arquivos/uploads/captcha')// o caminho para armazenar as imagens
                      ->setGcFreq(10)//especifica a cada quantas vezes o garbage collector vai rodar para eliminar as imagens inválidas
                      ->setExpiration(500)// tempo de expiração em segundos.
                      ->setHeight(80) // tamanho da imagem de captcha
                      ->setWidth(130)// largura da imagem
                      ->setLineNoiseLevel(1) // o nivel das linhas, quanto maior, mais dificil fica a leitura
                      ->setDotNoiseLevel(1)// nivel dos pontos, experimente valores maiores
                      ->setFontSize(15)//tamanho da fonte em pixels
                      ->setFont(APPLICATION_PATH. '/../arquivos/default/fonts/andes-regular.ttf'); // caminho para a fonte a ser usada
              $this->view->idCaptcha = $captcha->generate(); // passamos aqui o id do captcha para a view
              $this->view->captcha = $captcha->render( $this->view ); // e o proprio captcha para a view

        $this->view->title = "Reverbcycle - A vida é uma troca";
		$this->view->description = "Tudo nessa vida pode ser reaproveitado!";
		$this->view->keywords = "Reverbcity, reverbcycle, sustentabilidade";

		date_default_timezone_set('America/Sao_Paulo');

	}

	/**
	 * action responsavel por listar os cycles
	 */
	public function indexAction() {

		//inicio o model de categorias do cycle
		$model_categoria = new Default_Model_Reverbcyclecategorias();
		//crio a query
		$select_categoria = $model_categoria->select()
		//ordeno pela descrição
						->order("DS_CATEGORIA_RVRC ASC");
		//assino ao view
		$this->view->categorias = $model_categoria->fetchAll($select_categoria);


		//iniciei o model de cycle
		$model_cycle = new Default_Model_Reverbcycle();
		//crio a query
		$select_cycle = $model_cycle->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('reverbcycle', array("NR_SEQ_REVERBCYCLE_RCRC",
									  "DS_OBJETO_RCRC",
									  "NR_SEQ_CADASTRO_RCRC",
									  "NR_SEQ_CATEGREV_RCRC",
									  "DS_EXT_RCRC",
									  "DT_CADASTRO_RCRC",
									  "NR_VIEWS_RCRC",
									  "ST_CYCLE_RCRC",
										"ST_CLIENTE_RCRC",
									  //crio uma subquery para contar o numero de comentarios
									  "total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_CRRC)
																AS total_comentatios
															FROM
															    reverbcycle_coments
															WHERE
															    NR_SEQ_REVERBCYCLE_RCRC = NR_SEQ_REVERBCYCLE_CRRC)"))
			//crio o inner join das pessoas
			->joinLeft('cadastros',
					'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',array('DS_NOME_CASO',
																							   'NR_SEQ_CADASTRO_CASO'))
            ->where('ST_CYCLE_RCRC = "A"');

		//recebo a categoria
		$idcategoria = $this->_request->getParam("idcategoria",0);
		//se existir categoria faz a busca
		if ($idcategoria > 0) {
			//faz busca por categoria
			$select_cycle->where("NR_SEQ_CATEGREV_RCRC = $idcategoria");
		}

		//ordeno pela data de envio
		$select_cycle->order("reverbcycle.NR_SEQ_REVERBCYCLE_RCRC DESC");


		// crio a paginação para proximo e para anterior
		$paginator = new Reverb_Paginator($select_cycle);
		//defino a quantidade de itens por pagina
		$paginator->setItemCountPerPage(11)
		//defino a quantidade de paginas
		->setPageRange(5)
		//recebo o numero da pagina
		->setCurrentPageNumber($this->_getParam('page', 1));
		//atribuo ovalor a variavel
		$pages = $paginator->getPages();
		//crio o array de paginas
		$pageArray = get_object_vars($pages);
		//assino
		$this->view->assign('pages', $pageArray);

	// crio paginacao com numeros
		$current_page = $this->_request->getParam("page", 1);
		//passo para o paginador o select de produtos
		$contador = new Reverb_Paginator($select_cycle);
		//defino o numero de itens a serem exibidos por página
		$contador->setItemCountPerPage(11)
		//pega o numero da pagina
		->setCurrentPageNumber($current_page)
		//defino quantas páginas iram aparecer por vez
		->setPageRange(5)
		//assino a paginacao
		->assign();
		//assino ao view
		$this->view->contadores = $contador;


		//inicio o model de banners
		$model_banner = new Default_Model_Banners();
		//crio o dia e hora atual
		$dia_hora = date("Y-m-d H:i:s");
		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_agendado_topo = $model_banner->select()
							->where("NR_SEQ_LOCAL_BARC = 87")
							->where("ST_BANNER_BARC = 'A'")
							->where("ST_AGENDAMENTO_BARC = 1")
							->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
							->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$agendados_topo = $model_banner->fetchAll($select_agendado_topo)->toArray();

		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_normais_topo = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 87")
								->where("ST_BANNER_BARC = 'A'")
								->where("ST_AGENDAMENTO_BARC = 0")
								->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$normais_topo = $model_banner->fetchAll($select_normais_topo)->toArray();
		//junto os 2 tipos de banners em um só array
		$banners_topo = array_merge($agendados_topo ,$normais_topo);

		//Assino ao view
		$this->view->banners = $banners_topo;

		//assino a categoria ao view
		$this->view->idcategoria = $idcategoria;
//		$this->view->headLink()->appendStylesheet('/arquivos/default/css/reverbcycle.css');
		$this->view->headScript()
			->appendFile(
				'https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js', 'text/javascript'
			)->appendFile(
				'https://cdnjs.cloudflare.com/ajax/libs/jquery-infinitescroll/2.1.0/jquery.infinitescroll.min.js',
				'text/javascript')
			->appendFile(
				'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.0.4/jquery.imagesloaded.min.js'
			)->appendFile(
				'/arquivos/default/js/cycle.js', 'text/javascript'
			);
	}

	public function ajaxcycleAction(){
		$this->_helper->layout()->disableLayout();
		//inicio o model de categorias do cycle
		$model_categoria = new Default_Model_Reverbcyclecategorias();
		//crio a query
		$select_categoria = $model_categoria->select()
			//ordeno pela descrição
			->order("DS_CATEGORIA_RVRC ASC");
		//assino ao view
		$this->view->categorias = $model_categoria->fetchAll($select_categoria);


		//iniciei o model de cycle
		$model_cycle = new Default_Model_Reverbcycle();
		//crio a query
		$select_cycle = $model_cycle->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('reverbcycle', array("NR_SEQ_REVERBCYCLE_RCRC",
				"DS_OBJETO_RCRC",
				"NR_SEQ_CADASTRO_RCRC",
				"NR_SEQ_CATEGREV_RCRC",
				"DS_EXT_RCRC",
				"DT_CADASTRO_RCRC",
				"NR_VIEWS_RCRC",
				"ST_CYCLE_RCRC",
				"ST_CLIENTE_RCRC",
				//crio uma subquery para contar o numero de comentarios
				"total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_CRRC)
																AS total_comentatios
															FROM
															    reverbcycle_coments
															WHERE
															    NR_SEQ_REVERBCYCLE_RCRC = NR_SEQ_REVERBCYCLE_CRRC)"))
			//crio o inner join das pessoas
			->joinLeft('cadastros',
				'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',array('DS_NOME_CASO',
					'NR_SEQ_CADASTRO_CASO'))
			->where('ST_CYCLE_RCRC = "A"');

		//recebo a categoria
		$idcategoria = $this->_request->getParam("idcategoria",0);
		//se existir categoria faz a busca
		if ($idcategoria > 0) {
			//faz busca por categoria
			$select_cycle->where("NR_SEQ_CATEGREV_RCRC = $idcategoria");
		}

		//ordeno pela data de envio
		$select_cycle->order("reverbcycle.NR_SEQ_REVERBCYCLE_RCRC DESC");


		// crio a paginação para proximo e para anterior
		$paginator = new Reverb_Paginator($select_cycle);
		//defino a quantidade de itens por pagina
		$paginator->setItemCountPerPage(11)
			//defino a quantidade de paginas
			->setPageRange(5)
			//recebo o numero da pagina
			->setCurrentPageNumber($this->_getParam('page', 1));
		//atribuo ovalor a variavel
		$pages = $paginator->getPages();
		//crio o array de paginas
		$pageArray = get_object_vars($pages);
		//assino
		$this->view->assign('pages', $pageArray);

		// crio paginacao com numeros
		$current_page = $this->_request->getParam("page", 1);
		//passo para o paginador o select de produtos
		$contador = new Reverb_Paginator($select_cycle);
		//defino o numero de itens a serem exibidos por página
		$contador->setItemCountPerPage(11)
			//pega o numero da pagina
			->setCurrentPageNumber($current_page)
			//defino quantas páginas iram aparecer por vez
			->setPageRange(5)
			//assino a paginacao
			->assign();
		//assino ao view
		$this->view->contadores = $contador;


	}
	/**
	* funcao responsavel por detalhar o cycle escolhido
	*/

	public function detalhecycleAction(){
		//inicio a sessao e verifico se o usuário ja esta logado
		$usuarios = new Zend_Session_Namespace("usuarios");
		// Cria a sessão das mensagens
		$session = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o id do cycle selecionado
			$idcycle = $this->_request->getparam("idcycle");

			//iniciei o model de cycle
			$model_cycle = new Default_Model_Reverbcycle();
			//crio a query
			$select_cycle = $model_cycle->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('reverbcycle')
			//crio o inner join das categorias
			->joinInner('reverbcycle_categorias',
					'reverbcycle.NR_SEQ_CATEGREV_RCRC = reverbcycle_categorias.NR_SEQ_CATEGREV_RVRC',array('*'))
			//faco a condicao de acordo com o que o usuario escolheu
			->where('reverbcycle.NR_SEQ_REVERBCYCLE_RCRC = ?', $idcycle);

		$cycle = $model_cycle->fetchRow($select_cycle);
		//assino ao view
		$this->view->cycle = $cycle;

		//inicio a sessao de produtos do cycle vistos
		$cycle_vistos = new Zend_Session_Namespace("cycle");
		//recebo os parametros do cycle
		$nome = $cycle['DS_OBJETO_RCRC'];
		$extensao_imagem = $cycle["DS_EXT_RCRC"];
		//agora alimento a sessao com os dados
		$cycle_vistos->cycles[$idcycle] = array(
				'codigo' => $idcycle,
				'nome'          => $nome,
				'path'   => $extensao_imagem,
				'hora' => date("H:i:s")
		);

		//assino ao view os vistos
		$this->view->cycles = $cycle_vistos->cycles;

		//query de sugestoes
		$select_sugestoes = $model_cycle->select()
							->from("reverbcycle", array("DS_OBJETO_RCRC", "DS_EXT_RCRC", "NR_SEQ_REVERBCYCLE_RCRC"))
							->where("NR_SEQ_CATEGREV_RCRC =  $cycle->NR_SEQ_CATEGREV_RCRC")
							->order("RAND()")
							->limit(4);


		//assino ao view as sugestoes
		$this->view->sugestoes = $model_cycle->fetchAll($select_sugestoes);

		$db = Zend_Registry::get("db");
		//crio a query para selecionar os comentarios
		$select_comentarios = "SELECT
    								`cadastros`.`DS_NOME_CASO`,
    								`cadastros`.`NR_SEQ_CADASTRO_CASO`,
   								 	`reverbcycle_coments` . *
								FROM
									reverbcycle_coments
  								inner join
								cadastros on cadastros.NR_SEQ_CADASTRO_CASO =reverbcycle_coments.NR_SEQ_CADASTRO_CRRC
								WHERE reverbcycle_coments.NR_SEQ_REVERBCYCLE_CRRC = $idcycle
								AND comentario_id is null
								ORDER BY
									NR_SEQ_COMENTARIO_CRRC
								DESC";
			// Monta a query
		$query = $db->query($select_comentarios);
		//crio uma lista de comentarios
		$lista = $query->fetchAll();
		//assino os comentarios ao view
		$this->view->comentarios = $lista;

		//assino o nome do usuario
		$this->view->nomeusuario = $usuarios->nome;
		$this->view->idusuario = $usuarios->idperfil;
		$this->view->idcycle = $idcycle;


		//inicio o model de banners
		$model_banner = new Default_Model_Banners();
		//crio o dia e hora atual
		$dia_hora = date("Y-m-d H:i:s");
		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_agendado_topo = $model_banner->select()
							->where("NR_SEQ_LOCAL_BARC = 87")
							->where("ST_BANNER_BARC = 'A'")
							->where("ST_AGENDAMENTO_BARC = 1")
							->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
							->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$agendados_topo = $model_banner->fetchAll($select_agendado_topo)->toArray();

		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_normais_topo = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 87")
								->where("ST_BANNER_BARC = 'A'")
								->where("ST_AGENDAMENTO_BARC = 0")
								->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$normais_topo = $model_banner->fetchAll($select_normais_topo)->toArray();
		//junto os 2 tipos de banners em um só array
		$banners_topo = array_merge($agendados_topo ,$normais_topo);

		//Assino ao view
		$this->view->banners = $banners_topo;

		//inicio o model de categorias do cycle
		$model_categoria = new Default_Model_Reverbcyclecategorias();
		//crio a query
		$select_categoria = $model_categoria->select()
		//ordeno pela descrição
						->order("DS_CATEGORIA_RVRC ASC");
		//assino ao view
		$this->view->categorias = $model_categoria->fetchAll($select_categoria);

		//vejo o numero de views
		$nr_views = $cycle->NR_VIEWS_RCRC;


		$total_views = $nr_views + 1;

		$data_views = array("NR_VIEWS_RCRC" => $total_views);
		//atualizo o numero de views
		$model_cycle->update($data_views, "NR_SEQ_REVERBCYCLE_RCRC = $idcycle");

		//inicio as tags
		$model_tags = new Default_Model_Reverbcycletags();

		//inicio a query para trazer as tags
		$select_tag = $model_tags->select()->where("idcycle = ?", $idcycle);

		//assino ao view as tags
		$this->view->tags = $model_tags->fetchAll($select_tag);



		}else{
			// Envio um feedback de sucesso ao usuário.
			$session->error = "Para vizualizar esta página você deve estar logado!";
			//redireciono para a ultima pagina
			$this->_redirect("/reverbme");
		}
	}

	/**
	* funcao responsavel por incluir um comentario no cycle
	*/

	public function cyclecontatoAction(){
		//inicio a sessao e verifico se o usuário ja esta logado
		$usuarios = new Zend_Session_Namespace("usuarios");
		// Cria a sessão das mensagens
		$session = new Zend_Session_Namespace("messages");
		//se for post ele insere os comentarios
		if ($this->_request->isPost()) {
                    //inicio o adaptador do banco
                    $db = Zend_Registry::get("db");
                    //recebo os campos
                    $idusuario = $usuarios->idperfil;
                    //recebo a mensagem do post
                    $mensagem = $this->_request->getparam("mensagem");
                    $comentario_id = $this->_request->getParam('idmensagem', null);
                    $idcycle = $this->_request->getparam("idcycle");
                    $status = "I";
                    //crio  a data atual
                    $data_hora = date('d-m-Y');
                    $data_hora .= ' '.date('H:i:s');

                    if($comentario_id){
                        $selectMensagem = "SELECT c.ds_nome_caso AS nome, c.ds_email_caso AS email FROM reverbcycle_coments INNER JOIN cadastros c ON c.nr_seq_cadastro_caso = NR_SEQ_CADASTRO_CRRC WHERE NR_SEQ_COMENTARIO_CRRC = '".$comentario_id."'";
                        $query = $db->query($selectMensagem);
                        $dadosMensagem = $query->fetchAll();

                        $mensagem = "<tr>
									<td width=\"283\" colspan='9' height=\"277\" style=\"color: #646464; background-color: #dcddde; font-size: 12px; font-family: Verdana\">
										<p width=\"243\" style=\"margin-top:-90px; margin-left:22px;\">
											Olá <b>". $dadosMensagem[0]['nome'] ."</b>!<br><br>

											".$usuarios->nome." respondeu seu comentário, clique <a href=".$_SERVER['HTTP_REFERER'].">aqui</a> para visualizar.

										</p>
									</td>
								</tr>
								<tr>
									<td colspan=\"9\">

									</td>
								</tr>";

                        // Busca o conteudo do topo e do rodape
                        $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_indicacao.html");
                        $topo = str_replace('Indicação de Seu Amigo', 'NOVO COMENTÁRIO', $topo);

                        $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_indicacao.html");
                        //crio o corpo á ser enviado para o cliente
                        $body .= $topo;
                        $body .= $mensagem;
                        $body .= $rodape;

                        $config = array(
                            'auth' => 'login',
                            'username' => "atendimento@reverbcity.com",
                            'password' => "ramones@334",
                            'ssl' => "tls", # default ("ssl")
                            'port' => "587" # default ("25")
                        );

                        $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                        $emailAdm = "atendimento@reverbcity.com";
                        $mail = new Zend_Mail('UTF-8');
                        $mail->setBodyHtml($body);
                        $mail->addTo($dadosMensagem[0]['email'], $dadosMensagem[0]['nome']);
                        $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                        $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                        $mail->setSubject("Novo Comentário no ReverbCycle");
                        $mail->send($mailTransport);
                    }

                    //crio um array para inserir os valores no banco de dados
                    $data = array('NR_SEQ_CADASTRO_CRRC' => $idusuario,
                                              'NR_SEQ_REVERBCYCLE_CRRC' => $idcycle,
                                              'DS_STATUS_CRRC' => $status,
                                              'DS_TEXTO_CRRC' => $this->_request->getparam("mensagem"),
                                              'comentario_id' => $comentario_id);
                    //insiro o registro
                    $db->insert("reverbcycle_coments", $data);
                    
                    $model_cycle = new Default_Model_Reverbcycle();
                    $dados_cycle = $model_cycle->fetchRow(array('NR_SEQ_REVERBCYCLE_RCRC = ?' => $idcycle));
                    
                    //inicio o array para as informações da mensagem
                    $data_mensagem = array ("NR_SEQ_CADASTRO_SBRC" => $dados_cycle->NR_SEQ_CADASTRO_RCRC,
                                                "NR_SEQ_AUTOR_SBRC" => $usuarios->idperfil,
                                                "DS_POST_SBRC" => $this->_request->getparam("mensagem"),
                                                "ST_POST_SBRC" => "A",
                                                "ST_PUBLICO_SBRC" => 1);
                    
                    $model_scraps = new Default_Model_Mescraps();
                    $model_scraps->insert($data_mensagem);
                    
                    //inicio o model para pegar o email de quem irá receber a mensagem
                    $model_perfil = new Default_Model_Reverbme();
                    //crio a query
                    $select_email = $model_perfil->select()
                        ->setIntegrityCheck(false)
                        ->from('cadastros', array('DS_EMAIL_CASO', "DS_NOME_CASO"))
                        ->where("NR_SEQ_CADASTRO_CASO = ?", $dados_cycle->NR_SEQ_CADASTRO_RCRC);

                    //armazeno as informações do amigo na variavel
                    $info_amigo = $model_perfil->fetchRow($select_email);

                    //crio a mensagem
                    $mensagem = "<tr>
                                        <td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
                                                NOVO RECADO
                                        </td>
                                </tr>
                                <tr>
                                        <td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
                                                </br></br>
                                                Olá, <b>". $info_amigo["DS_NOME_CASO"] .",</b></br></br>

                                                Você acaba de receber uma nova mensagem ReverbCycle.

                                                Para acessar visualizar acesse o link abaixo:!</br>
                                                </br>

                                        </td>
                                </tr>
                                <tr>
                                        <td colspan=\"6\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
                                                <b><a href=\"https://www.reverbcity.com/cycle-detalhe/{$this->view->createslug($dados_cycle->DS_OBJETO_RCRC)}/{$dados_cycle->NR_SEQ_REVERBCYCLE_RCRC}\" style=\"text-decoration:none;color: #646464; font-size: 12px;\">Ir para ReverbCycle </a></b>
                                        </td>
                                </tr>";

                    // Busca o conteudo do topo e do rodape
                    $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_padrao.html");

                    $rodape  = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_padrao.html");
                    //crio o corpo á ser enviado para o cliente
                    $body .= $topo;
                    $body .= $mensagem;
                    $body .= $rodape;

                    $config = array (
                        'auth' => 'login',
                        'username' =>     "atendimento@reverbcity.com",
                        'password' =>     "ramones@334",
                        'ssl' =>          "tls", # default ("ssl")
                        'port' =>         "587" # default ("25")
                    );
                     $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com",$config);

                    $emailAdm = "atendimento@reverbcity.com";
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setBodyHtml($body,'UTF-8');
                    $mail->addTo($info_amigo['DS_EMAIL_CASO'], "Reverbcity - A Música que veste");
					$mail->addBcc('atendimento@reverbcity.com');
                    $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                    $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                    $mail->setSubject("Você recebeu uma mensagem");
                    $mail->send($mailTransport);
                    
                    // Envio um feedback de sucesso ao usuário.
                    $session->success = "Seu comentário foi inserido com sucesso!";
                    //redireciono para a ultima página
                    $this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}
	//ação responsável por cadastrar o cyle
	public function cadastrocycleAction(){
		//inicio a sessao e verifico se o usuário ja esta logado
		$usuarios = new Zend_Session_Namespace("usuarios");
		// Cria a sessão das mensagens
		$session = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado != TRUE) {
			// Envio um feedback de sucesso ao usuário.
			$session->error = "Para incluir um item você deverá esta logado";
			//redireciono para a ultima página
			//redireciono para a ultima pagina
			$this->_redirect("/reverbme");
			//se estiver logado faz o cadastro
		}else{
			//se for post
			if ($this->_request->isPost()) {
				try{
					//recebo os parametros
					$titulo = $this->_request->getparam("objeto");
					$categoria = $this->_request->getparam("categoria");
					$descricao = $this->_request->getparam("descricao");
					$contatos = $this->_request->getparam("contatos");
					$idusuario = $usuarios->idperfil;
					$email = $usuarios->email;


					//inicio o model cycle
					$model_cycle = new Default_Model_Reverbcycle();

					//se o usuário nâo informou a forma de contato pego o email do cadastro
					if($contatos == ""){
						$contatos = $email;
					}
					//crio o array com os dados recebido
					$data = array('DS_OBJETO_RCRC' => $titulo,
						'NR_SEQ_CATEGREV_RCRC' => $categoria,
						'DS_CARACTERISTICAS_RCRC' => $descricao,
						'DS_DADOSCONTATO_RCRC' => $contatos,
						'NR_SEQ_CADASTRO_RCRC' => $idusuario,
						'ST_CYCLE_RCRC' => 'A',
						'ST_CLIENTE_RCRC' => 'A',
						'DT_CADASTRO_RCRC' => date('Y-m-d H:i:s'));
					//insiro os registros e pego o ID
					$id_registro = $model_cycle->insert($data);

					//faço o upload daa imagem de destaque
					if ($_FILES['imagem']['tmp_name'] != ""){

						$extensao =  explode(".", $_FILES['imagem']['name']);

						//agora pego a extensao real
						$ext = $extensao[1];
						//cria o nome para  a foto
						$filename = $id_registro .".". $ext;
						//atribuo o valor do nome
						$data_img['DS_EXT_RCRC'] = $ext;

						// Move o arquivo para o diretório
						move_uploaded_file($_FILES['imagem']['tmp_name'], APPLICATION_PATH . "/../arquivos/uploads/reverbcycle/" . $filename);
					}

					//faço o upload daa imagem secundaria
					if ($_FILES['imagem1']['tmp_name'] != ""){

						$extensao =  explode(".", $_FILES['imagem']['name']);

						//agora pego a extensao real
						$ext = $extensao[1];
						//cria o nome para  a foto
						$filename = md5(time() . rand(1000, 9999)) . "." . $ext;
						//atribuo o valor do nome
						$data_img['IMG_1_RCRC'] = $filename;

						// Move o arquivo para o diretório
						move_uploaded_file($_FILES['imagem1']['tmp_name'], APPLICATION_PATH . "/../arquivos/uploads/reverbcycle/" . $filename);
					}

					//faço o upload daa imagem terciaria
					if ($_FILES['imagem2']['tmp_name'] != ""){
						$extensao =  explode(".", $_FILES['imagem']['name']);

						//agora pego a extensao real
						$ext = $extensao[1];
						//cria o nome para  a foto
						$filename = md5(time() . rand(1000, 9999)) . "." . $ext;
						//atribuo o valor do nome
						$data_img['IMG_2_RCRC'] = $filename;

						// Move o arquivo para o diretório
						move_uploaded_file($_FILES['imagem2']['tmp_name'], APPLICATION_PATH . "/../arquivos/uploads/reverbcycle/" . $filename);
					}

					//atualizo com extenção do arquivo
					$model_cycle->update($data_img, "NR_SEQ_REVERBCYCLE_RCRC = $id_registro");

					//agora pego as tags informadas
					$tags = $this->_request->getParam("tags");
					//agora explodo as tags por virgula
					$tag = explode(",", $tags);

					//inicio o model de tags
					$model_tag = new Default_Model_Reverbcycletags();
					//inicio um array de tag
					$data_tag = array();
					//agora para cada tag eu insiro no banco
					foreach ($tag as $key => $tg) {
						$data_tag[$key]["idcycle"] = $id_registro;
						$data_tag[$key]["tag"] = $tg;
						//agora insiro
						$model_tag->insert($data_tag[$key]);
					}

					// Envio um feedback de sucesso ao usuário.
					$session->success = "Seu item foi inserido com sucesso!";
					//redireciono para a ultima página
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}catch (Exception $e){
					die($e->getMessage());
				}
			}
		}
	}

	//função responsável por fechar negocio
	public function fecharnegocioAction(){

		//inicio a sessao e verifico se o usuário ja esta logado
		$usuarios = new Zend_Session_Namespace("usuarios");
		// Cria a sessão das mensagens
		$session = new Zend_Session_Namespace("messages");

		//recebo os parametros
		$idcycle = $this->_request->getParam("idcycle");

		$status = $this->_request->getParam("status");
		//se o status for como A (ativo) se torna I (vendido)
		if ($status == 'A') {
			$status = 'I';
			//senao vira A (aberto)
		}else{
			$status = 'A';
		}
		//inicio o model do cycle
		$model_cycle = new Default_Model_Reverbcycle();

		//crio o array
		$data['ST_CYCLE_RCRC'] = $status;
		//altero o status para fechado ou aberto
		$model_cycle->update($data, "NR_SEQ_REVERBCYCLE_RCRC = $idcycle");

		//retorno a mensagem para o usuario de acordo com o status
		if ($status == 'A') {
			// Envio um feedback de sucesso ao usuário.
				$session->success = "Seu item foi reaberto com sucesso!";
				//redireciono para a ultima página
				$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{
			// Envio um feedback de sucesso ao usuário.
				$session->success = "Seu item foi fechado com sucesso!";
				//redireciono para a ultima página
				$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}
        
        public function apagarComentarioAction(){
            
            //desabilito o layout
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            //inicio a sessao de mensagem
            $messages = new Zend_Session_Namespace("messages");
            //inicio o model de mensagem
            $model_mensagens = new Default_Model_Produtoscoments();
            //inicio a sessao de usuários
            $usuarios = new Zend_Session_Namespace("usuarios");

            $idcomentario = $this->_request->getParam('idcomentario');

            try{
                //verifico se o usuario esta logado
                if($usuarios->logado == true){
                    if($usuarios == 2 || $usuarios == 4162 || $usuarios == 22652){
                        $model = new Default_Model_Reverbcyclecoments();
                        $model->update(array('DS_STATUS_CRRC' => 'I'), array('NR_SEQ_COMENTARIO_CRRC = ?' => $idcomentario));
                    }
                }

                $messages->success = "Comentário inativado com sucesso.";
            } catch (Exception $ex) {
                $messages->error = "Ocorreu um erro ao inativar o comentário.";
            }

            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
}

