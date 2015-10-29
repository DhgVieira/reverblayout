<?php

/**
*
*/
class ReverbmeController extends Zend_Controller_Action {
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

        $this->view->title = "Reverbme - A nossa rede social";
		$this->view->description = "A Rede Social exclusiva da Reverbcity";
		$this->view->keywords = "Reverbcity, rede social, facebook, instagram, twitter";
	}

    function validaCPF($cpf = null) {

        // Verifica se um número foi informado
        if(empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

	/**
	 *
	 */
	public function indexAction() {
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");

		$pagina = new Zend_Session_Namespace('pagina');
		$pagina->pagina_anterior = $_SERVER['HTTP_REFERER'];

		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//se existir eu redireciono para a página do perfil
			$this->_redirect("/meu-perfil");
		}

        $this->view->title = "Reverbme - Reverbcity.com";
        $this->view->description = "A Rede Social exclusiva da Reverbcity";
        $this->view->keywords = "Reverbcity, rede social, facebook, instagram, twitter";


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
	 *
	 */
	public function blogmeAction() {
		//inicio o blog
		$model_blog = new Default_Model_Reverbmeblog();
		//recebo o  id do post
		$id_post = $this->_request->getParam("idpost");
		//crio a query
		$select_post = $model_blog
                ->select()
                //seto a integridade como falsa
                ->setIntegrityCheck(FALSE)
                //informo a tabela
                ->from("me_blog")
                //faco o join das tabelas de usuario
                ->joinInner("cadastros", "cadastros.NR_SEQ_CADASTRO_CASO = me_blog.idusuario", array("DS_NOME_CASO"))
                //onde os recados pertencerem apenas a pessoa
                ->where("idme_blog = ?", $id_post);
           
		//assino ao view
		$this->view->post = $model_blog->fetchRow($select_post);

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

		//inicio o model de mensagens
		$msg_model = new Default_Model_Reverbmeblogcoments();

		//faço a query de comentarios
		$select_comentarios = $msg_model->select()
		//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
		//escolho a tabela do select para o join
			->from('me_blog_coments', array("idme_blog_coment",
										 "id_me_blog",
										 "idusuario",
										 "comentario",
										 "data_comentario",
										 "total_curtidas",
										 "total_nao_curtidas",
										 "idme_blog_coments_pai"))
			//crio o inner de quem postou
			->joinLeft('cadastros',
				'me_blog_coments.idusuario = cadastros.NR_SEQ_CADASTRO_CASO',array('DS_NOME_CASO',
																				   'NR_SEQ_CADASTRO_CASO',
																				    'DS_EXT_CACH'))
		//somente os referentes a esta postagem e aprovados
			->where("id_me_blog = ?", $id_post)
			->where("idme_blog_coments_pai is NULL");

		//assino ao vire
		$this->view->comentarios = $msg_model->fetchAll($select_comentarios);


	}

	/**
	 * funcao responsavel pelo cadastro do reverb me
	 */
	public function cadastroAction() {
		// Cria a sessão das mensagens
		$session = new Zend_Session_Namespace("messages");

		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//se existir eu redireciono para a página do perfil
			$this->_redirect("/meu-perfil");
		}

		//verifico se é uma requisicao de post para realizar o contato
		if ($this->_request->isPost()) {

			//inicio o model da tabela de Reverbme
			$model = new Default_Model_Reverbme();

			//recebo os parametros para compor data de nascimento
			$dia =  $this->_request->getParam('dia');
			$mes =  $this->_request->getParam('mes');
			$ano =  $this->_request->getParam('ano');
			//concateno a data de nascimento
			$data_nascimento = $ano."-".$mes."-".$dia;
			//pego a variavel do email
			$mail = $this->_request->getParam('usuarioemail');
			//cpf
			$cpf = $this->_request->getParam('cpf');

			//removo os pontos do cpf
			$cpf = str_replace(".", "", $cpf);
			//removo os traços
			$cpf = str_replace("-", "", $cpf);
			//removo os espacos em branco
			$cpf = str_replace(" ", "", $cpf);

			$caracteres_cpf = strlen($cpf);

			if($caracteres_cpf < 11 or $caracteres_cpf > 11){
				// Envio um feedback de sucesso ao usuário.
				$session->error = "o CPF Informado é invalido, Remova os pontos e traços, deixe apenas números!";
				//redireciono para a última página visitada
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}

            if(!$this->validaCPF($cpf)){
                // Envio um feedback de sucesso ao usuário.
                $session->error = "O CPF informado é invalido!";
                //redireciono para a última página visitada
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }

	
			$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
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

			//crio a query para verificar se existe email cadastrado
			$select_cpf = $model->select()->
							from("cadastros", array("DS_CPFCNPJ_CASO"))
							->where("DS_CPFCNPJ_CASO = ".$cpf);

			//armazeno em uma variavel
			$existe_cpf = $model->fetchRow($select_cpf);


			if($existe_cpf->DS_CPFCNPJ_CASO != ""){

				// Envio um feedback de sucesso ao usuário.
				$session->error = "Desculpe, já existe uma conta vinculada com este CPF!";
				//redireciono para a última página visitada
				$this->_redirect($_SERVER['HTTP_REFERER']);

			}

			//pego o tel para explodir o dddd e fone
			$telefone_1 = $this->_request->getParam("telefone1");

			//removo os espaços em branco
			$telefone_1 = str_replace(" ", "", $telefone_1);

			//agora explodo a variavel para pegar o DDD e o telefone
			$telefone_1 = explode("(", $telefone_1);
			//agora explodo a ultima vez para pegar o conteudo que eu quero realmente
			$telefone_1 = explode(")", $telefone_1[1]);

		
			$telefone_2 =  $this->_request->getParam("telefone2");

			//removo os espaços em branco
			$telefone_2 = str_replace(" ", "", $telefone_2);

			//agora explodo a variavel para pegar o DDD e o telefone
			$telefone_2 = explode("(", $telefone_2);
			//agora explodo a ultima vez para pegar o conteudo que eu quero realmente
			$telefone_2 = explode(")", $telefone_2[1]);



			//crio um array com os campos do formulario
			$data = array('DS_NOME_CASO' => $this->_request->getParam('nomecompleto'),
				          'DS_SEXO_CACH' => $this->_request->getParam('sexo'),
				          'DT_NASCIMENTO_CASO' => $data_nascimento,
				          'DS_CPFCNPJ_CASO' => $cpf,
				          'DS_ENDERECO_CASO' => $this->_request->getParam('endereco'),
				          'DS_NUMERO_CASO' => $this->_request->getParam('numero'),
				          'DS_BAIRRO_CASO' => $this->_request->getParam('bairro'),
				          'DS_COMPLEMENTO_CASO' => $this->_request->getParam('complemento'),
			 			  'DS_CEP_CASO' => $this->_request->getParam('cep'),
			  			  'DS_UF_CASO' => $this->_request->getParam('estado'),
			   			  'DS_CIDADE_CASO' => $this->_request->getParam('cidade'),
			    		  'DS_PAIS_CACH' => $this->_request->getParam('pais'),
			     		  'DS_DDDFONE_CASO' => $telefone_1[0],
						  'DS_FONE_CASO' => $telefone_1[1],
						  'DS_DDDCEL_CASO' => $telefone_2[0],
						  'DS_CELULAR_CASO' => $telefone_2[1],
			       		  'DS_EMAIL_CASO' => $this->_request->getParam('usuarioemail'),
			        	  'DS_SENHA_CASO' => $this->_request->getParam('usuariosenha'),
			        	  'DS_FACEBOOK_CACH' => $this->_request->getParam('facebook'),
			        	  'DS_TWITTER_CACH' => $this->_request->getParam('twitter'),
			         	  'DS_OBS_CACH' => $this->_request->getParam('observacoes'),
			          	  'ST_ENVIO_CASO' => $this->_request->getParam('mailing'),
			           	  'ST_ENVIOSMS_CACH' => $this->_request->getParam('sms'),
			           	  'ST_CADASTRO_CASO'=> "A",
			           	  'DS_PROFILE_CACH' => "P",
						  'DS_TIPO_CASO'=> "PF",
						  'ST_CADASTROCOMPLETO_CASO' => 1);


			//tento inserir o registro
			try {
				
				//insiro os registros no banco de dados
				$idme = $model->insert($data);

				//agora insiro os dados adicionais dos perfil

				/*---------------------
				*
				*  Amigos
				*
				*--------------------*/
				$model_friends = new Default_Model_Mefriends();

				//agora coloco o id do perfil de cada funcionando da reverb
				$data_amigos = array("2","3388","4162","5189","10470", "26087", "29424", "32609", "22652", "1269", "4866");
				//para cada amigo
				foreach ($data_amigos as $key => $idamigo) {
					//agora pego os dados para inserir na tabela me friends
					$data_mefriends = array('NR_SEQ_CADASTRO_FRRC' => $idamigo,
											'NR_SEQ_AMIGO_FRRC' => $idme);

					//agora insiro o registro
					$model_friends->insert($data_mefriends);

					//agora pego os dados para inserir na tabela me friends
					$data_friendme = array('NR_SEQ_CADASTRO_FRRC' => $idme,
											'NR_SEQ_AMIGO_FRRC' => $idamigo);

					//agora insiro o registro
					$model_friends->insert($data_friendme);
				}

				/*---------------------------
				*
				* Recados
				*
				*-------------------------*/

				//crio a variavel para pega o dia do cadastro
				$dia_cadastro = date("d");

				//agora verifico o dia do cadastro para mandar o recado personalisado
				switch ($dia_cadastro) {
					case '01':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que polêmicas entre os irmãos Gallaghers! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '02':
						$msg_recado = "Hey, aqui na Reverbcity tem mais rock and roll do que oleosidade na testa do Brandon Flowers! heheheheh Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '03':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que zombies em Walking Dead Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '04':
						$msg_recado = "Oioioi, aqui na Reverbcity tem mais rock and roll do que o Alex Turner requebrando o quadril estes tempos Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '05':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que o Muse tem de fã! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '06':
						$msg_recado = "E ae amizade, aqui na Reverbcity tem mais rock and roll do que esquisitice nas dancinhas do Thom Yorke Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '07':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que rugas na cara do Keith Richards Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '08':
						$msg_recado = "Seja bem-vindo, aqui na Reverbcity tem mais rock and roll do que o Dave Grohl levantando o braço nos shows! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '09':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que falta de amor no coração da Summer #500Days Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '10':
						$msg_recado = "Ooopaaa, aqui na Reverbcity tem mais rock and roll do que as vezes que o Iggy Pop apareceu sem camiseta Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '11':
						$msg_recado = "Ois, aqui na Reverbcity tem mais rock and roll do que sujeira no cabelo do Julian Casablancas hehehehehe Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '12':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que cachos no cabelo do Jim Morrison Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '13':
						$msg_recado = "Hi, aqui na Reverbcity tem mais rock and roll do que '1 2 3 4' em começo de música dos Ramones Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '14':
						$msg_recado = "Seja bem vindo, aqui na Reverbcity tem mais rock and roll do que os foras que o Ted levou em HIMYM Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '15':
						$msg_recado = "Welcome, aqui na Reverbcity tem mais rock and roll do que Ben Gibbard levando pé na bunda Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '16':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que o Alex Turner ajeitando o topete! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '17':
						$msg_recado = "Hellloooo, aqui na Reverbcity tem mais rock and roll do que o Flea pelado em show do RHCP Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '18':
						$msg_recado = "Oeeee, aqui na Reverbcity tem mais rock and roll do que fracassos amorosos na vida do Rob Fleming em Alta Fidelidade Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '19':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que batom na boca do Robert Smith Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '20':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que polêmicas entre os irmãos Gallaghers! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '21':
						$msg_recado = "Hey, aqui na Reverbcity tem mais rock and roll do que oleosidade na testa do Brandon Flowers! heheheheh Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '22':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que zombies em Walking Dead Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '23':
						$msg_recado = "Oioioi, aqui na Reverbcity tem mais rock and roll do que o Alex Turner requebrando o quadril estes tempos Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '24':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que o Muse tem de fã! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '25':
						$msg_recado = "Ooieeee, aqui na Reverbcity tem mais rock and roll do que laque no topete do Morrissey! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '26':
						$msg_recado = "E ae amizade, aqui na Reverbcity tem mais rock and roll do que esquisitice nas dancinhas do Thom Yorke Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '27':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que rugas na cara do Keith Richards Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '28':
						$msg_recado = "Seja bem-vindo, aqui na Reverbcity tem mais rock and roll do que o Dave Grohl levantando o braço nos shows! Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '29':
						$msg_recado = "Olá, aqui na Reverbcity tem mais rock and roll do que falta de amor no coração da Summer #500Days Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '30':
						$msg_recado = "Ooopaaa, aqui na Reverbcity tem mais rock and roll do que as vezes que o Iggy Pop apareceu sem camiseta Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					case '31':
						$msg_recado = "Ois, aqui na Reverbcity tem mais rock and roll do que sujeira no cabelo do Julian Casablancas hehehehehe Aproveite e cola lá nosso fórum http://rvb.la/Forum";
					break;
					
				}

				//inicio o model de scraps
				$model_scraps = new Default_Model_Mescraps();

				//inicio o array para as informações da mensagem
				$data_mensagem = array ("NR_SEQ_CADASTRO_SBRC" => $idme,
								"NR_SEQ_AUTOR_SBRC" => 22364,
								"DS_POST_SBRC" => $msg_recado,
								"ST_POST_SBRC" => "A",
								"ST_PUBLICO_SBRC" => 1);
				//insiro a mensagem
				$model_scraps->insert($data_mensagem);

				/*---------------------
				*
				* Me Blog
				*
				*---------------------*/
				
				$mensagem_me = "Olá, quando você se cadastra na Reverbcity, além de poder fazer suas compras, você também pode aproveitar nossa rede social,
								o ReverbME e ter um blog hospedado no nosso site. Agora você tem esse espaço para publicar todas suas impressões sobre a música,
								a vida, o universo e tudo mais e compartilhar com seus amigos e até com não-amigos também.\r </br></br> 

								Ah, não se esqueça de sempre ter bom senso em suas publicações, nada de ofensas e preconceitos por aqui, senão seremos obrigados a bloquear seu blog ";
				//crio o array
				$data_me_blog = array("idusuario" => $idme,
									  "titulo" => "ESTE É O SEU BLOG DENTRO DA REVERBCITY!",
									  "post" => $mensagem_me);
				//inicio o model do blog
				$model_blog_me = new Default_Model_Reverbmeblog();
				//insiro os dados
				$model_blog_me->insert($data_me_blog);

				

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
						$usuarios->cadastro_completo = 1;

						// Envio um feedback de sucesso ao usuário.
						$session->success = "O cadastro foi realizado com sucesso!";

						$mode_monitora = new Default_Model_Monitoraclientes();

						$data_monitora_cliente = array("idcliente" => $idme,
													  "dia_acesso" => date("d"),
													   "mes_acesso" => date("m"),
													   "ano_acesso" => date("Y"));

						$mode_monitora->insert($data_monitora_cliente);

						$carrinho = new Zend_Session_Namespace("carrinho");
						if(count($carrinho->produtos) > 0){
							
							$this->_redirect('/carrinho-compras');
						}else{

							$this->_redirect('/todos-produtos');
						}

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
			//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
			$select_banner = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 87")
								->where("ST_BANNER_BARC = 'A'")
								->order("DT_CADASTRO_BARC DESC");
			//Assino ao view
			$this->view->banners = $model_banner->fetchAll($select_banner);



	}


	/**
	 * funcao responsavel por exibir o perfil do usuario
	 */
	public function novomeAction() {
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");

		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {

            $this->view->title = "Reverbme - Reverbcity.com";
            $this->view->description = "A Rede Social exclusiva da Reverbcity";
            $this->view->keywords = "Reverbcity, rede social, facebook, instagram, twitter";

			//inicio o model do perfil
			$model_perfil = new Default_Model_Reverbme();

			$incompleto = $this->_request->getParam('incompleto');
			$this->view->incompleto = $incompleto;

			//crio o select do perfil de acordo com o usuário logado
			$select_perfil = $model_perfil->select()
										->where("NR_SEQ_CADASTRO_CASO = ? ", $usuarios->idperfil);
			//pego as informacoes do perfil
			$perfil = $model_perfil->fetchRow($select_perfil);

			//assino ao view
			$this->view->perfil = $perfil;

			//calculo o nascimento
			// Separa em dia, mês e ano
   			list($ano, $mes, $dia) = explode('-', $perfil->DT_NASCIMENTO_CASO);

   			// Descobre que dia é hoje e retorna a unix timestamp
		    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		    // Descobre a unix timestamp da data de nascimento do usuario
		    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

		    // Depois apenas fazemos o cálculo
		    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
		    //assino ao view a idade
			$this->view->idade = $idade;

			//pego a data de hoje
			$hoje_niver = date("d-m");
			//agora pego o dia e o mes do nascimento e concateno
			$dia_mes_niver = $dia ."-". $mes;
			//agora verifico se é aniversario
			if($hoje_niver == $dia_mes_niver){
				//falo que ele é aniversariante
				$this->view->aniversariante = 1;
			}else{
				$this->view->aniversariante = 0;
			}


			/*--------------------------------
			*
			*Pontos de experiencia
			*
			*-------------------------------*/
			$db1 = Zend_Registry::get("db");

			//faco a consulta de total de comentarios no blog
			 $select_total_blog_coments = "SELECT COUNT(NR_SEQ_COMENTARIO_CBRC)
											AS total_comentarios
		                                     FROM
		                                     		blog_coments
		                                     WHERE
		                                           NR_SEQ_CADASTRO_CASO = $usuarios->idperfil";


		     // Monta a query
	        $query_total_blog_coemnts = $db1->query($select_total_blog_coments);
	        //crio uma lista de comentario
	        $blog_total_coments = $query_total_blog_coemnts->fetchAll();
	        //armazeno em uma variavel o total
	     	$total_comentarios_blog = $blog_total_coments[0]["total_comentarios"];

	     	//se o total de comentarios for maior que 100, ficara como 100
	     	if($total_comentarios_blog > 100){

	     		$total_comentarios_blog = 100;
	     	}

	     	//faco a consulta de total de comentarios nos produtos
			 $select_total_produto_coments = "SELECT COUNT(NR_SEQ_PRODCOMENT_PCRC)
											AS total_comentarios
		                                     FROM
		                                     		produtos_coments
		                                     WHERE
		                                           NR_SEQ_CADASTRO_PCRC = $usuarios->idperfil";


		     // Monta a query
	        $query_total_produto_coemnts = $db1->query($select_total_produto_coments);
	        //crio uma lista de comentario
	        $produto_total_coments = $query_total_produto_coemnts->fetchAll();
	        //armazeno em uma variavel o total
	     	$total_comentarios_produto = $produto_total_coments[0]["total_comentarios"];
	     	//se o total de comentarios for maior que 100, ficara como 100
	     	if($total_comentarios_produto > 100){

	     		$total_comentarios_produto = 100;
	     	}

	     	//faco a consulta de total de scraps enviados
			 $select_total_scraps = "SELECT COUNT(NR_SEQ_AUTOR_SBRC)
											AS total_scraps
		                                     FROM
		                                     		me_scraps
		                                     WHERE
		                                           NR_SEQ_AUTOR_SBRC = $usuarios->idperfil";


		     // Monta a query
	        $query_total_scraps = $db1->query($select_total_scraps);
	        //crio uma lista de comentario
	        $total_scraps = $query_total_scraps->fetchAll();
	        //armazeno em uma variavel o total
	     	$total_scraps_enviados = $total_scraps[0]["total_scraps"];

	     	//se o total de scraps enviados for maior que 100, ficara como 100
	     	if($total_scraps_enviados > 100){

	     		$total_scraps_enviados = 100;
	     	}

	     	$total_experiencia = ($total_scraps_enviados + $total_comentarios_produto + $total_comentarios_blog) / 3;

	     	$this->view->experiencia_user = $total_experiencia;


			/*-------------------------------
			*
			* Responsável pelas fotos (quantidade de paginas)
			*
			--------------------------------*/

			//crio a query
            $select_fotos_count = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO'))
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinLeft('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_MCRC)
                                           FROM me_fotos_coments
                                           WHERE me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $usuarios->idperfil)
                //ordeno pela data de envio
                ->order("me_fotos.DT_CADASTRO_FORC DESC")
                 ->group("NR_SEQ_FOTO_MCRC");

                $lista_fotos = $model_perfil->fetchAll($select_fotos_count);

                $total_fotos = count($lista_fotos);


                $numero_paginas_fotos = ceil($total_fotos / 9);


                $this->view->paginas_fotos = $numero_paginas_fotos;

               /*-------------------------------
				*
				* Responsável pelas fotos listagem inicial
				*
				--------------------------------*/
            $select_fotos = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO'))
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinLeft('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_MCRC)
                                           FROM me_fotos_coments
                                           WHERE me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $usuarios->idperfil)
                //ordeno pela data de envio
                ->order("me_fotos.DT_CADASTRO_FORC DESC")
                 ->group("NR_SEQ_FOTO_MCRC")
                 ->limit(9);

                 $this->view->fotos = $model_perfil->fetchAll($select_fotos);


			/*-------------------------------
			*
			* Responsável pelos Videos contagem
			*
			--------------------------------*/


			//inicio o model de videos
			$model_videos = new Default_Model_Mevideos();
			  //crio o select de recados
            $select_videos_count = $model_videos
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_VIRC DESC")
                ->group("NR_SEQ_VIDEO_VIRC");
            //assino a lista de videos
            $lista_videos = $model_videos->fetchAll($select_videos_count);
          	//conto quantos registros possui
            $total_videos = count($lista_videos);
            //assino a quantidade de paginas
            $this->view->paginas_videos = ceil($total_videos / 4);

            /*-------------------------------
			*
			* Responsável pelos Videos listagem
			*
			--------------------------------*/

			//crio o select de recados
            $select_videos = $model_videos
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_VIRC DESC")
                ->group("NR_SEQ_VIDEO_VIRC")
                ->limit(4);
                
			$this->view->videos = $model_videos->fetchAll($select_videos);

			/*-----------------------
			*
			*Posts Contagem
			*
			*-----------------------*/

 			$model_post = new Default_Model_Reverbmeblog();
 			 //crio o select de post
            $select_post_count = $model_post
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("data_publicacao DESC")
                 ->group("idme_blog");

            //assino a lista de videos
            $lista_posts = $model_post->fetchAll($select_post_count);
          	//conto quantos registros possui
            $total_posts = count($lista_posts);
            //assino a quantidade de paginas
            $this->view->paginas_post = ceil($total_posts / 3);

			/*-----------------------
			*
			*Posts listagem
			*
			*-----------------------*/
			//select
            $select_post = $model_post
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("data_publicacao DESC")
                 ->group("idme_blog")
                 ->limit(3);

			//assino ao view
			$this->view->posts = $model_post->fetchAll($select_post);

			/*-----------------------
			*
			* Amigos contagem
			*
			*-----------------------*/
			//se for busca
			$filter_amigos = $this->_request->getParam("filter", "");



			 // Cria o objeto de conexão
        	$db = Zend_Registry::get("db");
        	 //crio a query para selecionar os amigos
            $select_amigos_count = "SELECT NR_SEQ_CADASTRO_CASO,
                                     DS_NOME_CASO,
                                     NR_SEQ_FRIEND_FRRC,
                                     NR_SEQ_AMIGO_FRRC,
                                     DS_EXT_CACH
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $usuarios->idperfil
                                    ";
            //se tiver alguma palavra na pesquisa
            if ($filter_amigos != "") {
                $select_amigos_count .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter_amigos . "%") . "";
            }
            $select_amigos_count .= " GROUP BY NR_SEQ_CADASTRO_CASO
                                ORDER BY DT_ACESSO_CASO DESC";

	        // Monta a query
	        $query_count = $db->query($select_amigos_count);
	        //crio uma lista de amigos
	        $lista_count = $query_count->fetchAll();
	        //crio o total de amigos
	        $total_amigos = count($lista_count);

	        //crio a quantidade de paginas
	        $this->view->paginas_amigos = ceil($total_amigos / 8);

			/*-----------------------
			*
			* Amigos listagem
			*
			*-----------------------*/

			 //crio a query para selecionar os amigos
            $select_amigos = "SELECT NR_SEQ_CADASTRO_CASO,
                                     DS_NOME_CASO,
                                     NR_SEQ_FRIEND_FRRC,
                                     NR_SEQ_AMIGO_FRRC,
                                     DS_EXT_CACH
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $usuarios->idperfil
                                    ";
            //se tiver alguma palavra na pesquisa
            if ($filter_amigos != "") {
                $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter_amigos . "%") . "";
            }
            $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO
                                ORDER BY DT_ACESSO_CASO DESC
                                LIMIT 8";

	        // Monta a query
	        $query = $db->query($select_amigos);
	        //crio uma lista de amigos
	        $lista = $query->fetchAll();


	        $this->view->amigos = $lista;


			/*-----------------------
			*
			* Recados count
			*
			*-----------------------*/

			 //inicio o model de recados
        	$model_scraps = new Default_Model_Mescraps();
        	//inicio a query
        	$select_scrap_count = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO', 'DS_EXT_CACH'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_POST_SBRC DESC")
                ->group("NR_SEQ_SCRAP_SBRC");

            $lista_recados = $model_scraps->fetchAll($select_scrap_count);

            //conto quantos registros possui
            $total_recados = count($lista_recados);
            //assino a quantidade de paginas
            $this->view->paginas_recados = ceil($total_recados / 5);


			/*-----------------------
			*
			* Recados listagem
			*
			*-----------------------*/

        	//inicio a query
        	$select_scrap = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO', 'DS_EXT_CACH'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_POST_SBRC DESC")
                ->group("NR_SEQ_SCRAP_SBRC")
                ->limit(5);


			//assino ao view
			$this->view->recados = $model_scraps->fetchAll($select_scrap);

			/*----------------------
			*
			* Recados baixa para lidos
			*
			*-----------------------*/
			//dou baixa nas mensagens pra lidas
			$data_msgs = array("ST_LIDA_SBRC" => 1);

			//atualizo a tabela
			$model_scraps->update($data_msgs, array("NR_SEQ_CADASTRO_SBRC = ?" => $usuarios->idperfil));



			/*-----------------------
			*
			* wishlist count
			*
			*-----------------------*/

			//crio o model de wishlist
        	$wishlist_model = new Default_Model_Wishlist();
			 //crio a query da wishlist
            $select_wishlist_count = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',
                            array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_WLRC DESC")
                 ->group("NR_SEQ_WISHLIST_WLRC");

            $lista_wishlist = $wishlist_model->fetchAll($select_wishlist_count);

            //conto quantos registros possui
            $total_wishlist = count($lista_wishlist);
            //assino a quantidade de paginas
            $this->view->paginas_wishlist = ceil($total_wishlist / 6);


            /*-----------------------
			*
			* wishlist listagem
			*
			*-----------------------*/

			 //crio a query da wishlist
            $select_wishlist = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',
                            array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_WLRC DESC")
                ->group("NR_SEQ_WISHLIST_WLRC")
                ->limit(6);

			//assino ao view
			$this->view->wishlists = $wishlist_model->fetchAll($select_wishlist);

			/*-----------------------
			*
			* Cycle count
			*
			*-----------------------*/

			//crio o model de reverbcycle
       		$model_cycle = new Default_Model_Reverbcycle();

       		 //crio a query do reverbcycle
            $select_cycle_count = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            array( "total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_CRRC)
																AS total_comentatios
															FROM
															    reverbcycle_coments
															WHERE
															    NR_SEQ_REVERBCYCLE_RCRC = NR_SEQ_REVERBCYCLE_CRRC)"))
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_RCRC DESC")
                ->group("NR_SEQ_REVERBCYCLE_RCRC");

            $lista_cycle = $model_cycle->fetchAll($select_cycle_count);

            //conto quantos registros possui
            $total_cycle = count($lista_cycle);
            //assino a quantidade de paginas
            $this->view->paginas_cycle = ceil($total_cycle / 4);


            /*-----------------------
			*
			* Cycle listagem
			*
			*-----------------------*/

			//crio o model de reverbcycle
       		$model_cycle = new Default_Model_Reverbcycle();

       		 //crio a query do reverbcycle
            $select_cycle = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            array( "total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_CRRC)
																AS total_comentatios
															FROM
															    reverbcycle_coments
															WHERE
															    NR_SEQ_REVERBCYCLE_RCRC = NR_SEQ_REVERBCYCLE_CRRC)"))
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_RCRC DESC")
                ->group("NR_SEQ_REVERBCYCLE_RCRC")
                ->limit(6);


			//assino ao view
			$this->view->cycles = $model_cycle->fetchAll($select_cycle);


			/*-----------------------
			*
			* Banners
			*
			*-----------------------*/

			//inicio o model de banners
			$model_banner = new Default_Model_Banners();
			//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
			$select_banner = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 68")
								->where("ST_BANNER_BARC = 'A'")
								->order("DT_CADASTRO_BARC DESC");
			//Assino ao view
			$this->view->banners = $model_banner->fetchAll($select_banner);
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


			/*-------------------------------
			*
			* Compras
			*
			*--------------------------------*/

			$model_cesta = new Default_Model_Cestas();

			//crio a query
			$select_cesta = $model_cesta->select()
			//digo que nao existe integridade entre as tabelas
            	->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cestas', array('NR_SEQ_PRODUTO_CESO',
                					   'DT_INCLUSAO_CESO',
                					   'NR_SEQ_COMPRA_CESO'))
                ->joinInner("compras",
                			"cestas.NR_SEQ_COMPRA_CESO = compras.NR_SEQ_COMPRA_COSO", array("ST_COMPRA_COSO"))
                ->joinInner("produtos",
                			"cestas.NR_SEQ_PRODUTO_CESO = produtos.NR_SEQ_PRODUTO_PRRC", array("NR_SEQ_PRODUTO_PRRC",
                																			   "DS_EXT_PRRC",
                																			   "DS_PRODUTO_PRRC"))
               	->where("NR_SEQ_CADASTRO_CESO = ?", $usuarios->idperfil)
                ->order("cestas.DT_INCLUSAO_CESO DESC")
                ->group("produtos.NR_SEQ_PRODUTO_PRRC")
                ->limit(3);


            $this->view->cestas = $model_cesta->fetchAll($select_cesta);

            $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/tinymce.min.js');
            $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/langs/pt_BR.js');

		}else{
			//se nao existir eu redireciono para a página de cadastro
			$this->_redirect("reverbme");
		}
	}

	/**
	 * login do usuario
	 */
	public function loginAction() {

		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		$usuarios = new Zend_Session_Namespace("usuarios");
		// Cria a sessao do carrinhi
		$carrinho = new Zend_Session_Namespace("carrinho");
		//crio a sessão com a url do produto que ele quer
		$url_ultimo_prod = new Zend_Session_Namespace("ultimo_produto");




		if ($usuarios->logado == TRUE) {

			// Redireciona
			$this->_redirect("reverbme/novome");


		}
		//se estiver fazendo login
		if ($this->_request->isPost()) {
			//pego o atributo de manter logado
			$manter_logado = $this->_request->getParam("manter_logado");
			// Busca os dados do formulário
			$usuario = $this->_request->getParam("email", "");

			$senha = $this->_request->getParam("senha", "");

			// Cria o objeto da model
			$perfil_model = new Default_Model_Reverbme();
			//crio a query de login
			$select_login = $perfil_model->select()
							->from('cadastros', array("NR_SEQ_CADASTRO_CASO",
													  "DS_NOME_CASO",
													  "DS_EMAIL_CASO",
													  "DS_CIDADE_CASO",
													  "DS_UF_CASO",
													  "DS_TIPO_CASO",
													  "DS_CEP_CASO",
													  "DT_NASCIMENTO_CASO",
													  "ST_CADASTRO_CASO",
													  "DS_SENHA_CASO",
													  "DS_DDDCEL_CASO",
													  "DS_CELULAR_CASO",
													  "ST_CADASTROCOMPLETO_CASO"))
                                                        ->where('ST_CADASTRO_CASO = "A"')
							->where("DS_EMAIL_CASO = ?", $usuario);



			//crio a lista
			$row = $perfil_model->fetchRow($select_login);
			// Zend_Debug::Dump($row);die();
			// verifico se o email informado esta correto
			// $row = $perfil_model->fetchRow(array('DS_EMAIL_CASO = ?' => $usuario));

			if ($row->ST_CADASTRO_CASO == 'N'){
				// Exibe mensagem de usuário inválido
				$messages->error = "Sua conta foi desativada, entre em contato com a Reverbcity.";

				// Redireciona para a última página
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}
			//se estiver vazio, informo que o email é invalido
			if ($row == NULL) {
				// Exibe mensagem de usuário inválido
				$messages->error = "E-mail inválido.";

				// Redireciona para a última página
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}else{
				//pego a senha do banco
				$parts = explode(":", $row->DS_SENHA_CASO);
				//agora atribuo a senha informada
				$hash = $parts[1] . $senha;


				//comparo a senha informado com a do banco, se forem iguais eu inicio a sessao
				if ($hash == $parts[0]) {
					
					// Seta os dados do usuáario logado
						$usuarios->idperfil = $row->NR_SEQ_CADASTRO_CASO;
						$usuarios->logado = TRUE;
						$usuarios->nome = $row->DS_NOME_CASO;
						$usuarios->email = $row->DS_EMAIL_CASO;
						$usuarios->cidade = $row->DS_CIDADE_CASO;
						$usuarios->uf = $row->DS_UF_CASO;
						$usuarios->tipo = $row->DS_TIPO_CASO;
						$usuarios->ddd = $row->DS_DDDCEL_CASO;
						$usuarios->cel = $row->DS_CELULAR_CASO;
						$usuarios->cep = $row->DS_CEP_CASO;
						$usuarios->facebook = false;
						$usuarios->twitter = false;
						$usuarios->nascimento = $row->DT_NASCIMENTO_CASO;
						$usuarios->cadastro_completo = $row->ST_CADASTROCOMPLETO_CASO;
                        $usuarios->permanecer_logado = $manter_logado;

					// }

						//crio a data de hoje para atualizar o ultimo acesso
						$hoje_agora = date("Y-m-d H:i:s");

						//jogo para um array
						$data_login = array("DT_ACESSO_CASO" => $hoje_agora);
						//tento atualizar
						try{
							//atualizo
							$perfil_model->update($data_login, array("NR_SEQ_CADASTRO_CASO = ?" => $row->NR_SEQ_CADASTRO_CASO));

							$mode_monitora = new Default_Model_Monitoraclientes();

							$data_monitora_cliente = array("idcliente" => $row->NR_SEQ_CADASTRO_CASO,
													  "dia_acesso" => date("d"),
													   "mes_acesso" => date("m"),
													   "ano_acesso" => date("Y"));

							$mode_monitora->insert($data_monitora_cliente);

						}catch(Exception $e){
							var_dump($e);
							die();
						}
						//se ele tiver vindo de um produto redireciono para a pagina do produto
						$pagina = new Zend_Session_Namespace('pagina');
						$pagina_anterior = $pagina->pagina_anterior;
						if(count($carrinho->produtos) > 0){

							if(!empty($pagina_anterior)){
								$pagina->pagina_anterior = '';
								$this->_redirect($pagina_anterior);
							}else{
								$this->_redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
							if(!empty($pagina_anterior)){
								$pagina->pagina_anterior = '';
								$this->_redirect($pagina_anterior);
							}else{
								$this->_redirect($_SERVER['HTTP_REFERER']);
							}
						}
						
				}else{
					$messages->error = "Senha incorreta";
                                        $messages->email = $usuario;
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
			}
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}



	}

	/**
	 * logout do usuario
	 */
	public function logoutAction() {

	// Cria a sessao dos cliente
		$usuarios = new Zend_Session_Namespace("usuarios");
		// Cria a sessao do carrinhi
		$carrinho = new Zend_Session_Namespace("carrinho");

		// Destroi a sessão do usuário no site
		Zend_Session::namespaceUnset("usuarios");
		// Destroi a sessão do usuário no site
		Zend_Session::namespaceUnset("carrinho");
		// Destroi a sessão do usuário no site
		Zend_Session::namespaceUnset("promocoes");

		// Destroi a sessão do usuário no site
		Zend_Session::namespaceUnset("fretes");

		// Redireciona
		$this->_redirect("/todos-produtos");
	}

	/**
	* Ação para minhas compras
	*/
	public function minhascomprasAction(){

		// Cria a sessao dos cliente
		$usuarios = new Zend_Session_Namespace("usuarios");
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		
		if($usuarios->logado == TRUE){
			$model_compra = new Default_Model_Compras();

				//crio a query
				$select_compra = $model_compra->select()
				//digo que nao existe integridade entre as tabelas
	            	->setIntegrityCheck(false)
	                //escolho a tabela do select para o join
	                ->from('compras', array('NR_SEQ_COMPRA_COSO',
	                					   'DT_COMPRA_COSO',
	                					   'DS_FORMAPGTO_COSO',
	                					   'ST_COMPRA_COSO',
	                					   'VL_TOTAL_COSO',
	                					   'DS_RASTREAMENTO_COSO'))
	               ->joinInner("cestas", "cestas.NR_SEQ_COMPRA_CESO = compras.NR_SEQ_COMPRA_COSO", array("total_itens" => "(SELECT 
	               																												COUNT(NR_SEQ_COMPRA_CESO) as total_itens 
	               																											FROM 
	               																												cestas 
	               																											WHERE 
	               																												NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
	               																											GROUP BY 
	               																												NR_SEQ_COMPRA_COSO)"))
	               	->where("NR_SEQ_CADASTRO_CESO = ?", $usuarios->idperfil)
	                ->order("compras.DT_COMPRA_COSO DESC")
	                ->group("compras.NR_SEQ_COMPRA_COSO");


	            $this->view->compras = $model_compra->fetchAll($select_compra);

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
		}else{
			//mensagem de retorno para o usuario
			$messages->error = "Você precisa estar logado para acessar suas compras.";
			// Redireciona para a última página
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	 * perfil do usuário
	 */
	public function novoperfilAction() {

	// Cria a sessao dos cliente
		$usuarios = new Zend_Session_Namespace("usuarios");
			//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");

		if ($usuarios->logado == TRUE) {

			$idusuario = $this->_request->getParam("idperfil");
			//inicio o model do perfil
			$model_perfil = new Default_Model_Reverbme();
			//crio o select do perfil de acordo com o usuário logado
			$select_perfil = $model_perfil->select()
										->where("NR_SEQ_CADASTRO_CASO = ? ", $idusuario);
			//pego as informacoes do perfil
			$perfil = $model_perfil->fetchRow($select_perfil);
			//assino ao view
			$this->view->perfil = $perfil;

			//calculo o nascimento
			// Separa em dia, mês e ano
   			list($ano, $mes, $dia) = explode('/', $perfil->DT_NASCIMENTO_CASO);

   			// Descobre que dia é hoje e retorna a unix timestamp
		    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		    // Descobre a unix timestamp da data de nascimento do usuario
		    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

		    // Depois apenas fazemos o cálculo
		    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
		    //assino ao view a idade
			$this->view->idade = $idade;


			/*-------------------------------
			*
			* Responsável pelas fotos (quantidade de paginas)
			*
			--------------------------------*/

			//crio a query
            $select_fotos_count = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO'))
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinLeft('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_MCRC)
                                           FROM me_fotos_coments
                                           WHERE me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $idusuario)
                //ordeno pela data de envio
                ->order("me_fotos.DT_CADASTRO_FORC DESC")
                 ->group("NR_SEQ_FOTO_MCRC");

                $lista_fotos = $model_perfil->fetchAll($select_fotos_count);

                $total_fotos = count($lista_fotos);


                $numero_paginas_fotos = ceil($total_fotos / 9);


                $this->view->paginas_fotos = $numero_paginas_fotos;

               /*-------------------------------
				*
				* Responsável pelas fotos listagem inicial
				*
				--------------------------------*/
            $select_fotos = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO'))
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinLeft('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_MCRC)
                                           FROM me_fotos_coments
                                           WHERE me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $idusuario)
                //ordeno pela data de envio
                ->order("me_fotos.DT_CADASTRO_FORC DESC")
                 ->group("NR_SEQ_FOTO_MCRC")
                 ->limit(9);

                 $this->view->fotos = $model_perfil->fetchAll($select_fotos);


			/*-------------------------------
			*
			* Responsável pelos Videos contagem
			*
			--------------------------------*/


			//inicio o model de videos
			 $model_videos = new Default_Model_Mevideos();
			  //crio o select de recados
            $select_videos_count = $model_videos
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_VIRC DESC")
                ->group("NR_SEQ_VIDEO_VIRC")
                ->order("DT_CADASTRO_VIRC DESC");
            //assino a lista de videos
            $lista_videos = $model_videos->fetchAll($select_videos_count);
          	//conto quantos registros possui
            $total_videos = count($lista_videos);
            //assino a quantidade de paginas
            $this->view->paginas_videos = ceil($total_videos / 4);

            /*-------------------------------
			*
			* Responsável pelos Videos listagem
			*
			--------------------------------*/

			//crio o select de recados
            $select_videos = $model_videos
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_VIRC DESC")
                ->group("NR_SEQ_VIDEO_VIRC")
                ->order("DT_CADASTRO_VIRC DESC")
                ->limit(4);

			$this->view->videos = $model_videos->fetchAll($select_videos);

			/*-----------------------
			*
			*Posts Contagem
			*
			*-----------------------*/

 			$model_post = new Default_Model_Reverbmeblog();
 			 //crio o select de post
            $select_post_count = $model_post
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("data_publicacao DESC")
                 ->group("idme_blog");

            //assino a lista de videos
            $lista_posts = $model_post->fetchAll($select_post_count);
          	//conto quantos registros possui
            $total_posts = count($lista_posts);
            //assino a quantidade de paginas
            $this->view->paginas_post = ceil($total_posts / 3);

			/*-----------------------
			*
			*Posts listagem
			*
			*-----------------------*/
			//select
            $select_post = $model_post
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("data_publicacao DESC")
                 ->group("idme_blog")
                 ->limit(3);

			//assino ao view
			$this->view->posts = $model_post->fetchAll($select_post);

			/*-----------------------
			*
			* Amigos contagem
			*
			*-----------------------*/
			//se for busca
			$filter_amigos = $this->_request->getParam("filter", "");
			 // Cria o objeto de conexão
        	$db = Zend_Registry::get("db");
        	 //crio a query para selecionar os amigos
            $select_amigos_count = "SELECT NR_SEQ_CADASTRO_CASO,
                                     DS_NOME_CASO,
                                     NR_SEQ_FRIEND_FRRC,
                                     NR_SEQ_AMIGO_FRRC,
                                     DS_EXT_CACH
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $idusuario
                                    ";
            //se tiver alguma palavra na pesquisa
            if ($filter_amigos != "") {
                $select_amigos_count .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%") . "";
            }
            $select_amigos_count .= " GROUP BY NR_SEQ_CADASTRO_CASO
                                ORDER BY DT_ACESSO_CASO DESC";

	        // Monta a query
	        $query_count = $db->query($select_amigos_count);
	        //crio uma lista de amigos
	        $lista_count = $query_count->fetchAll();
	        //crio o total de amigos
	        $total_amigos = count($lista_count);

	        //crio a quantidade de paginas
	        $this->view->paginas_amigos = ceil($total_amigos / 8);

			/*-----------------------
			*
			* Amigos listagem
			*
			*-----------------------*/

			 //crio a query para selecionar os amigos
            $select_amigos = "SELECT NR_SEQ_CADASTRO_CASO,
                                     DS_NOME_CASO,
                                     NR_SEQ_FRIEND_FRRC,
                                     NR_SEQ_AMIGO_FRRC,
                                     DS_EXT_CACH
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $idusuario
                                    ";
            //se tiver alguma palavra na pesquisa
            if ($filter_amigos != "") {
                $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%") . "";
            }
            $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO
                                ORDER BY DT_ACESSO_CASO DESC
                                LIMIT 8";

	        // Monta a query
	        $query = $db->query($select_amigos);
	        //crio uma lista de amigos
	        $lista = $query->fetchAll();


	        $this->view->amigos = $lista;


			/*-----------------------
			*
			* Recados count
			*
			*-----------------------*/

			 //inicio o model de recados
        	$model_scraps = new Default_Model_Mescraps();
        	//inicio a query
        	$select_scrap_count = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO', 'DS_EXT_CACH'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_POST_SBRC DESC")
                ->group("NR_SEQ_SCRAP_SBRC");

            $lista_recados = $model_scraps->fetchAll($select_scrap_count);

            //conto quantos registros possui
            $total_recados = count($lista_recados);
            //assino a quantidade de paginas
            $this->view->paginas_recados = ceil($total_recados / 5);


			/*-----------------------
			*
			* Recados listagem
			*
			*-----------------------*/

        	//inicio a query
        	$select_scrap = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO', 'DS_EXT_CACH'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_POST_SBRC DESC")
                ->group("NR_SEQ_SCRAP_SBRC")
                ->limit(5);


			//assino ao view
			$this->view->recados = $model_scraps->fetchAll($select_scrap);


			/*-----------------------
			*
			* wishlist count
			*
			*-----------------------*/

			//crio o model de wishlist
        	$wishlist_model = new Default_Model_Wishlist();
			 //crio a query da wishlist
            $select_wishlist_count = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',
                            array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_WLRC DESC")
                 ->group("NR_SEQ_WISHLIST_WLRC");

            $lista_wishlist = $wishlist_model->fetchAll($select_wishlist_count);

            //conto quantos registros possui
            $total_wishlist = count($lista_wishlist);
            //assino a quantidade de paginas
            $this->view->paginas_wishlist = ceil($total_wishlist / 6);


            /*-----------------------
			*
			* wishlist listagem
			*
			*-----------------------*/

			 //crio a query da wishlist
            $select_wishlist = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',
                            array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_WLRC DESC")
                ->group("NR_SEQ_WISHLIST_WLRC")
                ->limit(6);

			//assino ao view
			$this->view->wishlists = $wishlist_model->fetchAll($select_wishlist);

			/*-----------------------
			*
			* Cycle count
			*
			*-----------------------*/

			//crio o model de reverbcycle
       		$model_cycle = new Default_Model_Reverbcycle();

       		 //crio a query do reverbcycle
            $select_cycle_count = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            array( "total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_CRRC)
																AS total_comentatios
															FROM
															    reverbcycle_coments
															WHERE
															    NR_SEQ_REVERBCYCLE_RCRC = NR_SEQ_REVERBCYCLE_CRRC)"))
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_RCRC DESC")
                ->group("NR_SEQ_REVERBCYCLE_RCRC");

            $lista_cycle = $model_cycle->fetchAll($select_cycle_count);

            //conto quantos registros possui
            $total_cycle = count($lista_cycle);
            //assino a quantidade de paginas
            $this->view->paginas_cycle = ceil($total_cycle / 4);


            /*-----------------------
			*
			* Cycle listagem
			*
			*-----------------------*/

			//crio o model de reverbcycle
       		$model_cycle = new Default_Model_Reverbcycle();

       		 //crio a query do reverbcycle
            $select_cycle = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            array( "total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_CRRC)
																AS total_comentatios
															FROM
															    reverbcycle_coments
															WHERE
															    NR_SEQ_REVERBCYCLE_RCRC = NR_SEQ_REVERBCYCLE_CRRC)"))
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_RCRC DESC")
                ->group("NR_SEQ_REVERBCYCLE_RCRC");


			//assino ao view
			$this->view->cycles = $model_cycle->fetchAll($select_cycle);


			/*-----------------------
			*
			* Banners
			*
			*-----------------------*/
			//inicio o model de banners
			$model_banner = new Default_Model_Banners();
			//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
			$select_banner = $model_banner->select()
								->where("NR_SEQ_LOCAL_BARC = 68")
								->where("ST_BANNER_BARC = 'A'")
								->order("DT_CADASTRO_BARC DESC");
			//Assino ao view
			$this->view->banners = $model_banner->fetchAll($select_banner);

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


			//recebo o id do amigo
			$idamigo = $this->_request->getParam("idperfil");

			//inicio o model de amizade
			$model_friends = new Default_Model_Mefriends();

			//em caso de ter sido o outro usuario ter feito solicitacao faço a queery de prevencao
			$select_amizade = $model_friends->select()
										->where("NR_SEQ_CADASTRO_FRRC = ?", $usuarios->idperfil)
										->where("NR_SEQ_AMIGO_FRRC = ?", $idamigo);
			//armazeno a amizade em uma variavel
			$amizade_info = $model_friends->fetchRow($select_amizade);

			//assino ao view
			$this->view->amizade = $amizade_info;


			//inicio o model de amizade
			$model_autorizacoes = new Default_Model_Autorizacoes();

			//em caso de ter sido o outro usuario ter feito solicitacao faço a queery de prevencao
			$select_solicitacao = $model_autorizacoes->select()
										->where("NR_SEQ_CADASTRO_AURC = ?", $usuarios->idperfil)
										->where("NR_SEQ_ME_AURC = ?", $idamigo)
										->where("ST_CHAVE_AURC = 'I'");
			//armazeno a amizade em uma variavel
			$solicitacao_info = $model_autorizacoes->fetchRow($select_solicitacao);

			//assino ao view
			$this->view->solicitacao = $solicitacao_info;


		}else{
			$messages->error = "Você precisa estar logado para poder acessar esta página.";
				// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * funcao responsavel remover um recado
	 */
	public function deletarrecadoAction() {
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$usuarios = new Zend_Session_Namespace("usuarios");
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {

			//recebo o recado que será removido
			$idrecado = $this->_request->getParam("idrecado");

			//inicio o model de recados
			$model_recados = new Default_Model_Mescraps();


			try {
				//crio a condicao que sera utilizada para apagar o recado
				$where = $model_recados->getAdapter()->quoteInto('NR_SEQ_SCRAP_SBRC = ?', $idrecado);

				//removo o recado
				$model_recados->delete($where);

				$messages->success = "Seu recado foi removido com sucesso!";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);

			}catch(Exception $e) {
				//retorno mensagem de sucesso para o usuário
				$messages->error = "Ocorreu um erro ao remover seu recado";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para remover o recado.";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);

		}
	}

	/**
	* Funcao responsavel por aceitar amizade
	*/
	public function aceitaramigoAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$messages = new Zend_Session_Namespace("messages");

		// Cria a sessao dos cliente
		$usuarios = new Zend_Session_Namespace("usuarios");
		if ($usuarios->logado == TRUE) {
			//crio os dois modulos a serem usados
			$model_autorizacoes = new Default_Model_Autorizacoes();
			$model_friends = new Default_Model_Mefriends();

			//pego o id do usuario logado
			$idusuario = $usuarios->idperfil;
			//id da solicitacao
			$idamigo = $this->_request->getParam("idamigo");
			//recebo o id da solicitacao
			$idsolicitacao = $this->_request->getParam("idsolicitacao");
			//passo o parametro atualizado
			$data_solicitacoes = array('ST_CHAVE_AURC' => "A" );
			try {
				//agora atualizo a tabela de informacoes
				$model_autorizacoes->update($data_solicitacoes,  array("NR_SEQ_AUT_AURC = $idsolicitacao"));

				//agora pego os dados para inserir na tabela me friends
				$data_mefriends = array('NR_SEQ_CADASTRO_FRRC' => $idamigo,
										'NR_SEQ_AMIGO_FRRC' => $idusuario);

				//agora insiro o registro
				$model_friends->insert($data_mefriends);
				//mando mensagem de sucesso
				$messages->success = "A amizade foi feita com sucesso.";
				// Redireciona p/ pagina anterior
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}catch(Exception $e) {
				//retorno mensagem de sucesso para o usuário
				$messages->error = "Ocorreu um erro ao fazer a amizade.";
				// Redireciona p/ pagina anterior
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para aceitar o amigo.";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	* Funcao responsavel por recusar amizade
	*/
	public function recusaramigoAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		// Cria a sessao dos cliente
		$usuarios = new Zend_Session_Namespace("usuarios");
		//se estiver logado
		if ($usuarios->logado == TRUE) {
			//recebo o id do amigo
			$idamigo = $this->_request->getParam("idamigo");
			//crio o model de solicitacoes
			$model_solicitacoes = new Default_Model_Autorizacoes();
			//deleto o registro de solicitacao
			$model_solicitacoes->delete(array('NR_SEQ_AUT_AURC = ?' => $idamigo));

			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para recusar o amigo.";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	* Função responsavel por inserir um post no perfil do me
	*/
	public function publicarblogAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");

		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//inicio o model de post do me
			$model = new Default_Model_Reverbmeblog();
			//recebo os parametros
			$titulo = $this->_request->getParam("titulo");
			$mensagem = $this->_request->getParam("post");
			$idusuario = $usuarios->idperfil;
			//recebo o arquivo
			$arquivo = isset($_FILES["imagem"]) ? $_FILES["imagem"] : FALSE;


			//se tiver aquivo de foto
			if($arquivo["name"]){

				//pego a extensao
				// preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
				$ext =  strtolower(end(explode(".", $arquivo['name'])));

				//cria o nome para  a foto
				$filename = md5(time() . rand(1000, 9999)) . "." . $ext;
		
				// Move o arquivo para o diretório
				move_uploaded_file($_FILES['imagem']['tmp_name'], APPLICATION_PATH . "/../arquivos/uploads/blogme/" . $filename);

			}
				//retorno mensagem de sucesso para o usuário

			//crio o array para inserir no banco
			$data_post = array("idusuario" => $idusuario,
								"titulo" => $titulo,
								"post" => $mensagem,
								"imagem_path" => $filename);
			//insiro no banco
			$model->insert($data_post);
			//retorno mensagem de sucesso para o usuário
			$messages->success = "O registro foi inserido com sucesso!";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);

		}else{
		// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/*
	*
	*Funçao para inserir comentario
	*
	*/

	public function comentarmeAction(){
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
			$msg_model = new Default_Model_Reverbmeblogcoments();

			//se for post
			if($this->_request->isPost()){
				//recebo o parametro de mensagem pai
				$idmensagem_pai = $this->_request->getParam("idmensagem_pai", 0);
				//se continuar como zero não e resposta de nenhum comentario
				if($idmensagem_pai == 0){

					//crio o array
					$data_comentario = array("id_me_blog" => $this->_request->getParam("idpost"),
											 "idusuario" => $usuarios->idperfil,
											 "comentario" => $this->_request->getParam("comentario"),
											 "total_curtidas" => 0,
											 "total_nao_curtidas" => 0);


					try{
						$msg_model->insert($data_comentario);
						//mensagem de usuario
						$mensagem->success = "Seu comentario foi inserida com sucesso.";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);
					}catch(Exception $e){
						//dou retorno ao usuario
						// die(var_dump($e));
						$mensagem->error = "Houve um erro ao inserir seu comentario, por favor tente novamente mais tarde!";
						//retorno a ultima pagina
						$this->_redirect($_SERVER['HTTP_REFERER']);

					}
				//se for diferente de zero e porque existe resposta
				}else{
					//crio o array
					$data_comentario = array("id_me_blog" => $this->_request->getParam("idpost"),
											 "idusuario" => $usuarios->idperfil,
											 "comentario" => $this->_request->getParam("comentario"),
											 "total_curtidas" => 0,
											 "total_nao_curtidas" => 0,
											 "idme_blog_coments_pai" => $idmensagem_pai);
					try{
						$msg_model->insert($data_comentario);
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
			$this->_redirect("reverbme/cadastro-rapido");
		}

	}

	/*
	*
	* Curtir comentario me
	*
	*/

	public function curtircomentariomeAction(){

		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//inicio o model de mensagem
		$model_mensagens = new Default_Model_Reverbmeblogcoments();
		//recupero o id da msg
		$idmsg = $this->_request->getparam("idpost");
		//crio a query para receber a quantidade de curtidas
		$select = $model_mensagens->select()
					->from("me_blog_coments", array("idme_blog_coment",
									"total_curtidas"))
					->where("idme_blog_coment = ?", $idmsg);

		//recebo o resultado da pesquisa
		$resultado = $model_mensagens->fetchRow($select);
		//agora cada curtida ganha um ponto
		$total_curtida = $resultado->total_curtidas + 1;

		$data = array("total_curtidas" => $total_curtida);
		

		$model_mensagens->update($data, array("idme_blog_coment = $idmsg"));

		$mensagem->success = "Operação realizada com sucesso.";
	
		$this->_redirect($_SERVER['HTTP_REFERER']);

	}

	/*
	*
	* Não Curtir comentario me
	*
	*/

	public function naocurtircomentariomeAction(){

		//desabilito o layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//inicio a sessao de mensagem
		$mensagem = new Zend_Session_Namespace("messages");
		//inicio o model de mensagem
		$model_mensagens = new Default_Model_Reverbmeblogcoments();
		//recupero o id da msg
		$idmsg = $this->_request->getparam("idpost");
		//crio a query para receber a quantidade de curtidas
		$select = $model_mensagens->select()
					->from("me_blog_coments", array("idme_blog_coment",
									"total_nao_curtidas"))
					->where("idme_blog_coment = ?", $idmsg);
		//recebo o resultado da pesquisa
		$resultado = $model_mensagens->fetchRow($select);
		//agora cada curtida ganha um ponto
		$total_curtida = $resultado->total_nao_curtidas + 1;

		$data = array("total_nao_curtidas" => $total_curtida);

		$model_mensagens->update($data,  array("idme_blog_coment = $idmsg"));

		$mensagem->success = "Operação realizada com sucesso.";
	
		$this->_redirect($_SERVER['HTTP_REFERER']);

	}




	/**
	* Função responsavel por desativar a conta
	**/

	public function desativarcontaAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");

		$idperfil = $usuarios->idperfil;

		$data = array('ST_ENVIO_CASO' => "N",
					  'ST_ENVIOSMS_CACH' => "N",
					  'ST_CADASTRO_CASO'=> "N");
		//crio o model
		$model = new Default_Model_Reverbme();
		//atualizo a tabela
		$model->update($data, array("NR_SEQ_CADASTRO_CASO = ?" => $idperfil));
		// Destroi a sessão do usuário no site
		Zend_Session::namespaceUnset("usuarios");
	
		//retorno mensagem de sucesso para o usuário
		$messages->success = "Sua conta foi desativada com sucesso! Sentiremos sua falta :(";
		//redireciono
		$this->_redirect("/index");


	}

	/**
	* Função responsavel por alterar os dados cadastrais
	**/

	public function alterardadosAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o id do perfil que sera atualizado
			$idperfil = $usuarios->idperfil;
			// se for um post
			if($this->_request->isPost()){
				//recebo o parametro que define se altero todos os dados ou apenas da página inicial do me (1 = completo)
				$cadastro_completo = $this->_request->getParam("cadastro_completo");
				//crio o model
				$model = new Default_Model_Reverbme();
				//se for direrente de 1 quer dizer que é da página inicial do me
				if ($cadastro_completo <> 1){
					//crio o array com as informações
					$data = array("DS_NOME_CASO" => $this->_request->getParam("nome"),
								  "DS_OCUPACAO_CACH" => $this->_request->getParam("ocupacao"),
								  "DS_CIDADE_CASO" => $this->_request->getParam("cidade1"),
								  "DS_UF_CASO" => $this->_request->getParam("estado1"),
								  "DS_PLAYLIST_CACH" => $this->_request->getParam("bandas"),
								  "DS_TWITTER_CACH" => $this->_request->getParam("twitter"),
								  "DS_FACEBOOK_CACH" => $this->_request->getParam("facebook"),
					 			  "ST_ENVIO_CASO" => $this->_request->getParam('mailing'),
								  "ST_ENVIOSMS_CACH" => $this->_request->getParam('sms'));
					
					//atualizo a tabela
					$model->update($data, array("NR_SEQ_CADASTRO_CASO = ?"=>$idperfil));

					if ($this->_request->getParam('json')) {

						$retorno['mensagem'] = "Alterado com sucesso";
						$this->_helper->json($retorno);
					}

					//retorno mensagem de sucesso para o usuário
					$messages->success = "Seus dados foram atualizados com sucesso!";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}else{	

					//pego o tel para explodir o dddd e fone
					$telefone_1 = $this->_request->getParam("telefone11");

					//removo os espaços em branco
					$telefone_1 = str_replace(" ", "", $telefone_1);
	
					//agora explodo a variavel para pegar o DDD e o telefone
					$telefone_1 = explode("(", $telefone_1);
					//agora explodo a ultima vez para pegar o conteudo que eu quero realmente
					$telefone_1 = explode(")", $telefone_1[1]);

				
					$telefone_2 =  $this->_request->getParam("telefone21");

					//removo os espaços em branco
					$telefone_2 = str_replace(" ", "", $telefone_2);
	
					//agora explodo a variavel para pegar o DDD e o telefone
					$telefone_2 = explode("(", $telefone_2);
					//agora explodo a ultima vez para pegar o conteudo que eu quero realmente
					$telefone_2 = explode(")", $telefone_2[1]);

					//cpf
					$cpf = $this->_request->getParam('cpf');

					//removo os pontos do cpf
					$cpf = str_replace(".", "", $cpf);
					//removo os traços
					$cpf = str_replace("-", "", $cpf);
					//removo os espacos em branco
					$cpf = str_replace(" ", "", $cpf);

					$caracteres_cpf = strlen($cpf);

					if($caracteres_cpf < 11 or $caracteres_cpf > 11){
						// Envio um feedback de sucesso ao usuário.
						$messages->error = "o CPF Informado é invalido, Remova os pontos e traços, deixe apenas números!";
						//redireciono para a última página visitada
						$this->_redirect($_SERVER['HTTP_REFERER']);
					}

					



					//recebo os 3 campos para fazer a data de nascimento
					$dia_nascimento = $this->_request->getParam("dia_nascimento");
					$mes_nascimento = $this->_request->getParam("mes_nascimento");
					$ano_nascimento = $this->_request->getParam("ano_nascimento");

					//agora concateno a data de nascimento
					$data_nascimento = $ano_nascimento.'-'.$mes_nascimento.'-'.$dia_nascimento;

					//crio o array com as informações
					$data = array("DS_NOME_CASO" => $this->_request->getParam("nomecompleto"),
								  "DS_SEXO_CACH" => $this->_request->getParam("sexo"),
								  "DS_CPFCNPJ_CASO" => $cpf,
								  "DS_CEP_CASO" => $this->_request->getParam("cep"),
								  "DS_ENDERECO_CASO" => $this->_request->getParam("endereco"),
								  "DS_NUMERO_CASO" => $this->_request->getParam("numero"),
								  "DS_COMPLEMENTO_CASO" => $this->_request->getParam("complemento"),
								  "DS_BAIRRO_CASO" => $this->_request->getParam("bairro1"),
								  "DS_UF_CASO" => $this->_request->getParam("estado1"),
								  "DS_CIDADE_CASO" => $this->_request->getParam("cidade1"),
								  "DS_PAIS_CACH" => $this->_request->getParam("pais"),
								  "DS_DDDFONE_CASO" => $telefone_1[0],
								  "DS_FONE_CASO" => $telefone_1[1],
								  "DS_DDDCEL_CASO" => $telefone_2[0],
								  "DS_CELULAR_CASO" => $telefone_2[1],
								  "DS_EMAIL_CASO" => $this->_request->getParam("usuarioemail"),
								  "DS_SENHA_CASO" => $this->_request->getParam("usuariosenha"),
								  "DS_FACEBOOK_CACH" => $this->_request->getParam("facebook"),
								  "DS_TWITTER_CACH" => $this->_request->getParam("twitter"),
								  "DS_INSTAGRAM_CASO" => $this->_request->getParam("instagram"),
								  "DS_PINTEREST_CASO" => $this->_request->getParam("pinterest"),
								  'ST_ENVIO_CASO' => $this->_request->getParam('mailing'),
					           	  'ST_ENVIOSMS_CACH' => $this->_request->getParam('sms'),
					           	  'ST_CADASTRO_CASO'=> "A",
					           	  'ST_CADASTROCOMPLETO_CASO' => 1,
					           	  'DT_CADASTROCOMPLETO_CASO' => date('Y-m-d'));

					//se tiver informado uma data de nascimento insiro
					if($data_nascimento != '--'){
						$data["DT_NASCIMENTO_CASO"] = $data_nascimento;
					}
						
					
					try{
						
						$usuarios->cadastro_completo = 1;

						//atualizo a tabela
						$model->update($data, array("NR_SEQ_CADASTRO_CASO = ?" => $idperfil));
												//retorno mensagem de sucesso para o usuário
						$messages->success = "Seus dados foram atualizados com sucesso!";
						//redireciono
						$this->_redirect($_SERVER['HTTP_REFERER']);

					}catch(Exception $e){
						die($var_dump($e));
					}

				}

			}
		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por remover as fotos cadastradas
	**/

	public function removerfotoAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o id da foto que sera removida
			$idfoto = $this->_request->getParam("idfoto");
		//se for post
			// if ($this->_request->isPost()){
				//crio o model
				$model = new Default_Model_People();
				try {
					//removo o registro
					$model->delete(array('NR_SEQ_FOTO_FORC = ?' => $idfoto));
					//retorno mensagem de sucesso para o usuário

					$messages->success = "Sua foto foi removida com sucesso";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);

				}catch(Exception $e) {
					//retorno mensagem de sucesso para o usuário
					$messages->error = "Ocorreu um erro ao remover sua foto";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
			// }
		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por remover os videos cadastrados
	**/

	public function removervideoAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//verifico se e um post
			// if($this->_request->isPost()){
				//recebo o id da foto que sera removida
				$idvideo = $this->_request->getParam("idvideo");

				//crio o model
				$model = new Default_Model_Mevideos();
				try{
					//removo o registro
					$model->delete(array('NR_SEQ_VIDEO_VIRC = ?' => $idvideo));

					//retorno mensagem de sucesso para o usuário
					$messages->success = "Seu video foi removido com sucesso";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}catch(Exception $e){
					//retorno mensagem de sucesso para o usuário
					$messages->error = "Ocorreu um erro ao remover seu video";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);

				}
			// }

		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por remover os post dos blogs
	**/

	public function removerblogAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//se for post
			// if($this->_request->isPost()){
				//recebo o id da foto que sera removida
				$idblog = $this->_request->getParam("idblog");


				//crio o model
				$model = new Default_Model_Reverbmeblog();
				try{
					//removo o registro
					$model->delete(array('idme_blog = ?' => $idblog));

					//retorno mensagem de sucesso para o usuário
					$messages->success = "Seu post foi removido com sucesso";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}catch(Exception $e){
					//retorno mensagem de sucesso para o usuário
					$messages->error = "Houve um erro ao remover seu post.";
					// Redireciona p/ pagina anterior
					$this->_redirect($_SERVER['HTTP_REFERER']);

				}
			// }

		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por enviar uma mensagem no me
	**/

	public function enviarmensagemAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//inicio o model de recados

			$model_scraps = new Default_Model_Mescraps();
			//codigo do usuario que vai mandar a mensagem
			$idusuario = $usuarios->idperfil;
			//pego o perfil de quem vai receber a mensagem
			$idperfil = $this->_request->getParam("idperfil");

			//recebo o parametro do checkbox para privado
			$privado = $this->_request->getParam("isPrivate");
			//recebo se a pessoa quer enviar aviso por email
			$enviaemail = $this->_request->getParam("sendByMail");

			//verifico se e privado se não for o tipo de recado e publico
			if($privado == 1){
				$tipo_recado = 1;
			}else{
				$tipo_recado = 0;
			}

			//inicio o array para as informações da mensagem
			$data_mensagem = array ("NR_SEQ_CADASTRO_SBRC" => $idperfil,
									"NR_SEQ_AUTOR_SBRC" => $idusuario,
									"DS_POST_SBRC" => $this->_request->getParam("reverbme-mensagem"),
									"ST_POST_SBRC" => "A",
									"ST_PUBLICO_SBRC" => $tipo_recado);

			$model_scraps->insert($data_mensagem);

			//se o usuário chegou a opção de enviar por e-mail o aviso do recado
			if ($enviaemail == 1) {

				//inicio o model para pegar o email de quem irá receber a mensagem
				$model_perfil = new Default_Model_Reverbme();
				//crio a query
				$select_email = $model_perfil->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('cadastros', array('DS_EMAIL_CASO', "DS_NOME_CASO"))
				//pego apenas o email do perfil
				->where("NR_SEQ_CADASTRO_CASO = ?", $idperfil);

				//armazeno as informações do amigo na variavel
				$info_amigo = $model_perfil->fetchRow($select_email);



				//crio o corpo da mensagem

				//crio a mensagem
				$mensagem = 	"<tr>
									<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
										NOVO RECADO
									</td>
								</tr>
								<tr>
									<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
										</br></br>
										Olá, <b>". $info_amigo["DS_NOME_CASO"] .",</b></br></br>

										Você acaba de receber uma nova mensagem ReverbMe.

										Para acessar o seu perfil acesse o link abaixo:!</br>
										</br>

									</td>
								</tr>
								<tr>
									<td colspan=\"6\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
										<b><a href=\"http://reverbcity.com/reverbme/novome\" style=\"text-decoration:none;color: #646464; font-size: 12px;\">Meu Perfil </a></b>
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

				$emailAdm = "gustavo@reverbcity.com";
				$mail = new Zend_Mail('UTF-8');
				$mail->setBodyHtml($body,'UTF-8');
				$mail->addTo($info_amigo['DS_EMAIL_CASO'], "Reverbcity - A Música que veste");
				$mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
				$mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
				$mail->setSubject("Você recebeu um recado");
				$mail->send($mailTransport);


				//retorno mensagem de sucesso para o usuário
				$messages->success = "Seu recado foi enviado com sucesso. Enviamos um e-mail para seu amigo avisando.";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);

			}else{

				//retorno mensagem de sucesso para o usuário
				$messages->success = "Seu recado foi enviado com sucesso";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}


		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}


	/**
	* Função responsavel por remover os wishlist
	**/

	public function removerwishlistAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {

			//recebo o id da foto que sera removida
			$idwishlist = $this->_request->getParam("idwishlist");


			//crio o model
			$model = new Default_Model_Wishlist();
			try{
				//removo o registro
				$model->delete(array('NR_SEQ_WISHLIST_WLRC = ?' => $idwishlist));

				//retorno mensagem de sucesso para o usuário
				$messages->success = "Seu produto foi removido com sucesso";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}catch(Exception $e){
				//retorno mensagem de sucesso para o usuário
				$messages->error = "Ocorreu um erro ao remover o produto da sua lista de desejos!";
				// Redireciona p/ pagina anterior
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}


		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por remover os produtos do cycle
	**/

	public function removercycleAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			if($this->_request->isPost()){

				//recebo o id da foto que sera removida
				$idcycle = $this->_request->getParam("idcycle");
				//crio o model
				$model = new Default_Model_Reverbcycle();
				try{
					//removo o registro
					$model->delete(array('NR_SEQ_REVERBCYCLE_RCRC = ?' => $idcycle));

					//retorno mensagem de sucesso para o usuário
					$messages->success = "Seu produto foi removido com sucesso";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}catch(Exception $e){
					//retorno mensagem de sucesso para o usuário
					$messages->error = "Ocorreu um erro ao remover o seu produto do Reverb Cycle!";
					// Redireciona p/ pagina anterior
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
			}

		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por denunciar um perfil
	**/

	public function denunciarperfilAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo os parametros
			$iddenunciado = $this->_request->getParam("idperfil");
			$denunciante = $usuarios->nome;

			//inicio o model para pegar o nome da pessoa denunciada
			$model_me = new Default_Model_Reverbme();
			//crio a query para pegar o nome
			$select_nome = $model_me->select()
			//digo que nao existe integridade entre as tabelas
			->setIntegrityCheck(false)
			//escolho a tabela do select para o join
			->from('cadastros', array('DS_EMAIL_CASO',
			 						  'DS_NOME_CASO'))
			//pego apenas o email do perfil
			->where("NR_SEQ_CADASTRO_CASO = ?", $iddenunciado);
			//armazeno as informações do usuario em uma variavel
			$info_usuario = $model_me->fetchRow($select_nome);
			//crio o slug para colocar na url o nome do usuario
			$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $info_usuario->DS_NOME_CASO);
			$clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_| -]+/", '-', $clean);

			//pego o server
			$server = $_SERVER['SERVER_NAME'];
			//monto a url de quem esta sendo denunciado
			$urlperfil = "http://" . $server . "/perfil/" . $clean ."/". $iddenunciado;

			//crio a mensagem
			$mensagem = 	"<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
									DENUNCIA DE PERFIL
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
										O Perfil do usuário $info_usuario->DS_NOME_CASO </b></br>
										foi denunciado pelo usuario <b>$denunciante</b> por conter irregularidades.</br></br>

										Email do perfil denunciado. <b>$info_usuario->DS_EMAIL_CASO</b></br>

										Para conferir o perfil denunciado clique no link abaixo.</br>

									</br>

								</td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
									<b><a href=\"$urlperfil\" style=\"text-decoration:none;color: #646464; font-size: 12px;\">Perfil Denunciado </a></b>
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

				$emailAdm = "gustavo@reverbcity.com";
				$mail = new Zend_Mail('UTF-8');
				$mail->setBodyHtml($body,'UTF-8');
				$mail->addTo($emailAdm, "Reverbcity - A Música que veste");
				$mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
				$mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
				$mail->setSubject("Denuncia de Perfil");
				$mail->send($mailTransport);


				if($mail->send($mailTransport)){
					//retorno mensagem de sucesso para o usuário
					$messages->success = "Sua denuncia foi feita com sucesso, iremos avaliar o perfil. Obrigado.";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}else{
					//retorno mensagem de sucesso para o usuário
					$messages->error = "Ocorreu um erro ao denunciar o perfil, tente mais tarde.";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}



		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para realizar esta função!";
			// Redireciona p/ pagina anterior
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por desfazer amizade
	**/
	public function desfazeramizadeAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o id de quem não quero mais ser amigo
			$idexamigo = $this->_request->getParam("idperfil");

			//inicio o model de amizade
			$model_friends = new Default_Model_Mefriends();

			//em caso de ter sido o outro usuario ter feito solicitacao faço a queery de prevencao
			$select_amizade = $model_friends->select()
										->where("NR_SEQ_CADASTRO_FRRC = ?", $usuarios->idperfil)
										->where("NR_SEQ_AMIGO_FRRC = ?", $idexamigo);
			//armazeno a amizade em uma variavel
			$amizade_info = $model_friends->fetchRow($select_amizade);

			//tento remover o registro
			try {
				//removo o registro
				$model_friends->delete(array('NR_SEQ_FRIEND_FRRC = ?' => $amizade_info->NR_SEQ_FRIEND_FRRC));
			}
			catch(Exception $e) {
				die(var_dump($e));
			}


			//retorno mensagem de sucesso para o usuário
			$messages->success = "A amizade foi desfeita.";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);

		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para desfazer uma amizade.";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsavel por adicionar amigos
	**/
	public function adicionaramigoAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o id de quem quero ser amigo
			$idamigo = $this->_request->getParam("idperfil");
			//crio o model
			$model_solicitacoes = new Default_Model_Autorizacoes();

			//faço a query para validar
			$select_solicitacao = $model_solicitacoes->select()
										->where("NR_SEQ_CADASTRO_AURC = ?", $usuarios->idperfil)
										->where("NR_SEQ_ME_AURC = ?", $idamigo)
										->where("ST_CHAVE_AURC = 'I'");
			//armazeno a amizade em uma variavel
			$solicitacao_info = $model_solicitacoes->fetchRow($select_solicitacao);
			//agora previno que adicione mais de uma vez
			if ($solicitacao_info != "") {
				//retorno mensagem de sucesso para o usuário
				$messages->error = "Você já adicionou esta pessoa, aguarde uma resposta dela.";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			//se nao adicionou ainda faz a requisiao
			}else{

				$data_autorizacao = array("NR_SEQ_CADASTRO_AURC" => $usuarios->idperfil,
										  "NR_SEQ_ME_AURC" => $idamigo,
										  "NR_REFERENCIA_AURC" => 1,
										  "ST_CHAVE_AURC" => "I");


				//tento inserir o registro
				try {
					//insiro o registro
					$model_solicitacoes->insert($data_autorizacao);
					//retorno mensagem de sucesso para o usuário
					$messages->success = "Sua solicitação de amizade foi enviada com sucesso.";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
				catch(Exception $e) {
					die(var_dump($e));
				}
			}
		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para adicionar um amigo.";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	* Função responsável por desfazer um pedido de amizade
	**/

	public function cancelaramizadeAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o id de quem quero ser amigo
			$idamigo = $this->_request->getParam("idperfil");
			//crio o model
			$model_solicitacoes = new Default_Model_Autorizacoes();

			//faço a query para validar
			$select_solicitacao = $model_solicitacoes->select()
										->where("NR_SEQ_CADASTRO_AURC = ?", $usuarios->idperfil)
										->where("NR_SEQ_ME_AURC = ?", $idamigo)
										->where("ST_CHAVE_AURC = 'I'");

			//armazeno a amizade em uma variavel
			$solicitacao_info = $model_solicitacoes->fetchRow($select_solicitacao);
			//agora previno que adicione mais de uma vez
			if ($solicitacao_info == "") {
				//retorno mensagem de sucesso para o usuário
				$messages->error = "Não existe solicitação de amizade com este usuário.";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			//se nao adicionou ainda faz a requisiao
			}else{

				//tento remover o registro
				try {
					//removo o registro
					$model_solicitacoes->delete(array('NR_SEQ_AUT_AURC = ?' => $solicitacao_info->NR_SEQ_AUT_AURC));
					//retorno mensagem de sucesso para o usuário
					$messages->success = "Sua solicitação de amizade foi cancelada com sucesso.";
					//redireciono
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
				catch(Exception $e) {
					die(var_dump($e));
				}

			}

		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado cancelar a solicitação.";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
	* Função responsável por incluir um video no me
	**/

	public function cadastrarvideoAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//inicio o modulo do me videos
			$model = new Default_Model_Mevideos();

			//recebo os parametros
			$idusuario = $usuarios->idperfil;
			//recebi o nome do video
			$titulo = $this->_request->getParam("titulo-video");
			//recebo a url
			$url = $this->_request->getParam("url-video");

			$data = array("NR_SEQ_CADASTRO_VIRC" => $idusuario,
						  "DS_NOME_VIRC" => $titulo,
						  "DS_YOUTUBE_VIRC" => $url);
			//tento inserir o registro
			try {
				$model->insert($data);
				//retorno mensagem de sucesso para o usuário
				$messages->success = "Seu video foi inserido com sucesso.";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);

			}catch(Exception $e) {
				die(var_dump($e));
			}


		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado cancelar a solicitação.";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**
	* Função responsável por Alterar a foto do perfil
	**/

	public function alterarfotoAction(){

		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		// Cria a sessão de usuário
		$usuarios = new Zend_Session_Namespace("usuarios");
		//se o o metodo for post
		if ($this->_request->isPost()){
			//recupero o id do perfil
			$idperfil = $usuarios->idperfil;
			//pego o arquivo
			$arquivo = isset($_FILES["imagem_perfil"]) ? $_FILES["imagem_perfil"] : FALSE;

			$model_perfil = new Default_Model_Reverbme();


			//se tiver aquivo de foto
			if($arquivo["name"]){

				//pego a extensao
				// preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
				$ext =  strtolower(end(explode(".", $arquivo['name'])));

				//crio o nome da imagem
				$imagem_nome = $idperfil . "." . $ext;



				$data['DS_EXT_CACH'] = $ext;
				// Move o arquivo para o diretório
				move_uploaded_file($_FILES['imagem_perfil']['tmp_name'], APPLICATION_PATH . "/../arquivos/uploads/reverbme/" . $imagem_nome);

				$model_perfil->update($data, array("NR_SEQ_CADASTRO_CASO = ?"=>$idperfil));

			}
				//retorno mensagem de sucesso para o usuário
				$messages->success = "Foto alterada com sucesso.";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você não pode acessar esta url diretamente.";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/*
	*Função para alterar o tipo do perfil do usuario
	*/

	public function alterarprivacidadeAction(){
		// Desabilita os layouts
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		//crio a sessao de usuarios
		$usuarios = new Zend_Session_Namespace("usuarios");
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o tipo de privacidade
			$privacidade = $this->_request->getParam("tipo");

			//inicio o model do me
			$model = new Default_Model_Reverbme();

			//crio o array para atualizar o campo
			$data_privacidade = array("DS_PRIVADO_CASO" => $privacidade);

			//agora faço a atualização e dou o feedback para o usuário
			if($privacidade == 1){

				$model->update($data_privacidade, array("NR_SEQ_CADASTRO_CASO = ?"=>$usuarios->idperfil));

				//retorno mensagem de sucesso para o usuário
				$messages->success = "Seu perfil será visto apenas por amigos!";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);

			}else{

				$model->update($data_privacidade, array("NR_SEQ_CADASTRO_CASO = ?"=>$usuarios->idperfil));

				//retorno mensagem de sucesso para o usuário
				$messages->success = "Seu perfil esta visível para todos!";
				//redireciono
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			//retorno mensagem de sucesso para o usuário
			$messages->error = "Você precisa estar logado para executar esta operação!";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/*
	*
	*Detalhamento da compra
	*
	*/
	public function detalhecompraAction(){

		//crio a sessao de usuarios
		$usuarios = new Zend_Session_Namespace("usuarios");
		//crio a sessao de mensagens
		$messages = new Zend_Session_Namespace("messages");
		//verifico se existe usuário logado com sessao
		if ($usuarios->logado == TRUE) {
			//recebo o id da compra
			$idcompra = $this->_request->getParam("idcompra");
			//inicio o model de cesta
			$model_cesta = new Default_Model_Cestas;
			//inicio a consulta

			$select_cesta = $model_cesta->select()
			//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from('cestas', array("NR_SEQ_COMPRA_CESO",
									 	"VL_PRODUTO_CESO",
									 	"NR_QTDE_CESO"))		
				//agora o join dos produtos
				->joinInner("produtos", "produtos.NR_SEQ_PRODUTO_PRRC = cestas.NR_SEQ_PRODUTO_CESO", array("NR_SEQ_PRODUTO_PRRC",
																											"DS_EXT_PRRC",
																											"DS_PRODUTO_PRRC",
																											"DS_INFORMACOES_PRRC",
																											"NR_SEQ_TIPO_PRRC"))
				->joinLeft("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_SEQ_TAMANHO_ESRC"))
				->joinLeft("tamanhos", "cestas.NR_SEQ_TAMANHO_CESO = tamanhos.NR_SEQ_TAMANHO_TARC", array("DS_SIGLA_TARC"))
				->where("NR_SEQ_COMPRA_CESO = ?", $idcompra)
				->group("NR_SEQ_PRODUTO_PRRC")
				->group("DS_SIGLA_TARC");

				// die($select_cesta);/
				//crio a lista
				$lista_produtos = $model_cesta->fetchAll($select_cesta);
				//assino ao view
				$this->view->produtos_compra = $lista_produtos;


			
				//inicio o model de compras
				$model_compra = new Default_Model_Compras;
				//agora faço das compras e do comprador
				$select_compra= $model_compra->select()
				//digo que nao existe integridade entre as tabelas
				->setIntegrityCheck(false)
				//escolho a tabela do select para o join
				->from("compras", array("VL_DESCONTO_COSO", 
										"NR_PARCELAS_COSO",
										"ST_COMPRA_COSO",
										"DS_FORMAPGTO_COSO",
										"VL_TOTAL_COSO",
										"VL_FRETE_COSO",
										"DT_COMPRA_COSO",
										"NR_SEQ_COMPRA_COSO",
                                        "DS_FORMAENVIO_COSO"))
				//agora junto o comprador
				->joinInner("cadastros", "cadastros.NR_SEQ_CADASTRO_CASO = compras.NR_SEQ_CADASTRO_COSO", array("DS_NOME_CASO",
																												"DS_ENDERECO_CASO",
																												"DS_NUMERO_CASO",
																												"DS_COMPLEMENTO_CASO",
																												"DS_BAIRRO_CASO",
																												"DS_CIDADE_CASO",
																												"DS_CEP_CASO",
																												"DS_UF_CASO",
																												"DS_PAIS_CACH"))
				->where("NR_SEQ_COMPRA_COSO = ?", $idcompra);

                $modelEndereco = new Default_Model_Enderecosentrega();
                $dadosEndereco = $modelEndereco->fetchRow(array('NR_SEQ_COMPRA_ENRC = ?' => $idcompra));

                $this->view->dadosEndereco = $dadosEndereco;

				//crio uma lista
				$detalhes = $model_compra->fetchRow($select_compra);
				//assino ao view
				$this->view->detalhes = $detalhes;

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

		}else{

			$messages->error = "Você precisa estar logado para ver os detalhes da sua compra";
			//redireciono
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/*
	*
	*Funçao responsável por reabrir uma compras
	*
	*/

	public function reabrircompraAction(){
            
            //crio a sessao de usuarios
            $usuarios = new Zend_Session_Namespace("usuarios");
            //crio a sessao de mensagens
            $messages = new Zend_Session_Namespace("messages");
            $carrinho = new Zend_Session_Namespace("carrinho");

            //verifico se existe usuário logado com sessao
            if ($usuarios->logado == TRUE) {
                $model_cesta = new Default_Model_Cestas;
                $modelCompra = new Default_Model_Compras();
                
                $idcompra = $this->_request->getParam("idcompra");
                
                $dadosCompra = $modelCompra->fetchRow(array('NR_SEQ_COMPRA_COSO = ?' => $idcompra));

                if($usuarios->idperfil != $dadosCompra->NR_SEQ_CADASTRO_COSO){
                    $messages->error = "Você não tem permissão para isso";
                    $this->_redirect('/minhas-compras');
                }

                if($dadosCompra->ST_COMPRA_COSO != 'A'){
                    $messages->error = "Essa compra não está disponivel para ser reaberta.";
                    $this->_redirect('/minhas-compras');
                }

                if(!empty($dadosCompra->DS_TID_COSO)){
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $sql = "select NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO FROM cestas WHERE NR_SEQ_COMPRA_CESO = " . addslashes($idcompra);
                    $query = $db->query($sql);
                    $listas = $query->fetchAll();

                    foreach($listas as $lista){
                        $sql2 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC + ".$lista['NR_QTDE_CESO']." WHERE NR_SEQ_TAMANHO_ESRC = ".$lista['NR_SEQ_TAMANHO_CESO']." AND NR_SEQ_PRODUTO_ESRC =".$lista['NR_SEQ_PRODUTO_CESO'];
                        $db->query($sql2);

                        $sql3 = "INSERT INTO estoque_controle (NR_SEQ_USUARIO_ECRC, NR_SEQ_PRODUTO_ECRC, NR_SEQ_TAMANHO_ECRC, DS_ACAO_ECRC, DS_OBS_ECRC, DT_ACAO_ECRC, NR_QTDE_ECRC)
                           values (9, ".$lista['NR_SEQ_PRODUTO_CESO'].", ".$lista['NR_SEQ_TAMANHO_CESO'].", 'Adicionou ".$lista['NR_QTDE_CESO']."', 'Cancelamento compra " . $idcompra . " pelo cliente', sysdate(), ".$lista['NR_QTDE_CESO'].")";
                        $db->query($sql3);

                        $sql4 = "UPDATE produtos SET DS_CLASSIC_PRRC = 'N' WHERE NR_SEQ_PRODUTO_PRRC = ".$lista['NR_SEQ_PRODUTO_CESO'];
                        $db->query($sql4);

                        $data_hoje = date("Y-m-d H:s:i");
                        $sql5 = "UPDATE compras SET ST_COMPRA_COSO = 'C', DT_STATUS_COSO = '$data_hoje', ST_NOVOPGTO_COSO = null WHERE NR_SEQ_COMPRA_COSO =".$idcompra;
                        $db->query($sql5);
                    }
                }
                
                Zend_Session::namespaceUnset('carrinho');
                
                $select_cesta = $model_cesta->select()
                    //digo que nao existe integridade entre as tabelas
                    ->setIntegrityCheck(false)
                    //escolho a tabela do select para o join
                    ->from('cestas')		
                    //agora o join dos produtos
                    ->joinInner("produtos", "produtos.NR_SEQ_PRODUTO_PRRC = cestas.NR_SEQ_PRODUTO_CESO", array("NR_SEQ_PRODUTO_PRRC",
                                                                                                                                                                                                            "DS_EXT_PRRC",
                                                                                                                                                                                                            "DS_PRODUTO_PRRC",
                                                                                                                                                                                                            "DS_INFORMACOES_PRRC",
                                                                                                                                                                                                            "NR_SEQ_TIPO_PRRC"))
                    ->joinLeft("tamanhos", "cestas.NR_SEQ_TAMANHO_CESO = tamanhos.NR_SEQ_TAMANHO_TARC", array("DS_SIGLA_TARC"))
                    ->where("NR_SEQ_COMPRA_CESO = ?", $idcompra);

                    // die($select_cesta);
                    //crio a lista
                    $lista_produtos = $model_cesta->fetchAll($select_cesta);
                    
                    foreach($lista_produtos as $listaProduto){
                        
                        // Busca o id do produto
                        $idproduto = $listaProduto->NR_SEQ_PRODUTO_CESO;
                        $estoque =  $listaProduto->NR_SEQ_ESTOQUE_CESO;
                        $genero =  $this->_request->getParam("genero", 0);
                        $tamanho =  $listaProduto->NR_SEQ_TAMANHO_CESO;

                        //tipo do cadastro
                        $tipo_cadastro = $usuarios->tipo;

                        //inicio o model do produto
                        $model_produto = new Default_Model_Produtos();

                        $select_tipo = $model_produto->select()->from('produtos', array("NR_SEQ_TIPO_PRRC"))->where("NR_SEQ_PRODUTO_PRRC = ?", $idproduto);

                        $tipo_prod = $model_produto->fetchRow($select_tipo);

                        //crio a query
                        $select = $model_produto->select()
                        //digo que nao existe integridade entre as tabelas
                                ->setIntegrityCheck(false)
                                //seleciono da tabela de produtos
                                ->from('produtos', array("DS_PRODUTO_PRRC",
                                                                                "DS_INFORMACOES_PRRC",
                                                                                "DS_EXT_PRRC",
                                                                                "VL_PRODUTO_PRRC",
                                                                                "NR_PESOGRAMAS_PRRC",
                                                                                "VL_PROMO_PRRC",
                                                                                "DS_FRETEGRATIS_PRRC"))
                                //faço o join
                                ->joinLeft('estoque',
                                        'produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC', array('NR_QTDE_ESRC','NR_SEQ_TAMANHO_ESRC'))

                                ->joinLeft('tamanhos', 'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC', array("DS_SIGLA_TARC"))
                                //faco o join dos tipos
                                ->joinInner('produtos_tipo',
                                        'produtos_tipo.NR_SEQ_CATEGPRO_PTRC = produtos.NR_SEQ_TIPO_PRRC', array('NR_SEQ_CATEGPRO_PTRC'))
                                //seleciono somente o produto desejado
                                ->where("NR_SEQ_PRODUTO_PRRC = ?", $idproduto);
                        
                        //se o tipo do produto for diferente de 9 (vale presente acrescento o estoque na pesquisa)
                        if($tipo_prod->NR_SEQ_TIPO_PRRC != 9){
                                $select->where("NR_SEQ_ESTOQUE_ESRC = ?", $estoque);
                        }


                        //seleciono o produto e armazeno e uma variavel
                        $produto = $model_produto->fetchRow($select);

                        $nome = $produto['DS_PRODUTO_PRRC'];
                        $descricao = $produto['DS_INFORMACOES_PRRC'];
                        $extensao_imagem = $produto["DS_EXT_PRRC"];
                        $valor = $listaProduto->VL_PRODUTOCHEIO_CESO;
                        //$valor = $produto['VL_PRODUTO_PRRC'];
                        $peso = $produto['NR_PESOGRAMAS_PRRC'];
                        $valor_promo = $listaProduto->VL_PRODUTO_CESO;
                        //$valor_promo = $produto['VL_PROMO_PRRC'];
                        $qtde_estoque = $produto['NR_QTDE_ESRC'];
                        $tipo = $produto['NR_SEQ_CATEGPRO_PTRC'];
                        $st_frete_gratis = $produto['DS_FRETEGRATIS_PRRC'];
                        $sigla 			= $produto['DS_SIGLA_TARC'];

        //              Zend_Debug::dump($imagem);die;
                        //se for pessoa juridica adiciona ao carrinho com quantidade
                        
                        //se o tipo de produto for 9 (diferente de vale presente)
                        if($tipo_prod->NR_SEQ_TIPO_PRRC != 9){
                            $carrinho->produtos[$estoque] = array(
                                'codigo' => $idproduto,
                                'nome'          => $nome,
                                'descricao'     => $descricao,
                                'path'   => $extensao_imagem,
                                'valor'   => $valor,
                                'peso'	=> $peso,
                                'tamanho' => $tamanho,
                                'genero' => $genero,
                                'quantidade' => 1,
                                'vl_promo' => $valor_promo,
                                'estoque' => $qtde_estoque,
                                'tipo' => $tipo,
                                'idestoque' => $estoque,
                                'frete_gratis' => $st_frete_gratis,
                                'sigla' => $sigla,
                                'brinde' => 0
                            );
                            
                            // Declaro as variaveis
                            $existeValePresente = false;

                            // Percorro todos itens
                            foreach($carrinho->produtos as $key => $produtoCarrinho){
                                // Verifico se existe vale presente
                                if($produtoCarrinho['tipo'] == 9){
                                    $existeValePresente = true;
                                }
                            }

                            // Se existir vale presente
                            if($existeValePresente){
                                // Apago ele do carrinho
                                unset($carrinho->produtos[$estoque]);
                                $messages->error = "Finalize a compra do vale presente para comprar outros produtos.";

                                // Redireciona para a pagina anterior
                                $this->_redirect('/carrinho-compras');
                            }
                        // Se o produto for vale presente
                        }else{
                            $carrinho->produtos[$idproduto] = array(
                                'codigo' => $idproduto,
                                'nome'          => $nome,
                                'descricao'     => $descricao,
                                'path'   => $extensao_imagem,
                                'valor'   => $valor,
                                'peso'	=> $peso,
                                'tamanho' => 12,
                                'genero' => $genero,
                                'quantidade' => 1,
                                'vl_promo' => $valor_promo,
                                'estoque' => $qtde_estoque,
                                'tipo' => $tipo,
                                'idestoque' => 1,
                                'frete_gratis' => $st_frete_gratis,
                                'sigla' => $sigla,
                                'brinde' => 0
                            );

                            // Declaro as variaveis
                            $existeProduto = false;

                            // Percorro todos itens
                            foreach($carrinho->produtos as $key => $produtoCarrinho){
                                // Verifico se existe produto
                                if($produtoCarrinho['tipo'] != 9){
                                    $existeProduto = true;
                                }
                            }

                            // Se existir produto
                            if($existeProduto){
                                // Apago ele do carrinho
                                unset($carrinho->produtos[$idproduto]);
                                $messages->error = "A compra do vale presente precisa ser feita em um pedido separado.";

                                // Redireciono ele para a pagina anterior
                                $this->_redirect($_SERVER['HTTP_REFERER']);
                            }
                        }
                    }
            }

            $this->_redirect('/carrinho-compras');
            

//		//crio a sessao de usuarios
//		$usuarios = new Zend_Session_Namespace("usuarios");
//		//crio a sessao de mensagens
//		$messages = new Zend_Session_Namespace("messages");
//		//verifico se existe usuário logado com sessao
//		if ($usuarios->logado == TRUE) {
//			//recebo o id da compra
//			$idcompra = $this->_request->getParam("idcompra");
//			//inicio o model de cesta
//			$model_cesta = new Default_Model_Cestas;
//			//inicio a consulta
//
//			$select_cesta = $model_cesta->select()
//			//digo que nao existe integridade entre as tabelas
//				->setIntegrityCheck(false)
//				//escolho a tabela do select para o join
//				->from('cestas', array("NR_SEQ_COMPRA_CESO",
//									 	"VL_PRODUTO_CESO",
//									 	"NR_QTDE_CESO"))		
//				//agora o join dos produtos
//				->joinInner("produtos", "produtos.NR_SEQ_PRODUTO_PRRC = cestas.NR_SEQ_PRODUTO_CESO", array("NR_SEQ_PRODUTO_PRRC",
//																											"DS_EXT_PRRC",
//																											"DS_PRODUTO_PRRC",
//																											"DS_INFORMACOES_PRRC",
//																											"NR_SEQ_TIPO_PRRC"))
//				->joinLeft("tamanhos", "cestas.NR_SEQ_TAMANHO_CESO = tamanhos.NR_SEQ_TAMANHO_TARC", array("DS_SIGLA_TARC"))
//				->where("NR_SEQ_COMPRA_CESO = ?", $idcompra);
//
//				// die($select_cesta);
//				//crio a lista
//				$lista_produtos = $model_cesta->fetchAll($select_cesta);
//				//assino ao view
//				$this->view->produtos_compra = $lista_produtos;
//
//
//			
//				//inicio o model de compras
//				$model_compra = new Default_Model_Compras;
//				//agora faço das compras e do comprador
//				$select_compra= $model_compra->select()
//				//digo que nao existe integridade entre as tabelas
//				->setIntegrityCheck(false)
//				//escolho a tabela do select para o join
//				->from("compras", array("VL_DESCONTO_COSO", 
//										"NR_PARCELAS_COSO",
//										"ST_COMPRA_COSO",
//										"DS_FORMAPGTO_COSO",
//										"VL_TOTAL_COSO",
//										"VL_FRETE_COSO",
//										"DT_COMPRA_COSO",
//										"NR_SEQ_COMPRA_COSO",
//										"TOTAL_COMPRA" => "(SELECT SUM(VL_PRODUTO_CESO) FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idcompra)"))
//				//agora junto o comprador
//				->joinInner("cadastros", "cadastros.NR_SEQ_CADASTRO_CASO = compras.NR_SEQ_CADASTRO_COSO", array("DS_NOME_CASO",
//																												"DS_ENDERECO_CASO",
//																												"DS_NUMERO_CASO",
//																												"DS_COMPLEMENTO_CASO",
//																												"DS_BAIRRO_CASO",
//																												"DS_CIDADE_CASO",
//																												"DS_CEP_CASO",
//																												"DS_UF_CASO",
//																												"DS_PAIS_CACH"))
//				->where("NR_SEQ_COMPRA_COSO = ?", $idcompra);
//
//
//
//				//crio uma lista
//				$detalhes = $model_compra->fetchRow($select_compra);
//				//assino ao view
//				$this->view->detalhes = $detalhes;
//
//				$total_compra = $detalhes->VL_TOTAL_COSO;
//
//				//verifico o total da compra
//				switch ($total_compra) {
//				// se for maior ou igual que 50 dividimos em 2 vezes
//					case $total_compra >= 50:
//						//2x
//						$this->view->duas_parcelas = $total_compra / 2;
//
//					//se for maior que 100 dividimos em 3x
//					case $total_compra >= 100:
//						//3X
//						$this->view->tres_parcelas = $total_compra / 3;
//					//se for maior que 150 4x
//					case $total_compra >= 150:
//
//						$this->view->quatro_parcelas = $total_compra / 4;
//
//				}
//
//				$model_banner = new Default_Model_Banners();
//				//crio o dia e hora atual
//				$dia_hora = date("Y-m-d H:i:s");
//				//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
//				$select_agendado_topo = $model_banner->select()
//									->where("NR_SEQ_LOCAL_BARC = 87")
//									->where("ST_BANNER_BARC = 'A'")
//									->where("ST_AGENDAMENTO_BARC = 1")
//									->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
//									->order("DT_CADASTRO_BARC DESC");
//									
//				//armazeno em uma variavel
//				$agendados_topo = $model_banner->fetchAll($select_agendado_topo)->toArray();
//				
//				//crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
//				$select_normais_topo = $model_banner->select()
//										->where("NR_SEQ_LOCAL_BARC = 87")
//										->where("ST_BANNER_BARC = 'A'")
//										->where("ST_AGENDAMENTO_BARC = 0")
//										->order("DT_CADASTRO_BARC DESC");
//									
//				//armazeno em uma variavel
//				$normais_topo = $model_banner->fetchAll($select_normais_topo)->toArray();
//				//junto os 2 tipos de banners em um só array
//				$banners_topo = array_merge($agendados_topo ,$normais_topo);
//
//				//Assino ao view
//				$this->view->banners = $banners_topo;
//
//		}else{
//
//			$messages->error = "Você precisa estar logado para ver os detalhes da sua compra";
//			//redireciono
//			$this->_redirect($_SERVER['HTTP_REFERER']);
//		}


	}
}

