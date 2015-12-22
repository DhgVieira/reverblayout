<?php

/**
 *
 */
class PeopleController extends Zend_Controller_Action {

    /**
     *
     */
    public function init() {
        /* Initialize action controller here */
        $captcha = new Zend_Captcha_Image(); // Este é o nome da classe, no secrets...  
        $captcha->setWordlen(3) // quantidade de letras, tente inserir outros valores  
                ->setImgDir(APPLICATION_PATH . '/../arquivos/uploads/captcha')// o caminho para armazenar as imagens
                ->setGcFreq(10)//especifica a cada quantas vezes o garbage collector vai rodar para eliminar as imagens inválidas
                ->setExpiration(500)// tempo de expiração em segundos.
                ->setHeight(80) // tamanho da imagem de captcha
                ->setWidth(130)// largura da imagem
                ->setLineNoiseLevel(1) // o nivel das linhas, quanto maior, mais dificil fica a leitura
                ->setDotNoiseLevel(1)// nivel dos pontos, experimente valores maiores
                ->setFontSize(15)//tamanho da fonte em pixels
                ->setFont(APPLICATION_PATH . '/../arquivos/default/fonts/andes-regular.ttf'); // caminho para a fonte a ser usada
        $this->view->idCaptcha = $captcha->generate(); // passamos aqui o id do captcha para a view
        $this->view->captcha = $captcha->render($this->view); // e o proprio captcha para a view

        $this->view->title = "Reverb People - Quem usa Reverbcity";
        $this->view->description = "Veja a galeria das pessoas que usam Reverbcity";
        $this->view->keywords = "Reverbcity, fotos, clientes, festivais, galeria de fotos";

        date_default_timezone_set('America/Sao_Paulo');
    }

    /**
     *
     */
    public function indexAction() {
        //crio a listagem de imagens
        $model_perfil = new Default_Model_Reverbme();
        //crio a query
        $select_fotos = $model_perfil->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_fotos', array("NR_SEQ_CADASTRO_FORC",
                    "DS_NOME_FORC",
                    "DS_EXT_FORC",
                    "NR_SEQ_FOTO_FORC",
                    "NR_VIEWS_FORC",
                    //crio uma subquery para contar o numero de comentarios
                    "total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_MCRC)
																AS total_comentatios
															FROM
															    me_fotos_coments
															WHERE
															    NR_SEQ_FOTO_MCRC = NR_SEQ_FOTO_FORC)"))
                //crio o inner join das pessoas
                ->joinInner('cadastros', 'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO', array("DS_NOME_CASO",
            "DS_CIDADE_CASO",
            "NR_SEQ_CADASTRO_CASO"));

        //se for post, faz a busca
        if ($this->_request->isPost()) {
            // defino o adaptador do banco
            $db = Zend_Registry::get("db");
            $palavra = $this->_request->getParam("busca_people");

            $select_fotos->where("DS_NOME_CASO LIKE " . $db->quote("%" . $palavra . "%") . "OR DS_CIDADE_CASO LIKE " . $db->quote("%" . $palavra . "%"));
        }
        $select_fotos->where('me_fotos.ST_PEOPLE_FORC = "A"');
        //ordeno pela data de envio
        $select_fotos->order("me_fotos.NR_SEQ_FOTO_FORC DESC");

//        $select_fotos->limit('10');

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($select_fotos);

        // crio paginacao com numeros
        $current_page = $this->_request->getParam("page", 1);

        //defino a quantidade de itens por pagina
        $paginator->setItemCountPerPage(20)
                //defino a quantidade de paginas
                ->setPageRange(5)
        ->setCurrentPageNumber($this->_getParam('page', 1));
        //atribuo ovalor a variavel
        $pages = $paginator->getPages();
        //crio o array de paginas
        $pageArray = get_object_vars($pages);
        //assino
        $this->view->assign('pages', $pageArray);
//        print_r($select_fotos->__toString());
//        die;
        //passo para o paginador o select de produtos
        $contador = new Reverb_Paginator($select_fotos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(20)
            ->setCurrentPageNumber($current_page)
                //defino quantas páginas iram aparecer por vez
                ->setPageRange(5)
                //assino a paginacao
                ->assign();
        //assino ao view
        $query = $select_fotos->__toString();
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
        $banners_topo = array_merge($agendados_topo, $normais_topo);

        $this->view->headLink()->appendStylesheet('/arquivos/default/css/people.css');

        $this->view->headScript()
            ->appendFile(
                'https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js', 'text/javascript'
            )->appendFile(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-infinitescroll/2.1.0/jquery.infinitescroll.min.js',
                'text/javascript')
            ->appendFile(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.0.4/jquery.imagesloaded.min.js'
            )->appendFile(
                '/arquivos/default/js/people.js', 'text/javascript'
        );

        //Assino ao view
        $this->view->banners = $banners_topo;
        $this->view->page = $this->_request->getParam("page", 1);
    }

    /**
     *
     */
    public function ajaxpeopleAction() {
        $this->_helper->layout()->disableLayout();
        //crio a listagem de imagens
        $model_perfil = new Default_Model_Reverbme();
        //crio a query
        $select_fotos = $model_perfil->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_fotos', array("NR_SEQ_CADASTRO_FORC",
                    "DS_NOME_FORC",
                    "DS_EXT_FORC",
                    "NR_SEQ_FOTO_FORC",
                    "NR_VIEWS_FORC",
                    //crio uma subquery para contar o numero de comentarios
                    "total_comentarios" => "(SELECT
															COUNT(NR_SEQ_COMENTARIO_MCRC)
																AS total_comentatios
															FROM
															    me_fotos_coments
															WHERE
															    NR_SEQ_FOTO_MCRC = NR_SEQ_FOTO_FORC)"))
                //crio o inner join das pessoas
                ->joinInner('cadastros', 'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO', array("DS_NOME_CASO",
            "DS_CIDADE_CASO",
            "NR_SEQ_CADASTRO_CASO"));

        //se for post, faz a busca
        if ($this->_request->isPost()) {
            // defino o adaptador do banco
            $db = Zend_Registry::get("db");
            $palavra = $this->_request->getParam("busca_people");

            $select_fotos->where("DS_NOME_CASO LIKE " . $db->quote("%" . $palavra . "%") . "OR DS_CIDADE_CASO LIKE " . $db->quote("%" . $palavra . "%"));
        }
        $select_fotos->where('me_fotos.ST_PEOPLE_FORC = "A"');
        //ordeno pela data de envio
        $select_fotos->order("me_fotos.NR_SEQ_FOTO_FORC DESC");

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($select_fotos);
        //defino a quantidade de itens por pagina
        $paginator->setItemCountPerPage(20)
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
        $contador = new Reverb_Paginator($select_fotos);
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
     * detalhamento da foto
     */
    public function peopledetalheAction() {
        $usuarios = new Zend_Session_Namespace("usuarios");

        //verifico se existe usuário logado com sessao
        if ($usuarios->logado == TRUE) {

            $idfoto = $this->_request->getParam("idfoto");
            //crio a listagem de imagens
            $model_perfil = new Default_Model_Reverbme();
            //crio a query
            $select_fotos = $model_perfil->select()
                    //digo que nao existe integridade entre as tabelas
                    ->setIntegrityCheck(false)
                    //escolho a tabela do select para o join
                    ->from('cadastros', array("DS_NOME_CASO",
                        "DS_CIDADE_CASO",
                        "NR_SEQ_CADASTRO_CASO"))
                    //crio o inner join das pessoas
                    ->joinInner('me_fotos', 'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO', array('*'))
                    ->where("NR_SEQ_FOTO_FORC = ?", $idfoto);

            $fotos = $model_perfil->fetchRow($select_fotos);
            //assino ao view
            $this->view->foto = $fotos;

            $db = Zend_Registry::get("db");
            //crio a query para selecionar os comentarios
            $select_comentarios = "SELECT
	    								`cadastros`.`DS_NOME_CASO`,
	    								`cadastros`.`NR_SEQ_CADASTRO_CASO`,
	   								 	`me_fotos_coments` . *
									FROM
										me_fotos_coments
	  								inner join
									cadastros on cadastros.NR_SEQ_CADASTRO_CASO = me_fotos_coments.NR_SEQ_CADASTRO_MCRC
									WHERE me_fotos_coments.NR_SEQ_FOTO_MCRC = $idfoto AND comentario_id IS NULL
									ORDER BY
										NR_SEQ_COMENTARIO_MCRC
									DESC
									LIMIT 4";

            // Monta a query
            $query = $db->query($select_comentarios);
            //crio uma lista de comentarios
            $lista = $query->fetchAll();
            //assino os comentarios ao view
            $this->view->comentarios = $lista;
            //assino o idpeple
            $this->view->idpeople = $idfoto;
            //se for um post significa que esta inserindo um registro
            if ($this->_request->isPost()) {
                //inicio o model
                $model_coments = new Default_Model_Fotoscomentariosme();
                //recebo os parametros
                $mensagem = $this->_request->getParam("mensagem");
                //crio  a data atual
                $data_hora = date('d-m-Y');
                $data_hora .= ' ' . date('H:i:s');
                //crio o array com os campos
                $data = array('NR_SEQ_CADASTRO_MCRC' => $usuarios->idperfil,
                    'NR_SEQ_FOTO_MCRC' => $idfoto,
                    'DT_CADASTRO_MCRC' => $data_hora,
                    'DS_STATUS_MCRC' => "A",
                    'DS_TEXTO_MCRC' => $mensagem);
                //insiro no banco
                $model_coments->insert($data);
            }

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
            $banners_topo = array_merge($agendados_topo, $normais_topo);

            //Assino ao view
            $this->view->banners = $banners_topo;

            //vejo o numero de views 
            $nr_views = $fotos->NR_VIEWS_FORC;


            $total_views = $nr_views + 1;

            $data_views = array("NR_VIEWS_FORC" => $total_views);
            //atualizo o numero de views
            $db->update("me_fotos", $data_views, 'NR_SEQ_FOTO_FORC =' . $idfoto);
        } else {
            // Envio um feedback de sucesso ao usuário.
            $session->error = "Para vizualizar esta página você deve estar logado!";
            //redireciono para a ultima pagina
            $this->_redirect("/reverbme");
        }
    }

    //função responsável por comentar uma foto do people
    public function comentarpeopleAction() {

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
            $idpeople = $this->_request->getparam("idpeople");
            $idmensagem = $this->_request->getParam('idmensagem', null);
            $status = "I";
            //crio  a data atual
            $data_hora = date('d-m-Y');
            $data_hora .= ' ' . date('H:i:s');

            //crio um array para inserir os valores no banco de dados
            $data = array('NR_SEQ_CADASTRO_MCRC' => $idusuario,
                'NR_SEQ_FOTO_MCRC' => $idpeople,
                'DS_STATUS_MCRC' => $status,
                'DS_TEXTO_MCRC' => $mensagem,
                'comentario_id' => $idmensagem);
            //insiro o registro
            $db->insert("me_fotos_coments", $data);
            // Envio um feedback de sucesso ao usuário.
            $session->success = "Seu comentário foi inserido com sucesso!";
            //redireciono para a ultima página
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //função responsável por comentar uma foto do people
    public function apagarComentarioPeopleAction() {

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

        try {
            //verifico se o usuario esta logado
            if ($usuarios->logado == true) {
                if ($usuarios == 2 || $usuarios == 4162 || $usuarios == 22652) {
                    $model = new Default_Model_Fotoscomentariosme();
                    $model->update(array('DS_STATUS_MCRC' => 'I'), array('NR_SEQ_COMENTARIO_MCRC = ?' => $idcomentario));
                }
            }

            $messages->success = "Comentário inativado com sucesso.";
        } catch (Exception $ex) {
            $messages->error = "Ocorreu um erro ao inativar o comentário.";
        }

        $this->_redirect($_SERVER['HTTP_REFERER']);
    }

    //função responsável por apagar o people
    public function cadastrarpeopleAction() {
        //inicio a sessao e verifico se o usuário ja esta logado
        $usuarios = new Zend_Session_Namespace("usuarios");
        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");
        //verifico se existe usuário logado com sessao
        if ($usuarios->logado != TRUE) {
            // Envio um feedback de sucesso ao usuário.
            $session->error = "Para incluir uma foto você deverá esta logado";
            //redireciono para a ultima pagina
            $this->_redirect("reverbme");
            //se estiver logado faz o cadastro
        } else {
            //se for post
            if ($this->_request->isPost()) {
                //recebo os parametros
                $idusuario = $usuarios->idperfil;
                $nome = $usuarios->nome;

                //inicio o model people
                $model_people = new Default_Model_People();

                //crio o array com os dados recebido
                $data = array('NR_SEQ_CATEGORIA_FORC' => 1,
                    'DS_NOME_FORC' => $nome,
                    'NR_SEQ_CADASTRO_FORC' => $idusuario,
                    'ST_PEOPLE_FORC' => 'A',
                    'DS_PEOPLE_FORC' => 'S',
                    'DT_CADASTRO_FORC' => date('Y-m-d H:i:s'));

                try {

                    //insiro os registros e pego o ID
                    $id_registro = $model_people->insert($data);
                } catch (Excpetion $e) {
                    var_dump($e);
                    die();
                }


                //faço o upload daa imagem
                if ($_FILES['imagem']['tmp_name'] != "") {

                    $extensao = strtolower(end(explode(".", $_FILES['imagem']['name'])));
                    //cria o nome para  a foto
                    $filename = $id_registro . "." . $extensao;
                    //atribuo o valor do nome
                    $data_img['DS_EXT_FORC'] = $extensao;

                    // Move o arquivo para o diretório
                    move_uploaded_file($_FILES['imagem']['tmp_name'], APPLICATION_PATH . "/../arquivos/uploads/people/" . $filename);
                }

                //atualizo com extenção do arquivo
                $model_people->update($data_img, array("NR_SEQ_FOTO_FORC = ?" => $id_registro));


                // Envio um feedback de sucesso ao usuário.
                $session->success = "Sua foto foi inserida com sucesso!";
                //redireciono para a ultima página
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function removeAction() {
        $foto_id = $this->_request->getParam('foto_id');

        if (!empty($foto_id)) {
            $usuarios = new Zend_Session_Namespace("usuarios");

            if ($usuarios->idperfil == '359733' or $usuarios->idperfil == '2' or $usuarios->idperfil == '4162') {
                $modelPeople = new Default_Model_People();
                $modelPeople->update(array('ST_PEOPLE_FORC' => 'I'), array('NR_SEQ_FOTO_FORC = ?' => $foto_id));
            }
        }

        $this->_redirect($_SERVER['HTTP_REFERER']);
    }

}
