<?php

/**
 *
 */
class LojaController extends Zend_Controller_Action {

    /**
     *
     */
    public function init() {

        //Zend_Debug::dump(mb_detect_encoding('nÃ©h')); exit;
        /* Initialize action controller here */
//        $captcha = new Zend_Captcha_Image(); // Este é o nome da classe, no secrets...
//        $captcha->setWordlen(3) // quantidade de letras, tente inserir outros valores
//                ->setImgDir(APPLICATION_PATH . '/../arquivos/uploads/captcha')// o caminho para armazenar as imagens
//                ->setGcFreq(10)//especifica a cada quantas vezes o garbage collector vai rodar para eliminar as imagens inválidas
//                ->setExpiration(500)// tempo de expiração em segundos.
//                ->setHeight(80) // tamanho da imagem de captcha
//                ->setWidth(130)// largura da imagem
//                ->setLineNoiseLevel(1) // o nivel das linhas, quanto maior, mais dificil fica a leitura
//                ->setDotNoiseLevel(1)// nivel dos pontos, experimente valores maiores
//                ->setFontSize(15)//tamanho da fonte em pixels
//                ->setFont(APPLICATION_PATH . '/../arquivos/default/fonts/andes-regular.ttf'); // caminho para a fonte a ser usada
//        $this->view->idCaptcha = $captcha->generate(); // passamos aqui o id do captcha para a view
//        $this->view->captcha = $captcha->render($this->view); // e o proprio captcha para a view
    }

    /**
     *
     */
    public function indexAction() {


        $this->view->title = "Camisetas de bandas de rock, bones e posters - Reverbcity.com";
        $this->view->description = "Na Loja Reverbcity você encontra diversas camisetas de rock, bones, canecas, posters e muito mais!";
        $this->view->keywords = "Reverbcity, camisetas de bandas de rock, camisetas rock, camisetas personalizadas, camisetas indie";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        $usuarios->lock();
        //se por PJ redireciona

        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");

        $campanhas = new Zend_Session_Namespace("campanhas");
        //pego a url da campanha
        $endereco = $_SERVER ['REQUEST_URI'];
        //pego o id da campanha
        $parametro = explode("=", $endereco);

        //verifico se existe parametro 
        if ($parametro[1] != "") {
            //adiciono a campanha a sessão
            $campanhas->idcampanha = $parametro[1];
            $campanhas->lock();
        }



        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()
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
                    'DS_CORES_PRRC',
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");

        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } else if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }

        if ($categoria != "") {
            $select_produtos->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);

            if ($categoria == 190) {
                $select_produtos->order('DS_PRODUTO_PRRC ASC');
            }

            $modelProdutoCategoria = new Default_Model_Produtoscategoria();
            $dadosProdutoCategoria = $modelProdutoCategoria->fetchRow(array('NR_SEQ_CATEGPRO_PCRC = ?' => $categoria))->toArray();

            $this->view->title = $dadosProdutoCategoria['title'];
            $this->view->description = $dadosProdutoCategoria['description'];
            $this->view->keywords = $dadosProdutoCategoria['keywords'];
            $this->view->categoria_nome = $dadosProdutoCategoria['DS_CATEGORIA_PCRC'];

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
        } elseif ($genero == "feminino") {
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
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "p") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 2 or NR_SEQ_TAMANHO_TARC = 7");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "m") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 3 or NR_SEQ_TAMANHO_TARC = 8");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "g") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 4 or NR_SEQ_TAMANHO_TARC = 9");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "gg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 5 or NR_SEQ_TAMANHO_TARC = 10");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "xgg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 33");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        }

        //agrupo por codigo do produto
        $select_produtos->group("NR_SEQ_PRODUTO_PRRC")
                //ordeno pela ordem de ordenacao de produtos
                ->order("NR_ORDEM_PRRC ASC");

        // crio a paginação para proximo e para anterior
//            $paginator = new Reverb_Paginator($select_produtos);
//            //defino a quantidade de itens por pagina
//            $paginator->setItemCountPerPage(16)
//                //defino a quantidade de paginas
//                ->setPageRange(5)
//                //recebo o numero da pagina
//                ->setCurrentPageNumber($this->_getParam('page'));
//            
//            //atribuo ovalor a variavel
//            $pages = $paginator->getPages();
//            //crio o array de paginas
//            $pageArray = get_object_vars($pages);
//
//            //assino
//            $this->view->assign('pages', $pageArray);
        // crio paginacao com numeros
        $current_page = $this->_request->getParam("page", 1);
        //passo para o paginador o select de produtos
        $contador = new Reverb_Paginator($select_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(20)
                //pega o numero da pagina
                ->setCurrentPageNumber($current_page)
                //defino quantas páginas iram aparecer por vez
                ->setPageRange(5)
                //assino a paginacao
                ->assign();

        //assino ao view
        $this->view->contadores = $contador;

        /*
         * aqui inicio o filtro dinamico
         */
        $model_menu = new Default_Model_Menusite();

        //consulta para os tipos
        $select_tipos = $model_menu->select()
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
        } elseif ($valor == 30) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }

        //agora agrupo
        $select_tipos->group("NR_SEQ_CATEGPRO_PTRC");

        $idCache = md5((string) $select_tipos);

        $lista_tipos = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_tipos) {

            //crio uma lista de tipo
            $lista_tipos = $model_menu->fetchAll($select_tipos)->toArray();

            Zend_Registry::get("cache")->save($lista_tipos, $idCache);
        }

        //assino os amigos ao view
        $this->view->tipos = $lista_tipos;

        //inicio a consulta das categoria
        $select_categorias = $model_menu->select()
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_produtos_categoria", "menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu")
                //faço outro join
                ->joinInner("produtos_categoria", "menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("NR_SEQ_CATEGPRO_PCRC", "DS_CATEGORIA_PCRC"))
                //faço o join de produtos para ver quais categorias tem novidades
                ->joinInner("produtos", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("TP_DESTAQUE_PRRC"))
                //agora faço as condições
                ->where("DS_STATUS_PCRC = 'A'")
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        //se tiver uma cor selecionada
        //se tiver um tipo de produto selecionado
        if ($tipo != "") {
            $select_categorias->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
        if ($valor == 29.90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        } elseif ($valor == 30) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($cor != "") {
            //se tiver cor selecionada coloco no filtro
            $select_categorias->where("NR_SEQ_COR_PRRC = " . $cor);
        }

        //agora agrupo
        $select_categorias->group("NR_SEQ_CATEGPRO_PCRC");
        $select_categorias->order('DS_CATEGORIA_PCRC ASC');

        $idCache = md5((string) $select_categorias);

        $lista_categoria = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_categoria) {
            //crio uma lista de categorias
            $lista_categoria = $model_menu->fetchAll($select_categorias)->toArray();

            Zend_Registry::get("cache")->save($lista_categoria, $idCache);
        }

        //assino as categorias ao view
        $this->view->categorias = $lista_categoria;

        //inicio a query de cores(
        $select_cor = $model_menu->select()
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_cores", "menu_site.idmenu = menu_site_has_cores.menu_site_idmenu")
                //faço outro join
                ->joinInner("cores", "menu_site_has_cores.cores_idcor = cores.idcor")
                //faço outro join
                ->joinInner("produtos", "cores.idcor = produtos.NR_SEQ_COR_PRRC", array("NR_SEQ_COR_PRRC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
        if ($categoria != "") {
            $select_cor->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);
        }
        //se tiver um valor relacionado
        if ($valor == 29.90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        } elseif ($valor == 30) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }

        //agora faço as condições
        $select_cor->group("idcor");

        $idCache = md5((string) $select_cor);

        $lista_cores = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_cores) {
            //crio uma lista de categorias
            $lista_cores = $model_menu->fetchAll($select_cor)->toArray();

            Zend_Registry::get("cache")->save($lista_cores, $idCache);
        }

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

        $cacheBannerTopo87 = "cacheBannerTopo87";

        $lista_banner_topo = Zend_Registry::get("cache")->load($cacheBannerTopo87);

        // Se nao existir o cache faz consulta
        if (!$lista_banner_topo) {

            //inicio o model de banners
            $model_banner = new Default_Model_Banners();

            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_banner_topo = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 87")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->order("DT_CADASTRO_BARC DESC");
            $lista_banner_topo = $model_banner->fetchAll($select_banner_topo);
        }

        $title = array();
        if (!empty($tipo)) {
            $db = Zend_Registry::get("db");
            //crio a query de categorias
            $selectTipo = "SELECT
							DS_CATEGORIA_PTRC

						FROM
						    produtos_tipo
						WHERE
							NR_SEQ_CATEGPRO_PTRC = '" . addslashes($tipo) . "'";

            $query_tipo = $db->query($selectTipo);
            $row_tipo = $query_tipo->fetchAll();
            $title[0] = $row_tipo[0]['DS_CATEGORIA_PTRC'];
        }

        if (!empty($categoria)) {
            $title[1] = $dadosProdutoCategoria['DS_CATEGORIA_PCRC'];
        }

        if (!empty($genero)) {
            $title[2] = ucfirst(substr_replace($genero, 'as', -1));
        }

        if (!empty($valor)) {
            if ($valor == 29.90) {
                $title[3] = 'até R$29,90';
            } elseif ($valor == 30) {
                $title[3] = 'de R$30,00 até R$60,00';
            } elseif ($valor == 61) {
                $title[3] = 'de R$61,00 até R$89,90';
            } elseif ($valor == 90) {
                $title[3] = 'a partir de R$90,00';
            }
        }

        if (count($title) > 0) {
            $this->view->title = implode(' ', $title) . ' - Reverbcity.com';
        }


        //Assino ao view
        $this->view->banners_topo = $lista_banner_topo;
    }

    /**
     *
     */
    public function estilosMusicaisAction() {


        $this->view->title = "Estilos musicais - Reverbcity.com";
        $this->view->description = "No nosso shop online você compra nossas camisetas e muito mais!";
        $this->view->keywords = "Reverbcity, shop, compra, camisetas, indie, rock,  bandas";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");

        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");

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

        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()
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
                    'DS_CORES_PRRC',
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");

        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
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
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
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
                ->order("NR_ORDEM_PRRC ASC");

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($select_produtos);
        //defino a quantidade de itens por pagina
        $paginator->setItemCountPerPage(16)
                //defino a quantidade de paginas
                ->setPageRange(5)
                //recebo o numero da pagina
                ->setCurrentPageNumber($this->_getParam('page'));
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
         * aqui inicio o filtro dinamico
         */

        $model_menu = new Default_Model_Menusite();

        //consulta para os tipos
        $select_tipos = $model_menu->select()
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
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_produtos_categoria", "menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu")
                //faço outro join
                ->joinInner("produtos_categoria", "menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("NR_SEQ_CATEGPRO_PCRC", "DS_CATEGORIA_PCRC"))
                //faço o join de produtos para ver quais categorias tem novidades
                ->joinInner("produtos", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("TP_DESTAQUE_PRRC"))
                //agora faço as condições
                ->where("DS_STATUS_PCRC = 'A'")
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        //se tiver uma cor selecionada
        //se tiver um tipo de produto selecionado
        if ($tipo != "") {
            $select_categorias->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
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
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($cor != "") {
            //se tiver cor selecionada coloco no filtro
            $select_categorias->where("NR_SEQ_COR_PRRC = " . $cor);
        }

        //agora agrupo
        $select_categorias->group("NR_SEQ_CATEGPRO_PCRC");

        //crio uma lista de categorias
        $lista_categoria = $model_menu->fetchAll($select_categorias)->toArray();

        //assino as categorias ao view
        $this->view->categorias = $lista_categoria;

        //inicio a query de cores(
        $select_cor = $model_menu->select()
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_cores", "menu_site.idmenu = menu_site_has_cores.menu_site_idmenu")
                //faço outro join
                ->joinInner("cores", "menu_site_has_cores.cores_idcor = cores.idcor")
                //faço outro join
                ->joinInner("produtos", "cores.idcor = produtos.NR_SEQ_COR_PRRC", array("NR_SEQ_COR_PRRC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
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
    public function novidadesAction() {

        $this->view->title = "Novidades e Lançamentos - Reverbcity.com";
        $this->view->description = "Veja os últimos lançamentos da Reverbcity";
        $this->view->keywords = "Reverbcity, camisetas, novidades, loja de rock, compra online, bandas, indie, rock";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");

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
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //onde e tipo de destaque = 3 (novidades)
                ->where("TP_DESTAQUE_PRRC in (1,4)");
        //removo os buttons
//                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //agrupo por codigo do produto
        $select_produtos->group("NR_SEQ_PRODUTO_PRRC");
        //agora coloco as condições da url, dependendo dos parametros
        //se tiver uma cor selecionada
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
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
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");

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
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
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
                ->order(array(
                    'NR_ORDEM_LCTO_PRRC ASC',
                    'DT_CADASTRO_PRRC desc'
        ));

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($select_produtos);
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
        $contador = new Reverb_Paginator($select_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(20)
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
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
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
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
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
     * Crio a Funcao que lista os produtos masculino
     */
    public function masculinoAction() {

        $this->view->title = "Camisetas Masculinas - Reverbcity.com";
        $this->view->description = "Os meninos usam as camisetas da Reverbcity e muito mais";
        $this->view->keywords = "Reverbcity, camisetas personalizadas, camiseta de bandas, camisetas rock, camisetas indie, masculino";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $valor = $this->_request->getParam("valor");

        $campanhas = new Zend_Session_Namespace("campanhas");
        //pego a url da campanha
        $endereco = $_SERVER['REQUEST_URI'];
        //pego o id da campanha
        $parametro = explode("=", $endereco);
        //verifico se existe parametro 
        if ($parametro[1] != "") {
            //adiciono a campanha a sessão
            $campanhas->idcampanha = $parametro[1];
        }


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
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //onde e tipo de destaque = 3 (novidades)
                ->where("DS_GENERO_PRRC = 'M'")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
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
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
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
                ->where("DS_GENERO_PRRC = 'M'")
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
                ->where("DS_GENERO_PRRC = 'M'")
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
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($tipo != "") {
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
                //somente onde tiver produtos com destaque masculino
                ->where("DS_GENERO_PRRC = 'M'")
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
    public function femininoAction() {

        $this->view->title = "Camisetas Femininas - Reverbcity.com";
        $this->view->description = "As meninas usam as camisetas da Reverbcity e muito mais";
        $this->view->keywords = "Reverbcity, camisetas personalizadas, camiseta de bandas, camisetas rock, camisetas indie, feminino";


        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
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
                    'VL_PROMO_PRRC',
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //onde e tipo de destaque = 3 (novidades)
                ->where("DS_GENERO_PRRC = 'F'")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }

        if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }        
        if ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
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
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
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
                ->where("DS_GENERO_PRRC = 'M'")
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
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($tipo != "") {
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
        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = ?", $tipo);
        }
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
    public function acessoriosAction() {




        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }


        $this->view->title = "Acessórios - Reverbcity.com";
        $this->view->description = "Você já vestiu de música? Se as pessoas passam boa parte da vida escutando música, por que não carregar toda essa paixão em suas camisetas também? É assim que funciona a Reverbcity.";
        $this->view->keywords = "Reverbcity, acessorios, unisex, shop, compra online, bandas, indie, rock";

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $valor = $this->_request->getParam("valor");

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
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //onde e tipo de destaque = 3 (novidades)
                ->where("TP_DESTAQUE_PRRC = 1")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59,6)");
        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }        
        if ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
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
    public function casaAction() {


        $this->view->title = "Posters, Copos e Canecas - Reverbcity.com";
        $this->view->description = "A sua casa também pode se decorar de música";
        $this->view->keywords = "Reverbcity, moda rock, loja de rock, camisetas personalisadas";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $valor = $this->_request->getParam("valor");

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
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC = 52");
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
                //somente onde tiver produtos com destaque
                ->where("NR_SEQ_TIPO_PRRC in (52)")
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
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
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
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
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }

        //agora agrupo
        $select_tipos->group("NR_SEQ_CATEGPRO_PTRC");

        //crio uma lista de tipo
        $lista_tipos = $model_menu->fetchAll($select_tipos)->toArray();

        //assino os amigos ao view
        $this->view->tipos = $lista_tipo;


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
                ->where("NR_SEQ_CATEGORIA_PRRC in (57,173)")
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
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
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
                //somente onde tiver produtos com destaque de casa
                ->where("NR_SEQ_CATEGORIA_PRRC in (57,173)")
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
    public function saleAction() {

        $this->view->title = "Desconto e promoções - Reverbcity.com";
        $this->view->description = "Aqui você encontra todos os nossos itens que estão com descontos!";
        $this->view->keywords = "Reverbcity, sale, desconto, promoção, liquidação";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");

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
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //onde e tipo de destaque = 3 (novidades)
                ->where("TP_DESTAQUE_PRRC = 2")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
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
            $select_produtos->where("DS_CORES_PRRC = " . $cor);
            //assino ao view a categoria
            $this->view->cor_url = $cor;
        }
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
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
//                ->order(array(
//                    'NR_ORDEM_SALE_PRRC ASC',
//                    'DT_CADASTRO_PRRC desc ',
//                ));
                ->order('VL_PROMO_PRRC ASC');
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
        $contador->setItemCountPerPage(20)
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
                ->where("TP_DESTAQUE_PRRC = '2'")
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
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($tipo != "") {
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
                //somente onde tiver produtos com destaque de casa
                ->where("TP_DESTAQUE_PRRC = '2'")
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
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = ?", $tipo);
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
    public function raglansMoletomAction() {

        $this->view->title = "Raglans e Moletom - Reverbcity.com";
        $this->view->description = "Aqui você encontra todos os nossos itens que estão com descontos!";
        $this->view->keywords = "Reverbcity, sale, desconto, promoção, liquidação";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");

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
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0")
                //onde e tipo de destaque = 3 (novidades)
                //->where("TP_DESTAQUE_PRRC = 2")
                ->where('NR_SEQ_CATEGORIA_PRRC IN(187,49)')
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }        
        if ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
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
            $select_produtos->where("DS_CORES_PRRC = " . $cor);
            //assino ao view a categoria
            $this->view->cor_url = $cor;
        }
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
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
                ->where("DS_GENERO_PRRC = 'M'")
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
                ->where("TP_DESTAQUE_PRRC = '2'")
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
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($tipo != "") {
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
                //somente onde tiver produtos com destaque de casa
                ->where("TP_DESTAQUE_PRRC = '2'")
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
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = ?", $tipo);
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
    public function todosProdutosAction() {
        $this->view->title = "Camisetas de bandas, filmes e series - Reverbcity.com";
        $this->view->description = "Na Reverbcity você encontra diversas camisetas de bandas de rock, camisetas de filmes, camisetas de series e muito mais!";
        $this->view->keywords = "Reverbcity, camisetas de bandas de rock, camisetas filmes, series";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        $usuarios->lock();
        //se por PJ redireciona

        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");

        $campanhas = new Zend_Session_Namespace("campanhas");
        //pego a url da campanha
        $endereco = $_SERVER ['REQUEST_URI'];
        //pego o id da campanha
        $parametro = explode("=", $endereco);

        //verifico se existe parametro
        if ($parametro[1] != "") {
            //adiciono a campanha a sessão
            $campanhas->idcampanha = $parametro[1];
            $campanhas->lock();
        }



        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()
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
                    'DS_CORES_PRRC',
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                ->joinInner("produtos_categoria", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array())
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
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");

        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } else if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }elseif ($valor == 59) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC = 59, VL_PROMO_PRRC = 59)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } 
        if ($categoria != "") {
            $select_produtos->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);

            if ($categoria == 190) {
                $select_produtos->order('DS_PRODUTO_PRRC ASC');
            }

            $modelProdutoCategoria = new Default_Model_Produtoscategoria();
            $dadosProdutoCategoria = $modelProdutoCategoria->fetchRow(array('NR_SEQ_CATEGPRO_PCRC = ?' => $categoria))->toArray();

            $this->view->title = $dadosProdutoCategoria['title'];
            $this->view->description = $dadosProdutoCategoria['description'];
            $this->view->keywords = $dadosProdutoCategoria['keywords'];
            $this->view->categoria_nome = $dadosProdutoCategoria['DS_CATEGORIA_PCRC'];

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
        } elseif ($genero == "feminino") {
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
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "p") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 2 or NR_SEQ_TAMANHO_TARC = 7");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "m") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 3 or NR_SEQ_TAMANHO_TARC = 8");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "g") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 4 or NR_SEQ_TAMANHO_TARC = 9");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "gg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 5 or NR_SEQ_TAMANHO_TARC = 10");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "xgg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 33");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        }

        //agrupo por codigo do produto
        $select_produtos->group("NR_SEQ_PRODUTO_PRRC")
                //ordeno pela ordem de ordenacao de produtos
                ->order(array(
                    //"DS_CATEGORIA_PCRC ASC",
                    'NR_ORDEM_TODOS_PRRC ASC'
        ));

        // crio a paginação para proximo e para anterior
//            $paginator = new Reverb_Paginator($select_produtos);
//            //defino a quantidade de itens por pagina
//            $paginator->setItemCountPerPage(16)
//                //defino a quantidade de paginas
//                ->setPageRange(5)
//                //recebo o numero da pagina
//                ->setCurrentPageNumber($this->_getParam('page'));
//
//            //atribuo ovalor a variavel
//            $pages = $paginator->getPages();
//            //crio o array de paginas
//            $pageArray = get_object_vars($pages);
//
//            //assino
//            $this->view->assign('pages', $pageArray);
        // crio paginacao com numeros
        $current_page = $this->_request->getParam("page", 1);
        //passo para o paginador o select de produtos
        $contador = new Reverb_Paginator($select_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(20)
                //pega o numero da pagina
                ->setCurrentPageNumber($current_page)
                //defino quantas páginas iram aparecer por vez
                ->setPageRange(5)
                //assino a paginacao
                ->assign();

        //assino ao view
        $this->view->contadores = $contador;

        /*
         * aqui inicio o filtro dinamico
         */
        $model_menu = new Default_Model_Menusite();

        //consulta para os tipos
        $select_tipos = $model_menu->select()
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
        } elseif ($valor == 30) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }

        //agora agrupo
        $select_tipos->group("NR_SEQ_CATEGPRO_PTRC");

        $idCache = md5((string) $select_tipos);

        $lista_tipos = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_tipos) {

            //crio uma lista de tipo
            $lista_tipos = $model_menu->fetchAll($select_tipos)->toArray();

            Zend_Registry::get("cache")->save($lista_tipos, $idCache);
        }

        //assino os amigos ao view
        $this->view->tipos = $lista_tipos;

        //inicio a consulta das categoria
        $select_categorias = $model_menu->select()
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_produtos_categoria", "menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu")
                //faço outro join
                ->joinInner("produtos_categoria", "menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("NR_SEQ_CATEGPRO_PCRC", "DS_CATEGORIA_PCRC"))
                //faço o join de produtos para ver quais categorias tem novidades
                ->joinInner("produtos", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("TP_DESTAQUE_PRRC"))
                //agora faço as condições
                ->where("DS_STATUS_PCRC = 'A'")
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        //se tiver uma cor selecionada
        //se tiver um tipo de produto selecionado
        if ($tipo != "") {
            $select_categorias->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
        if ($valor == 29.90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        } elseif ($valor == 30) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($cor != "") {
            //se tiver cor selecionada coloco no filtro
            $select_categorias->where("NR_SEQ_COR_PRRC = " . $cor);
        }

        //agora agrupo
        $select_categorias->group("NR_SEQ_CATEGPRO_PCRC");
        $select_categorias->order('DS_CATEGORIA_PCRC ASC');

        $idCache = md5((string) $select_categorias);

        $lista_categoria = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_categoria) {
            //crio uma lista de categorias
            $lista_categoria = $model_menu->fetchAll($select_categorias)->toArray();

            Zend_Registry::get("cache")->save($lista_categoria, $idCache);
        }

        //assino as categorias ao view
        $this->view->categorias = $lista_categoria;

        //inicio a query de cores(
        $select_cor = $model_menu->select()
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_cores", "menu_site.idmenu = menu_site_has_cores.menu_site_idmenu")
                //faço outro join
                ->joinInner("cores", "menu_site_has_cores.cores_idcor = cores.idcor")
                //faço outro join
                ->joinInner("produtos", "cores.idcor = produtos.NR_SEQ_COR_PRRC", array("NR_SEQ_COR_PRRC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
        if ($categoria != "") {
            $select_cor->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);
        }
        //se tiver um valor relacionado
        if ($valor == 29.90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        } elseif ($valor == 30) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }

        //agora faço as condições
        $select_cor->group("idcor");

        $idCache = md5((string) $select_cor);

        $lista_cores = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_cores) {
            //crio uma lista de categorias
            $lista_cores = $model_menu->fetchAll($select_cor)->toArray();

            Zend_Registry::get("cache")->save($lista_cores, $idCache);
        }

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

        $cacheBannerTopo87 = "cacheBannerTopo87";

        $lista_banner_topo = Zend_Registry::get("cache")->load($cacheBannerTopo87);

        // Se nao existir o cache faz consulta
        if (!$lista_banner_topo) {

            //inicio o model de banners
            $model_banner = new Default_Model_Banners();

            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_banner_topo = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 87")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->order("DT_CADASTRO_BARC DESC");
            $lista_banner_topo = $model_banner->fetchAll($select_banner_topo);
        }

        //Assino ao view
        $this->view->banners_topo = $lista_banner_topo;
    }

    /**
     *
     */
    public function lollapaloozaAction() {
        $this->view->title = "Camisetas Lollapalooza 2015 - Reverbcity.com";
        $this->view->description = "16 camisetas de bandas para o lollapalooza 2015, vista se de música com estampas exclusivas da Reverbcity.com!";
        $this->view->keywords = "Reverbcity, camisetas lollapalooza, lollapalooza 2015, camisetas de bandas de rock, camisetas filmes, series";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        $usuarios->lock();
        //se por PJ redireciona

        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        $tipo = $this->_request->getParam("tipo");
        $valor = $this->_request->getParam("valor");

        $campanhas = new Zend_Session_Namespace("campanhas");
        //pego a url da campanha
        $endereco = $_SERVER ['REQUEST_URI'];
        //pego o id da campanha
        $parametro = explode("=", $endereco);

        //verifico se existe parametro
        if ($parametro[1] != "") {
            //adiciono a campanha a sessão
            $campanhas->idcampanha = $parametro[1];
            $campanhas->lock();
        }



        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()
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
                    'DS_CORES_PRRC',
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                ->joinInner("produtos_categoria", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array())
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
                ->where("NR_SEQ_PRODUTO_PRRC in (590, 4919, 591, 4677, 524, 4642, 2488, 5778, 5656, 5657, 5777, 5776, 5775, 5774, 4944, 527, 4947, 4504)");

        //agora coloco as condições da url, dependendo dos parametros
        if ($valor == 19.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 19.90, VL_PROMO_PRRC <= 19.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } else if ($valor == 29.90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 30) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 61) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        } elseif ($valor == 90) {
            $select_produtos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
            //assino ao view a categoria
            $this->view->valor_url = $valor;
        }
        if ($categoria != "") {
            $select_produtos->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);

            if ($categoria == 190) {
                $select_produtos->order('DS_PRODUTO_PRRC ASC');
            }

            $modelProdutoCategoria = new Default_Model_Produtoscategoria();
            $dadosProdutoCategoria = $modelProdutoCategoria->fetchRow(array('NR_SEQ_CATEGPRO_PCRC = ?' => $categoria))->toArray();

            $this->view->title = $dadosProdutoCategoria['title'];
            $this->view->description = $dadosProdutoCategoria['description'];
            $this->view->keywords = $dadosProdutoCategoria['keywords'];
            $this->view->categoria_nome = $dadosProdutoCategoria['DS_CATEGORIA_PCRC'];

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
        } elseif ($genero == "feminino") {
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
        //se o tamanho do produto for pp
        if ($tamanho == "pp") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 1 or NR_SEQ_TAMANHO_TARC = 6");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "p") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 2 or NR_SEQ_TAMANHO_TARC = 7");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "m") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 3 or NR_SEQ_TAMANHO_TARC = 8");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "g") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 4 or NR_SEQ_TAMANHO_TARC = 9");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "gg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 5 or NR_SEQ_TAMANHO_TARC = 10");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        } elseif ($tamanho == "xgg") {
            $select_produtos->where("NR_SEQ_TAMANHO_TARC = 33");
            //assino ao view a categoria
            $this->view->tamanho_url = $tamanho;
        }

        //agrupo por codigo do produto
        $select_produtos->group("NR_SEQ_PRODUTO_PRRC")
                //ordeno pela ordem de ordenacao de produtos
                ->order(array(
                    //"DS_CATEGORIA_PCRC ASC",
                    'NR_ORDEM_TODOS_PRRC ASC'
        ));

        // crio a paginação para proximo e para anterior
//            $paginator = new Reverb_Paginator($select_produtos);
//            //defino a quantidade de itens por pagina
//            $paginator->setItemCountPerPage(16)
//                //defino a quantidade de paginas
//                ->setPageRange(5)
//                //recebo o numero da pagina
//                ->setCurrentPageNumber($this->_getParam('page'));
//
//            //atribuo ovalor a variavel
//            $pages = $paginator->getPages();
//            //crio o array de paginas
//            $pageArray = get_object_vars($pages);
//
//            //assino
//            $this->view->assign('pages', $pageArray);
        // crio paginacao com numeros
        $current_page = $this->_request->getParam("page", 1);
        //passo para o paginador o select de produtos
        $contador = new Reverb_Paginator($select_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(20)
                //pega o numero da pagina
                ->setCurrentPageNumber($current_page)
                //defino quantas páginas iram aparecer por vez
                ->setPageRange(5)
                //assino a paginacao
                ->assign();

        //assino ao view
        $this->view->contadores = $contador;

        /*
         * aqui inicio o filtro dinamico
         */
        $model_menu = new Default_Model_Menusite();

        //consulta para os tipos
        $select_tipos = $model_menu->select()
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
        } elseif ($valor == 30) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_tipos->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }

        //agora agrupo
        $select_tipos->group("NR_SEQ_CATEGPRO_PTRC");

        $idCache = md5((string) $select_tipos);

        $lista_tipos = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_tipos) {

            //crio uma lista de tipo
            $lista_tipos = $model_menu->fetchAll($select_tipos)->toArray();

            Zend_Registry::get("cache")->save($lista_tipos, $idCache);
        }

        //assino os amigos ao view
        $this->view->tipos = $lista_tipos;

        //inicio a consulta das categoria
        $select_categorias = $model_menu->select()
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_produtos_categoria", "menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu")
                //faço outro join
                ->joinInner("produtos_categoria", "menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("NR_SEQ_CATEGPRO_PCRC", "DS_CATEGORIA_PCRC"))
                //faço o join de produtos para ver quais categorias tem novidades
                ->joinInner("produtos", "produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC", array("TP_DESTAQUE_PRRC"))
                //agora faço as condições
                ->where("DS_STATUS_PCRC = 'A'")
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        //se tiver uma cor selecionada
        //se tiver um tipo de produto selecionado
        if ($tipo != "") {
            $select_categorias->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
        if ($valor == 29.90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        } elseif ($valor == 30) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_categorias->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }
        if ($cor != "") {
            //se tiver cor selecionada coloco no filtro
            $select_categorias->where("NR_SEQ_COR_PRRC = " . $cor);
        }

        //agora agrupo
        $select_categorias->group("NR_SEQ_CATEGPRO_PCRC");
        $select_categorias->order('DS_CATEGORIA_PCRC ASC');

        $idCache = md5((string) $select_categorias);

        $lista_categoria = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_categoria) {
            //crio uma lista de categorias
            $lista_categoria = $model_menu->fetchAll($select_categorias)->toArray();

            Zend_Registry::get("cache")->save($lista_categoria, $idCache);
        }

        //assino as categorias ao view
        $this->view->categorias = $lista_categoria;

        //inicio a query de cores(
        $select_cor = $model_menu->select()
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('menu_site', array("idmenu"))
                //faço o join
                ->joinInner("menu_site_has_cores", "menu_site.idmenu = menu_site_has_cores.menu_site_idmenu")
                //faço outro join
                ->joinInner("cores", "menu_site_has_cores.cores_idcor = cores.idcor")
                //faço outro join
                ->joinInner("produtos", "cores.idcor = produtos.NR_SEQ_COR_PRRC", array("NR_SEQ_COR_PRRC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'");

        if ($tipo != "") {
            $select_cor->where("NR_SEQ_TIPO_PRRC = " . $tipo);
        }
        if ($categoria != "") {
            $select_cor->where("NR_SEQ_CATEGORIA_PRRC = " . $categoria);
        }
        //se tiver um valor relacionado
        if ($valor == 29.90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC <= 29.90, VL_PROMO_PRRC <= 29.90)");
        } elseif ($valor == 30) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 30 and 60 , VL_PROMO_PRRC BETWEEN 30 and 60)");
        } elseif ($valor == 61) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC BETWEEN 61 and 90 , VL_PROMO_PRRC BETWEEN 61 and 90)");
        } elseif ($valor == 90) {
            $select_cor->where("IF(VL_PROMO_PRRC <= 0, VL_PRODUTO_PRRC > 90, VL_PROMO_PRRC > 90)");
        }

        //agora faço as condições
        $select_cor->group("idcor");

        $idCache = md5((string) $select_cor);

        $lista_cores = Zend_Registry::get("cache")->load($idCache);

        // Se nao existir o cache faz consulta
        if (!$lista_cores) {
            //crio uma lista de categorias
            $lista_cores = $model_menu->fetchAll($select_cor)->toArray();

            Zend_Registry::get("cache")->save($lista_cores, $idCache);
        }

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

        $cacheBannerTopo87 = "cacheBannerTopo87";

        $lista_banner_topo = Zend_Registry::get("cache")->load($cacheBannerTopo87);

        // Se nao existir o cache faz consulta
        if (!$lista_banner_topo) {

            //inicio o model de banners
            $model_banner = new Default_Model_Banners();

            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_banner_topo = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 87")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->order("DT_CADASTRO_BARC DESC");
            $lista_banner_topo = $model_banner->fetchAll($select_banner_topo);
        }

        //Assino ao view
        $this->view->banners_topo = $lista_banner_topo;
    }

    /**
     *
     */
    public function valepresenteAction() {

        $this->view->title = "Vale presente - Reverbcity.com";
        $this->view->description = "Presenteie aquela pessoa especial com o nosso vale-presente";
        $this->view->keywords = "Reverbcity, presente, amigo, namorado, namorada, vale presente";

        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()
                ->where("NR_SEQ_TIPO_PRRC = 9")
                ->where("ST_PRODUTOS_PRRC = 'A'")
                ->order("VL_PRODUTO_PRRC");

        $this->view->vale_presentes = $model_produtos->fetchAll($select_produtos);

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
                ->where("blog.DS_STATUS_BLRC = 'A'")
                ->order("DT_CADASTRO_BLRC DESC")
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
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
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
    public function avisameAction() {

        $this->view->title = "Avise-me - Reverbcity.com";
        $this->view->description = "Aquele produto que você queria acabou? Saiba como pedir para ele voltar!";
        $this->view->keywords = "Reverbcity, avise-me, email, camisetas, reposição, reprint";


        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

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


        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela base
                ->from("aviseme", array("NR_SEQ_AVISEME_AVRC",
                    "NR_SEQ_PRODUTO_AVRC",
                    "COUNT(NR_SEQ_PRODUTO_AVRC) as total_produtos"
                ))
                //escolho a tabela do select para o join
                ->joinInner('produtos', "aviseme.NR_SEQ_PRODUTO_AVRC = produtos.NR_SEQ_PRODUTO_PRRC", array('NR_SEQ_PRODUTO_PRRC',
                    'VL_PRODUTO_PRRC',
                    'DS_PRODUTO_PRRC',
                    'DS_EXT_PRRC',
                    'TP_DESTAQUE_PRRC',
                    'DS_FRETEGRATIS_PRRC',
                    'NR_SEQ_CATEGORIA_PRRC',
                    'NR_SEQ_TIPO_PRRC',
                    'VL_PROMO_PRRC'))
                //->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                //->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'S'")
                // //produto e ativo
                // ->where("ST_PRODUTOS_PRRC = 'A'")
                // //quantidade em estoque positiva
                //->where("NR_QTDE_ESRC = 0")
                // //onde e tipo de destaque = 3 (novidades)
                // ->where("TP_DESTAQUE_PRRC = 1")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC = 6")
                ->where("ST_JACOMPROU_AVRC = 'N'")
                ->where('NR_SEQ_PRODUTO_AVRC NOT IN(2030, 2025)')
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)");
        //agora coloco as condições da url, dependendo dos parametros
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
            $select_produtos->where("DS_CORES_PRRC = " . $cor);
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
                ->order('total_produtos DESC');

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($select_produtos);
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
        $contador = new Reverb_Paginator($select_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(20)
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
                ->order("DT_CADASTRO_BLRC DESC")
                ->LIMIT(1);
        //assino ao view
        $this->view->post = $model_blog->fetchRow($select_post);

        //inicio o model do forum
        $model_forum = new Default_Model_Forum();
        //inicio a query
        $select_forum = $model_forum->select()
                //seleciono somente os ativos
                ->where("ST_FORUM_FOSO LIKE '%A%'")
                //ordeno pela data de cadastro em ordem decrescente
                ->order("DT_CADASTRO_FOSO DESC")
                //limito em 7
                ->LIMIT(7);
        //assino ao view
        $this->view->foruns = $model_forum->fetchAll($select_forum);

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
    public function colecoesantigasAction() {

        $this->view->title = "Classics - Tudo aquilo que já fizemos - Reverbcity.com";
        $this->view->description = "A galeria com os nossos produtos clássicos";
        $this->view->keywords = "Reverbcity, classic, classicos, camisetas, indie, rock";

        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }
        //recebo os parametros da url
        $categoria = $this->_request->getParam("categoria");
        $tamanho = $this->_request->getParam("tamanho");
        $genero = $this->_request->getParam("genero");
        $cor = $this->_request->getParam("cor");
        $palavra = $this->_request->getParam("busca_produto");
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
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'S' AND NR_SEQ_LOJAS_PRRC = 1 AND ST_PRODUTOS_PRRC = 'A'")
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65,59)")
                ->group("DS_PRODUTO_PRRC")
                //ordeno pela ordem de ordenacao de produtos
                ->order(array(
            'NR_ORDEM_CLAS_PRRC ASC',
            'DT_CADASTRO_PRRC desc'
        ));

        // crio a paginação para proximo e para anterior
        $paginator = new Reverb_Paginator($select_produtos);
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
        $contador = new Reverb_Paginator($select_produtos);
        //defino o numero de itens a serem exibidos por página
        $contador->setItemCountPerPage(20)
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
                ->order("DT_CADASTRO_BLRC DESC")
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
    public function carrinhoAction() {
        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");
        //inicio a sessao do usuario logado
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio a sessao dos descontos
        $descontos = new Zend_Session_Namespace("descontos");
        //crio a sessao de mensagens de promo
        $sessao_promo = new Zend_Session_Namespace("promocoes");


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

        // foreach ($carrinho->produtos as $key => $produto) {
        // 	$valor[$key]  = $produto['valor'];
        // }
        // array_multisort($valor, SORT_DESC, $carrinho->produtos);
        // usort($carrinho->produtos, create_function('$a, $b',
        //  			'if ($a["valor"] == $b["valor"]) return 0; return ($a["valor"] < $b["valor"]) ? -1 : 1;'));


        $sessao_promo->niver = 0;
        $sessao_promo->primeira = 0;
        $sessao_promo->brinde = 0;
        //verifico se o usuario esta logado
        if ($usuarios->logado == TRUE) {
            //verifico se existe produtos no carrinho
            if (count($carrinho->produtos) <= 0) {
                //mensagem de retorno para o usuario
                $messages->error = "Seu carrinho esta vazio.";
                // Redireciona para a última página
                $this->_redirect("/loja");
            }

            //agora verifico se já completou o cadastro para poder avançar
            if ($usuarios->cadastro_completo == 0) {
                //mensagem de retorno para o usuario
                $messages->error = "Você precisa completar seu cadastro para continuar a sua compra.";
                // Redireciona para a última página
                $this->_redirect('/reverbme/novome/incompleto/1');
            }

            //inicio a sessao de frete para mostrar o valor do mesmo apos ser calculado
            $sessao_frete = new Zend_Session_Namespace("fretes");
            //zero o valor para caso o usuário atualize a pagina
            $sessao_frete->valor = null;
            //assino o frete ao view
            $this->view->frete = $sessao_frete->valor;
            //assino o tipo do frete
            $this->view->forma_envio = $sessao_frete->forma_envio;
            //coloco o cep
            $this->view->cep = $sessao_frete->cep;

            //coloco o valor para frete gratis
            $this->view->valor_para_frete_gratis = $sessao_frete->valor_para_frete_gratis;
            //recebo o cupon de desconto ou vale presente
            $cupom = $this->_request->getParam("cupom");

            $sessao_frete->cupom = $cupom;
            //recebo a chave para desativar o vale presente
            $desativa = $this->_request->getParam("desativa");

            //zero as variaveis
            $valor = 0;
            //zero a variavel de valor total (de valor de produtos de carrinho)
            $valor_total = 0;
            //zero a variavel de valor total da compra
            $total_compra = 0;
            //variavel de desconto
            $valor_desconto = 0;
            //variavel para verificar se tem produto em promo
            $tem_promo = 0;
            //variavel para verificar se tem produto cheio
            $tem_cheio = 0;
            //deixo aniversariante como falso
            $aniversariante = 0;
            //mensagem de promocao vazia
            $msg_promo = "";
            //agora defino uma variavel para saber se ja tem um brinde
            $ja_tem_brinde = 0;
            //digo que existe um tipo de produto que possa anular o frete gratis
            $anula_frete_gratis = 0;
            //vejo quantos bones existes
            $total_bone = 0;
            //vejo se tem bone
            $tem_bone = 0;

            $sessao_promo->niver = 0;
            $sessao_promo->primeira = 0;

            //crio a data de hoje
            $hoje = date("m");
            //agora pego o dia e o mes do usuario
            $dia_aniversario = explode("-", $usuarios->nascimento);

            $dia_aniversario = $dia_aniversario[1];

            //inicio o model de cadastro
            $model_cadastro = new Default_Model_Reverbme();
            //inicio a query
            $select_info = $model_cadastro->select()
                    ->from("cadastros", array("DS_NOME_CASO",
                        "DS_ENDERECO_CASO",
                        "DS_NUMERO_CASO",
                        "DS_COMPLEMENTO_CASO",
                        "DS_CIDADE_CASO",
                        "DS_UF_CASO",
                        "DS_PAIS_CACH",
                        "DS_CEP_CASO",
                        "DS_BAIRRO_CASO"))
                    ->where("NR_SEQ_CADASTRO_CASO = '$usuarios->idperfil'");
            //assino o cliente ao view
            $infos = $model_cadastro->fetchRow($select_info)->toArray();
            //assino ao view as informações do cadastro
            $this->view->info = $infos;
            //para cada produto no carrinho
            //inicio o model de produto
            $model_produto = new Default_Model_Produtos();

            //inicio o model de promocoes
            $model_promo = new Default_Model_Promocoes();
            //assino os valores na variavel
            $promocoes = $model_promo->fetchRow();

            //inicio o model de configurações
            $configuracoes = new Default_Model_Configuracoes();

            //assino os valores na variavel
            $configuracao = $configuracoes->fetchRow();

            uasort($carrinho->produtos, function($a, $b) {
                return $b['total_produto'] - $a['total_produto'];
            });

            foreach ($carrinho->produtos as $key => $item) {

                //crio a query dos produtos do carrinho
                $select_produto = $model_produto->select()
                        //so escolho os campos desejados
                        ->from("produtos", array("codigo" => "NR_SEQ_PRODUTO_PRRC",
                            "nome" => "DS_PRODUTO_PRRC",
                            "descricao" => "DS_INFORMACOES_PRRC",
                            "path" => "DS_EXT_PRRC",
                            "valor" => "VL_PRODUTO_PRRC",
                            "vl_promo" => "VL_PROMO_PRRC",
                            "tipo" => "NR_SEQ_TIPO_PRRC",
                            "categoria" => "NR_SEQ_CATEGORIA_PRRC",
                            "destaque" => "TP_DESTAQUE_PRRC"))
                        ->where("NR_SEQ_PRODUTO_PRRC = ?", $item['codigo']);

                //atribuo o valor
                $row_produto = $model_produto->fetchRow($select_produto);


                //crio um array para exibir os dados do produtos de forma dinamica e nao salvar na sessao
                $data_carrinho[$key] = array("codigo" => $row_produto['codigo'],
                    "nome" => $row_produto["nome"],
                    "descricao" => $row_produto['descricao'],
                    "path" => $row_produto['path'],
                    "valor" => $row_produto['valor'],
                    "vl_promo" => $row_produto['vl_promo'],
                    "idestoque" => $item['idestoque'],
                    "estoque" => $item['estoque'],
                    "quantidade" => $item['quantidade'],
                    "tipo" => $row_produto['tipo'],
                    "categoria" => $row_produto["categoria"],
                    "destaque" => $row_produto["destaque"],
                    "sigla" => $item["sigla"],
                    "brinde" => 0);
                //somo o total de itens no carrinho
                $total_itens_carrinho += $item['quantidade'];

                //agora verifico se existe algo que anule frete gratis
                if ($data_carrinho[$key]['tipo'] == 52) {
                    //anulo o frete gratis
                    $anula_frete_gratis = 1;
                } else {
                    //nao anulo
                    $anula_frete_gratis = 0;
                }


                /*                 * ************-
                 * **************-
                 * ****PROMOS****-
                 * **************-
                 * ************** */




                //----------------//
                //Primeira Compra//
                //---------------//
                //verifico se a promo de primeira compra esta ativa
                if ($promocoes["st_primeira_compra"] == 1 and $usuarios->tipo <> 'PJ') {

                    // Cria o objeto de conexão
                    $db = Zend_Registry::get("db");
                    //crio a query para verificar se o usuário tem alguma compra que não seja cancelada
                    $select_primeira_compra = "SELECT
												NR_SEQ_CADASTRO_COSO
											 from
											 	compras,
											 	cadastros
											 WHERE
											 	NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
											 and
	               	 							ST_COMPRA_COSO <> 'C'
	               	 						and NR_SEQ_CADASTRO_CASO = $usuarios->idperfil";
                    // die($select_primeira_compra);
                    //executo a query
                    $query_primeira_compra = $db->query($select_primeira_compra);

                    //crio uma varivel que recebe a primeira compra ou fica vazia
                    $primeira_compra = $query_primeira_compra->fetchAll();
                    //se tiver como nulo significa que é a primeira compra
                    if ($primeira_compra[0] == Null) {
                        //agora faco uma query para verificar se o cadastro tem mais de 30 dias ou não
                        $select_tempo_cadastro = "SELECT
						 							DATEDIFF(SYSDATE(),DT_CADASTRO_CASO)
						 						AS
						 							diferenca
						 						from
						 							cadastros
						 						WHERE
						 							NR_SEQ_CADASTRO_CASO = $usuarios->idperfil";
                        //executo a query
                        $query_tempo_cadastro = $db->query($select_tempo_cadastro);

                        //crio uma varivel que recebe a primeira compra ou fica vazia
                        $tempo_cadastro = $query_tempo_cadastro->fetchAll();

                        //agora verifico se o tempo de cadastro e maior que 90 dias
                        if ($tempo_cadastro[0]["diferenca"] <= 90 and $ja_tem_brinde == 0) {
                            //atribuo a mensagem
                            $msg_promo = $promocoes["msg_primeira_compra"];
                            //agora assino a mensagem a promo
                            $sessao_promo->msg = $msg_promo;

                            $this->view->primeira_compra = 1;

                            //agora verifico se existe mais de 150 em compras e se ainda não entrou brinde para ele

                            if ($valor_total >= $promocoes["vl_primeira_compra"]) {

                                //se tiver apenas 1
                                if ($item['quantidade'] == 1) {
                                    //se tiver um de preco cheio
                                    if ($tem_cheio == 1) {

                                        //agora vejo se e camiseta
                                        if ($item["tipo"] == 6) {

                                            //agora vejo se o item atual é de valor de 69 ou menor
                                            if ($data_carrinho[$key]['valor'] <= 69 or $data_carrinho[$key]['vl_promo'] <= 69) {
                                                //defino os valores como 0
                                                $data_carrinho[$key]['vl_promo'] = 0;
                                                $data_carrinho[$key]['valor'] = 0;
                                                $carrinho->produtos[$key]["brinde"] = 1;



                                                //falo que ele ja ganhou um brinde
                                                $ja_tem_brinde = 1;
                                                //agora atribuo como verdadeiro a sessao de primeira compra
                                                $sessao_promo->primeira = 1;
                                                $sessao_promo->brinde = 1;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                //-----------//
                //aniversario//
                //----------//
                //agora passo o valor do produto se tiver promo atribuo o valor de promo para ver na promo
                if ($data_carrinho[$key]['vl_promo'] == 0) {
                    $valor_produto_promo = $data_carrinho[$key]['valor'];
                } else {
                    $valor_produto_promo = $data_carrinho[$key]['vl_promo'];
                }



                //verifico se a promo de aniversário esta ativa
                if ($promocoes["st_promo_niver"] == 1) {

                    $ano_atual = date("Y");

                    // deixo a data de aniversario como a data de hoje para ativar a promo de dia dos namorados
                    // $dia_aniversario = $hoje;
                    // se hoje for o dia do aniversario do usuario atribuo como aniversariante e não for PJ
                    if ($hoje == $dia_aniversario and $usuarios->tipo <> 'PJ') {

                        // Cria o objeto de conexão
                        $db = Zend_Registry::get("db");
                        //crio a query para verificar se o usuário tem alguma compra que não seja cancelada no mes
                        $select_compra_mes = "SELECT
													NR_SEQ_CADASTRO_COSO
												 from
												 	compras,
												 	cadastros
												 WHERE
												 	NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
												 and
		               	 							MONTH(DT_COMPRA_COSO) = $hoje
		               	 						 AND 
		               	 						 	YEAR(DT_COMPRA_COSO) = $ano_atual
		               	 						 AND 
		               	 						 	ST_COMPRA_COSO <> 'C'

		               	 						and NR_SEQ_CADASTRO_CASO = $usuarios->idperfil";
                        // die($select_compra_mes);
                        //executo a query
                        $query_compra_niver = $db->query($select_compra_mes);

                        //crio uma varivel que recebe a primeira compra ou fica vazia
                        $compra_niver = $query_compra_niver->fetchAll();

                        if ($compra_niver[0] == Null) {
                            //é aniversariante
                            $aniversariante == true;
                            //atribuo a mensagem para o carrinho
                            $msg_promo = $promocoes["msg_promo_niver"];
                            //agora assino a mensagem a promo
                            $sessao_promo->msg = $msg_promo;

                            $this->view->compra_niver = 1;

                            if ($tem_promo == 0) {

                                //agora verifico se o produto e valor maior que o ultimo e se ainda não entrou brinde para ele e se é camiseta
                                if ($valor_cheio >= $valor_produto_promo and $ja_tem_brinde == 0 and $data_carrinho[$key]['tipo'] == 6) {

                                    //se tiver apenas 1
                                    if ($item['quantidade'] == 1) {
                                        //defino os valores como 0

                                        $data_carrinho[$key]['vl_promo'] = 0;
                                        $data_carrinho[$key]['valor'] = 0;
                                        $carrinho->produtos[$key]["brinde"] = 1;
                                        $carrinho->produtos[$key]["brinde"];
                                        //falo que ele ja ganhou um brinde
                                        $ja_tem_brinde = 1;
                                        //agora atribuo como verdadeiro a sessao de primeira compra
                                        $sessao_promo->niver = 1;
                                        $sessao_promo->brinde = 1;
                                    }
                                }
                            }
                        }
                    }
                }

                //-----------//
                //Ganha sale //
                //-----------//
                //se tiver apenas 1
//				if ($item['quantidade'] == 1){
//				 	//se tiver um de preco cheio
//				 	if($tem_cheio == 1){
//					
//				 		//agora vejo se e camiseta
//				 		if($data_carrinho[$key]["destaque"] == 2){
//
//				 			//atribuo a mensagem para o carrinho
//				 			$msg_promo = "Na compra de um produto a partir de  69,00  ganhe uma camiseta grátis que esteja em sale!";
//				 			//agora assino a mensagem a promo
//				 			$sessao_promo->msg = $msg_promo;
//
//				 			$this->view->promo_sale = 1;
//
//				 			//agora vejo se e camiseta
//				 			if($item["tipo"] == 6 and $ja_tem_brinde == 0){
//				 				//defino os valores como 0
//				 				$data_carrinho[$key]['vl_promo'] = 0;
//				 				$data_carrinho[$key]['valor'] = 0;
//				 				//falo que ele ja ganhou um brinde
//				 				$ja_tem_brinde = 1;
//				 				//agora atribuo como verdadeiro a sessao de primeira compra
//				 				$sessao_promo->sale = 1;
//
//				 			}
//				 		}
//				 	}									
//                               }



                /*                 * ************-
                 * **************-
                 * **FIM PROMOS***-
                 * **************-
                 * ************** */

                if ($usuarios->tipo <> 'PJ') {
                    //aqui verifico se e promo ou não
                    if ($data_carrinho[$key]['vl_promo'] > 0) {
                        //jogo o valor da promo no valor do produto
                        $valor = $data_carrinho[$key]['vl_promo'];

                        //recebo a quantidade
                        $quantidade = $item['quantidade'];

                        //multiplico pela quantidade do produto
                        $valor = $valor * $quantidade;

                        //agora falo que tem promo na variavel
                        $tem_promo = 1;
                    } else {
                        //jogo o valor do produto na variavel
                        $valor = $data_carrinho[$key]['valor'];
                        //jogo o valor do produto na variavel de produto cheio
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto
                        $valor = $valor * $quantidade;
                        //agora falo que tem produto cheio
                        if ($valor_cheio >= 69) {
                            $tem_cheio = 1;
                        }
                    }
                } else {
//                                        
//					if($data_carrinho[$key]["tipo"] == 142){
//					
//
//						//jogo o valor do produto na variavel
//						$valor = $data_carrinho[$key]['valor'] * 0.5;
//						//jogo o valor do produto na variavel de produto cheio
//						$valor_cheio = $data_carrinho[$key]['valor'] * 0.5;
//
//					}else{
                    if ($data_carrinho[$key]["destaque"] != 2) {

                        //jogo o valor do produto na variavel
                        $valor = $data_carrinho[$key]['valor'] * 0.7;
                        //jogo o valor do produto na variavel de produto cheio
                        $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
                    }
//						}else{
//							//jogo o valor do produto na variavel
//							$valor = $data_carrinho[$key]['valor'] * 0.5;
//							//jogo o valor do produto na variavel de produto cheio
//							$valor_cheio = $data_carrinho[$key]['valor'] * 0.5;
//						}
//					}
                    //verifico se e poster ou camiseta
                    //agora o valor do carrinho
                    $data_carrinho[$key]['valor'] = $valor;
                    //recebo a quantidade
                    $quantidade = $item['quantidade'];
                    //multiplico pela quantidade do produto
                    $valor = $valor * $quantidade;
                    //agora falo que tem produto cheio
                    $data_carrinho[$key]['vl_promo'] = 0;
                }
                //para  carrinho do banco
                $data_carrinho[$key]['total_produto'] = $valor;
                //pra carrinho da sessao
                $carrinho->produtos[$key]['total_produto'] = $valor;
                //atribuo o valor total do carrinho
                $valor_total += $valor;
            }



            //assino ao view se anulou frete gratis ou não
            $this->view->anula_frete = $anula_frete_gratis;
            //assino ao view o total de itens
            $this->view->total_itens_carrinho = $total_itens_carrinho;
            //verifico o valor que falta
            $total_para_frete_gratis = $configuracao->VL_FRETEGRATIS_GESA - $valor_total;
            //assino o valor para frete gratis

            $this->view->valor_frete_gratis = $total_para_frete_gratis;

            $this->view->tem_brinde = $ja_tem_brinde;


            //assino o carrinho ao view
            $this->view->carrinho = $data_carrinho;

            if ($this->_request->isPost()) {

                // se existir um cupom informado
                if ($cupom != "") {
                    //inicio o modulo de cupom
                    $model_cupom = new Default_Model_Cupons();
                    //crio a query
                    $select_cupom = $model_cupom->select()
                            ->from("cupons", array("DS_CUPOM_CURC",
                                "VL_VALOR_CURC",
                                "ST_CUPOM_CURC"))
                            ->where("DS_CUPOM_CURC = '$cupom'");
                    //crio uma variavel que recebe o cupom de desconto
                    $cupom_selecionado = $model_cupom->fetchRow($select_cupom);
                    //se não trouxer cupom de desconto faz a consulta de vale presente
                    if ($cupom_selecionado == "") {


                        //se ele nao quer mais utilizar o vale presente
                        if ($desativa == 1) {
                            //deixo o valor do desconto vazio
                            $valor_desconto = 0;

                            //Limpo o vale presente
                            $this->view->valepresente = "";

                            //retorno mensagem para o usuario
                            $messages->success = "Você removeu o seu desconto, agora poderá utiliza-lo em outra compra!";
                            //se for json
                            if ($this->_request->getParam('json')) {
                                //crio um array com mensagem do json
                                $data_json = array('valor_desconto' => 0,
                                    'erro' => false,
                                    'msg_erro' => 'Você removeu o seu desconto, agora poderá utiliza-lo em outra compra!');
                                //assino o json
                                $this->_helper->json($data_json);
                            }
                            //senao entra na condicao do vale presente
                        } else {

                            //inicio o model de vale presente
                            $model_valepresente = new Default_Model_Bilhetes();
                            //inicio a query
                            $select_valepresente = $model_valepresente->select()
                                    ->from("bilhetes", array("NR_SEQ_BILHETES_BIRC",
                                        "DS_BILHETE_BIRC",
                                        "ST_STATUS_BIRC",
                                        "VL_BILHETE_BIRC"))
                                    ->where("DS_BILHETE_BIRC = '$cupom'");


                            //crio uma lista com o vale presente
                            $valepresente = $model_valepresente->fetchRow($select_valepresente);

                            //agora verifico o status do bilhete

                            if ($valepresente->ST_STATUS_BIRC == 'U') {

                                //se for json
                                if ($this->_request->getParam('json')) {
                                    //crio um array com mensagem do json
                                    $data_json = array('valor_desconto' => 0,
                                        'erro' => true,
                                        'msg_erro' => 'Seu Vale presente já foi utilizado!');
                                    //assino o json
                                    $this->_helper->json($data_json);
                                }

                                //retorno mensagem para o usuario
                                $messages->error = "Seu Vale presente já foi utilizado.";
                                // Redireciona para a última página
                                $this->_redirect($_SERVER['HTTP_REFERER']);
                                //senao foi utilizado dou o desconto
                            } else {
                                //atribuo o desconto do cupom
                                $valor_desconto = $valepresente->VL_BILHETE_BIRC;

                                //agora verifico se foi digitado algo valido
                                if ($valor_desconto <= 0 or $valor_desconto == "") {
                                    //se for json
                                    if ($this->_request->getParam('json')) {
                                        //crio um array com mensagem do json
                                        $data_json = array('valor_desconto' => 0,
                                            'erro' => true,
                                            'msg_erro' => 'Insira um cupom / vale presente válido!');
                                        //assino o json
                                        $this->_helper->json($data_json);
                                    }
                                } else {


                                    //assino ao view o vale presente
                                    $this->view->valepresente = $cupom;

                                    $this->view->idvale_presente = $valepresente->NR_SEQ_BILHETES_BIRC;


                                    $sessao_frete->valor_desconto = $valor_desconto;
                                    //se for json
                                    if ($this->_request->getParam('json')) {
                                        //crio um array com mensagem do json
                                        $data_json = array('valor_desconto' => $valor_desconto,
                                            'erro' => false,
                                            'msg_erro' => '');
                                        //assino o json
                                        $this->_helper->json($data_json);
                                    }
                                }
                            }
                        }

                        //se tiver algo significa que teve resultado
                    } else {

                        //agora verifico o status dos bilhetes
                        if ($cupom_selecionado->ST_CUPOM_CURC == "C") {
                            //se for json
                            if ($this->_request->getParam('json')) {
                                //crio um array com mensagem do json
                                $data_json = array('valor_desconto' => 0,
                                    'erro' => true,
                                    'msg_erro' => 'Seu cupom já foi utilizado.');
                                //assino o json
                                $this->_helper->json($data_json);
                            }
                            //mensagem de retorno para o usuario
                            $messages->error = "Seu cupom já foi utilizado.";
                            // Redireciona para a última página
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                            //senao foi utilizado dou o desconto
                        } else {
                            //atribuo o desconto do cupom
                            $valor_desconto = $cupom_selecionado->VL_VALOR_CURC;


                            //se for json
                            if ($this->_request->getParam('json')) {
                                //crio um array com mensagem do json
                                $data_json = array('valor_desconto' => $valor_desconto,
                                    'erro' => false,
                                    'msg_erro' => '');
                                //assino o json
                                $this->_helper->json($data_json);
                            }
                        }
                    }
                } else {
                    if ($this->_request->getParam('json')) {
                        //crio um array com mensagem do json
                        $data_json = array('valor_desconto' => 0,
                            'erro' => true,
                            'msg_erro' => 'Por favor insira um cupom / vale presente válido');
                        //assino o json
                        $this->_helper->json($data_json);
                    }
                    //mensagem de retorno para o usuario
                    $messages->error = "Por favor insira um cupom / vale presente válido.";
                    // Redireciona para a última página
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }
            }

            /*
              //inicio a função de creditos dos parceiros
             */
            $data_hoje = date("Y-m-d");

            //inicio o model
            $model_creditos = new Default_Model_Contascorrente();
            //inicio a query do valor
            $select_credito = $model_creditos->select()
                    //digo a tabela e os campos que vou precisar
                    ->from("contacorrente", array("NR_SEQ_CONTA_CRSA",
                        "VL_LANCAMENTO_CRSA"))
                    //coloco todas as condições necessárias
                    ->where("TP_LANCAMENTO_CRSA = 'C'")
                    ->where("NR_SEQ_CADASTRO_CRSA = ?", $usuarios->idperfil)
                    ->where("VL_LANCAMENTO_CRSA > 0");
            // die($select_credito);
            //armazeno em uma váriavel o resultado da busca que eu fiz
            $creditos = $model_creditos->fetchRow($select_credito);

            //agora verifico se trouxe algum resultado ou se existe valor
            if ($creditos->VL_LANCAMENTO_CRSA > 0) {
                //atribuo o desconto do cupom
                $valor_desconto = $creditos->VL_LANCAMENTO_CRSA;
                //coloco na sessao 
                $sessao_frete->valor_desconto = $valor_desconto;
                //coloco na sessao 
                $sessao_frete->idconta = $creditos->NR_SEQ_CONTA_CRSA;
                //se for json
                if ($this->_request->getParam('json')) {
                    //crio um array com mensagem do json
                    $data_json = array('valor_desconto' => $valor_desconto,
                        'erro' => false,
                        'msg_erro' => '');
                    //assino o json
                    $this->_helper->json($data_json);
                }
            }



            /*
              //finalizo a função de creditos dos parceiros
             */

            //assino o subtotal de compras ao view
            $this->view->subtotal = $valor_total;
            //atribuo o valor da variavel total da compra
            $total_compra = $valor_total + $sessao_frete->valor;

            //agora deixo como 0 se o total da compra for menor que zero
            //vejo se tem desconto para remover do valor total
            if ($valor_desconto > 0) {
                $total_compra = $total_compra - $valor_desconto;
            }

            if ($total_compra < 0) {
                $total_compra = 0;
            }
            //assino o total ao view
            $this->view->total = $total_compra;


            //assino o valor do desconto ao view
            $this->view->valor_desconto = $valor_desconto;

            //verifico o total da compra
            switch ($total_compra) {
                // se for maior ou igual que 50 dividimos em 2 vezes
                case $total_compra >= 50:
                    //2x
                    $this->view->duas_parcelas = $total_compra / 2;

                //se for maior que 100 dividimos em 3x
                case $total_compra >= 100:
                    //3X
                    $this->view->tres_parcelas = $total_compra / 3;
                //se for maior que 150 4x
                case $total_compra >= 150:

                    $this->view->quatro_parcelas = $total_compra / 4;
            }

            //assino a quantidade
            $this->view->quantidade = $quantidade;



            //inicio o model de banners
            $model_banner = new Default_Model_Banners();
            //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
            $select_banner_topo = $model_banner->select()
                    ->where("NR_SEQ_LOCAL_BARC = 87")
                    ->where("ST_BANNER_BARC = 'A'")
                    ->order("DT_CADASTRO_BARC DESC");
            //Assino ao view
            $this->view->banners_topo = $model_banner->fetchAll($select_banner_topo);
            //assino ao view a mensagem da promo
            $this->view->msg_promo = $msg_promo;

            //assino ao view o tipo do usuario cadastrado e a cidade
            $this->view->tipo_usuario = $usuarios->tipo;
            $this->view->uf_usuario = $usuarios->uf;



            //assino que tem frete gratis no vire
            $this->view->frete_gratis = $sessao_frete->frete_gratis;

// Zend_Debug::dump($carrinho->produtos);die();
        } else {

            //mensagem de usuario
            $messages->error = "Você precisa estar logado para acessar o carrinho";
            //retorno a ultima pagina
            $this->_redirect("/cadastro-rapido");
        }
    }

    /**
     *
     */
    public function produtoAction() {


        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        //verifico se o usuário não esta logado
        if ($usuarios->logado != TRUE) {
            //se não tiver logado pego a url do produto
            $server = $_SERVER['SERVER_NAME'];
            $endereco = $_SERVER ['REQUEST_URI'];


            //crio a sessão com a url do produto que ele vuer
            $url_ultimo_prod = new Zend_Session_Namespace("ultimo_produto");

            //agora aermacendo na sessao
            $url_ultimo_prod->link = $endereco;
        }

        $idproduto = $this->_request->getParam("idproduto");

        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()

                //seleciono somente as informacoes do produto
                ->where("NR_SEQ_PRODUTO_PRRC = ?", $idproduto)
                ->where("ST_PRODUTOS_PRRC = 'A'");
        //armazeno em uma variavel
        $produtos_lista = $model_produtos->fetchRow($select_produtos);

        $preview = $this->_request->getParam('preview');

        if (!$produtos_lista && !$preview) {
            $mensagem = new Zend_Session_Namespace("messages");
            $mensagem->error = "A página que você tentou acessar não está disponível";

            //reorno para a pagina
            $this->_redirect($_SERVER['HTTP_REFERER']);
        } else {
            $select_produtos = $model_produtos->select()

                    //seleciono somente as informacoes do produto
                    ->where("NR_SEQ_PRODUTO_PRRC = ?", $idproduto);

            //armazeno em uma variavel
            $produtos_lista = $model_produtos->fetchRow($select_produtos);
        }

        $modelProdutoTags = new Default_Model_Produtotags();
        $selectProdutoTags = $modelProdutoTags->select()
                ->from('produtos_tags', array(
                    'produto_tag' => "(GROUP_CONCAT(produto_tag SEPARATOR ', '))"
                ))
                ->where('idproduto = ?', $idproduto);
        $dadosProdutoTags = $modelProdutoTags->fetchRow($selectProdutoTags);

        $modelTamanhos = new Default_Model_Tamanhos();
        $dadosTamanhos = $modelTamanhos->fetchAll(array('DS_STATUS_TARC = ?' => 'A'));

        $this->view->tamanhos = $dadosTamanhos;

        //assino ao view
        $this->view->produto = $produtos_lista;

        if ($produtos_lista->NR_SEQ_TIPO_PRRC == 6) {
            $preTitle = 'Camiseta ';
        }

        $ds_produto_prrc = explode(' - ', $produtos_lista->DS_PRODUTO_PRRC);

        $this->view->title = $preTitle . $produtos_lista->DS_PRODUTO_PRRC . " - Reverbcity.com";
        $this->view->description = $preTitle . $ds_produto_prrc[0] . " - " . substr(strip_tags($produtos_lista->DS_INFORMACOES_PRRC), 0, 200);
        $this->view->keywords = $dadosProdutoTags->produto_tag;
        $this->view->imagem_fb = $produtos_lista->NR_SEQ_PRODUTO_PRRC . "." . $produtos_lista->DS_EXT_PRRC;

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
						   NR_SEQ_PRODUTO_FORC = '" . addslashes($idproduto) . "'
						ORDER BY
							NR_ORDEM_FORC ASC";

        // Monta a query
        $query = $db->query($select_fotos);
        //crio uma lista de fotos
        $lista = $query->fetchAll();
        //assino os amigos ao view
        $this->view->fotos = $lista;



        //inicio o model de estoque
        $model_estoque = new Default_Model_Estoque();
        //crio a query para listagem de estoque
        $select_estoque = $model_estoque->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('estoque')
                //crio o inner join das fotos
                ->joinInner('tamanhos', 'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC', array('*'))
                //agora faco a condicao de que quero o estoque de apenas o produto desejado
                ->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
                //agora falo em quais codigos de tamanho
                ->where("estoque.NR_SEQ_TAMANHO_ESRC IN (33,1,2,3,4,5)")
                ->where("estoque.NR_QTDE_ESRC IS NOT NULL")
                ->order("NR_ORDEM_TARC ASC");
        ;

        //assino ao view
        $this->view->estoques_masculino = $model_estoque->fetchAll($select_estoque);

        //crio a query para listagem de estoque
        $select_estoque_feminino = $model_estoque->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('estoque')
                //crio o inner join das fotos
                ->joinInner('tamanhos', 'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC', array('*'))
                //agora faco a condicao de que quero o estoque de apenas o produto desejado
                ->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
                //agora falo em quais codigos de tamanho
                ->where("estoque.NR_SEQ_TAMANHO_ESRC IN (6,7,8,9,10,47)")
                ->where("estoque.NR_QTDE_ESRC IS NOT NULL")
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
                ->joinInner('tamanhos', 'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC', array('*'))
                //agora faco a condicao de que quero o estoque de apenas o produto desejado
                ->where("NR_SEQ_PRODUTO_ESRC = ?", $idproduto)
                //agora falo em quais codigos de tamanho
                ->where("estoque.NR_SEQ_TAMANHO_ESRC NOT IN (6,7,8,9,10,33,1,2,3,4,5,47)")
                //ordena
                ->order("NR_ORDEM_TARC ASC");
        //assino ao view
        $this->view->estoques_geral = $model_estoque->fetchAll($select_estoque_geral);

        //inicio a sessao de produtos vistos
        $produtos_vistos = new Zend_Session_Namespace("vistos");


        $produto = $produtos_lista;

        $nome = $produto['DS_PRODUTO_PRRC'];
        $descricao = $produto['DS_INFORMACOES_PRRC'];
        $extensao_imagem = $produto["DS_EXT_PRRC"];
        $valor = $produto["VL_PRODUTO_PRRC"];
        $peso = $produto['NR_PESOGRAMAS_PRRC'];
        $valor_promo = $produto['VL_PROMO_PRRC'];
        $categoria = $produto["NR_SEQ_CATEGORIA_PRRC"];
        $tipo = $produto["NR_SEQ_TIPO_PRRC"];
        $genero_produto = $produto["DS_GENERO_PRRC"];
        $cor_produto = $produto["NR_SEQ_COR_PRRC"];


// 		Zend_Debug::dump($imagem);die;

        $produtos_vistos->produtos[$idproduto] = array(
            'codigo' => $idproduto,
            'nome' => $nome,
            'descricao' => $descricao,
            'path' => $extensao_imagem,
            'valor' => $valor,
            'peso' => $peso,
            'promo' => $valor_promo,
            'hora' => date("H:i:s"),
            'categoria' => $categoria,
            'tipo' => $tipo
        );

        //crio uma query para exibir sugestões de produtos
        $select_sugestoes = $model_produtos->select()
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
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0");



        $select_sugestoes->where("NR_SEQ_CATEGORIA_PRRC = 179");


        //se ja tiver escolhido um antioriemnte
        // if($categoria != ""){
        // 	//o ultimo visitado
        // 	$select_sugestoes->where("NR_SEQ_CATEGORIA_PRRC = ?", $categoria)
        // 	//agora removo o produto com mesmo id para evitar sugestao igual ao que esta vendo
        // 	->where("NR_SEQ_PRODUTO_PRRC <> ?", $idproduto);
        // }
        //removo os buttons
        $select_sugestoes->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65)")
                //agrupo por id de produto para não repetir
                ->group("NR_SEQ_PRODUTO_PRRC")
                //ordeno randomicamente
                ->order("RAND()")
                //limito em 4
                ->limit(1);

        $sugestoes = $model_produtos->fetchAll($select_sugestoes);


        // crio uma query para exibir produtos sale APPLICATIVA
        $select_sale = $model_produtos->select()
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
                    'DS_FRETEGRATIS_PRRC'))
                ->joinInner("estoque", "produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC", array("NR_QTDE_ESRC"))
                ->joinLeft("tamanhos", "tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC", array("NR_SEQ_TAMANHO_TARC"))
                //coloco as condições pertence so a loja
                ->where("NR_SEQ_LOJAS_PRRC = 1")
                //nao e classic
                ->where("DS_CLASSIC_PRRC = 'N'")
                //é sale
                ->where("TP_DESTAQUE_PRRC = '2'")
                //produto e ativo
                ->where("ST_PRODUTOS_PRRC = 'A'")
                //quantidade em estoque positiva
                ->where("NR_QTDE_ESRC > 0");

        //removo os buttons
        $select_sale->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65)")
                //agrupo por id de produto para não repetir
                ->group("NR_SEQ_PRODUTO_PRRC")
                //ordeno randomicamente
                ->order("RAND()")
                //limito em 4
                ->limit(1);

        $sale = $model_produtos->fetchAll($select_sale);

        //assino ao view
        $this->view->sales = $model_produtos->fetchAll($select_sale);

        //assino ao view
        $this->view->sugestoes = $model_produtos->fetchAll($select_sugestoes);

        /*         * ****************************************************
         * 
         * Aqui inicio o filtro na barra lateral do produto
         *
         * ***************************************************** */

        //crio a query de categorias
        $select_categorias = "SELECT
								NR_SEQ_CATEGPRO_PCRC,
								DS_CATEGORIA_PCRC
							FROM
								produtos_categoria
							WHERE
								DS_STATUS_PCRC = 'A'
							AND 
								NR_SEQ_CATEGPRO_PCRC = $categoria
							ORDER BY
								DS_CATEGORIA_PCRC ASC"
        ;

        // Monta a query
        $quer_categoria = $db->query($select_categorias);
        //crio uma lista de fotos
        $lista_categoria = $quer_categoria->fetchAll();


        //assino os amigos ao view
        $this->view->categoria = $lista_categoria[0];


        //crio a query de tipos
        $select_tipos = "SELECT
								NR_SEQ_CATEGPRO_PTRC,
								DS_CATEGORIA_PTRC
							FROM
								produtos_tipo
							WHERE
								DS_STATUS_PTRC = 'A'
							AND 
								NR_SEQ_CATEGPRO_PTRC = $tipo
							ORDER BY
								DS_CATEGORIA_PTRC ASC"
        ;

        // Monta a query
        $query_tipos = $db->query($select_tipos);
        //crio uma lista de fotos
        $lista_tipos = $query_tipos->fetchAll();

        //assino os amigos ao view
        $this->view->tipo = $lista_tipos[0];

        //agora faço a verificação de qual faixa de valor o usuário escolheu
        //verifico se o valor do produto é de promo
        if ($valor_promo > 0 or $valor_promo != "") {
            //agora verifico se o valor é até o primeiro nivel do filtro
            if ($valor_promo <= 29.90) {
                //se for eu assino ao view
                $this->view->valor = 29.90;
            }
            //agora o segundo nivel do filtro
            if ($valor_promo >= 30.00 and $valor_promo <= 60.00) {
                //se for eu assino ao view
                $this->view->valor = 30;
            }
            //agora o segundo nivel do filtro
            if ($valor_promo >= 61.00 and $valor_promo <= 89.90) {
                //se for eu assino ao view
                $this->view->valor = 61;
            }
            //agora o segundo nivel do filtro
            if ($valor_promo >= 90.00) {
                //se for eu assino ao view
                $this->view->valor = 90;
            }
        } else {
            //agora verifico se o valor é até o primeiro nivel do filtro
            if ($valor <= 29.90) {
                //se for eu assino ao view
                $this->view->valor = 29.90;
            }
            //agora o segundo nivel do filtro
            if ($valor >= 30.00 and $valor <= 60.00) {
                //se for eu assino ao view
                $this->view->valor = 30;
            }
            //agora o segundo nivel do filtro
            if ($valor >= 61.00 and $valor <= 89.90) {
                //se for eu assino ao view
                $this->view->valor = 61;
            }
            //agora o segundo nivel do filtro
            if ($valor >= 90.00) {
                //se for eu assino ao view
                $this->view->valor = 90;
            }
        }
        //assino ao view o genero do produto para um filtro direto
        $this->view->genero_produto = $genero_produto;

        //verifico se existe cor informada
        if ($cor_produto) {
            //crio a query de cor
            $select_cores = "SELECT
									idcor,
									cor
								FROM
									cores
								WHERE
									idcor = $cor_produto
								ORDER BY
									cor ASC"
            ;

            // Monta a query
            $query_cores = $db->query($select_cores);
            //crio uma lista de fotos
            $lista_cores = $query_cores->fetchAll();

            //assino os amigos ao view
            $this->view->cor = $lista_cores[0];
        }

        /*         * ****************************************************
         *
         * Aqui finalizo o filtro na barra lateral do produto
         *
         * ***************************************************** */

        //crio o model de notas
        $model_notas = new Default_Model_Produtosnotas();
        //crio a query para mostrar o resultado de notas de produtos
        $select_nota = "SELECT
						    `produtos_notas`.`idproduto`,
						    ROUND((SELECT
						                    SUM(nota) AS soma_notas
						                FROM
						                    produtos_notas
						                WHERE
						                    produtos_notas.idproduto = '" . addslashes($idproduto) . "') / (SELECT
						                    COUNT(idprodutos_nota) AS total_avaliacoes
						                FROM
						                    produtos_notas
						                WHERE
						                    produtos_notas.idproduto = '" . addslashes($idproduto) . "')) AS `soma_notas`,
                                                    (SELECT
						                    COUNT(idprodutos_nota) AS total_avaliacoes
						                FROM
						                    produtos_notas
						                WHERE
						                    produtos_notas.idproduto = '" . addslashes($idproduto) . "') AS total_voto
						FROM
						    `produtos_notas`
						GROUP BY `produtos_notas`.`idproduto`";
        // Monta a query
        $quer_nota = $db->query($select_nota);
        //crio uma lista de fotos
        $nota = $quer_nota->fetchAll();


        //assino os amigos ao view
        $this->view->nota = $nota[0];

        // agora inicio a listagem dos comentarios do produto
        $model_coments = new Default_Model_Produtoscoments();
        //crio a query
        $select_coments = $model_coments->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('produtos_coments', array("NR_SEQ_CADASTRO_PCRC",
                    "NR_SEQ_PRODCOMENT_PCRC",
                    "NR_SEQ_PRODUTO_PCRC",
                    "DS_AUTOR_PCRC",
                    "DS_EMAIL_PCRC",
                    "DS_COMENTARIO_PCRC",
                    "DT_COMENT_PCRC",
                    "DS_STATUS_PCRC",
                    "DS_IP_PCRC",
                    "NR_SEQ_REPLY_PCRC",
                    "NR_CURTIRAM_PCRC",
                    "NR_NAOCURTIRAM_PCRC",
//										 "total_comentarios" => "(SELECT 
//										 							COUNT(NR_SEQ_PRODCOMENT_PCRC)
//										 						  AS
//										 						  	total_comentarios
//										 						  FROM 
//										 						  	produtos_coments
//										 						  WHERE
//										 						  	NR_SEQ_PRODCOMENT_PCRC = NR_SEQ_PRODCOMENT_PCRC
//										 						  AND 
//										 						  	NR_SEQ_REPLY_PCRC is not null)" 
                ))
                //crio o inner join das fotos
                ->joinInner('cadastros', 'produtos_coments.NR_SEQ_CADASTRO_PCRC = cadastros.NR_SEQ_CADASTRO_CASO', array('*'))
                //agora faco a condicao de que quero o produto desejado
                ->where("NR_SEQ_PRODUTO_PCRC = ?", $idproduto)
                //somente as mensagens que nao etem resposta
                ->where("NR_SEQ_REPLY_PCRC is NULL")
                //comentario aprovados
                ->where("DS_STATUS_PCRC = 'A'")
                //orderno do mais novo para o ultimo
                ->order("NR_SEQ_PRODCOMENT_PCRC DESC");

        $this->view->comentarios = $model_coments->fetchAll($select_coments);

        //assino o id do produto ao view
        $this->view->idproduto = $idproduto;


        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_banner = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->order("DT_CADASTRO_BARC DESC");
        //Assino ao view
        $this->view->banners = $model_banner->fetchAll($select_banner);

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


        $this->view->nome = $usuarios->nome;
        $this->view->email = $usuarios->email;
        $this->view->cidade = $usuarios->cidade;
        $this->view->uf = $usuarios->uf;
        $this->view->ddd = $usuarios->ddd;
        $this->view->telefone = $usuarios->cel;
        $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/tinymce.min.js');
        $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/libs/tinymce/langs/pt_BR.js');
    }

    /**
     *
     */
    public function classicAction() {

        $this->view->title = "Classics - Reverbcity.com";
        $this->view->description = "A galeria com os nossos produtos clássicos";
        $this->view->keywords = "Reverbcity, classic, camisetas, indie, rock";


        //crio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //se por PJ redireciona
        if ($usuarios->tipo == 'PJ') {
            $this->_redirect("atacado");
        }

        $idproduto = $this->_request->getParam("idproduto");

        //Inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();
        //crio a query de produtos
        $select_produtos = $model_produtos->select()
                //seleciono somente as informacoes do produto
                ->where("NR_SEQ_PRODUTO_PRRC = $idproduto");


        //assino ao view
        $this->view->produto = $model_produtos->fetchRow($select_produtos);

        $modelProdutoTags = new Default_Model_Produtotags();
        $selectProdutoTags = $modelProdutoTags->select()
                ->from('produtos_tags', array(
                    'produto_tag' => "(GROUP_CONCAT(produto_tag SEPARATOR ', '))"
                ))
                ->where('idproduto = ?', $idproduto);
        $dadosProdutoTags = $modelProdutoTags->fetchRow($selectProdutoTags);

        $this->view->title = $this->view->produto->DS_PRODUTO_PRRC . " - Reverbcity.com";
        $this->view->description = substr(strip_tags($this->view->produto->DS_INFORMACOES_PRRC), 0, 200);
        $this->view->keywords = $dadosProdutoTags->produto_tag;
        $this->view->imagem_fb = $this->view->produto->NR_SEQ_PRODUTO_PRRC . "." . $this->view->produto->DS_EXT_PRRC;


        // agora inicio a listagem dos comentarios do produto
        $model_coments = new Default_Model_Produtoscoments();
        $select_coments_where = $model_coments->select()->from('produtos_coments')->where('DS_STATUS_PCRC = "A"');

        $this->view->select_coments_where = $select_coments_where;

        //crio a query
        $select_coments = $model_coments->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('produtos_coments', array("NR_SEQ_CADASTRO_PCRC",
                    "NR_SEQ_PRODCOMENT_PCRC",
                    "NR_SEQ_PRODUTO_PCRC",
                    "DS_AUTOR_PCRC",
                    "DS_EMAIL_PCRC",
                    "DS_COMENTARIO_PCRC",
                    "DT_COMENT_PCRC",
                    "DS_STATUS_PCRC",
                    "DS_IP_PCRC",
                    "NR_SEQ_REPLY_PCRC",
                    "NR_CURTIRAM_PCRC",
                    "NR_NAOCURTIRAM_PCRC",
                    "total_comentarios" => "(SELECT 
										 							COUNT(NR_SEQ_PRODCOMENT_PCRC)
										 						  AS
										 						  	total_comentarios
										 						  FROM 
										 						  	produtos_coments
										 						  WHERE
										 						  	NR_SEQ_PRODCOMENT_PCRC = NR_SEQ_PRODCOMENT_PCRC
										 						  AND 
										 						  	NR_SEQ_REPLY_PCRC is not null)"))
                //crio o inner join das fotos
                ->joinInner('cadastros', 'produtos_coments.NR_SEQ_CADASTRO_PCRC = cadastros.NR_SEQ_CADASTRO_CASO', array('*'))
                //agora faco a condicao de que quero o produto desejado
                ->where("NR_SEQ_PRODUTO_PCRC = ?", $idproduto)
                //somente as mensagens que nao etem resposta
                ->where("NR_SEQ_REPLY_PCRC is NULL")
                //orderno do mais novo para o ultimo
                ->order("NR_SEQ_PRODCOMENT_PCRC DESC");



        $this->view->comentarios = $model_coments->fetchAll($select_coments);

        //assino o id do produto ao view
        $this->view->idproduto = $idproduto;

        $modelTamanhos = new Default_Model_Tamanhos();
        $dadosTamanhos = $modelTamanhos->fetchAll(array('DS_STATUS_TARC = ?' => 'A'));

        $this->view->tamanhos = $dadosTamanhos;

        //inicio o model de banners
        $model_banner = new Default_Model_Banners();
        //crio a query com os banners que pertencem somente a esta pagina e ativos e depois ordeno por data de cadastro
        $select_banner = $model_banner->select()
                ->where("NR_SEQ_LOCAL_BARC = 87")
                ->where("ST_BANNER_BARC = 'A'")
                ->order("DT_CADASTRO_BARC DESC");
        //Assino ao view
        $this->view->banners = $model_banner->fetchAll($select_banner);

        // 		//crio a query para selecionar o tipo de produtos para o filtro lateral
        // $select_tipo = "SELECT
        // 					NR_SEQ_CATEGPRO_PTRC,
        // 					DS_CATEGORIA_PTRC
        // 				FROM
        // 				    produtos_tipo
        // 				WHERE
        // 					DS_STATUS_PTRC = 'A'
        // 				ORDER BY DS_CATEGORIA_PTRC ASC";
        // // Monta a query
        // $query_tipo = $db->query($select_tipo);
        // //crio uma lista de fotos
        // $lista_tipo = $query_tipo->fetchAll();
        // //assino os amigos ao view
        // $this->view->tipos = $lista_tipo;
        $this->view->nome = $usuarios->nome;
        $this->view->email = $usuarios->email;
        $this->view->cidade = $usuarios->cidade;
        $this->view->uf = $usuarios->uf;
        $this->view->ddd = $usuarios->ddd;
        $this->view->telefone = $usuarios->cel;
    }

    /**
     *
     * */
    public function avaliarprodutoAction() {
        //inicio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio a sessao de mensagem
        $mensagem = new Zend_Session_Namespace("messages");
        // Desabilita os layouts
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        //verifico se existe usuário logado com sessao
        if ($usuarios->logado == TRUE) {
            //recebo a nota do produto
            $nota = $this->_request->getParam("nota");

            //recebo o id do produto
            $idproduto = $this->_request->getParam("idproduto");
            //agora o id do usuario
            $usuario = $usuarios->idperfil;


            //inicio o model de notas
            $model_notas = new Default_Model_Produtosnotas();

            //crio o array
            $data = array("idusuario" => $usuario,
                "idproduto" => $idproduto,
                "nota" => $nota);


            try {
                //insiro no banco
                $model_notas->insert($data);

                $retorno['sucesso'] = "Avaliação realizada com sucesso";


                $this->_helper->json($retorno);
                //crio a mensagem de sucesso
                $mensagem->success = "Avaliação realizada com sucesso";

                //reorno para a pagina
                $this->_redirect($_SERVER['HTTP_REFERER']);
            } catch (Exception $e) {
                $retorno['erro'] = "Houve um problema ao avaliar o produto.";


                $this->_helper->json($retorno);

                //crio a mensagem de sucesso
                $mensagem->error = "Houve um problema ao avaliar o produto.";

                //reorno para a pagina
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
            //se nao tiver usuario logado redireciono para a ultima página
        } else {
            //mensagem de usuario
            $mensagem->error = "Você precisa estar logado para avaliar este produto";
            //retorno a ultima pagina
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     */

    public function curtircomentsAction() {
        //desabilito o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //inicio a sessao de mensagem
        $mensagem = new Zend_Session_Namespace("messages");
        //inicio o model de mensagem
        $model_mensagens = new Default_Model_Produtoscoments();
        //recupero o id da msg
        $idmsg = $this->_request->getparam("idcomentario");
        //crio a query para receber a quantidade de curtidas
        $select = $model_mensagens->select()
                ->from("produtos_coments", array("NR_SEQ_PRODCOMENT_PCRC",
                    "NR_CURTIRAM_PCRC"))
                ->where("NR_SEQ_PRODCOMENT_PCRC = ?", $idmsg);

        //recebo o resultado da pesquisa
        $resultado = $model_mensagens->fetchRow($select);
        //agora cada curtida ganha um ponto
        $total_curtida = $resultado->NR_CURTIRAM_PCRC + 1;

        $data = array("NR_CURTIRAM_PCRC" => $total_curtida);

        try {

            $model_mensagens->update($data, array("NR_SEQ_PRODCOMENT_PCRC = $idmsg"));

            $mensagem->success = "Operação realizada com sucesso.";

            $this->_redirect($_SERVER['HTTP_REFERER']);
        } catch (Exception $e) {
            var_dump($e);
            die();
        }
    }

    /*
     *
     */

    public function naocurtircomentsAction() {

        //desabilito o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //inicio a sessao de mensagem
        $mensagem = new Zend_Session_Namespace("messages");
        //inicio o model de mensagem
        $model_mensagens = new Default_Model_Produtoscoments();
        //recupero o id da msg
        $idmsg = $this->_request->getparam("idcomentario");
        //crio a query para receber a quantidade de curtidas
        $select = $model_mensagens->select()
                ->from("produtos_coments", array("NR_SEQ_PRODCOMENT_PCRC",
                    "NR_NAOCURTIRAM_PCRC"))
                ->where("NR_SEQ_PRODCOMENT_PCRC = ?", $idmsg);
        //recebo o resultado da pesquisa
        $resultado = $model_mensagens->fetchRow($select);
        //agora cada curtida ganha um ponto
        $total_curtida = $resultado->NR_NAOCURTIRAM_PCRC + 1;

        $data = array("NR_NAOCURTIRAM_PCRC" => $total_curtida);

        $model_mensagens->update($data, array("NR_SEQ_PRODCOMENT_PCRC = $idmsg"));

        $mensagem->success = "Operação realizada com sucesso.";

        $this->_redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     *
     */
    public function apagarComentarioAction() {

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
                    $model_mensagens = new Default_Model_Produtoscoments();
                    $model_mensagens->update(array('DS_STATUS_PCRC' => 'I'), array('NR_SEQ_COMENTARIO_CRRC = ?' => $idcomentario));
                }
            }

            $messages->success = "Comentário inativado com sucesso.";
        } catch (Exception $ex) {
            $messages->error = "Ocorreu um erro ao inativar o comentário.";
        }

        $this->_redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     *
     */
    public function comentarprodutoAction() {

        //desabilito o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //inicio a sessao de mensagem
        $messages = new Zend_Session_Namespace("messages");
        //inicio o model de mensagem
        $model_mensagens = new Default_Model_Produtoscoments();
        //inicio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");
        //verifico se o usuario esta logado
        if ($usuarios->logado == true) {
            //se for post
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
                        $this->_redirect($_SERVER['HTTP_REFERER']);
                        echo "Failed";
                    }
                }

                //recebo os parametros para comentar

                $idmensagem = $this->_request->getParam("idmensagem");
                $idproduto = $this->_request->getParam("idproduto");

                $modelProduto = new Default_Model_produtos();
                $dadosProduto = $modelProduto->fetchRow(array('NR_SEQ_PRODUTO_PRRC = ?' => $idproduto));

                $mail = $usuarios->email;
                $idusuario = $usuarios->idperfil;
                $nome = $usuarios->nome;
                //verifico se existe usuário logado
                if ($idusuario == "") {
                    $mail = $this->_request->getParam("comentario_email");
                    $nome = $this->_request->getParam("comentario_nome");
                }

                if ($idusuario == 2 || $idusuario == 4162 || $idusuario == 22652) {
                    $status = 'A';
                } else {
                    $status = 'I';
                }

                $extensao = $this->_request->getParam("extensao");

                $foto_produto = $idproduto . "." . $extensao;

                $url_comentario = "http://reverbcity.com/Readm_911s/grupos_comentarios.php?idp=" . $idproduto;

                $foto_produto = $this->view->fotoproduto($idproduto);
                $foto_produto = $foto_produto[0]['NR_SEQ_FOTO_FORC'] . "." . $foto_produto[0]['DS_EXT_FORC'];

                //se o campo comentário estiver vazio acusa mensagem de erro
                if ($this->_request->getParam("comentario") != null || $this->_request->getParam("comentario") != '' || $this->_request->getParam("new-comment") != null || $this->_request->getParam("new-comment") != '') {
                    //se não tiver nenhuma mensagem quer dizer que é um topico novo
                    if ($idmensagem == "") {

                        $dadosMensagemAnterior = $model_mensagens->fetchRow(array(
                            'NR_SEQ_CADASTRO_PCRC = ?' => $idusuario,
                            'DS_COMENTARIO_PCRC = ?' => $this->_request->getParam("comentario")
                        ));

                        if ($dadosMensagemAnterior) {
                            $messages->error = "Este comentário já foi enviado. Por favor aguarde a aprovação!";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }

                        $data = array("NR_SEQ_CADASTRO_PCRC" => $idusuario,
                            "NR_SEQ_PRODUTO_PCRC" => $idproduto,
                            "DS_AUTOR_PCRC" => $nome,
                            "DS_EMAIL_PCRC" => $mail,
                            "DS_COMENTARIO_PCRC" => $this->_request->getParam("comentario"),
                            "DS_STATUS_PCRC" => $status,
                            "DS_IP_PCRC" => $_SERVER["REMOTE_ADDR"],
                            "NR_CURTIRAM_PCRC" => 0,
                            "NR_NAOCURTIRAM_PCRC" => 0);
                        //senão é uma mensagem de resposta
                    } else {
                        $dadosMensagemAnterior = $model_mensagens->fetchRow(array(
                            'NR_SEQ_CADASTRO_PCRC = ?' => $idusuario,
                            'DS_COMENTARIO_PCRC = ?' => $this->_request->getParam("new-comment")
                        ));

                        if ($dadosMensagemAnterior) {
                            $messages->error = "Este comentário já foi enviado. Por favor aguarde a aprovação!";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }

                        $data = array("NR_SEQ_CADASTRO_PCRC" => $idusuario,
                            "NR_SEQ_PRODUTO_PCRC" => $idproduto,
                            "DS_AUTOR_PCRC" => $nome,
                            "DS_EMAIL_PCRC" => $mail,
                            "DS_COMENTARIO_PCRC" => $this->_request->getParam("new-comment"),
                            "DS_STATUS_PCRC" => $status,
                            "NR_SEQ_REPLY_PCRC" => $idmensagem,
                            "DS_IP_PCRC" => $_SERVER["REMOTE_ADDR"],
                            "NR_CURTIRAM_PCRC" => 0,
                            "NR_NAOCURTIRAM_PCRC" => 0);

                        $data['DS_COMENTARIO_PCRC'] = strip_tags($data['DS_COMENTARIO_PCRC'], '<a>');

                        $selectMensagem = $model_mensagens->select()
                                ->from(array('pc' => 'produtos_coments'), array())
                                ->join(array('c' => 'cadastros'), 'c.nr_seq_cadastro_caso = pc.nr_seq_cadastro_pcrc', array())
                                ->columns(array(
                                    'nome' => 'c.ds_nome_caso',
                                    'email' => 'c.ds_email_caso'
                                ))
                                ->where('pc.NR_SEQ_PRODCOMENT_PCRC = ?', $idmensagem)
                                ->setIntegrityCheck(false);
                        $dadosMensagem = $model_mensagens->fetchRow($selectMensagem);

                        $mensagem = "<tr>
    									<td colspan=\"2\" width=\"283\" height=\"277\" style=\"color: #646464; background-color: #dcddde; font-size: 12px; font-family: Verdana\">
    										<p width=\"243\" style=\"margin-top:-90px; margin-left:22px;\">
    											Olá <b>" . $dadosMensagem->nome . "</b>!<br><br>

    											" . $nome . " respondeu seu comentário, clique <a href=" . $_SERVER['HTTP_REFERER'] . ">aqui</a> para visualizar.

    										</p>
    									</td>
    								<td colspan=\"6\" width=\"300\" height=\"277\"  style=\"color: #646464; background-color: #dcddde;\">
    										<a href='" . $url_comentario . "'style=\"text-decoration:none;\"'>
    											<img src=\"http://reverbcity.com/thumb/fotosprodutos/2/245/277/" . $foto_produto . "\" style=\"padding-left: 40px;\"/>
    										</a>
    									</td>
    									<td style=\"color: #646464; background-color: #dcddde;\" width=\"15\" height=\"277\">

    									</td>
    								</tr>
    								<tr>
    									<td colspan=\"9\" width=\"598\" height=\"17\" style=\"color: #646464; background-color: #dcddde;\">

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
                        $mail->setSubject("Novo Comentário Produto");
                        $mail->send($mailTransport);
                    }
                } else {
                    //mensagem de erro para o usuário
                    $messages->error = "Você precisa digitar uma mensagem";
                    //redireciono
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }
                try {

                    $id_mensagem = $model_mensagens->insert($data);

                    if ($idusuario == '2' || $idusuario == '4162' || $idusuario == '22652') {
                        $messages->success = "Seu comentário incluído com sucesso.";
                    } else {
                        $mensagem = "<tr>
									<td colspan=\"2\" width=\"283\" height=\"277\" style=\"color: #646464; background-color: #dcddde; font-size: 12px; font-family: Verdana\">
										<p width=\"243\" style=\"margin-top:-90px; margin-left:22px;\">
											O usuário, <b>" . $data["DS_AUTOR_PCRC"] . "</b> Comentou um produto.</br></br>
                                                                                            
                                                                                        " . nl2br($data['DS_COMENTARIO_PCRC']) . "
											
											Para aprovar o comentário deste produto basta clicar <a href='https://www.reverbcity.com/Readm_911s/grupos_comentarios_aprovar.php?idcomentario={$id_mensagem}&url=https://www.reverbcity.com/produto/{$this->view->createslug($dadosProduto->DS_PRODUTO_PRRC)}/{$dadosProduto->NR_SEQ_PRODUTO_PRRC}'>aqui</a> <br /><br />
                                                                                        Para ver o produto clique <a href='https://www.reverbcity.com/produto/{$this->view->createslug($dadosProduto->DS_PRODUTO_PRRC)}/{$dadosProduto->NR_SEQ_PRODUTO_PRRC}'>aqui</a>

											Obs: Você deverá estar logado no sistema administrativo para isso.
										</p>
									</td>
									<td colspan=\"6\" width=\"300\" height=\"277\"  style=\"color: #646464; background-color: #dcddde;\">
										<a href='" . $url_comentario . "'style=\"text-decoration:none;\"'>
											<img src=\"http://reverbcity.com/thumb/fotosprodutos/2/245/277/" . $foto_produto . "\" style=\"padding-left: 40px;\"/>
										</a>
									</td>
									<td style=\"color: #646464; background-color: #dcddde;\" width=\"15\" height=\"277\">
									
									</td>
								</tr>
								<tr>
									<td colspan=\"9\" width=\"598\" height=\"17\" style=\"color: #646464; background-color: #dcddde;\">
										
									</td>
								</tr>";

                        // Busca o conteudo do topo e do rodape
                        $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_indicacao.html");
                        $topo = str_replace('Indicação de Seu Amigo', 'NOVO COMENTÁRIO', $topo);

                        $rodape = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/rodape_indicacao.html");
                        //crio o corpo á ser enviado para o cliente
                        $body = "";
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
                        $contatos = array("marcio" => "marcio@reverbcity.com",
                            "miri" => "atendimento@reverbcity.com",
                            "tony" => "contato@reverbcity.com",
                            'daniel' => 'desenvolvimento@reverbcity.com');

                        foreach ($contatos as $key => $contato) {
                            $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                            $emailAdm = "atendimento@reverbcity.com";
                            $mail = new Zend_Mail('UTF-8');
                            $mail->setBodyHtml($body);
                            $mail->addTo($contato, "Reverbcity - A Música que veste");
                            $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                            $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email válido do seu dominio
                            $mail->setSubject("Novo Comentário Produto");
                            $mail->send($mailTransport);
                        }

                        $messages->success = "Seu comentário incluído com sucesso, assim que for aprovado será visto por todos, Obrigado.";
                    }

                    $this->_redirect($_SERVER['HTTP_REFERER']);
                } catch (Exception $e) {
                    var_dump($e);
                    die();
                }
            } else {

                $messages->error = "Você não pode acessar esta página por aqui.";

                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            //mensagem de erro para o usuário
            $messages->error = "Você precisa estar logado para comentar um produto";
            //redireciono
            $this->_redirect("/cadastro-rapido");
        }
    }

    /**
     * Função responsável pelo avise'me
     * */
    public function avisemeprodutoAction() {
        // Desabilita os layouts
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");

        //inicio a sessao de usuários
        $usuarios = new Zend_Session_Namespace("usuarios");


        if ($this->_request->isPost()) {

            $model_avisame = new Default_Model_Aviseme();

            $data = array("NR_SEQ_PRODUTO_AVRC" => $this->_request->getParam("idproduto"),
                "NR_SEQ_TAMANHO_AVRC" => $this->_request->getParam("tamanho"),
                "NR_SEQ_CADASTRO_AVRC" => $usuarios->idperfil,
                "DS_NOME_AVRC" => $this->_request->getParam("NomeCompleto"),
                "DS_EMAIL_AVRC" => $this->_request->getParam("Email"),
                "DS_TELEFONE_AVRC" => $this->_request->getParam("Telefone"),
                "DS_OBSERVACAO_AVRC" => $this->_request->getParam("observacoes"),
                "ST_AVISO_AVRC" => 'N',
                "ST_JACOMPROU_AVRC" => 'N',
                "DS_CIDADE_AVRC" => $this->_request->getParam("cidade"),
                "DS_UF_AVRC" => $this->_request->getParam("estado"));

            $model_avisame->insert($data);

            $messages->success = "Te avisaremos assim que o produto voltar em estoque.";

            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Função do json de medidas
     * */
    public function jsonmedidasAction() {

        //crio a query para trazer as tabelas de medidas
        $model_modelos = new Default_Model_Modelostamanhos();
        //passo o id do produto
        $idproduto = $this->_request->getParam("idproduto");

        //inicio a query de modelos
        $select_modelos = $model_modelos->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('modelos_has_tamanhos', array(
                    'idmodelo_has_tamanho',
                    'idmodelo',
                    'idtamanho'
                ))
                ->columns(array(
                    'imagem_tamanho' => '(select imagem_tamanho from modelos_has_tamanhos mht where mht.idmodelo = modelos.idmodelo and mht.idtamanho = tamanhos_medidas.idtamanho order by mht.idmodelo_has_tamanho desc limit 1)'
                ))
                //crio o inner join das modelos
                ->joinInner('modelos', 'modelos_has_tamanhos.idmodelo = modelos.idmodelo', array('*'))
                //join das medidas
                ->joinInner('tamanhos_medidas', 'modelos_has_tamanhos.idtamanho = tamanhos_medidas.idtamanho', array('*'))
                //join dos produtos
                ->joinInner('produtos', 'modelos.idmodelo = produtos.NR_SEQ_MODELO_PRRC', array('NR_SEQ_PRODUTO_PRRC'))
                //pego somento o produto
                ->where("produtos.NR_SEQ_PRODUTO_PRRC = ?", $idproduto)
                //ordeno pelo tamanho
                ->group('tamanho')
                ->order('tamanhos_medidas.ordem_tabela');

        $medidas = $model_modelos->fetchAll($select_modelos)->toArray();

        //crio o json
        $this->_helper->json($medidas);
    }

    /*
     * Função responsavel por indicar um produto
     */

    public function indiqueprodutoAction() {
        // Cria a sessão das mensagens
        $session = new Zend_Session_Namespace("messages");
        //pego a ultima url(a indicada)
        $url_indicada = $_SERVER['HTTP_REFERER'];
        //inicio o model de indicacoes
        $model_indicacao = new Default_Model_Indicacoes();

        if ($this->_request->isPost()) {




            $idproduto = $this->_request->getParam("idproduto");

            $extensao = $this->_request->getParam("extensao");

            $nome_produto = $this->_request->getParam("nome_produto");

            $foto_produto = $idproduto . "." . $extensao;

            $url_indicada = "http://reverbcity.com/produto/indicacao-amigo/" . $idproduto;

            $data = array("url_indicada" => $url_indicada,
                "quem_indicou" => $this->_request->getParam("Nome"),
                "email_quem_indicou" => $this->_request->getParam("Email"),
                "quem_recebeu" => $this->_request->getParam("NomeAmigo"),
                "email_quem_recebeu" => $this->_request->getParam("EmailAmigo"),
                "mensagem" => $this->_request->getParam("mensagem"));

            try {
                $model_indicacao->insert($data);


                $mensagem = "<tr>
								<td colspan=\"2\" width=\"283\" height=\"277\" style=\"color: #646464; background-color: #dcddde; font-size: 12px; font-family: Verdana\">
									<p width=\"243\" style=\"margin-top:-90px; margin-left:22px;\">
										Olá <b>" . $data["quem_recebeu"] . ",</b></br></br>

										O seu amigo <b>" . $data["quem_indicou"] . "</b> indicou este produto para você
										no site da <b><a style=\"text-decoration:none; color: #646464;\" href='http://www.reverbcity.com'>Reverbcity</a></b></br></br>
										Clique na imagem ao lado para conhecer.</br></br>

										<b>Mensagem do seu amigo: </b></br>
										" . $data["mensagem"] . "
									</p>
								</td>
								<td colspan=\"6\" width=\"300\" height=\"277\"  style=\"color: #646464; background-color: #dcddde;\">
									<a href='" . $data["url_indicada"] . "'style=\"text-decoration:none;\"'>
										<img src=\"http://reverbcity.com/thumb/produtos/2/245/277/" . $foto_produto . "\" style=\"
    padding-left: 40px;\"/>
									</a>
								</td>
								<td style=\"color: #646464; background-color: #dcddde;\" width=\"15\" height=\"277\">
								
								</td>
							</tr>
							<tr>
								<td colspan=\"9\" width=\"598\" height=\"17\" style=\"color: #646464; background-color: #dcddde;\">
									
								</td>
							</tr>";

                // Busca o conteudo do topo e do rodape
                $topo = file_get_contents(APPLICATION_PATH . "/../arquivos/emails/topo_indicacao.html");

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

}
