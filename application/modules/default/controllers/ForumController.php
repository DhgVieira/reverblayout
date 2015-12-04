<?php

/**
*
*/
class ForumController extends Zend_Controller_Action {
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

        $this->view->title = "Forum - Reverbcity.com";
		$this->view->description = "Quer saber o que o pessoal do rock acha da sua opinião? crie um forum ou uma enquete!";
		$this->view->keywords = "Reverbcity, forum, musica, comunidade, novidades, topicos";
	}


	/**
	 *
	 */
	public function indexAction() {

		//inicio o model de forum
		$model_forum = new Default_Model_Topicos();

		$palavra = $this->_request->getparam("busca");



		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//crio a query de forum
		$select_ultimo_forum = $model_forum->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('topicos')
			//crio o inner join das pessoas
			->joinInner('cadastros',
					'topicos.NR_SEQ_CADASTRO_TOSO = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO',
																						  'DS_NOME_CASO',
																						  'DS_EXT_CACH'))
			//ordeno pela data de envio
			->order("topicos.DT_CADASTRO_TOSO DESC")
			//limito a 14 registros
			->limit(1);



			//assino ao view
			$this->view->ultimo_topico = $model_forum->fetchRow($select_ultimo_forum);

			//crio a query de forum
		$select_hot_forum = $model_forum->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('topicos')
			//crio o inner join das pessoas
			->joinInner('cadastros',
					'topicos.NR_SEQ_CADASTRO_TOSO = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO',
																						  'DS_NOME_CASO',
																						  'DS_EXT_CACH'))
			//ordeno pela data de envio
			->order("topicos.NR_MSGS_TOSO DESC")
			//limito a 14 registros
			->limit(1);


			//assino ao view
			$this->view->hot_topico = $model_forum->fetchRow($select_hot_forum);


		//crio a query de topicos em destaque
		$select_forum_destaque = $model_forum->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('topicos')
			//crio o inner join das pessoas
			->joinInner('cadastros',
					'topicos.NR_SEQ_CADASTRO_TOSO = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO',
																						  'DS_NOME_CASO',
																						  'DS_EXT_CACH'))
			//ordeno pela data de envio
			->order("topicos.DT_ULTIMOPOST_TOSO DESC")
			//limito a 14 registros
			->limit(2);
			//assino ao view

			$this->view->topicos_destaque = $model_forum->fetchAll($select_forum_destaque);


		//crio a query de forum
		$select_forum = $model_forum->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('topicos')
			//crio o inner join das pessoas
			->joinInner('cadastros',
					'topicos.NR_SEQ_CADASTRO_TOSO = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO',
																						  'DS_NOME_CASO',
																						  'DS_EXT_CACH'));
			if($palavra != ""){
				$select_forum->where("DS_TOPICO_TOSO like '%".$palavra."%'");
			}
			//ordeno pela data de envio
			$select_forum->order("topicos.DT_ULTIMOPOST_TOSO DESC")
			//limito a 14 registros
			->limit(14);


			//assino ao view
			$this->view->topicos = $model_forum->fetchAll($select_forum);

			
			//inicio o modulo das enquetes
			$model_enquete = new Default_Model_Enquetes();


			//inicio a query da enquete mais nova
			$select_enquete_nova = $model_enquete->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				->from('enquetes', array('idenquete',
										 'titulo_enquete',
										 'idautor',
										 'data_inicio',
										 'total_votos' => "(SELECT
										 						SUM(quantidade_votos)
										 					AS
										 						total_votos
										 					FROM
										 						enquetes_opcoes
										 					WHERE
										 						enquetes.idenquete = enquetes_opcoes.idenquete)"))
				->joinLeft('cadastros',
							'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO','NR_SEQ_CADASTRO_CASO'))
				->order("data_inicio DESC")
				->limit(1);

				//assino ao view
				$nova_enquete = $model_enquete->fetchRow($select_enquete_nova);
				$this->view->nova_enquete = $nova_enquete;

				//inicio a query da enquete mais nova
				$select_enquete_hot = $model_enquete->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				->from('enquetes', array('idenquete',
										 'titulo_enquete',
										 'idautor',
										 'data_inicio',
										 'total_votos' => "(SELECT
										 						SUM(quantidade_votos)
										 					AS
										 						total_votos
										 					FROM
										 						enquetes_opcoes
										 					WHERE
										 						enquetes.idenquete = enquetes_opcoes.idenquete)"))
				->joinInner('cadastros',
							'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO','NR_SEQ_CADASTRO_CASO'))
				->order("total_votos DESC")
				->limit(2);
				
					//crio agora a lista das 2 mais votadas no topo
				$this->view->enquetes_hot = $model_enquete->fetchAll($select_enquete_hot);

				//assino ao view a enquete com ponto vermelho
				$hot_enquete = $model_enquete->fetchRow($select_enquete_hot);
				$this->view->hot_enquete = $hot_enquete;

				//recebo o parametro para buscar a enquete
				$palavra_enquete = $this->_request->getparam("busca_enquete");

				//inicio a query
				$select_enquete = $model_enquete->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				->from('enquetes', array('idenquete',
										 'titulo_enquete',
										 'idautor',
										 'data_inicio',
										 'total_votos' => "(SELECT
										 						SUM(quantidade_votos)
										 					AS
										 						total_votos
										 					FROM
										 						enquetes_opcoes
										 					WHERE
										 						enquetes.idenquete = enquetes_opcoes.idenquete)"))
				->joinInner('cadastros',
							'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO','NR_SEQ_CADASTRO_CASO'))
				->where("idenquete not in (".$hot_enquete->idenquete .",". $nova_enquete->idenquete .")");
				if ($palavra_enquete != "") {
					$select_enquete->where("titulo_enquete LIKE '%". $palavra_enquete ."%'");
				}
				$select_enquete->order("data_inicio DESC");

				//assino ao view
				$this->view->enquetes = $model_enquete->fetchAll($select_enquete);

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


			//agora pego o id do usuário logado
			$idusuario = $usuarios->idperfil;

			$this->view->idusuario = $idusuario;

		$this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/jquery-timeago/jquery.timeago.js');
		$this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/tinymce.min.js');


	}

	/**
	 * funcao responsavel por detalhar o forum
	 */
	public function detalheforumAction() {
		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//recebo o id do topico
		$idtopico = $this->_request->getparam("idforum");

		//inicio o model do forum
		$model_topico = new Default_Model_Topicos();
		//inicio a query
		$select_topicos = $model_topico->select()
		//seleciono somente os ativos
						->where("NR_SEQ_TOPICO_TOSO = ?", $idtopico)
						->where("ST_TOPICO_TOSO = 'A'");


		//assino ao view
		$this->view->topico = $model_topico->fetchRow($select_topicos);

		//inicio o model de mensagens
		$model_mensagens = new Default_Model_Mensagens();
		//crio a query
		$select_mensagens = $model_mensagens->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('msgs', array('NR_SEQ_MSG_MESO',
								 'NR_SEQ_TOPICO_MESO',
								 'NR_SEQ_CADASTRO_CASO',
								 'DT_CADASTRO_MESO',
								 'ST_MSG_MESO',
								 'DS_MSG_MESO',
								 'DS_IP_MESO',
								 'NR_CURTIRAM_MESO',
								 'NR_NAOCURTIRAM_MESO',
								 'NR_REPLY_MESO'))

			//crio o inner join das pessoas
			->joinInner('cadastros',
					'msgs.NR_SEQ_CADASTRO_CASO = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO', 'DS_NOME_CASO', 'DS_EXT_CACH'))
			->where("msgs.NR_SEQ_TOPICO_MESO = ?", $idtopico)
			->where("NR_REPLY_MESO is NULL")
			//ordeno pela data de envio
			->order("msgs.DT_CADASTRO_MESO DESC")
			->group("msgs.NR_SEQ_MSG_MESO");


			$lista_comentarios = $model_mensagens->fetchAll($select_mensagens);
			//crio o objeto de conexao com o banco externo
			// $db = Zend_Registry::get('db');
			// //agora vou contar as respostas
			// foreach ($lista_comentarios as $key => $comentario) {

				
				
			// 	$select_total_comentarios = "SELECT
			// 									NR_SEQ_MSG_MESO, 										
			// 									DS_NOME_CASO,
			// 									NR_CURTIRAM_MESO,
			// 									NR_NAOCURTIRAM_MESO,
			// 									DS_MSG_MESO,
			// 									DT_CADASTRO_MESO,
			// 									COUNT(NR_SEQ_MSG_MESO)
			// 								AS 
			// 									total_comentarios 
			// 								FROM 
			// 									msgs
			// 								INNER JOIN 
			// 									cadastros 
			// 								ON 
			// 									cadastros.NR_SEQ_CADASTRO_CASO = msgs.NR_SEQ_CADASTRO_CASO 
			// 								WHERE 
			// 									NR_REPLY_MESO = ". $comentario["NR_SEQ_MSG_MESO"];

			// 	$query_coments = $db->query($select_total_comentarios);
			// 	//crio uma lista de comentario
			// 	$total_comentarios_resp = $query_coments->fetchAll();

			// 	if($total_comentarios_resp[0]["total_comentarios"] > 0){

			// 		$lista_comentarios[$key]["idresposta"] = $total_comentarios_resp[0]["NR_SEQ_MSG_MESO"];
			// 		$lista_comentarios[$key]["nome_resposta"] = $total_comentarios_resp[0]["DS_NOME_CASO"];
			// 		$lista_comentarios[$key]["curtiram_resposta"] = $total_comentarios_resp[0]["NR_CURTIRAM_MESO"];
			// 		$lista_comentarios[$key]["nao_curtiram_resposta"] = $total_comentarios_resp[0]["NR_NAOCURTIRAM_MESO"];
			// 		$lista_comentarios[$key]["resposta"] = $total_comentarios_resp[0]["DS_MSG_MESO"];
			// 		$lista_comentarios[$key]["data_resposta"] = $total_comentarios_resp[0]["DT_CADASTRO_MESO"];
			// 		$lista_comentarios[$key]["total_comentarios"] = $total_comentarios_resp[0]["total_comentarios"];

			// 	}else{
					
			// 		$lista_comentarios[$key]["total_comentarios"] = $total_comentarios_resp[0]["total_comentarios"];
			// 	}
			// } 

			//assino ao view

			// crio a paginação para proximo e para anterior
			$contador = new Reverb_Paginator($lista_comentarios);

			//defino a quantidade de itens por pagina
			$contador->setItemCountPerPage(9)
			//defino a quantidade de paginas
			->setPageRange(5)
			//recebo o numero da pagina
			->setCurrentPageNumber($this->_getParam('page'));
			//atribuo ovalor a variavel
			$pages = $contador->getPages();
			//crio o array de paginas
			$pageArray = get_object_vars($pages);
			//assino
			$this->view->assign('pages', $pageArray);


		// crio paginacao com numeros
			$current_page = $this->_request->getParam("page", 1);
			//passo para o paginador o select de produtos
			$contador = new Reverb_Paginator($lista_comentarios);
			//defino o numero de itens a serem exibidos por página
			$contador->setItemCountPerPage(9)
			//pega o numero da pagina
			->setCurrentPageNumber($current_page)
			//defino quantas páginas iram aparecer por vez
			->setPageRange(5)
			//assino a paginacao
			->assign();
			//assino ao view

			$this->view->mensagens = $contador;
			// $this->view->mensagens = $model_mensagens->fetchAll($select_mensagens);

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

			//assino ao view o id do usuario logado para poder deletar os comentario
			$this->view->codigo_usuario = $usuarios->idperfil;

            $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/tinymce.min.js');
            $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/langs/pt_BR.js');

	}

	/*
	*
	*/
	public function curtirAction(){
		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");

		//verifico se o usuário esta logado
		if($usuarios->logado == true){
		//inicio o model de mensagem
                    
                        $idmsg = $this->_request->getparam("idmsg");
                    
                        $model_curtiram = new Default_Model_Curtiram();
                        
                        $dadosCurtiram = $model_curtiram->fetchRow(array(
                            'NR_SEQ_CADASTRO_CURC = ?' => $usuarios->idperfil,
                            'NR_SEQ_MSG_CURC = ?' => $idmsg
                        ));
                        
                        if(!$dadosCurtiram){
                            $model_mensagens = new Default_Model_Mensagens();
                            //recupero o id da msg
                            //crio a query para receber a quantidade de curtidas
                            $select = $model_mensagens->select()
                                                    ->from("msgs", array("NR_SEQ_MSG_MESO",
                                                                                    "NR_CURTIRAM_MESO"))
                                                    ->where("NR_SEQ_MSG_MESO = ?", $idmsg);
                            //recebo o resultado da pesquisa
                            $resultado = $model_mensagens->fetchRow($select);
                            //agora cada curtida ganha um ponto
                            $total_curtida = $resultado->NR_CURTIRAM_MESO + 1;

                            $data = array("NR_CURTIRAM_MESO" => $total_curtida);

                            $model_mensagens->update($data,  array("NR_SEQ_MSG_MESO = $idmsg"));
                            
                            $data = array();
                            $data['NR_SEQ_CADASTRO_CURC'] = $usuarios->idperfil;
                            $data['NR_SEQ_MSG_CURC'] = $idmsg;
                            
                            $model_curtiram->insert($data);
                        }

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{

			$mensagem->error = "Você precisa estar logado para curtir um comentário.";

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/*
	*
	*/
	public function naocurtirAction(){

		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");

		$usuarios = new Zend_Session_Namespace("usuarios");

		//verifico se o usuário esta logado
		if($usuarios->logado == true){
                        //recupero o id da msg
			$idmsg = $this->_request->getparam("idmsg");
                    
                        $model_naocurtiram = new Default_Model_Naocurtiram();
                        
                        $dadosCurtiram = $model_naocurtiram->fetchRow(array(
                            'NR_SEQ_CADASTRO_CURC = ?' => $usuarios->idperfil,
                            'NR_SEQ_MSG_CURC' => $idmsg
                        ));
                        
                        if(!$dadosCurtiram){
                            //inicio o model de mensagem
                            $model_mensagens = new Default_Model_Mensagens();

                            //crio a query para receber a quantidade de curtidas
                            $select = $model_mensagens->select()
                                                    ->from("msgs", array("NR_SEQ_MSG_MESO",
                                                                                    "NR_NAOCURTIRAM_MESO"))
                                                    ->where("NR_SEQ_MSG_MESO = ?", $idmsg);
                            //recebo o resultado da pesquisa
                            $resultado = $model_mensagens->fetchRow($select);
                            //agora cada curtida ganha um ponto
                            $total_curtida = $resultado->NR_NAOCURTIRAM_MESO + 1;

                            $data = array("NR_NAOCURTIRAM_MESO" => $total_curtida);

                            $model_mensagens->update($data,  array("NR_SEQ_MSG_MESO = $idmsg"));
                            
                            $data = array();
                            $data['NR_SEQ_CADASTRO_CURC'] = $usuarios->idperfil;
                            $data['NR_SEQ_MSG_CURC'] = $idmsg;
                            
                            $model_naocurtiram->insert($data);
                        }

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{

			$mensagem->error = "Você precisa estar logado para nao curtir um comentário.";

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}


	public function enquetelistaAction() {

		$palavra = $this->_request->getparam("busca");

		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");

		//inicio o modulo das enquetes
		$model_enquete = new Default_Model_Enquetes();


		//inicio a query da enquete mais nova
		$select_enquete_nova = $model_enquete->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			->from('enquetes', array('idenquete',
				'titulo_enquete',
				'idautor',
				'data_inicio',
				'total_votos' => "(SELECT
									SUM(quantidade_votos)
								AS
									total_votos
								FROM
									enquetes_opcoes
								WHERE
									enquetes.idenquete = enquetes_opcoes.idenquete)"))
			->joinLeft('cadastros',
				'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO','NR_SEQ_CADASTRO_CASO'))
			->order("data_inicio DESC")
			->limit(1);

		//assino ao view
		$nova_enquete = $model_enquete->fetchRow($select_enquete_nova);
		$this->view->nova_enquete = $nova_enquete;

		//inicio a query da enquete mais nova
		$select_enquete_hot = $model_enquete->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			->from('enquetes', array('idenquete',
				'titulo_enquete',
				'idautor',
				'data_inicio',
				'total_votos' => "(SELECT
									SUM(quantidade_votos)
								AS
									total_votos
								FROM
									enquetes_opcoes
								WHERE
									enquetes.idenquete = enquetes_opcoes.idenquete)"))
			->joinInner('cadastros',
				'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO','NR_SEQ_CADASTRO_CASO'))
			->order("total_votos DESC")
			->limit(2);

		//crio agora a lista das 2 mais votadas no topo
		$this->view->enquetes_hot = $model_enquete->fetchAll($select_enquete_hot);

		//assino ao view a enquete com ponto vermelho
		$hot_enquete = $model_enquete->fetchRow($select_enquete_hot);
		$this->view->hot_enquete = $hot_enquete;

		//recebo o parametro para buscar a enquete
		$palavra_enquete = $this->_request->getparam("busca_enquete");

		//inicio a query
		$select_enquete = $model_enquete->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			->from('enquetes', array('idenquete',
				'titulo_enquete',
				'idautor',
				'data_inicio',
				'total_votos' => "(SELECT
										SUM(quantidade_votos)
									AS
										total_votos
									FROM
										enquetes_opcoes
									WHERE
										enquetes.idenquete = enquetes_opcoes.idenquete)"))
			->joinInner('cadastros',
				'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO','NR_SEQ_CADASTRO_CASO'))
			->where("idenquete not in (".$hot_enquete->idenquete .",". $nova_enquete->idenquete .")");
		if ($palavra_enquete != "") {
			$select_enquete->where("titulo_enquete LIKE '%". $palavra_enquete ."%'");
		}
		$select_enquete->order("data_inicio DESC");

		//assino ao view
		$this->view->enquetes = $model_enquete->fetchAll($select_enquete);

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


		//agora pego o id do usuário logado
		$idusuario = $usuarios->idperfil;

		$this->view->idusuario = $idusuario;
		$this->view->headLink()->appendStylesheet($this->view->basePath . '/arquivos/application/css/default/forum/index.css');
		$this->view->headLink()->appendStylesheet($this->view->basePath . '/arquivos/application/js/default/forum/index.css');
		$this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/jquery-timeago/jquery.timeago.js');
		$this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/tinymce.min.js');
	}

	/**
	* Função responsavel por criar a enquete
	**/

	public function criarenqueteAction(){

		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//se for um post
			if($this->_request->isPost()){
				//crio o modulo de enquete
				$model_enquete = new Default_Model_Enquetes();
				//recebo os parametros para criar a data de fim
				$data_form = $this->_request->getparam("dataselecionada");


				//explodo data para formatar
				$data_explode = explode("/", $data_form);

				$dia = $data_explode[0];
				$mes = $data_explode[1];
				$ano = $data_explode[2];

				$data_fim = $ano ."-".$mes."-".$dia;

 				//crio o array de enquete
				$data_enquete = array("idautor"=> $usuarios->idperfil,
									  "titulo_enquete" => $this->_request->getparam("assunto"),
									  "descricao" => $this->_request->getparam("descricao"),
									  "permite_multipla" => $this->_request->getparam("radiog_dark"),
									  "data_fim" => $data_fim,
									  "exibe_resultado" => $this->_request->getparam("resultado"),
									  "sem_data_fim" => $this->_request->getparam("datadefinalizacao"));
				//insiro os registros e pego o id
				$idenquete = $model_enquete->insert($data_enquete);

				//inicio o model de alternativas
				$model_alternativas = new Default_Model_Enquetesopcoes();
				//recebo as imagens e as opções
				$fotos = $_FILES["fotos"];

				// var_dump($fotos);die();
				$opcoes = $this->_request->getparam("opcoes");



				//inicio o array de opcoes
				$data_opcao = array();

				foreach ($opcoes as $key => $opcao) {


					//passo os parametros
					$data_opcao["idenquete"] = $idenquete;
					$data_opcao["opcao"] = $opcao;

					if(($_FILES['fotos']['name'][$key]) != ""){
						$filename = md5(time() . rand(1000, 9999)) . ".jpg";
						$data_opcao['imagem_path'] = $filename;
						// Move o arquivo para o diretório
						move_uploaded_file($_FILES['fotos']['tmp_name'][$key], APPLICATION_PATH . "/../arquivos/uploads/enquete/" . $filename);
					}
					// Insere o registro
					try {
						$model_alternativas->insert($data_opcao);
						}
					catch(Exception $e) {
						die(var_dump($e));
					}

				}
					//mensagem de usuario
						$mensagem->success = "Enquete criada com sucesso!";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);
			}



		}else{
			//mensagem de usuario
			$mensagem->error = "Você precisa estar logado para criar uma enquete";
			//retorno a ultima pagina
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	* Função responsavel por detalhar a enquete
	**/

	public function enqueteAction(){
		//inicio a sessao de de votos
		$votos = new Zend_Session_Namespace("votou");

		//recebo o codigo da enquete
		$idenquete = $this->_request->getparam("idenquete");

		//inicio o model de enquete
		$model_enquete = new Default_Model_Enquetes();

		//crio a query de enquete
		$select_enquete = $model_enquete->select()
							->where("idenquete = ?", $idenquete);
		//armazeno as informações da variavel na enquente
		$enquete = $model_enquete->fetchRow($select_enquete);

		//inicio o model de alternativas
		$model_alternativas = new Default_Model_Enquetesopcoes();

		//crio a query das alternativas

		$select_alternativas = $model_alternativas->select()
								->where("idenquete = ?", $idenquete);



		//crio o model de comentarios
		$model_comentarios = new Default_Model_Enquetecomentarios();
		//inicio a query de comentarios
		$select_comentarios = $model_comentarios->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('enquete_comentarios', array("idenquete_comentario",
												"idenquete",
												"idusuario",
												"data_comentario",
												"comentario",
												"numero_curtiu",
												"numero_nao_curtiu",
												"total_comentarios" => "(SELECT 
																            COUNT(idenquete_comentario) AS total_comentarios
																        FROM
																            enquete_comentarios
																        WHERE
																            idenquete_comentario = idenquete_comentario
																        AND 
																        	idcomentario_pai is not null
																		AND 
																			idenquete = $idenquete)"))
			->joinInner('cadastros',
					'enquete_comentarios.idusuario = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO',
																						   'DS_NOME_CASO',
																						   'DS_EXT_CACH'))


												->where("idenquete = ?", $idenquete)
												->where("idcomentario_pai is null");

												
		//assino as alternativas a uma variavel
		$alternativas = $model_alternativas->fetchAll($select_alternativas);

	

		// agora verifico se o usuário já votou
		if($votos->votou == 1 and $idenquete == $votos->idenquete){
			//crio a query dos resultados
			$select_resultado = $model_alternativas->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			->from('enquetes_opcoes', array("idenquete",
										   "imagem_path",
										   "opcao",
										   "quantidade_votos",
										   "total_votos" => "(SELECT
										   						SUM(quantidade_votos) as total_votos
										   					  FROM
										   					  	enquetes_opcoes
										   					  WHERE
										   					  	idenquete = $idenquete)"))
								->where("idenquete = ?", $idenquete);
								
			$resultado_enquete = $model_alternativas->fetchAll($select_resultado);

			$this->view->resultado = $resultado_enquete;
			$this->view->javotou = $votos->votou;
		}else{

			//crio a query dos resultados
			$select_resultado = $model_alternativas->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			->from('enquetes_opcoes', array("idenquete",
										   "imagem_path",
										   "opcao",
										   "quantidade_votos",
										   "total_votos" => "(SELECT
										   						SUM(quantidade_votos) as total_votos
										   					  FROM
										   					  	enquetes_opcoes
										   					  WHERE
										   					  	idenquete = $idenquete)"))
								->where("idenquete = ?", $idenquete);
								
			$resultado_enquete = $model_alternativas->fetchAll($select_resultado);

			$this->view->resultado_fim = $resultado_enquete;

		}

		//assino ao view
		$this->view->enquete = $enquete;
		$this->view->alternativas = $alternativas;

		// crio a paginação para proximo e para anterior
		$contador = new Reverb_Paginator($select_comentarios);

		//defino a quantidade de itens por pagina
		$contador->setItemCountPerPage(9)
		//defino a quantidade de paginas
		->setPageRange(5)
		//recebo o numero da pagina
		->setCurrentPageNumber($this->_getParam('page'));
		//atribuo ovalor a variavel
		$pages = $contador->getPages();
		//crio o array de paginas
		$pageArray = get_object_vars($pages);
		//assino
		$this->view->assign('pages', $pageArray);


		// crio paginacao com numeros
		$current_page = $this->_request->getParam("page", 1);
		//passo para o paginador o select de produtos
		$contador = new Reverb_Paginator($select_comentarios);
		//defino o numero de itens a serem exibidos por página
		$contador->setItemCountPerPage(9)
		//pega o numero da pagina
		->setCurrentPageNumber($current_page)
		//defino quantas páginas iram aparecer por vez
		->setPageRange(5)
		//assino a paginacao
		->assign();
		//assino ao view

		$this->view->comentarios = $contador;
	

		// $this->view->comentarios = $model_comentarios->fetchAll($select_comentarios);
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



	}


	/**
	* Função responsavel por votar na enquete
	**/

	public function votarenqueteAction(){

		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio o model de mensagem
		$model_opcoes = new Default_Model_Enquetesopcoes();

		//recebo o id da enquete 
		$idenquete = $this->_request->getParam("idenquete");
		//inicio a sessao de de votos
		$votos = new Zend_Session_Namespace("votou");

		if($this->_request->isPost()){
			//recupero o id da msg
			$idopcao = $this->_request->getparam("idopcao");

			//crio a query para receber a quantidade de curtidas
			foreach ($idopcao as $key => $opcao) {

				$select = $model_opcoes->select()
							->from("enquetes_opcoes", array("idenquete_opcao",
											"quantidade_votos"))
							->where("idenquete_opcao = ?", $opcao);

				//recebo o resultado da pesquisa
				$resultado = $model_opcoes->fetchRow($select)->toArray();

				// //agora cada curtida ganha um ponto
				$total_votos = $resultado['quantidade_votos'] + 1;


				$data = array("quantidade_votos" => $total_votos);

				$model_opcoes->update($data,  array("idenquete_opcao = $opcao"));
			}
			//digo que o usuario ja votou
			$votos->votou = 1;
			$votos->idenquete = $idenquete;
			//mensagem de usuario
			$mensagem->success = "Voto realizado com sucesso!";

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{

			//mensagem de usuario
			$mensagem->error = "Você não pode acessar esta página por aqui!";

			$this->_redirect($_SERVER['HTTP_REFERER']);

		}


	}

	/**
	* Função responsavel por comentar a enquete
	**/

	public function comentarenqueteAction(){

		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//se for um post
			if($this->_request->isPost()){
				//inicio o modulo de comentarios
				$model_comentarios = new Default_Model_Enquetecomentarios();

				//recebo a mensagem pai
				$idmensagem_pai = $this->_request->getParam("idmensagem_pai");

				if ($idmensagem_pai == ""){
					//crio o array com as informações do comentarios
					$data_comentario = array("idenquete" => $this->_request->getparam("idenquete"),
											 "idusuario" => $usuarios->idperfil,
											 "comentario" => $this->_request->getparam("comentario"));
				}else{
					//crio o array com as informações do comentarios
					$data_comentario = array("idenquete" => $this->_request->getparam("idenquete"),
											 "idusuario" => $usuarios->idperfil,
											 "comentario" => $this->_request->getparam("comentario"),
											 "idcomentario_pai" => $idmensagem_pai);
				}
				//tento inserir os comentarios
					try {
						$model_comentarios->insert($data_comentario);
						//mensagem de usuario
						$mensagem->success = "Comentario inserido com sucesso!";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);
					}
					catch(Exception $e) {
						$mensagem->error = "Ocorreu um erro ao criar seu comentario!";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);
					}


			}
		}else{
			//mensagem de usuario
			$mensagem->error = "Você precisa estar logado para comentar uma enquete";

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	* Função responsavel por curtir comentario da enquete
	**/

	public function curtircomentarioenqueteAction(){
		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//inicio o model de mensagem
		$model_mensagens = new Default_Model_Enquetecomentarios();
		//recupero o id da msg
		$idmsg = $this->_request->getparam("idcomentario");
		//crio a query para receber a quantidade de curtidas
		$select = $model_mensagens->select()
					->from("enquete_comentarios", array("idenquete_comentario",
									"numero_curtiu"))
					->where("idenquete_comentario = ?", $idmsg);

		//recebo o resultado da pesquisa
		$resultado = $model_mensagens->fetchRow($select);
		//agora cada curtida ganha um ponto
		$total_curtida = $resultado->numero_curtiu + 1;
		//crio o array
		$data = array("numero_curtiu" => $total_curtida);

		//atualizo a tabela
		$model_mensagens->update($data, array("idenquete_comentario = $idmsg"));
		//mensagem para o usuario
		$mensagem->success = "Operação realizada com sucesso.";

		$this->_redirect($_SERVER['HTTP_REFERER']);

	}

	/**
	* Função responsavel por Não curtir comentario da enquete
	**/

	public function naocurtircomentarioenqueteAction(){

		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//inicio o model de mensagem
		$model_mensagens = new Default_Model_Enquetecomentarios();
		//recupero o id da msg
		$idmsg = $this->_request->getparam("idcomentario");
		//crio a query para receber a quantidade de curtidas
		$select = $model_mensagens->select()
					->from("enquete_comentarios", array("idenquete_comentario",
									"numero_nao_curtiu"))
					->where("idenquete_comentario = ?", $idmsg);

		//recebo o resultado da pesquisa
		$resultado = $model_mensagens->fetchRow($select);
		//agora cada curtida ganha um ponto
		$total_nao_curtida = $resultado->numero_nao_curtiu + 1;
		//crio o array
		$data = array("numero_nao_curtiu" => $total_nao_curtida);

		//atualizo a tabela
		$model_mensagens->update($data, array("idenquete_comentario = $idmsg"));
		//mensagem para o usuario
		$mensagem->success = "Operação realizada com sucesso.";

		$this->_redirect($_SERVER['HTTP_REFERER']);

	}


	/**
	 * funcao responsavel por cadastrar forum
	 */
	public function criarforumAction() {

		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//inicio o modulo de topicos
			$model_topicos = new Default_Model_Topicos();

			//crio o array com informações do topico
			$data_topico = array("NR_SEQ_FORUM_TOSO" => 1,
								 "NR_SEQ_CADASTRO_TOSO" => $usuarios->idperfil,
								 "DS_TOPICO_TOSO" => $this->_request->getparam("titulo"),
								 "NR_MSGS_TOSO" => 0,
								 "ST_TOPICO_TOSO" => 'A',
								 "DS_MSG_TOSO" => $this->_request->getparam("mensagem"));
			//insiro os registros
			$model_topicos->insert($data_topico);
			//mensagem de usuario
			$mensagem->success = "Seu topico foi incluído com sucesso.";
			//retorno a ultima pagina
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{
			//mensagem de usuario
			$mensagem->error = "Você precisa estar logado para criar um topico";
			//retorno a ultima pagina
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}


	public function createslug($SEO_text) {

		// Verifica se tem texto
		if(empty($SEO_text)) {
			return;
		}

		// Decodifica o html entities
		$SEO_text = html_entity_decode($SEO_text,ENT_QUOTES, 'UTF-8');

		// Diminui o tamanho da letra
		$SEO_text = mb_strtolower($SEO_text, "UTF-8");

		// Troca os caracteres especiais
		$trans = array(
			'ç' => "c",
			'á' => "a",
			'â' => "a",
			'à' => "a",
			'ã' => "a",
			'é' => "e",
			'ê' => "e",
			'è' => "e",
			'ẽ' => "e",
			'í' => "i",
			'î' => "i",
			'ì' => "i",
			'ĩ' => "i",
			'ó' => "o",
			'ô' => "o",
			'ò' => "o",
			'õ' => "o",
			'ú' => "u",
			'û' => "u",
			'ù' => "u",
			'ũ' => "u"
		);
		$SEO_text = strtr($SEO_text, $trans);

		// Trocar o que não é especial
		$SEO_text = preg_replace("@[^a-zA-Z0-9]@", "-", $SEO_text);

		// Troca varios espacos por 1 só
		$SEO_text = preg_replace("/__+/", "-", $SEO_text);

		// Retorna o texto
		return $SEO_text;
	}

	/**
	 * funcao responsavel json de forum
	 */
	public function jsonforumAction() {
		$info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 9);

		//inicio o model de forum
		$model_forum = new Default_Model_Topicos();

		$palavra = $this->_request->getparam("busca");

		if($info){
			//crio a query de forum
			$select_forum = $model_forum->select()
			//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('topicos')
				//crio o inner join das pessoas
				->joinInner('cadastros',
						'topicos.NR_SEQ_CADASTRO_TOSO = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO',
																							  'DS_NOME_CASO',
																							  'DS_EXT_CACH'));
				if($palavra != ""){
					$select_forum->where("DS_TOPICO_TOSO like '%".$palavra."%'");
				}
				//ordeno pela data de envio
				$select_forum
				->order("NR_SEQ_TOPICO_TOSO ASC");
		}else{
			//crio a query de forum
			$select_forum = $model_forum->select()
			//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('topicos')
				//crio o inner join das pessoas
				->joinInner('cadastros',
						'topicos.NR_SEQ_CADASTRO_TOSO = cadastros.NR_SEQ_CADASTRO_CASO',array('NR_SEQ_CADASTRO_CASO',
																							  'DS_NOME_CASO',
																							  'DS_EXT_CACH'));
				if($palavra != ""){
					$select_forum->where("DS_TOPICO_TOSO like '%".$palavra."%'");
				}
				//ordeno pela data de envio
				$select_forum
				->order("NR_SEQ_TOPICO_TOSO ASC")
				->limit($size, $start);
		}

			//assino ao view
			$topicos = $model_forum->fetchAll($select_forum);

			 foreach ($topicos as $key => $topico) {

			 	// Converte a data para o formato Brasileiro
	            $data_explode = explode("-", $topico->DT_ULTIMOPOST_TOSO);
	            $dia = explode(" ", $data_explode[2]);
	            //$nova_data = $dia[0]."/".$data_explode[1]."/".$data_explode[0];
	            $nova_data = date_format($topico->DT_ULTIMOPOST_TOSO,"F d, Y");
	            $novo_total = number_format($topico->NR_MSGS_TOSO);

				 $topico->NR_MSGS_TOSO = $novo_total;

	            $topico->DT_ULTIMOPOST_TOSO  = $nova_data;
        	}
			//agora atualizo o array de itens
			if ($info) {
            $topicos = array(
                'TOTAL_ITEMS'   => (int) $topicos[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
	        } else {
	            $topicos = $topicos->toArray();
	        }

			//json
			$this->_helper->json($topicos);

	}

	/**
	 * funcao responsavel json enquetes
	 */
	public function jsonenqueteAction() {
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 9);

		//recebo o parametro para buscar a enquete
		$palavra_enquete = $this->_request->getparam("busca_enquete");
		//inicio o modulo das enquetes
		$model_enquete = new Default_Model_Enquetes();

		if($info){
			//inicio a query
			$select_enquete = $model_enquete->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			->from('enquetes', array('idenquete',
										'titulo_enquete',
									    'idautor',
										'data_inicio',
										'total_votos' => "(SELECT
											 					SUM(quantidade_votos)
											 				AS
											 					total_votos
											 				FROM
											 					enquetes_opcoes
											 				WHERE
											 					enquetes.idenquete = enquetes_opcoes.idenquete)"))
				->joinInner('cadastros',
							'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO'));
				//->where("idenquete not in (".$hot_enquete->idenquete .",". $nova_enquete->idenquete .")");
				if ($palavra_enquete != "") {
					$select_enquete->where("titulo_enquete LIKE '%". $palavra_enquete ."%'");
				}
				$select_enquete->order("data_inicio DESC");
			}else{
				//inicio a query
				$select_enquete = $model_enquete->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				->from('enquetes', array('idenquete',
											'titulo_enquete',
										    'idautor',
											'data_inicio',
											'total_votos' => "(SELECT
												 					SUM(quantidade_votos)
												 				AS
												 					total_votos
												 				FROM
												 					enquetes_opcoes
												 				WHERE
												 					enquetes.idenquete = enquetes_opcoes.idenquete)"))
					->joinInner('cadastros',
								'cadastros.NR_SEQ_CADASTRO_CASO = enquetes.idautor', array('DS_NOME_CASO'));
					//->where("idenquete not in (".$hot_enquete->idenquete .",". $nova_enquete->idenquete .")");
					if ($palavra_enquete != "") {
						$select_enquete->where("titulo_enquete LIKE '%". $palavra_enquete ."%'");
					}
					$select_enquete->order("data_inicio DESC")
					->limit($size, $start);
			}



			//assino ao view
			$enquetes = $model_enquete->fetchAll($select_enquete)->toArray();

			foreach ($enquetes as $key => $enquete) {

	            $data_explode = explode("-", $enquete->data_inicio);
	            $dia = explode(" ", $data_explode[2]);
	            $nova_data = $dia[0]."/".$data_explode[1]."/".$data_explode[0];
	  
	            $enquete->data_inicio  = $nova_data;
        	}	
			//json
			$this->_helper->json($enquetes);
	}


	/*
	*
	*Comentar forum
	*
	*/

	public function comentarforumAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//inicio o model de mensagens
			$msg_model = new Default_Model_Mensagens();

			$idforum = $this->_request->getParam("idforum");

			$model_topicos = new Default_Model_Topicos();

			$select_resposta = $model_topicos->select()->from("topicos", array("NR_MSGS_TOSO"))->where("NR_SEQ_TOPICO_TOSO = ?", $idforum);



			$lista_resposta = $model_topicos->fetchRow($select_resposta);

			//se for post
			if($this->_request->isPost()){
				//recebo o parametro de mensagem pai
				$idmensagem_pai = $this->_request->getParam("idmensagem_pai", 0);
					//atribuo o total de respostas
				$total_respostas = $lista_resposta->NR_MSGS_TOSO + 1;

				$data_respostas = array("NR_MSGS_TOSO" => $total_respostas,
										"DT_ULTIMOPOST_TOSO" => date('Y-m-d H:i:s'));
				//se continuar como zero não e resposta de nenhum comentario
				if($idmensagem_pai == 0){
					//crio o array
					$data_comentario = array("NR_SEQ_TOPICO_MESO" => $this->_request->getParam("idforum"),
											 "NR_SEQ_CADASTRO_CASO" => $usuarios->idperfil,
											 "DT_CADASTRO_MESO" => date("Y-m-d H:i:s"),
											 "ST_MSG_MESO" => "A",
											 "DS_MSG_MESO" => $this->_request->getParam("comentario"),
											 "DS_IP_MESO" => $_SERVER["REMOTE_ADDR"],
											 "NR_CURTIRAM_MESO" => 0,
											 "NR_NAOCURTIRAM_MESO" => 0);
				

					try{
						$msg_model->insert($data_comentario);

						$model_topicos->update($data_respostas, array("NR_SEQ_TOPICO_TOSO = ?" => $idforum));

						//mensagem de usuario
						$mensagem->success = "Sua resposta foi inserida com sucesso.";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);
					}catch(Exception $e){
						//dou retorno ao usuario
						$mensagem->error = "Houve um erro ao inserir seu comentario, por favor tente novamente mais tarde!";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);

					}
				//se for diferente de zero e porque existe resposta
				}else{
					//crio o array
					$data_comentario = array("NR_SEQ_TOPICO_MESO" => $this->_request->getParam("idforum"),
											 "NR_SEQ_CADASTRO_CASO" => $usuarios->idperfil,
											 "DT_CADASTRO_MESO" => date("Y-m-d H:i:s"),
											 "ST_MSG_MESO" => "A",
											 "DS_MSG_MESO" => $this->_request->getParam("comentario"),
											 "DS_IP_MESO" => $_SERVER["REMOTE_ADDR"],
											 "NR_CURTIRAM_MESO" => 0,
											 "NR_NAOCURTIRAM_MESO" => 0,
											 "NR_REPLY_MESO" => $idmensagem_pai);

                    $selectMensagem = $msg_model->select()
                        ->from(array('m' => 'msgs'), array())
                        ->join(array('c' => 'cadastros'), 'c.nr_seq_cadastro_caso = m.NR_SEQ_CADASTRO_CASO', array())
                        ->columns(array(
                            'nome' => 'c.ds_nome_caso',
                            'email' => 'c.ds_email_caso'
                        ))
                        ->where('m.NR_SEQ_MSG_MESO = ?', $idmensagem_pai)
                        ->setIntegrityCheck(false);
                    $dadosMensagem = $msg_model->fetchRow($selectMensagem);

                    $mensagem = "<tr>
									<td width=\"283\" colspan='9' height=\"277\" style=\"color: #646464; background-color: #dcddde; font-size: 12px; font-family: Verdana\">
										<p width=\"243\" style=\"margin-top:-90px; margin-left:22px;\">
											Olá <b>". $dadosMensagem->nome ."</b>!<br><br>

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
                    $mail->addTo($dadosMensagem->email, $dadosMensagem->nome);
                    $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                    $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                    $mail->setSubject("Novo Comentário no Fórum");
                    $mail->send($mailTransport);

					try{
						$msg_model->insert($data_comentario);
						$model_topicos->update($data_respostas, array("NR_SEQ_TOPICO_TOSO = ?" => $idforum));
						//mensagem de usuario
						$mensagem->success = "Sua resposta foi inserida com sucesso.";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);
					}catch(Exception $e){
						//dou retorno ao usuario
						$mensagem->error = "Houve um erro ao inserir seu comentario, por favor tente novamente mais tarde!";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);

					}

				}	
			}

			

		}else{

			$mensagem->error = "Você precisa estar logado para comentar!";
			//retorno a ultima pagina
			$this->_redirect("/cadastro-rapido");
		}

	}


	/*
	*
	*Denunciar forum
	*
	*/

	public function denunciarforumAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//inicio a sessao de mensagem
		$message = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {

			$idforum = $this->_request->getParam("idforum");

			$topico = $this->_request->getParam("topico");

			$denunciante = $usuarios->nome;

			//pego o server
			$server = $_SERVER['SERVER_NAME'];
			//monto a url de quem esta sendo denunciado 
			$urlforum = "http://" . $server . "/detalhe-forum/page/1" . $topico ."/". $idforum;

			//crio a mensagem
			$mensagem = 	"<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
									DENUNCIA DE FORUM
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
										O Tópico <b> $topico </b> do forum </br>
										foi denunciado pelo usuario <b>$denunciante</b> por conter irregularidades.</br></br>

										

										Para conferir o topico denunciado clique no link abaixo.</br>

									</br>

								</td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
									<b><a href=\"$urlforum\" style=\"text-decoration:none;color: #646464; font-size: 12px;\">Tópico Denunciado </a></b>
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
				$mail->addTo($emailAdm, "Reverbcity - A Música que veste");
				$mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
				$mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
				$mail->setSubject("Denuncia de Perfil");
				$mail->send($mailTransport);


				if($mail->send($mailTransport)){
					//retorno mensagem de sucesso para o usuário
					$message->success = "Sua denuncia foi feita com sucesso, iremos avaliar o topico. Obrigado.";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}else{
					//retorno mensagem de sucesso para o usuário
					$message->error = "Ocorreu um erro ao denunciar o topico, tente mais tarde.";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}


		}else{
			$mensagem->error = "Você precisa estar logado para denunciar um forum!";
			//retorno a ultima pagina
			$this->_redirect("/cadastro-rapido");
		}
	}

	public function deletarcomentarioforumAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//inicio a sessao de mensagem
		$message = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//inicio o model de mensagens
			$msg_model = new Default_Model_Mensagens();
			//recebo o id do comentario
			$idcomentario = $this->_request->getParam("idcomentario");

			if($usuarios->idperfil == 2){
				//crio a query de mensagem para previnir que o usuario remova um outr post
				$sql_msg = $msg_model->select()
					->where("NR_SEQ_MSG_MESO = ?", $idcomentario);
			}else{
				//crio a query de mensagem para previnir que o usuario remova um outr post
				$sql_msg = $msg_model->select()
					->where("NR_SEQ_MSG_MESO = ?", $idcomentario)
					->where("NR_SEQ_CADASTRO_CASO = ?", $usuarios->idperfil);
			}

			//armazeno a mensagem em uma variavel
			$msgs = $msg_model->fetchRow($sql_msg);
			//agora previno que remova mais de uma vez
			if ($msgs == "") {
				//retorno mensagem de sucesso para o usuário
				$message->error = "Você não pode remover esta mensagem.";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			//se nao adicionou ainda faz a requisiao
			}else{


				try {
				
					//removo o recado
					$msg_model->delete(array('NR_SEQ_MSG_MESO = ?' => $msgs->NR_SEQ_MSG_MESO));

					$message->success = "Seu comentario foi removido com sucesso";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);

				}catch(Exception $e) {
					//retorno mensagem de sucesso para o usuário
					$message->error = "Ocorreu um erro ao remover seu comentario";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
			}


		}else{
			$message->error = "Você precisa estar logado deletar seu comentario!";
			//retorno a ultima pagina
			$this->_redirect("/cadastro-rapido");
		}
	}

	/*
	*
	* Função para mandar recados para todos os que participam do forum
	*
	*/

	public function escrevertodosAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");
		//inicio a sessao de mensagem
		$message = new Zend_Session_Namespace("messages");
	// 	//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//agora verifico se é post
			// if($this->_request->isPost()){

				//agora pego o id do usuário logado
				$idusuario = $usuarios->idperfil;

				//agora verifico se e o marcio, tony, gabi, ou gustavo
				if($idusuario == 2 or $idusuario == 6605 or $idusuario == 4162 or $idusuario == 32609){

					//recebo o texto digitado
					$post = $this->_request->getParam("mensagem");
				
					//inicio o adaptador do banco
					$db = Zend_Registry::get("db");

					//faço a query do id dos usuarios
					$select_id = "SELECT distinct 
									NR_SEQ_CADASTRO_CASO 
								from 
									msgs";
					// Monta a query
			        $query_users = $db->query($select_id);
			        //crio uma lista de amigos
			        $lista_users = $query_users->fetchAll();


			        //agora para cada usuário eu envio o recado

			        foreach ($lista_users as $key => $usuario) {
			        	//pego o id de quem vai receber
			        	$idme = $usuario['NR_SEQ_CADASTRO_CASO'];


			        	$data_scrap = array("NR_SEQ_CADASTRO_SBRC" => $idme,
			        						"NR_SEQ_AUTOR_SBRC" => $idusuario,
			        						"DS_POST_SBRC" => $post,
			        						"DT_POST_SBRC" => date('Y-m-d H:i:s'));
			       
						// Monta a query
			        	$db->insert("me_scraps", $data_scrap);
			        		


					    $texto = "<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
								NOVO SCRAP
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
									Olá,</br></br>

									<p>Você acaba de receber uma mensagem no seu Scrap reverbcity.com.</p> 
					                
					                <p>
					                Para acessar o seu perfil clique no link abaixo:
					                <br /><br />
					                <a href=\"http://reverbcity.com/meu-perfil\">Novo Recado</a>
					                <br /><br /></p>

								</td>
							</tr>";



					              // Busca o conteudo do topo e do rodape
						$topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_padrao.html");

						$rodape  = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_padrao.html");
						//crio o corpo á ser enviado para o cliente
						$body .= $topo;
						$body .= $texto;
						$body .= $rodape;

						//configuro o envio de email
						$config = array (
							'auth' => 'login',
							'username' =>     "atendimento@reverbcity.com",
							'password' =>     "ramones@334",
							'ssl' =>          "tls", # default ("ssl")
							'port' =>         "587" # default ("25")
						);

						//faço a query do email dos usuarios
						$select_mail = "SELECT DS_EMAIL_CASO, ST_BLOQUEIOMAIL_CACH FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $idme";
						// Monta a query
				        $query_mail = $db->query($select_mail);
				        //crio uma lista de emails
				        $lista_mail = $query_mail->fetchAll();

				  

				        //agora verifico se o usuário autoriza receber email
				        if($lista_mail[0]['ST_BLOQUEIOMAIL_CACH'] == "N"){

				        	//agora crio o esquema de enviar o email
				        	$emailAdm = "atendimento@reverbcity.com";
							$mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com",$config);

							$emailcliente = $lista_mail[0]['DS_EMAIL_CASO'];

							$mail = new Zend_Mail('UTF-8');
							$mail->setBodyHtml($body,'UTF-8');
							$mail->addTo($emailcliente, "Reverbcity - A Música que veste");
							$mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
							$mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
							$mail->setSubject("Novo Scrap");
							$mail->send($mailTransport);
						}

			        }
			        $message->success =  "Operação realizada com sucesso!";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);

				}else{
					$message->error =  "Você não tem permissão suficiente para executar esta ação";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}

			// }else{
			// 	$message->error = "Você não pode acessar esta página assim.";
			// 	//redireciono
			// 	$this->_redirect($_SERVER['HTTP_REFERER']);
			// }

		}else{
			$message->error = "Você precisa estar logado para executar esta ação";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

}
