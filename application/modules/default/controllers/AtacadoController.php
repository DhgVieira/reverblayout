<?php

/**
*
*/
class AtacadoController extends Zend_Controller_Action {
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

        $this->view->title = "Reverbcity - Atacado";
		$this->view->description = "Quer comprar em grande quantidade para revender? A reverbcity também trabalha desta forma!";
		$this->view->keywords = "Reverbcity, atacado, revenda ,musica, indie, rock, bandas";


	}

	/** 
	 * lista os produtos
	 */
	public function indexAction() {
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessao dos cliente
		$usuarios = new Zend_Session_Namespace("usuarios");


		//verifico se existe um usuario logado
		if ($usuarios->logado == TRUE) {
			//se o usuario for PJ fica na página, senao é redirecionado para o cadastro de logista
			if ($usuarios->tipo == "PJ"){

				//recebo os parametros da url
				$categoria = $this->_request->getParam("categoria");
				$tamanho = $this->_request->getParam("tamanho");
				$genero = $this->_request->getParam("genero");
				$cor = $this->_request->getParam("cor");
				$palavra = $this->_request->getParam("busca_produto");
				$valor = $this->_request->getParam("valor");
				//Inicio o model de produtos
				$model_produtos = new Default_Model_Produtos();
				//crio a query de produtos
				$select_produtos = $model_produtos->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('produtos', array('NR_SEQ_PRODUTO_PRRC',
										 'VL_PRODUTO_PRRC',
										 'DS_PRODUTO_PRRC',
										 'DS_EXT_PRRC',
										 'TP_DESTAQUE_PRRC',
										 'DS_FRETEGRATIS_PRRC',
										 'NR_SEQ_CATEGORIA_PRRC',
										 'NR_SEQ_TIPO_PRRC',
										  'VL_PROMO_PRRC'))
				->joinInner("estoque",
							"produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
				->joinLeft("tamanhos",
							"tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
				//coloco as condições pertence so a loja
				->where("NR_SEQ_LOJAS_PRRC = 1")
				//nao e classic
				->where("DS_CLASSIC_PRRC = 'N'")
				//produto e ativo
				->where("ST_PRODUTOS_PRRC = 'A'")
				//quantidade em estoque positiva
				->where("NR_QTDE_ESRC > 0")
				//removo os buttons
				->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)")
				//sem canexas
				->where("NR_SEQ_CATEGORIA_PRRC not in (57)");
                                
				//agora coloco as condições da url, dependendo dos parametros
				if($valor == 29.90){
					$select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
					//assino ao view a categoria
					$this->view->valor_url = $valor;
				}
				if($valor == 30){
					$select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
					//assino ao view a categoria
					$this->view->valor_url = $valor;
				}
				if($valor == 61){
					$select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
					//assino ao view a categoria
					$this->view->valor_url = $valor;
				}
				if($valor == 90){
					$select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
					//assino ao view a categoria
					$this->view->valor_url = $valor;
				}
				if ($categoria != ""){
					$select_produtos->where("NR_SEQ_CATEGORIA_PRRC = ". $categoria);
					//assino ao view a categoria
					$this->view->cat_url = $categoria;
				}
				//se existir palavra a ser buscada
				if($palavra != ""){
					$select_produtos->where("DS_PRODUTO_PRRC LIKE '%". $palavra . "%'");
					//assino ao view a palavra
					$this->view->palavra_busca = $palavra;
				}
				//se for masculino
				if($genero == "masculino"){
					$select_produtos->where("DS_GENERO_PRRC = 'M'");
					//assino ao view o genero
					$this->view->genero = $genero;
				}
				//se for feminino
				if($genero == "feminino"){
					$select_produtos->where("DS_GENERO_PRRC = 'F'");
					//assino ao view o genero
					$this->view->genero = $genero;
				}
				//se tiver um tipo de produto selecionado
				if ($tipo != ""){
					$select_produtos->where("NR_SEQ_TIPO_PRRC = ". $tipo);
					//assino ao view a categoria
					$this->view->tipo_url = $tipo;
				}
				//se tiver uma cor selecionada
				if ($cor != ""){
					$select_produtos->where("NR_SEQ_COR_PRRC = ". $cor);
					//assino ao view a categoria
					$this->view->cor_url = $cor;
				}
				//se o tamanho do produto for p
				if ($tamanho == "p"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 2 or NR_SEQ_TAMANHO_TARC = 7" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for m
				if ($tamanho == "m"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 3 or NR_SEQ_TAMANHO_TARC = 8" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for g
				if ($tamanho == "g"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 4 or NR_SEQ_TAMANHO_TARC = 9" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for gg
				if ($tamanho == "gg"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 5 or NR_SEQ_TAMANHO_TARC = 10" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for xgg
				if ($tamanho == "xgg"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 33" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}		//agrupo por codigo do produto
				$select_produtos->group("NR_SEQ_PRODUTO_PRRC")
				//ordeno pela ordem de ordenacao de produtos
				->order('NR_ORDEM_PRRC ASC');
                                
				
			
			// crio a paginação para proximo e para anterior
				$paginator = new Reverb_Paginator($select_produtos);
				//defino a quantidade de itens por pagina
				$paginator->setItemCountPerPage(12)
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
				$contador = new Reverb_Paginator($select_produtos);
				//defino o numero de itens a serem exibidos por página
				$contador->setItemCountPerPage(12)
				//pega o numero da pagina
				->setCurrentPageNumber($current_page)
				//defino quantas páginas iram aparecer por vez
				->setPageRange(5)
				//assino a paginacao
				->assign();		
				//assino ao view
				$this->view->contadores = $contador;

				/*
		/aqui inicio o filtro dinamico
		*/

		$model_menu = new Default_Model_Menusite();

		//consulta para os tipos
		$select_tipos = $model_menu->select()
		//digo que não existe integridade
		->setIntegrityCheck(false)
		//escolho a tabela do banco para o join
		->from('menu_site', array("idmenu"))
		//faço o join
		->joinInner("menu_site_has_produtos_tipo", "menu_site_has_produtos_tipo.menu_site_idmenu = menu_site.idmenu", array(""))
		//faço o join de outra tabela
		->joinInner("produtos_tipo", "menu_site_has_produtos_tipo.produtos_tipo_NR_SEQ_CATEGPRO_PTRC = produtos_tipo.NR_SEQ_CATEGPRO_PTRC", array("NR_SEQ_CATEGPRO_PTRC", "DS_CATEGORIA_PTRC"))
		//coloco o array do produto
		->joinInner("produtos", "produtos.NR_SEQ_TIPO_PRRC = produtos_tipo.NR_SEQ_CATEGPRO_PTRC", array("TP_DESTAQUE_PRRC"))
		//coloco as condicoes
		//agora faço as condições
		->where("DS_STATUS_PTRC = 'A'")
		//coloco as condições pertence so a loja
		->where("NR_SEQ_LOJAS_PRRC = 1")
		//somente onde tiver produtos com destaque
		->where("DS_GENERO_PRRC = 'M'")
		//nao e classic
		->where("DS_CLASSIC_PRRC = 'N'");
		//agora verifico o que foi feito no filtro
		if ($categoria != ""){
			$select_tipos->where("NR_SEQ_CATEGORIA_PRRC = ". $categoria);
		}
		//se tiver uma cor selecionada
		if ($cor != ""){
			//se tiver cor selecionada coloco no filtro
			$select_tipos->where("NR_SEQ_COR_PRRC = ". $cor);
		}
		//se tiver uma cor selecionada
		if($valor == 29.90){
			$select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
		}
		if($valor == 30){
			$select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
		}
		if($valor == 61){
			$select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
		}
		if($valor == 90){
			$select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");	
		}

		//agora agrupo
		$select_tipos->group("NR_SEQ_CATEGPRO_PTRC");
		//crio uma lista de tipo
		$lista_tipos = $model_menu->fetchAll($select_tipos)->toArray();

		//assino os amigos ao view
		$this->view->tipos = $lista_tipos;

		//inicio a consulta das categoria
		$select_categorias = $model_menu->select()
		//seto falsa integridade
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('menu_site', array("idmenu"))
		//faço o join
		->joinInner("menu_site_has_produtos_categoria", "menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu")
		//faço outro joint
		->joinInner("produtos_categoria", "menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("NR_SEQ_CATEGPRO_PCRC", "DS_CATEGORIA_PCRC"))
		//faço o join de produtos para ver quais categorias tem novidades
		->joinInner("produtos", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("TP_DESTAQUE_PRRC"))
		//agora faço as condições
		->where("DS_STATUS_PCRC = 'A'")
		//somente onde tiver produtos com destaque
		->where("DS_GENERO_PRRC = 'F'")
		//coloco as condições pertence so a loja
		->where("NR_SEQ_LOJAS_PRRC = 1")
		//nao e classic
		->where("DS_CLASSIC_PRRC = 'N'");
		//se tiver uma cor selecionada
		if ($cor != ""){
			//se tiver cor selecionada coloco no filtro
			$select_categorias->where("NR_SEQ_COR_PRRC = ". $cor);
		}
		//se tiver uma cor selecionada
		if($valor == 29.90){
			$select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
		}
		if($valor == 30){
			$select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
		}
		if($valor == 61){
			$select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
		}
		if($valor == 90){
			$select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
			
		}
		if($tipo != ""){
			$select_categorias->where("NR_SEQ_TIPO_PRRC = ?", $tipo);
		}
		//agora agrupo
		$select_categorias->group("NR_SEQ_CATEGPRO_PCRC");


		//crio uma lista de categorias
		$lista_categoria = $model_menu->fetchAll($select_categorias)->toArray();

		//assino as categorias ao view
		$this->view->categorias = $lista_categoria;


		$select_cor = $model_menu->select()
		//seto falsa integridade
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('menu_site', array("idmenu"))
		//faço o join
		->joinInner("menu_site_has_cores", "menu_site.idmenu = menu_site_has_cores.menu_site_idmenu")
		//faço outro join
		->joinInner("cores", "menu_site_has_cores.cores_idcor = cores.idcor")
		//faço outro join
		->joinInner("produtos", "cores.idcor = produtos.NR_SEQ_COR_PRRC", array("NR_SEQ_COR_PRRC"))
		//somente onde tiver produtos com destaque feminino
		->where("DS_GENERO_PRRC = 'F'")
		//coloco as condições pertence so a loja
		->where("NR_SEQ_LOJAS_PRRC = 1")
		//nao e classic
		->where("DS_CLASSIC_PRRC = 'N'");
		if($tipo != ""){
			$select_cor->where("NR_SEQ_TIPO_PRRC = ?", $tipo);
		}
		if ($categoria != ""){
			$select_cor->where("NR_SEQ_CATEGORIA_PRRC = ". $categoria);
		}
		//se tiver um valor relacionado
		if($valor == 29.90){
			$select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
		}
		if($valor == 30){
			$select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
		}
		if($valor == 61){
			$select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
		}
		if($valor == 90){
			$select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
		}
		//agora faço as condições
		$select_cor->group("idcor");

		//crio uma lista de categorias
		$lista_cores = $model_menu->fetchAll($select_cor)->toArray();

		$this->view->cores = $lista_cores;

		

		//agora para cada cor assino uma variavel
		foreach ($lista_cores as $key => $cor) {
			//agora verifico se tem as cores
			switch ($cor["idcor"]) {
				case 1:
					$this->view->tem_preto = 1;
				break;
				
				case 2:
					$this->view->tem_cinza = 1;
				break;

				case 3:
					$this->view->tem_branco = 1;
				break;

				case 4:
					$this->view->tem_vermelho = 1;
				break;

				case 5:
					$this->view->tem_amarelo = 1;
				break;

				case 6:
					$this->view->tem_verde = 1;
				break;

				case 7:
					$this->view->tem_azul = 1;
				break;

				case 8:
					$this->view->tem_marrom = 1;
				break;

				case 9:
					$this->view->tem_roxo = 1;
				break;

				case 10:
					$this->view->tem_laranja = 1;
				break;

				case 11:
					$this->view->tem_creme = 1;
				break;

				case 12:
					$this->view->tem_rosa = 1;
				break;
			}
		}


			//redireciona para o cadastro de logista
			}else{
				//falo para o usuario que ele precisa ser atacadista
				$messages->error = "Desculpe, Você precisa ser cadastrado como pessoa jurídica para acessar esta sessão.";
				//redireciono
				$this->_redirect("/meu-perfil");
			}
		//se nãou houver usuario logado direciona para o cadastro
		}else{
			$this->_redirect("atacado/cadastrolojista");
		}	

		


	}
	
	/**
	 * Função responsável pelo cadastro de lojista
	 */
	public function cadastrolojistaAction() {

        $this->view->title = "Atacado - Reverbcity.com";
        $this->view->description = "";
        $this->view->keywords = "Reverbcity, acatado, vendas, login";

		// Cria a sessão das mensagens
		$session = new Zend_Session_Namespace("messages");
		
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == true) {
			//se o usuario for PJ fica na página, senao é redirecionado para o cadastro de logista
			if ($usuarios->tipo == "PJ"){
				$this->_redirect("atacado/index");
			}else{
				$this->_redirect("/meu-perfil");
			}
			//se existir eu redireciono para a página do perfil
			$this->_redirect("atacado/index");
		}

		//verifico se é uma requisicao de post para realizar o contato
		if ($this->_request->isPost()) {
			
			//inicio o model da tabela de Reverbme
			$model = new Default_Model_Reverbme();

			//recebo o email
			$mail = $this->_request->getParam('atacadistaemail');

			//crio a query para verificar se existe email cadastrado
			$select_email = $model->select()->
							from("cadastros", array("DS_EMAIL_CASO"))
							->where("DS_EMAIL_CASO like '%".$mail."%'");

			//armazeno em uma variavel
			$existe_mail = $model->fetchRow($select_email);


			if($existe_mail->DS_EMAIL_CASO != ""){

				// Envio um feedback de sucesso ao usuário.
				$session->error = "Desculpe, já existe uma conta vinculada com este e-mail!";
				//redireciono para a última página visitada
				$this->_redirect($_SERVER['HTTP_REFERER']);

			}
			//recebo o cnpj
			$cnpj = $this->_request->getParam('cnpj');

			//crio a query para verificar se existe email cadastrado
			$select_cnpj = $model->select()->
							from("cadastros", array("DS_CPFCNPJ_CASO"))
							->where("DS_CPFCNPJ_CASO like '%".$cnpj."%'");

			//armazeno em uma variavel
			$existe_cnpj = $model->fetchRow($select_cnpj);


			if($existe_cnpj->DS_CPFCNPJ_CASO != ""){

				// Envio um feedback de sucesso ao usuário.
				$session->error = "Desculpe, já existe uma conta vinculada com este CNPJ!";
				//redireciono para a última página visitada
				$this->_redirect($_SERVER['HTTP_REFERER']);

			}

			//recebo os parametros para compor data de nascimento
			$dia =  $this->_request->getParam('dia');
			$mes =  $this->_request->getParam('mes');
			$ano =  $this->_request->getParam('ano');
			//concateno a data de nascimento
			$data_nascimento = $ano."-".$mes."-".$dia;

			//crio um array com os campos do formulario
			$data = array('DS_NOMEFANTASIA_CACH' => $this->_request->getParam('nomefantasia'),
						  'DS_NOME_CASO' => $this->_request->getParam('razaosocial'),
						  'DS_CONTATO_CACH' => $this->_request->getParam('contato'),
				          'DT_NASCIMENTO_CASO' => $data_nascimento,
				          'DS_CPFCNPJ_CASO' => $this->_request->getParam('cnpj'),
				          'DS_INSCRICAO_CACH' => $this->_request->getParam('inscricaoestadual'),
				          'DS_ENDERECO_CASO' => $this->_request->getParam('endereco'),
				          'DS_COMPLEMENTO_CASO' => $this->_request->getParam('complemento'),
			 			  'DS_CEP_CASO' => $this->_request->getParam('cep'),
			  			  'DS_UF_CASO' => $this->_request->getParam('estado'),
			   			  'DS_CIDADE_CASO' => $this->_request->getParam('cidade'),
			    		  'DS_PAIS_CACH' => $this->_request->getParam('pais'),
			     		  'DS_FONECOM_CASO' => $this->_request->getParam('telefone1'),
			      		  'DS_CELULAR_CASO' => $this->_request->getParam('telefone2'),
			       		  'DS_EMAIL_CASO' => $this->_request->getParam('atacadistaemail'),
			        	  'DS_SENHA_CASO' => $this->_request->getParam('atacadistasenha'),
			         	  'DS_OBS_CACH' => $this->_request->getParam('observacoes'),
			          	  'ST_ENVIO_CASO' => $this->_request->getParam('mailing'),
			           	  'ST_ENVIOSMS_CACH' => $this->_request->getParam('sms'),
			           	  'ST_CADASTRO_CASO'=> "A",
			           	  'DS_PROFILE_CACH' => "P",
			           	  'DS_TIPO_CASO'=> "PJ",
			           	  'TP_CADASTRO_CACH' => 1);

			//tento inserir o registro
			try {
				//insiro os registros no banco de dados
				$idme = $model->insert($data);

				//se tiver aquivo de foto
				if($arquivo["name"]){
					//pego a extensao
					preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
					//crio o nome da imagem
					$imagem_nome = $idme . "." . $ext[1];

					$data['DS_EXT_CACH'] = $ext[1];
						// Move o arquivo para o diretório
					move_uploaded_file($_FILES['foto']['tmp_name'], APPLICATION_PATH . "/../arquivos/uploads/reverbme/" . $imagem_nome);

					$model->update($data, array("NR_SEQ_CADASTRO_CASO = ?"=>$idme));

				}

						$usuarios->idperfil = $idme;
						$usuarios->logado = TRUE;
						$usuarios->nome = $data['DS_NOME_CASO'];
						$usuarios->email = $data['DS_EMAIL_CASO'];
						$usuarios->cidade = $data['DS_CIDADE_CASO'];
						$usuarios->uf = $data['DS_UF_CASO'];
						$usuarios->tipo = $data['DS_TIPO_CASO'];
						$usuarios->cep = $data['DS_CEP_CASO'];
						$usuarios->facebook = false;
						$usuarios->twitter = false;
						$usuarios->nascimento = $data['DT_NASCIMENTO_CASO'];
					
						// Envio um feedback de sucesso ao usuário.
						$session->success = "O cadastro foi realizado com sucesso!";

						$this->_redirect('/atacado/index');

			}catch(Exception $e) {
				// die(var_dump($e));
				// Envio um feedback de sucesso ao usuário.
				$session->error = "Ocorreu um erro no seu cadastro, por favor entre em contato e informe o ocorrido!";
				//redireciono para a última página visitada
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}
		}

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
		$this->view->banners = $banners_topo;
	}

	//função que lista o produto do lojista
	public function produtolojistaAction(){

		$idproduto = $this->_request->getParam("idproduto");

		//Inicio o model de produtos
		$model_produtos = new Default_Model_Produtos();
		//crio a query de produtos
		$select_produtos = $model_produtos->select()
		//seleciono somente as informacoes do produto
		->where("NR_SEQ_PRODUTO_PRRC = $idproduto");
		//assino ao view
		$this->view->produto = $model_produtos->fetchRow($select_produtos);

		//seleciono todas as fotos do produto
		// Cria o objeto de conexão
		$db = Zend_Registry::get("db");
		//crio a query para selecionar os amigos
		$select_fotos = "SELECT 
							NR_SEQ_FOTO_FORC,
							NR_SEQ_PRODUTO_FORC,
							DS_EXT_FORC,
							NR_ORDEM_FORC
						FROM
						   fotos
						WHERE 
						   NR_SEQ_PRODUTO_FORC = ". $idproduto ."
						ORDER BY 
							NR_ORDEM_FORC ASC";

			// Monta a query
			$query = $db->query($select_fotos);
			//crio uma lista de fotos
			$lista = $query->fetchAll();
			//assino os amigos ao view
			$this->view->fotos = $lista;

		//crio a query de categorias
		$select_categorias = "SELECT
								NR_SEQ_CATEGPRO_PCRC,
								DS_CATEGORIA_PCRC
							FROM
								produtos_categoria
							WHERE
								DS_STATUS_PCRC = 'A'
							ORDER BY
								DS_CATEGORIA_PCRC ASC"
							;

		// Monta a query
		$quer_categoria = $db->query($select_categorias);
		//crio uma lista de fotos
		$lista_categoria = $quer_categoria->fetchAll();
		//assino os amigos ao view
		$this->view->categorias = $lista_categoria;

		//inicio o model de estoque
		$model_estoque = new Default_Model_Estoque();
		//crio a query para listagem de estoque
		$select_estoque = $model_estoque->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('estoque')
		//crio o inner join das fotos	
		->joinInner('tamanhos',
				'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC',array('*'))
		//agora faco a condicao de que quero o estoque de apenas o produto desejado
		->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
		//agora falo em quais codigos de tamanho
		->where("estoque.NR_SEQ_TAMANHO_ESRC IN (33,1,2,3,4,5)")
		->order("NR_ORDEM_TARC ASC");
	
		//assino ao view
		$this->view->estoques_masculino = $model_estoque->fetchAll($select_estoque);

		//crio a query para listagem de estoque
		$select_estoque_feminino = $model_estoque->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('estoque')
		//crio o inner join das fotos	
		->joinInner('tamanhos',
				'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC',array('*'))
		//agora faco a condicao de que quero o estoque de apenas o produto desejado
		->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
		//agora falo em quais codigos de tamanho
		->where("estoque.NR_SEQ_TAMANHO_ESRC IN (6,7,8,9,10,47)")
		->order("NR_ORDEM_TARC ASC");

		//assino ao view
		$this->view->estoques_feminino = $model_estoque->fetchAll($select_estoque_feminino);


		//crio a query para listagem de estoque
		$select_estoque_geral = $model_estoque->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('estoque')
		//crio o inner join das fotos	
		->joinInner('tamanhos',
				'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC',array('*'))
		//agora faco a condicao de que quero o estoque de apenas o produto desejado
		->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
		//agora falo em quais codigos de tamanho
		->where("estoque.NR_SEQ_TAMANHO_ESRC NOT IN (6,7,8,9,10,33,1,2,3,4,5,47)")
		->order("NR_ORDEM_TARC ASC");

		//assino ao view
		$this->view->estoques_geral = $model_estoque->fetchAll($select_estoque_geral);

		//inicio a sessao de produtos vistos
		$produtos_vistos = new Zend_Session_Namespace("vistos");


		$produto = $model_produtos->fetchRow($select_produtos);

		$nome = $produto['DS_PRODUTO_PRRC'];
		$descricao = $produto['DS_INFORMACOES_PRRC'];
		$extensao_imagem = $produto["DS_EXT_PRRC"];
		$valor = $produto["VL_PRODUTO_PRRC"];
		$peso = $produto['NR_PESOGRAMAS_PRRC'];
		$valor_promo = $produto['VL_PROMO_PRRC'];
		
// 		Zend_Debug::dump($imagem);die;
		
		$produtos_vistos->produtos[$idproduto] = array(
				'codigo' => $idproduto,
				'nome'          => $nome,
				'descricao'     => $descricao,
				'path'   => $extensao_imagem,
				'valor'   => $valor,
				'peso'	=> $peso,
				'promo' => $valor_promo,
				'hora' => date("H:i:s")
		);

		//crio o model de notas
		$model_notas = new Default_Model_Produtosnotas();
		//crio a query para mostrar o resultado de notas de produtos
		$select_nota = $model_notas->select()
						->from("produtos_notas",array("idproduto",
												"soma_notas" => "ROUND((SELECT
																		SUM(nota)
																		AS
																			soma_notas
																		FROM
																		 	produtos_notas
																		WHERE
																		 	produtos_notas.idproduto = $idproduto) / 
																		(SELECT
																			COUNT(idprodutos_nota)
																		AS 
																			total_avaliacoes
																		FROM
																			produtos_notas
																		WHERE
																		 	produtos_notas.idproduto = $idproduto))"))
						->group("produtos_notas.idproduto");
		//assino ao view
		$this->view->nota = $model_notas->fetchRow($select_nota);
	
	// agora inicio a listagem dos comentarios do produto
		$model_coments = new Default_Model_Produtoscoments();
		//crio a query
		$select_coments = $model_coments->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('produtos_coments')
		//crio o inner join das fotos	
		->joinInner('cadastros',
				'produtos_coments.NR_SEQ_CADASTRO_PCRC = cadastros.NR_SEQ_CADASTRO_CASO',array('*'))
		//agora faco a condicao de que quero o produto desejado
		->where("NR_SEQ_PRODUTO_PCRC = ?", $idproduto)
		//somente as mensagens que nao etem resposta
		->where("NR_SEQ_REPLY_PCRC is NULL")
		//orderno do mais novo para o ultimo
		->order("NR_SEQ_PRODCOMENT_PCRC DESC");

		$this->view->comentarios = $model_coments->fetchAll($select_coments);

		//assino o id do produto ao view
		$this->view->idproduto = $idproduto;


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
		$this->view->banners = $banners_topo;


	}

	/*
	*
	* listagem de produtos pre venda
	*
	*/

	public function prevendaAction(){
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessao dos cliente
		$usuarios = new Zend_Session_Namespace("usuarios");


		//verifico se existe um usuario logado
		if ($usuarios->logado == TRUE) {
			//se o usuario for PJ fica na página, senao é redirecionado para o cadastro de logista
			if ($usuarios->tipo == "PJ"){


						//recebo os parametros da url
				$categoria = $this->_request->getParam("categoria");
				$tamanho = $this->_request->getParam("tamanho");
				$genero = $this->_request->getParam("genero");
				$cor = $this->_request->getParam("cor");
				$palavra = $this->_request->getParam("busca_produto");
				$tipo = $this->_request->getParam("tipo");
				//Inicio o model de produtos
				$model_produtos = new Default_Model_Produtos();
				//crio a query de produtos
				$select_produtos = $model_produtos->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('produtos', array('NR_SEQ_PRODUTO_PRRC',
										 'VL_PRODUTO_PRRC',
										
										 'DS_PRODUTO_PRRC',
										 'DS_EXT_PRRC',
										 'TP_DESTAQUE_PRRC',
										 'DS_FRETEGRATIS_PRRC',
										 'NR_SEQ_CATEGORIA_PRRC',
										 'NR_SEQ_TIPO_PRRC',
										 'VL_PROMO_PRRC',
										 'DS_GENERO_PRRC',
										 'DS_CORES_PRRC' ))
				->joinLeft("estoque",
							"produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
				->joinLeft("tamanhos",
							"tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
				//nao e classic
				->where("DS_CLASSIC_PRRC = 'N'")
				//produto e ativo
				->where("ST_PRODUTOS_PRRC = 'P'")
	
				//elimino as categorias
				->where("NR_SEQ_TIPO_PRRC not in (4,24,139,52,140,65)")
				//somente da loja on line
				->where("NR_SEQ_LOJAS_PRRC = 1");

				
				//agora coloco as condições da url, dependendo dos parametros
				if ($categoria != ""){
					$select_produtos->where("NR_SEQ_CATEGORIA_PRRC = ". $categoria);
					//assino ao view a categoria
					$this->view->cat_url = $categoria;
				}
				//se existir palavra a ser buscada
				if($palavra != ""){
					$select_produtos->where("DS_PRODUTO_PRRC LIKE '%". $palavra . "%'");
					//assino ao view a palavra
					$this->view->palavra_busca = $palavra;
				}
				//se for masculino
				if($genero == "masculino"){
					$select_produtos->where("DS_GENERO_PRRC = 'M'");
					//assino ao view o genero
					$this->view->genero = $genero;
				}
				//se for feminino
				if($genero == "feminino"){
					$select_produtos->where("DS_GENERO_PRRC = 'F'");
					//assino ao view o genero
					$this->view->genero = $genero;
				}
				//se tiver um tipo de produto selecionado
				if ($tipo != ""){
					$select_produtos->where("NR_SEQ_TIPO_PRRC = ". $tipo);
					//assino ao view a categoria
					$this->view->tipo_url = $tipo;
				}
				//se tiver uma cor selecionada
				if ($cor != ""){
					$select_produtos->where("DS_CORES_PRRC = ". $cor);
					//assino ao view a categoria
					$this->view->cor_url = $cor;
				}
				//se o tamanho do produto for p
				if ($tamanho == "p"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 2 or NR_SEQ_TAMANHO_TARC = 7" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for m
				if ($tamanho == "m"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 3 or NR_SEQ_TAMANHO_TARC = 8" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for g
				if ($tamanho == "g"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 4 or NR_SEQ_TAMANHO_TARC = 9" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for gg
				if ($tamanho == "gg"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 5 or NR_SEQ_TAMANHO_TARC = 10" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}
				//se o tamanho do produto for xgg
				if ($tamanho == "xgg"){
					$select_produtos->where("NR_SEQ_TAMANHO_TARC = 33" );
					//assino ao view a categoria
					$this->view->tamanho_url = $tamanho;
				}

				//agrupo por codigo do produto
				$select_produtos->group("NR_SEQ_PRODUTO_PRRC")
				//ordeno pela ordem de ordenacao de produtos
				->order('NR_ORDEM_PRRC ASC');

			
			// crio a paginação para proximo e para anterior
				$paginator = new Reverb_Paginator($select_produtos);
				//defino a quantidade de itens por pagina
				$paginator->setItemCountPerPage(12)
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
				$contador = new Reverb_Paginator($select_produtos);
				//defino o numero de itens a serem exibidos por página
				$contador->setItemCountPerPage(12)
				//pega o numero da pagina
				->setCurrentPageNumber($current_page)
				//defino quantas páginas iram aparecer por vez
				->setPageRange(5)
				//assino a paginacao
				->assign();		
				//assino ao view
				$this->view->contadores = $contador;

				//faco a query para listar as ultimas fotos em baixo do form login
				// Cria o objeto de conexão
				$db = Zend_Registry::get("db");
				
				//crio a query de categorias
				$select_categorias = "SELECT 
									NR_SEQ_CATEGPRO_PCRC,
									DS_CATEGORIA_PCRC
									
								FROM
								    produtos_categoria
								WHERE 
									DS_STATUS_PCRC = 'A'
								ORDER BY DS_CATEGORIA_PCRC ASC";

				// Monta a query
				$query_categoria = $db->query($select_categorias);

				//crio uma lista de categorias
				$lista_categoria = $query_categoria->fetchAll();
			
				//assino as categorias ao view
				$this->view->categorias = $lista_categoria;

				//crio a query para selecionar o tipo de produtos para o filtro lateral
				$select_tipo = "SELECT 
									NR_SEQ_CATEGPRO_PTRC,
									DS_CATEGORIA_PTRC
								FROM
								    produtos_tipo
								WHERE
									DS_STATUS_PTRC = 'A'
								ORDER BY DS_CATEGORIA_PTRC ASC";

				// Monta a query
				$query_tipo = $db->query($select_tipo);
				//crio uma lista de fotos
				$lista_tipo = $query_tipo->fetchAll();
				//assino os amigos ao view
				$this->view->tipos = $lista_tipo;

			//redireciona para o cadastro de logista
			}else{
				//falo para o usuario que ele precisa ser atacadista
				$messages->error = "Desculpe, Você precisa ser cadastrado como pessoa jurídica para acessar esta sessão.";
				//redireciono
				$this->_redirect("/meu-perfil");
			}
		//se nãou houver usuario logado direciona para o cadastro
		}else{
			$this->_redirect("atacado/cadastrolojista");
		}	
	}

	/*
	*
	*
	* Produto de pre venda
	*
	*/

	public function produtoprevendaAction(){
		$idproduto = $this->_request->getParam("idproduto");

		//Inicio o model de produtos
		$model_produtos = new Default_Model_Produtos();
		//crio a query de produtos
		$select_produtos = $model_produtos->select()
		//seleciono somente as informacoes do produto
		->where("NR_SEQ_PRODUTO_PRRC = $idproduto");
		//assino ao view
		$this->view->produto = $model_produtos->fetchRow($select_produtos);

		//seleciono todas as fotos do produto
		// Cria o objeto de conexão
		$db = Zend_Registry::get("db");
		//crio a query para selecionar os amigos
		$select_fotos = "SELECT 
							NR_SEQ_FOTO_FORC,
							NR_SEQ_PRODUTO_FORC,
							DS_EXT_FORC,
							NR_ORDEM_FORC
						FROM
						   fotos
						WHERE 
						   NR_SEQ_PRODUTO_FORC = ". $idproduto ."
						ORDER BY 
							NR_ORDEM_FORC DESC";

			// Monta a query
			$query = $db->query($select_fotos);
			//crio uma lista de fotos
			$lista = $query->fetchAll();
			//assino os amigos ao view
			$this->view->fotos = $lista;

		//crio a query de categorias
		$select_categorias = "SELECT
								NR_SEQ_CATEGPRO_PCRC,
								DS_CATEGORIA_PCRC
							FROM
								produtos_categoria
							WHERE
								DS_STATUS_PCRC = 'A'
							ORDER BY
								DS_CATEGORIA_PCRC ASC"
							;

		// Monta a query
		$quer_categoria = $db->query($select_categorias);
		//crio uma lista de fotos
		$lista_categoria = $quer_categoria->fetchAll();
		//assino os amigos ao view
		$this->view->categorias = $lista_categoria;

		//inicio o model de estoque
		$model_estoque = new Default_Model_Estoque();
		//crio a query para listagem de estoque
		$select_estoque = $model_estoque->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('estoque')
		//crio o inner join das fotos	
		->joinInner('tamanhos',
				'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC',array('*'))
		//agora faco a condicao de que quero o estoque de apenas o produto desejado
		->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
		//agora falo em quais codigos de tamanho
		->where("estoque.NR_SEQ_TAMANHO_ESRC IN (33,1,2,3,4,5)");
	
		//assino ao view
		$this->view->estoques_masculino = $model_estoque->fetchAll($select_estoque);

		//crio a query para listagem de estoque
		$select_estoque_feminino = $model_estoque->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('estoque')
		//crio o inner join das fotos	
		->joinInner('tamanhos',
				'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC',array('*'))
		//agora faco a condicao de que quero o estoque de apenas o produto desejado
		->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
		//agora falo em quais codigos de tamanho
		->where("estoque.NR_SEQ_TAMANHO_ESRC IN (6,7,8,9,10)");

		//assino ao view
		$this->view->estoques_feminino = $model_estoque->fetchAll($select_estoque_feminino);


		//crio a query para listagem de estoque
		$select_estoque_geral = $model_estoque->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('estoque')
		//crio o inner join das fotos	
		->joinInner('tamanhos',
				'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC',array('*'))
		//agora faco a condicao de que quero o estoque de apenas o produto desejado
		->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
		//agora falo em quais codigos de tamanho
		->where("estoque.NR_SEQ_TAMANHO_ESRC NOT IN (6,7,8,9,10,33,1,2,3,4,5)");

		//assino ao view
		$this->view->estoques_geral = $model_estoque->fetchAll($select_estoque_geral);

		//inicio a sessao de produtos vistos
		$produtos_vistos = new Zend_Session_Namespace("vistos");


		$produto = $model_produtos->fetchRow($select_produtos);

		$nome = $produto['DS_PRODUTO_PRRC'];
		$descricao = $produto['DS_INFORMACOES_PRRC'];
		$extensao_imagem = $produto["DS_EXT_PRRC"];
		$valor = $produto["VL_PRODUTO_PRRC"];
		$peso = $produto['NR_PESOGRAMAS_PRRC'];
		$valor_promo = $produto['VL_PROMO_PRRC'];
		
// 		Zend_Debug::dump($imagem);die;
		
		$produtos_vistos->produtos[$idproduto] = array(
				'codigo' => $idproduto,
				'nome'          => $nome,
				'descricao'     => $descricao,
				'path'   => $extensao_imagem,
				'valor'   => $valor,
				'peso'	=> $peso,
				'promo' => $valor_promo,
				'hora' => date("H:i:s")
		);

		//crio o model de notas
		$model_notas = new Default_Model_Produtosnotas();
		//crio a query para mostrar o resultado de notas de produtos
		$select_nota = $model_notas->select()
						->from("produtos_notas",array("idproduto",
												"soma_notas" => "ROUND((SELECT
																		SUM(nota)
																		AS
																			soma_notas
																		FROM
																		 	produtos_notas
																		WHERE
																		 	produtos_notas.idproduto = $idproduto) / 
																		(SELECT
																			COUNT(idprodutos_nota)
																		AS 
																			total_avaliacoes
																		FROM
																			produtos_notas
																		WHERE
																		 	produtos_notas.idproduto = $idproduto))"))
						->group("produtos_notas.idproduto");
		//assino ao view
		$this->view->nota = $model_notas->fetchRow($select_nota);
	
	// agora inicio a listagem dos comentarios do produto
		$model_coments = new Default_Model_Produtoscoments();
		//crio a query
		$select_coments = $model_coments->select()
		//digo que nao existe integridade entre as tabelas
		->setIntegrityCheck(false)
		//escolho a tabela do select para o join
		->from('produtos_coments')
		//crio o inner join das fotos	
		->joinInner('cadastros',
				'produtos_coments.NR_SEQ_CADASTRO_PCRC = cadastros.NR_SEQ_CADASTRO_CASO',array('*'))
		//agora faco a condicao de que quero o produto desejado
		->where("NR_SEQ_PRODUTO_PCRC = ?", $idproduto)
		//somente as mensagens que nao etem resposta
		->where("NR_SEQ_REPLY_PCRC is NULL")
		//orderno do mais novo para o ultimo
		->order("NR_SEQ_PRODCOMENT_PCRC DESC");

		$this->view->comentarios = $model_coments->fetchAll($select_coments);

		//assino o id do produto ao view
		$this->view->idproduto = $idproduto;


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
		$this->view->banners = $banners_topo;
	}

}

