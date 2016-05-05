<?php

/**
 *
 */
class IndexController extends Zend_Controller_Action {

    /**
     *
     */
    public function init() {

        // require ($_SERVER['DOCUMENT_ROOT'] ."/library/Reverb/Seguranca/Ssl.php");
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
    }

    public function testeAction() {

        $modeAviseme = new Default_Model_Aviseme();
        $selectAviseme = $modeAviseme->select()
                ->from(array('a' => 'aviseme'))
                ->where('NR_SEQ_PRODUTO_AVRC = ?', 5105)
                ->where('ST_AVISO_AVRC = "N"');

        $dadosAviseme = $modeAviseme->fetchAll($selectAviseme)->toArray();
        $count = 4;
        $msg = "A camiseta dos Beatles voltou! Corre, é numa quantidade SUPER limitada http://rvb.la/Beatles";

        foreach ($dadosAviseme as $avise) {
            $celular = preg_replace("/[^0-9]/", "", $avise['DS_TELEFONE_AVRC']);
            $primeiroDigito = substr($celular, 0, 1);

            if ($primeiroDigito) {
                if ($primeiroDigito == 0) {
                    $celular = substr($celular, 1);
                }

                file_get_contents("http://193.105.74.59/api/sendsms/plain?user=rbcity&password=rbcity123&sender=Reverbcity&GSM=554399553021&SMStext=" . urlencode($msg));
                $count++;

                $modeAviseme->update(array('ST_AVISO_AVRC' => 'S'), array('NR_SEQ_AVISEME_AVRC = ?' => $avise['NR_SEQ_AVISEME_AVRC']));

                exit;
            }
        }
        die('ok');
    }

    /**
     *
     */
    public function indexAction() {
        // script para mudar a inicial para /inicio/page

        $this->view->headLink()->offsetUnset(2);
        $this->view->headLink()->appendStylesheet($this->view->basePath . '/arquivos/application/css/default/index/inicio.css');
        $this->inicioAction();
        $this->render('inicio');

        //$this->view->title = "Loja - Reverbcity.com";
        $this->view->title = "Camisetas de rock, indie, personalizadas - Reverbcity.com";
        $this->view->description = "Na Reverbcity você encontra diversas camisetas de bandas rock, camisetas indie, raglans personalizadas e muito mais!";
        $this->view->keywords = "Reverbcity, camisetas de bandas de rock, camisetas rock, camisetas personalizadas, camisetas indie";

        $iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");

        $campanhas = new Zend_Session_Namespace("campanhas");
        //pego a url da campanha
        $endereco = $_SERVER ['REQUEST_URI'];
        //pego o id da campanha
        $parametro = explode("=", $endereco);
        //adiciono a campanha a sessão
        //verifico se existe parametro

        if ($parametro[1] != "") {
            //adiciono a campanha a sessão
            $campanhas->idcampanha = $parametro[1];
        }
        //se nao existir eu redireciono para a página de cadastro
        //$this->_redirect("index/inicio");

        if ($iphone || $android || $palmpre || $ipod || $iPad || $berry == true) {
            //se nao existir eu redireciono para a página de cadastro
            $this->_redirect("index/inicio");
        } else {
            //crio a sessao de usuários
            $usuarios = new Zend_Session_Namespace("usuarios");
            //crio o dia e hora atual
            $dia_hora = date("Y-m-d H:i:s");

            /*             * **********
             * BANNERS AGENDADOS
             * *********** */

            // // Busca o cache
            // $idCache = "banners_agendado";
            // $agendados = Zend_Registry::get("cache")->load($idCache);
            // // Se nao existir o cache faz consulta
            // if(!$agendados) {
            //inicio o model de banners
            $model_banner = new Default_Model_Banners();



            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_normais_topo = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 87")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->where("ST_AGENDAMENTO_BARC = 0")
                    ->order("DT_CADASTRO_BARC DESC");

            //armazeno em uma variavel
            $normais_topo = $model_banner->fetchAll($select_normais_topo)->toArray();
            //junto os 2 tipos de banners em um só array
            $banners_topo = $normais_topo;

            //Assino ao view
            $this->view->banners_topo = $banners_topo;
            //crio a query com 				os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_agendado = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 65")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->where("ST_AGENDAMENTO_BARC = 1")
                    ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                    ->order("RAND()");

            //armazeno em uma variavel
            $agendados = $model_banner->fetchAll($select_agendado)->toArray();

            // // Salva o cache
            //  	Zend_Registry::get("cache")->save($agendados, $idCache);
            // }


            /*             * **********
             * BANNERS NORMAIS
             * *********** */

            // // Busca o cache
            // $idCache1 = "banners_normais";
            // $normais = Zend_Registry::get("cache")->load($idCache1);
            // // Se nao existir o cache faz consulta
            // if(!$normais) {
            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_normais = $model_banner->select();
            //agora faço a condição de frete grátis para usuários de londrina
            if ($usuarios->cidade != "Londrina") {
                //inicio o model de promocoes
                $model_promo = new Default_Model_Promocoes();
                //assino os valores na variavel
                $promocoes = $model_promo->fetchRow();
                //verifico se a promo de frete gratis londrina esta ativae o tipo de cadastro nao for pj
                if ($promocoes["st_frete_londrina"] == 1 and $usuarios->tipo <> 'PJ') {

                    $select_normais->where("NR_SEQ_BANNER_BARC not in(568)");
                }
            }

            $select_normais->where("NR_SEQ_LOCAL_BARC = 65")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->where("ST_AGENDAMENTO_BARC = 0")
                    ->order("RAND()");

            //armazeno em uma variavel
            $normais = $model_banner->fetchAll($select_normais)->toArray();

            // 	 // Salva o cache
            //    	Zend_Registry::get("cache")->save($normais, $idCache1);
            // }

            /*             * **********
             * FUSAO BANNERS AGENDADOS E NORMAIS
             * *********** */

            //junto os 2 tipos de banners em um só array
            $banners = array_merge($agendados, $normais);

            if (count($banners) <= 0) {
                $this->_redirect("index/inicio");
            }
            //randomico
            shuffle($banners);
            //Assino ao view
            $this->view->banners = $banners;


            /*             * **********
             * BANNERS MENORES AGENDADO 1
             * *********** */

            // Busca o cache
            $idCache2 = "banners_agendado_menor1";

            $banner_1 = Zend_Registry::get("cache")->load($idCache2);

            // Se nao existir o cache faz consulta
            if (!$banner_1) {

                //seleciono os banners menores
                $select_banner_1 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 66")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 1")
                        ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //salvo o resultado em uma variavel
                $banner_1 = $model_banner->fetchAll($select_banner_1)->toArray();

                // Salva o cache
                Zend_Registry::get("cache")->save($banner_1, $idCache2);
            }


            //conto quantos agendados existem
            $total_agendado = count($banner_1);

            /*             * **********
             * BANNERS MENORES NORMAIS 1
             * *********** */

            // Busca o cache
            $idCache3 = "banners_normais_menor1";

            $banner_1_comun = Zend_Registry::get("cache")->load($idCache3);

            // Se nao existir o cache faz consulta
            if (!$banner_1_comun) {

                //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
                $select_normais_1 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 66")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 0")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //agora armazeno os banners em uma variavel
                $banner_1_comun = $model_banner->fetchAll($select_normais_1)->toArray();

                // Salva o cache
                Zend_Registry::get("cache")->save($banner_1_comun, $idCache3);
            }

            /*             * **********
             * CONDICOES PARA JUNTAR OS BANNERS DESTA POSICAO
             * *********** */

            //agora verifico se tem menos de 3 banners agendados para poder entrar os não agendados
            if ($total_agendado == 0) {
                //uno os arrays
                $banners_1 = array_merge($banner_1, $banner_1_comun);

                //assino ao view
                $this->view->banner_1 = $banners_1;
                //se tiver 3 ou mais ele assina somente os agendados
            } else {
                //Assino ao view
                $this->view->banner_1 = $banner_1;
            }

            /*             * **********
             * BANNERS MENORES AGENDADOS 2
             * *********** */

            // Busca o cache
            $idCache4 = "banners_agendado_menor2";

            $banner_2 = Zend_Registry::get("cache")->load($idCache4);

            // Se nao existir o cache faz consulta
            if (!$banner_2) {

                //seleciono os banners menores
                $select_banner_2 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 90")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 1")
                        ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //salvo o resultado em uma variavel
                $banner_2 = $model_banner->fetchAll($select_banner_2)->toArray();

                // Salva o cache
                Zend_Registry::get("cache")->save($banner_2, $idCache4);
            }

            //conto quantos agendados existem
            $total_agendado_2 = count($banner_2);

            /*             * **********
             * BANNERS MENORES NORMAIS 2
             * *********** */

            // Busca o cache
            $idCache5 = "banners_normais_menor2";

            $banner_2_comun = Zend_Registry::get("cache")->load($idCache5);

            // Se nao existir o cache faz consulta
            if (!$banner_2_comun) {


                //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
                $select_normais_2 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 90")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 0")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //agora armazeno os banners em uma variavel
                $banner_2_comun = $model_banner->fetchAll($select_normais_2)->toArray();

                // Salva o cache
                Zend_Registry::get("cache")->save($banner_2_comun, $idCache5);
            }

            /*             * **********
             * CONDICOES PARA JUNTAR OS BANNERS DESTA POSICAO
             * *********** */

            //agora verifico se tem menos de 3 banners agendados para poder entrar os não agendados
            if ($total_agendado_2 == 0) {
                //uno os arrays
                $banners_2 = array_merge($banner_2, $banner_2_comun);

                //assino ao view
                $this->view->banner_2 = $banners_2;
                //se tiver 3 ou mais ele assina somente os agendados
            } else {
                //Assino ao view
                $this->view->banner_2 = $banner_2;
            }

            /*             * **********
             * BANNERS MENORES AGENDADOS 3
             * *********** */

            // Busca o cache
            $idCache6 = "banners_agendado_menor3";

            $banner_3 = Zend_Registry::get("cache")->load($idCache6);

            // Se nao existir o cache faz consulta
            if (!$banner_3) {

                //seleciono os banners menores
                $select_banner_3 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 91")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 1")
                        ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //salvo o resultado em uma variavel
                $banner_3 = $model_banner->fetchAll($select_banner_3)->toArray();

                // Salva o cache
                Zend_Registry::get("cache")->save($banner_3, $idCache6);
            }

            //conto quantos agendados existem
            $total_agendado_3 = count($banner_3);


            /*             * **********
             * BANNERS MENORES COMUNS 3
             * *********** */

            // Busca o cache
            $idCache7 = "banners_normais_menor3";

            $banner_3_comun = Zend_Registry::get("cache")->load($idCache7);

            // Se nao existir o cache faz consulta
            if (!$banner_3_comun) {

                //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
                $select_normais_3 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 91")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 0")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //agora armazeno os banners em uma variavel
                $banner_3_comun = $model_banner->fetchAll($select_normais_3)->toArray();

                // Salva o cache
                Zend_Registry::get("cache")->save($banner_3_comun, $idCache7);
            }

            /*             * **********
             * CONDICOES PARA JUNTAR OS BANNERS DESTA POSICAO
             * *********** */

            //agora verifico se tem menos de 3 banners agendados para poder entrar os não agendados
            if ($total_agendado_3 == 0) {
                //uno os arrays
                $banners_3 = array_merge($banner_3, $banner_3_comun);

                //assino ao view
                $this->view->banner_3 = $banners_3;
                //se tiver 3 ou mais ele assina somente os agendados
            } else {
                //Assino ao view
                $this->view->banner_3 = $banner_3;
            }

            /*             * **********
             * BANNERS MENORES AGENDADOS 4
             * *********** */

            // Busca o cache
            $idCache8 = "banners_agendados_menor4";

            $banner_4 = Zend_Registry::get("cache")->load($idCache8);

            // Se nao existir o cache faz consulta
            if (!$banner_4) {

                //seleciono os banners menores
                $select_banner_4 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 92")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 1")
                        ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //salvo o resultado em uma variavel
                $banner_4 = $model_banner->fetchAll($select_banner_4)->toArray();

                // Salva o cache
                Zend_Registry::get("cache")->save($banner_4, $idCache8);
            }

            //conto quantos agendados existem
            $total_agendado_4 = count($banner_4);


            /*             * **********
             * BANNERS MENORES NORMAIS 4
             * *********** */

            // Busca o cache
            $idCache9 = "banners_normais_menor4";

            $banner_4_comun = Zend_Registry::get("cache")->load($idCache9);

            // Se nao existir o cache faz consulta
            if (!$banner_4_comun) {

                //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
                $select_normais_4 = $model_banner->select()
                        ->where("NR_SEQ_LOCAL_BARC = 92")
                        ->where("ST_BANNER_BARC = 'A'")
                        ->where("ST_AGENDAMENTO_BARC = 0")
                        ->order("DT_CADASTRO_BARC DESC")
                        ->limit(1);
                //agora armazeno os banners em uma variavel
                $banner_4_comun = $model_banner->fetchAll($select_normais_4)->toArray();
                // Salva o cache
                Zend_Registry::get("cache")->save($banner_4_comun, $idCache9);
            }

            /*             * **********
             * CONDICOES PARA JUNTAR OS BANNERS DESTA POSICAO
             * *********** */

            //agora verifico se tem menos de 3 banners agendados para poder entrar os não agendados
            if ($total_agendado_4 == 0) {
                //uno os arrays
                $banners_4 = array_merge($banner_4, $banner_4_comun);

                //assino ao view
                $this->view->banner_4 = $banners_4;
                //se tiver 3 ou mais ele assina somente os agendados
            } else {
                //Assino ao view
                $this->view->banner_4 = $banner_4;
            }
        }
    }

    public function inicioAction() {

        $this->view->title = "Camisetas de bandas de rock, filmes e series! - Reverbcity.com";
        $this->view->description = "Na Reverbcity você encontra diversas camisetas de bandas de rock, series, filmes e muito mais!";
        $this->view->keywords = "Reverbcity, camisetas de bandas, camisetas rock, camisetas personalizadas, camisetas indie";
        //Inicio o model de produtos
        //recebo o codigo da caregoria do produto
        $idcategoria = $this->_request->getParam("idcategoria");
        //assino ao view para poder colocar na rota
        $this->view->categoria_produto = $idcategoria;

        /*         * **********
         * Lista produtos
         * *********** */



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
                    'VL_PROMO_PRRC',
                    'TP_DESTAQUE_PRRC',
                    'DS_FRETEGRATIS_PRRC',
                    'NR_SEQ_TIPO_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))

                // Remover depois da black
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                ->joinInner("produtos_categoria", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array())
                ->joinInner('menu_site_has_produtos_categoria', 'menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC', array())
                ->joinInner('menu_site', 'menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu', array())

                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produtos ativos
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //os quais tipo de destaque seja diferente de destaque da home page
                ->where("TP_DESTAQUE_PRRC <> 6")
                // que possuem estoque
                ->where("NR_QTDE_ESRC > 0")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //se tiver selecionado uma categoria na pagina do produto faz um filtro
        if ($idcategoria != "") {
            $select_produtos->where("NR_SEQ_CATEGORIA_PRRC = $idcategoria");
        }
        //agrupo por codigo do produto
        $select_produtos->group("NR_SEQ_PRODUTO_PRRC")
                //ordeno pela ordem de ordenacao de produtos
                ->order(array(
                    // Remover comentarios depois da blackfriday
                    //"NR_ORDEM_HOME_PRRC ASC",
                    //"NR_ORDEM_TODOS_PRRC ASC"
                        //"DT_CADASTRO_PRRC DESC"
                        "VL_PROMO_PRRC DESC"
        ));

        $lista_produtos = $model_produtos->fetchAll($select_produtos)->toArray();

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($lista_produtos);
        //defino a quantidade de itens por pagina
        $paginator->setItemCountPerPage(12)
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
        $contador = new Reverb_Paginator($lista_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(12)
                //pega o numero da pagina
                ->setCurrentPageNumber($current_page)
                //defino quantas páginas iram aparecer por vez
                ->setPageRange(9)
                //assino a paginacao
                ->assign();
        //assino ao view
        $this->view->contadores = $contador;

        //faco a query para listar as ultimas fotos em baixo do form login
        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        /*         * **********
         * FOTOS DO ME LOGIN
         * *********** */

        // Busca o cache
        $idCache_me = "me_inicio";

        $lista = Zend_Registry::get("cache")->load($idCache_me);

        // Zend_Registry::get("cache")->remove($idCache_me);
        // Se nao existir o cache faz consulta
        if (!$lista) {

            //crio a query para selecionar os amigos
            $select_fotos = "select
                                                                        NR_SEQ_CADASTRO_CASO,
									DS_NOME_CASO,
									DS_EXT_CACH
								from
								    cadastros
								WHERE NR_SEQ_CADASTRO_CASO IN(2,4162,22652,29424)
								LIMIT 4";

            // Monta a query
            $query = $db->query($select_fotos);
            //crio uma lista de fotos
            $lista = $query->fetchAll();
            //assino os amigos ao view
            // Salva o cache
            Zend_Registry::get("cache")->save($lista, $idCache_me);
        }

        $this->view->fotosme = $lista;

        $hoje = date("Y-m-d H:i:s");
        //crio a query de listar o ultimo post

        /*         * **********
         * POST BLOG
         * *********** */

        // Busca o cache
        $idCache1 = "blog_inicio";

        $lista_blog = Zend_Registry::get("cache")->load($idCache1);

        // Se nao existir o cache faz consulta
        if (!$lista_blog) {
            //inicio o model do blog
            $model_blog = new Default_Model_Blog();
            //crio a query para listar a ultima query
            $select_post = $model_blog->select()
                    //digo que nao existe integridade entre as tabelas
                    ->setIntegrityCheck(false)
                    //escolho a tabela do select para o join
                    ->from('blog', array("NR_SEQ_BLOG_BLRC",
                        "DS_EXT_BLRC",
                        "DS_TITULO_BLRC",
                        "DT_PUBLICACAO_BLRC",
                        "DS_TEXTO_BLRC"))
                    //crio o inner join dos autores
                    ->joinLeft('colunistas', 'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC', array('DS_COLUNISTA_CORC'))
                    ->where("DT_PUBLICACAO_BLRC <= ?", $hoje)
                    ->order("DT_PUBLICACAO_BLRC DESC")
                    ->LIMIT(1);

            $lista_blog = $model_blog->fetchRow($select_post);

            // Salva o cache
            Zend_Registry::get("cache")->save($lista_blog, $idCache1);
        }

        //assino ao view
        $this->view->post = $lista_blog;

        /*         * **********
         * POST FORUM
         * *********** */

        // Busca o cache
        $idCache2 = "forum_inicio";

//        $lista_forum = Zend_Registry::get("cache")->load($idCache2);
        // Se nao existir o cache faz consulta
        if (!$lista_forum) {

            //inicio o model do forum
            $model_topico = new Default_Model_Topicos();
            //inicio a query
            $select_topicos = $model_topico->select()
                    //seleciono somente os ativos
                    ->where("ST_TOPICO_TOSO = 'A'")
                    ->order("DT_CADASTRO_TOSO DESC")
                    ->LIMIT(20);

            $lista_forum = $model_topico->fetchAll($select_topicos);

            // Salva o cache
//            Zend_Registry::get("cache")->save($lista_forum, $idCache2);
        }


        //assino ao view
        $this->view->foruns = $lista_forum;

        /*         * **********
         * BANNER LATERAL
         * *********** */

        // Busca o cache
        $idCache3 = "banner_lateral";

        $lista_banner = Zend_Registry::get("cache")->load($idCache3);

        // Se nao existir o cache faz consulta
        if (!$lista_banner) {

            //inicio o model de banners
            $model_banner = new Default_Model_Banners();
            //crio o dia e hora atual
            $dia_hora = date("Y-m-d H:i:s");
            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_banner = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 67")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->order("DT_CADASTRO_BARC DESC");

            $lista_banner = $model_banner->fetchAll($select_banner);
            // Salva o cache
            Zend_Registry::get("cache")->save($lista_banner, $idCache3);
        }

        //Assino ao view
        $this->view->banners = $lista_banner;

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_banner_topo = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->order("DT_CADASTRO_BARC DESC");
        //Assino ao view
        $this->view->banners_topo = $model_banner->fetchAll($select_banner_topo);

        /*         * **********
         * PRODUTO DESTAQUE
         * *********** */

        // Busca o cache
        $idCache4 = "produto_destaque";

        $lista_destaque = Zend_Registry::get("cache")->load($idCache4);

        // Se nao existir o cache faz consulta
        if (!$lista_destaque) {
            //agora crio a query para pegar o ultimo destaque

            $select_destaque = $model_produtos->select()
                    //digo que nao existe integridade entre as tabelas
                    ->setIntegrityCheck(false)
                    //escolho a tabela do select para o join
                    ->from('produtos', array('NR_SEQ_PRODUTO_PRRC',
                        'VL_PRODUTO_PRRC',
                        'DS_PRODUTO_PRRC',
                        'DS_EXT_PRRC',
                        'TP_DESTAQUE_PRRC',
                        'DS_FRETEGRATIS_PRRC',
                        'VL_PROMO_PRRC',
                        'TP_DESTAQUE_PRRC',
                        'DT_CADASTRO_PRRC',
                        'NR_SEQ_TIPO_PRRC'))
                    ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))

                    //coloco as condições pertence so a loja
                    ->where("NR_SEQ_LOJAS_PRRC = 1")
                    //nao e classic
                    ->where("DS_CLASSIC_PRRC = 'N'")
                    //produtos ativos
                    ->where("ST_PRODUTOS_PRRC = 'A'")
                    // que possuem estoque
                    ->where("NR_QTDE_ESRC > 0")
                    //destaque
                    ->where("TP_DESTAQUE_PRRC = 6")
                    //agrupo por codigo do produto
                    ->group("NR_SEQ_PRODUTO_PRRC")
                    //ordeno pela ordem de ordenacao de produtos
                    ->order('DT_CADASTRO_PRRC DESC')
                    //limito somente em 1
                    ->limit(1);

            $lista_destaque = $model_produtos->fetchRow($select_destaque);

            // Salva o cache
            Zend_Registry::get("cache")->save($lista_destaque, $idCache4);
        }

        $this->view->destaque = $lista_destaque;

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();

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
        $banners = array_merge($agendados, $normais);

        //Assino ao view
        $this->view->banners = $banners;

        $this->view->headScript()->appendFile('//static.criteo.net/js/ld/ld.js');
        $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/criteo.js');
        $whatDevice = $this->_helper->navegacao->whatDevice();
        $userEmail = $this->_helper->usuario->getEmail();
        $strScript = $this->_helper->criteo->getCriteoHome($whatDevice, $userEmail);
        $this->view->headScript()->appendScript($strScript);
    }

    public function inicio2Action() {

        $this->view->title = "Vista-se de Música com a Reverbcity.com";
        $this->view->description = "Camisetas de bandas, filmes, séries, além canecas, posters e muito mais!";
        $this->view->keywords = "Reverbcity, camisetas de bandas, camisetas rock, camisetas personalizadas, camisetas indie";
        //Inicio o model de produtos
        //recebo o codigo da caregoria do produto
        $idcategoria = $this->_request->getParam("idcategoria");
        //assino ao view para poder colocar na rota
        $this->view->categoria_produto = $idcategoria;

        /*         * **********
         * Lista produtos
         * *********** */



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
                    'VL_PROMO_PRRC',
                    'TP_DESTAQUE_PRRC',
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))

                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produtos ativos
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //os quais tipo de destaque seja diferente de destaque da home page
                ->where("TP_DESTAQUE_PRRC <> 6")
                // que possuem estoque
                ->where("NR_QTDE_ESRC > 0")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //se tiver selecionado uma categoria na pagina do produto faz um filtro
        if ($idcategoria != "") {
            $select_produtos->where("NR_SEQ_CATEGORIA_PRRC = $idcategoria");
        }
        //agrupo por codigo do produto
        $select_produtos->group("NR_SEQ_PRODUTO_PRRC")
                //ordeno pela ordem de ordenacao de produtos
                ->order(array(
                    "NR_ORDEM_HOME_PRRC DESC",
                    "DT_CADASTRO_PRRC DESC"
        ));

        $lista_produtos = $model_produtos->fetchAll($select_produtos)->toArray();




        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($lista_produtos);
        //defino a quantidade de itens por pagina
        $paginator->setItemCountPerPage(12)
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
        $contador = new Reverb_Paginator($lista_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(12)
                //pega o numero da pagina
                ->setCurrentPageNumber($current_page)
                //defino quantas páginas iram aparecer por vez
                ->setPageRange(9)
                //assino a paginacao
                ->assign();
        //assino ao view
        $this->view->contadores = $contador;

        //faco a query para listar as ultimas fotos em baixo do form login
        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        /*         * **********
         * FOTOS DO ME LOGIN
         * *********** */

        // Busca o cache
        $idCache_me = "me_inicio";

        $lista = Zend_Registry::get("cache")->load($idCache_me);

        // Zend_Registry::get("cache")->remove($idCache_me);
        // Se nao existir o cache faz consulta
        if (!$lista) {

            //crio a query para selecionar os amigos
            $select_fotos = "select
                                                                        NR_SEQ_CADASTRO_CASO,
									DS_NOME_CASO,
									DS_EXT_CACH
								from
								    cadastros
								WHERE NR_SEQ_CADASTRO_CASO IN(2,4162,22652,29424)
								LIMIT 4";

            // Monta a query
            $query = $db->query($select_fotos);
            //crio uma lista de fotos
            $lista = $query->fetchAll();
            //assino os amigos ao view
            // Salva o cache
            Zend_Registry::get("cache")->save($lista, $idCache_me);
        }

        $this->view->fotosme = $lista;

        $hoje = date("Y-m-d H:i:s");
        //crio a query de listar o ultimo post

        /*         * **********
         * POST BLOG
         * *********** */

        // Busca o cache
        $idCache1 = "blog_inicio";

        $lista_blog = Zend_Registry::get("cache")->load($idCache1);

        // Se nao existir o cache faz consulta
        if (!$lista_blog) {
            //inicio o model do blog
            $model_blog = new Default_Model_Blog();
            //crio a query para listar a ultima query
            $select_post = $model_blog->select()
                    //digo que nao existe integridade entre as tabelas
                    ->setIntegrityCheck(false)
                    //escolho a tabela do select para o join
                    ->from('blog', array("NR_SEQ_BLOG_BLRC",
                        "DS_EXT_BLRC",
                        "DS_TITULO_BLRC",
                        "DT_PUBLICACAO_BLRC",
                        "DS_TEXTO_BLRC"))
                    //crio o inner join dos autores
                    ->joinLeft('colunistas', 'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC', array('DS_COLUNISTA_CORC'))
                    ->where("DT_PUBLICACAO_BLRC <= ?", $hoje)
                    ->order("DT_PUBLICACAO_BLRC DESC")
                    ->LIMIT(1);

            $lista_blog = $model_blog->fetchRow($select_post);

            // Salva o cache
            Zend_Registry::get("cache")->save($lista_blog, $idCache1);
        }

        //assino ao view
        $this->view->post = $lista_blog;

        /*         * **********
         * POST FORUM
         * *********** */

        // Busca o cache
        $idCache2 = "forum_inicio";

        $lista_forum = Zend_Registry::get("cache")->load($idCache2);

        // Se nao existir o cache faz consulta
        if (!$lista_forum) {

            //inicio o model do forum
            $model_topico = new Default_Model_Topicos();
            //inicio a query
            $select_topicos = $model_topico->select()
                    //seleciono somente os ativos
                    ->where("ST_TOPICO_TOSO = 'A'")
                    ->order("DT_CADASTRO_TOSO DESC")
                    ->LIMIT(7);

            $lista_forum = $model_topico->fetchAll($select_topicos);

            // Salva o cache
            Zend_Registry::get("cache")->save($lista_forum, $idCache2);
        }


        //assino ao view
        $this->view->foruns = $lista_forum;

        /*         * **********
         * BANNER LATERAL
         * *********** */

        // Busca o cache
        $idCache3 = "banner_lateral";

        $lista_banner = Zend_Registry::get("cache")->load($idCache3);

        // Se nao existir o cache faz consulta
        if (!$lista_banner) {

            //inicio o model de banners
            $model_banner = new Default_Model_Banners();
            //crio o dia e hora atual
            $dia_hora = date("Y-m-d H:i:s");
            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_banner = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 67")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->order("DT_CADASTRO_BARC DESC");

            $lista_banner = $model_banner->fetchAll($select_banner);
            // Salva o cache
            Zend_Registry::get("cache")->save($lista_banner, $idCache3);
        }

        //Assino ao view
        $this->view->banners = $lista_banner;

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_banner_topo = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->order("DT_CADASTRO_BARC DESC");
        //Assino ao view
        $this->view->banners_topo = $model_banner->fetchAll($select_banner_topo);

        /*         * **********
         * PRODUTO DESTAQUE
         * *********** */

        // Busca o cache
        $idCache4 = "produto_destaque";

        $lista_destaque = Zend_Registry::get("cache")->load($idCache4);

        // Se nao existir o cache faz consulta
        if (!$lista_destaque) {
            //agora crio a query para pegar o ultimo destaque

            $select_destaque = $model_produtos->select()
                    //digo que nao existe integridade entre as tabelas
                    ->setIntegrityCheck(false)
                    //escolho a tabela do select para o join
                    ->from('produtos', array('NR_SEQ_PRODUTO_PRRC',
                        'VL_PRODUTO_PRRC',
                        'DS_PRODUTO_PRRC',
                        'DS_EXT_PRRC',
                        'TP_DESTAQUE_PRRC',
                        'DS_FRETEGRATIS_PRRC',
                        'VL_PROMO_PRRC',
                        'TP_DESTAQUE_PRRC',
                        'DT_CADASTRO_PRRC'))
                    ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))

                    //coloco as condições pertence so a loja
                    ->where("NR_SEQ_LOJAS_PRRC = 1")
                    //nao e classic
                    ->where("DS_CLASSIC_PRRC = 'N'")
                    //produtos ativos
                    ->where("ST_PRODUTOS_PRRC = 'A'")
                    // que possuem estoque
                    ->where("NR_QTDE_ESRC > 0")
                    //destaque
                    ->where("TP_DESTAQUE_PRRC = 6")
                    //agrupo por codigo do produto
                    ->group("NR_SEQ_PRODUTO_PRRC")
                    //ordeno pela ordem de ordenacao de produtos
                    ->order('DT_CADASTRO_PRRC DESC')
                    //limito somente em 1
                    ->limit(1);

            $lista_destaque = $model_produtos->fetchRow($select_destaque);

            // Salva o cache
            Zend_Registry::get("cache")->save($lista_destaque, $idCache4);
        }

        $this->view->destaque = $lista_destaque;

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();

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
        $banners = array_merge($agendados, $normais);

        //Assino ao view
        $this->view->banners = $banners;
    }

    /** Acao responsavel em disparar emails para contato
     */
    public function contatoAction() {

        $this->view->title = "Contato - Reverbcity.com";
        $this->view->description = "Saiba como entrar em contato com nosso atendimento";
        $this->view->keywords = "Reverbcity, Londrina, São Paulo, contato, atendimento";
        // Cria a sessão das mensagens
        $messages = new Zend_Session_Namespace("messages");
        //crio a sessao de usuarios
        $usuarios = new Zend_Session_Namespace("usuarios");

        //verifico se é uma requisicao de post para realizar o contato
        if ($this->_request->isPost()) {
            //verifico o captcha
            if (isset($_POST['captcha'])) {
                $captcha = new Zend_Captcha_Image();
                if ($captcha->isValid($_POST['captcha'], $_POST)) {
                    echo "Success";
                } else {
                    //captcha invalid.. redisplay..
                    $session->sent = time();
                    $messages->error = "Captcha digitado errado, tente novamente!";
                    $this->_helper->redirector("contato", "index", "default");
                    echo "Failed";
                }
            }

            //inicio o model da tabela de contatos
            $model = new Default_Model_Contato();

            //crio um array com os campos do formulario
            $data = array('nome' => $this->_request->getParam('nome'),
                'email' => $this->_request->getParam('email'),
                'cidade' => $this->_request->getParam('cidade'),
                'mensagem' => $this->_request->getParam('content-message'),
                'ip' => $_SERVER["REMOTE_ADDR"]);

            //insiro os registros no banco de dados
            $model->insert($data);

            //crio a mensagem
            $mensagem = "<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
								CONFIRMAÇÃO DE CONTATO
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
									Olá, <b>" . $data["nome"] . ",</b></br></br>

									Obrigado por entrar em contato com a Reverbcity, acabamos de receber sua mensagem e vamos responde-la o mais rápido possível!.</br>

									Obrigado!</br>

								</td>
							</tr>";

            //crio a mensagem para o adm
            $mensagem2 = "<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
								CONFIRMAÇÃO DE CONTATO
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
									O usuário, <b>" . $data["nome"] . "</b> Entrou em contato pelo site.</br></br>

									Dados informados pelo usuário:</br>
									<b> Nome : </b> " . $data["nome"] . " </br>
									<b> E-mail : </b> " . $data["email"] . " </br>
									<b> Cidade : </b> " . $data["cidade"] . " </br>
									<b> Mensagem : </b> " . $data["mensagem"] . " </br>

								</td>
							</tr>";

            // Busca o conteudo do topo e do rodape
            $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_padrao.html");

            $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_padrao.html");
            //crio o corpo á ser enviado para o cliente
            $body .= $topo;
            $body .= $mensagem;
            $body .= $rodape;

            //crio o corpo á ser enviado para o adm
            $body2 .= $topo;
            $body2 .= $mensagem2;
            $body2 .= $rodape;


            $config = array(
                'auth' => 'login',
                'username' => "vendas@reverbcity.com",
                'password' => "vendas@reverb144",
                'ssl' => "tls", # default ("ssl")
                'port' => "587" # default ("25")
            );
            $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

            $emailAdm = "atendimento@reverbcity.com";
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($body);
            $mail->addTo($data['email'], "Reverbcity - A Música que veste");
            $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
            $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
            $mail->setSubject("Confirmação do contato");
            $mail->send($mailTransport);


            $mail2 = new Zend_Mail('UTF-8');
            $mail2->setBodyHtml($body2);
            $mail2->addTo($emailAdm, "Reverbcity - A Música que veste");
            $mail2->setReplyTo($data["email"], $data["nome"]);
            $mail2->setFrom($emailAdm, "Reverbcity - A Música que veste");
            $mail2->setReturnPath($data['email']); #muito importante na locaweb, informar um email válido do seu dominio
            $mail2->setSubject("Contato através do site");
            $mail2->send($mailTransport);

            // Envio um feedback de sucesso ao usuário.
            $messages->success = "A sua mensagem foi enviada com sucesso!";
            //redireciono para a última página visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio o dia e hora atual
        $dia_hora = date("Y-m-d H:i:s");
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_agendado = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 1")
                ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $agendados = $model_banner->fetchAll($select_agendado)->toArray();

        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_normais = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 0")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $normais = $model_banner->fetchAll($select_normais)->toArray();
        //junto os 2 tipos de banners em um só array
        $banners = array_merge($agendados, $normais);

        //Assino ao view
        $this->view->banners = $banners;



        $this->view->nome = $usuarios->nome;
        $this->view->email = $usuarios->email;
        $this->view->cidade = $usuarios->cidade;
        $this->view->uf = $usuarios->uf;
    }

    /**
     *
     */
    public function quemsomosAction() {

        $this->view->title = "Quem Somos - Reverbcity.com";
        $this->view->description = "Saiba quem são as pessoas que fazem a Reverbcity";
        $this->view->keywords = "Reverbcity, sobre, quem somos, equipe, time";
        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio o dia e hora atual
        $dia_hora = date("Y-m-d H:i:s");
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_agendado = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 1")
                ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $agendados = $model_banner->fetchAll($select_agendado)->toArray();

        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_normais = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 0")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $normais = $model_banner->fetchAll($select_normais)->toArray();
        //junto os 2 tipos de banners em um só array
        $banners = array_merge($agendados, $normais);

        //Assino ao view
        $this->view->banners = $banners;
    }

    /**
     * ~Fução responsável por listar imprensa
     */
    public function imprensaAction() {

        $this->view->title = "Imprensa - Reverbcity.com";
        $this->view->description = "Saiba o que andam falando sobre a Reverbcity";
        $this->view->keywords = "Reverbcity, imprensa, clipping, jornal, revista";

        //inicio o model de imprensa
        $model = new Default_Model_Imprensa();

        $select = $model->select()
                ->order("data_post DESC");

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($select);
        //defino a quantidade de itens por pagina
        $paginator->setItemCountPerPage(4)
                //defino a quantidade de paginas
                ->setPageRange(3)
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
        //passo para o paginador o select de imprensa
        $contador = new Reverb_Paginator($select);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(4)
                //pega o numero da pagina
                ->setCurrentPageNumber($current_page)
                //defino quantas páginas iram aparecer por vez
                ->setPageRange(3)
                //assino a paginacao
                ->assign();
        //assino ao view
        $this->view->contadores = $contador;



        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio o dia e hora atual
        $dia_hora = date("Y-m-d H:i:s");
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_agendado = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 1")
                ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $agendados = $model_banner->fetchAll($select_agendado)->toArray();

        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_normais = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 0")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $normais = $model_banner->fetchAll($select_normais)->toArray();
        //junto os 2 tipos de banners em um só array
        $banners = array_merge($agendados, $normais);

        //Assino ao view
        $this->view->banners = $banners;


        //se for post significa que esta fazendo uma busca
        if ($this->_request->isPost()) {
            //recebo o parametro da busca
            $palavra = $this->_request->getParam("search-text");
            $palavra_data = $this->_request->getParam("search-date");

            $palavra_explode = explode("/", $palavra_data);

            if ($palavra_explode [0] != "" and $palavra_explode[1] != "" and $palavra_explode [2] != "") {
                $data_pesquisa = $palavra_explode[2] . "-" . $palavra_explode[1] . "-" . $palavra_explode[0];
            }
            // defino o adaptador do banco
            $db = Zend_Registry::get("db");
            //crio a query de busca
            $select_imprensa = $db->select()
                    ->union(array(
                "SELECT i.idimprensa as idimprensa, i.data_post as data_post, i.titulo 	as titulo, i.imagem_path as imagem_path, i.post as post FROM imprensa i WHERE i.data_post LIKE " . $db->quote("%" . $data_pesquisa . "%") . "OR  i.titulo LIKE " . $db->quote("%" . $palavra . "%") . "",
            ));

            // Monta a query
            $query = $db->query($select_imprensa);
            //crio uma lista de fotos
            //assino os amigos ao view
            $this->view->contadores = $lista;
        }
    }

    /**
     *
     */
    public function buscaAction() {

        if ($this->_request->isPost()) {
            $palavra = $this->_request->getParam("busca_topo");
            $this->_redirect("/busca/{$palavra}");
        }

        $palavra = $this->_request->getParam("search");

        $this->view->title = ucfirst($palavra) . " - Reverbcity.com";
        $this->view->description = "Você já vestiu de música? Se as pessoas passam boa parte da vida escutando música, por que não carregar toda essa paixão em suas camisetas também? É assim que funciona a Reverbcity.";
        $this->view->keywords = "Reverbcity, busca, camisetas, indie, rock";

        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");

        //verifico se existe algo na busca
        if ($palavra != "") {
            // defino o adaptador do banco
            $db = Zend_Registry::get("db");
            $model_buscas = new Default_Model_Buscas();

            $palavra = str_replace(' ', '%', $palavra);

            $select_palavra = "SELECT idbusca, quantidade from buscas WHERE palavra_buscada LIKE " . $db->quote("%" . $palavra . "%") . " ORDER BY quantidade DESC limit 1";

            //crio uma lista com o resultado de sementes
            $palavra_buscada = $db->fetchAll($select_palavra);

            $quantidade = $palavra_buscada[0]['quantidade'] + 1;

            $data_palavra = array("quantidade" => $quantidade,
                "data_busca" => date("Y-m-d H:i:s"));

            $model_buscas->update($data_palavra, array("idbusca = ?" => $palavra_buscada[0]['idbusca']));

            $select = $db->select()
                    ->union(array(
                "SELECT p.NR_SEQ_PRODUTO_PRRC 		as id, p.DS_PRODUTO_PRRC 	as titulo, 1 as tipo, p.DS_EXT_PRRC 		as extencao,	p.DT_CADASTRO_PRRC 		as	data_cadastro, 	p.VL_PRODUTO_PRRC 	as valor, p.VL_PROMO_PRRC 		as extra,	p.NR_SEQ_TIPO_PRRC AS NR_SEQ_TIPO_PRRC FROM produtos p 	WHERE (p.DS_PRODUTO_PRRC  LIKE " . $db->quote("%" . $palavra . "%") . " OR (SELECT group_concat(produto_tag SEPARATOR ' ') FROM produtos_tags where produtos_tags.idproduto = p.NR_SEQ_PRODUTO_PRRC) LIKE " . $db->quote("%" . $palavra . "%") . " ) AND DS_CLASSIC_PRRC = 'N' AND NR_SEQ_TIPO_PRRC not in(4) AND NR_SEQ_LOJAS_PRRC = 1 AND ST_PRODUTOS_PRRC = 'A'",
                "SELECT c.NR_SEQ_REVERBCYCLE_RCRC 	as id, c.DS_OBJETO_RCRC 	as titulo, 2 as tipo, c.DS_EXT_RCRC 		as extensao, 	c.DT_CADASTRO_RCRC 		as	data_cadastro,	c.NR_VALOR_RCRC 	as valor, c.ST_CYCLE_RCRC 		as extra,	0 AS NR_SEQ_TIPO_PRRC FROM reverbcycle c 	            WHERE c.DS_OBJETO_RCRC 	 LIKE " . $db->quote("%" . $palavra . "%") . "",
                "SELECT b.NR_SEQ_BLOG_BLRC 			as id, b.DS_TITULO_BLRC 	as titulo, 4 as tipo, b.DS_EXT_BLRC 		as extensao, 	b.DT_PUBLICACAO_BLRC 	as 	data_cadastro,  b.DS_TEXTO_BLRC 	as valor, b.DT_CADASTRO_BLRC 	as extra,	0 AS NR_SEQ_TIPO_PRRC  FROM blog b 		                WHERE b.DS_TITULO_BLRC 	 LIKE " . $db->quote("%" . $palavra . "%") . "",
                "SELECT t.NR_SEQ_TOPICO_TOSO 		as id, t.DS_TOPICO_TOSO 	as titulo, 5 as tipo, t.ST_TOPICO_TOSO 		as status, 		t.DT_CADASTRO_TOSO 		as 	data_cadastro,	t.NR_MSGS_TOSO 		as valor, t.DT_ULTIMOPOST_TOSO 	as extra,	0 AS NR_SEQ_TIPO_PRRC FROM topicos t 		            WHERE t.DS_TOPICO_TOSO 	 LIKE " . $db->quote("%" . $palavra . "%") . "",
                "SELECT cl.NR_SEQ_PRODUTO_PRRC 		as id, cl.DS_PRODUTO_PRRC 	as titulo, 6 as tipo, cl.DS_EXT_PRRC 		as extencao,	cl.DT_CADASTRO_PRRC 	as	data_cadastro, 	cl.VL_PRODUTO_PRRC 	as valor, cl.VL_PROMO_PRRC 		as extra,	0 AS NR_SEQ_TIPO_PRRC FROM produtos cl 	                WHERE cl.DS_PRODUTO_PRRC LIKE " . $db->quote("%" . $palavra . "%") . "AND DS_CLASSIC_PRRC = 'S' AND DS_CLASSIC_PRRC = 'S' AND NR_SEQ_LOJAS_PRRC = 1 AND ST_PRODUTOS_PRRC = 'A' ",
            ));


            //crio uma lista com o resultado de sementes
            $lista_produto = $db->fetchAll($select);
            //quantidade de resultados
            $this->view->qtd_resultados = count($lista_produto);
            //assino ao view o resultado
            $this->view->resultados = $lista_produto;
            //crio os 5 arrays
            $arr1 = array();
            $arr2 = array();
            $arr3 = array();
            $arr4 = array();
            $arr5 = array();
            $arr6 = array();
            //para cada lista de produto
            foreach ($lista_produto as $key => $value) {
                //se for tipo 1 = produto atribuo o valor ao array
                if ($value['tipo'] === '1') {
                    array_push($arr1, $value);
                }
                //se for tipo 2 = cycle atribuo o valor ao array
                else if ($value['tipo'] === '2') {
                    array_push($arr2, $value);
                }
                //se for tipo 3 = cadastros atribuo o valor ao array
                else if ($value['tipo'] === '3') {
                    array_push($arr3, $value);
                }
                //se for tipo 4 = blog atribuo o valor ao array
                else if ($value['tipo'] === '4') {
                    array_push($arr4, $value);
                }
                //se for tipo 5 = forum atribuo o valor ao array
                else if ($value['tipo'] === '5') {
                    array_push($arr5, $value);
                }
                //se for tipo 6 = forum atribuo o valor ao array
                else if ($value['tipo'] === '6') {
                    array_push($arr6, $value);
                }
            }
            //assino a variavel ao view
            $palavra = str_replace('%', ' ', $palavra);
            $this->view->palavra = $palavra;
            //assino os arrays criados ao view
            $this->view->arr1 = $arr1;
            $this->view->arr2 = $arr2;
            $this->view->arr3 = $arr3;
            $this->view->arr4 = $arr4;
            $this->view->arr5 = $arr5;
            $this->view->arr6 = $arr6;


            //inicio o model de banners
            $model_banner = new Default_Model_Banners();
            //crio o dia e hora atual
            $dia_hora = date("Y-m-d H:i:s");
            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_agendado = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 87")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->where("ST_AGENDAMENTO_BARC = 1")
                    ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                    ->order("DT_CADASTRO_BARC DESC");

            //armazeno em uma variavel
            $agendados = $model_banner->fetchAll($select_agendado)->toArray();

            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_normais = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 87")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->where("ST_AGENDAMENTO_BARC = 0")
                    ->order("DT_CADASTRO_BARC DESC");

            //armazeno em uma variavel
            $normais = $model_banner->fetchAll($select_normais)->toArray();
            //junto os 2 tipos de banners em um só array
            $banners = array_merge($agendados, $normais);

            //Assino ao view
            $this->view->banners = $banners;
        } else {
            $messages->error = "Informe uma palavra válida para a busca";
            //redireciono
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     *
     */
    public function ajudaAction() {

        $this->view->title = "Ajuda Reverbcity";
        $this->view->description = "Dificuldades? Estamos aqui para ajudar você!";
        $this->view->keywords = "Reverbcity, ajuda, camisetas, indie, rock";
        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");
        //crio a query para selecionar os amigos
        $select_fotos = "select
							NR_SEQ_FOTO_FORC,
							DS_NOME_FORC,
							DS_EXT_FORC,
							DT_CADASTRO_FORC
						from
						    me_fotos
						ORDER BY RAND()
						LIMIT 4";

        // Monta a query
        $query = $db->query($select_fotos);
        //crio uma lista de fotos
        $lista = $query->fetchAll();
        //assino os amigos ao view
        $this->view->fotos = $lista;

        $hoje = date("Y-m-d H:i:s");

        //crio a query de listar o ultimo post
        $model_blog = new Default_Model_Blog();
        //crio a query para listar a ultima query
        $select_post = $model_blog->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('blog', array("NR_SEQ_BLOG_BLRC",
                    "DS_EXT_BLRC",
                    "DS_TITULO_BLRC",
                    "DT_PUBLICACAO_BLRC",
                    "DS_TEXTO_BLRC"))
                //crio o inner join dos autores
                ->joinLeft('colunistas', 'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC', array('DS_COLUNISTA_CORC'))
                ->where("DT_PUBLICACAO_BLRC <= ?", $hoje)
                ->order("DT_PUBLICACAO_BLRC DESC")
                ->LIMIT(1);

        //assino ao view
        $this->view->post = $model_blog->fetchRow($select_post);


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

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();

        //crio o dia e hora atual
        $dia_hora = date("Y-m-d H:i:s");

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
        $banners = array_merge($agendados, $normais);

        //Assino ao view
        $this->view->banners = $banners;

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_banner_topo = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->order("DT_CADASTRO_BARC DESC");
        //Assino ao view
        $this->view->banners_topo = $model_banner->fetchAll($select_banner_topo);
    }

    /**
     *
     */
    public function politicaprivacidadeAction() {

        $this->view->title = "Politica de privacidade da Reverbcity";
        $this->view->description = "Aqui você encontra as politicas da Reverbcity";
        $this->view->keywords = "Reverbcity, politica de privacidade, camisetas, indie, rock";

        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");
        //crio a query para selecionar os amigos
        $select_fotos = "select
							NR_SEQ_FOTO_FORC,
							DS_NOME_FORC,
							DS_EXT_FORC,
							DT_CADASTRO_FORC
						from
						    me_fotos
						ORDER BY RAND()
						LIMIT 4";

        // Monta a query
        $query = $db->query($select_fotos);
        //crio uma lista de fotos
        $lista = $query->fetchAll();
        //assino os amigos ao view
        $this->view->fotos = $lista;

        //crio a query de listar o ultimo post
        //inicio o model do blog
        $model_blog = new Default_Model_Blog();
        //crio a query para listar a ultima query
        $select_post = $model_blog->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('blog')
                //crio o inner join dos autores
                ->joinInner('colunistas', 'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC', array('DS_COLUNISTA_CORC'))
                //somente os com estatus A = Aprovado
                ->where("blog.DS_STATUS_BLRC LIKE '%A%'")
                ->order("RAND()")
                ->LIMIT(1);

        //assino ao view
        $this->view->post = $model_blog->fetchRow($select_post);


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
        $this->view->banners_topo = $banners_topo;


        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_agendado = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 88")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 1")
                ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $agendados = $model_banner->fetchAll($select_agendado)->toArray();

        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_normais = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 88")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 0")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $normais = $model_banner->fetchAll($select_normais)->toArray();
        //junto os 2 tipos de banners em um só array
        $banners = array_merge($agendadoso, $normais);

        //Assino ao view
        $this->view->banners = $banners;
    }

    /**
     *
     */
    public function termosusoAction() {

        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");
        //crio a query para selecionar os amigos
        $select_fotos = "select
							NR_SEQ_FOTO_FORC,
							DS_NOME_FORC,
							DS_EXT_FORC,
							DT_CADASTRO_FORC
						from
						    me_fotos
						ORDER BY RAND()
						LIMIT 4";

        // Monta a query
        $query = $db->query($select_fotos);
        //crio uma lista de fotos
        $lista = $query->fetchAll();
        //assino os amigos ao view
        $this->view->fotos = $lista;

        //crio a query de listar o ultimo post
        //inicio o model do blog
        $model_blog = new Default_Model_Blog();
        //crio a query para listar a ultima query
        $select_post = $model_blog->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('blog')
                //crio o inner join dos autores
                ->joinInner('colunistas', 'blog.NR_SEQ_COLUNISTA_BLRC = colunistas.NR_SEQ_COLUNISTA_CORC', array('DS_COLUNISTA_CORC'))
                //somente os com estatus A = Aprovado
                ->where("blog.DS_STATUS_BLRC LIKE '%A%'")
                ->order("RAND()")
                ->LIMIT(1);

        //assino ao view
        $this->view->post = $model_blog->fetchRow($select_post);


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
        $this->view->banners_topo = $banners_topo;


        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_agendado = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 88")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 1")
                ->where("'$dia_hora' BETWEEN DT_INICIO_BARC AND DT_FIM_BARC")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $agendados = $model_banner->fetchAll($select_agendado)->toArray();

        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_normais = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 88")
                ->where("ST_BANNER_BARC = 'A'")
                ->where("ST_AGENDAMENTO_BARC = 0")
                ->order("DT_CADASTRO_BARC DESC");

        //armazeno em uma variavel
        $normais = $model_banner->fetchAll($select_normais)->toArray();
        //junto os 2 tipos de banners em um só array
        $banners = array_merge($agendadoso, $normais);

        //Assino ao view
        $this->view->banners = $banners;
    }

    /**
     * Ação de assinatura de news
     */
    public function assinanewsAction() {
        //inicio o model de assinantes
        $model = new Default_Model_Assinantes();
        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");
        //se for post
        if ($this->_request->isPost()) {
            //recebo o email informado
            $email = $this->_request->getParam("newsletter-email");
            //agora verifico se o usuario ja e cadastrou
            $select = $model->select()->where("DS_EMAIL_NLRC = ?", $email);


            //armazendo o resultado
            $jacadastrou = $model->fetchRow($select);

            //agora vejo se ja tem cadastro
            if ($jacadastrou > 0) {
                $session->error = "Você já possuí um cadastro no nosso site!";
                //redireciono
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
            //crio o array
            $data = array('DS_EMAIL_NLRC' => $email,
                'DT_CADASTRO_NLRC' => date('Y-m-d'));

            // Insere o registro
            try {
                $model->insert($data);
                // Envio um feedback de sucesso ao usuário.
                $session->success = "O cadastro foi realizado com sucesso!";
            } catch (Exception $e) {
                // Envio um feedback de sucesso ao usuário.
                $session->error = "Houve um problema com seu cadastro, tente novamente mais tarde ou entre em contato conosco!";
            }
        }

        //redireciono
        $this->_redirect($_SERVER['HTTP_REFERER']);
    }

    //função responsavel por enviar e-mail de compras internacionais
    public function internationalAction() {

        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");

        //verifico se é uma requisicao de post para realizar o contato
        if ($this->_request->isPost()) {

            //verifico o captcha
//            if (isset($_POST['captcha'])) {
//                $captcha = new Zend_Captcha_Image();
//                if ($captcha->isValid($_POST['captcha'], $_POST)) {
//                    echo "Success";
//                } else {
//                    //captcha invalid.. redisplay..
//                    $session->sent = time();
//                    $messages->error = "Captcha digitado errado, tente novamente!";
//                    $this->_redirect($_SERVER['HTTP_REFERER']);
//                    echo "Failed";
//                }
//            }
            //inicio o model da tabela de contatos
            $model = new Default_Model_Contato();

            //crio um array com os campos do formulario
            $data = array('nome' => $this->_request->getParam('name-ip'),
                'email' => $this->_request->getParam('email-ip'),
                'cidade' => $this->_request->getParam('city-ip'),
                'pais' => $this->_request->getParam('country-ip'),
                'mensagem' => $this->_request->getParam('message-ip'),
                'ip' => $_SERVER["REMOTE_ADDR"]);

            //insiro os registros no banco de dados
            $model->insert($data);

            //crio a mensagem
            $mensagem = "<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
								INTERNATIONAL PURCHASE
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
									Hello, <b>" . $data["nome"] . ",</b></br></br>

									Thank you for contact us, we just received your message, we will anser you as soon as possible!.</br>

									Thanks!</br>

								</td>
							</tr>";

            //crio a mensagem para o adm
            $mensagem2 = "<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
								INTERNATIONAL PURCHASE
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
									O usuário, <b>" . $data["nome"] . "</b>Entrou em contato pelo site <b>(international purchase)</b></br></br>

									Dados informados pelo usuário:</br>
									<b> Nome : </b> " . $data["nome"] . " </br>
									<b> E-mail : </b> " . $data["email"] . " </br>
									<b> Cidade : </b> " . $data["cidade"] . " </br>
									<b> País : </b> " . $data["pais"] . " </br>
									<b> Mensagem : </b> " . $data["mensagem"] . " </br>

								</td>
							</tr>";

            // Busca o conteudo do topo e do rodape
            $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_padrao.html");

            $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_padrao.html");
            //crio o corpo á ser enviado para o cliente
            $body .= $topo;
            $body .= $mensagem;
            $body .= $rodape;

            //crio o corpo á ser enviado para o adm
            $body2 .= $topo;
            $body2 .= $mensagem2;
            $body2 .= $rodape;

            $config = array(
                'auth' => 'login',
                'username' => "vendas@reverbcity.com",
                'password' => "vendas@reverb144",
                'ssl' => "tls", # default ("ssl")
                'port' => "587" # default ("25")
            );
            $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

            $emailAdm = "contato@reverbcity.com";
            $emailatendimento = "atendimento@reverbcity.com";
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($body, 'UTF-8');
            $mail->addTo($data['email'], "Reverbcity - A Música que veste");
            $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
            $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
            $mail->setSubject("Reverbcity - Contact");
            $mail->send($mailTransport);

            $mail2 = new Zend_Mail('UTF-8');
            $mail2->setBodyHtml($body2, 'UTF-8');
            $mail2->addTo($emailAdm, "Reverbcity - A Música que veste");
            $mail2->addBcc($emailatendimento, "Reverbcity - A Música que veste");
            $mail2->setFrom($emailAdm, "Reverbcity - A Música que veste");
            $mail2->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
            $mail2->setSubject("Compra internacional");
            $mail2->send($mailTransport);

            // Envio um feedback de sucesso ao usuário.
            $session->success = "Your message has been successfully sent";
            //redireciono para a última página visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     * Login com twitter
     */

    public function logintwitterAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //incluo o que e necessario
        require ($_SERVER['DOCUMENT_ROOT'] . "/library/Reverb/Twitter/Twitteroauth.php");
        require ($_SERVER['DOCUMENT_ROOT'] . "/library/Reverb/Twitter/Configtwitter.php");
        //inicio a sessao do login com twitter
        $login_twitter = new Zend_Session_Namespace("twitter");
        // Cria a sessão das mensagens
        $messages = new Zend_Session_Namespace("messages");

        //inicio o objeto

        $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);
        //pego a url
        $request_token = $twitteroauth->getRequestToken('http://reverbcity.com/index/gettwitterdata');

        $login_twitter->oauth_token = $request_token['oauth_token'];
        $login_twitter->oauth_token_secret = $request_token['oauth_token_secret'];

        // se tudo der certo
        if ($twitteroauth->http_code == 200) {
            // cria a url e redireciona
            $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);


            //redireciono
            $this->_redirect($url);
        } else {
            // It's a bad idea to kill the script, but we've got to know when there's an error.
            $messages->error = "Houve um problema ao logar, por favor tenta mais tarde";
        }
    }

    /*
     *
     * Responsavel por receber as informações do Twitter
     *
     */

    public function gettwitterdataAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //incluo o que e necessario
        require ($_SERVER['DOCUMENT_ROOT'] . "/library/Reverb/Twitter/Twitteroauth.php");
        require ($_SERVER['DOCUMENT_ROOT'] . "/library/Reverb/Twitter/Configtwitter.php");
        require ($_SERVER['DOCUMENT_ROOT'] . "/library/Reverb/Twitter/Verificausuario.php");
        //inicio a sessao do login com twitter
        $login_twitter = new Zend_Session_Namespace("twitter");
        // Cria a sessão das mensagens
        $messages = new Zend_Session_Namespace("messages");

        // Cria a sessão de usuário
        $usuarios = new Zend_Session_Namespace("usuarios");

        //verifico se os parametros vieram de forma correta
        if (!empty($_GET['oauth_verifier']) && !empty($login_twitter->oauth_token) && !empty($login_twitter->oauth_token_secret)) {
            // recebo o que eu preciso
            $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $login_twitter->oauth_token, $login_twitter->oauth_token_secret);
            // chave de acesso
            $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
            // salvo a chave na sessao
            $login_twitter->access_token = $access_token;
            // pego as informacoes do usuario
            $user_info = $twitteroauth->get('account/verify_credentials');

            if (isset($user_info->error)) {
                /// Envio um feedback de sucesso ao usuário.
                $messages->error = "Houve um problema com o login, tente novamente mais tarde.";
                //redireciono para a última página visitada
                $this->_redirect("/index/inicio");
            } else {
                $uid = $user_info->id;

                $username = $user_info->name;

                $user = new User();

                $userdata = $user->checkUser($uid, 'twitter', $username);




                if (!empty($userdata)) {

                    //inicio o model do me
                    $model_me = new Default_Model_Reverbme();

                    // Seta os dados do usuáario logado
                    $usuarios->idperfil = $userdata['NR_SEQ_CADASTRO_CASO'];
                    $usuarios->logado = TRUE;
                    $usuarios->nome = $userdata['DS_NOME_CASO'];
                    $usuarios->email = $userdata['DS_EMAIL_CASO'];
                    $usuarios->cidade = $userdata['DS_CIDADE_CASO'];
                    $usuarios->uf = $userdata['DS_UF_CASO'];
                    $usuarios->tipo = $userdata['DS_TIPO_CASO'];
                    $usuarios->cep = $userdata['DS_CEP_CASO'];
                    $usuarios->facebook = false;
                    $usuarios->twitter = true;
                    $usuarios->cadastro_completo = 0;



                    //passo data de acesso
                    $agora = date("Y-m-d H:i:s");

                    $data_acesso['DT_ACESSO_CASO'] = $agora;

                    $model_me->update($data_acesso, array("NR_SEQ_CADASTRO_CASO = ?" => $usuarios->idperfil));


                    // Envio um feedback de sucesso ao usuário.
                    $messages->success = "Seja bem vindo, Não esqueça de completar seu cadastro clicando em DADOS CADASTRAIS";
                    //redireciono para a última página visitada
                    $this->_redirect('/reverbme/novome');
                }
            }
        }
    }

    /**
     * Função responsavel por adicionar o produto ao wishlist
     * */
    public function adicionawishlistAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        $idproduto = $this->_request->getParam("produto");
        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");

        // Cria a sessão de usuário
        $usuarios = new Zend_Session_Namespace("usuarios");
        //verifico se existe usuário logado com sessao
        if ($usuarios->logado == TRUE) {
            //crio o array com o wishlist
            $data_wish = array("NR_SEQ_CADASTRO_WLRC" => $usuarios->idperfil,
                "NR_SEQ_PRODUTO_WLRC" => $idproduto);
            //crio o model
            $model_wishlist = new Default_Model_Wishlist();


            //tento inserir os dados
            try {
                $model_wishlist->insert($data_wish);
                // Envio um feedback de sucesso ao usuário.
                $session->success = "O Produto foi adicionado a sua Lista de desejos com sucesso!";
                //se existir eu redireciono para a página do perfil
                $this->_redirect($_SERVER['HTTP_REFERER']);
            } catch (Exception $e) {
                // Envio um feedback de sucesso ao usuário.
                $session->error = "Houve um problema ao inserir o produto á sua lista de desejos! Tente novamente mais tarde.";
                //se existir eu redireciono para a página do perfil
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            // Envio um feedback de sucesso ao usuário.
            $session->error = "Você precisa estar logado para realizar esta operação.";
            //se existir eu redireciono para a página do perfil
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     * Cadastro rápido ou login pelo facebook
     */

    public function cadastrorapidoAction() {

        $this->_redirect("reverbme");
        $this->view->title = "Cadastro rápido da Reverb";
        $this->view->description = "Quer apenas curtir o que o site oferece? faça um cadastro rápido!";
        $this->view->keywords = "Reverbcity, cadastro rapido, camisetas, indie, rock";

        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");
        // Cria a sessão de usuário
        $usuarios = new Zend_Session_Namespace("usuarios");


        if ($usuarios->logado == TRUE) {

            // Redireciona
            $this->_redirect("reverbme/novome");
        }
        //se for get e tiver um codigo setado
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])) {

            // Informe o seu App ID abaixo
            $appId = '222802401243110';

            // Digite o App Secret do seu aplicativo abaixo:
            $appSecret = '897181715209682fd1403cd927aa7b51';

            // Url informada no campo "Site URL"
            $redirectUri = urlencode('http://reverbcity.com/cadastro-rapido');

            // Obtém o código da query string
            $code = $_GET['code'];

            // Monta a url para obter o token de acesso e assim obter os dados do usuário
            $token_url = "https://graph.facebook.com/oauth/access_token?"
                    . "client_id=" . $appId . "&redirect_uri=" . $redirectUri
                    . "&client_secret=" . $appSecret . "&code=" . $code;

            //pega os dados
            $response = @file_get_contents($token_url);
            if ($response) {
                $params = null;
                parse_str($response, $params);
                if (isset($params['access_token']) && $params['access_token']) {
                    $graph_url = "https://graph.facebook.com/me?access_token="
                            . $params['access_token'];
                    $user = json_decode(file_get_contents($graph_url));

                    // var_dump($user);die();
                    // nesse IF verificamos se veio os dados corretamente
                    if (isset($user->email) && $user->email) {

                        // $usuarios->logado = TRUE;
                        $usuarios->email = $user->email;
                        $usuarios->nome = $user->name;
                        $usuarios->cidade = $user->location->name;
                        $usuarios->codigo_fb = $user->id;
                        $usuarios->nome_fb = $user->username;
                        $usuarios->link_fb = $user->link;
                        $usuarios->logado = true;
                        $usuarios->facebook = true;
                        $usuarios->twitter = false;




                        //inicio o model de cadastro do me
                        $model_reverbme = new Default_Model_Reverbme();

                        //faço o select para ver se o usuário ja tem um cadastro pelo facebook
                        $select_facebook = $model_reverbme->select()
                                ->from("cadastros", array("NR_IDFACEBOOK_CASO", "NR_SEQ_CADASTRO_CASO", "DS_EMAIL_CASO"))
                                ->where("NR_IDFACEBOOK_CASO = ?", $user->id)
                                ->limit(1);

                        //armazeno o id do face em uma variavel
                        $idfacebook = $model_reverbme->fetchRow($select_facebook);

                        $aniversario = explode("/", $user->birthday);
                        $aniversario_formatado = $aniversario[2] . "-" . $aniversario[0] . "-" . $aniversario[1];

                        // die($aniversario_formatado);
                        //    //agora verifico se já existe um cadastro cadastro com este ID caso contrario crio um cadastro
                        if ($idfacebook->NR_IDFACEBOOK_CASO == "") {

                            //crio o array com os dados do face e crio uma senha padrão para o usuário
                            $data_me = array("DS_NOME_CASO" => $user->name,
                                "DS_CIDADE_CASO" => $user->location->name,
                                "DS_EMAIL_CASO" => $user->email,
                                "DS_FACEBOOK_CACH" => $user->link,
                                "NR_IDFACEBOOK_CASO" => $user->id,
                                "DS_SENHA_CASO" => $user->id,
                                "DS_TIPO_CASO" => "PF",
                                "DT_NASCIMENTO_CASO" => $aniversario_formatado,
                                "ST_CADASTROCOMPLETO_CASO" => 0);


                            //verifico se já existe um e-mail cadastrado igual ao do facebook do usuário

                            if ($idfacebook->DS_EMAIL_CASO != "") {

                                $usuarios->idperfil = $idfacebook->NR_SEQ_CADASTRO_CASO;
                                $this->_redirect($_SERVER['HTTP_REFERER']);
                            }


                            //tento inserir os dados
                            try {

                                $idme = $model_reverbme->insert($data_me);
                                //passo agora o id do usuario para a sessao
                                $usuarios->idperfil = $idme;
                                $usuarios->cadastro_completo = 0;

                                $mensagem = "<tr>
													<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
														BEM VINDO
													</td>
												</tr>
												<tr>
													<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
														</br></br>
															Olá, <b>" . $data_me['DS_NOME_CASO'] . ", Seja bem vindo a Reverbcity.  </b></br>

															Obrigado por se cadastrar no site, a partir de agora </br>
															você poderá usar e abusar de todas as funções de nosso site.

															<b>Dados de acesso:</b>

															<b>E-mail - " . $data_me['DS_EMAIL_CASO'] . "</br>
															<b>Senha - " . $data_me['DS_SENHA_CASO'] . "</br>

															<b>Obs:</b> Não se esqueça de completar seu cadastro para que você possa realizar compras em nossa loja.</br>
															Para completar seu cadastro, acesse </b>MEU PERFIL</b> no topo do site, logo apos isso clique em <b>DADOS CADASTRAIS</b>.

														</br>

													</td>
												</tr>";

                                // Busca o conteudo do topo e do rodape
                                $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_padrao.html");

                                $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_padrao.html");
                                //crio o corpo á ser enviado para o cliente
                                $body .= $topo;
                                $body .= $mensagem;
                                $body .= $rodape;

                                $config = array(
                                    'auth' => 'login',
                                    'username' => "vendas@reverbcity.com",
                                    'password' => "vendas@reverb144",
                                    'ssl' => "tls", # default ("ssl")
                                    'port' => "587" # default ("25")
                                );
                                $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                                $emailAdm = "gustavo@reverbcity.com";
                                $mail = new Zend_Mail('UTF-8');
                                $mail->setBodyHtml($body, 'UTF-8');
                                $mail->addTo($data_me['DS_EMAIL_CASO'], "Reverbcity - A Música que veste");
                                $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                                $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                                $mail->setSubject("Reverbcity - Confirmação de Cadastro");
                                $mail->send($mailTransport);


                                $mode_monitora = new Default_Model_Monitoraclientes();

                                $data_monitora_cliente = array("idcliente" => $idme,
                                    "dia_acesso" => date("d"),
                                    "mes_acesso" => date("m"),
                                    "ano_acesso" => date("Y"));

                                $mode_monitora->insert($data_monitora_cliente);


                                // Envio um feedback de sucesso ao usuário.
                                $messages->success = "Seja bem vindo!";
                                //redireciono para a última página visitada
                                $this->_redirect('/reverbme/novome');
                            } catch (Exception $e) {
                                // Envio um feedback de sucesso ao usuário.
                                $messages->error = "Houve um problema ao realizar seu login com o Facebook, tente novamente mais tarde.";
                                // die(var_dump($e));
                                //se existir eu redireciono para a página do perfil
                                $this->_redirect($_SERVER['HTTP_REFERER']);
                            }
                        } else {
                            $usuarios->idperfil = $idfacebook->NR_SEQ_CADASTRO_CASO;

                            // Envio um feedback de sucesso ao usuário.
                            $messages->success = "Seja bem vindo!";
                            //redireciono para a última página visitada
                            $this->_redirect('/reverbme/novome');
                        }
                    }
                } else {
                    $messages->error = "Erro de conexão com Facebook";
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $messages->error = "Erro de conexão com Facebook";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])) {
            $messages->error = "Permissão não concedida";
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
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
        $this->view->banners_topo = $banners_topo;
    }

    /*
     *
     * Insiro o cadastro rapido
     *
     */

    public function inserircadastroAction() {

        //verifico se e post
        if ($this->_request->isPost()) {
            // Cria a sessão das mensagens
            $session = new Zend_Session_Namespace("messages");

            // Cria a sessão de usuário
            $usuarios = new Zend_Session_Namespace("usuarios");

            $model_me = new Default_Model_Reverbme();

            $mail = $this->_request->getParam("email");
            //crio a query para verificar se existe email cadastrado
            $select_email = $model_me->select()->
                    from("cadastros", array("DS_EMAIL_CASO"))
                    ->where("DS_EMAIL_CASO like '%" . $mail . "%'");

            //armazeno em uma variavel
            $existe_mail = $model_me->fetchRow($select_email);


            if ($existe_mail->DS_EMAIL_CASO != "") {

                // Envio um feedback de sucesso ao usuário.
                $session->error = "Desculpe, já existe uma conta vinculada com este e-mail!";
                //redireciono para a última página visitada
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }

            $data_cadastro = array("DS_EMAIL_CASO" => $this->_request->getParam("email"),
                "DS_SENHA_CASO" => $this->_request->getParam("senha"),
                'ST_ENVIO_CASO' => $this->_request->getParam('mailing'),
                'DS_OBS_CACH' => $this->_request->getParam('observacoes'),
                'ST_ENVIOSMS_CACH' => $this->_request->getParam('sms'),
                'ST_CADASTRO_CASO' => "A",
                'DS_PROFILE_CACH' => "P",
                'DS_TIPO_CASO' => "PF");
            try {
                //recebo o id do cadastro
                $idme = $model_me->insert($data_cadastro);

                $usuarios->idperfil = $idme;
                $usuarios->logado = TRUE;
                $usuarios->email = $data['DS_EMAIL_CASO'];
                $usuarios->tipo = $data['DS_TIPO_CASO'];
                $usuarios->cep = $data['DS_CEP_CASO'];

                // Envio um feedback de sucesso ao usuário.
                $session->success = "O cadastro foi realizado com sucesso!";

                $this->_redirect('/reverbme/novome');
            } catch (Exception $e) {
                // die(var_dump($e));
                // Envio um feedback de sucesso ao usuário.
                $session->error = "Ocorreu um erro no seu cadastro, por favor entre em contato e informe o ocorrido!";
                //redireciono para a última página visitada
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            // Envio um feedback de sucesso ao usuário.
            $session->error = "Você não pode acessar esta url por aqui!";
            //redireciono para a última página visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     * Função para indicar um amigo
     */

    public function indiqueamigoAction() {
        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");
        //pego a ultima url(a indicada)
        $url_indicada = $_SERVER['HTTP_REFERER'];
        //inicio o model de indicacoes
        $model_indicacao = new Default_Model_Indicacoes();

        if ($this->_request->isPost()) {
            //recebo a url montada do form
            $url_form = $this->_request->getParam("url");
            //se tiver sido setada atribuo a mesma a url indicada
            if ($url_form) {

                $url_indicada = $url_form;
            }

            $data = array("url_indicada" => $url_indicada,
                "quem_indicou" => $this->_request->getParam("Nome"),
                "email_quem_indicou" => $this->_request->getParam("Email"),
                "quem_recebeu" => $this->_request->getParam("NomeAmigo"),
                "email_quem_recebeu" => $this->_request->getParam("EmailAmigo"),
                "mensagem" => $this->_request->getParam("mensagem"));

            try {
                $model_indicacao->insert($data);


                $mensagem = "<tr>
								<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
									INDICAÇÃO DE AMIGO
								</td>
							</tr>
							<tr>
								<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
									</br></br>
										Olá, <b>" . $data["quem_recebeu"] . ",</b></br>

										O seu amigo :<b> " . $data["quem_indicou"] . " </br>
										E-mail : " . $data["email_quem_indicou"] . "</b> indicou a seguinte página para que você confira clicando no link abaixo:</br>

										<b>Mensagem Personalizada </b>" . $data["mensagem"] . " </br>

									</br>

								</td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
									<b><a href='" . $data["url_indicada"] . "' style=\"text-decoration:none;color: #646464; font-size: 12px;\">Página indicada </a></b>
								</td>
							</tr>";

                // Busca o conteudo do topo e do rodape
                $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_padrao.html");

                $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_padrao.html");
                //crio o corpo á ser enviado para o cliente
                $body .= $topo;
                $body .= $mensagem;
                $body .= $rodape;

                $config = array(
                    'auth' => 'login',
                    'username' => "vendas@reverbcity.com",
                    'password' => "vendas@reverb144",
                    'ssl' => "tls", # default ("ssl")
                    'port' => "587" # default ("25")
                );
                $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                $emailAdm = "noreply@reverbcity.com";
                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml($body);
                $mail->addTo($data['email_quem_recebeu'], "Reverbcity - A Música que veste");
                $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                $mail->setSubject("Indicação do seu amigo");
                $mail->send($mailTransport);


                // Envio um feedback de sucesso ao usuário.
                $session->success = "A sua indicação foi enviada com sucesso!";
                //redireciono para a última página visitada
                $this->_redirect($_SERVER['HTTP_REFERER']);
            } catch (Exception $e) {

                // Envio um feedback de sucesso ao usuário.
                $session->error = "Não foi possível enviar sua indicação, tente novamente mais tarde.";
                //redireciono para a última página visitada
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            // Envio um feedback de sucesso ao usuário.
            $session->error = "Você não pode acessar esta página por aqui!";
            //redireciono para a última página visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     * Função para indicar um amigo
     */

    public function indiqueamigo2Action() {
        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");
        //pego a ultima url(a indicada)
        $url_indicada = $_SERVER['HTTP_REFERER'];
        //inicio o model de indicacoes
        $model_indicacao = new Default_Model_Indicacoes();

        if ($this->_request->isPost()) {

            $perfil_model = new Default_Model_Reverbme();
            $dadosCadastro = $perfil_model->fetchRow(array('DS_EMAIL_CASO = ?' => $this->_request->getParam("EmailAmigo")));

            if ($dadosCadastro) {
                $session->error = "Seu amigo já esta cadastrado!";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }

            $usuarios = new Zend_Session_Namespace("usuarios");

            $data = array("quem_indicou" => $usuarios->nome,
                "email_quem_indicou" => $usuarios->email,
                "quem_recebeu" => $this->_request->getParam("NomeAmigo"),
                "email_quem_recebeu" => $this->_request->getParam("EmailAmigo"));

            try {
                $model_indicacao->insert($data);


                $mensagem = "<div style=\"font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;\">
                                        </br></br>
                                        Olá {$data['quem_recebeu']}, o seu amig@ {$data['quem_indicou']} indicou você para ganhar uma camiseta na Reverbcity!
                                        </br>
                                        <br />
                                        Basta fazer um cadastro na Reverbcity.com e realizar uma compra única a partir de R$150 em até 90 dias. A partir do momento em que você atingir este valor, a próxima camiseta que você colocar no carrinho não será cobrada!
                                        <br /><br />
                                        Faça seu cadastro e participe!
                                        <br /><br />
                                        Reverbcity | Música Que Veste
                                        <br /><br />
                                        Promoção válida apenas para novos cadastros. A promo tem validade de 90 dias após a data do cadastro. A Reverbcity se reserva ao direito de alterar/cancelar essa promoção conforme ache necessário e sem aviso prévio.
                                </div>";

                // Busca o conteudo do topo e do rodape
                $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_indique.html");

                $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_indique.html");
                //crio o corpo á ser enviado para o cliente
                $body .= $topo;
                $body .= $mensagem;
                $body .= $rodape;

                $config = array(
                    'auth' => 'login',
                    'username' => "vendas@reverbcity.com",
                    'password' => "vendas@reverb144",
                    'ssl' => "tls", # default ("ssl")
                    'port' => "587" # default ("25")
                );
                $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                $emailAdm = "noreply@reverbcity.com";
                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml($body);
                $mail->addTo($data['email_quem_recebeu'], "Reverbcity - A Música que veste");
                $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                $mail->setSubject("Você foi convidado para se vestir de música!");
                $mail->send($mailTransport);


                // Envio um feedback de sucesso ao usuário.
                $session->success = "A sua indicação foi enviada com sucesso!";
                //redireciono para a última página visitada
                $this->_redirect($_SERVER['HTTP_REFERER']);
            } catch (Exception $e) {

                // Envio um feedback de sucesso ao usuário.
                $session->error = "Não foi possível enviar sua indicação, tente novamente mais tarde.";
                //redireciono para a última página visitada
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            // Envio um feedback de sucesso ao usuário.
            $session->error = "Você não pode acessar esta página por aqui!";
            //redireciono para a última página visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     *
     */

    public function recuperarsenhaAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");
        //se for post
        if ($this->_request->isPost()) {
            //pego o email
            $email = $this->_request->getParam("email");

            // Cria o objeto da model
            $perfil_model = new Default_Model_Reverbme();
            // verifico se o email informado esta correto
            $row = $perfil_model->fetchRow(array('DS_EMAIL_CASO = ?' => $email));

            //se estiver vazio, informo que o email é invalido
            if ($row == NULL) {
                // Exibe mensagem de usuário inválido
                $messages->error = "E-mail inválido.";

                // Redireciona para a última página
                $this->_redirect($_SERVER['HTTP_REFERER']);
            } else {
                try {
                    $mensagem = "<tr>
									<td colspan=\"6\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana;\" width=\"602\" height=\"31\" >
										RECUPERAR SENHA
									</td>
								</tr>
								<tr>
									<td colspan=\"11\" width=\"632\"  style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464\">
										</br></br>
											Olá, <b>" . $email . ",</b></br>

											Você solicitou a recuperação da sua senha, guarde este e-mail caso precise novamente. </br></br>
											Sua senha é : <b>" . $row->DS_SENHA_CASO . "</b></br></br>

											Caso não tenha solicitado uma nova senha, por favor desconsidere este e-mail</br></br>

											Obrigado. </br>

										</br>

									</td>
								</tr>";

                    // Busca o conteudo do topo e do rodape
                    $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_padrao.html");

                    $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_padrao.html");
                    //crio o corpo á ser enviado para o cliente
                    $body .= $topo;
                    $body .= $mensagem;
                    $body .= $rodape;

                    $config = array(
                        'auth' => 'login',
                        'username' => "vendas@reverbcity.com",
                        'password' => "vendas@reverb144",
                        'ssl' => "tls", # default ("ssl")
                        'port' => "587" # default ("25")
                    );
                    $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                    $emailAdm = "atendimento@reverbcity.com";
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setBodyHtml($body);
                    $mail->addTo($email, "Reverbcity - A Música que veste");
                    $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                    $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                    $mail->setSubject("Recuperar Senha");
                    $mail->send($mailTransport);


                    // Envio um feedback de sucesso ao usuário.
                    $session->success = "Enviamos sua senha para o e-mail informado!";
                    //redireciono para a última página visitada
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                } catch (Exception $e) {

                    // Envio um feedback de sucesso ao usuário.
                    $session->error = "Não foi possível recuperar sua senha, tente novamente mais tarde.";
                    //redireciono para a última página visitada
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            // Envio um feedback de sucesso ao usuário.
            $session->error = "Você não pode acessar esta página por aqui!";
            //redireciono para a última página visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     * Autocomplete da busca
     *
     */

    public function autocompleteAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        $palavra = $this->_request->getParam("search");
        $palavra = str_replace(' ', '%', $palavra);
        // defino o adaptador do banco
        $db = Zend_Registry::get("db");
        $select = $db->select()
                ->union(array(
                    "SELECT p.NR_SEQ_PRODUTO_PRRC 		as id, p.DS_PRODUTO_PRRC 	as titulo, 1 as tipo, p.DS_EXT_PRRC 		as extencao,	p.DT_CADASTRO_PRRC 	as	data_cadastro, 	p.VL_PRODUTO_PRRC 	as valor 	FROM produtos p 	WHERE p.DS_PRODUTO_PRRC LIKE " . $db->quote("%" . $palavra . "%") . "AND DS_CLASSIC_PRRC = 'N' AND NR_SEQ_TIPO_PRRC not in(4) AND NR_SEQ_LOJAS_PRRC = 1 AND ST_PRODUTOS_PRRC = 'A'",
                ))
                ->limit(50);

        //crio uma lista com o resultado de sementes
        $lista_produto = $db->fetchAll($select);

        // recupera apenas os titulos
        foreach ($lista_produto as $key => $value) {
            $json_value[$key] = $value['titulo'];
        }

        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value, 0, 13);

        //assino ao view o resultado
        $this->_helper->json($json_value);
    }

    //função para promoçoes de marketing
    public function promocoesAction() {

        $produto_promo2 = $this->_request->getParam("produto");
        $produto_promo2 = str_replace('-', ' ', $produto_promo2);
        $produto_promo2 = ucwords($produto_promo2);

        $this->view->title = "Camisetas " . $produto_promo2 . " - Reverbcity.com";
        $this->view->description = "Na Reverbcity você encontra diversas camisetas de bandas rock, camisetas " . strtolower($produto_promo2) . " ,camisetas indie, raglans personalizadas e muito mais!";
        $this->view->keywords = "camisetas " . strtolower($produto_promo2) . ", camisetas de bandas de rock, camisetas rock, camisetas personalizadas, camisetas indie";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");

        $campanhas = new Zend_Session_Namespace("campanhas");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }
        $campanhas = new Zend_Session_Namespace("campanhas");
        //pego a url da campanha
        $endereco = $_SERVER ['REQUEST_URI'];
        //pego o id da campanha
        $parametro = explode("=", $endereco);
        //verifico se existe parametro
        if ($parametro[1] != "") {
            //adiciono a campanha a sessão
            $campanhas->idcampanha = $parametro[1];
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");
        $produto_promo = $this->_request->getParam("produto");


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
                    'DS_CORES_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                ->joinLeft('produtos_tags', 'idproduto = nr_seq_produto_prrc', array())
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //onde e tipo de destaque = 3 (novidades)
                ->where("DS_PRODUTO_PRRC LIKE '%" . addslashes(str_replace('-', '%', $produto_promo)) . "%' OR produto_tag LIKE '%" . addslashes(str_replace('-', '%', $produto_promo)) . "%'")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //agrupo por codigo do produto
        $select_produtos->group("NR_SEQ_PRODUTO_PRRC");
        //agora coloco as condições da url, dependendo dos parametros
        //se tiver uma cor selecionada
        if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");

            $this->view->valor_url = $valor;
        }
        if ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");

            $this->view->valor_url = $valor;
        }
        if ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");

            $this->view->valor_url = $valor;
        }
        if ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC BETWEEN > 90)");

            $this->view->valor_url = $valor;
        }
        if ($categoria != "") {
            $select_produtos->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);
            //assino ao view a categoria
            $this->view->cat_url = $categoria;
        }
        //se existir palavra a ser buscada
        if ($palavra != "") {
            $select_produtos->where("DS_PRODUTO_PRRC LIKE '%" . $palavra . "%'");
            //assino ao view a palavra
            $this->view->palavra_busca = $palavra;
        }
        //se for masculino
        if ($genero == "masculino") {
            $select_produtos->where("DS_GENERO_PRRC = 'M'");
            //assino ao view o genero
            $this->view->genero = $genero;
        }
        //se for feminino
        if ($genero == "feminino") {
            $select_produtos->where("DS_GENERO_PRRC = 'F'");
            //assino ao view o genero
            $this->view->genero = $genero;
        }
        //se tiver um tipo de produto selecionado
        if ($tipo != "") {
            $select_produtos->where("NR_SEQ_TIPO_PRRC = " . $tipo);
            //assino ao view a categoria
            $this->view->tipo_url = $tipo;
        }
        //se tiver uma cor selecionada
        if ($cor != "") {
            $select_produtos->where("NR_SEQ_COR_PRRC = " . $cor);
            //assino ao view a categoria
            $this->view->cor_url = $cor;
        }
        //se o tamanho do produto for p
        if ($tamanho == "p") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 2 or NR_SEQ_TAMANHO_TARC = 7");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        }
        //se o tamanho do produto for m
        if ($tamanho == "m") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 3 or NR_SEQ_TAMANHO_TARC = 8");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        }
        //se o tamanho do produto for g
        if ($tamanho == "g") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 4 or NR_SEQ_TAMANHO_TARC = 9");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        }
        //se o tamanho do produto for gg
        if ($tamanho == "gg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 5 or NR_SEQ_TAMANHO_TARC = 10");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        }
        //se o tamanho do produto for xgg
        if ($tamanho == "xgg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 33");
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
        $paginator->setItemCountPerPage(16)
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
        $contador->setItemCountPerPage(16)
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
                ->where("TP_DESTAQUE_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");
        //agora verifico o que foi feito no filtro
        if ($categoria != "") {
            $select_tipos->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);
        }
        //se tiver uma cor selecionada
        if ($cor != "") {
            //se tiver cor selecionada coloco no filtro
            $select_tipos->where("NR_SEQ_COR_PRRC = " . $cor);
        }
        //se tiver uma cor selecionada
        if ($valor == 29.90) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        }
        if ($valor == 30) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        }
        if ($valor == 61) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        }
        if ($valor == 90) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC BETWEEN > 90)");
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
                ->where("TP_DESTAQUE_PRRC = 1")
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");
        //se tiver uma cor selecionada
        if ($cor != "") {
            //se tiver cor selecionada coloco no filtro
            $select_categorias->where("NR_SEQ_COR_PRRC = " . $cor);
        }
        //se tiver uma cor selecionada
        if ($valor == 29.90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        }
        if ($valor == 30) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        }
        if ($valor == 61) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        }
        if ($valor == 90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC BETWEEN > 90)");
        }
        //se tiver um tipo de produto selecionado
        if ($tipo != "") {
            $select_categorias->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
        //agora agrupo
        $select_categorias->group("NR_SEQ_CATEGPRO_PCRC");


        //crio uma lista de categorias
        $lista_categoria = $model_menu->fetchAll($select_categorias)->toArray();

        //assino as categorias ao view
        $this->view->categorias = $lista_categoria;

        //inicio a query de cores(
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
                //somente novidades
                ->where("TP_DESTAQUE_PRRC = 1")
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");
        if ($categoria != "") {
            $select_cor->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);
        }
        //se tiver um valor relacionado
        if ($valor == 29.90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        }
        if ($valor == 30) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        }
        if ($valor == 61) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        }
        if ($valor == 90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC BETWEEN > 90)");
        }
        //se tiver um tipo de produto selecionado
        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = " . $tipo);
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
    }

    /*
     *
     * Assina newsletter pelo facebook
     *
     */

    public function assinafacebookAction() {
        $this->_helper->layout->disableLayout();
    }

    public function closeCheckoutAction() {
        $usuarios = new Zend_Session_Namespace("usuarios");

        if ($usuarios->logado == TRUE) {
            $carrinho = new Zend_Session_Namespace("carrinho");

            if (count($carrinho->produtos) >= 1) {
                date_default_timezone_set('America/Sao_Paulo');

                $indices = implode(', ', array_keys($carrinho->produtos));

                $produtos = array();

                foreach ($carrinho->produtos as $estoque => $produto) {
                    $produtos[$estoque] = $produto['codigo'];
                }

                $produtosJson = json_encode($produtos);

                $modelCarrinho = new Default_Model_Carrinho();
                $dadosCarrinho = $modelCarrinho->fetchRow(array('cadastros_id = ?' => $usuarios->idperfil, 'compras_id IS NULL', 'email_enviado = 0'));

                $data = array();
                $data['cadastros_id'] = $usuarios->idperfil;
                $data['email_cadastro'] = $usuarios->email;
                $data['estoque_id'] = $produtosJson;
                $data['hora'] = date("Y-m-d H:i:s");

                if ($dadosCarrinho) {
                    $modelCarrinho->update($data, array('carrinho_id = ?' => $dadosCarrinho->carrinho_id));
                } else {
                    $modelCarrinho->insert($data);
                }
            }
        }

        die();
    }

    public function emailRecuperacaoAction() {
        date_default_timezone_set('America/Sao_Paulo');
        try {
            $dataHora = date("Y-m-d H:i:s", strtotime('-1 hours'));
            $dataAtual = date("Y-m-d H:i:s");

            $modelCarrinho = new Default_Model_Carrinho();

            $selectCarrinho = $modelCarrinho->select()
                    ->from(array('c' => 'carrinho'))
                    ->columns(array(
                        'ultimacompra' => '(SELECT MAX(compras.DT_COMPRA_COSO) FROM compras WHERE compras.NR_SEQ_CADASTRO_COSO = c.cadastros_id)'
                    ))
                    ->where('c.compras_id IS NULL')
                    ->where('c.email_cadastro IS NOT NULL')
                    ->where('c.email_enviado = 0')
                    ->where('c.hora <= ?', $dataHora)
                    //->having("(ultimacompra < '{$dataHora}' AND ultimacompra >) OR ultimacompra IS NULL");
                    ->having("ultimacompra < c.hora OR ultimacompra IS NULL");

            $dadosCarrinho = $modelCarrinho->fetchAll($selectCarrinho);

            $modelProdutos = new Default_Model_produtos();
            $modelCadastros = new Default_Model_Reverbme();
            $modelEstoque = new Default_Model_Estoque();

            foreach ($dadosCarrinho as $carrinho) {

                $dadosCadastro = $modelCadastros->fetchRow(array('NR_SEQ_CADASTRO_CASO = ?' => $carrinho->cadastros_id));

                $arrProdutos = json_decode($carrinho->estoque_id, true);
                $totalProdutos = count($arrProdutos);

                $rowSpan = 13 + ($totalProdutos * 6);

                $nome = explode(' ', $dadosCadastro->DS_NOME_CASO);
                $nome = $nome[0];

                $htmlBody = '<html>
                                <title></title>
                                <meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><!-- Save for Web Slices (MAIL_RESGATE.psd) -->
                                <table align="center" border="0" cellpadding="0" cellspacing="0" id="Table_01" width="701">
                                    <tbody>
                                        <tr>
                                            <td rowspan="' . $rowSpan . '">&nbsp;</td>
                                            <td colspan="21" style="text-align: left;"><img alt="" height="145" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_02.png" width="600" /></td>
                                            <td rowspan="' . $rowSpan . '">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="20" valign="bottom"><span style="font-family: Verdana,sans-serif; font-size: 12px; color: #414042;">Olá ' . $nome . '! </span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="20"><span style="font-family: Verdana,sans-serif; font-size: 12px; color: #414042; font-weight: bold;">
                                                <br />Procurou e não levou?
                                                <br />Guardamos pra você, mas por pouco tempo. Corre que o estoque é limitado!</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="20"><img alt="" height="21" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_14.png" width="600" /></td>
                                        </tr>
                            ';

                foreach ($arrProdutos as $estoque_id => $arrProduto) {
                    $dadosProduto = $modelProdutos->fetchRow(array('NR_SEQ_PRODUTO_PRRC = ?' => $arrProduto));

                    $selectEstoque = $modelEstoque->select()
                            ->from(array('e' => 'estoque'), array())
                            ->join(array('t' => 'tamanhos'), 'e.NR_SEQ_TAMANHO_ESRC = t.NR_SEQ_TAMANHO_TARC', array('DS_TAMANHO_TARC'))
                            ->where('e.NR_SEQ_ESTOQUE_ESRC = ?', $estoque_id)
                            ->setIntegrityCheck(FALSE);
                    $dadosTamanho = $modelEstoque->fetchRow($selectEstoque);

                    $dadosFotosProduto = $this->view->fotoproduto($arrProduto);

                    $htmlBody .= '<!-- Começa produto -->
                                <tr>
                                    <td colspan="20"><img border="0" alt="" height="5" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_15.png" width="600" /></td>
                                </tr>
                                <tr>
                                    <td rowspan="5"><img border="0" alt="" height="92" src="https://www.reverbcity.com/thumb/fotosprodutos/1/84/92/' . $dadosFotosProduto[0]['NR_SEQ_FOTO_FORC'] . '.' . $dadosFotosProduto[0]['DS_EXT_FORC'] . '" width="84" /></td>
                                    <td colspan="19"><img border="0" alt="" height="11" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_17.png" width="516" /></td>
                                </tr>
                                <tr>
                                    <td colspan="15" rowspan="2">
                                        <span style="font-family: Verdana,sans-serif; font-size: 12px; color: #414042; font-weight: bold; margin-left: 20px;">
                                            ' . $dadosProduto->DS_PRODUTO_PRRC . '
                                        </span>
                                    </td>
                                    <td colspan="4"><img border="0" alt="" height="17" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_19.png" width="212" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2" rowspan="3"><img border="0" alt="" height="64" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_20.png" width="82" /></td>
                                    <td colspan="2" rowspan="2" style="text-align: right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="15" rowspan="2" valign="top">
                                        <span style="font-family: Verdana,sans-serif; font-size: 12px; color: #414042; margin-left: 20px;">
                                            ' . $dadosTamanho->DS_TAMANHO_TARC . '
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img border="0" alt="" height="28" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_24.png" width="120" /></td>
                                </tr>
                                <!-- Termina produto -->';
                }

                $htmlBody .= '<tr>
                            <td colspan="20" style="text-align: center;"><img alt="" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_14.png" width="600" /></td>
                        </tr>
                        <tr height="150">
                            <td colspan="18" rowspan="1"><span style="font-family: Verdana,sans-serif; font-size: 12px; color: #414042;">O seu pedido est&aacute; reservado e te esperando. <br />Clique no bot&atilde;o <a href="https://www.reverbcity.com/refazer-carrinho/' . $carrinho->carrinho_id . '" style="color: #ee5731; font-weight: bold; text-decoration: none;">ir para o carrinho</a> para se vestir de m&uacute;sica! </span></td>
                            <td colspan="2" style="text-align: right;">
                                <a href="https://www.reverbcity.com/refazer-carrinho/' . $carrinho->carrinho_id . '" target="_blank">
                                    <img border="0" alt="" height="46" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/btn_ircarrinho.png" width="136" />​
                                </a>
                            </td>
                            <td valign="top">
                                <img src="https://www.reverbcity.com/arquivos/emails/mail_resgate/seta.png" width="100">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="20" style="text-align: center;"><img border="0" alt="" height="50" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_32.png" width="600" /></td>
                        </tr>
                        <tr>
                            <td colspan="6" rowspan="3"><img border="0" alt="" height="71" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_33.png" width="218" /></td>
                            <td colspan="2">
                                <a href="https://www.facebook.com/Reverbcity" target="_blank">
                                    <img border="0" alt="" height="41" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_34.png" width="29" />
                                </a>
                            </td>
                            <td colspan="2">
                                <a href="https://twitter.com/reverbcity" target="_blank">
                                    <img border="0" alt="" height="41" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_35.png" width="41" />
                                </a>
                            </td>
                            <td colspan="2">
                                <a href="http://reverbcity.tumblr.com" target="_blank">
                                    <img border="0" alt="" height="41" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_36.png" width="31" />
                                </a>
                            </td>
                            <td>
                                <a href="http://instagram.com/reverbcity" target="_blank">
                                    <img border="0" alt="" height="41" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_37.png" width="36" />
                                </a>
                            </td>
                            <td colspan="3">
                                <a href="http://www.pinterest.com/reverbcity/" target="_blank">
                                    <img border="0" alt="" height="41" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_38.png" width="33" />
                                </a>
                            </td>
                            <td colspan="4" rowspan="3"><img border="0" alt="" height="71" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_39.png" width="212" /></td>
                        </tr>
                        <tr>
                            <td colspan="3"><img border="0" alt="" height="15" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_40.png" width="35" /></td>
                            <td colspan="4">
                                <a href="https://www.reverbcity.com" target="_blank">
                                    <img border="0" alt="" height="15" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_41.png" width="102" />
                                </a>
                            </td>
                            <td colspan="3"><img border="0" alt="" height="15" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_42.png" width="33" /></td>
                        </tr>
                        <tr>
                            <td><img border="0" alt="" height="15" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_43.png" width="17" /></td>
                            <td colspan="7">
                                <a href="mailto:atendimento@reverbcity.com">
                                    <img border="0" alt="" height="15" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_44.png" width="130" />
                                </a>
                            </td>
                            <td colspan="2"><img border="0" alt="" height="15" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_45.png" width="23" /></td>
                        </tr>
                        <tr>
                            <td colspan="20" style="text-align: center;"><img border="0" alt="" height="17" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_46.png" width="600" />​</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="https://www.reverbcity.com/politica-de-privacidade" target="_blank">
                                    <img border="0" alt="" height="13" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_47.png" width="105" />
                                </a>
                            </td>
                            <td colspan="2">
                                <!-- <img alt="" height="13" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_48.png" width="77" /> -->
                            </td>
                            <td colspan="16" rowspan="2"><img border="0" alt="" height="52" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/MAIL_RESGATE_49.png" width="418" /></td>
                        </tr>
                        <tr>
                            <td colspan="4"><img border="0" alt="" height="39" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/all_rights.png" width="182" /></td>
                        </tr>
                        <tr>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="50" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="84" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="21" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="8" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="69" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="27" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="9" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="17" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="12" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="6" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="35" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="14" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="17" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="36" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="10" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="10" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="13" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="69" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="13" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="52" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="68" /></td>
                            <td><img border="0" alt="" height="1" src="https://www.reverbcity.com/arquivos/emails/mail_resgate/spacer.gif" width="50" /></td>
                        </tr>
                    </tbody>
                </table>
                <!-- End Save for Web Slices -->
                <img width="0" src="https://www.reverbcity.com/index/email-recuperacao-lido/carrinho_id/' . $carrinho->carrinho_id . '"/>
                </html>';

                $config = array(
                    'auth' => 'login',
                    'username' => "atendimento@reverbcity.com",
                    'password' => "ramones@334",
                    'ssl' => "ssl",
                    'port' => "465"
                );
                $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                $emailAdm = "atendimento@reverbcity.com";
                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml($htmlBody);
                $mail->addTo($carrinho->email_cadastro, $dadosCadastro->DS_NOME_CASO);
                $mail->setFrom($emailAdm, "Reverbcity");
                $mail->setReturnPath($emailAdm);
                $mail->setSubject("Hey, você! Pq nos abandonou? O show continua!");
                $mail->send($mailTransport);

                $modelCarrinho->update(array('email_enviado' => 1), array('carrinho_id = ?' => $carrinho->carrinho_id));
            }
            die('enviados');
        } catch (Exception $e) {
            Zend_Debug::dump($e);
            exit;
        }
    }

    public function emailRecuperacaoLidoAction() {
        $carrinho_id = $this->_request->getParam('carrinho_id');

        if (!empty($carrinho_id)) {
            $modelCarrinho = new Default_Model_Carrinho();
            $modelCarrinho->update(array('email_lido' => 1), array('carrinho_id = ?' => $carrinho_id));
        }

        die();
    }

    /*
     * Cria os thumbs
     *
     * @name thumbAction
     */

    public function thumbAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        // Busca os parametros
        $file = $this->_request->getParam("imagem", "");
        $type = $this->_request->getParam("tipo", "");
        $width = $this->_request->getParam("largura", "");
        $height = $this->_request->getParam("altura", "");
        $crop = $this->_request->getParam("crop", 1);

        // Monta o caminho do arquivo
        $file = APPLICATION_PATH . "/../arquivos/uploads/" . $type . "/" . $file;

        // Cria o objeto canvas
        $canvas = new Reverb_Image_Canvas($file);

        // Verifica se foi passada somente a largura
        if (($width != "") && ($height == "")) {
            $canvas->redimensiona($width);
        }
        // Verifica se foi passada somente a altura
        elseif ($width == "" && $height != "") {
            $canvas->redimensiona('', $height);
        }
        // Verifica se foram passadas as duas dimensoes
        elseif ($width != "" && $height != "") {
            if ($crop == 0) {
                $canvas->redimensiona($width, $height);
            } elseif ($crop == 1) {
                $canvas->redimensiona($width, $height, "crop");
            } elseif ($crop == 2) {
                $canvas->hexa($cor);
                $canvas->redimensiona($width, $height, "preenchimento");
            }
        } else {
            $canvas->redimensiona($thumbs->largura, $thumbs->altura, "preenchimento");
        }

        // Mostra a imagem
        $canvas->grava("", 100);
    }

    public function relatorioVendasAction() {
        $data = $this->_request->getParam('data');

        $modelCompras = new Default_Model_Compras();
        $selectCompras = $modelCompras->select()
                ->from(array('c' => 'compras'), array())
                ->join(array('ce' => 'cestas'), 'ce.NR_SEQ_COMPRA_CESO = c.NR_SEQ_COMPRA_COSO', array())
                ->join(array('p' => 'produtos'), 'p.NR_SEQ_PRODUTO_PRRC = ce.NR_SEQ_PRODUTO_CESO', array())
                ->columns(array(
                    'data' => 'DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%d/%m/%Y")',
                    'pedido' => 'c.NR_SEQ_COMPRA_COSO',
                    'referencia' => 'p.DS_REFERENCIA_PRRC',
                    'titulo' => 'p.DS_PRODUTO_PRRC',
                    'quantidade' => 'ce.NR_QTDE_CESO',
                    'valor_unitario' => "CONCAT('R$ ', REPLACE (REPLACE (REPLACE (FORMAT(ce.VL_PRODUTO_CESO, 2), '.', '|'), ',', '.'), '|', ','))",
                    'valor_total' => "CONCAT('R$ ', REPLACE (REPLACE (REPLACE (FORMAT((ce.NR_QTDE_CESO * ce.VL_PRODUTO_CESO), 2), '.', '|'), ',', '.'), '|', ','))",
                    'valor_custo' => "CONCAT('R$ ', REPLACE (REPLACE (REPLACE (FORMAT(p.VL_PRODUTO2_PRRC, 2), '.', '|'), ',', '.'), '|', ','))",
                    'valor_custo_total' => "CONCAT('R$ ', REPLACE (REPLACE (REPLACE (FORMAT((ce.NR_QTDE_CESO * p.VL_PRODUTO2_PRRC), 2), '.', '|'), ',', '.'), '|', ','))"
                ))
                ->where('c.ST_COMPRA_COSO NOT IN("A", "C")')
                ->order('DT_PAGAMENTO_COSO ASC')
                ->setIntegrityCheck(FALSE);

        if (!empty($data)) {
            $selectCompras->where('DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m") = ?', $data);
        } else {
            $selectCompras->where('DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m") = "2015-02"');
        }

        $arrayCsv = array(
            'Data',
            'Pedido',
            'Referencia',
            'Titulo',
            'Quantidade',
            'Valor unitario',
            'Valor total',
            'Valor custo',
            'Valor custo total',
            'Valor liquido'
        );

        $output = fopen("php://output", "w");
        fputcsv($output, $arrayCsv);

        $dadosCompras = $modelCompras->fetchAll($selectCompras);

        $quantidade = 0;
        $valor_unitario = 0;
        $valor_total = 0;
        $valor_custo = 0;
        $valor_custo_total = 0;
        $valor_liquido = 0;

        foreach ($dadosCompras as $compra) {

            $quantidade += $compra->quantidade;
            $valor_unitario += (float) str_replace(',', '.', str_replace('R$', '', $compra->valor_unitario));
            $valor_total += (float) str_replace(',', '.', str_replace('R$', '', $compra->valor_total));
            $valor_custo += (float) str_replace(',', '.', str_replace('R$', '', $compra->valor_custo));
            $valor_custo_total += (float) str_replace(',', '.', str_replace('R$', '', $compra->valor_custo_total));
            $valor_liquido += str_replace(',', '.', str_replace('R$', '', $compra->valor_total)) - str_replace(',', '.', str_replace('R$', '', $compra->valor_custo_total));


            $arrayCsv = array(
                $compra->data,
                $compra->pedido,
                $compra->referencia,
                $compra->titulo,
                $compra->quantidade,
                $compra->valor_unitario,
                $compra->valor_total,
                $compra->valor_custo,
                $compra->valor_custo_total,
                'R$' . number_format(str_replace(',', '.', str_replace('R$', '', $compra->valor_total)) - str_replace(',', '.', str_replace('R$', '', $compra->valor_custo_total)), 2, ',', '.')
            );

            fputcsv($output, $arrayCsv);
        }

        $arrayCsv = array(
            '',
            '',
            '',
            '',
            $quantidade,
            'R$' . number_format($valor_unitario, 2, ',', '.'),
            'R$' . number_format($valor_total, 2, ',', '.'),
            'R$' . number_format($valor_custo, 2, ',', '.'),
            'R$' . number_format($valor_custo_total, 2, ',', '.'),
            'R$' . number_format($valor_liquido, 2, ',', '.')
        );

        fputcsv($output, $arrayCsv);

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=relatorio-vendas.csv");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies

        die();
    }

    public function feedAction() {
        $rss = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss xmlns:atom="http://www.w3.org/2005/Atom"></rss>');
        $rss->addAttribute('version', '2.0');

        $modelBlog = new Default_Model_Blog();
        $selectBlog = $modelBlog->select()
                ->from('blog')
                ->where('DS_STATUS_BLRC = "A"')
                ->order('DT_PUBLICACAO_BLRC DESC')
                ->limit(100);
        $dadosBlog = $modelBlog->fetchAll($selectBlog);

        $canal = $rss->addChild('channel');

        $atom = $canal->addChild('atom:atom:link'); //add atom node
        $atom->addAttribute('href', 'https://www.reverbcity.com/index/feed'); //add atom node attribute
        $atom->addAttribute('rel', 'self');
        $atom->addAttribute('type', 'application/rss+xml');

        $canal->addChild('title', 'Reverbcity');
        $canal->addChild('link', 'https://www.reverbcity.com/');
        $canal->addChild('description', 'Feed reverbcity.com');

        foreach ($dadosBlog as $blog) {
            $item = $canal->addChild('item');
            $item->addChild('title', $blog->DS_TITULO_BLRC);
            $item->addChild('link', 'https://www.reverbcity.com/post/' . $this->view->createslug($blog->DS_TITULO_BLRC) . '/' . $blog->NR_SEQ_BLOG_BLRC);
            $item->addChild('guid', 'https://www.reverbcity.com/post/' . $this->view->createslug($blog->DS_TITULO_BLRC) . '/' . $blog->NR_SEQ_BLOG_BLRC);
            $item->addChild('description', preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', str_replace("\n", '', str_replace("\r", '', html_entity_decode(strip_tags($blog->DS_TEXTO_BLRC))))));
            $item->addChild('pubDate', date('r', strtotime($blog->DT_PUBLICACAO_BLRC)));
        }

        header("content-type: text/xml; charset=utf-8");
        echo $rss->asXML();

        die();
    }

    public function merchantAction() {
        $modelProdutos = new Default_Model_produtos();

        $selectProdutos = $modelProdutos->select()
                ->setIntegrityCheck(false)
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
                    'NR_SEQ_COR_PRRC',
                    'DS_INFORMACOES_PRRC',
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinInner("cores", "produtos.NR_SEQ_COR_PRRC = cores.idcor", array("cor"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC", "DS_TAMANHO_TARC"))
                ->joinInner("produtos_categoria", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array('DS_CATEGORIA_PCRC'))
                ->joinInner('menu_site_has_produtos_categoria', 'menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC', array())
                ->joinInner('menu_site', 'menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu', array())


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
                ->group("NR_SEQ_PRODUTO_PRRC")
                ->order(array(
            //"DS_CATEGORIA_PCRC ASC",
            'NR_ORDEM_TODOS_PRRC ASC'
        ));

        $dadosProdutos = $modelProdutos->fetchAll($selectProdutos);

        echo '<?xml version="1.0" encoding="utf-8"?>
                <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
                  <channel>';

        foreach ($dadosProdutos as $produto) {
            $descricao = str_replace('&', 'e', str_replace(array("\r\n", "\r", "\t"), "", html_entity_decode(strip_tags($produto->DS_INFORMACOES_PRRC))));
            $preco = $produto->VL_PRODUTO_PRRC;
            $preco_desconto = $produto->VL_PROMO_PRRC;
            $foto = $this->view->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC);
            $foto_completa = $foto[0]['NR_SEQ_FOTO_FORC'] . '.' . $foto[0]['DS_EXT_FORC'];
            $cor = $produto->cor;
            $size = 'M';
            
            if (isset($produto->NR_SEQ_TAMANHO_ESRC)) {
                $size = '';
                switch ($produto->NR_SEQ_TAMANHO_ESRC) {
                    case 1:
                        $size = 'PP';
                        break;
                    case 2;
                        $size = 'P';
                        break;
                    case 3:
                        $size = 'M';
                        break;
                    case 4;
                        $size = 'G';
                        break;
                    case 5:
                        $size = 'GG';
                        break;
                    case 33;
                        $size = 'XGL';
                        break;
                }
            }

            if (strpos($produto->DS_TAMANHO_TARC, 'Masc') !== FALSE) {
                $genero = 'male';
            } elseif (strpos($produto->DS_TAMANHO_TARC, 'Fem') !== FALSE) {
                $genero = 'female';
            } else {
                $genero = 'unisex';
            }

            if ($produto->NR_SEQ_TIPO_PRRC == 6) {
                $preTitle = 'Camiseta ';
            } else {
                $preTitle = '';
            }

            $ds_produto_prrc = explode(' - ', $produto->DS_PRODUTO_PRRC);
            $slug = $preTitle . $ds_produto_prrc[0];


            echo '<item>
                      <title>' . $preTitle . $produto->DS_PRODUTO_PRRC . '</title>
                      <link>https://www.reverbcity.com' . $this->view->url(["titulo" => $this->view->createslug($slug), "idproduto" => $produto->NR_SEQ_PRODUTO_PRRC], 'produto', TRUE) . '?cp=1210</link>
                      <description>' . $slug . ' ' . $descricao . '</description>
                      <g:id>' . $produto->NR_SEQ_PRODUTO_PRRC . '</g:id>
                      <g:condition>new</g:condition>
                      <g:availability>in stock</g:availability>
                      <g:price>' . $preco . ' BRL</g:price>';

            if ($preco_desconto > 0 && $preco > $preco_desconto) {
                echo '<g:sale_price>' . $preco_desconto . ' BRL</g:sale_price>';
                if ($preco_desconto >= 50 and $preco_desconto <= 100) {
                    $parcela = $preco_desconto / 2;
                    echo '<g:installment>
                               <g:months>2</g:months>
                               <g:amount>' . $parcela . ' BRL</g:amount>
                            </g:installment>';
                }
            } else {
                if ($preco >= 50 and $preco <= 100) {
                    $parcela = $preco / 2;
                    echo '<g:installment>
                               <g:months>2</g:months>
                               <g:amount>' . $parcela . ' BRL</g:amount>
                            </g:installment>';
                }
            }

            echo '<g:brand>Reverbcity</g:brand>
                      <g:image_link>https://www.reverbcity.com' . $this->view->Url(['tipo' => "fotosprodutos", 'crop' => 1, 'largura' => 0, 'altura' => 0, 'imagem' => $foto_completa], "imagem", TRUE) . '</g:image_link>
                      <g:google_product_category>Vestuário e acessórios &gt; Roupas</g:google_product_category>
                      <g:product_type>' . $produto->DS_CATEGORIA_PCRC . '</g:product_type>
                      <g:gender>' . $genero . '</g:gender>
                      <g:age_group>adult</g:age_group>
                      <g:size>'.$size.'</g:size>
                      <g:color>' . $cor . '</g:color>
                    </item>';
        }
        echo '</channel>
            </rss>';
        header("Content-type: text/xml");

        die();
    }

//    public function testemailAction(){
//        $select = "SELECT
//                        *,
//                        (SELECT
//                                MAX(compras.DT_COMPRA_COSO)
//                            FROM
//                                compras
//                            WHERE
//                                compras.NR_SEQ_CADASTRO_COSO = c.cadastros_id) AS ultima
//                    FROM
//                        carrinho AS c
//                    WHERE
//                        hora > '2015-01-01'
//                    GROUP BY email_cadastro
//                    HAVING ultima < c.hora OR ultima IS NULL
//                    ORDER BY carrinho_id DESC";
//
//        $db = Zend_Db_Table::getDefaultAdapter();
//        $query = $db->query($select);
//        $lista = $query->fetchAll();
//
//        $body = "Olá, tudo bem?<br />
//                <br />
//                <br />
//                Vimos que você estava pensando em se vestir, mas sua turnê pelo nosso site parou no meio do caminho. <br />
//                <br />
//                <br />
//                Gostaríamos de saber o que aconteceu para você nos deixar assim, alguma coisa no nosso lineup não te agradou? <br />
//                <br />
//                <br />
//                Obrigado, <br />
//                Equipe Reverbcity<br />
//                <a href='https://www.reverbcity.com'>reverbcity.com</a>";
//
//        foreach($lista as $l){
//            $config = array(
//                'auth' => 'login',
//                'username' => "desenvolvimento@reverbcity.com",
//                'password' => "sebadoh90",
//                'ssl' => "ssl",
//                'port' => "465"
//            );
//            $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);
//
//            $emailAdm = "desenvolvimento@reverbcity.com";
//            $mail = new Zend_Mail('UTF-8');
//            $mail->setBodyHtml($body);
//            $mail->addTo($l['email_cadastro']);
//            $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
//            $mail->setReturnPath($emailAdm);
//            $mail->setSubject("Por que vc desistiu de se vestir de música? :(");
//            $mail->send($mailTransport);
//        }
//
//        exit;
//    }

    public function whatsSendAction() {
        set_time_limit(0);

        include APPLICATION_PATH . '/../library/Reverb/Library/whatsapi/src/whatsprot.class.php';

        function onGetProfilePicture($from, $target, $type, $data) {
            if ($type == "preview") {
                $filename = "preview_" . $target . ".jpg";
            } else {
                $filename = $target . ".jpg";
            }
            $filename = WhatsProt::PICTURES_FOLDER . "/" . $filename;
            $fp = @fopen($filename, "w");
            if ($fp) {
                fwrite($fp, $data);
                fclose($fp);
            }

            echo "- Profile picture saved in /" . WhatsProt::PICTURES_FOLDER . "\n";
        }

        function onPresenceReceived($username, $from, $type) {
            $dFrom = str_replace(array("@s.whatsapp.net", "@g.us"), "", $from);
            if ($type == "available")
                echo "<$dFrom is online>\n\n";
            else
                echo "<$dFrom is offline>\n\n";
        }

        $username = "554398344166";
        $password = "cj/GHHGSWZmVuKh0/v1ZrkXXZZc=";
        $identity = md5(554398344166);
        $nickname = "Reverbcity";
        $target = "554384754521";
        $debug = false;

        $w = new WhatsProt($username, $identity, $nickname, $debug);
        $w->connect();
        $w->loginWithPassword($password);
        $w->eventManager()->bind("onGetProfilePicture", "onGetProfilePicture");
        $w->eventManager()->bind("onPresence", "onPresenceReceived");
        $w->sendSetProfilePicture(APPLICATION_PATH . '/../library/Reverb/Library/whatsapi/examples/demo/toy.jpg');

        die();

        $selectCliente = "SELECT
                            REPLACE(CONCAT(CONCAT('55',
                                                IF(LEFT(DS_DDDCEL_CASO, 1) = 0,
                                                    SUBSTRING(DS_DDDCEL_CASO, 2),
                                                    DS_DDDCEL_CASO)),
                                        DS_CELULAR_CASO),
                                '-',
                                '') as celular,
                            nr_seq_cadastro_caso
                        FROM
                            cadastros
                        WHERE
                            DS_DDDCEL_CASO IS NOT NULL
                                AND DS_DDDCEL_CASO <> ''
                                AND DS_DDDCEL_CASO <> '-'
                                AND DS_DDDCEL_CASO <> '0'
                                AND DS_CELULAR_CASO IS NOT NULL
                                AND DS_CELULAR_CASO <> ''
                                AND DS_CELULAR_CASO <> '-'
                                AND DS_CELULAR_CASO <> '0'
                                AND DS_CELULAR_CASO NOT LIKE '%(%'
                                AND ds_tipo_caso <> 'PJ'
                                AND whats_enviado = 0
                        GROUP BY cadastros.NR_SEQ_CADASTRO_CASO";

        $db = Zend_Db_Table::getDefaultAdapter();
        $query = $db->query($selectCliente);
        $lista = $query->fetchAll();

        foreach ($lista as $cliente) {
            $atualizaCliente = "update cadastros set whats_enviado = 1 where nr_seq_cadastro_caso = " . $cliente['nr_seq_cadastro_caso'];
            $db->query($atualizaCliente);

            $w->sendGetProfilePicture($cliente['celular'], true);
            $w->sendMessage($cliente['celular'], "Não basta escutar música, é preciso viver de música! Agora a Reverbcity também está no whatsapp, o que você acha desta novidade?\n\nEm breve teremos várias coisas bacanas rolando por aqui, enquanto isso aproveite nossos descontos com camisetas a partir de R$19,90!");
            $w->sendMessage($cliente['celular'], "");
            $w->sendMessage($cliente['celular'], "http://rvb.la/Whatsapp");
        }

        die('enviados');
    }

    public function avisa30DescontoAction() {
        $modelContaCorrente = new Default_Model_Contascorrente();

        $selectContaCorrente = $modelContaCorrente->select()
                ->from(array('cc' => 'contacorrente'), array())
                ->join(array('c' => 'cadastros'), 'NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_CRSA', array())
                ->columns(array(
                    'cc.VL_LANCAMENTO_CRSA',
                    'c.DS_NOME_CASO',
                    'c.DS_EMAIL_CASO',
                    'celular' => "REPLACE(CONCAT(IF(LEFT(DS_DDDCEL_CASO, 1) = 0, SUBSTRING(DS_DDDCEL_CASO, 2), DS_DDDCEL_CASO), DS_CELULAR_CASO), '-', '')"
                ))
                ->where('NR_SEQ_COMPRA_CRSA IS NULL')
                ->where('ST_EXPIRADO_CRSA <> "S"')
                ->where('DATE_SUB(DATE_FORMAT(dt_vencimento_crsa, "%Y-%m-%d"), INTERVAL 1 MONTH) = DATE_FORMAT(NOW(), "%Y-%m-%d")')
                ->setIntegrityCheck(false);
        $dadosContaCorrente = $modelContaCorrente->fetchAll($selectContaCorrente);

        foreach ($dadosContaCorrente as $conta) {
            $htmlBody = '<table align="center"><tr><td>
            <table width="600" border="0" cellpadding="0" cellspacing="0">
                <tr><td colspan="2" height="4"><img src="http://www.reverbcity.com/imgrast/line1.gif" width="600" height="4" /></td></tr>
                <tr>
                    <td align="left" height="75"><a href="http://www.reverbcity.com"><img border="0" src="http://www.reverbcity.com/imgrast/logo.gif" width="235" height="75" /></a></td>
                    <td align="right" height="75">
                        <table width="150" cellpadding="0" cellspacing="0" height="25" border="0">
                            <tr>
                                <td><a href="http://instagram.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/rss.gif" width="26" height="25" /></a></td>
                                <td><a href="https://www.facebook.com/Reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/fb.gif" width="26" height="25" /></a></td>
                                <td><a href="https://twitter.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/twi.gif" width="26" height="25" /></a></td>
                                <td><a href="http://pinterest.com/reverbcity/pins/"><img border="0" src="http://www.reverbcity.com/imgrast/pin.gif" width="26" height="25" /></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2" height="5"><img src="http://www.reverbcity.com/imgrast/line2.gif" width="600" height="5" /></td></tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                         Seu crédito irá vencer em 30 dias!
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                <div style="width: 598px">
                    Olá ' . $conta->DS_NOME_CASO . ', <br />
                    <br />
                    Você tem um bônus de R$ ' . number_format($conta->VL_LANCAMENTO_CRSA, 2, ",", ".") . ' para serem usados na <a href="https://www.reverbcity.com/inicio">Reverbcity.com</a> que vão vencer daqui 30 dias. Não perca este desconto e faça um pedido agora mesmo.<br />
                    <br />
                    Para usar seus créditos é fácil! Basta você logar no site e colocar os itens desejados no seu carrinho, na hora de finalizar o pedido será aplicado automaticamente o desconto nos itens de PREÇO CHEIO que estiverem no seu carrinho, corre lá!<br />
                </div>
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';

            $config = array(
                'auth' => 'login',
                'username' => "desenvolvimento@reverbcity.com",
                'password' => "sebadoh90",
                'ssl' => "ssl",
                'port' => "465"
            );
            $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

            $emailAdm = "desenvolvimento@reverbcity.com";
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($htmlBody);
            $mail->addTo($conta->DS_EMAIL_CASO, $conta->DS_NOME_CASO);
            $mail->setFrom($emailAdm, "Reverbcity");
            $mail->setReturnPath($emailAdm);
            $mail->setSubject("Hey, seus créditos irão expirar!");
            $mail->send($mailTransport);

            $msg = "Ola, vc tem um bonus na Reverbcity.com que ja esta para expirar. Apos logar no site o desconto sera aplicado automaticamente";
            $url = "http://193.105.74.59/api/sendsms/plain?user=rbcity&password=rbcity123&sender=Reverbcity&GSM=55" . $conta->celular . "&SMStext=" . urlencode($msg);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            //curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, "UserID=".$UserID."&Token=".$Token."&NroDestino=".$celular."&Mensagem=".$msg."&Remetente=Reverbcity");
            curl_setopt($ch, CURLOPT_FAILONERROR, 0);

            $resultbusca = curl_exec($ch);
            curl_close($ch);
        }
        die();
    }

    public function avisa60DescontoAction() {
        $modelContaCorrente = new Default_Model_Contascorrente();

        $selectContaCorrente = $modelContaCorrente->select()
                ->from(array('cc' => 'contacorrente'), array())
                ->join(array('c' => 'cadastros'), 'NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_CRSA', array())
                ->columns(array(
                    'cc.VL_LANCAMENTO_CRSA',
                    'c.DS_NOME_CASO',
                    'c.DS_EMAIL_CASO',
                    'celular' => "REPLACE(CONCAT(IF(LEFT(DS_DDDCEL_CASO, 1) = 0, SUBSTRING(DS_DDDCEL_CASO, 2), DS_DDDCEL_CASO), DS_CELULAR_CASO), '-', '')"
                ))
                ->where('NR_SEQ_COMPRA_CRSA IS NULL')
                ->where('ST_EXPIRADO_CRSA <> "S"')
                ->where('DATE_SUB(DATE_FORMAT(dt_vencimento_crsa, "%Y-%m-%d"), INTERVAL 2 MONTH) = DATE_FORMAT(NOW(), "%Y-%m-%d")')
                ->setIntegrityCheck(false);
        $dadosContaCorrente = $modelContaCorrente->fetchAll($selectContaCorrente);

        foreach ($dadosContaCorrente as $conta) {
            $htmlBody = '<table align="center"><tr><td>
            <table width="600" border="0" cellpadding="0" cellspacing="0">
                <tr><td colspan="2" height="4"><img src="http://www.reverbcity.com/imgrast/line1.gif" width="600" height="4" /></td></tr>
                <tr>
                    <td align="left" height="75"><a href="http://www.reverbcity.com"><img border="0" src="http://www.reverbcity.com/imgrast/logo.gif" width="235" height="75" /></a></td>
                    <td align="right" height="75">
                        <table width="150" cellpadding="0" cellspacing="0" height="25" border="0">
                            <tr>
                                <td><a href="http://instagram.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/rss.gif" width="26" height="25" /></a></td>
                                <td><a href="https://www.facebook.com/Reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/fb.gif" width="26" height="25" /></a></td>
                                <td><a href="https://twitter.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/twi.gif" width="26" height="25" /></a></td>
                                <td><a href="http://pinterest.com/reverbcity/pins/"><img border="0" src="http://www.reverbcity.com/imgrast/pin.gif" width="26" height="25" /></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2" height="5"><img src="http://www.reverbcity.com/imgrast/line2.gif" width="600" height="5" /></td></tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                         Seu crédito irá vencer em 60 dias!
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                <div style="width: 598px">
                    Olá ' . $conta->DS_NOME_CASO . ', <br />
                    <br />
                    Você tem um bônus de R$ ' . number_format($conta->VL_LANCAMENTO_CRSA, 2, ",", ".") . ' para serem usados na <a href="https://www.reverbcity.com/inicio">Reverbcity.com</a> que vão vencer daqui 60 dias. Não perca este desconto e faça um pedido agora mesmo.<br />
                    <br />
                    Para usar seus créditos é fácil! Basta você logar no site e colocar os itens desejados no seu carrinho, na hora de finalizar o pedido será aplicado automaticamente o desconto nos itens de PREÇO CHEIO que estiverem no seu carrinho, corre lá!<br />
                </div>
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';

            $config = array(
                'auth' => 'login',
                'username' => "desenvolvimento@reverbcity.com",
                'password' => "sebadoh90",
                'ssl' => "ssl",
                'port' => "465"
            );
            $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

            $emailAdm = "desenvolvimento@reverbcity.com";
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($htmlBody);
            $mail->addTo($conta->DS_EMAIL_CASO, $conta->DS_NOME_CASO);
            $mail->setFrom($emailAdm, "Reverbcity");
            $mail->setReturnPath($emailAdm);
            $mail->setSubject("Hey, seus créditos irão expirar!");
            $mail->send($mailTransport);

            $msg = "Ola, vc tem um bonus na Reverbcity.com que ja esta para expirar. Apos logar no site o desconto sera aplicado automaticamente";
            $url = "http://193.105.74.59/api/sendsms/plain?user=rbcity&password=rbcity123&sender=Reverbcity&GSM=55" . $conta->celular . "&SMStext=" . urlencode($msg);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            //curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, "UserID=".$UserID."&Token=".$Token."&NroDestino=".$celular."&Mensagem=".$msg."&Remetente=Reverbcity");
            curl_setopt($ch, CURLOPT_FAILONERROR, 0);

            $resultbusca = curl_exec($ch);
            curl_close($ch);
        }
        die();
    }

}
