<?php

/**
 *
 */
class Painel_SiteController extends Reverb_Controller_Action {
	/**
	 *
	 */
	public function init() {
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
		date_default_timezone_set('America/Sao_Paulo');
	}

	/**
	 *Banners cadastrados
	 */
	public function indexAction(){

        $modelBannerslocal = new Default_Model_Bannerslocal();
        $selectBannerslocal = $modelBannerslocal->select()
            ->from(array('bl' => 'banners_locais'), array())
            ->joinInner(array('b' => 'banners'), 'b.NR_SEQ_LOCAL_BARC = bl.NR_SEQ_BANLOCAL_BLRC', array())
            ->columns(array(
                'bl.NR_SEQ_BANLOCAL_BLRC',
                'bl.DS_LOCAL_BLRC',
                'bl.ST_LOCAL_BLRC'
            ))
            ->where('NR_SEQ_BANLOCAL_BLRC not in (14,15,16,17,18,19,22,23,24,25,26,32,33,34,35,36,37)')
            ->group('NR_SEQ_BANLOCAL_BLRC')
			->setIntegrityCheck(FALSE);

        $dadosBannerslocal = $modelBannerslocal->fetchAll($selectBannerslocal);
        $this->view->dadosBannerslocal = $dadosBannerslocal;
	}

	/**
	 *Novo Banner
	 */
	public function novoBannerAction() {

		if($this->_request->isPost()){
			$message = new Zend_Session_Namespace('messages');

			try{
				$modelBanner = new Default_Model_Banners();
				$dadosPost = $this->_request->getParams();

				unset($dadosPost['module']);
				unset($dadosPost['controller']);
				unset($dadosPost['action']);
				unset($dadosPost['imagem']);

				$dadosPost['ST_BANNER_BARC'] = 'A';
				$dadosPost['DT_CADASTRO_BARC'] = date('Y-m-d h:i:s');
				$dadosPost['NR_POSICAO_BARC'] = 1;

				$idBanner = $modelBanner->insert($dadosPost);

				$arquivo = isset($_FILES["imagem"]) ? $_FILES["imagem"] : FALSE;

				if($arquivo['name']){
					preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);

					$imagem_nome = $idBanner . "." . $ext[1];

					$imagem_dir = APPLICATION_PATH . "/../arquivos/uploads/banners/" . $imagem_nome;

					move_uploaded_file($arquivo["tmp_name"], $imagem_dir);

					$modelBanner->update(array('DS_EXT_BARC' => $ext[1]), array('NR_SEQ_BANNER_BARC = ?' => $idBanner));
				}

				$message->success = 'Banner cadastrado com sucesso.';
			}catch (Exception $e){
				$message->error = 'Ocorreu um erro ao cadastrar o banner.';
			}

			$this->_redirect('/painel/site');
		}else{
			$modelBannerslocal = new Default_Model_Bannerslocal();
			$selectBannerslocal = $modelBannerslocal->select()
				->from(array('bl' => 'banners_locais'), array())
				->columns(array(
					'NR_SEQ_BANLOCAL_BLRC',
					'DS_LOCAL_BLRC',
					'ST_LOCAL_BLRC'
				))
				->where('NR_SEQ_BANLOCAL_BLRC not in (14,15,16,17,18,19,22,23,24,25,26,32,33,34,35,36,37)');

			$dadosBannerslocal = $modelBannerslocal->fetchAll($selectBannerslocal);
			$this->view->dadosBannerslocal = $dadosBannerslocal;
		}
	}

	/**
	 *
	 */
	public function editarBannerAction(){
		$id = $this->_request->getParam('id');
		$message = new Zend_Session_Namespace('messages');

		if(!empty($id)){
			if($this->_request->isPost()){
				try{
					$modelBanner = new Default_Model_Banners();

					$dadosPost = $this->_request->getParams();

					unset($dadosPost['module']);
					unset($dadosPost['controller']);
					unset($dadosPost['action']);
					unset($dadosPost['imagem']);
					unset($dadosPost['id']);

					$dadosPost['ST_BANNER_BARC'] = 'A';
					$dadosPost['DT_CADASTRO_BARC'] = date('Y-m-d h:i:s');
					$dadosPost['NR_POSICAO_BARC'] = 1;

					$modelBanner->update($dadosPost, array('NR_SEQ_BANNER_BARC = ?' => $id));

					$arquivo = isset($_FILES["imagem"]) ? $_FILES["imagem"] : FALSE;

					if($arquivo['name']){
						preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);

						$imagem_nome = $id . "." . $ext[1];

						$imagem_dir = APPLICATION_PATH . "/../arquivos/uploads/banners/" . $imagem_nome;

						move_uploaded_file($arquivo["tmp_name"], $imagem_dir);

						$modelBanner->update(array('DS_EXT_BARC' => $ext[1]), array('NR_SEQ_BANNER_BARC = ?' => $id));
					}
					$message->success = 'Banner editado com sucesso.';
				}catch (Exception $e){
					$message->error = 'Ocorreu um problema ao editar o banner.';
				}

				$this->_redirect('/painel/site');
			}else{
				$modelBanner = new Default_Model_Banners();
				$dadosBanner = $modelBanner->fetchRow(array('NR_SEQ_BANNER_BARC = ?' => $id));

				$modelBannerslocal = new Default_Model_Bannerslocal();
				$selectBannerslocal = $modelBannerslocal->select()
					->from(array('bl' => 'banners_locais'), array())
					->columns(array(
						'NR_SEQ_BANLOCAL_BLRC',
						'DS_LOCAL_BLRC',
						'ST_LOCAL_BLRC'
					))
					->where('NR_SEQ_BANLOCAL_BLRC not in (14,15,16,17,18,19,22,23,24,25,26,32,33,34,35,36,37)');

				$dadosBannerslocal = $modelBannerslocal->fetchAll($selectBannerslocal);

				$this->view->dadosBannerslocal = $dadosBannerslocal;
				$this->view->dadosBanner = $dadosBanner;
			}
		}
	}

	/**
	 *
	 */
	public function ativarBannerAction(){
		$id = $this->_request->getParam('id');

		if(!empty($id)){
			$message = new Zend_Session_Namespace('messages');

			$modelBanner = new Default_Model_Banners();
			$modelBanner->update(array('ST_BANNER_BARC' => 'A'), array('NR_SEQ_BANNER_BARC = ?' => $id));

			$message->success = 'Banner ativado com sucesso.';
		}

		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 *
	 */
	public function desativarBannerAction(){
		$id = $this->_request->getParam('id');

		if(!empty($id)){
			$message = new Zend_Session_Namespace('messages');

			$modelBanner = new Default_Model_Banners();
			$modelBanner->update(array('ST_BANNER_BARC' => 'I'), array('NR_SEQ_BANNER_BARC = ?' => $id));

			$message->success = 'Banner desativado com sucesso.';
		}

		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 *Novo local para banner
	 */
	public function novoLocalBannerAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";
	}

	/**
	 *Lista posts
	 */
	public function listaPostsAction() {
		if($this->_request->isPost()){
			$termo = $this->_request->getParam('termo');
			if(!empty($termo)){
				$this->_redirect('/painel/site/lista-posts/busca/' . $termo);
			}else{
				$this->_redirect('/painel/site/lista-posts');
			}
		}

		$modelBlog = new Default_Model_Blog();
		$selectBlog = $modelBlog->select()
			->from(array('b' => 'blog'), array())
			->columns(array(
				'NR_SEQ_BLOG_BLRC',
				'DS_STATUS_BLRC',
				'DT_PUBLICACAO_BLRC',
				'DS_TITULO_BLRC'
			))
			->order('DT_PUBLICACAO_BLRC DESC');

		$busca = $this->_request->getParam('busca');

		if(!empty($busca)){
			$selectBlog->where("DS_TITULO_BLRC LIKE '%".addslashes($busca)."%'");

			$this->view->busca = $busca;
		}

		$current_page = $this->_request->getParam("page", 1);
		$dadosBlog = new Reverb_Paginator($selectBlog);
		$dadosBlog->setItemCountPerPage(15)
			->setCurrentPageNumber($current_page)
			->setPageRange(5)
			->assign();

		$this->view->dadosBlog = $dadosBlog;
	}

	/**
	 * Comentários
	 */
	public function comentariosAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";
	}


	/**
	 * Cadastro posts
	 */
	public function cadastroPostAction() {

		if($this->_request->isPost()){
			$dadosPost = $this->_request->getParams();
			$message = new Zend_Session_Namespace('messages');

			unset($dadosPost['module']);
			unset($dadosPost['controller']);
			unset($dadosPost['action']);

			$dadosPost['DT_PUBLICACAO_BLRC'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_PUBLICACAO_BLRC'])));
			$dadosPost['DS_STATUS_BLRC'] = 'A';

			$dadosPost['DT_CADASTRO_BLRC'] = date('Y-m-d H:i:s');

			try{
				$modelBlog = new Default_Model_Blog();
				$idBlog = $modelBlog->insert($dadosPost);

				$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;

				if($arquivo['name']){
					preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);

					$imagem_nome = $idBlog . "." . $ext[1];

					$imagem_dir = APPLICATION_PATH . "/../arquivos/uploads/blog/" . $imagem_nome;

					move_uploaded_file($arquivo["tmp_name"], $imagem_dir);

					$modelBlog->update(array('DS_EXT_BLRC' => $ext[1]), array('NR_SEQ_BLOG_BLRC = ?' => $idBlog));
				}

				$message->success = 'Post criado com sucesso.';
			}catch (Exception $e){
				die($e->getMessage());
				$message->error = 'Ocorreu um erro ao criar o post.';
			}

			$this->_redirect('/painel/site/lista-posts');
		}else{
			$modelColunista = new Default_Model_Colunista();
			$dadosColunista = $modelColunista->fetchAll(null, 'DS_COLUNISTA_CORC ASC');

			$modelBlogCategoria = new Default_Model_Blogcategorias();
			$dadosBlogCategoria = $modelBlogCategoria->fetchAll(null, 'DS_CATEGORIA_BCRC ASC');

			$this->view->dadosBlogCategoria = $dadosBlogCategoria;
			$this->view->dadosColunista = $dadosColunista;
		}
	}

	/**
	 * Cadastro posts
	 */
	public function editarPostAction() {

		if($this->_request->isPost()){
			$dadosPost = $this->_request->getParams();
			$message = new Zend_Session_Namespace('messages');

			$idBlog = $this->_request->getParam('id');

			unset($dadosPost['module']);
			unset($dadosPost['controller']);
			unset($dadosPost['action']);
			unset($dadosPost['id']);

			$dadosPost['DT_PUBLICACAO_BLRC'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_PUBLICACAO_BLRC'])));
			$dadosPost['DS_STATUS_BLRC'] = 'A';

			try{
				$modelBlog = new Default_Model_Blog();
				$modelBlog->update($dadosPost, array('NR_SEQ_BLOG_BLRC = ?' => $idBlog));

				$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;

				if($arquivo['name']){
					preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);

					$imagem_nome = $idBlog . "." . $ext[1];

					$imagem_dir = APPLICATION_PATH . "/../arquivos/uploads/blog/" . $imagem_nome;

					move_uploaded_file($arquivo["tmp_name"], $imagem_dir);

					$modelBlog->update(array('DS_EXT_BLRC' => $ext[1]), array('NR_SEQ_BLOG_BLRC = ?' => $idBlog));
				}

				$message->success = 'Post criado com sucesso.';
			}catch (Exception $e){
				die($e->getMessage());
				$message->error = 'Ocorreu um erro ao criar o post.';
			}

			$this->_redirect('/painel/site/lista-posts');
		}else{
			$id = $this->_request->getParam('id');

			$modelBlog = new Default_Model_Blog();
			$dadosBlog = $modelBlog->fetchRow(array('NR_SEQ_BLOG_BLRC = ?' => $id));

			$modelColunista = new Default_Model_Colunista();
			$dadosColunista = $modelColunista->fetchAll(null, 'DS_COLUNISTA_CORC ASC');

			$modelBlogCategoria = new Default_Model_Blogcategorias();
			$dadosBlogCategoria = $modelBlogCategoria->fetchAll(null, 'DS_CATEGORIA_BCRC ASC');

			$this->view->dadosBlogCategoria = $dadosBlogCategoria;
			$this->view->dadosColunista = $dadosColunista;
			$this->view->dadosBlog = $dadosBlog;
		}
	}

	/**
	 *
	 */
	public function ativarPostAction(){
		$id = $this->_request->getParam('id');

		if(!empty($id)){
			$message = new Zend_Session_Namespace('messages');

			$modelBlog = new Default_Model_Blog();
			$modelBlog->update(array('DS_STATUS_BLRC' => 'A'), array('NR_SEQ_BLOG_BLRC = ?' => $id));

			$message->success = 'Post ativado com sucesso.';
		}

		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 *
	 */
	public function desativarPostAction(){
		$id = $this->_request->getParam('id');

		if(!empty($id)){
			$message = new Zend_Session_Namespace('messages');

			$modelBlog = new Default_Model_Blog();
			$modelBlog->update(array('DS_STATUS_BLRC' => 'I'), array('NR_SEQ_BLOG_BLRC = ?' => $id));

			$message->success = 'Post desativado com sucesso.';
		}

		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Nova categoria
	 */
	public function novaCategoriaAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";

	}

	/**
	 * Novo colunista
	 */
	public function novaColunistaAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";

	}


	/**
	 * Objetos cadastrados
	 */
	public function objetosCadastradosAction() {

		if($this->_request->isPost()){
			$termo = $this->_request->getParam('termo');
			if(!empty($termo)){
				$this->_redirect('/painel/site/objetos-cadastrados/busca/' . $termo);
			}else{
				$this->_redirect('/painel/site/objetos-cadastrados');
			}
		}

		$modelCycle = new Default_Model_Reverbcycle();

		$selectCycle = $modelCycle->select()
			->from(array('rc' => 'reverbcycle'), array())
			->join(array('c' => 'cadastros'), 'NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_RCRC', array())
			->join(array('rct' => 'reverbcycle_categorias'), 'NR_SEQ_CATEGREV_RVRC = NR_SEQ_CATEGREV_RCRC', array())
			->columns(array(
				'rc.NR_SEQ_REVERBCYCLE_RCRC',
				'rc.DS_EXT_RCRC',
				'rc.DT_CADASTRO_RCRC',
				'c.DS_NOME_CASO',
				'rct.DS_CATEGORIA_RVRC'
			))
			->order('rc.NR_SEQ_REVERBCYCLE_RCRC DESC')
			->setIntegrityCheck(FALSE);

		$busca = $this->_request->getParam('busca');

		if(!empty($busca)){
			$selectCycle->where("c.DS_NOME_CASO LIKE '%".addslashes($busca)."%'");

			$this->view->busca = $busca;
		}

		$current_page = $this->_request->getParam("page", 1);
		$dadosCycle = new Reverb_Paginator($selectCycle);
		$dadosCycle->setItemCountPerPage(15)
			->setCurrentPageNumber($current_page)
			->setPageRange(5)
			->assign();

		$this->view->dadosCycle = $dadosCycle;

	}


	/**
	 * Objetos cadastrados
	 */
	public function cadastroObjetoAction() {

		$modelCycle = new Default_Model_Reverbcycle();
	}

    
    /*
    /WS para receveber upload das imagens via WS
     *devido ao suporte á upload de várias imagens.
    */
    
    public function imagesAction(){
        $return['success'] = FALSE;
        $body = $this->getRequest()->getRawBody();
        $dados = Zend_Json::decode($body);

	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < 20; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
        try{
            //decodar as imagens em 
            if( preg_match('/data\:image\/jpeg\;base64,/', $dados['image']) ){
                $return['ext'] = 'jpg';
                $dados['image'] = preg_replace('/data\:image\/jpeg\;base64,/', '', $dados['image']);
            }elseif( preg_match('/data\:image\/jpg\;base64,/', $dados['image']) ){
                $return['ext'] = 'jpg';
                $dados['image'] = preg_replace('/data\:image\/jpg\;base64,/', '', $dados['image']);
            }elseif( preg_match('/data\:image\/png\;base64,/', $dados['image']) ){
                $return['ext'] = 'png';
                $dados['image'] = preg_replace('/data\:image\/png\;base64,/', '', $dados['image']);
            }
            $decodeEcg = base64_decode($dados['image']);

            $filenameEcg = md5(time() . $randomString) . ".".$return['ext'];
            file_put_contents(APPLICATION_PATH . "/../arquivos/uploads/teste/" . $filenameEcg, $decodeEcg);   
            $return['success'] = TRUE;
            $return['file'] = $filenameEcg;
        }catch(Exception $err){
            $return['success'] = FALSE;
            $return['err'] = $err->getMessage();
        }
        
        //header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        // Passa o retorno em json
        $this->_helper->json($return);
    }	

	/**
	 * Fotos cadastrados
	 */
	public function fotosCadastradasAction() {
		if($this->_request->isPost()){
			$termo = $this->_request->getParam('termo');
			if(!empty($termo)){
				$this->_redirect('/painel/site/fotos-cadastradas/busca/' . $termo);
			}else{
				$this->_redirect('/painel/site/fotos-cadastradas');
			}
		}

		$modelPeople = new Default_Model_Reverbme();
		$selectPeople = $modelPeople->select()
			->from(array('c' => 'cadastros'), array())
			->join(array('mf' => 'me_fotos'), 'mf.NR_SEQ_CADASTRO_FORC = c.NR_SEQ_CADASTRO_CASO', array())
			->columns(array(
				'mf.NR_SEQ_FOTO_FORC',
				'mf.DS_EXT_FORC',
				'mf.DT_CADASTRO_FORC',
				'c.DS_NOME_CASO'
			))
			->order('mf.NR_SEQ_FOTO_FORC DESC')
			->setIntegrityCheck(FALSE);

		$busca = $this->_request->getParam('busca');

		if(!empty($busca)){
			$selectPeople->where("c.DS_NOME_CASO LIKE '%".addslashes($busca)."%'");

			$this->view->busca = $busca;
		}

		$current_page = $this->_request->getParam("page", 1);
		$dadosPeople = new Reverb_Paginator($selectPeople);
		$dadosPeople->setItemCountPerPage(15)
			->setCurrentPageNumber($current_page)
			->setPageRange(5)
			->assign();

		$this->view->dadosPeople = $dadosPeople;

	}

	/**
	 * Ordem das fotos
	 */
	public function ordemFotosAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";

	}

	/**
	 * Tópicos cadastrados
	 */
	public function topicosCadastradosAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";

	}

	/**
	 * Tópicos ? temas ?  cadastrados
	 */
	public function temasCadastradosAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";

	}

	/**
	 * Cadastrar tópico
	 */
	public function cadastrarTopicoAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";

	}

	/**
	* Receve imgs
	*/

	public function imagesCollectionAction(){
		$type = 'teste';
		$return = array(
			'images' => array(),
			'type' => $type,
		);
        try{
            foreach ($_FILES as $key => $file) {
            	$extension = pathinfo(basename($file['name']), PATHINFO_EXTENSION);
            	$name = time() . '.' . $extension;
            	$path = APPLICATION_PATH . "/../arquivos/uploads/{$type}/" . $name;
	            if(move_uploaded_file($file['tmp_name'], $path)){
	            	$return['images'][] = array(
	            		'name' => $name,
	            		'path' => $this->view->basePath . '/arquivos/uploads/' . $type . '/' . $name,
	            		'type' => $type,
	            	);
	            }
				sleep(1);
            }
		}catch(Exception $er){
			die($er->getMessage());
		}

		$this->_helper->json($return);
 	}

}

