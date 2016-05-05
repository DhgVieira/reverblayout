<?php

/**
 * Cria o plugin para carregar informações para todo o site
 *
 * @name Reverb_Controller_Plugin_Geral
 */
class Reverb_Controller_Plugin_Geral extends Zend_Controller_Plugin_Abstract
{
    /**
     * Método da classe
     *
     * @name preDispatch
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Busca o view
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
        $viewRenderer->initView();
        $view = $viewRenderer->view;

        if (substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], ".")) == ".jpg") {
            return TRUE;
        }

        if ($this->_request->getParam("module") == "user") {
            return TRUE;
        }

        if ( APPLICATION_ENV == 'production' && $this->_request->getParam("controller") != "landing") {
            if (substr($_SERVER['HTTP_HOST'], 0, 4) !== 'www.') {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: https://www.' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        //variaveis para identificar mobile

        $iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");

        //se for mobile eu vou assinar uma variavel para identificar e remover um menu
        if ($iphone || $android || $palmpre || $ipod || $iPad || $berry == true) {
            //se entrar e porque e dispositivo movel e assino ao view como true
            $ismobile = true;
            //assino ao view
            $view->_isMobile = $ismobile;

        }

        //inicio a sessao do carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicia a sessao de cep
        $cep_session = new Zend_Session_Namespace("cep_session");
        //inicio a sessao de produtos vistos
        $produtos_vistos = new Zend_Session_Namespace("vistos");
        $sessao_promo = new Zend_Session_Namespace("promocoes");

        date_default_timezone_set('America/Sao_Paulo');

        $server = $_SERVER['SERVER_NAME'];
        $endereco = $_SERVER ['REQUEST_URI'];

        $pagina = "https://www." . $server . $endereco;
        //assino ao view
        $view->_pagina_atual = $pagina;

        $timestamp = time();
        $timeout = time() - 120; // valor em segundos

        $ip_user = $_SERVER["REMOTE_ADDR"];
        $PHP_SELF = $_SERVER["SCRIPT_NAME"];
        //atribuo o id do usuario senao tiver logado ezero
        if ($usuarios->logado == TRUE) {
            $usuario = $usuarios->idperfil;
        } else {
            $usuario = 0;
        }

        $db1 = Zend_Db_Table::getDefaultAdapter();
        // Insere o valor das variaveis em um array
        $data = array('timestamp' => $timestamp,
            'ip' => $ip_user,
            'arquivo' => $PHP_SELF,
            'nrseq_cad' => $usuario);
        // Insere o valor do array no tabela do banco de dados
        $db1->insert("useronline", $data);

        $deleta_user = "DELETE FROM useronline WHERE timestamp < $timeout";
        //delto os antigos
        $query_deleta = $db1->query($deleta_user);


        //faço a query dos usuarios on line
        $select_ip = "SELECT count(DISTINCT
                                            ip ) as ip
                                            FROM 
                                    useronline";

        // Monta a query
        $query_ip = $db1->query($select_ip);
        //agora crio a lista de usuarios
        $lista_users = $query_ip->fetchAll();

        //agora conto quantos usuários on line tem
        $total_usuarios = $lista_users[0]["ip"] + 8;
        //assino ao view
        $view->_totalusers = $total_usuarios;

        //inicio o model de produtos
        $model_produtos = new Default_Model_Produtos();

        if ($usuarios->logado == TRUE) {
            $data_nascimento = strtotime($usuarios->nascimento);
            $mes_nascimento = date('m', $data_nascimento);
            $mes_atual = date('m');

            if ($mes_atual == $mes_nascimento) {
                if ($_COOKIE['popup_niver'] == 1) {
                    $view->popupNiver = false;
                } else {
                    $view->popupNiver = true;
                    $date_of_expiry = time() + 60 * 60 * 6;
                    setcookie("popup_niver", "1", $date_of_expiry, "/");
                }
            }

            /************
             * RECADOS PUBLICOS
             *************/

            //inicio o model de scraps
            $model_scraps = new Default_Model_Mescraps();

            //faco o select dos scraps publicos
            $select_scraps = $model_scraps->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                    'cadastros.NR_SEQ_CADASTRO_CASO = me_scraps.NR_SEQ_AUTOR_SBRC', array('NR_SEQ_CADASTRO_CASO', 'DS_NOME_CASO', 'DS_EXT_CACH'))
                ->where("ST_PUBLICO_SBRC = 0")
                ->where("NR_SEQ_CADASTRO_SBRC = ?", $usuarios->idperfil)
                ->where("ST_LIDA_SBRC = 0")
                ->limit(2)
                ->order("DT_POST_SBRC DESC");

            // Busca o cache
            $idCache2 = md5((string)$select_scraps);
            //Zend_Registry::get("cache")->remove($idCache2);

            $lista_recados = Zend_Registry::get("cache")->load($idCache2);

            // Se nao existir o cache faz consulta
            if (!$lista_recados) {
                $lista_recados = $model_scraps->fetchAll($select_scraps)->toArray();

                Zend_Registry::get("cache")->save($lista_recados, $idCache2);
            }

            $view->_publicos = $lista_recados;

            //faco o select dos scraps privados
            $select_privados = $model_scraps->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                    'cadastros.NR_SEQ_CADASTRO_CASO = me_scraps.NR_SEQ_AUTOR_SBRC', array('NR_SEQ_CADASTRO_CASO', 'DS_NOME_CASO', 'DS_EXT_CACH'))
                ->where("ST_PUBLICO_SBRC = 1")
                ->where("NR_SEQ_CADASTRO_SBRC = ?", $usuarios->idperfil)
                ->where("ST_LIDA_SBRC = 0")
                ->limit(3)
                ->order("DT_POST_SBRC DESC");

            // Busca o cache
            $idCache2 = md5((string)$select_privados);

            $lista_recados_privado = Zend_Registry::get("cache")->load($idCache2);

            // Se nao existir o cache faz consulta
            if (!$lista_recados_privado) {
                $lista_recados_privado = $model_scraps->fetchAll($select_privados)->toArray();

                Zend_Registry::get("cache")->save($lista_recados_privado, $idCache2);
            }

            //assino ao view
            $view->_privados = $lista_recados_privado;

            //crio a query para selecionar os comentarios
            $select_total_amigos = "SELECT
                            *
                    FROM 
                            autorizacoes
                    INNER JOIN
                            cadastros
                    ON 
                            cadastros.NR_SEQ_CADASTRO_CASO = autorizacoes.NR_SEQ_CADASTRO_AURC
                    WHERE
                            NR_SEQ_ME_AURC = $usuarios->idperfil
                    AND 
                            ST_CHAVE_AURC = 'I'";

            // Busca o cache
            $idCache2 = md5((string)$select_total_amigos);

            $lista = Zend_Registry::get("cache")->load($idCache2);
            $lista = false;
            // Se nao existir o cache faz consulta
            if (!$lista) {
                // Monta a query
                $query = $db1->query($select_total_amigos);
                //crio uma lista de comentarios
                $lista = $query->fetchAll();

                Zend_Registry::get("cache")->save($lista, $idCache2);
            }

            //assino quantidade de amigos ao view
            $view->_amigos = $lista;

            //atribuo 1 para variavel logado para mostrar os itens do menu
            $view->_logado = 1;
            //assino as variaveis do usuario logado

            $view->_email_usuario = $usuarios->email;
            $view->_nome_usuario = $usuarios->nome;
            $view->_idperfil = $usuarios->idperfil;
            $view->_tipo = $usuarios->tipo;
        }else{
            $view->popupNiver = false;
        }
        /************
         * SUGESTAO DE PRODUTOS
         *************/

        // Busca o cache
        $idCache2 = 'produtos_sugestoes';

        $sugestoes_produtos = Zend_Registry::get("cache")->load($idCache2);

        // Se nao existir o cache faz consulta
        if (!$sugestoes_produtos) {
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
                ->where("NR_SEQ_CATEGORIA_PRRC = 179")
                //removo os buttons
                ->where("NR_SEQ_TIPO_PRRC not in (4,24,139,140,65)")
                //ordeno randomicamente
                ->order("RAND()")
                //limito em 4
                ->limit(4);

            $sugestoes_produtos = $model_produtos->fetchAll($select_sugestoes);

            Zend_Registry::get("cache")->save($sugestoes_produtos, $idCache2);
        }

        //assino ao view
        $view->_sugestoes = $sugestoes_produtos;
        //assino os ultimos produtos visualizados
        $view->_visitados = $produtos_vistos->produtos;


        //assino ao view o cep e o valor do frete
        $view->_cepinformado = $cep_session->cep;
        $view->_valorfrete = $cep_session->valor;


        /************
         *Produto Dia
         *************/

        // Busca o cache
        $idCache1 = "produto_dia";

        $lista_produtos = Zend_Registry::get("cache")->load($idCache1);

        // Se nao existir o cache faz consulta
        if (!$lista_produtos) {

            //crio a query do produto do dia
            $db_prod = Zend_Registry::get("db");
            //crio a query para selecionar o banner do produto do dia
            $select_produto_dia = "SELECT
                            *
                    FROM 
                            banners_agendados
                    WHERE
                            ST_ATUAL_BARC = 'S'
                    ORDER BY 
                            DT_PUBLICACAO_BARC
                    DESC
                    LIMIT 1";


            // Monta a query
            $query_produto_dia = $db_prod->query($select_produto_dia);

            //crio uma lista de comentarios
            $lista_produtos = $query_produto_dia->fetchAll();
            //vejo se tem produto do dia atual
            if (!$lista_produtos[0]['NR_SEQ_PRODUTO_BARC']) {

                //crio a query para selecionar o banner do produto do dia
                $select_produto_dia = "SELECT
                                                    *
                                            FROM 
                                                    banners_agendados
                                            ORDER BY 
                                                    DT_PUBLICACAO_BARC
                                            DESC
                                            LIMIT 1";


                // Monta a query
                $query_produto_dia = $db_prod->query($select_produto_dia);

                //crio uma lista de comentarios
                $lista_produtos = $query_produto_dia->fetchAll();

                // Salva o cache
                Zend_Registry::get("cache")->save($lista_produtos, $idCache1);
            }

        }

        // Busca o cache
        $idCache2 = "produto_dia1";

        $lista_produto_dia = Zend_Registry::get("cache")->load($idCache2);


        // Se nao existir o cache faz consulta
        if (!$lista_produto_dia) {

            //agora crio a query para pegar as informações do produto do dia
            $select_dia = $model_produtos->select()
                //seto integridade false
                ->setIntegrityCheck(FALSE)
                //falo a tabela
                ->from("produtos", array("NR_SEQ_PRODUTO_PRRC",
                    "DS_EXT_PRRC",
                    "VL_PRODUTO_PRRC",
                    "VL_PROMO_PRRC",
                    "DS_PRODUTO_PRRC",
                    "DS_FRETEGRATIS_PRRC",
                    "NR_SEQ_TIPO_PRRC"))
                ->where("NR_SEQ_PRODUTO_PRRC = " . $lista_produtos[0]['NR_SEQ_PRODUTO_BARC']);

            $lista_produto_dia = $model_produtos->fetchRow($select_dia);

            // Salva o cache
            Zend_Registry::get("cache")->save($lista_produto_dia, $idCache2);

        }

        //assino quantidade de amigos ao view
        $view->_produto_dia = $lista_produto_dia;

        $dia_aniversario = explode("-", $usuarios->nascimento);
        $dia_aniversario = $dia_aniversario[1];
        $hoje = date("m");

        $model_produto = $model_produtos;

        //inicio o model de promocoes
        $model_promo = new Default_Model_Promocoes();
        //assino os valores na variavel
        $promocoes = $model_promo->fetchRow();
//
//        uasort($carrinho->produtos, function($a, $b) {
//            return $b['total_produto'] - $a['total_produto'];
//        });
        //$sessao_promo->niver = 0;
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
                    "vl_promo_m" => "VL_PROMO_M_PRRC",
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
                "vl_promo" => $item['vl_promo'],
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

            // Promo caneca ou poster grátis da compra de uma estilos musicais
            if($data_carrinho[$key]['categoria'] == 186){
                $tem_estilos_musicais = 1;
            }
            if(($data_carrinho[$key]['categoria'] == 57 or $data_carrinho[$key]['categoria'] == 173) and $tem_estilos_musicais == 1 and $tem_estilos_musicais_brinde == 0 and $tem_cheio == 1){
                $data_carrinho[$key]['valor'] = 0;
                $carrinho->produtos[$key]['valor'] = 0;
                $data_carrinho[$key]['vl_promo'] = 0;
                $carrinho->produtos[$key]['vl_promo'] = 0;
                $tem_estilos_musicais_brinde = 1;
            }
            // Fim promo

            /**
             *  Promo de preço para tamanho M
             */
            if($row_produto['vl_promo_m'] > 0 and ($item['tamanho'] == 3 or $item['tamanho'] == 8)){
                $data_carrinho[$key]['vl_promo'] = $row_produto['vl_promo_m'];
                $carrinho->produtos[$key]['vl_promo'] = $row_produto['vl_promo_m'];
            }

            $modelEstoque = new Default_Model_Estoque();
            $dadosEstoque = $modelEstoque->fetchRow(array('NR_SEQ_ESTOQUE_ESRC = ?' => $key));

            if($dadosEstoque->NR_VALOR_ESRC){
                $data_carrinho[$key]['vl_promo'] = $dadosEstoque->NR_VALOR_ESRC;
                $carrinho->produtos[$key]['vl_promo'] = $dadosEstoque->NR_VALOR_ESRC;
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

                if($usuarios->logado == true){
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
                }

                //se tiver como nulo significa que é a primeira compra
                if ($primeira_compra[0] == Null) {
                    if($usuarios->logado == true) {
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
                    }
                    //agora verifico se o tempo de cadastro e maior que 90 dias
                    //if ($tempo_cadastro[0]["diferenca"] <= 90 and $ja_tem_brinde == 0) {
                    if ($ja_tem_brinde == 0) {

                        //agora verifico se existe mais de 150 em compras e se ainda não entrou brinde para ele
//                            if ($valor_total >= $promocoes["vl_primeira_compra"]) {
//
//                                //se tiver apenas 1
//                                if ($item['quantidade'] == 1) {
//                                    //se tiver um de preco cheio
//                                    if ($tem_cheio == 1) {
//
//                                        //agora vejo se e camiseta
//                                        if ($item["tipo"] == 6) {
//
//                                            //agora vejo se o item atual é de valor de 69 ou menor
//                                            if ($data_carrinho[$key]['valor'] <= 69 or $data_carrinho[$key]['vl_promo'] <= 69) {
//                                                //defino os valores como 0
//                                                $data_carrinho[$key]['vl_promo'] = 0;
//                                                $data_carrinho[$key]['valor'] = 0;
//                                                $carrinho->produtos[$key]["brinde"] = 1;
//
//                                                //agora assino a mensagem a promo
//                                                $sessao_promo->msg = $msg_promo;
//
//                                                $this->view->primeira_compra = 1;
//
//                                                //falo que ele ja ganhou um brinde
//                                                $ja_tem_brinde = 1;
//                                                //agora atribuo como verdadeiro a sessao de primeira compra
//                                                $sessao_promo->primeira = 1;
//                                                $sessao_promo->brinde = 1;
//                                            }
//                                        }
//                                    }
//                                }
//                            }

                        if ($usuarios->tipo <> 'PJ') {
                            if ($data_carrinho[$key]['vl_promo'] == 0) {
                                if ($data_carrinho[$key]['valor'] >= 59) {
                                    $sessao_promo->primeira = 1;
                                    $sessao_promo->brinde = 1;

                                    $msg_promo = $promocoes["msg_primeira_compra"];
                                    $sessao_promo->msg = $promocoes["msg_primeira_compra"];

                                    $credito_proxima_compra += $data_carrinho[$key]['valor'] * 0.15;
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
//            if ($data_carrinho[$key]['vl_promo'] == 0) {
//                $valor_produto_promo = $data_carrinho[$key]['valor'];
//            } else {
//                $valor_produto_promo = $data_carrinho[$key]['vl_promo'];
//            }
//
//            //verifico se a promo de aniversário esta ativa
//            if ($promocoes["st_promo_niver"] == 1) {
//
//                $ano_atual = date("Y");
//
//                // deixo a data de aniversario como a data de hoje para ativar a promo de dia dos namorados
//                // $dia_aniversario = $hoje;
//                // se hoje for o dia do aniversario do usuario atribuo como aniversariante e não for PJ
//
//                if ($dia_aniversario == date('m') and $usuarios->tipo <> 'PJ') {
//
//                    // Cria o objeto de conexão
//                    $db = Zend_Registry::get("db");
//                    //crio a query para verificar se o usuário tem alguma compra que não seja cancelada no mes
//                    $select_compra_mes = "SELECT
//                                                                                                NR_SEQ_CADASTRO_COSO
//                                                                                         from
//                                                                                                compras,
//                                                                                                cadastros
//                                                                                         WHERE
//                                                                                                NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
//                                                                                         and
//                                                                                MONTH(DT_COMPRA_COSO) = $hoje
//                                                                         AND
//                                                                                YEAR(DT_COMPRA_COSO) = $ano_atual
//                                                                         AND
//                                                                                ST_COMPRA_COSO <> 'C'
//
//                                                                        and NR_SEQ_CADASTRO_CASO = $usuarios->idperfil";
//                    // die($select_compra_mes);
//                    //executo a query
//                    $query_compra_niver = $db->query($select_compra_mes);
//
//                    //crio uma varivel que recebe a primeira compra ou fica vazia
//                    $compra_niver = $query_compra_niver->fetchAll();
//
//                    if ($compra_niver[0] == Null) {
//                        //if ($sessao_promo->niver == 1) {
//
//                        //agora verifico se o produto e valor maior que o ultimo e se ainda não entrou brinde para ele e se é camiseta
////                                if ($valor_cheio >= $valor_produto_promo and $ja_tem_brinde == 0 and $data_carrinho[$key]['tipo'] == 6 and $tem_cheio == 1) {
////
////                                    //se tiver apenas 1
////                                    if ($item['quantidade'] == 1) {
////                                        //defino os valores como 0
////
////                                        $data_carrinho[$key]['vl_promo'] = 0;
////                                        $data_carrinho[$key]['valor'] = 0;
////                                        $carrinho->produtos[$key]["brinde"] = 1;
////                                        $carrinho->produtos[$key]["brinde"];
////                                        //falo que ele ja ganhou um brinde
////                                        $ja_tem_brinde = 1;
////                                        //agora atribuo como verdadeiro a sessao de primeira compra
////                                        $sessao_promo->niver = 1;
////                                        $sessao_promo->brinde = 1;
////                                    }
////                                }
//                        if ($data_carrinho[$key]['vl_promo'] == 0) {
//                            if ($data_carrinho[$key]['valor'] >= 59) {
//                                //é aniversariante
//                                $aniversariante == true;
//                                //atribuo a mensagem para o carrinho
//                                $msg_promo = $promocoes["msg_promo_niver"];
//                                //agora assino a mensagem a promo
//                                $sessao_promo->msg = $msg_promo;
//
//                                $this->view->compra_niver = 1;
//
//                                $valor = $data_carrinho[$key]['valor'] * $item['quantidade'];
//
//                                $sessao_promo->valor_desconto += $valor * 0.2;
//
//                                $valor = $valor - ($valor * 0.2);
//                                $sessao_promo->niver = 1;
//                                $sessao_promo->brinde = 1;
//
//                                $data_carrinho[$key]['valor_total_desconto'] = $valor;
//                                $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
//                            }
//                        }
//                        //}
//                    }
//                }
//            }

            //-----------------------------------------//
            //  Promo ganhe outra quem nunca comprou   //
            //-----------------------------------------//

//            if($usuarios->logado == true){
//                // Cria o objeto de conexão
//                $db = Zend_Registry::get("db");
//                //crio a query para verificar se o usuário tem alguma compra que não seja cancelada
//                $select_compra = "SELECT
//                                                NR_SEQ_CADASTRO_COSO
//                                         from
//                                                compras,
//                                                cadastros
//                                         WHERE
//                                                NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
//                                         AND
//                                                ST_COMPRA_COSO <> 'C'
//
//                                         AND NR_SEQ_CADASTRO_CASO = $usuarios->idperfil";
//                // die($select_compra_mes);
//                //executo a query
//                $query_compra = $db->query($select_compra);
//
//                //crio uma varivel que recebe a primeira compra ou fica vazia
//                $dadosCompra = $query_compra->fetchAll();
//            }else{
//                $dadosCompra[0] = true;
//            }
//
//            if($dadosCompra[0] == NULL and $ja_tem_brinde == 0 and $valor_total >= 150){
//
//                //é aniversariante
//                $aniversariante == true;
//                //atribuo a mensagem para o carrinho
//                $msg_promo = "Compre 1 camiseta de preço cheio e ganhe outra, a mesma de aniversario (para quem tem cadastro e nunca comprou)";
//                //agora assino a mensagem a promo
//                $sessao_promo->msg = $msg_promo;
//
//                $this->view->compra_niver = 1;
//
//                if ($tem_promo == 0) {
//
//                    //agora verifico se o produto e valor maior que o ultimo e se ainda não entrou brinde para ele e se é camiseta
//                    if ($valor_cheio >= $valor_produto_promo and $ja_tem_brinde == 0 and $data_carrinho[$key]['tipo'] == 6 and $tem_cheio == 1) {
//
//                        //se tiver apenas 1
//                        if ($item['quantidade'] == 1) {
//                            //defino os valores como 0
//
//                            $data_carrinho[$key]['vl_promo'] = 0;
//                            $data_carrinho[$key]['valor'] = 0;
//                            $carrinho->produtos[$key]["brinde"] = 1;
//                            $carrinho->produtos[$key]["brinde"];
//                            //falo que ele ja ganhou um brinde
//                            $ja_tem_brinde = 1;
//                            //agora atribuo como verdadeiro a sessao de primeira compra
//                            $sessao_promo->niver = 1;
//                            $sessao_promo->brinde = 1;
//                        }
//                    }
//                }
//            }

            //-----------------------------------------------------------------------------//
            //    Promo ganhe sale para quem só fez 1 compra ou esta 3 meses sem compra    //
            //-----------------------------------------------------------------------------//

//            // Cria o objeto de conexão
//            $db = Zend_Registry::get("db");
//            //crio a query para verificar se o usuário tem alguma compra que não seja cancelada
//            $select_compra = "SELECT
//                                    date_format(max(dt_compra_coso), '%Y-%m-%d') as ultima_compra,
//                                    count(*) as total_compra
//                                FROM
//                                    compras
//                                WHERE
//                                    st_compra_coso <> 'C'
//                                AND
//                                    NR_SEQ_CADASTRO_COSO = '".$usuarios->idperfil."'";
//            // die($select_compra_mes);
//            //executo a query
//            $query_compra = $db->query($select_compra);
//
//            //crio uma varivel que recebe a primeira compra ou fica vazia
//            $dadosCompra = $query_compra->fetchAll();
//
//            $data_limite = '2014-07-01';
//
//            if(($dadosCompra[0]['ultima_compra'] <= $data_limite || $dadosCompra[0]['total_compra'] == 1) && $ja_tem_brinde == 0){
//                //se tiver apenas 1
//                if ($item['quantidade'] == 1){
//                    //se tiver um de preco cheio
//                    if($tem_cheio == 1){
//
//                        //agora vejo se e camiseta
//                        if($data_carrinho[$key]["destaque"] == 2){
//
//                            //atribuo a mensagem para o carrinho
//                            $msg_promo = "Compre 1 camiseta de preço cheio (R$69) e ganhe outra com a tag sale (para segunda compra e cadastro com +3 meses sem compra)";
//                            //agora assino a mensagem a promo
//                            $sessao_promo->msg = $msg_promo;
//
//                            $this->view->promo_sale = 1;
//
//                            //agora vejo se e camiseta
//                            if($item["tipo"] == 6 and $ja_tem_brinde == 0){
//                                //defino os valores como 0
//                                $data_carrinho[$key]['vl_promo'] = 0;
//                                $data_carrinho[$key]['valor'] = 0;
//                                //falo que ele ja ganhou um brinde
//                                $ja_tem_brinde = 1;
//                                //agora atribuo como verdadeiro a sessao de primeira compra
//                                $sessao_promo->sale2 = 1;
//                                $sessao_promo->brinde = 1;
//
//                            }
//                        }
//                    }
//                }
//            }
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
//                                }



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
                    if ($valor_cheio >= 59) {
                        $tem_cheio = 1;
                    }
                }
            } else {

//                if ($data_carrinho[$key]["tipo"] == 142) {
//
//
//                    //jogo o valor do produto na variavel
//                    $valor = $data_carrinho[$key]['valor'] * 0.7;
//                    //jogo o valor do produto na variavel de produto cheio
//                    $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//                } else {
//                    if ($data_carrinho[$key]["destaque"] == 2) {
//
//                        //jogo o valor do produto na variavel
//                        $valor = $data_carrinho[$key]['valor'] * 0.7;
//                        //jogo o valor do produto na variavel de produto cheio
//                        $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//                    } elseif($data_carrinho[$key]['codigo'] == 5745){
//                        $valor = $data_carrinho[$key]['valor'];
//                        $valor_cheio = $data_carrinho[$key]['valor'];
//                    }else {
//                        //jogo o valor do produto na variavel
//                        $valor = $data_carrinho[$key]['valor'] * 0.7;
//                        //jogo o valor do produto na variavel de produto cheio
//                        $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//                    }
//                }

                $valor = $data_carrinho[$key]['valor'] * 0.6;

                // Se o preço promocional for menor que o com desconto
                if($data_carrinho[$key]['vl_promo'] > 0 && $valor > $data_carrinho[$key]['vl_promo']){
                    $valor = $data_carrinho[$key]['vl_promo'];
                }

                if($data_carrinho[$key]['codigo'] == 5745){
                    $valor = $data_carrinho[$key]['valor'];
                }

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

            if($data_carrinho[$key]['categoria'] == 186 and count($carrinho->produtos) == 1 and $data_carrinho[$key]['valor'] >= 59 and empty($data_carrinho[$key]['vl_promo']) and $sessao_promo->niver != 1 and $sessao_promo->primeira != 1){
                $view->exibeBrindeCanecaPoster = 1;

            }else{
                $view->exibeBrindeCanecaPoster = 0;
            }
        }
        //assino ao view
        $view->_total_carrinho = $valor_total;
        //assino a quantidade de produtos no carrinho
        $view->_totalprodutos = $carrinho->produtos;

        //armazeno a ultima url visitada
        $ultima_url = $_SERVER['HTTP_REFERER'];

//        if(strpos($ultima_url, 'aclk') > 0){
//            echo 'aclk';
//        }elseif(strpos($ultima_url, 'google.com') > 0){
//            echo 'google';
//        }

        $ultima_action = explode("/", $ultima_url);

        $view->_ultima_action = $ultima_action[3];
        //pego a hora atual
        $agora = date("H:i:s");
        //pego o dia da semana (0 para domingo e 6 para sabado);
        $dia_semana = date("w");

        //verifico se não é sabado ou domingo para o chat ficar on line
        if ($dia_semana != 0 or $dia_semana != 6) {
            //se for algum dia util, o chat ficará online, agora verifico os horarios de atendimento para ficar online
            if (($agora >= "08:30:00" AND $agora <= "11:30:00") or ($agora >= "13:00:00" AND $agora <= "17:30:00")) {
                $view->_chat_online = 1;
            } else {
                $view->_chat_online = 0;
            }
        } else {
            $view->_chat_online = 0;
        }

        $session = new Zend_Session_Namespace("login");

        if($session->logged_usuario){
            $this->view->logged_usuario = $session->logged_usuario;
        }

        if($view->popupNiver == false){

            if ($_COOKIE['popup_primeira'] == 1) {
                $view->popupPrimeira = false;
            } else {
                $view->popupPrimeira = true;
                $date_of_expiry = time() + 60 * 60 * 5;
                setcookie("popup_primeira", "1", $date_of_expiry, "/");
            }
        }
    }
}
