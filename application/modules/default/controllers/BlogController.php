<?php

/**
*
*/
class BlogController extends Zend_Controller_Action {
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

	}

	/**
	 *
	 */
	public function indexAction() {

        $this->view->title = "Noticias e Novidades - Reverbcity.com";
		$this->view->description = "Música, design, humor e muito mais no nosso blog";
		$this->view->keywords = "Reverbcity, blog, musica, design, novidades, humor";
		//recebo o id da categoria
		$categoria = $this->_request->getParam("categoria");
		//recebo o titulo
		$titulo = $this->_request->getParam("search-text");
		$data_search = $this->_request->getParam("search-date");

		$data_explode = explode("/", $data_search);

		date_default_timezone_set('America/Sao_Paulo');

		$hoje = date("Y-m-d H:i:s");

		$data_pesquisa = $data_explode[2] ."-". $data_explode[1] . "-" . $data_explode[0];

		$this->view->categoria = $categoria;
		$this->view->titulo = $titulo;
		//inicio o model do blog


		/************
		* Lista posts
		*************/

			// Busca o cache
			$idCache_blog = "blog_index";

			$lista_blog = Zend_Registry::get("cache")->load($idCache_blog);

			// Zend_Registry::get("cache")->remove($idCache_blog);
			 
			$model_blog = new Default_Model_Blog();
			// Se nao existir o cache faz consulta
			if(!$lista_blog) {

				//crio a query de blog
				$select_blog = $model_blog->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('blog', array('NR_SEQ_BLOG_BLRC',
									 'DS_EXT_BLRC',
									 'DS_TITULO_BLRC',
									 'DT_PUBLICACAO_BLRC',
									 'NR_SEQ_CATEGORIA_BLRC',
									 'NR_SEQ_COLUNISTA_BLRC',
									 'DS_TEXTO_BLRC',
									 'total_comentarios' => "(SELECT
																	COUNT(NR_SEQ_COMENTARIO_CBRC)
																		AS total_comentatios
																	FROM
																	    blog_coments
																	WHERE
																	    NR_SEQ_BLOG_BLRC = NR_SEQ_BLOG_CBRC
																	AND DS_STATUS_CBRC = 'A')"))

				//crio o inner join dos autores
				->joinInner('colunistas',
						'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC',array('DS_COLUNISTA_CORC'))
				//somente os com estatus A = Aprovado
				->where("blog.DS_STATUS_BLRC = 'A'")
				//todos com data que ja passaram
				->where("DT_PUBLICACAO_BLRC <= ?", $hoje)
				->group("NR_SEQ_BLOG_BLRC")
				//ordeno pela ordem de ordenacao de produtos
				->order('DT_PUBLICACAO_BLRC DESC');


				$lista_blog = $model_blog->fetchAll($select_blog)->toArray();

				// Salva o cache
				Zend_Registry::get("cache")->save($lista_blog, $idCache_blog);

			}
		//se tiver categoria faz o filtro por categoria
		if ($categoria != "") {
			//crio a query de blog
				$select_blog = $model_blog->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('blog', array('NR_SEQ_BLOG_BLRC',
									 'DS_EXT_BLRC',
									 'DS_TITULO_BLRC',
									 'DT_PUBLICACAO_BLRC',
									 'NR_SEQ_CATEGORIA_BLRC',
									 'NR_SEQ_COLUNISTA_BLRC',
									 'DS_TEXTO_BLRC',
									 'total_comentarios' => "(SELECT
																	COUNT(NR_SEQ_COMENTARIO_CBRC)
																		AS total_comentatios
																	FROM
																	    blog_coments
																	WHERE
																	    NR_SEQ_BLOG_BLRC = NR_SEQ_BLOG_CBRC
																	AND DS_STATUS_CBRC = 'A')"))

				//crio o inner join dos autores
				->joinInner('colunistas',
						'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC',array('DS_COLUNISTA_CORC'))
				//somente os com estatus A = Aprovado
				->where("blog.DS_STATUS_BLRC = 'A'")
				//todos com data que ja passaram
				->where("DT_PUBLICACAO_BLRC <= ?", $hoje)
				->where("blog.NR_SEQ_CATEGORIA_BLRC = " . $categoria)
				->group("NR_SEQ_BLOG_BLRC")
				//ordeno pela ordem de ordenacao de produtos
				->order('DT_PUBLICACAO_BLRC DESC');

				$lista_blog = $model_blog->fetchAll($select_blog)->toArray();
				//exibo a categoria ao view
				$this->view->cat = $categoria;
		}
		if($titulo != ""){
			//crio a query de blog
			$select_blog = $model_blog->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('blog', array('NR_SEQ_BLOG_BLRC',
								 'DS_EXT_BLRC',
								 'DS_TITULO_BLRC',
								 'DT_PUBLICACAO_BLRC',
								 'NR_SEQ_CATEGORIA_BLRC',
								 'NR_SEQ_COLUNISTA_BLRC',
								 'DS_TEXTO_BLRC',
								 'total_comentarios' => "(SELECT
																COUNT(NR_SEQ_COMENTARIO_CBRC)
																	AS total_comentatios
																FROM
																    blog_coments
																WHERE
																    NR_SEQ_BLOG_BLRC = NR_SEQ_BLOG_CBRC
																AND DS_STATUS_CBRC = 'A')"))

			//crio o inner join dos autores
			->joinInner('colunistas',
					'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC',array('DS_COLUNISTA_CORC'))
			//somente os com estatus A = Aprovado
			->where("blog.DS_STATUS_BLRC = 'A'")
			//todos com data que ja passaram
			->where("DT_PUBLICACAO_BLRC <= ?", $hoje)
			->where("blog.DS_TITULO_BLRC LIKE '%" . $titulo . "%'")
			->group("NR_SEQ_BLOG_BLRC")
			//ordeno pela ordem de ordenacao de produtos
			->order('DT_PUBLICACAO_BLRC DESC');

			$lista_blog = $model_blog->fetchAll($select_blog)->toArray();

		}

		if($data_pesquisa != "--"){
			//crio a query de blog
			$select_blog = $model_blog->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('blog', array('NR_SEQ_BLOG_BLRC',
								 'DS_EXT_BLRC',
								 'DS_TITULO_BLRC',
								 'DT_PUBLICACAO_BLRC',
								 'NR_SEQ_CATEGORIA_BLRC',
								 'NR_SEQ_COLUNISTA_BLRC',
								 'DS_TEXTO_BLRC',
								 'total_comentarios' => "(SELECT
																COUNT(NR_SEQ_COMENTARIO_CBRC)
																	AS total_comentatios
																FROM
																    blog_coments
																WHERE
																    NR_SEQ_BLOG_BLRC = NR_SEQ_BLOG_CBRC
																AND DS_STATUS_CBRC = 'A')"))

			//crio o inner join dos autores
			->joinInner('colunistas',
					'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC',array('DS_COLUNISTA_CORC'))
			//somente os com estatus A = Aprovado
			->where("blog.DS_STATUS_BLRC = 'A'")
			//todos com data que ja passaram
			->where("DT_PUBLICACAO_BLRC <= ?", $hoje)
			->where("DT_PUBLICACAO_BLRC like '%" . $data_pesquisa . "%'")
			->group("NR_SEQ_BLOG_BLRC")
			//ordeno pela ordem de ordenacao de produtos
			->order('DT_PUBLICACAO_BLRC DESC');

			$lista_blog = $model_blog->fetchAll($select_blog)->toArray();
		}


		// die($select_blog);

		// crio a paginação para proximo e para anterior
		$paginator = new Reverb_Paginator($lista_blog);
		//defino a quantidade de itens por pagina
		$paginator->setItemCountPerPage(10)
		//defino a quantidade de paginas
		->setPageRange(9)
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
		$contador = new Reverb_Paginator($lista_blog);
		//defino o numero de itens a serem exibidos por página
		$contador->setItemCountPerPage(10)
		//pega o numero da pagina
		->setCurrentPageNumber($current_page)
		//defino quantas páginas iram aparecer por vez
		->setPageRange(9)
		//assino a paginacao
		->assign();
		//assino ao view
		$this->view->contadores = $contador;

		/************
		* Lista categorias
		*************/

			// Busca o cache
			$idCache_categoria = "blog_categorias";
		
			$lista_categorias = Zend_Registry::get("cache")->load($idCache_categoria);
		
			// Se nao existir o cache faz consulta
			if(!$lista_categorias) {

				//inicio o model de blog categorias
				$model_categorias = new Default_Model_Blogcategorias();
				///crio a query de categoria
				$select_categoria = $model_categorias->select()->order("DS_CATEGORIA_BCRC ASC");
				//lista de categorias
				$lista_categorias = $model_categorias->fetchAll($select_categoria);

				
				// Salva o cache
				Zend_Registry::get("cache")->save($lista_categorias, $idCache_categoria);
			}
			//assino ao view
			$this->view->categorias = $lista_categorias;


		/************
		* Lista forum
		*************/

			// Busca o cache
			$idCache_forum = "blog_forum";

			$$lista_forum = Zend_Registry::get("cache")->load($idCache_forum);
		
			// Se nao existir o cache faz consulta
			if(!$$lista_forum) {

				//inicio o model de forum
				$model_forum = new Default_Model_Topicos();

				//crio a query de forum
				$select_forum = $model_forum->select()
				//digo que nao existe integridade entre as tabelas
					->setIntegrityCheck(false)
					//escolho a tabela do select para o join
					->from('topicos')
					//crio o inner join das pessoas
					->joinInner('cadastros',
							'topicos.NR_SEQ_CADASTRO_TOSO = cadastros.NR_SEQ_CADASTRO_CASO',array('*'))
					//ordeno pela data de envio
					->order("topicos.DT_ULTIMOPOST_TOSO DESC")
					//limito a nove registros
					->limit(40);

				$lista_forum = $model_forum->fetchAll($select_forum);

				// Salva o cache
				Zend_Registry::get("cache")->save($lista_forum, $idCache_forum);
			}

			//assino ao view
			$this->view->foruns = $lista_forum;


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
		$this->view->banners_topo = $banners_topo;


		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_agendado = $model_banner->select()
							->where("NR_SEQ_LOCAL_BARC = 89")
							->where("ST_BANNER_BARC = 'A'")
							->where("ST_AGENDAMENTO_BARC = 1")
							->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
							->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$agendados = $model_banner->fetchAll($select_agendado)->toArray();

		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_normais = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 89")
								->where("ST_BANNER_BARC = 'A'")
								->where("ST_AGENDAMENTO_BARC = 0")
								->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$normais = $model_banner->fetchAll($select_normais)->toArray();
		//junto os 2 tipos de banners em um só array
		$banners = array_merge($agendados,$normais);


		//Assino ao view
		$this->view->banners = $banners;



	}

	/**
	 *
	 */
	public function postAction() {

		$idpost = $this->_request->getParam('idpost');

		$server = $_SERVER['SERVER_NAME']; 
		$endereco = $_SERVER ['REQUEST_URI'];

		$url = $server . $endereco;

		$this->view->url = $url;

		$model_blog = new Default_Model_Blog();
		//crio a query de blog
		$select_blog = $model_blog->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('blog', array('NR_SEQ_BLOG_BLRC',
							 'DS_LINKIMAGEM_BLRC',
							 'DS_EXT_BLRC',
							 'DS_TITULO_BLRC',
							 'DT_PUBLICACAO_BLRC',
							 'NR_SEQ_CATEGORIA_BLRC',
							 'NR_SEQ_COLUNISTA_BLRC',
							 'DS_TEXTO_BLRC',
							 'total_comentarios' => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_CBRC)
																AS total_comentatios
															FROM
															    blog_coments
															WHERE
															    NR_SEQ_BLOG_BLRC = NR_SEQ_BLOG_CBRC
															AND DS_STATUS_CBRC = 'A')"))
		//crio o inner join das categorias
		->joinInner('blog_categorias',
				'blog.NR_SEQ_CATEGORIA_BLRC = blog_categorias.NR_SEQ_BLOGCAT_BCRC',array('*'))
		//crio o inner join dos autores
		->joinInner('colunistas',
				'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC',array('DS_COLUNISTA_CORC'))
		//onde id do post for igual o selecionado
		->where("blog.NR_SEQ_BLOG_BLRC = $idpost")
		//agrupo por codigo do post
		->group("NR_SEQ_BLOG_BLRC");
		//recebo o posto na variavel
		$post = $model_blog->fetchRow($select_blog);
		//assino o post ao view
		$this->view->blog = $post;


        $this->view->title = $post->DS_TITULO_BLRC . " - Reverbcity.com";
		$this->view->description = "Música, design, humor e muito mais no nosso blog";
		$this->view->keywords = "Reverbcity, blog, musica, design, novidades, humor";
		$this->view->imagem_fb = $post->NR_SEQ_BLOG_BLRC.".".$post->DS_EXT_BLRC;

		//inicio o model de blog categorias
		$model_categorias = new Default_Model_Blogcategorias();
		///crio a query de categoria
		$select_categoria = $model_categorias->select()->order("DS_CATEGORIA_BCRC ASC");
		//assino ao view
		$this->view->categorias = $model_categorias->fetchAll($select_categoria);

		//inicio o model de comentario deo blog
		$model_comentarios = new Default_Model_Comentariosblog();
		//faço a query de comentarios
		$select_comentarios = $model_comentarios->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
		//escolho a tabela do select para o join
			->from('blog_coments', array("NR_SEQ_COMENTARIO_CBRC",
										 "NR_SEQ_CADASTRO_CASO",
										 "NR_SEQ_BLOG_CBRC",
										 "DS_TEXTO_CBRC",
										 "DS_TEMP_CBRC",
										 "NR_CURTIRAM_CBRC",
										 "NR_NAOCURTIRAM_CBRC",
										 "NR_SEQ_REPLY_CBRC",
										 "DT_CADASTRO_CBRC"))
			//crio o inner de quem postou
			->joinLeft('cadastros',
				'blog_coments.NR_SEQ_CADASTRO_CASO = cadastros.NR_SEQ_CADASTRO_CASO',array('DS_NOME_CASO',
																						   'NR_SEQ_CADASTRO_CASO',
																						   'DS_EXT_CACH'))
		//somente os referentes a esta postagem e aprovados
			->where("NR_SEQ_BLOG_CBRC = ?", $idpost)
			->where("DS_STATUS_CBRC = 'A'")
			->where("NR_SEQ_REPLY_CBRC is NULL")
			->order("DT_CADASTRO_CBRC DESC");

		$lista_comentarios = $model_comentarios->fetchAll($select_comentarios);
		//inicio a sessao de usuários
		$usuarios = new Zend_Session_Namespace("usuarios");

		//assino ao view o id do usuario logado para poder deletar os comentario
		$this->view->codigo_usuario = $usuarios->idperfil;
		// crio o objeto de conexao com o banco externo
		// $db = Zend_Registry::get('db');
		// //agora vou contar as respostas
		// foreach ($lista_comentarios as $key => $comentario) {

			
			
		// 	$select_total_comentarios = "SELECT
		// 									NR_SEQ_COMENTARIO_CBRC, 										
		// 									DS_NOME_CASO,
		// 									NR_CURTIRAM_CBRC,
		// 									NR_NAOCURTIRAM_CBRC,
		// 									DS_TEXTO_CBRC,
		// 									DT_CADASTRO_CBRC
		// 								FROM 
		// 									blog_coments
		// 								INNER JOIN 
		// 									cadastros 
		// 								ON 
		// 									cadastros.NR_SEQ_CADASTRO_CASO = blog_coments.NR_SEQ_CADASTRO_CASO 
		// 								WHERE 
		// 									NR_SEQ_REPLY_CBRC = ". $comentario["NR_SEQ_COMENTARIO_CBRC"];



		// 	$query_coments = $db->query($select_total_comentarios);
		// 	//crio uma lista de comentario
		// 	$total_comentarios_resp = $query_coments->fetchAll();

		// 	foreach ($total_comentarios_resp[0] as $key => $resposta) {

		// 		$lista_comentarios["idresposta"] = $total_comentarios_resp[0]["NR_SEQ_COMENTARIO_CBRC"];
		// 		$lista_comentarios["nome_resposta"] = $total_comentarios_resp[0]["DS_NOME_CASO"];
		// 		$lista_comentarios["curtiram_resposta"] = $total_comentarios_resp[0]["NR_CURTIRAM_CBRC"];
		// 		$lista_comentarios["nao_curtiram_resposta"] = $total_comentarios_resp[0]["NR_NAOCURTIRAM_CBRC"];
		// 		$lista_comentarios["resposta"] = $total_comentarios_resp[0]["DS_TEXTO_CBRC"];
		// 		$lista_comentarios["data_resposta"] = $total_comentarios_resp[0]["DT_CADASTRO_CBRC"];
		// 		$lista_comentarios["total_comentarios"] = $total_comentarios_resp[0]["total_comentarios"];
		// 	}

		
			
		// }


		
		//assino ao vire
		$this->view->comentarios = $lista_comentarios;

		//inicio o model de banners
		$model_banner = new Default_Model_Banners();
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
		$this->view->banners_topo = $banners_topo;


		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_agendado = $model_banner->select()
							->where("NR_SEQ_LOCAL_BARC = 89")
							->where("ST_BANNER_BARC = 'A'")
							->where("ST_AGENDAMENTO_BARC = 1")
							->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
							->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$agendados = $model_banner->fetchAll($select_agendado)->toArray();

		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_normais = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 89")
								->where("ST_BANNER_BARC = 'A'")
								->where("ST_AGENDAMENTO_BARC = 0")
								->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$normais = $model_banner->fetchAll($select_normais)->toArray();
		//junto os 2 tipos de banners em um só array
		$banners = array_merge($agendados,$normais);

		//Assino ao view
		$this->view->banners = $banners;

		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_agendado2 = $model_banner->select()
							->where("NR_SEQ_LOCAL_BARC = 89")
							->where("ST_BANNER_BARC = 'A'")
							->where("ST_AGENDAMENTO_BARC = 1")
							->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
							->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$agendados2 = $model_banner->fetchAll($select_agendado2)->toArray();

		//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
		$select_normais2 = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 89")
								->where("ST_BANNER_BARC = 'A'")
								->where("ST_AGENDAMENTO_BARC = 0")
								->order("DT_CADASTRO_BARC DESC");

		//armazeno em uma variavel
		$normais2 = $model_banner->fetchAll($select_normais2)->toArray();
		//junto os 2 tipos de banners em um só array
		$banners2 = array_merge($agendados2,$normais2);

		//Assino ao view
		$this->view->banners2 = $banners2;



		//inicio o model do forum
		$model_topico = new Default_Model_Topicos();
		//inicio a query
		$select_topicos = $model_topico->select()
		//seleciono somente os ativos
						->where("ST_TOPICO_TOSO = 'A'")
						->order("DT_CADASTRO_TOSO DESC")
						->LIMIT(7);
		//assino ao view
		$this->view->foruns = $model_topico->fetchAll($select_topicos);

        $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/tinymce.min.js');
        $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/langs/pt_BR.js');

	}

	public function deletarcomentarioblogAction(){

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
			$model_comentarios = new Default_Model_Comentariosblog();
			//recebo o id do comentario
			$idcomentario = $this->_request->getParam("idcomentario");
			//crio a query de mensagem para previnir que o usuario remova um outr post
			$sql_msg = $model_comentarios->select()
								->where("NR_SEQ_COMENTARIO_CBRC = ?", $idcomentario)
								->where("NR_SEQ_CADASTRO_CASO = ?", $usuarios->idperfil);
			//armazeno a mensagem em uma variavel
			$msgs = $model_comentarios->fetchRow($sql_msg);
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
					$model_comentarios->delete(array('NR_SEQ_COMENTARIO_CBRC = ?' => $msgs->NR_SEQ_COMENTARIO_CBRC));

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
	* funcao responsavel por inserir o comentario no blog
	*/
	public function comentarAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");

		//verifico se o usuário esta logado
		if($usuarios->logado == true){

			//verifico se é uma requisicao de post para realizar o contato
			if ($this->_request->isPost()) {

				//verifico o captcha
				if (isset($_POST['captcha'])){
	                $captcha = new Zend_Captcha_Image();
	                if ($captcha->isValid($_POST['captcha'], $_POST)){
	                    echo "Success";
	                }else{
	                //captcha invalid.. redisplay..
	                    $session->sent = time();
	                    $messages->error = "Captcha digitado errado, tente novamente!";
	                   //redireciono
						$this->_redirect($_SERVER['HTTP_REFERER']);
	                    echo "Failed";
	                }
	            }
				//inicio o model da tabela de contatos
				$model = new Default_Model_Comentariosblog();
				//recebo o id do usuario
				$idusuario = $usuarios->idperfil;

				//recebo a mensagem pai
				$id_mensagem_pai = $this->_request->getParam("idmensagem");

				//verifico se veio mensagem pai
				if($id_mensagem_pai == ""){

					//crio um array com os campos do formulario
					$data = array('NR_SEQ_CADASTRO_CASO' => $idusuario,
						          'NR_SEQ_BLOG_CBRC' => $this->_request->getParam('idpost'),
						          'DT_CADASTRO_CBRC' => date("Y-m-d H:i:s"),
						          'DS_STATUS_CBRC' => "A",
						          'DS_TEXTO_CBRC' => $this->_request->getParam('comentario'),
						          'DS_TEMP_CBRC' => $this->_request->getParam('nome'),
						          'DS_TEMPEMAIL_CBRC' => $this->_request->getParam('email'),
						          'DS_IP_CBRC' => $_SERVER["REMOTE_ADDR"],
						          'NR_CURTIRAM_CBRC' => 0,
						          'NR_NAOCURTIRAM_CBRC' => 0);
				}else{
						//crio um array com os campos do formulario
					$data = array('NR_SEQ_CADASTRO_CASO' => $idusuario,
						          'NR_SEQ_BLOG_CBRC' => $this->_request->getParam('idpost'),
						          'DT_CADASTRO_CBRC' => date("Y-m-d H:i:s"),
						          'DS_STATUS_CBRC' => "A",
						          'DS_TEXTO_CBRC' => $this->_request->getParam('new-comment'),
						          'DS_TEMP_CBRC' => $this->_request->getParam('nome'),
						          'DS_TEMPEMAIL_CBRC' => $this->_request->getParam('email'),
						          'DS_IP_CBRC' => $_SERVER["REMOTE_ADDR"],
						          'NR_CURTIRAM_CBRC' => 0,
						          'NR_NAOCURTIRAM_CBRC' => 0,
						          'NR_SEQ_REPLY_CBRC' => $id_mensagem_pai);

                    $selectMensagem = $model->select()
                        ->from(array('bc' => 'blog_coments'), array())
                        ->join(array('c' => 'cadastros'), 'c.nr_seq_cadastro_caso = bc.NR_SEQ_CADASTRO_CASO', array())
                        ->columns(array(
                            'nome' => 'c.ds_nome_caso',
                            'email' => 'c.ds_email_caso'
                        ))
                        ->where('bc.NR_SEQ_COMENTARIO_CBRC = ?', $id_mensagem_pai)
                        ->setIntegrityCheck(false);
                    $dadosMensagem = $model->fetchRow($selectMensagem);

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
                    $mail->setSubject("Novo Comentário no Blog");
                    $mail->send($mailTransport);
				}


				try {
						//insiro o registro
						$model->insert($data);
						//retorno mensagem de sucesso para o usuário
						$messages->success = "Comentario inserido com sucesso.";
						//redireciono
						$this->_redirect($_SERVER['HTTP_REFERER']);
					}
					catch(Exception $e) {
						die(var_dump($e));
					}
			}else{
				$messages->error = "Você Não pode acessar esta página por aqui!";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
				$messages->error = "Você precisa estar logado para comentar no blog!";
				//retorno o cadastro rapido
				$this->_redirect("/cadastro-rapido");
		}
	}

	/**
	*Funcao responsavel por curtir um post
	**/
	public function curtirpostAction(){

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
			$model_mensagens = new Default_Model_Comentariosblog();
			//recupero o id da msg
			$idmsg = $this->_request->getparam("idpost");
			//crio a query para receber a quantidade de curtidas
			$select = $model_mensagens->select()
						->from("blog_coments", array("NR_SEQ_COMENTARIO_CBRC",
										"NR_CURTIRAM_CBRC"))
						->where("NR_SEQ_COMENTARIO_CBRC = ?", $idmsg);

			//recebo o resultado da pesquisa
			$resultado = $model_mensagens->fetchRow($select);
			//agora cada curtida ganha um ponto
			$total_curtida = $resultado->NR_CURTIRAM_CBRC + 1;

			$data = array("NR_CURTIRAM_CBRC" => $total_curtida);


			$model_mensagens->update($data, array("NR_SEQ_COMENTARIO_CBRC = $idmsg"));

			$mensagem->success = "Operação realizada com sucesso.";

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{

			$mensagem->error = "Você precisa estar logado para curtir um comentário.";

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	*Funcao responsavel por Nao curtir um post
	**/
	public function naocurtirpostAction(){

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
			$model_mensagens = new Default_Model_Comentariosblog();
			//recupero o id da msg
			$idmsg = $this->_request->getparam("idpost");
			//crio a query para receber a quantidade de curtidas
			$select = $model_mensagens->select()
						->from("blog_coments", array("NR_SEQ_COMENTARIO_CBRC",
										"NR_NAOCURTIRAM_CBRC"))
						->where("NR_SEQ_COMENTARIO_CBRC = ?", $idmsg);
			//recebo o resultado da pesquisa
			$resultado = $model_mensagens->fetchRow($select);
			//agora cada curtida ganha um ponto
			$total_curtida = $resultado->NR_NAOCURTIRAM_CBRC + 1;

			$data = array("NR_NAOCURTIRAM_CBRC" => $total_curtida);

			$model_mensagens->update($data,  array("NR_SEQ_COMENTARIO_CBRC = $idmsg"));

			$mensagem->success = "Operação realizada com sucesso.";

			$this->_redirect($_SERVER['HTTP_REFERER']);

		}else{
			$mensagem->error = "Você precisa estar logado para não curtir um comentário.";

			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}
}

