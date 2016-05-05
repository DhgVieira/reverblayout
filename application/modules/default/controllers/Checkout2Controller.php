<?php

/**
 *
 */
class Checkout2Controller extends Zend_Controller_Action {

    /**
     *
     */
    public function init() {

        /* Initialize action controller here */
        $captcha = new Zend_Captcha_Image(); // Este Ã© o nome da classe, no secrets...
        $captcha->setWordlen(3) // quantidade de letras, tente inserir outros valores
                ->setImgDir(APPLICATION_PATH . '/../arquivos/uploads/captcha')// o caminho para armazenar as imagens
                ->setGcFreq(10)//epagarmespecifica a cada quantas vezes o garbage collector vai rodar para eliminar as imagens invÃ¡lidas
                ->setExpiration(500)// tempo de expiraÃ§Ã£o em segundos.
                ->setHeight(80) // tamanho da imagem de captcha
                ->setWidth(130)// largura da imagemff
                ->setLineNoiseLevel(1) // o nivel das linhas, quanto maior, mais dificil fica a leitura
                ->setDotNoiseLevel(1)// nivel dos pontos, experimente valores maiores
                ->setFontSize(15)//tamanho da fonte em pixels
                ->setFont(APPLICATION_PATH . '/../arquivos/default/fonts/andes-regular.ttf'); // caminho para a fonte a ser usada
        $this->view->idCaptcha = $captcha->generate(); // passamos aqui o id do captcha para a view
        $this->view->captcha = $captcha->render($this->view); // e o proprio captcha para a view
    }

    /**
     *
     */
    public function indexAction() {
        
    }

    /**
     * Action usada somente quando adiciona ao carrinho a partir do email
     * */
    public function adicionarcarrinhoAction() {

        //crio a sessao de usuÃ¡rios
        $usuarios = new Zend_Session_Namespace("usuarios");

        //cria a sessÃ£o do carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");

        // Cria a sessÃ£o das mensagens
        $messages = new Zend_Session_Namespace("messages");
        //agora verifico se jÃ¡ completou o cadastro para poder avanÃ§ar
        // Busca o id do produto
        $idproduto = $this->_request->getParam("idproduto", 0);
        $estoque = $this->_request->getParam("idestoque", 0);
        $genero = $this->_request->getParam("genero", 0);
        $tamanho = $this->_request->getParam("tamanho", 0);
        $carrinho_id = $this->_request->getParam('carrinho_id');

        $recuperarCarrinho = new Zend_Session_Namespace("recuperar_carrinho");
        $recuperarCarrinho->carrinho_id = $carrinho_id;

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
                //faÃ§o o join
                ->joinLeft('estoque', 'produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC', array('NR_QTDE_ESRC', 'NR_SEQ_TAMANHO_ESRC'))
                ->joinLeft('tamanhos', 'estoque.NR_SEQ_TAMANHO_ESRC = tamanhos.NR_SEQ_TAMANHO_TARC', array("DS_SIGLA_TARC"))
                //faco o join dos tipos
                ->joinInner('produtos_tipo', 'produtos_tipo.NR_SEQ_CATEGPRO_PTRC = produtos.NR_SEQ_TIPO_PRRC', array('NR_SEQ_CATEGPRO_PTRC'));

        if ($idproduto) {
            //seleciono somente o produto desejado
            $select->where("NR_SEQ_PRODUTO_PRRC = ?", $idproduto);
        }
        //se o tipo do produto for diferente de 9 (vale presente acrescento o estoque na pesquisa)
        if ($tipo_prod->NR_SEQ_TIPO_PRRC != 9) {
            $select->where("NR_SEQ_ESTOQUE_ESRC = ?", $estoque);
        }

        //seleciono o produto e armazeno e uma variavel
        $produto = $model_produto->fetchRow($select);

        if ($produto['NR_QTDE_ESRC'] <= 0) {
            $messages->error = $produto['DS_PRODUTO_PRRC'] . " se esgostou de nosso estoque :/";
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }

        $nome = $produto['DS_PRODUTO_PRRC'];
        $descricao = $produto['DS_INFORMACOES_PRRC'];
        $extensao_imagem = $produto["DS_EXT_PRRC"];
        $valor = $produto["VL_PRODUTO_PRRC"];
        $peso = $produto['NR_PESOGRAMAS_PRRC'];
        $valor_promo = $produto['VL_PROMO_PRRC'];
        $qtde_estoque = $produto['NR_QTDE_ESRC'];
        $tipo = $produto['NR_SEQ_CATEGPRO_PTRC'];
        $st_frete_gratis = $produto['DS_FRETEGRATIS_PRRC'];
        $sigla = $produto['DS_SIGLA_TARC'];

// 		Zend_Debug::dump($imagem);die;
        //se for pessoa juridica adiciona ao carrinho com quantidade
        //se o tipo de produto for 9 (diferente de vale presente)
        if ($tipo_prod->NR_SEQ_TIPO_PRRC != 9) {
            $carrinho->produtos[$estoque] = array(
                'codigo' => $idproduto,
                'nome' => $nome,
                'descricao' => $descricao,
                'path' => $extensao_imagem,
                'valor' => $valor,
                'peso' => $peso,
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
            foreach ($carrinho->produtos as $key => $produtoCarrinho) {
                // Verifico se existe vale presente
                if ($produtoCarrinho['tipo'] == 9) {
                    $existeValePresente = true;
                }
            }

            // Se existir vale presente
            if ($existeValePresente) {
                // Apago ele do carrinho
                unset($carrinho->produtos[$estoque]);
                $messages->error = "Finalize a compra do vale presente para comprar outros produtos.";

                // Redireciona para a pagina anterior
                $this->_redirect('/carrinho-compras');
            }
            // Se o produto for vale presente
        } else {
            $carrinho->produtos[$idproduto] = array(
                'codigo' => $idproduto,
                'nome' => $nome,
                'descricao' => $descricao,
                'path' => $extensao_imagem,
                'valor' => $valor,
                'peso' => $peso,
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
            foreach ($carrinho->produtos as $key => $produtoCarrinho) {
                // Verifico se existe produto
                if ($produtoCarrinho['tipo'] != 9) {
                    $existeProduto = true;
                }
            }

            // Se existir produto
            if ($existeProduto) {
                // Apago ele do carrinho
                unset($carrinho->produtos[$idproduto]);
                $messages->error = "A compra do vale presente precisa ser feita em um pedido separado.";

                // Redireciono ele para a pagina anterior
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }

//        if($usuarios->logado){
//            $produtos = array();
//
//            foreach($carrinho->produtos as $estoque => $produto){
//                $produtos[$estoque] = $produto['codigo'];
//            }
//
//            $produtosJson = json_encode($produtos);
//
//            $modelCarrinho = new Default_Model_Carrinho();
//            $dadosCarrinho = $modelCarrinho->fetchRow(array('cadastros_id = ?' => $usuarios->idperfil, 'compras_id IS NULL', 'email_enviado = 0'));
//
//            $data = array();
//            $data['cadastros_id'] = $usuarios->idperfil;
//            $data['email_cadastro'] = $usuarios->email;
//            $data['estoque_id'] = $produtosJson;
//            $data['hora'] = date("Y-m-d H:i:s");
//
//            if($dadosCarrinho){
//                $modelCarrinho->update($data, array('carrinho_id = ?' => $dadosCarrinho->carrinho_id));
//            }else{
//                $modelCarrinho->insert($data);
//            }
//        }

        if ($usuarios->cadastro_completo == 0) {
            //mensagem de retorno para o usuario
            $messages->error = "Você precisa completar seu cadastro para continuar a sua compra.";
            // Redireciona para a Ãºltima pÃ¡gina
            $this->_redirect('/reverbme/novome/incompleto/1');
        } else {
            if ($carrinho_id) {
                $this->_redirect("/carrinho-compras");
            } else {
                $this->_redirect("/todos-produtos");
            }
        }
    }

    /**
     *
     * */
    public function adicionarcarrinhoatacadistaAction() {

        //crio a sessao de usuÃ¡rios
        $usuarios = new Zend_Session_Namespace("usuarios");

        //cria a sessÃ£o do carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");

        // Cria a sessÃ£o das mensagens
        $messages = new Zend_Session_Namespace("messages");
        // Busca o id do produto
        $idproduto = $this->_request->getParam("idproduto", 0);
        //se for post
        if ($this->_request->isPost()) {



            //recebo os dados do formulario
            $estoque = $this->_request->getParam("idestoque", 0);
            $quantidades = $this->_request->getParam("quantidade");



            $tamanho = $this->_request->getParam("tamanho", 0);

            //para cada produto marcado
            foreach ($quantidades as $key => $quantidade) {
                $idestoque = $estoque[$key];

                //agora verifico se existe quantidade selecionada
                if ($quantidade > 0 and $quantidade != "") {


                    //inicio o model do produto
                    $model_produto = new Default_Model_Produtos();
                    //crio a query
                    $select = $model_produto->select()
                            //digo que nao existe integridade entre as tabelas
                            ->setIntegrityCheck(false)
                            //seleciono da tabela de produtos
                            ->from('produtos')
                            //faÃ§o o join
                            ->joinInner('estoque', 'produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC', array('NR_QTDE_ESRC', 'NR_SEQ_TAMANHO_ESRC'))
                            //faco o join dos tipos
                            ->joinInner('produtos_tipo', 'produtos_tipo.NR_SEQ_CATEGPRO_PTRC = produtos.NR_SEQ_TIPO_PRRC', array('NR_SEQ_CATEGPRO_PTRC'))
                            //seleciono somente o produto desejado
                            ->where("NR_SEQ_PRODUTO_PRRC = ?", $idproduto)
                            ->where("NR_SEQ_ESTOQUE_ESRC = ?", $estoque[$key]);

                    //seleciono o produto e armazeno e uma variavel
                    $produto = $model_produto->fetchRow($select);

                    $nome = $produto['DS_PRODUTO_PRRC'];
                    $descricao = $produto['DS_INFORMACOES_PRRC'];
                    $extensao_imagem = $produto["DS_EXT_PRRC"];
                    //agora verifico se Ã© camiseta ou caneca para adicionar o valor correto
                    $valor = $produto["VL_PRODUTO_PRRC"];

                    if ($produto['VL_PROMO_PRRC']) {
                        $valor = $produto['VL_PROMO_PRRC'];
                    } else {
                        $valor = $produto["VL_PRODUTO_PRRC"] * 0.7;
                    }

//					if($produto['NR_SEQ_TIPO_PRRC'] == 6){
//
//						if($produto['TP_DESTAQUE_PRRC'] == 2){
//
//							$valor = $produto["VL_PRODUTO_PRRC"] * 0.4;
//						}else{
//							$valor = $produto["VL_PRODUTO_PRRC"] * 0.5;
//						}
//					}
//					if($produto['NR_SEQ_CATEGORIA_PRRC'] == 173){
//						$valor = $produto["VL_PRODUTO_PRRC"] - ($produto["VL_PRODUTO_PRRC"] * 0.3);
//					}
//					if($produto['NR_SEQ_TIPO_PRRC'] == 142 or $produto['NR_SEQ_TIPO_PRRC'] == 143){
//						$valor = $produto["VL_PRODUTO_PRRC"] * 0.5;
//					}
                    $peso = $produto['NR_PESOGRAMAS_PRRC'];
                    $valor_promo = $produto['VL_PROMO_PRRC'];
                    $qtde_estoque = $produto['NR_QTDE_ESRC'];
                    $tipo = $produto['NR_SEQ_CATEGPRO_PTRC'];
                    $destaque = $produto['TP_DESTAQUE_PRRC'];




                    // 		Zend_Debug::dump($imagem);die;
                    //se for pessoa juridica adiciona ao carrinho com quantidade

                    $carrinho->produtos[$idestoque] = array(
                        'codigo' => $idproduto,
                        'nome' => $nome,
                        'descricao' => $descricao,
                        'path' => $extensao_imagem,
                        'valor' => $valor,
                        'peso' => $peso,
                        'tamanho' => $tamanho[$key],
                        'genero' => $genero,
                        'quantidade' => $quantidade,
                        'vl_promo' => $valor_promo,
                        'estoque' => $qtde_estoque,
                        'tipo' => $tipo,
                        'idestoque' => $estoque[$key],
                        'destaque' => $destaque
                    );
                }
            }

            $this->_redirect("loja/carrinho");
        } else {
            $messages->error = "Você não pode acessar esta página direto!";

            //redireciono para a Ãºltima pÃ¡gina visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * funÃ§Ã£o responsavel por remover o produto do carrinho
     */
    public function removercarrinhoAction() {
        // Desabilita os layouts
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //cria a sessÃ£o do carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");

        // Cria a sessÃ£o das mensagens
        $messages = new Zend_Session_Namespace("messages");


        $idestoque = $this->_request->getParam("idestoque", 0);
        $idproduto = $this->_request->getParam("idproduto", 0);

        // unset($carrinho->produtos[$idproduto]);
        if ($this->_request->isPost()) {
            if ($idproduto > 0) {
                unset($carrinho->produtos[$idproduto]);
            } else {
                unset($carrinho->produtos[$idestoque]);
            }

            //crio um array com mensagem do json
            $data_json = array('erro' => false,
                'msg_sucesso' => 'O Produto foi removido com sucesso do seu carrinho!');
            //assino o json
            $this->_helper->json($data_json);
        } else {
            if ($idproduto > 0) {
                unset($carrinho->produtos[$idproduto]);
            } else {
                unset($carrinho->produtos[$idestoque]);
            }

            $messages->success = "O Produto foi removido com sucesso do seu carrinho!";

            //redireciono para a Ãºltima pÃ¡gina visitada
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     * Com antigo Checkout
     */

    public function fazerpedidoAction() {

        $dados = $this->_request->getParams();

        //inicio a sessao do usuario logado
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //inicio a sessao de frete para mostrar o valor do mesmo apos ser calculado
        $sessao_frete = new Zend_Session_Namespace("fretes");
        //inicio a sessao dos descontos
        $descontos = new Zend_Session_Namespace("descontos");
        //crio a sessao de mensagens de promo
        $sessao_promo = new Zend_Session_Namespace("promocoes");
        //inicio a sessao de camapanhas
        $campanhas = new Zend_Session_Namespace("campanhas");
        // Cria a sessÃ£o das mensagens
        $messages = new Zend_Session_Namespace("messages");

        $temTeste = false;

        //verifico se tem valor no frete
        if ($sessao_frete->valor > 0 or $sessao_frete->frete_gratis > 0) {
            if (count($carrinho->produtos) <= 0) {
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }

            //se for post
            if ($this->_request->isPost()) {

                if ($usuarios->tipo == 'PJ') {
                    $quantidadeTemp = 0;
                    foreach ($carrinho->produtos as $produtoCarrinho) {
                        $quantidadeTemp += $produtoCarrinho['quantidade'];
                        if ($produtoCarrinho['codigo'] == 5745) {
                            $temTeste = true;
                        }
                    }

                    if ($quantidadeTemp < 30 and $temTeste == false) {
                        $messages->error = 'Pedido mínimo para atacado é de 30 produtos.';
                        $this->_redirect($_SERVER['HTTP_REFERER']);
                    }
                }

                //recebo o valor total
                $cod_vl = $this->_request->getParam("cod_vl");
                //recebo o bilhete
                $bilhete = $this->_request->getParam("bilhete");

                date_default_timezone_set('America/Sao_Paulo');
                //crio a data de hoje
                $data_hoje = date("Y-m-d H:i:s");
                //recebo o ip do usuario
                $ip = $_SERVER["REMOTE_ADDR"];
                //recebo a forma de pagamento
                $forma_pagamento = $this->_request->getParam("formapagto");

                $ja_tem_brinde = 0;

                $tem_cheio = 0;

                $tem_promo = 0;

                //agora recebo o parametro que o cliente informa se tiver endereÃ§o de entrega diferente do dele sim(true) e nÃ£o (false)
                $endereco_entrega_diferente = $this->_request->getParam("usar_mesmo");


                //agora faco as condiÃ§oes de numero de parcelas e pegar o numero de cartÃ£o de acordo com a forma de pagamento escolhida
                //boleto
                if ($forma_pagamento == "boleto") {
                    //rpara boleto Ã© apenas 1 parcela
                    $numero_parcelas = 1;
                }
                //visa
                if ($forma_pagamento == "visa") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelamento");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("visa");
                }
                //mastercard
                if ($forma_pagamento == "mastercard") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelamento");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("mastercard");
                }
                //american express
                if ($forma_pagamento == "amex") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelamento");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("americanexpress");
                }
                //dinners
                if ($forma_pagamento == "diners") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelamento");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("diners");

                    $messages->error = 'Trabalhamos com os cartões Visa, Mastercard e Amex.';
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }

                //elo
                if ($forma_pagamento == "elo") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelamento");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("elo");
                    $messages->error = 'Trabalhamos com os cartões Visa, Mastercard e Amex.';
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }

                //recebo a promocao ativa
                $promo = $sessao_promo->msg;

                //inicio o model de compras
                $model_compras = new Default_Model_Compras();

                $forma_envio = $this->_request->getParam("forma_envio");

                if ($forma_envio == 1) {
                    $forma = 'PAC';
                } elseif ($forma_envio == 2) {
                    $forma = 'SEDEX';
                } elseif ($forma_envio == 3) {
                    $forma = 'E-SEDEX';
                } elseif ($forma_envio == 4) {
                    $forma = 'TAM';
                } elseif ($forma_envio == 5) {
                    $forma = ' CORREIOS REGISTRADO';
                } else {
                    $forma = 'GRÁTIS';
                }

                //crio o array da compra
                $data_compra = array("NR_SEQ_LOJA_COSO" => 1,
                    "NR_SEQ_CADASTRO_COSO" => $usuarios->idperfil,
                    "NR_SEQ_BILHETE_COSO" => $bilhete,
                    "DT_COMPRA_COSO" => $data_hoje,
                    "DS_IP_COSO" => $ip,
                    "DS_FORMAENVIO_COSO" => $forma,
                    "VL_FRETE_COSO" => $sessao_frete->valor,
                    "ST_COMPRA_COSO" => 'A',
                    "VL_DESCONTO_COSO" => $sessao_frete->valor_desconto ? $sessao_frete->valor_desconto : '0',
                    "DS_FORMAPGTO_COSO" => $forma_pagamento,
                    "NR_PARCELAS_COSO" => $numero_parcelas,
                    "DS_DESCPROMO_COSO" => $promo);

                $db = Zend_Db_Table::getDefaultAdapter();
                //$db->beginTransaction();
                //insiro o registro e pego o id da compra
                $idcompra = $model_compras->insert($data_compra);

                if ($sessao_promo->creditos > 0) {
                    $modelContaCorrente = new Default_Model_Contascorrente();

                    $dataContaCorrente = array(
                        'NR_SEQ_CADASTRO_CRSA' => $usuarios->idperfil,
                        'VL_LANCAMENTO_CRSA' => $sessao_promo->creditos,
                        'DT_LANCAMENTO_CRSA' => date('Y-m-d H:i:s'),
                        'DS_OBSERVACAO_CRSA' => 'Crédito de ' . $sessao_promo->creditos . ' gerado pela compra ' . $idcompra,
                        'DT_VENCIMENTO_CRSA' => date('Y-m-d', strtotime('+90 days')),
                        'TP_LANCAMENTO_CRSA' => 'C',
                        'ST_EXPIRADO_CRSA' => 'S'
                    );

                    $sessao_promo->creditos = 0;

                    $idContaCorrente = $modelContaCorrente->insert($dataContaCorrente);
                }


                $recuperarCarrinho = new Zend_Session_Namespace("recuperar_carrinho");

                if ($recuperarCarrinho->carrinho_id) {

                    $modelCarrinho = new Default_Model_Carrinho();
                    $modelCarrinho->update(array('compras_id' => $idcompra), array('carrinho_id = ?' => $recuperarCarrinho->carrinho_id));
                    Zend_Session::namespaceUnset('recuperar_carrinho');
                }

                if ($sessao_frete->idconta) {
                    //atualizo o model de contacorrente para utilizado
                    $model_conta = new Default_Model_Contascorrente();

                    $data_conta = array("ST_EXPIRADO_CRSA" => "S",
                        "NR_SEQ_COMPRA_CRSA" => $idcompra,
                        "VL_LANCAMENTO_CRSA" => 0);

                    $model_conta->update($data_conta, array("NR_SEQ_CONTA_CRSA = ?" => $sessao_frete->idconta));
                }


                //agora verifico se esta utilizando outro endereco
                if ($endereco_entrega_diferente != 1) {
                    //inicio o model de endereco
                    $model_endereco_entrega = new Default_Model_Enderecosentrega();

                    $dadosEnderecoEntrega = $model_endereco_entrega->fetchRow(array('NR_SEQ_ENDERECO_ENRC = ?' => $endereco_entrega_diferente));

                    //removo os caracteres desnecessÃ¡rios do cep
                    $cep = $dadosEnderecoEntrega->DS_CEP_ENRC;
                    //remo os pontos
                    $cep = str_replace(".", "", $cep);
                    //agora removo o traÃ§o
                    $cep = str_replace("-", "", $cep);


                    //crio o array para receber os parametros
                    $data_entrega = array('NR_SEQ_COMPRA_ENRC' => $idcompra,
                        'DS_DESTINATARIO_ENRC' => $dadosEnderecoEntrega->DS_DESTINATARIO_ENRC,
                        'DS_ENDERECO_ENRC' => $dadosEnderecoEntrega->DS_ENDERECO_ENRC,
                        'DS_NUMERO_ENRC' => $dadosEnderecoEntrega->DS_NUMERO_ENRC,
                        'DS_COMPLEMENTO_ENRC' => $dadosEnderecoEntrega->DS_COMPLEMENTO_ENRC,
                        'DS_BAIRRO_ENRC' => $dadosEnderecoEntrega->DS_BAIRRO_ENRC,
                        'DS_CEP_ENRC' => $cep,
                        'DS_CIDADE_ENRC' => $dadosEnderecoEntrega->DS_CIDADE_ENRC,
                        'DS_UF_ENRC' => $dadosEnderecoEntrega->DS_UF_ENRC,
                        'DS_FONE_ENRC' => $dadosEnderecoEntrega->DS_FONE_ENRC,
                        'DS_CEL_ENRC' => $dadosEnderecoEntrega->DS_CEL_ENRC,
                        'DT_CADASTRO_ENRC' => date("Y-m-d H:i:s"));
                    //insiro no banco de dados o endereco de entrega
                    $model_endereco_entrega->insert($data_entrega);
                }

                //verifico se existe parametro 
                if ($campanhas->idcampanha > 0) {

                    //inicio o adaptador do banco
                    $db = Zend_Registry::get("db");
                    // Insere o valor das variaveis em um array
                    $data_campanha = array('NR_SEQ_CAMPANHA_ACRC' => $campanhas->idcampanha,
                        'NR_SEQ_TIPO_ACRC' => 1,
                        'DS_IP_ACRC' => $ip,
                        'DT_REGISTRO_ACRC' => date("Y-m-d H:i:s"),
                        'DS_OBS_ACRC' => $idcompra,
                        'NR_SEQ_CADASTRO_ACRC' => $usuarios->idperfil);
                    // Insere o valor do array no tabela do banco de dados
                    $db->insert("campanhas_hist", $data_campanha);

                    //acabo com a sessao campanha
                    Zend_Session::namespaceUnset("campanhas");
                }

                //inicio o model de cestas
                $model_cestas = new Default_Model_Cestas();
                //inicio o model de estoque
                $model_estoque = new Default_Model_Estoque();
                //inicio o model de controle de estoque
                $model_controle_estoque = new Default_Model_Estoquecontrole();
                //inicio o model de produto
                $model_produto = new Default_Model_Produtos();

                uasort($carrinho->produtos, function($a, $b) {
                    return $b['total_produto'] - $a['total_produto'];
                });

                // Foreach para validar o estoque
                foreach ($carrinho->produtos as $key => $item) {

                    $quantidade = $item['quantidade'];

                    $select_produto = $model_produto->select()
                            ->from("produtos", array(
                                "nome" => "DS_PRODUTO_PRRC",
                                "tipo_produto" => "NR_SEQ_TIPO_PRRC"))
                            ->where("NR_SEQ_PRODUTO_PRRC = ?", $item['codigo']);
                    $row_produto = $model_produto->fetchRow($select_produto);

                    $select_estoque = $model_estoque->select()
                            ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);
                    $produto_estoque = $model_estoque->fetchRow($select_estoque);

                    if ($row_produto["tipo_produto"] != 9) {
                        if ($produto_estoque['NR_QTDE_ESRC'] == 0) {
                            $messages->error = "Desculpe, o produto {$row_produto["nome"]} se esgotou em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }

                        if ($produto_estoque['NR_QTDE_ESRC'] < $quantidade) {
                            $messages->error = "Desculpe, não temos {$quantidade} {$row_produto["nome"]} em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                }

                //para cada produto no carrinho
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
                                "tipo_produto" => "NR_SEQ_TIPO_PRRC",
                                "categoria" => "NR_SEQ_CATEGORIA_PRRC",
                                "destaque" => "TP_DESTAQUE_PRRC",
                                "vl_custo" => "VL_PRODUTO2_PRRC"))
                            ->where("NR_SEQ_PRODUTO_PRRC = ?", $item['codigo']);
                    //atribuo o valor
                    $row_produto = $model_produto->fetchRow($select_produto);

                    //crio um array para exibir os dados do produtos de forma dinamica e nao salvar na sessao
                    $data_carrinho[$key] = array("codigo" => $row_produto['codigo'],
                        "nome" => $row_produto["nome"],
                        "descricao" => $row_produto['descricao'],
                        "path" => $row_produto['path'],
                        "valor" => $item['valor'],
                        "vl_promo" => $item['vl_promo'],
                        "vl_desconto" => $item['valor_total_desconto'],
                        "idestoque" => $item['idestoque'],
                        "estoque" => $item['estoque'],
                        "quantidade" => $item['quantidade'],
                        "destaque" => $row_produto["destaque"],
                        "sigla" => $item["sigla"],
                        "brinde" => $item["brinde"],
                        "tipo" => $row_produto["tipo_produto"],
                        "categoria" => $row_produto["categoria"]);

                    $modelAviseme = new Default_Model_Aviseme();
                    $dadosAviseme = $modelAviseme->fetchRow(array(
                        'NR_SEQ_PRODUTO_AVRC = ?' => $item['codigo'],
                        'NR_SEQ_TAMANHO_AVRC = ?' => $item['tamanho'],
                        'NR_SEQ_CADASTRO_AVRC = ?' => $usuarios->idperfil
                    ));

                    if ($dadosAviseme) {
                        $modelAviseme->update(array('ST_JACOMPROU_AVRC' => 'S'), array('NR_SEQ_AVISEME_AVRC = ?' => $dadosAviseme->NR_SEQ_AVISEME_AVRC));
                    }


                    /*                     * ***********-
                     * **************-
                     * ****PROMOS****-
                     * **************-
                     * ************** */

                    if ($sessao_promo->niver > 0) {
                        $data_niver["ST_COMPROU_NIVER"] = 1;
                        $model_compras->update($data_niver, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));
                    }



                    //----------------//
                    //Primeira Compra//
                    //---------------//
                    if ($sessao_promo->primeira > 0) {
                        $data_primeira["ST_COMPROU_NIVER"] = 1;
                        $model_compras->update($data_primeira, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));
                    }
                    //verifico se Ã© a promo correta
                    if ($sessao_promo->primeira > 0) {
                        /*
                         * implementar
                         */
                    }
                    /*                     * ***********-
                     * **************-
                     * **FIM PROMOS***-
                     * **************-
                     * ************** */

                    if ($usuarios->tipo == 'PJ') {

                        $valor = $data_carrinho[$key]['valor'];
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        $valor_uni = $data_carrinho[$key]['valor'];

                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto
                        $valor = $valor * $quantidade;

                        if ($data_carrinho[$key]['codigo'] == 5745) {
                            $valor_uni = $data_carrinho[$key]['valor'];
                            $valor = $quantidade * $data_carrinho[$key]['valor'];
                        }

                        //assino o valor total por produto ao view
                        $this->view->total_produto = $valor;

                        $data_carrinho[$key]['vl_promo'] = 0;
                    } else {

                        //Zend_Debug::dump($carrinho->produtos); exit;
                        if ($data_carrinho[$key]['vl_desconto'] == NULL AND $sessao_promo->primeira == 1) {


                            if ($data_carrinho[$key]['vl_promo'] > 0) {
                                //jogo o valor do produto na variavel
                                $valor = $data_carrinho[$key]['vl_promo'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['vl_promo'];
                            } else {
                                //jogo o valor do produto na variavel
                                $valor = $data_carrinho[$key]['valor'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['valor'];
                            }
                        } elseif ($data_carrinho[$key]['vl_desconto'] == NULL) {

                            if ($data_carrinho[$key]['vl_promo'] > 0) {
                                $valor = $data_carrinho[$key]['vl_promo'];
                                $valor_uni = $data_carrinho[$key]['vl_promo'];
                            } else {
                                $valor = $data_carrinho[$key]['valor'];
                                $valor_uni = $data_carrinho[$key]['valor'];
                            }
                        } else {
                            //jogo o valor do produto na variavel

                            $valor = $data_carrinho[$key]['valor'];

                            //o mesmo valor para inserir no banco sem ter sido multiplicado
                            $valor_uni = $data_carrinho[$key]['valor'];
                        }

                        //atribuo o valor cheio
                        $valor_cheio = 0;
                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto

                        $valor = $valor * $quantidade;
                        //agora falo que tem produto cheio
                        $tem_cheio = 1;
                        //assino o valor total por produto ao view
                        $this->view->total_produto = $valor;
                    }

                    //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                    if ($valor_uni == 0.1 or $valor == 0.1) {
                        $valor_uni = 0;
                        $valor = 0;
                        $valor_cheio = 0;
                    }

                    if ($row_produto["tipo_produto"] != 9) {
                        $select_estoque = $model_estoque->select()
                                ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                        //armazeno o resultado do estoque em uma variavel
                        $produto_estoque = $model_estoque->fetchRow($select_estoque);

                        if ($produto_estoque['NR_QTDE_ESRC'] == 0) {
                            $messages->error = "Desculpe, o produto {$row_produto["nome"]} se esgotou em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }

                        if ($produto_estoque['NR_QTDE_ESRC'] < $quantidade) {
                            $messages->error = "Desculpe, não temos {$quantidade} {$row_produto["nome"]} em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }
                    }

                    //agora atualizo o carrinho com a quantidade disponivel
                    $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;

                    //crio o array da cesta
                    $data_cesta = array("NR_SEQ_CADASTRO_CESO" => $usuarios->idperfil,
                        "NR_SEQ_COMPRA_CESO" => $idcompra,
                        "NR_SEQ_PRODUTO_CESO" => $item["codigo"],
                        "NR_SEQ_ESTOQUE_CESO" => $produto_estoque["NR_SEQ_ESTOQUE_ESRC"],
                        "NR_SEQ_TAMANHO_CESO" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                        "NR_QTDE_CESO" => $quantidade,
                        "VL_PRODUTO_CESO" => $valor_uni,
                        'VL_COM_DESCONTO' => $item['valor_total_desconto'],
                        "DT_INCLUSAO_CESO" => $data_hoje,
                        "VL_PRODUTOCHEIO_CESO" => $valor_cheio,
                        "VL_CUSTO_CESO" => $row_produto['vl_custo']);
                    //agora insiro o registro da cesta
                    $model_cestas->insert($data_cesta);

                    //agora verifico se Ã© vale presente para que possa inserir no banco
                    if ($row_produto["tipo_produto"] == 9) {
                        //inicio o model de vale presente
                        $model_valepresente = new Default_Model_Bilhetes();
                        //informo quais caracteres podem ser inseridos
                        $CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
                        //agora digo o tamanho maximo
                        $max = strlen($CaracteresAceitos) - 1;
                        //inicio a criacao do bilhete
                        $bilhete = date('Ymdhis');
                        //agora faÃ§o de 0 a 6
                        for ($i = 0; $i < 6; $i++) {
                            //concateno o bilhete de forma randomica
                            $bilhete .= $CaracteresAceitos{
                                    mt_rand(0, $max)};
                        }
                        $emailganhador = $dados['emailganhador'];

                        //coloco as informaÃ§Ãµes de vale presente em um array
                        $data_vale_presente = array("NR_SEQ_COMPRA_BIRC" => $idcompra,
                            "NR_SEQ_CADCRIADOR_BIRC" => $usuarios->idperfil,
                            "DS_BILHETE_BIRC" => $bilhete,
                            "DT_CRIACAO_BIRC" => date("Y-m-d H:i:s"),
                            "ST_STATUS_BIRC" => 'A',
                            "VL_BILHETE_BIRC" => $row_produto["valor"],
                            "DS_EMAILGANHADOR_BIRC" => $emailganhador);
                        //insiro os dados do bilhete
                        $model_valepresente->insert($data_vale_presente);
                    }
                    //atribuo o valor total do carrinho
                    $valor_total += $valor;

                    // fim foreach carrinho
                }


                if ($sessao_frete->cupom != "") {
                    //calculo o valor final
                    $valor_final = ($valor_total + $sessao_frete->valor) - $sessao_frete->valor_desconto;

                    ///inicio o model de vale presente
                    $model_valepresente = new Default_Model_Bilhetes();
                    //inicio a query
                    $select_valepresente = $model_valepresente->select()
                            ->from("bilhetes", array("NR_SEQ_BILHETES_BIRC",
                                "DS_BILHETE_BIRC",
                                "ST_STATUS_BIRC",
                                "VL_BILHETE_BIRC"))
                            ->where("DS_BILHETE_BIRC = '$sessao_frete->cupom'");


                    //crio uma lista com o vale presente
                    $valepresente = $model_valepresente->fetchRow($select_valepresente);
                    $idbilhete = $valepresente->NR_SEQ_BILHETES_BIRC;

                    // die($idbilhete);

                    $data_cupom = array("ST_STATUS_BIRC" => "U",
                        "DT_UTILIZACAO_BIRC" => $data_hoje);
                    //atualizo
                    $model_valepresente->update($data_cupom, array("NR_SEQ_BILHETES_BIRC = $idbilhete"));
                } else {
                    $sessao_frete->cupom = "";
                    $valor_final = ($valor_total + $sessao_frete->valor) - $sessao_frete->valor_desconto;
                    $sessao_frete->valor_desconto = "";
                }

                $data_compra["VL_TOTAL_COSO"] = $valor_final;

                if ($sessao_promo->valor_desconto > 0) {
                    $data_compra["VL_DESCONTO_COSO"] = $sessao_promo->valor_desconto;
                }

                $model_compras->update($data_compra, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                if ($forma_pagamento != 'boleto') {
                    $modelUsuario = new Default_Model_Reverbme();

                    $dadosUsuario = $modelUsuario->fetchRow(array('NR_SEQ_CADASTRO_CASO = ?' => $usuarios->idperfil))->toArray();

                    $dados['vencimento_ano'] = substr($dados['vencimento_ano'], -2);

                    require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
                    Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

                    $valor_final = number_format((float) $valor_final, 2, '', '');


                    if ($dadosUsuario['DS_FONE_CASO'] != null) {
                        if ($dadosUsuario['DS_FONE_CASO'] == '-') {
                            $telefonenumber = '00000000';
                        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $dadosUsuario['DS_FONE_CASO'])) {
                            $arrayStrreplace = array(0 => ' ', 1 => '-');
                            $telefonenumber = str_replace($arrayStrreplace, '', $dadosUsuario['DS_FONE_CASO']);
                        } else {
                            $telefonenumber = $dadosUsuario['DS_FONE_CASO'];
                        }
                    }

                    $valida_cep = str_replace('.', '', $dadosUsuario['DS_CEP_CASO']);
                    $valida_cep = str_replace('/', '', $valida_cep);
                    $valida_cep = str_replace('-', '', $valida_cep);


                    $transaction = new PagarMe_Transaction(array(
                        'amount' => $valor_final,
                        'card_number' => $dados['numero_cartao'],
                        'card_holder_name' => $dados['nome_portador'],
                        'card_expiration_month' => $dados['vencimento_mes'],
                        'card_expiration_year' => $dados['vencimento_ano'],
                        'card_cvv' => $dados['cod_seguranca'],
                        'installments' => $dados['parcelamento'],
                        'metadata' => array('id_pedido' => $idcompra),
                        "customer" => array(
                            "name" => $dadosUsuario['DS_NOME_CASO'],
                            "document_number" => $dadosUsuario['DS_CPFCNPJ_CASO'],
                            "email" => $dadosUsuario['DS_EMAIL_CASO'],
                            "address" => array(
                                "street" => $dadosUsuario['DS_ENDERECO_CASO'],
                                "neighborhood" => $dadosUsuario['DS_BAIRRO_CASO'],
                                "zipcode" => $valida_cep,
                                "street_number" => $dadosUsuario['DS_NUMERO_CASO'],
                                "complementary" => $dadosUsuario['DS_COMPLEMENTO_CASO']
                            ),
                            "phone" => array(
                                "ddd" => $dadosUsuario['DS_DDDFONE_CASO'],
                                "number" => $telefonenumber
                            )
                        )
                    ));

                    try {
                        $transaction->charge();
                        $status = $transaction->getStatus();
                        //$db->commit();
                        if ($status == 'paid') {
                            date_default_timezone_set('America/Sao_Paulo');
                            $data_hoje = date("Y-m-d H:i:s");
                            $model_compras->update(array(
                                'ST_COMPRA_COSO' => 'P',
                                'DT_PAGAMENTO_COSO' => $data_hoje,
                                'DT_STATUS_COSO' => $data_hoje
                                    ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                            foreach ($carrinho->produtos as $key => $item) {
                                if ($usuarios->tipo == 'PJ') {

                                    //jogo o valor do produto na variavel
                                    $valor = $data_carrinho[$key]['valor'];
                                    //jogo o valor do produto na variavel de produto cheio
                                    $valor_cheio = $data_carrinho[$key]['valor'];
                                    $valor_uni = $data_carrinho[$key]['valor'];

                                    //recebo a quantidade
                                    $quantidade = $item['quantidade'];
                                    //multiplico pela quantidade do produto
                                    $valor = $valor * $quantidade;

                                    //assino o valor total por produto ao view
                                    $this->view->total_produto = $valor;

                                    $data_carrinho[$key]['vl_promo'] = 0;
                                } else {


                                    //aqui verifico se e promo ou nÃ£o
                                    if ($data_carrinho[$key]['vl_promo'] > 0) {
                                        //jogo o valor da promo no valor do produto
                                        $valor = $data_carrinho[$key]['vl_promo'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['vl_promo'];

                                        //atribuo o valor cheio
                                        $valor_cheio = $data_carrinho[$key]['valor'];

                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];

                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;

                                        //agora falo que tem promo na variavel
                                        $tem_promo = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto_promo = $valor;
                                    } else {
                                        //jogo o valor do produto na variavel
                                        $valor = $data_carrinho[$key]['valor'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['valor'];
                                        //atribuo o valor cheio
                                        $valor_cheio = 0;
                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];
                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;
                                        //agora falo que tem produto cheio
                                        $tem_cheio = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto = $valor;
                                    }
                                }

                                //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                                if ($valor_uni == 0.1 or $valor == 0.1) {
                                    $valor_uni = 0;
                                    $valor = 0;
                                    $valor_cheio = 0;
                                }

                                //crio a query para pegar o estoque
                                $select_estoque = $model_estoque->select()
                                        ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                                //armazeno o resultado do estoque em uma variavel
                                $produto_estoque = $model_estoque->fetchRow($select_estoque);

                                //agora eu insiro o valor da nova quantidade no array
                                $data_estoque = array('NR_QTDE_ESRC' => $produto_estoque['NR_QTDE_ESRC'] - $quantidade);
                                //agora atualizo o carrinho com a quantidade disponivel
                                $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
                                //atualizo a quantidade
                                $model_estoque->update($data_estoque, array("NR_SEQ_ESTOQUE_ESRC = ?" => $key));

                                //crio o array de controle de estoque
                                $data_controle = array("NR_SEQ_PRODUTO_ECRC" => $item["codigo"],
                                    "NR_SEQ_USUARIO_ECRC" => 9,
                                    "NR_SEQ_TAMANHO_ECRC" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                                    "DS_ACAO_ECRC" => "Removeu " . $quantidade,
                                    "DS_OBS_ECRC" => "Venda site - Compra Nr " . $idcompra,
                                    "DT_ACAO_ECRC" => $data_hoje,
                                    "NR_QTDE_ECRC" => "-" . $quantidade);
                                //agora insiro no banco de dados o registro do controle de estoque
                                $model_controle_estoque->insert($data_controle);
                            }

                            if (!empty($idContaCorrente)) {
                                $modelContaCorrente->update(array('ST_EXPIRADO_CRSA' => 'N'), array('NR_SEQ_CONTA_CRSA = ?' => $idContaCorrente));
                            }
                        } else if ($status == 'refused') {
                            //TransaÃ§Ã£o foi recusada
                            // $transaction->getRefuseReason() - mostra por que a transaÃ§Ã£o foi recusada
                            $model_compras->update(array(
                                'ST_COMPRA_COSO' => 'C',
                                'DT_PAGAMENTO_COSO' => $data_hoje,
                                'DT_STATUS_COSO' => $data_hoje
                                    ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));
                            // Se o status for diferente de pago e recusado
                        } else {
                            $model_compras->update(array(
                                'DS_RETORNO_COSO' => $status
                                    ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                            foreach ($carrinho->produtos as $key => $item) {
                                if ($usuarios->tipo == 'PJ') {

                                    //jogo o valor do produto na variavel
                                    $valor = $item['valor'];
                                    //jogo o valor do produto na variavel de produto cheio
                                    $valor_cheio = $item['valor'];
                                    $valor_uni = $item['valor'];

                                    //recebo a quantidade
                                    $quantidade = $item['quantidade'];
                                    //multiplico pela quantidade do produto
                                    $valor = $valor * $quantidade;

                                    //assino o valor total por produto ao view
                                    $this->view->total_produto = $valor;

                                    $data_carrinho[$key]['vl_promo'] = 0;
                                } else {


                                    //aqui verifico se e promo ou nÃ£o
                                    if ($data_carrinho[$key]['vl_promo'] > 0) {
                                        //jogo o valor da promo no valor do produto
                                        $valor = $data_carrinho[$key]['vl_promo'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['vl_promo'];

                                        //atribuo o valor cheio
                                        $valor_cheio = $data_carrinho[$key]['valor'];

                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];

                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;

                                        //agora falo que tem promo na variavel
                                        $tem_promo = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto_promo = $valor;
                                    } else {
                                        //jogo o valor do produto na variavel
                                        $valor = $data_carrinho[$key]['valor'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['valor'];
                                        //atribuo o valor cheio
                                        $valor_cheio = 0;
                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];
                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;
                                        //agora falo que tem produto cheio
                                        $tem_cheio = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto = $valor;
                                    }
                                }

                                //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                                if ($valor_uni == 0.1 or $valor == 0.1) {
                                    $valor_uni = 0;
                                    $valor = 0;
                                    $valor_cheio = 0;
                                }

                                //crio a query para pegar o estoque
                                $select_estoque = $model_estoque->select()
                                        ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                                //armazeno o resultado do estoque em uma variavel
                                $produto_estoque = $model_estoque->fetchRow($select_estoque);

                                //agora eu insiro o valor da nova quantidade no array
                                $data_estoque = array('NR_QTDE_ESRC' => $produto_estoque['NR_QTDE_ESRC'] - $quantidade);
                                //agora atualizo o carrinho com a quantidade disponivel
                                $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
                                //atualizo a quantidade
                                $model_estoque->update($data_estoque, array("NR_SEQ_ESTOQUE_ESRC = ?" => $key));

                                //crio o array de controle de estoque
                                $data_controle = array("NR_SEQ_PRODUTO_ECRC" => $item["codigo"],
                                    "NR_SEQ_USUARIO_ECRC" => 9,
                                    "NR_SEQ_TAMANHO_ECRC" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                                    "DS_ACAO_ECRC" => "Removeu " . $quantidade,
                                    "DS_OBS_ECRC" => "Venda site - Compra Nr " . $idcompra,
                                    "DT_ACAO_ECRC" => $data_hoje,
                                    "NR_QTDE_ECRC" => "-" . $quantidade);
                                //agora insiro no banco de dados o registro do controle de estoque
                                $model_controle_estoque->insert($data_controle);
                            }
                        }
                    } catch (Exception $ex) {
                        //$db->rollBack();
                        $messages->error = $ex->getMessage();

                        $model_compras->update(array(
                            'DS_RETORNO_COSO' => $ex->getMessage()
                                ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                        $model_compras->update(array(
                            'ST_COMPRA_COSO' => 'C',
                            'DT_PAGAMENTO_COSO' => $data_hoje,
                            'DT_STATUS_COSO' => $data_hoje
                                ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                        $this->_redirect($_SERVER['HTTP_REFERER']);
                    }

                    // Salvo o tid da transacao
                    $data = array(
                        'DS_TID_COSO' => $transaction->id
                    );
                    $model_compras->update($data, array('NR_SEQ_COMPRA_COSO = ?' => $idcompra));
                    // Se for boleto
                } else {
                    foreach ($carrinho->produtos as $key => $item) {
                        if ($usuarios->tipo == 'PJ') {

                            //jogo o valor do produto na variavel
                            $valor = $item['valor'];
                            //jogo o valor do produto na variavel de produto cheio
                            $valor_cheio = $item['valor'];
                            $valor_uni = $item['valor'];

                            //recebo a quantidade
                            $quantidade = $item['quantidade'];
                            //multiplico pela quantidade do produto
                            $valor = $valor * $quantidade;

                            //assino o valor total por produto ao view
                            $this->view->total_produto = $valor;

                            $data_carrinho[$key]['vl_promo'] = 0;
                        } else {


                            //aqui verifico se e promo ou nÃ£o
                            if ($data_carrinho[$key]['vl_promo'] > 0) {
                                //jogo o valor da promo no valor do produto
                                $valor = $data_carrinho[$key]['vl_promo'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['vl_promo'];

                                //atribuo o valor cheio
                                $valor_cheio = $data_carrinho[$key]['valor'];

                                //recebo a quantidade
                                $quantidade = $item['quantidade'];

                                //multiplico pela quantidade do produto
                                $valor = $valor * $quantidade;

                                //agora falo que tem promo na variavel
                                $tem_promo = 1;
                                //assino o valor total por produto ao view
                                $this->view->total_produto_promo = $valor;
                            } else {
                                //jogo o valor do produto na variavel
                                $valor = $data_carrinho[$key]['valor'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['valor'];
                                //atribuo o valor cheio
                                $valor_cheio = 0;
                                //recebo a quantidade
                                $quantidade = $item['quantidade'];
                                //multiplico pela quantidade do produto
                                $valor = $valor * $quantidade;
                                //agora falo que tem produto cheio
                                $tem_cheio = 1;
                                //assino o valor total por produto ao view
                                $this->view->total_produto = $valor;
                            }
                        }

                        //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                        if ($valor_uni == 0.1 or $valor == 0.1) {
                            $valor_uni = 0;
                            $valor = 0;
                            $valor_cheio = 0;
                        }

                        //crio a query para pegar o estoque
                        $select_estoque = $model_estoque->select()
                                ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                        //armazeno o resultado do estoque em uma variavel
                        $produto_estoque = $model_estoque->fetchRow($select_estoque);

                        //agora eu insiro o valor da nova quantidade no array
                        $data_estoque = array('NR_QTDE_ESRC' => $produto_estoque['NR_QTDE_ESRC'] - $quantidade);
                        //agora atualizo o carrinho com a quantidade disponivel
                        $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
                        //atualizo a quantidade
                        $model_estoque->update($data_estoque, array("NR_SEQ_ESTOQUE_ESRC = ?" => $key));

                        //crio o array de controle de estoque
                        $data_controle = array("NR_SEQ_PRODUTO_ECRC" => $item["codigo"],
                            "NR_SEQ_USUARIO_ECRC" => 9,
                            "NR_SEQ_TAMANHO_ECRC" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                            "DS_ACAO_ECRC" => "Removeu " . $quantidade,
                            "DS_OBS_ECRC" => "Venda site - Compra Nr " . $idcompra,
                            "DT_ACAO_ECRC" => $data_hoje,
                            "NR_QTDE_ECRC" => "-" . $quantidade);
                        //agora insiro no banco de dados o registro do controle de estoque
                        $model_controle_estoque->insert($data_controle);
                    }

                    require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
                    Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

                    $valor_final = number_format((float) $valor_final, 2, '', '');

                    $vencimentoBoleto = date(DATE_ISO8601, strtotime("+3 days"));

                    $modelUsuario = new Default_Model_Reverbme();

                    $dadosUsuario = $modelUsuario->fetchRow(array('NR_SEQ_CADASTRO_CASO = ?' => $usuarios->idperfil))->toArray();

                    $transaction = new PagarMe_Transaction(array(
                        'payment_method' => 'boleto',
                        'amount' => $valor_final,
                        //'postback_url' => 'http://requestb.in/143jb281',
                        'postback_url' => 'https://www.reverbcity.com/checkout2/status-boleto',
                        'boleto_expiration_date' => $vencimentoBoleto,
                        'customer' => array(
                            'name' => $dadosUsuario['DS_NOME_CASO'],
                            'document_number' => $dadosUsuario['DS_CPFCNPJ_CASO'],
                            'email' => $dadosUsuario['DS_EMAIL_CASO']
                        ),
                        'metadata' => array('id_pedido' => $idcompra)
                    ));

                    try {
                        $transaction->charge();
                        //$db->commit();
                    } catch (Exception $ex) {
                        //$db->rollBack();
                        $messages->error = $ex->getMessage();
                        $this->_redirect($_SERVER['HTTP_REFERER']);
                    }

                    $data = array(
                        'DS_TID_COSO' => $transaction->id
                    );

                    $model_compras->update($data, array('NR_SEQ_COMPRA_COSO = ?' => $idcompra));
                }

                //redireciono para a pÃ¡gina do pedido
                $this->_redirect("finalizar-pedido2/$idcompra");
            }
        } else {
            $messages->error = "Você precisa calcular o frete para poder avançar!";
            //redireciono
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     * Com novo Checkout
     */

    function fazerpedidocheckoutAction() {

        $dados = $this->_request->getParams();

        //inicio a sessao do usuario logado
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //inicio a sessao de frete para mostrar o valor do mesmo apos ser calculado
        $sessao_frete = new Zend_Session_Namespace("fretes");
        //inicio a sessao dos descontos
        $descontos = new Zend_Session_Namespace("descontos");
        //crio a sessao de mensagens de promo
        $sessao_promo = new Zend_Session_Namespace("promocoes");
        //inicio a sessao de camapanhas
        $campanhas = new Zend_Session_Namespace("campanhas");
        // Cria a sessÃ£o das mensagens
        $messages = new Zend_Session_Namespace("messages");

        $temTeste = false;

        require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
        Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

        $token = $dados['transition-token'];
        $returnedTransaction = PagarMe_Transaction::findById("{$token}");

        $valor = $returnedTransaction['amount'] / 100;
        //$valor = number_format($valor, ".");
        //verifico se tem valor no frete
        if ($sessao_frete->valor > 0 or $sessao_frete->frete_gratis > 0) {
            if (count($carrinho->produtos) <= 0) {
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }

            //se for post
            if ($this->_request->isPost()) {

                if ($usuarios->tipo == 'PJ') {
                    $quantidadeTemp = 0;
                    foreach ($carrinho->produtos as $produtoCarrinho) {
                        $quantidadeTemp += $produtoCarrinho['quantidade'];
                        if ($produtoCarrinho['codigo'] == 5745) {
                            $temTeste = true;
                        }
                    }

                    if ($quantidadeTemp < 30 and $temTeste == false) {
                        $messages->error = 'Pedido mínimo para atacado é de 30 produtos.';
                        $this->_redirect($_SERVER['HTTP_REFERER']);
                    }
                }

                //recebo o valor total
                $cod_vl = $this->_request->getParam("cod_vl");
                //recebo o bilhete
                $bilhete = $this->_request->getParam("bilhete");

                date_default_timezone_set('America/Sao_Paulo');
                //crio a data de hoje
                $data_hoje = date("Y-m-d H:i:s");
                //recebo o ip do usuario
                $ip = $_SERVER["REMOTE_ADDR"];

                $ja_tem_brinde = 0;

                $tem_cheio = 0;

                $tem_promo = 0;

                //agora recebo o parametro que o cliente informa se tiver endereÃ§o de entrega diferente do dele sim(true) e nÃ£o (false)
                $endereco_entrega_diferente = $this->_request->getParam("usar_mesmo");


                //agora faco as condiÃ§oes de numero de parcelas e pegar o numero de cartÃ£o de acordo com a forma de pagamento escolhida
                //boleto                
                if ($returnedTransaction['payment_method'] == "boleto") {
                    $forma_pagamento = "boleto";
                    //para boleto Ã© apenas 1 parcela
                    $numero_parcelas = 1;
                } elseif ($returnedTransaction['payment_method'] == "credit_card") {
                    $numero_parcelas = $returnedTransaction['installments'];
                    $forma_pagamento = $returnedTransaction['card_brand'];
                }

                //recebo a promocao ativa
                $promo = $sessao_promo->msg;

                //inicio o model de compras
                $model_compras = new Default_Model_Compras();

                $forma_envio = $this->_request->getParam("forma_envio");

                if ($forma_envio == 1) {
                    $forma = 'PAC';
                } elseif ($forma_envio == 2) {
                    $forma = 'SEDEX';
                } elseif ($forma_envio == 3) {
                    $forma = 'E-SEDEX';
                } elseif ($forma_envio == 4) {
                    $forma = 'TAM';
                } elseif ($forma_envio == 5) {
                    $forma = ' CORREIOS REGISTRADO';
                } else {
                    $forma = 'GRÁTIS';
                }

                //crio o array da compra
                $data_compra = array("NR_SEQ_LOJA_COSO" => 1,
                    "NR_SEQ_CADASTRO_COSO" => $usuarios->idperfil,
                    "NR_SEQ_BILHETE_COSO" => $bilhete,
                    "DT_COMPRA_COSO" => $data_hoje,
                    "DS_IP_COSO" => $ip,
                    "DS_FORMAENVIO_COSO" => $forma,
                    "VL_FRETE_COSO" => $sessao_frete->valor,
                    "ST_COMPRA_COSO" => 'A',
                    "VL_DESCONTO_COSO" => $sessao_frete->valor_desconto ? $sessao_frete->valor_desconto : '0',
                    "DS_FORMAPGTO_COSO" => $forma_pagamento,
                    "NR_PARCELAS_COSO" => $returnedTransaction['installments'],
                    "DS_DESCPROMO_COSO" => $promo);

                $db = Zend_Db_Table::getDefaultAdapter();
                //$db->beginTransaction();
                //insiro o registro e pego o id da compra
                $idcompra = $model_compras->insert($data_compra);

                if ($sessao_promo->creditos > 0) {
                    $modelContaCorrente = new Default_Model_Contascorrente();

                    $dataContaCorrente = array(
                        'NR_SEQ_CADASTRO_CRSA' => $usuarios->idperfil,
                        'VL_LANCAMENTO_CRSA' => $sessao_promo->creditos,
                        'DT_LANCAMENTO_CRSA' => date('Y-m-d H:i:s'),
                        'DS_OBSERVACAO_CRSA' => 'Crédito de ' . $sessao_promo->creditos . ' gerado pela compra ' . $idcompra,
                        'DT_VENCIMENTO_CRSA' => date('Y-m-d', strtotime('+90 days')),
                        'TP_LANCAMENTO_CRSA' => 'C',
                        'ST_EXPIRADO_CRSA' => 'S'
                    );

                    $sessao_promo->creditos = 0;

                    $idContaCorrente = $modelContaCorrente->insert($dataContaCorrente);
                }


                $recuperarCarrinho = new Zend_Session_Namespace("recuperar_carrinho");

                if ($recuperarCarrinho->carrinho_id) {

                    $modelCarrinho = new Default_Model_Carrinho();
                    $modelCarrinho->update(array('compras_id' => $idcompra), array('carrinho_id = ?' => $recuperarCarrinho->carrinho_id));
                    Zend_Session::namespaceUnset('recuperar_carrinho');
                }

                if ($sessao_frete->idconta) {
                    //atualizo o model de contacorrente para utilizado
                    $model_conta = new Default_Model_Contascorrente();

                    $data_conta = array("ST_EXPIRADO_CRSA" => "S",
                        "NR_SEQ_COMPRA_CRSA" => $idcompra,
                        "VL_LANCAMENTO_CRSA" => 0);

                    $model_conta->update($data_conta, array("NR_SEQ_CONTA_CRSA = ?" => $sessao_frete->idconta));
                }


                //agora verifico se esta utilizando outro endereco
                if ($endereco_entrega_diferente != 1) {
                    //inicio o model de endereco
                    $model_endereco_entrega = new Default_Model_Enderecosentrega();

                    $dadosEnderecoEntrega = $model_endereco_entrega->fetchRow(array('NR_SEQ_ENDERECO_ENRC = ?' => $endereco_entrega_diferente));

                    //removo os caracteres desnecessÃ¡rios do cep
                    $cep = $dadosEnderecoEntrega->DS_CEP_ENRC;
                    //remo os pontos
                    $cep = str_replace(".", "", $cep);
                    //agora removo o traÃ§o
                    $cep = str_replace("-", "", $cep);


                    //crio o array para receber os parametros
                    $data_entrega = array('NR_SEQ_COMPRA_ENRC' => $idcompra,
                        'DS_DESTINATARIO_ENRC' => $dadosEnderecoEntrega->DS_DESTINATARIO_ENRC,
                        'DS_ENDERECO_ENRC' => $dadosEnderecoEntrega->DS_ENDERECO_ENRC,
                        'DS_NUMERO_ENRC' => $dadosEnderecoEntrega->DS_NUMERO_ENRC,
                        'DS_COMPLEMENTO_ENRC' => $dadosEnderecoEntrega->DS_COMPLEMENTO_ENRC,
                        'DS_BAIRRO_ENRC' => $dadosEnderecoEntrega->DS_BAIRRO_ENRC,
                        'DS_CEP_ENRC' => $cep,
                        'DS_CIDADE_ENRC' => $dadosEnderecoEntrega->DS_CIDADE_ENRC,
                        'DS_UF_ENRC' => $dadosEnderecoEntrega->DS_UF_ENRC,
                        'DS_FONE_ENRC' => $dadosEnderecoEntrega->DS_FONE_ENRC,
                        'DS_CEL_ENRC' => $dadosEnderecoEntrega->DS_CEL_ENRC,
                        'DT_CADASTRO_ENRC' => date("Y-m-d H:i:s"));
                    //insiro no banco de dados o endereco de entrega
                    $model_endereco_entrega->insert($data_entrega);
                }

                //verifico se existe parametro 
                if ($campanhas->idcampanha > 0) {

                    //inicio o adaptador do banco
                    $db = Zend_Registry::get("db");
                    // Insere o valor das variaveis em um array
                    $data_campanha = array('NR_SEQ_CAMPANHA_ACRC' => $campanhas->idcampanha,
                        'NR_SEQ_TIPO_ACRC' => 1,
                        'DS_IP_ACRC' => $ip,
                        'DT_REGISTRO_ACRC' => date("Y-m-d H:i:s"),
                        'DS_OBS_ACRC' => $idcompra,
                        'NR_SEQ_CADASTRO_ACRC' => $usuarios->idperfil);
                    // Insere o valor do array no tabela do banco de dados
                    $db->insert("campanhas_hist", $data_campanha);

                    //acabo com a sessao campanha
                    Zend_Session::namespaceUnset("campanhas");
                }

                //inicio o model de cestas
                $model_cestas = new Default_Model_Cestas();
                //inicio o model de estoque
                $model_estoque = new Default_Model_Estoque();
                //inicio o model de controle de estoque
                $model_controle_estoque = new Default_Model_Estoquecontrole();
                //inicio o model de produto
                $model_produto = new Default_Model_Produtos();

                uasort($carrinho->produtos, function($a, $b) {
                    return $b['total_produto'] - $a['total_produto'];
                });

                // Foreach para validar o estoque
                foreach ($carrinho->produtos as $key => $item) {

                    $quantidade = $item['quantidade'];

                    $select_produto = $model_produto->select()
                            ->from("produtos", array(
                                "nome" => "DS_PRODUTO_PRRC",
                                "tipo_produto" => "NR_SEQ_TIPO_PRRC"))
                            ->where("NR_SEQ_PRODUTO_PRRC = ?", $item['codigo']);
                    $row_produto = $model_produto->fetchRow($select_produto);

                    $select_estoque = $model_estoque->select()
                            ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);
                    $produto_estoque = $model_estoque->fetchRow($select_estoque);

                    if ($row_produto["tipo_produto"] != 9) {
                        if ($produto_estoque['NR_QTDE_ESRC'] == 0) {
                            $messages->error = "Desculpe, o produto {$row_produto["nome"]} se esgotou em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }

                        if ($produto_estoque['NR_QTDE_ESRC'] < $quantidade) {
                            $messages->error = "Desculpe, não temos {$quantidade} {$row_produto["nome"]} em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                }

                //para cada produto no carrinho
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
                                "tipo_produto" => "NR_SEQ_TIPO_PRRC",
                                "categoria" => "NR_SEQ_CATEGORIA_PRRC",
                                "destaque" => "TP_DESTAQUE_PRRC",
                                "vl_custo" => "VL_PRODUTO2_PRRC"))
                            ->where("NR_SEQ_PRODUTO_PRRC = ?", $item['codigo']);
                    //atribuo o valor
                    $row_produto = $model_produto->fetchRow($select_produto);

                    //crio um array para exibir os dados do produtos de forma dinamica e nao salvar na sessao
                    $data_carrinho[$key] = array("codigo" => $row_produto['codigo'],
                        "nome" => $row_produto["nome"],
                        "descricao" => $row_produto['descricao'],
                        "path" => $row_produto['path'],
                        "valor" => $item['valor'],
                        "vl_promo" => $item['vl_promo'],
                        "vl_desconto" => $item['valor_total_desconto'],
                        "idestoque" => $item['idestoque'],
                        "estoque" => $item['estoque'],
                        "quantidade" => $item['quantidade'],
                        "destaque" => $row_produto["destaque"],
                        "sigla" => $item["sigla"],
                        "brinde" => $item["brinde"],
                        "tipo" => $row_produto["tipo_produto"],
                        "categoria" => $row_produto["categoria"]);

                    $modelAviseme = new Default_Model_Aviseme();
                    $dadosAviseme = $modelAviseme->fetchRow(array(
                        'NR_SEQ_PRODUTO_AVRC = ?' => $item['codigo'],
                        'NR_SEQ_TAMANHO_AVRC = ?' => $item['tamanho'],
                        'NR_SEQ_CADASTRO_AVRC = ?' => $usuarios->idperfil
                    ));

                    if ($dadosAviseme) {
                        $modelAviseme->update(array('ST_JACOMPROU_AVRC' => 'S'), array('NR_SEQ_AVISEME_AVRC = ?' => $dadosAviseme->NR_SEQ_AVISEME_AVRC));
                    }


                    /*                     * **************-
                     * ***************-
                     * *****PROMOS****-
                     * ***************-
                     * ************** */

                    //----------------//
                    //Primeira Niver //
                    //---------------//                    
                    if ($sessao_promo->niver > 0) {
                        $data_niver["ST_COMPROU_NIVER"] = 1;
                        $model_compras->update($data_niver, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));
                    }

                    //----------------//
                    //Primeira Compra//
                    //---------------//
                    if ($sessao_promo->primeira > 0) {
                        $data_primeira["ST_COMPROU_NIVER"] = 1;
                        $model_compras->update($data_primeira, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));
                    }

                    /*                     * **************-
                     * ***************-
                     * **FIM PROMOS***-
                     * ***************-
                     * ************** */

                    if ($usuarios->tipo == 'PJ') {

                        $valor = $data_carrinho[$key]['valor'];
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        $valor_uni = $data_carrinho[$key]['valor'];

                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto
                        $valor = $valor * $quantidade;

                        // Se o preço promocional for menor que o com desconto
                        if ($data_carrinho[$key]['codigo'] == 5745) {
                            $valor_uni = $data_carrinho[$key]['valor'];
                            $valor = $quantidade * $data_carrinho[$key]['valor'];
                        }

                        //assino o valor total por produto ao view
                        $this->view->total_produto = $valor;

                        $data_carrinho[$key]['vl_promo'] = 0;
                    } else {

                        //Zend_Debug::dump($carrinho->produtos); exit;
                        if ($data_carrinho[$key]['vl_desconto'] == NULL AND $sessao_promo->primeira == 1) {


                            if ($data_carrinho[$key]['vl_promo'] > 0) {
                                //jogo o valor do produto na variavel
                                $valor = $data_carrinho[$key]['vl_promo'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['vl_promo'];
                            } else {
                                //jogo o valor do produto na variavel
                                $valor = $data_carrinho[$key]['valor'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['valor'];
                            }
                        } elseif ($data_carrinho[$key]['vl_desconto'] == NULL) {

                            if ($data_carrinho[$key]['vl_promo'] > 0) {
                                $valor = $data_carrinho[$key]['vl_promo'];
                                $valor_uni = $data_carrinho[$key]['vl_promo'];
                            } else {
                                $valor = $data_carrinho[$key]['valor'];
                                $valor_uni = $data_carrinho[$key]['valor'];
                            }
                        } else {
                            //jogo o valor do produto na variavel
                            $valor = $data_carrinho[$key]['vl_desconto'];

                            //o mesmo valor para inserir no banco sem ter sido multiplicado
                            $valor_uni = $data_carrinho[$key]['vl_desconto'];
                        }

                        //atribuo o valor cheio
                        $valor_cheio = 0;
                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto
                        $valor = $valor;
                        //agora falo que tem produto cheio
                        $tem_cheio = 1;
                        //assino o valor total por produto ao view
                        $this->view->total_produto = $valor;
                    }

                    //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                    if ($valor_uni == 0.1 or $valor == 0.1) {
                        $valor_uni = 0;
                        $valor = 0;
                        $valor_cheio = 0;
                    }

                    //crio a query para pegar o estoque
                    if ($row_produto["tipo_produto"] != 9) {
                        $select_estoque = $model_estoque->select()
                                ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                        //armazeno o resultado do estoque em uma variavel
                        $produto_estoque = $model_estoque->fetchRow($select_estoque);

                        if ($produto_estoque['NR_QTDE_ESRC'] == 0) {
                            $messages->error = "Desculpe, o produto {$row_produto["nome"]} se esgotou em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }

                        if ($produto_estoque['NR_QTDE_ESRC'] < $quantidade) {
                            $messages->error = "Desculpe, não temos {$quantidade} {$row_produto["nome"]} em nosso estoque! :(";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                        }
                    }

                    //agora atualizo o carrinho com a quantidade disponivel
                    $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
                    //crio o array da cesta
                    $data_cesta = array("NR_SEQ_CADASTRO_CESO" => $usuarios->idperfil,
                        "NR_SEQ_COMPRA_CESO" => $idcompra,
                        "NR_SEQ_PRODUTO_CESO" => $item["codigo"],
                        "NR_SEQ_ESTOQUE_CESO" => $produto_estoque["NR_SEQ_ESTOQUE_ESRC"],
                        "NR_SEQ_TAMANHO_CESO" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                        "NR_QTDE_CESO" => $quantidade,
                        "VL_PRODUTO_CESO" => $valor_uni,
                        'VL_COM_DESCONTO' => $item['valor_total_desconto'],
                        "DT_INCLUSAO_CESO" => $data_hoje,
                        "VL_PRODUTOCHEIO_CESO" => $valor_cheio,
                        "VL_CUSTO_CESO" => $row_produto['vl_custo']);
                    //agora insiro o registro da cesta
                    $model_cestas->insert($data_cesta);

                    //agora verifico se Ã© vale presente para que possa inserir no banco
                    if ($row_produto["tipo_produto"] == 9) {
                        //inicio o model de vale presente
                        $model_valepresente = new Default_Model_Bilhetes();
                        //informo quais caracteres podem ser inseridos
                        $CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
                        //agora digo o tamanho maximo
                        $max = strlen($CaracteresAceitos) - 1;
                        //inicio a criacao do bilhete
                        $bilhete = date('Ymdhis');
                        //agora faÃ§o de 0 a 6
                        for ($i = 0; $i < 6; $i++) {
                            //concateno o bilhete de forma randomica
                            $bilhete .= $CaracteresAceitos{
                                    mt_rand(0, $max)};
                        }
                        $emailganhador = $dados['emailganhador'];

                        //coloco as informaÃ§Ãµes de vale presente em um array
                        $data_vale_presente = array("NR_SEQ_COMPRA_BIRC" => $idcompra,
                            "NR_SEQ_CADCRIADOR_BIRC" => $usuarios->idperfil,
                            "DS_BILHETE_BIRC" => $bilhete,
                            "DT_CRIACAO_BIRC" => date("Y-m-d H:i:s"),
                            "ST_STATUS_BIRC" => 'A',
                            "VL_BILHETE_BIRC" => $row_produto["valor"],
                            "DS_EMAILGANHADOR_BIRC" => $emailganhador);
                        //insiro os dados do bilhete
                        $model_valepresente->insert($data_vale_presente);
                    }
                    //atribuo o valor total do carrinho
                    $valor_total += $valor;

                    // fim foreach carrinho
                }


                if ($sessao_frete->cupom != "") {
                    //calculo o valor final
                    $valor_final = ($valor_total + $sessao_frete->valor) - $sessao_frete->valor_desconto;

                    ///inicio o model de vale presente
                    $model_valepresente = new Default_Model_Bilhetes();
                    //inicio a query
                    $select_valepresente = $model_valepresente->select()
                            ->from("bilhetes", array("NR_SEQ_BILHETES_BIRC",
                                "DS_BILHETE_BIRC",
                                "ST_STATUS_BIRC",
                                "VL_BILHETE_BIRC"))
                            ->where("DS_BILHETE_BIRC = '$sessao_frete->cupom'");


                    //crio uma lista com o vale presente
                    $valepresente = $model_valepresente->fetchRow($select_valepresente);
                    $idbilhete = $valepresente->NR_SEQ_BILHETES_BIRC;

                    // die($idbilhete);

                    $data_cupom = array("ST_STATUS_BIRC" => "U",
                        "DT_UTILIZACAO_BIRC" => $data_hoje);
                    //atualizo
                    $model_valepresente->update($data_cupom, array("NR_SEQ_BILHETES_BIRC = $idbilhete"));
                } else {
                    $sessao_frete->cupom = "";
                    $valor_final = ($valor_total + $sessao_frete->valor) - $sessao_frete->valor_desconto;
                    $sessao_frete->valor_desconto = "";
                }

                $data_compra["VL_TOTAL_COSO"] = $valor_final;

                if ($sessao_promo->valor_desconto > 0) {
                    $data_compra["VL_DESCONTO_COSO"] = $sessao_promo->valor_desconto;
                }

                $model_compras->update($data_compra, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                if ($forma_pagamento != 'boleto') {
                    $modelUsuario = new Default_Model_Reverbme();

                    $dadosUsuario = $modelUsuario->fetchRow(array('NR_SEQ_CADASTRO_CASO = ?' => $usuarios->idperfil))->toArray();

                    //$dados['vencimento_ano'] = substr($dados['vencimento_ano'], -2);
                    //require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
                    //Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

                    $valor_final = number_format((float) $valor_final, 2, '', '');


                    if ($dadosUsuario['DS_FONE_CASO'] != null) {
                        if ($dadosUsuario['DS_FONE_CASO'] == '-') {
                            $telefonenumber = '00000000';
                        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $dadosUsuario['DS_FONE_CASO'])) {
                            $arrayStrreplace = array(0 => ' ', 1 => '-');
                            $telefonenumber = str_replace($arrayStrreplace, '', $dadosUsuario['DS_FONE_CASO']);
                        } else {
                            $telefonenumber = $dadosUsuario['DS_FONE_CASO'];
                        }
                    }

                    $valida_cep = str_replace('.', '', $dadosUsuario['DS_CEP_CASO']);
                    $valida_cep = str_replace('/', '', $valida_cep);
                    $valida_cep = str_replace('-', '', $valida_cep);


                    $transaction = new PagarMe_Transaction(array(
                        'amount' => $valor_final,
                        'card_id' => $returnedTransaction->card->id,
                        'installments' => $numero_parcelas,
                        'metadata' => array('id_pedido' => $idcompra),
                        "customer" => array(
                            "name" => $dadosUsuario['DS_NOME_CASO'],
                            "document_number" => $dadosUsuario['DS_CPFCNPJ_CASO'],
                            "email" => $dadosUsuario['DS_EMAIL_CASO'],
                            "address" => array(
                                "street" => $dadosUsuario['DS_ENDERECO_CASO'],
                                "neighborhood" => $dadosUsuario['DS_BAIRRO_CASO'],
                                "zipcode" => $valida_cep,
                                "street_number" => $dadosUsuario['DS_NUMERO_CASO'],
                                "complementary" => $dadosUsuario['DS_COMPLEMENTO_CASO']
                            ),
                            "phone" => array(
                                "ddd" => $dadosUsuario['DS_DDDFONE_CASO'],
                                "number" => $telefonenumber
                            )
                        )
                    ));

                    try {
                        $transaction->charge();
                        $status = $transaction->getStatus();

                        //$db->commit();
                        if ($status == 'paid') {
                            date_default_timezone_set('America/Sao_Paulo');
                            $data_hoje = date("Y-m-d H:i:s");
                            $model_compras->update(array(
                                'ST_COMPRA_COSO' => 'P',
                                'DT_PAGAMENTO_COSO' => $data_hoje,
                                'DT_STATUS_COSO' => $data_hoje
                                    ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                            foreach ($carrinho->produtos as $key => $item) {
                                if ($usuarios->tipo == 'PJ') {

                                    //jogo o valor do produto na variavel
                                    $valor = $data_carrinho[$key]['valor'];
                                    //jogo o valor do produto na variavel de produto cheio
                                    $valor_cheio = $data_carrinho[$key]['valor'];
                                    $valor_uni = $data_carrinho[$key]['valor'];

                                    //recebo a quantidade
                                    $quantidade = $item['quantidade'];
                                    //multiplico pela quantidade do produto
                                    $valor = $valor * $quantidade;

                                    //assino o valor total por produto ao view
                                    $this->view->total_produto = $valor;

                                    $data_carrinho[$key]['vl_promo'] = 0;
                                } else {


                                    //aqui verifico se e promo ou nÃ£o
                                    if ($data_carrinho[$key]['vl_promo'] > 0) {
                                        //jogo o valor da promo no valor do produto
                                        $valor = $data_carrinho[$key]['vl_promo'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['vl_promo'];

                                        //atribuo o valor cheio
                                        $valor_cheio = $data_carrinho[$key]['valor'];

                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];

                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;

                                        //agora falo que tem promo na variavel
                                        $tem_promo = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto_promo = $valor;
                                    } else {
                                        //jogo o valor do produto na variavel
                                        $valor = $data_carrinho[$key]['valor'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['valor'];
                                        //atribuo o valor cheio
                                        $valor_cheio = 0;
                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];
                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;
                                        //agora falo que tem produto cheio
                                        $tem_cheio = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto = $valor;
                                    }
                                }

                                //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                                if ($valor_uni == 0.1 or $valor == 0.1) {
                                    $valor_uni = 0;
                                    $valor = 0;
                                    $valor_cheio = 0;
                                }

                                //crio a query para pegar o estoque
                                $select_estoque = $model_estoque->select()
                                        ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                                //armazeno o resultado do estoque em uma variavel
                                $produto_estoque = $model_estoque->fetchRow($select_estoque);

                                //agora eu insiro o valor da nova quantidade no array
                                $data_estoque = array('NR_QTDE_ESRC' => $produto_estoque['NR_QTDE_ESRC'] - $quantidade);
                                //agora atualizo o carrinho com a quantidade disponivel
                                $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
                                //atualizo a quantidade
                                $model_estoque->update($data_estoque, array("NR_SEQ_ESTOQUE_ESRC = ?" => $key));

                                //crio o array de controle de estoque
                                $data_controle = array("NR_SEQ_PRODUTO_ECRC" => $item["codigo"],
                                    "NR_SEQ_USUARIO_ECRC" => 9,
                                    "NR_SEQ_TAMANHO_ECRC" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                                    "DS_ACAO_ECRC" => "Removeu " . $quantidade,
                                    "DS_OBS_ECRC" => "Venda site - Compra Nr " . $idcompra,
                                    "DT_ACAO_ECRC" => $data_hoje,
                                    "NR_QTDE_ECRC" => "-" . $quantidade);
                                //agora insiro no banco de dados o registro do controle de estoque
                                $model_controle_estoque->insert($data_controle);
                            }

                            if (!empty($idContaCorrente)) {
                                $modelContaCorrente->update(array('ST_EXPIRADO_CRSA' => 'N'), array('NR_SEQ_CONTA_CRSA = ?' => $idContaCorrente));
                            }
                        } else if ($status == 'refused') {
                            //TransaÃ§Ã£o foi recusada
                            // $transaction->getRefuseReason() - mostra por que a transaÃ§Ã£o foi recusada
                            $model_compras->update(array(
                                'ST_COMPRA_COSO' => 'C',
                                'DT_PAGAMENTO_COSO' => $data_hoje,
                                'DT_STATUS_COSO' => $data_hoje
                                    ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));
                            // Se o status for diferente de pago e recusado
                        } else {
                            $model_compras->update(array(
                                'DS_RETORNO_COSO' => $status
                                    ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                            foreach ($carrinho->produtos as $key => $item) {
                                if ($usuarios->tipo == 'PJ') {

                                    //jogo o valor do produto na variavel
                                    $valor = $item['valor'];
                                    //jogo o valor do produto na variavel de produto cheio
                                    $valor_cheio = $item['valor'];
                                    $valor_uni = $item['valor'];

                                    //recebo a quantidade
                                    $quantidade = $item['quantidade'];
                                    //multiplico pela quantidade do produto
                                    $valor = $valor * $quantidade;

                                    //assino o valor total por produto ao view
                                    $this->view->total_produto = $valor;

                                    $data_carrinho[$key]['vl_promo'] = 0;
                                } else {


                                    //aqui verifico se e promo ou nÃ£o
                                    if ($data_carrinho[$key]['vl_promo'] > 0) {
                                        //jogo o valor da promo no valor do produto
                                        $valor = $data_carrinho[$key]['vl_promo'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['vl_promo'];

                                        //atribuo o valor cheio
                                        $valor_cheio = $data_carrinho[$key]['valor'];

                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];

                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;

                                        //agora falo que tem promo na variavel
                                        $tem_promo = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto_promo = $valor;
                                    } else {
                                        //jogo o valor do produto na variavel
                                        $valor = $data_carrinho[$key]['valor'];

                                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                                        $valor_uni = $data_carrinho[$key]['valor'];
                                        //atribuo o valor cheio
                                        $valor_cheio = 0;
                                        //recebo a quantidade
                                        $quantidade = $item['quantidade'];
                                        //multiplico pela quantidade do produto
                                        $valor = $valor * $quantidade;
                                        //agora falo que tem produto cheio
                                        $tem_cheio = 1;
                                        //assino o valor total por produto ao view
                                        $this->view->total_produto = $valor;
                                    }
                                }

                                //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                                if ($valor_uni == 0.1 or $valor == 0.1) {
                                    $valor_uni = 0;
                                    $valor = 0;
                                    $valor_cheio = 0;
                                }

                                //crio a query para pegar o estoque
                                $select_estoque = $model_estoque->select()
                                        ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                                //armazeno o resultado do estoque em uma variavel
                                $produto_estoque = $model_estoque->fetchRow($select_estoque);

                                //agora eu insiro o valor da nova quantidade no array
                                $data_estoque = array('NR_QTDE_ESRC' => $produto_estoque['NR_QTDE_ESRC'] - $quantidade);
                                //agora atualizo o carrinho com a quantidade disponivel
                                $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
                                //atualizo a quantidade
                                $model_estoque->update($data_estoque, array("NR_SEQ_ESTOQUE_ESRC = ?" => $key));
                                //crio o array de controle de estoque
                                $data_controle = array("NR_SEQ_PRODUTO_ECRC" => $item["codigo"],
                                    "NR_SEQ_USUARIO_ECRC" => 9,
                                    "NR_SEQ_TAMANHO_ECRC" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                                    "DS_ACAO_ECRC" => "Removeu " . $quantidade,
                                    "DS_OBS_ECRC" => "Venda site - Compra Nr " . $idcompra,
                                    "DT_ACAO_ECRC" => $data_hoje,
                                    "NR_QTDE_ECRC" => "-" . $quantidade);
                                //agora insiro no banco de dados o registro do controle de estoque
                                $model_controle_estoque->insert($data_controle);
                            }
                        }
                    } catch (Exception $ex) {
                        //$db->rollBack();
                        $messages->error = $ex->getMessage();

                        $model_compras->update(array(
                            'DS_RETORNO_COSO' => $ex->getMessage()
                                ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                        $model_compras->update(array(
                            'ST_COMPRA_COSO' => 'C',
                            'DT_PAGAMENTO_COSO' => $data_hoje,
                            'DT_STATUS_COSO' => $data_hoje
                                ), array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                        $this->_redirect($_SERVER['HTTP_REFERER']);
                    }

                    // Salvo o tid da transacao
                    $data = array(
                        'DS_TID_COSO' => $transaction->id
                    );
                    $model_compras->update($data, array('NR_SEQ_COMPRA_COSO = ?' => $idcompra));
                    // Se for boleto
                } else {
                    foreach ($carrinho->produtos as $key => $item) {
                        if ($usuarios->tipo == 'PJ') {

                            //jogo o valor do produto na variavel
                            $valor = $item['valor'];
                            //jogo o valor do produto na variavel de produto cheio
                            $valor_cheio = $item['valor'];
                            $valor_uni = $item['valor'];

                            //recebo a quantidade
                            $quantidade = $item['quantidade'];
                            //multiplico pela quantidade do produto
                            $valor = $valor * $quantidade;

                            //assino o valor total por produto ao view
                            $this->view->total_produto = $valor;

                            $data_carrinho[$key]['vl_promo'] = 0;
                        } else {

                            //aqui verifico se e promo ou nÃ£o
                            if ($data_carrinho[$key]['vl_promo'] > 0) {
                                //jogo o valor da promo no valor do produto
                                $valor = $data_carrinho[$key]['vl_promo'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['vl_promo'];

                                //atribuo o valor cheio
                                $valor_cheio = $data_carrinho[$key]['valor'];

                                //recebo a quantidade
                                $quantidade = $item['quantidade'];

                                //multiplico pela quantidade do produto
                                $valor = $valor * $quantidade;

                                //agora falo que tem promo na variavel
                                $tem_promo = 1;
                                //assino o valor total por produto ao view
                                $this->view->total_produto_promo = $valor;
                            } else {
                                //jogo o valor do produto na variavel
                                $valor = $data_carrinho[$key]['valor'];

                                //o mesmo valor para inserir no banco sem ter sido multiplicado
                                $valor_uni = $data_carrinho[$key]['valor'];
                                //atribuo o valor cheio
                                $valor_cheio = 0;
                                //recebo a quantidade
                                $quantidade = $item['quantidade'];
                                //multiplico pela quantidade do produto
                                $valor = $valor * $quantidade;
                                //agora falo que tem produto cheio
                                $tem_cheio = 1;
                                //assino o valor total por produto ao view
                                $this->view->total_produto = $valor;
                            }
                        }

                        //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                        if ($valor_uni == 0.1 or $valor == 0.1) {
                            $valor_uni = 0;
                            $valor = 0;
                            $valor_cheio = 0;
                        }

                        //crio a query para pegar o estoque
                        $select_estoque = $model_estoque->select()
                                ->where("NR_SEQ_ESTOQUE_ESRC = ?", $key);


                        //armazeno o resultado do estoque em uma variavel
                        $produto_estoque = $model_estoque->fetchRow($select_estoque);

                        //agora eu insiro o valor da nova quantidade no array
                        $data_estoque = array('NR_QTDE_ESRC' => $produto_estoque['NR_QTDE_ESRC'] - $quantidade);
                        //agora atualizo o carrinho com a quantidade disponivel
                        $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
                        //atualizo a quantidade
                        $model_estoque->update($data_estoque, array("NR_SEQ_ESTOQUE_ESRC = ?" => $key));
                        //crio o array de controle de estoque
                        $data_controle = array("NR_SEQ_PRODUTO_ECRC" => $item["codigo"],
                            "NR_SEQ_USUARIO_ECRC" => 9,
                            "NR_SEQ_TAMANHO_ECRC" => $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
                            "DS_ACAO_ECRC" => "Removeu " . $quantidade,
                            "DS_OBS_ECRC" => "Venda site - Compra Nr " . $idcompra,
                            "DT_ACAO_ECRC" => $data_hoje,
                            "NR_QTDE_ECRC" => "-" . $quantidade);
                        //agora insiro no banco de dados o registro do controle de estoque
                        $model_controle_estoque->insert($data_controle);
                    }

                    //require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
                    //Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

                    $valor_final = number_format((float) $valor_final, 2, '', '');

                    $vencimentoBoleto = date(DATE_ISO8601, strtotime("+3 days"));

                    $modelUsuario = new Default_Model_Reverbme();

                    $dadosUsuario = $modelUsuario->fetchRow(array('NR_SEQ_CADASTRO_CASO = ?' => $usuarios->idperfil))->toArray();

                    $transaction = new PagarMe_Transaction(array(
                        'payment_method' => 'boleto',
                        'amount' => $valor_final,
                        //'postback_url' => 'http://requestb.in/143jb281',
                        'postback_url' => 'https://www.reverbcity.com/checkout2/status-boleto',
                        'boleto_expiration_date' => $vencimentoBoleto,
                        'customer' => array(
                            'name' => $dadosUsuario['DS_NOME_CASO'],
                            'document_number' => $dadosUsuario['DS_CPFCNPJ_CASO'],
                            'email' => $dadosUsuario['DS_EMAIL_CASO']
                        ),
                        'metadata' => array('id_pedido' => $idcompra)
                    ));

                    try {
                        $transaction->charge();
                        //$db->commit();
                    } catch (Exception $ex) {
                        //$db->rollBack();
                        $messages->error = $ex->getMessage();
                        $this->_redirect($_SERVER['HTTP_REFERER']);
                    }

                    $data = array(
                        'DS_TID_COSO' => $transaction->id
                    );

                    $model_compras->update($data, array('NR_SEQ_COMPRA_COSO = ?' => $idcompra));
                }

                //redireciono para a pÃ¡gina do pedido
                $this->_redirect("finalizar-pedido-com-checkout/$idcompra");
            }
        } else {
            $messages->error = "Você precisa calcular o frete para poder avançar!";
            //redireciono
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * FunÃ§Ã£o responsÃ¡vel por finalizar a compra
     * */
    public function finalizarAction() {
        //desabilito o layout
        //inicio a sessao do usuario logado
        $usuarios = new Zend_Session_Namespace("usuarios");
        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");
        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //inicio a sessao de frete para mostrar o valor do mesmo apos ser calculado

        $sessao_frete = new Zend_Session_Namespace("fretes");
        //crio a sessao de mensagens de promo
        $sessao_promo = new Zend_Session_Namespace("promocoes");

        //verifico se existe usuÃ¡rio logado com sessao
        if ($usuarios->logado == TRUE) {

            //verifico se existe produtos no carrinho
            if (count($carrinho->produtos) <= 0) {
                //mensagem de retorno para o usuario
                $messages->error = "Seu carrinho esta vazio, sua compra já foi processada!";
                // Redireciona para a Ãºltima pÃ¡gina
                $this->_redirect("/todos-produtos");
            }

            $this->view->desconto_promo = $sessao_promo->valor_desconto;

            //defino variavel ja tem brinde
            $ja_tem_brinde = 0;

            $tem_cheio = 0;
            //recupero o pedido feito
            $idpedido = $this->_request->getParam("idpedido");

            /**
             * Criteo
             */
            $this->view->headScript()->appendFile('//static.criteo.net/js/ld/ld.js');
            $this->view->headScript()->appendFile($this->view->basePath . '/arquivos/default/js/criteo.js');
            $whatDevice = $this->_helper->navegacao->whatDevice();
            $userEmail = $this->_helper->usuario->getEmail();
            $strScript = $this->_helper->criteo->getTransaction($whatDevice, $userEmail, $idpedido);
            $this->view->headScript()->appendScript($strScript);

            //inicio o modulo de compra
            $model_compras = new Default_Model_Compras();
            //inicio a query de compra
            $select_compra = $model_compras->select()->where("NR_SEQ_COMPRA_COSO = ?", $idpedido);

            //crio a variavel da compra
            $compra = $model_compras->fetchRow($select_compra);
            //assino ao view
            $this->view->compra = $compra;

            //pego o cartao
            $cartao = $carrinho->produtos['nr_card'];

            //inicio o model de tamanho
            $model_tamanho = new Default_Model_Tamanhos();
            //inicio o model de produto
            $model_produto = new Default_Model_Produtos();
            //para cada produto no carrinho
            foreach ($carrinho->produtos as $key => $item) {
                //inicio  a query do tamanho escolhido
                $select_tamanho = $model_tamanho->select()
                        ->where("NR_SEQ_TAMANHO_TARC = ?", $item['tamanho']);

                //armazeno em uma variavel
                $tamanho_produto = $model_tamanho->fetchRow($select_tamanho);

                //crio a query dos produtos do carrinho
                $select_produto = $model_produto->select()
                        //digo que nao existe integridade entre as tabelas
                        ->setIntegrityCheck(false)
                        //so escolho os campos desejados
                        ->from("produtos", array("codigo" => "NR_SEQ_PRODUTO_PRRC",
                            "nome" => "DS_PRODUTO_PRRC",
                            "descricao" => "DS_INFORMACOES_PRRC",
                            "destaque" => "TP_DESTAQUE_PRRC",
                            "path" => "DS_EXT_PRRC"))
                        ->joinInner("cestas", "cestas.NR_SEQ_PRODUTO_CESO = produtos.NR_SEQ_PRODUTO_PRRC", array("valor" => "VL_PRODUTO_CESO",
                            "vl_promo" => "VL_PRODUTOCHEIO_CESO"))
                        ->where("NR_SEQ_PRODUTO_PRRC = ?", $item['codigo'])
                        ->where("NR_SEQ_COMPRA_CESO = ?", $idpedido)
                        ->group("NR_SEQ_PRODUTO_PRRC");
                //atribuo o valor


                $row_produto = $model_produto->fetchRow($select_produto);

                //crio um array para exibir os dados do produtos de forma dinamica e nao salvar na sessao
                $data_carrinho[$key] = array("codigo" => $row_produto['codigo'],
                    "nome" => $row_produto["nome"],
                    "descricao" => $row_produto['descricao'],
                    "path" => $row_produto['path'],
                    "valor" => $row_produto['valor'],
                    "vl_promo" => $row_produto['vl_promo'],
                    'valor_total_desconto' => $item['valor_total_desconto'],
                    "idestoque" => $item['idestoque'],
                    "estoque" => $item['estoque'],
                    "destaque" => $row_produto["destaque"],
                    "quantidade" => $item['quantidade']);

                /*                 * ************-
                 * **************-
                 * ****PROMOS****-
                 * **************-
                 * ************** */

                //-----------//
                //aniversario//
                //----------//
                //agora passo o valor do produto se tiver promo atribuo o valor de promo para ver na promo
                if ($data_carrinho[$key]['vl_promo'] == 0) {
                    $valor_produto_promo = $data_carrinho[$key]['valor'];
                } else {
                    $valor_produto_promo = $data_carrinho[$key]['vl_promo'];
                }

                // verifico se entrou na promo certa
                if ($sessao_promo->niver > 0) {

                    //Ã© aniversariante
                    $aniversariante == true;

                    //agora verifico se o produto adicionado anteriormente Ã© de valor maior que o atual
                    if ($valor_cheio >= $valor_produto_promo and $ja_tem_brinde == 0 and $item["tipo"] == 6) {

                        //se tiver apenas 1
                        if ($quantidade == 1) {
                            //defino os valores como 0
                            $data_carrinho[$key]['vl_promo'] = 0.1;

                            $data_carrinho[$key]['valor'] = 0;
                            //falo que ele ja ganhou um brinde
                            $ja_tem_brinde = 1;
                        }
                    }
                }


                //----------------//
                //Primeira Compra//
                //---------------//
                //verifico se Ã© a promo correta
                if ($sessao_promo->primeira > 0) {

                    //agora verifico se existe mais de o valor para entrar na promo em compras e se ainda nÃ£o entrou brinde para ele
                    if ($compra->VL_TOTAL_COSO >= $promocoes["vl_primeira_compra"]) {
                        // if($valor_total >= $promocoes["vl_primeira_compra"] and $ja_tem_brinde == 0){
                        //se tiver apenas 1
                        if ($item['quantidade'] == 1) {
                            //se tiver um de preco cheio
//                            if ($tem_cheio == 1) {
                                //agora vejo se e camiseta
                                if ($item["tipo"] == 6) {

                                    if ($ja_tem_brinde == 0) {

                                        if ($item["brinde"] == 1) {

                                            //defino os valores como 0
                                            $data_carrinho[$key]['vl_promo'] = 0.1;
                                            $data_carrinho[$key]['valor'] = 0;
                                            //falo que ele ja ganhou um brinde
                                            $ja_tem_brinde = 1;
                                        }
                                    }
                                }
//                            }
                        }
                    }
                }

                /*                 * ***********-
                 * **************-
                 * **FIM PROMOS***-
                 * **************-
                 * ************** */

                if ($usuarios->tipo == 'PJ') {
                    //atribuo o valor cheio
                    if ($data_carrinho[$key]['tipo'] == 142) {
                        //atribuo o valor cheio
                        $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
                        //jogo o valor do produto na variavel
                        $valor = $data_carrinho[$key]['valor'] * 0.7;
                        //jogo o valor do produto na variavel de produto cheio
                        $valor_uni = $data_carrinho[$key]['valor'] * 0.7;
                    } else {
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        $valor = $data_carrinho[$key]['valor'];
                        $valor_uni = $data_carrinho[$key]['valor'];
                    }

                    $data_carrinho[$key]['valor'] = $valor_cheio;

                    //recebo a quantidade
                    $quantidade = $item['quantidade'];
                    //multiplico pela quantidade do produto
                    $valor = $valor * $quantidade;

                    //assino o valor total por produto ao view
                    $this->view->total_produto = $valor;

                    $data_carrinho[$key]['vl_promo'] = 0;
                } else {


                    //aqui verifico se e promo ou nÃ£o
                    if ($data_carrinho[$key]['vl_promo'] > 0) {
                        //jogo o valor da promo no valor do produto
                        $valor = $data_carrinho[$key]['vl_promo'];

                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                        $valor_uni = $data_carrinho[$key]['vl_promo'];

                        //atribuo o valor cheio
                        $valor_cheio = $data_carrinho[$key]['valor'];

                        //recebo a quantidade
                        $quantidade = $item['quantidade'];

                        //multiplico pela quantidade do produto
                        $valor = $valor_cheio * $quantidade;



                        //agora falo que tem promo na variavel
                        $tem_promo = true;
                        //assino o valor total por produto ao view
                        $this->view->total_produto_promo = $valor;
                    } else {
                        //jogo o valor do produto na variavel
                        $valor = $data_carrinho[$key]['valor'];

                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                        $valor_uni = $data_carrinho[$key]['valor'];
                        //atribuo o valor cheio
                        $valor_cheio = 0;
                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto
                        $valor = $valor * $quantidade;
                        //agora falo que tem produto cheio
                        $tem_cheio = 1;
                        //assino o valor total por produto ao view
                        $this->view->total_produto = $valor;
                    }
                }

                //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                if ($valor_uni == 0.1 or $valor == 0.1) {
                    $valor_uni = 0;

                    $valor = 0;
                    $valor_cheio = 0;
                    $data_carrinho[$key]["valor"] = 0;
                    $data_carrinho[$key]["vl_promo"] = 0;
                }
                //atribuo o valor total para o carrinho
                $data_carrinho[$key]['total_produto'] = $valor;

                $carrinho->produtos[$key]['sigla_tamanho'] = $tamanho_produto['DS_SIGLA_TARC'];
                //concateno para a foto
                $foto = $item['codigo'] . "." . $item['path'];
                $vl_email = number_format($valor_uni, 2, ",", "");
                $total_mail = number_format($valor, 2, ",", "");


                $fotosProd = $this->view->fotoproduto($item['codigo']);

                //agora monto o miolo da mensagem do email com os itens adicionados ao carrinho
                $mensagem_meio .= '<tr border="0" cellspacing="0">                 
                <td width="600" height="68"bgcolor="#F3F4F4" style="background-color: #f3f4f4;color: #646464; font-size: 12px; font-family: Verdana" border="0">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td width="10" height="68"></td>
                                <td width="58" height="68">
                                    <img src="http://reverbcity.com/arquivos/uploads/fotosprodutos/' . $fotosProd[0]['NR_SEQ_FOTO_FORC'] . '.' . $fotosProd[0]['DS_EXT_FORC'] . '" width="58" height="68" alt="" border="0" cellpadding="0" cellspacing="0">
                                </td>
                                <td width="302" height="68" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="302" bgcolor="#F3F4F4" style="background-color: #f3f4f4; padding-left: 10px; color: #646464; font-size: 12px; font-family: Verdana"><b>' . $item["nome"] . '</b></td>                                                    
                                            </tr>
                                            <tr>
                                                <td width="302" bgcolor="#F3F4F4" style="background-color: #f3f4f4; padding-left: 10px; color: #646464; font-size: 12px; font-family: Verdana">Tamanho : ' . $tamanho_produto['DS_SIGLA_TARC'] . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="103" height="68" align="center" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0" cellpadding="0" cellspacing="0">
                                    <b>R$ ' . $vl_email . '</b>
                                </td>
                                <td width="50" height="68" align="center" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0" cellpadding="0" cellspacing="0">
                                    <b>' . $quantidade . '</b>
                                </td>
                                <td width="77" height="68" align="center" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0" cellpadding="0" cellspacing="0">
                                    <b>R$' . $total_mail . '</b>
                                </td>
                                <td width="10" height="68"></td> 
                            </tr>
                        </tbody>
                    </table>                        
                </td>
            </tr> <!-- Done --> ';
            }



            //armazendo a forma de pagamento
            $pagamento = $compra->DS_FORMAPGTO_COSO;

            //armazeno o valor total
            $total_fim = $compra->VL_TOTAL_COSO;
            //armazeno o numero de parcelas
            $numero_parcelas = $compra->NR_PARCELAS_COSO;

            $frete_mail = $sessao_frete->valor;

            $mensagem_meio .= '<tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr style="background-color: #FFF; color: #646464; font-size: 12px; font-family: Verdana;   text-align: center;" border="0" cellpadding="0" cellspacing="0">
                             <td width="433" height="28"></td> 
                             <td width="69" height="28" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
                                FRETE
                            </td>
                            <td width="98" height="28" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
                                R$ ' . number_format($frete_mail, 2, ",", "") . '
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana;   text-align: center;" border="0" cellpadding="0" cellspacing="0">
                            <td width="433" height="28"></td> 
                            <td width="69" height="28" bgcolor="#f3f4f4" border="0" cellpadding="0" cellspacing="0">
                                <b>TOTAL</b>
                            </td>
                            <td width="98" height="28" bgcolor="#f3f4f4" border="0" cellpadding="0" cellspacing="0">
                                <b>R$' . number_format($total_fim, 2, ",", "") . '</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->  
';

            //inicio o adaotador
            $db = Zend_Registry::get("db");

            //agora trago as informaÃ§Ãµes do usuÃ¡rio logado
            $select_comprador = "SELECT
										DS_LOGIN_CASO,
										DS_NOME_CASO,
										DS_ENDERECO_CASO,
										DS_NUMERO_CASO,
										DS_COMPLEMENTO_CASO,
										DS_BAIRRO_CASO,
										DS_CIDADE_CASO,
										DS_UF_CASO,
										DS_CEP_CASO,
										DS_EMAIL_CASO,
										DT_NASCIMENTO_CASO,
										DS_CPFCNPJ_CASO
									FROM
										cadastros
									WHERE
										NR_SEQ_CADASTRO_CASO = " . $usuarios->idperfil;

            //armazeno os dados do usuario em uma variavel
            $query_usuario = $db->query($select_comprador);

            //crio uma lista de categorias
            $usuario = $query_usuario->fetchAll();
            //crio a variavel com o pedido
            $pedido_visa .= "Prod.: $ds_prod - Vlr.: " . number_format($vl_prod, 2, ",", "") . " - Qtde: " . $qtde . " - Tot.: $vl_total\n";

            //atribuo o valor da ordem para vazio;
            $order = "";
            //agora armazeno as variaveis do usuario
            $nome = $usuario[0]['DS_NOME_CASO'];
            $cidade = $usuario[0]['DS_CIDADE_CASO'];
            $estado = $usuario[0]['DS_UF_CASO'];
            $cep = $usuario[0]['DS_CEP_CASO'];
            $endereco = $usuario[0]['DS_ENDERECO_CASO'];
            $numero = $usuario[0]['DS_NUMERO_CASO'];
            $documento = $usuario[0]['DS_CPFCNPJ_CASO'];
            $bairro = $usuario[0]['DS_BAIRRO_CASO'];

            //agora concateno
            $order = "Dados: " . $nome . ", Docto: " . $documento . ", " . $endereco . " - " . $bairro . " - " . $cep . ", " . $cidade . "/" . $estado;
            $order = $order . " - Pedido: " . $pedido_visa;
            $order = str_replace("\n", "", $order);
            //se o pagamento for boleto defino todas as variaveis como boleto
            if ($pagamento == "boleto") {
                $formapg = "boleto";
                $bandeira = "boleto";
                //se for visa defino a forma de pagamento como 1 (para a vista 2 para parcelas) isso se houver mais de 1 parcela
            } else if ($pagamento == "visa") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "visa";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "visa";
                    $forma_pagamento = "1";
                }
                //para mastercard se tiver mais de uma parcela forma de pagamento fica 2
            } else if ($pagamento == "mastercard") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "mastercard";
                    $forma_pagamento = "2";
                    //senao mantenho 1
                } else {
                    $formapg = "visa";
                    $bandeira = "mastercard";
                    $forma_pagamento = "1";
                }
                //para pagamento com American express
            } else if ($pagamento == "amex") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "amex";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "amex";
                    $forma_pagamento = "1";
                }
                //para dinners tudo como dinners
            } else if ($pagamento == "diners") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "diners";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "diners";
                    $forma_pagamento = "1";
                }
            } else if ($pagamento == "elo") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "elo";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "elo";
                    $forma_pagamento = "1";
                }
            }


            //se a forma da pagamento for boleto
            if ($formapg == "boleto") {

                //numero da referencia da transaÃ§Ã£o
                $refTran = "1500893";
                //numero de digitos do codigo de pedido
                $totdig = strlen($idpedido);
                //inicio a variavel do meio dos digitos como vazia
                $meio = "";
                //agora para o total de digitos ate 10 atribuo o valor para a variavel 0
                for ($f = 0; $f < 10 - $totdig; $f++) {
                    $meio .= "0";
                }
                //agora concateno o pedido com a quantidade de zeros a referencia da transaÃ§Ã£o
                $refTran .= $meio . $idpedido;
                //valor formatado
                $valor = number_format($total_fim, 2, "", "");
                //inicio a variavel vazia que armazenara o valor total e a transiÃ§Ã£o
                $vlTran = "";
                //o total de digitos do valor
                $totdigv = strlen($valor);
                //falo novamente que a variavel meio esta vazia
                $meio = "";
                //agora para cada digito do total de digitos do valor com maximo 15 atribuo o valor para a variavel 0
                for ($f = 0; $f < 15 - $totdigv; $f++) {
                    $meio .= "0";
                }
                //atribuindo o valor da transiÃ§Ã£o com o valor a ser pago
                $vlTran .= $meio . $valor;
                //pego o horario
                $t = time();
                //numero de dias atribuo para 3
                $numOfDays = 3;
                //agora gero o numero de offset baseado no numero de dias
                $offSet = 86400 * $numOfDays;

                $t += $offSet;
                //agora o form de gerar o boleto
                //assino ao view as variaveis necessarias
                $this->view->nome = $nome;
                $this->view->refTran = $refTran;
                $this->view->vlTran = $vlTran;
                $this->view->t = date("dmY", $t);
                //crio o endereco completo
                $end_completo = $endereco . ',' . $numero;
                $this->view->endereco = $end_completo;
                $this->view->cidade = $cidade;
                $this->view->estado = $estado;
                $this->view->cep = $cep;
                $this->view->bairro = $bairro;

                require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
                Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

                $transaction = PagarMe_Transaction::findById($compra->DS_TID_COSO);

                $this->view->boleto_url = $transaction->getBoletoUrl();
                // Destroi a sessÃ£o do carrinho e de promo no site
                Zend_Session::namespaceUnset("carrinho");
                Zend_Session::namespaceUnset("fretes");
                Zend_Session::namespaceUnset("promocoes");
            }
            //se for visa
            if ($formapg == "visa" or $formapg == "mastercard" or $formapg == "amex" or $formapg == "diners" or $formapg == "elo") {
                //digo que a bandeira e visa

                if (strlen($order) > 1000) {
                    $order = substr($order, 0, 1000);
                }
                //assino o cartao ao view
                $this->view->cartao = $cartao;
                $this->view->bandeira = $bandeira;
                $this->view->formapg = $forma_pagamento;
                $this->view->numero_parcelas = $numero_parcelas;

                if ($compra->ST_COMPRA_COSO == 'P') {
                    // Destroi a sessÃ£o do carrinho e de promo no site
                    Zend_Session::namespaceUnset("carrinho");
                    Zend_Session::namespaceUnset("fretes");
                    Zend_Session::namespaceUnset("promocoes");
                }
            }


            //assino ao view o valor total da compra
            $this->view->total_fim = $total_fim;
            //explodo o valor final para remover os ponto

            $total_fim = number_format($total_fim, 2, "", ".");

            $total_fim = explode(".", $total_fim);

            $total_fim = $total_fim[0] . "" . $total_fim[1];

            //assino ao view o valor total da compra
            $this->view->total = $total_fim;
            //assino o pedido a view
            $this->view->pedido = $idpedido;
            // Zend_Debug::dump($data_carrinho);die()
            //assino o carrinho ao view
            $this->view->carrinho = $data_carrinho;

            $modelEndereco = new Default_Model_Enderecosentrega();
            $selectEndereco = $modelEndereco->select()
                    ->from('enderecos', array())
                    ->columns(array(
                        'nome' => 'DS_DESTINATARIO_ENRC',
                        'endereco' => 'DS_ENDERECO_ENRC',
                        'numero' => 'DS_NUMERO_ENRC',
                        'bairro' => 'DS_BAIRRO_ENRC',
                        'cep' => 'DS_CEP_ENRC',
                        'cidade' => 'DS_CIDADE_ENRC',
                        'estado' => 'DS_UF_ENRC',
                        'complemento' => 'DS_COMPLEMENTO_ENRC'
                    ))
                    ->where('NR_SEQ_COMPRA_ENRC = ?', $idpedido);

            $dadosEndereco = $modelEndereco->fetchRow($selectEndereco);

            if ($dadosEndereco) {
                $this->view->enderecoCompra = $dadosEndereco;
            } else {
                $modelCadastro = new Default_Model_Reverbme();
                $selectCadastro = $modelCadastro->select()
                        ->from('cadastros', array())
                        ->columns(array(
                            'nome' => 'DS_NOME_CASO',
                            'endereco' => 'DS_ENDERECO_CASO',
                            'numero' => 'DS_NUMERO_CASO',
                            'bairro' => 'DS_BAIRRO_CASO',
                            'cep' => 'DS_CEP_CASO',
                            'cidade' => 'DS_CIDADE_CASO',
                            'estado' => 'DS_UF_CASO',
                            'complemento' => 'DS_COMPLEMENTO_CASO'
                        ))
                        ->where('NR_SEQ_CADASTRO_CASO = ?', $usuarios->idperfil);

                $dadosEndereco = $modelCadastro->fetchRow($selectCadastro);
                $this->view->enderecoCompra = $dadosEndereco;
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
            //junto os 2 tipos de banners em um sÃ³ array
            $banners_topo = array_merge($agendados_topo, $normais_topo);

            //Assino ao view
            $this->view->banners_topo = $banners_topo;

            //crio o model de me para pegar as informaÃ§Ãµes necessÃ¡rios para enviar junto ao email
            $model_me = new Default_Model_Reverbme();

            //consulto as informaÃ§Ãµes necessÃ¡rias do usuÃ¡rio
            $select_dados_user = $model_me->select()->from("cadastros", array("DS_NOME_CASO",
                        "DS_ENDERECO_CASO",
                        "DS_NUMERO_CASO",
                        "DS_COMPLEMENTO_CASO",
                        "DS_BAIRRO_CASO",
                        "DS_CIDADE_CASO",
                        "DS_UF_CASO",
                        "DS_EMAIL_CASO",
                        "DS_CPFCNPJ_CASO",
                        "DS_DDDCEL_CASO",
                        "DS_CELULAR_CASO",
                        "NR_SEQ_CADASTRO_CASO"))
                    ->where('NR_SEQ_CADASTRO_CASO = ?', $usuarios->idperfil);

            $dados_user = $model_me->fetchRow($select_dados_user);
            //inicio o model de entrega para verificar se o usuÃ¡rio colocou outro endereco de entrega
            $model_endereco_entrega = new Default_Model_Enderecosentrega();
            //consulto as informacoes de entrega
            $dados_entrega = $model_endereco_entrega->fetchRow(array('NR_SEQ_COMPRA_ENRC = ?' => $idpedido));

            //crio a mensagem do topo
            //crio a mensagem do topo
            $topo = '<table border="0" cellpadding="0" cellspacing="0" width="100%" id="elementar-wrapper" bgcolor="#fff" style="background-color: #fff;">
        <tbody>
            <tr>
                <td align="center" valign="top"><table id="Table_01" width="600" border="0" cellpadding="0" cellspacing="0" style="background-color: #fff;">
                    <tbody>
                        <tr> <!-- Done -->
                            <td width="600" bgcolor="#FFFFFF">
                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_topo.png" width="600" height="23" alt="" style="display: block;">
                            </td>
                        </tr> <!-- Done -->
                        <tr>
                            <td width="550">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                        <td>
                                            <a href="http://reverbcity.com/" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_logo.png" width="243" height="78" border="0" alt="Reverbcity - MÃƒÂºsica que veste!" style="display: block;">
                                            </a>
                                        </td>
                                        <td width="201" height="78" bgcolor="#FFFFFF">
                                            <img src="http://reverbcity.com/arquivos/emails/img_compra/spacer.gif" width="201" height="78" alt="" style="display: block;">
                                        </td>
                                        <td>
                                            <a href="http://instagram.com/reverbcity" target="_blank" rel="noreferrer"><img src="http://reverbcity.com/arquivos/emails/img_compra/topo_rss.png" width="37" height="78" border="0" alt="Instagram"></a>
                                        </td>
                                        <td>
                                            <a href="https://www.facebook.com/Reverbcity" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_fb.png" width="35" height="78" border="0" alt="Facebook">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="https://twitter.com/reverbcity" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_twitter.png" width="34" height="78" border="0" alt="Twitter">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="http://www.pinterest.com/reverbcity/" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_pinterest.png" width="50" height="78" border="0" alt="Pinterest">
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </td>       
                    </tr> <!-- Done -->
                    <tr>
                        <td width="600" height="5" bgcolor="#66C19D">
                            <img src="http://reverbcity.com/arquivos/emails/img_compra/spacer.gif" width="600" height="5" alt="">
                        </td>
                    </tr> <!-- Done -->
                    <tr>
                        <td width="600" height="14" bgcolor="#FFFFFF">
                            <img src="http://reverbcity.com/arquivos/emails/img_compra/spacer.gif" width="600" height="14" alt="">
                        </td>
                    </tr> <!-- Done -->';

            $mensagem_topo .= "<tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" height=\"31\" bgcolor=\"#646464\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana; text-transform: uppercase\">
                            Pedido Recebido na Reverbcity. Aguardando Confirmação de Pagamento
                        </td>
                    </tr> <!-- Done -->
								<tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td width=\"600\" height=\"1\" bgcolor=\"#FFFFFF\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img src=\"http://reverbcity.com/arquivos/emails/img_compra/spacer.gif\" width=\"600\" height=\"1\" alt=\"\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        </td>
                    </tr> <!-- Done -->

		        <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td width=\"600\" height=\"1\" bgcolor=\"#FFFFFF\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img src=\"http://reverbcity.com/arquivos/emails/img_compra/spacer.gif\" width=\"600\" height=\"1\" alt=\"\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        </td>
                    </tr> <!-- Done -->
                    
 <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td width=\"600\" height=\"8\" bgcolor=\"#FFFFFF\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img src=\"http://reverbcity.com/arquivos/emails/img_compra/spacer.gif\" width=\"600\" height=\"8\" alt=\"\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        </td>
                    </tr> <!-- Done -->
                    
 <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img border=\"0\" cellpadding=\"0\" cellspacing=\"0\" src=\"http://reverbcity.com/arquivos/emails/img_compra/pagamento_13.jpg\" width=\"600\" height=\"22\" alt=\"\">
                        </td>
                    </tr> <!-- Done -->                    
                    <tr>
                        <td border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" height=\"200\" style=\"padding-left: 15px; padding-right: 15px;  font-family: Verdana; font-size: 10px; color: #646464\">
                            Olá, <b>" . $dados_user->DS_NOME_CASO . ",</b>

                            A equipe da Reverbcity já está quase pronta para dar o play no seu pedido, mas antes da música começar 
                            precisamos fazer a confirmação do seu pagamento. Abaixo vamos te mandar um set list com uma série
                            de informações que você deve prestar atenção, para não perder o melhor do show: 

                            Esse email é a confirmação que sua compra foi realizada, mas o seu pagamento ainda não foi processado
                            pelo nosso sistema. 

                            Sua compra está sujeita a confirmação do pagamento do cartão de crédito ou boleto bancário (conforme a
                            opção escolhida no carrinho de compras). 

                            <b>Caso não receba o email de confirmação no período de 3 dias úteis, entre em contato através do 
                                atendimento@reverbcity.com ou pelo fone (43) 3322-8852.</b>

                                O prazo de entrega deverá ser contado a partir da data de recebimento do código de rastreamento.

                                Assim que seu pedido for despachado você receberá um email com o código de rastreamento fornecido pelos 

                                Correios.
                                Durante a época de promoções este email pode levar até 3 dias úteis para ser enviado.
                            </td>
                        </tr> <!-- Done -->
                        <tr>
                            <td width=\"600\" height=\"42\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                             NÚMERO PEDIDO: <b>$idpedido</b>
                         </td>
                     </tr> <!-- Done -->
			<tr>
                        <td width=\"600\" height=\"10\"></td>
                    </tr> <!-- Done -->				
<tr>
                        <td>
                            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                <tbody><tr>
                                    <td width=\"295\" height=\"27\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                        INFORMAÇÕES DE COBRANÇA
                                    </td>
                                    <td width=\"10\" height=\"27\"></td>
                                    <td width=\"295\" height=\"27\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                     INFORMAÇÕES DE ENTREGA
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </td>
             </tr> <!-- Done -->
             <tr>
                <td>
                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <tbody>
                            <tr>
                                <td width=\"275\" height=\"168\" bgcolor=\"#FFFFFF\" style=\"padding-right: 15px;background-color: #FFF; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								" . $dados_user->DS_NOME_CASO . "</br>
								" . $dados_user->DS_ENDERECO_CASO . ", " . $dados_user->DS_NUMERO_CASO . "</br>
								" . $dados_user->DS_COMPLEMENTO_CASO . "</br>
								" . $dados_user->DS_BAIRRO_CASO . "</br>
								" . $cidade . ", " . $estado . "</br>
								" . $dados_user->DS_EMAIL_CASO . "</br>
								CPF : " . $dados_user->DS_CPFCNPJ_CASO . "</br>
								Forma de pagamento : " . $compra->DS_FORMAPGTO_COSO . "</br>
							</td>";
            $mensagem_topo .= " <td width=\"10\" height=\"27\"></td>";
            //agora faÃ§o a condiÃ§Ã£o da forma de entrega, se o resultado da busca for nulo preencho com os dados do usuÃ¡rio, se tiver resultado, populo com os dados informados
            if ($dados_entrega == NULL) {
                $mensagem_topo .= "		<td width=\"275\" height=\"168\" bgcolor=\"#FFFFFF\" style=\"padding-right: 15px;background-color: #FFF; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								" . $dados_user->DS_NOME_CASO . "</br>
								" . $dados_user->DS_ENDERECO_CASO . ", " . $dados_user->DS_NUMERO_CASO . "</br>
								" . $dados_user->DS_COMPLEMENTO_CASO . "</br>
								" . $dados_user->DS_BAIRRO_CASO . "</br>
								" . $cidade . ", " . $estado . "</br>
								" . $dados_user->DS_EMAIL_CASO . "</br>
								CPF : " . $dados_user->DS_CPFCNPJ_CASO . "</br>
								Forma de pagamento : " . $compra->DS_FORMAPGTO_COSO . "</br>
							</td>
						";
            } else {
                $mensagem_topo .= "	<td width=\"283\" height=\"168\" colspan=\"9\" bgcolor=\"#FFFFFF\" style=\"background-color: #FFF; color: #646464; font-size: 12px; padding-left: 10px; font-family: Verdana;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
									" . $dados_entrega->DS_DESTINATARIO_ENRC . "</br>
									" . $dados_entrega->DS_ENDERECO_ENRC . ", " . $dados_entrega->DS_NUMERO_ENRC . "</br>
									" . $dados_entrega->DS_COMPLEMENTO_ENRC . "</br>
									" . $dados_entrega->DS_BAIRRO_ENRC . "</br>
									" . $dados_entrega->DS_CIDADE_ENRC . ", " . $DS_UF_ENRC . "</br>
									" . $dados_entrega->DS_FONE_ENRC . "</br>
									CEP : " . $dados_entrega->DS_CEP_ENRC . "</br>
									Forma de pagamento : " . $compra->DS_FORMAPGTO_COSO . "</br>
								</td>";
            }
            $mensagem_topo .= "</tr>
                        </tbody>
                    </table>
                </td>
            </tr> <!-- Done -->
            <tr>
                <td width=\"600\" height=\"10\"></td>
            </tr> <!-- Done -->
							 <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                <td width=\"579\" height=\"27\" colspan=\"15\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 10px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                    SEU PEDIDO
                </td>
            </tr> <!-- Done --> 
							
							";

            if ($formapg == "boleto") {
                $hoje_boleto = date('d/m/Y');
                // add 3 days to date
                $nova_data_boleto = date('d/m/Y', strtotime("+3 days"));
                $nova_data_boleto = str_replace("/", "", $nova_data_boleto);
                //form do boleto
//				$mensagem_baixo .=   "<tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
//									<td width=\"579\" height=\"102\" colspan=\"15\" bgcolor=\"#FFFFFF\" style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
//											<form action=\"https://www16.bancodobrasil.com.br/site/mpag/\" method=\"post\" name=\"pagamento\" target=\"_blank\">
//									            <input type=\"hidden\" name=\"idConv\" value=\"303990\" />
//									            <input type=\"hidden\" name=\"refTran\" value=\"".$refTran."\" />
//									            <input type=\"hidden\" name=\"valor\" value=\"". $vlTran."\" />
//									            <input type=\"hidden\" name=\"dtVenc\" value=\"". $nova_data_boleto ."\"/>
//									            <input type=\"hidden\" name=\"tpPagamento\" value=\"21\" />
//									            <input type=\"hidden\" name=\"urlRetorno\" value=\"/\" />
//									            <input type=\"hidden\" name=\"urlInforma\" value=\"RecBol.aspx\" />
//									            <input type=\"hidden\" name=\"nome\" value=\"".$dados_user->DS_NOME_CASO. "\" />
//									            <input type=\"hidden\" name=\"endereco\" value=\"".$dados_user->DS_ENDERECO_CASO.", ".$dados_user->DS_NUMERO_CASO."\" />
//									            <input type=\"hidden\" name=\"cidade\" value=\"".$dados_user->DS_CIDADE_CASO."\" />
//									            <input type=\"hidden\" name=\"uf\" value=\"".$estado."\" />
//									            <input type=\"hidden\" name=\"cep\" value=\"".$cep."\" />
//									            <input type=\"hidden\" name=\"msgLoja\" value=\"Voce fez uma reverb-compra\" />           
//									            <button type=\"submit\" style=\"background-color: #e85238; color: #FFF; width: 150px; height: 70px; border: none; float: right\">
//									               IMPRIMIR BOLETO
//									            </button>
//								        </form>
//									</td>
//								</tr>";

                $mensagem_baixo .= "<tr>
            <td width=\"600\" height=\"10\"></td>
        </tr> <!-- Done -->   
        <tr>
            <td>
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                    <tbody>
                        <tr>

                            <td width=\"10\" height=\"10\"></td>
                            <td width=\"430\"></td>
                            <td width=\"150\" height=\"50\" bgcolor=\"#FFFFFF\">
                                <a href=\"{$this->view->boleto_url}\" style=\"text-decoration: none; font-family: Verdana; font-size: 12px; text-align: center; color: #FFFFFF; background-color: #e85238; color: #FFF; width: 150px; height: 50px; border: none; float: right; padding: 15px; line-height: 50px\" target=\"_blank\" rel=\"noreferrer\">
                                    IMPRIMIR BOLETO 
                                </a>
                            </td>                                
                            <td width=\"10\" height=\"10\"></td>

                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->                  
        <tr>
            <td width=\"600\" height=\"10\"></td>
        </tr> <!-- Done -->  ";
            }
            //mensagem na parte inferior apos a listagem dos produtos
            $mensagem_baixo .= "        <tr>
            <td width=\"600\" bgcolor=\"#FFFFFF\" style=\"padding-left: 10px; padding-right: 10px; font-family: Verdana; font-size: 12px; color: #646464\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                Mantenha sempre o seu cadastro atualizado, pois caso haja alguma divergência nos dados, isso pode levar ao atraso na entrega da sua encomenda. <br>
                Para esclarecer qualquer dúvida: <b>atendimento@reverbcity.com</b>
            </td>
        </tr>  <!-- Done -->
        <tr>
            <td width=\"600\" height=\"10\"></td>
        </tr> <!-- Done -->";


            $rodape .= '<tr>
            <td>
                <img src="http://reverbcity.com/arquivos/emails/img_compra/3---mail_aguardando-confirmaÃ§Ã£o-de-pagamento_45.png" width="600" height="1" alt="">
            </td>
        </tr> <!-- Done -->
        <tr>
            <td width="600" height="10"></td>
        </tr> <!-- Done -->
        <tr>
            <td width="600"> 
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>                    
                        <tr>
                            <td width="600" style="padding-left: 10px; font-family: Verdana; font-size: 13px; font-style: italic">Abraços</td>
                        </tr>
                        <tr>
                            <td width="600" style="padding-left: 10px; font-family: Verdana; font-size: 13px; font-style: italic">Equipe Reverbcity</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->
        <tr>
            <td width="600" height="10"></td>
        </tr> <!-- Done -->
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td align="right">
                               <img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""/>
                           </td>
                           <td>
                            <a href="mailto:atendimento@reverbcity.com" onclick="return rcmail.command(\'compose\', \'atendimento@reverbcity.com\', this)" rel="noreferrer">
                                <img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""/>
                            </a>
                        </td>
                        <td align="left">    
                            <a href="http://www.reverbcity.com" target="_blank" rel="noreferrer">
                                <img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""/>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr> <!-- Done -->
    <tr>
        <td width="600" height="61" bgcolor="#FFFFFF" style="padding-left: 10px;font-size: 11px; color: #9e9e9e">
            <b>www.reverbcity.com</b> <br>
            Para garantir que você sempre receba as nossas mensagens <br>
            adicione o e-mail <u>news@reverbcity.com</u> em sua lista de contatos.
        </td>
    </tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';

            //agora concateno a mensagem toda
            $body .= $topo;
            $body .= $mensagem_topo;
            $body .= $mensagem_meio;
            $body .= $mensagem_baixo;
            $body .= $rodape;

            $fp = fopen("emailconfirmacaocompra.txt", "a");
            $escreve = fwrite($fp, $body);
            fclose($fp);

            //if ($compra->ST_COMPRA_COSO != 'P') {
            if ($formapg == 'boleto') {
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
                $mail->addTo($dados_user->DS_EMAIL_CASO, "Reverbcity - A Música que veste");
                $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email vÃ¡lido do seu dominio
                $mail->setSubject("Resumo da compra - Aguardando pagamento");
                $mail->send($mailTransport);
            }

            if ($formapg == 'boleto' or ( $compra->ST_COMPRA_COSO == 'P')) {
                $celddd = $dados_user->DS_DDDCEL_CASO;
                $celular = $dados_user->DS_CELULAR_CASO;
                $idc = $dados_user->NR_SEQ_CADASTRO_CASO;
                $SS_logadm = 32609;

                $texto = "Sua compra foi realizada com sucesso. Em breve vc recebera no seu email mais infos. Consulte seus pedidos aqui http://rvb.la/MinhaCompra";

                // //verifico se tem o celular
                $celddd = str_replace("(", "", $celddd);
                $celddd = str_replace(")", "", $celddd);
                $celddd = str_replace(" ", "", $celddd);

                $celular = str_replace("-", "", $celular);
                $celular = str_replace(".", "", $celular);
                $celular = str_replace("/", "", $celular);
                $celular = str_replace("=", "", $celular);
                $celular = str_replace(" ", "", $celular);

                $celularcomp = $celddd . $celular;

                if (substr($celularcomp, 0, 1) == "0") {

                    $celularcomp = substr($celularcomp, 1, strlen($celularcomp));
                }

                if (strlen($celularcomp) == 10 || strlen($celularcomp) == 11 || strlen($celularcomp) == 12) {

                    $msg = str_replace("&", "e", $texto);

                    $data_sms = array("NR_SEQ_USUARIO_SMRC" => $SS_logadm,
                        "NR_SEQ_CLIENTE_SMRC" => $idc,
                        "DS_CELULAR_SMRC" => $celularcomp,
                        "DS_MSG_SMRC" => $msg,
                        "DT_ENVIO_SMRC" => $hoje);

                    $msgid = $db->insert("sms_envios", $data_sms);

                    $url = "http://193.105.74.59/api/sendsms/plain?user=rbcity&password=rbcity123&sender=Reverbcity&GSM=55$celularcomp&SMStext=" . urlencode($msg);

                    $ch = curl_init();

                    $msg = URLEncode($msg);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                    //curl_setopt($ch, CURLOPT_POST, 1);
                    //curl_setopt($ch, CURLOPT_POSTFIELDS, "UserID=".$UserID."&Token=".$Token."&NroDestino=".$celular."&Mensagem=".$msg."&Remetente=Reverbcity");
                    curl_setopt($ch, CURLOPT_FAILONERROR, 0);

                    $resultbusca = curl_exec($ch);
                    curl_close($ch);

                    $resultbusca = trim($resultbusca);

                    $str = "UPDATE sms_envios SET DS_RETORNO_SMRC = '$resultbusca' where NR_SEQ_SMSENVIO_SMRC = $msgid";
                    //$st = mysql_query($str);
                    $db->query($str);

                    if (trim($resultbusca) > 0) {
                        //if (trim($resultbusca) == "OK"){
                        $strsms = "INSERT INTO sms_controle (NR_SEQ_SMS_CSRC, DS_DESCRICAO_CSRC, NR_QTDE_CSRC, DT_LANCTO_CRSC)
                                VALUES (" . $msgid . ", 'Envio de SMS', -1, sysdate())";
                        //$stsmss = mysql_query($strsms);
                        $db->query($strsms);
                    }
                }
            }

            // Destroi a sessÃ£o do carrinho e de promo no site
            // Zend_Session::namespaceUnset("carrinho");
            Zend_Session::namespaceUnset("promocoes");
        } else {
            $messages->error = "Você precisa estar logado para chegar a esta página";

            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * FunÃ§Ã£o responsÃ¡vel por finalizar a compra
     * */
    public function finalizarcomcheckoutAction() {
        //desabilito o layout
        //inicio a sessao do usuario logado
        $usuarios = new Zend_Session_Namespace("usuarios");
        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");
        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //inicio a sessao de frete para mostrar o valor do mesmo apos ser calculado

        $sessao_frete = new Zend_Session_Namespace("fretes");
        //crio a sessao de mensagens de promo
        $sessao_promo = new Zend_Session_Namespace("promocoes");

        //verifico se existe usuÃ¡rio logado com sessao
        if ($usuarios->logado == TRUE) {

            //verifico se existe produtos no carrinho
            if (count($carrinho->produtos) <= 0) {
                //mensagem de retorno para o usuario
                $messages->error = "Seu carrinho esta vazio, sua compra já foi processada!";
                // Redireciona para a Ãºltima pÃ¡gina
                $this->_redirect("/todos-produtos");
            }

            $this->view->desconto_promo = $sessao_promo->valor_desconto;

            //defino variavel ja tem brinde
            $ja_tem_brinde = 0;

            $tem_cheio = 0;
            //recupero o pedido feito
            $idpedido = $this->_request->getParam("idpedido");

            //inicio o modulo de compra
            $model_compras = new Default_Model_Compras();
            //inicio a query de compra
            $select_compra = $model_compras->select()->where("NR_SEQ_COMPRA_COSO = ?", $idpedido);

            //crio a variavel da compra
            $compra = $model_compras->fetchRow($select_compra);
            //assino ao view
            $this->view->compra = $compra;

            //pego o cartao
            $cartao = $carrinho->produtos['nr_card'];

            //inicio o model de tamanho
            $model_tamanho = new Default_Model_Tamanhos();
            //inicio o model de produto
            $model_produto = new Default_Model_Produtos();
            //para cada produto no carrinho
            foreach ($carrinho->produtos as $key => $item) {
                //inicio  a query do tamanho escolhido
                $select_tamanho = $model_tamanho->select()
                        ->where("NR_SEQ_TAMANHO_TARC = ?", $item['tamanho']);

                //armazeno em uma variavel
                $tamanho_produto = $model_tamanho->fetchRow($select_tamanho);

                //crio a query dos produtos do carrinho
                $select_produto = $model_produto->select()
                        //digo que nao existe integridade entre as tabelas
                        ->setIntegrityCheck(false)
                        //so escolho os campos desejados
                        ->from("produtos", array("codigo" => "NR_SEQ_PRODUTO_PRRC",
                            "nome" => "DS_PRODUTO_PRRC",
                            "descricao" => "DS_INFORMACOES_PRRC",
                            "destaque" => "TP_DESTAQUE_PRRC",
                            "path" => "DS_EXT_PRRC"))
                        ->joinInner("cestas", "cestas.NR_SEQ_PRODUTO_CESO = produtos.NR_SEQ_PRODUTO_PRRC", array("valor" => "VL_PRODUTO_CESO",
                            "vl_promo" => "VL_PRODUTOCHEIO_CESO"))
                        ->where("NR_SEQ_PRODUTO_PRRC = ?", $item['codigo'])
                        ->where("NR_SEQ_COMPRA_CESO = ?", $idpedido)
                        ->group("NR_SEQ_PRODUTO_PRRC");
                //atribuo o valor


                $row_produto = $model_produto->fetchRow($select_produto);

                //crio um array para exibir os dados do produtos de forma dinamica e nao salvar na sessao
                $data_carrinho[$key] = array("codigo" => $row_produto['codigo'],
                    "nome" => $row_produto["nome"],
                    "descricao" => $row_produto['descricao'],
                    "path" => $row_produto['path'],
                    "valor" => $row_produto['valor'],
                    "vl_promo" => $row_produto['vl_promo'],
                    'valor_total_desconto' => $item['valor_total_desconto'],
                    "idestoque" => $item['idestoque'],
                    "estoque" => $item['estoque'],
                    "destaque" => $row_produto["destaque"],
                    "quantidade" => $item['quantidade']);

                /*                 * ************-
                 * **************-
                 * ****PROMOS****-
                 * **************-
                 * ************** */

                //-----------//
                //aniversario//
                //----------//
                //agora passo o valor do produto se tiver promo atribuo o valor de promo para ver na promo
                if ($data_carrinho[$key]['vl_promo'] == 0) {
                    $valor_produto_promo = $data_carrinho[$key]['valor'];
                } else {
                    $valor_produto_promo = $data_carrinho[$key]['vl_promo'];
                }

                // verifico se entrou na promo certa
                if ($sessao_promo->niver > 0) {

                    //Ã© aniversariante
                    $aniversariante == true;

                    //agora verifico se o produto adicionado anteriormente Ã© de valor maior que o atual
                    if ($valor_cheio >= $valor_produto_promo and $ja_tem_brinde == 0 and $item["tipo"] == 6) {

                        //se tiver apenas 1
                        if ($quantidade == 1) {
                            //defino os valores como 0
                            $data_carrinho[$key]['vl_promo'] = 0.1;

                            $data_carrinho[$key]['valor'] = 0;
                            //falo que ele ja ganhou um brinde
                            $ja_tem_brinde = 1;
                        }
                    }
                }


                //----------------//
                //Primeira Compra//
                //---------------//
                //verifico se Ã© a promo correta
                if ($sessao_promo->primeira > 0) {

                    //agora verifico se existe mais de o valor para entrar na promo em compras e se ainda nÃ£o entrou brinde para ele
                    if ($compra->VL_TOTAL_COSO >= $promocoes["vl_primeira_compra"]) {
                        // if($valor_total >= $promocoes["vl_primeira_compra"] and $ja_tem_brinde == 0){
                        //se tiver apenas 1
                        if ($item['quantidade'] == 1) {
                            //se tiver um de preco cheio
//                            if ($tem_cheio == 1) {
                                //agora vejo se e camiseta
                                if ($item["tipo"] == 6) {

                                    if ($ja_tem_brinde == 0) {

                                        if ($item["brinde"] == 1) {

                                            //defino os valores como 0
                                            $data_carrinho[$key]['vl_promo'] = 0.1;
                                            $data_carrinho[$key]['valor'] = 0;
                                            //falo que ele ja ganhou um brinde
                                            $ja_tem_brinde = 1;
                                        }
                                    }
                                }
//                            }
                        }
                    }
                }

                /*                 * ***********-
                 * **************-
                 * **FIM PROMOS***-
                 * **************-
                 * ************** */

                if ($usuarios->tipo == 'PJ') {
                    //atribuo o valor cheio
                    if ($data_carrinho[$key]['tipo'] == 142) {
                        //atribuo o valor cheio
                        $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
                        //jogo o valor do produto na variavel
                        $valor = $data_carrinho[$key]['valor'] * 0.7;
                        //jogo o valor do produto na variavel de produto cheio
                        $valor_uni = $data_carrinho[$key]['valor'] * 0.7;
                    } else {
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        $valor = $data_carrinho[$key]['valor'];
                        $valor_uni = $data_carrinho[$key]['valor'];
                    }

                    $data_carrinho[$key]['valor'] = $valor_cheio;

                    //recebo a quantidade
                    $quantidade = $item['quantidade'];
                    //multiplico pela quantidade do produto
                    $valor = $valor * $quantidade;

                    //assino o valor total por produto ao view
                    $this->view->total_produto = $valor;

                    $data_carrinho[$key]['vl_promo'] = 0;
                } else {


                    //aqui verifico se e promo ou nÃ£o
                    if ($data_carrinho[$key]['vl_promo'] > 0) {
                        //jogo o valor da promo no valor do produto
                        $valor = $data_carrinho[$key]['vl_promo'];

                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                        $valor_uni = $data_carrinho[$key]['vl_promo'];

                        //atribuo o valor cheio
                        $valor_cheio = $data_carrinho[$key]['valor'];

                        //recebo a quantidade
                        $quantidade = $item['quantidade'];

                        //multiplico pela quantidade do produto
                        $valor = $valor_cheio * $quantidade;



                        //agora falo que tem promo na variavel
                        $tem_promo = true;
                        //assino o valor total por produto ao view
                        $this->view->total_produto_promo = $valor;
                    } else {
                        //jogo o valor do produto na variavel
                        $valor = $data_carrinho[$key]['valor'];

                        //o mesmo valor para inserir no banco sem ter sido multiplicado
                        $valor_uni = $data_carrinho[$key]['valor'];
                        //atribuo o valor cheio
                        $valor_cheio = 0;
                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto
                        $valor = $valor * $quantidade;
                        //agora falo que tem produto cheio
                        $tem_cheio = 1;
                        //assino o valor total por produto ao view
                        $this->view->total_produto = $valor;
                    }
                }

                //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                if ($valor_uni == 0.1 or $valor == 0.1) {
                    $valor_uni = 0;

                    $valor = 0;
                    $valor_cheio = 0;
                    $data_carrinho[$key]["valor"] = 0;
                    $data_carrinho[$key]["vl_promo"] = 0;
                }
                //atribuo o valor total para o carrinho
                $data_carrinho[$key]['total_produto'] = $valor;

                $carrinho->produtos[$key]['sigla_tamanho'] = $tamanho_produto['DS_SIGLA_TARC'];
                //concateno para a foto
                $foto = $item['codigo'] . "." . $item['path'];
                $vl_email = number_format($valor_uni, 2, ",", "");
                $total_mail = number_format($valor, 2, ",", "");


                $fotosProd = $this->view->fotoproduto($item['codigo']);

                //agora monto o miolo da mensagem do email com os itens adicionados ao carrinho
                $mensagem_meio .= '<tr border="0" cellspacing="0">                 
                <td width="600" height="68"bgcolor="#F3F4F4" style="background-color: #f3f4f4;color: #646464; font-size: 12px; font-family: Verdana" border="0">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td width="10" height="68"></td>
                                <td width="58" height="68">
                                    <img src="http://reverbcity.com/arquivos/uploads/fotosprodutos/' . $fotosProd[0]['NR_SEQ_FOTO_FORC'] . '.' . $fotosProd[0]['DS_EXT_FORC'] . '" width="58" height="68" alt="" border="0" cellpadding="0" cellspacing="0">
                                </td>
                                <td width="302" height="68" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="302" bgcolor="#F3F4F4" style="background-color: #f3f4f4; padding-left: 10px; color: #646464; font-size: 12px; font-family: Verdana"><b>' . $item["nome"] . '</b></td>                                                    
                                            </tr>
                                            <tr>
                                                <td width="302" bgcolor="#F3F4F4" style="background-color: #f3f4f4; padding-left: 10px; color: #646464; font-size: 12px; font-family: Verdana">Tamanho : ' . $tamanho_produto['DS_SIGLA_TARC'] . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="103" height="68" align="center" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0" cellpadding="0" cellspacing="0">
                                    <b>R$ ' . $vl_email . '</b>
                                </td>
                                <td width="50" height="68" align="center" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0" cellpadding="0" cellspacing="0">
                                    <b>' . $quantidade . '</b>
                                </td>
                                <td width="77" height="68" align="center" bgcolor="#F3F4F4" style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana" border="0" cellpadding="0" cellspacing="0">
                                    <b>R$' . $total_mail . '</b>
                                </td>
                                <td width="10" height="68"></td> 
                            </tr>
                        </tbody>
                    </table>                        
                </td>
            </tr> <!-- Done --> ';
            }



            //armazendo a forma de pagamento
            $pagamento = $compra->DS_FORMAPGTO_COSO;

            //armazeno o valor total
            $total_fim = $compra->VL_TOTAL_COSO;
            //armazeno o numero de parcelas
            $numero_parcelas = $compra->NR_PARCELAS_COSO;

            $frete_mail = $sessao_frete->valor;

            $mensagem_meio .= '<tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr style="background-color: #FFF; color: #646464; font-size: 12px; font-family: Verdana;   text-align: center;" border="0" cellpadding="0" cellspacing="0">
                             <td width="433" height="28"></td> 
                             <td width="69" height="28" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
                                FRETE
                            </td>
                            <td width="98" height="28" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
                                R$ ' . number_format($frete_mail, 2, ",", "") . '
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr style="background-color: #f3f4f4; color: #646464; font-size: 12px; font-family: Verdana;   text-align: center;" border="0" cellpadding="0" cellspacing="0">
                            <td width="433" height="28"></td> 
                            <td width="69" height="28" bgcolor="#f3f4f4" border="0" cellpadding="0" cellspacing="0">
                                <b>TOTAL</b>
                            </td>
                            <td width="98" height="28" bgcolor="#f3f4f4" border="0" cellpadding="0" cellspacing="0">
                                <b>R$' . number_format($total_fim, 2, ",", "") . '</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->  
';

            //inicio o adaotador
            $db = Zend_Registry::get("db");

            //agora trago as informaÃ§Ãµes do usuÃ¡rio logado
            $select_comprador = "SELECT
										DS_LOGIN_CASO,
										DS_NOME_CASO,
										DS_ENDERECO_CASO,
										DS_NUMERO_CASO,
										DS_COMPLEMENTO_CASO,
										DS_BAIRRO_CASO,
										DS_CIDADE_CASO,
										DS_UF_CASO,
										DS_CEP_CASO,
										DS_EMAIL_CASO,
										DT_NASCIMENTO_CASO,
										DS_CPFCNPJ_CASO
									FROM
										cadastros
									WHERE
										NR_SEQ_CADASTRO_CASO = " . $usuarios->idperfil;

            //armazeno os dados do usuario em uma variavel
            $query_usuario = $db->query($select_comprador);

            //crio uma lista de categorias
            $usuario = $query_usuario->fetchAll();
            //crio a variavel com o pedido
            $pedido_visa .= "Prod.: $ds_prod - Vlr.: " . number_format($vl_prod, 2, ",", "") . " - Qtde: " . $qtde . " - Tot.: $vl_total\n";

            //atribuo o valor da ordem para vazio;
            $order = "";
            //agora armazeno as variaveis do usuario
            $nome = $usuario[0]['DS_NOME_CASO'];
            $cidade = $usuario[0]['DS_CIDADE_CASO'];
            $estado = $usuario[0]['DS_UF_CASO'];
            $cep = $usuario[0]['DS_CEP_CASO'];
            $endereco = $usuario[0]['DS_ENDERECO_CASO'];
            $numero = $usuario[0]['DS_NUMERO_CASO'];
            $documento = $usuario[0]['DS_CPFCNPJ_CASO'];
            $bairro = $usuario[0]['DS_BAIRRO_CASO'];

            //agora concateno
            $order = "Dados: " . $nome . ", Docto: " . $documento . ", " . $endereco . " - " . $bairro . " - " . $cep . ", " . $cidade . "/" . $estado;
            $order = $order . " - Pedido: " . $pedido_visa;
            $order = str_replace("\n", "", $order);
            //se o pagamento for boleto defino todas as variaveis como boleto
            if ($pagamento == "boleto") {
                $formapg = "boleto";
                $bandeira = "boleto";
                //se for visa defino a forma de pagamento como 1 (para a vista 2 para parcelas) isso se houver mais de 1 parcela
            } else if ($pagamento == "visa") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "visa";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "visa";
                    $forma_pagamento = "1";
                }
                //para mastercard se tiver mais de uma parcela forma de pagamento fica 2
            } else if ($pagamento == "mastercard") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "mastercard";
                    $forma_pagamento = "2";
                    //senao mantenho 1
                } else {
                    $formapg = "visa";
                    $bandeira = "mastercard";
                    $forma_pagamento = "1";
                }
                //para pagamento com American express
            } else if ($pagamento == "amex") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "amex";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "amex";
                    $forma_pagamento = "1";
                }
                //para dinners tudo como dinners
            } else if ($pagamento == "diners") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "diners";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "diners";
                    $forma_pagamento = "1";
                }
            } else if ($pagamento == "elo") {
                if ($numero_parcelas > 1) {
                    $formapg = "visa";
                    $bandeira = "elo";
                    $forma_pagamento = "2";
                } else {
                    $formapg = "visa";
                    $bandeira = "elo";
                    $forma_pagamento = "1";
                }
            }

            //se a forma da pagamento for boleto
            if ($formapg == "boleto") {

                //numero da referencia da transaÃ§Ã£o
                $refTran = "1500893";
                //numero de digitos do codigo de pedido
                $totdig = strlen($idpedido);
                //inicio a variavel do meio dos digitos como vazia
                $meio = "";
                //agora para o total de digitos ate 10 atribuo o valor para a variavel 0
                for ($f = 0; $f < 10 - $totdig; $f++) {
                    $meio .= "0";
                }
                //agora concateno o pedido com a quantidade de zeros a referencia da transaÃ§Ã£o
                $refTran .= $meio . $idpedido;
                //valor formatado
                $valor = number_format($total_fim, 2, "", "");
                //inicio a variavel vazia que armazenara o valor total e a transiÃ§Ã£o
                $vlTran = "";
                //o total de digitos do valor
                $totdigv = strlen($valor);
                //falo novamente que a variavel meio esta vazia
                $meio = "";
                //agora para cada digito do total de digitos do valor com maximo 15 atribuo o valor para a variavel 0
                for ($f = 0; $f < 15 - $totdigv; $f++) {
                    $meio .= "0";
                }
                //atribuindo o valor da transiÃ§Ã£o com o valor a ser pago
                $vlTran .= $meio . $valor;
                //pego o horario
                $t = time();
                //numero de dias atribuo para 3
                $numOfDays = 3;
                //agora gero o numero de offset baseado no numero de dias
                $offSet = 86400 * $numOfDays;

                $t += $offSet;
                //agora o form de gerar o boleto
                //assino ao view as variaveis necessarias
                $this->view->nome = $nome;
                $this->view->refTran = $refTran;
                $this->view->vlTran = $vlTran;
                $this->view->t = date("dmY", $t);
                //crio o endereco completo
                $end_completo = $endereco . ',' . $numero;
                $this->view->endereco = $end_completo;
                $this->view->cidade = $cidade;
                $this->view->estado = $estado;
                $this->view->cep = $cep;
                $this->view->bairro = $bairro;

                require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
                Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

                $transaction = PagarMe_Transaction::findById($compra->DS_TID_COSO);

                $this->view->boleto_url = $transaction->getBoletoUrl();
                // Destroi a sessÃ£o do carrinho e de promo no site
                Zend_Session::namespaceUnset("carrinho");
                Zend_Session::namespaceUnset("fretes");
                Zend_Session::namespaceUnset("promocoes");
            }
            //se for visa
            if ($formapg == "visa" or $formapg == "mastercard" or $formapg == "amex" or $formapg == "diners" or $formapg == "elo") {
                //digo que a bandeira e visa

                if (strlen($order) > 1000) {
                    $order = substr($order, 0, 1000);
                }
                //assino o cartao ao view
                $this->view->cartao = $cartao;
                $this->view->bandeira = $bandeira;
                $this->view->formapg = $forma_pagamento;
                $this->view->numero_parcelas = $numero_parcelas;

                if ($compra->ST_COMPRA_COSO == 'P') {
                    // Destroi a sessÃ£o do carrinho e de promo no site
                    Zend_Session::namespaceUnset("carrinho");
                    Zend_Session::namespaceUnset("fretes");
                    Zend_Session::namespaceUnset("promocoes");
                }
            }


            //assino ao view o valor total da compra
            $this->view->total_fim = $total_fim;
            //explodo o valor final para remover os ponto

            $total_fim = number_format($total_fim, 2, "", ".");

            $total_fim = explode(".", $total_fim);

            $total_fim = $total_fim[0] . "" . $total_fim[1];

            //assino ao view o valor total da compra
            $this->view->total = $total_fim;
            //assino o pedido a view
            $this->view->pedido = $idpedido;
            // Zend_Debug::dump($data_carrinho);die()
            //assino o carrinho ao view
            $this->view->carrinho = $data_carrinho;

            $modelEndereco = new Default_Model_Enderecosentrega();
            $selectEndereco = $modelEndereco->select()
                    ->from('enderecos', array())
                    ->columns(array(
                        'nome' => 'DS_DESTINATARIO_ENRC',
                        'endereco' => 'DS_ENDERECO_ENRC',
                        'numero' => 'DS_NUMERO_ENRC',
                        'bairro' => 'DS_BAIRRO_ENRC',
                        'cep' => 'DS_CEP_ENRC',
                        'cidade' => 'DS_CIDADE_ENRC',
                        'estado' => 'DS_UF_ENRC',
                        'complemento' => 'DS_COMPLEMENTO_ENRC'
                    ))
                    ->where('NR_SEQ_COMPRA_ENRC = ?', $idpedido);

            $dadosEndereco = $modelEndereco->fetchRow($selectEndereco);

            if ($dadosEndereco) {
                $this->view->enderecoCompra = $dadosEndereco;
            } else {
                $modelCadastro = new Default_Model_Reverbme();
                $selectCadastro = $modelCadastro->select()
                        ->from('cadastros', array())
                        ->columns(array(
                            'nome' => 'DS_NOME_CASO',
                            'endereco' => 'DS_ENDERECO_CASO',
                            'numero' => 'DS_NUMERO_CASO',
                            'bairro' => 'DS_BAIRRO_CASO',
                            'cep' => 'DS_CEP_CASO',
                            'cidade' => 'DS_CIDADE_CASO',
                            'estado' => 'DS_UF_CASO',
                            'complemento' => 'DS_COMPLEMENTO_CASO'
                        ))
                        ->where('NR_SEQ_CADASTRO_CASO = ?', $usuarios->idperfil);

                $dadosEndereco = $modelCadastro->fetchRow($selectCadastro);
                $this->view->enderecoCompra = $dadosEndereco;
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
            //junto os 2 tipos de banners em um sÃ³ array
            $banners_topo = array_merge($agendados_topo, $normais_topo);

            //Assino ao view
            $this->view->banners_topo = $banners_topo;

            //crio o model de me para pegar as informaÃ§Ãµes necessÃ¡rios para enviar junto ao email
            $model_me = new Default_Model_Reverbme();

            //consulto as informaÃ§Ãµes necessÃ¡rias do usuÃ¡rio
            $select_dados_user = $model_me->select()->from("cadastros", array("DS_NOME_CASO",
                        "DS_ENDERECO_CASO",
                        "DS_NUMERO_CASO",
                        "DS_COMPLEMENTO_CASO",
                        "DS_BAIRRO_CASO",
                        "DS_CIDADE_CASO",
                        "DS_UF_CASO",
                        "DS_EMAIL_CASO",
                        "DS_CPFCNPJ_CASO",
                        "DS_DDDCEL_CASO",
                        "DS_CELULAR_CASO",
                        "NR_SEQ_CADASTRO_CASO"))
                    ->where('NR_SEQ_CADASTRO_CASO = ?', $usuarios->idperfil);

            $dados_user = $model_me->fetchRow($select_dados_user);
            //inicio o model de entrega para verificar se o usuÃ¡rio colocou outro endereco de entrega
            $model_endereco_entrega = new Default_Model_Enderecosentrega();
            //consulto as informacoes de entrega
            $dados_entrega = $model_endereco_entrega->fetchRow(array('NR_SEQ_COMPRA_ENRC = ?' => $idpedido));

            //crio a mensagem do topo
            //crio a mensagem do topo
            $topo = '<table border="0" cellpadding="0" cellspacing="0" width="100%" id="elementar-wrapper" bgcolor="#fff" style="background-color: #fff;">
        <tbody>
            <tr>
                <td align="center" valign="top"><table id="Table_01" width="600" border="0" cellpadding="0" cellspacing="0" style="background-color: #fff;">
                    <tbody>
                        <tr> <!-- Done -->
                            <td width="600" bgcolor="#FFFFFF">
                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_topo.png" width="600" height="23" alt="" style="display: block;">
                            </td>
                        </tr> <!-- Done -->
                        <tr>
                            <td width="550">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                        <td>
                                            <a href="http://reverbcity.com/" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_logo.png" width="243" height="78" border="0" alt="Reverbcity - MÃƒÂºsica que veste!" style="display: block;">
                                            </a>
                                        </td>
                                        <td width="201" height="78" bgcolor="#FFFFFF">
                                            <img src="http://reverbcity.com/arquivos/emails/img_compra/spacer.gif" width="201" height="78" alt="" style="display: block;">
                                        </td>
                                        <td>
                                            <a href="http://instagram.com/reverbcity" target="_blank" rel="noreferrer"><img src="http://reverbcity.com/arquivos/emails/img_compra/topo_rss.png" width="37" height="78" border="0" alt="Instagram"></a>
                                        </td>
                                        <td>
                                            <a href="https://www.facebook.com/Reverbcity" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_fb.png" width="35" height="78" border="0" alt="Facebook">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="https://twitter.com/reverbcity" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_twitter.png" width="34" height="78" border="0" alt="Twitter">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="http://www.pinterest.com/reverbcity/" target="_blank" rel="noreferrer">
                                                <img src="http://reverbcity.com/arquivos/emails/img_compra/topo_pinterest.png" width="50" height="78" border="0" alt="Pinterest">
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </td>       
                    </tr> <!-- Done -->
                    <tr>
                        <td width="600" height="5" bgcolor="#66C19D">
                            <img src="http://reverbcity.com/arquivos/emails/img_compra/spacer.gif" width="600" height="5" alt="">
                        </td>
                    </tr> <!-- Done -->
                    <tr>
                        <td width="600" height="14" bgcolor="#FFFFFF">
                            <img src="http://reverbcity.com/arquivos/emails/img_compra/spacer.gif" width="600" height="14" alt="">
                        </td>
                    </tr> <!-- Done -->';

            $mensagem_topo .= "<tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" height=\"31\" bgcolor=\"#646464\" style=\"background-color: #646464; color: #dcddde; font-size: 12px; padding-left: 32px; font-family: Verdana; text-transform: uppercase\">
                            Pedido Recebido na Reverbcity. Aguardando Confirmação de Pagamento
                        </td>
                    </tr> <!-- Done -->
								<tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td width=\"600\" height=\"1\" bgcolor=\"#FFFFFF\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img src=\"http://reverbcity.com/arquivos/emails/img_compra/spacer.gif\" width=\"600\" height=\"1\" alt=\"\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        </td>
                    </tr> <!-- Done -->

		        <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td width=\"600\" height=\"1\" bgcolor=\"#FFFFFF\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img src=\"http://reverbcity.com/arquivos/emails/img_compra/spacer.gif\" width=\"600\" height=\"1\" alt=\"\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        </td>
                    </tr> <!-- Done -->
                    
 <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td width=\"600\" height=\"8\" bgcolor=\"#FFFFFF\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img src=\"http://reverbcity.com/arquivos/emails/img_compra/spacer.gif\" width=\"600\" height=\"8\" alt=\"\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        </td>
                    </tr> <!-- Done -->
                    
 <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <td border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <img border=\"0\" cellpadding=\"0\" cellspacing=\"0\" src=\"http://reverbcity.com/arquivos/emails/img_compra/pagamento_13.jpg\" width=\"600\" height=\"22\" alt=\"\">
                        </td>
                    </tr> <!-- Done -->                    
                    <tr>
                        <td border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" height=\"200\" style=\"padding-left: 15px; padding-right: 15px;  font-family: Verdana; font-size: 10px; color: #646464\">
                            Olá, <b>" . $dados_user->DS_NOME_CASO . ",</b>

                            A equipe da Reverbcity já está quase pronta para dar o play no seu pedido, mas antes da música começar 
                            precisamos fazer a confirmação do seu pagamento. Abaixo vamos te mandar um set list com uma série
                            de informações que você deve prestar atenção, para não perder o melhor do show: 

                            Esse email é a confirmação que sua compra foi realizada, mas o seu pagamento ainda não foi processado
                            pelo nosso sistema. 

                            Sua compra está sujeita a confirmação do pagamento do cartão de crédito ou boleto bancário (conforme a
                            opção escolhida no carrinho de compras). 

                            <b>Caso não receba o email de confirmação no período de 3 dias úteis, entre em contato através do 
                                atendimento@reverbcity.com ou pelo fone (43) 3322-8852.</b>

                                O prazo de entrega deverá ser contado a partir da data de recebimento do código de rastreamento.

                                Assim que seu pedido for despachado você receberá um email com o código de rastreamento fornecido pelos 

                                Correios.
                                Durante a época de promoções este email pode levar até 3 dias úteis para ser enviado.
                            </td>
                        </tr> <!-- Done -->
                        <tr>
                            <td width=\"600\" height=\"42\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                             NÚMERO PEDIDO: <b>$idpedido</b>
                         </td>
                     </tr> <!-- Done -->
			<tr>
                        <td width=\"600\" height=\"10\"></td>
                    </tr> <!-- Done -->				
<tr>
                        <td>
                            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                <tbody><tr>
                                    <td width=\"295\" height=\"27\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                        INFORMAÇÕES DE COBRANÇA
                                    </td>
                                    <td width=\"10\" height=\"27\"></td>
                                    <td width=\"295\" height=\"27\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                     INFORMAÇÕES DE ENTREGA
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </td>
             </tr> <!-- Done -->
             <tr>
                <td>
                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <tbody>
                            <tr>
                                <td width=\"275\" height=\"168\" bgcolor=\"#FFFFFF\" style=\"padding-right: 15px;background-color: #FFF; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								" . $dados_user->DS_NOME_CASO . "</br>
								" . $dados_user->DS_ENDERECO_CASO . ", " . $dados_user->DS_NUMERO_CASO . "</br>
								" . $dados_user->DS_COMPLEMENTO_CASO . "</br>
								" . $dados_user->DS_BAIRRO_CASO . "</br>
								" . $cidade . ", " . $estado . "</br>
								" . $dados_user->DS_EMAIL_CASO . "</br>
								CPF : " . $dados_user->DS_CPFCNPJ_CASO . "</br>
								Forma de pagamento : " . $compra->DS_FORMAPGTO_COSO . "</br>
							</td>";
            $mensagem_topo .= " <td width=\"10\" height=\"27\"></td>";
            //agora faÃ§o a condiÃ§Ã£o da forma de entrega, se o resultado da busca for nulo preencho com os dados do usuÃ¡rio, se tiver resultado, populo com os dados informados
            if ($dados_entrega == NULL) {
                $mensagem_topo .= "		<td width=\"275\" height=\"168\" bgcolor=\"#FFFFFF\" style=\"padding-right: 15px;background-color: #FFF; color: #646464; font-size: 12px; padding-left: 15px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								" . $dados_user->DS_NOME_CASO . "</br>
								" . $dados_user->DS_ENDERECO_CASO . ", " . $dados_user->DS_NUMERO_CASO . "</br>
								" . $dados_user->DS_COMPLEMENTO_CASO . "</br>
								" . $dados_user->DS_BAIRRO_CASO . "</br>
								" . $cidade . ", " . $estado . "</br>
								" . $dados_user->DS_EMAIL_CASO . "</br>
								CPF : " . $dados_user->DS_CPFCNPJ_CASO . "</br>
								Forma de pagamento : " . $compra->DS_FORMAPGTO_COSO . "</br>
							</td>
						";
            } else {
                $mensagem_topo .= "	<td width=\"283\" height=\"168\" colspan=\"9\" bgcolor=\"#FFFFFF\" style=\"background-color: #FFF; color: #646464; font-size: 12px; padding-left: 10px; font-family: Verdana;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
									" . $dados_entrega->DS_DESTINATARIO_ENRC . "</br>
									" . $dados_entrega->DS_ENDERECO_ENRC . ", " . $dados_entrega->DS_NUMERO_ENRC . "</br>
									" . $dados_entrega->DS_COMPLEMENTO_ENRC . "</br>
									" . $dados_entrega->DS_BAIRRO_ENRC . "</br>
									" . $dados_entrega->DS_CIDADE_ENRC . ", " . $DS_UF_ENRC . "</br>
									" . $dados_entrega->DS_FONE_ENRC . "</br>
									CEP : " . $dados_entrega->DS_CEP_ENRC . "</br>
									Forma de pagamento : " . $compra->DS_FORMAPGTO_COSO . "</br>
								</td>";
            }
            $mensagem_topo .= "</tr>
                        </tbody>
                    </table>
                </td>
            </tr> <!-- Done -->
            <tr>
                <td width=\"600\" height=\"10\"></td>
            </tr> <!-- Done -->
							 <tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                <td width=\"579\" height=\"27\" colspan=\"15\" bgcolor=\"#DCDDDE\" style=\"background-color: #dcddde; color: #646464; font-size: 12px; padding-left: 10px; font-family: Verdana\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                    SEU PEDIDO
                </td>
            </tr> <!-- Done --> 
							
							";

            if ($formapg == "boleto") {
                $hoje_boleto = date('d/m/Y');
                // add 3 days to date
                $nova_data_boleto = date('d/m/Y', strtotime("+3 days"));
                $nova_data_boleto = str_replace("/", "", $nova_data_boleto);
                //form do boleto
//				$mensagem_baixo .=   "<tr border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
//									<td width=\"579\" height=\"102\" colspan=\"15\" bgcolor=\"#FFFFFF\" style=\"padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
//											<form action=\"https://www16.bancodobrasil.com.br/site/mpag/\" method=\"post\" name=\"pagamento\" target=\"_blank\">
//									            <input type=\"hidden\" name=\"idConv\" value=\"303990\" />
//									            <input type=\"hidden\" name=\"refTran\" value=\"".$refTran."\" />
//									            <input type=\"hidden\" name=\"valor\" value=\"". $vlTran."\" />
//									            <input type=\"hidden\" name=\"dtVenc\" value=\"". $nova_data_boleto ."\"/>
//									            <input type=\"hidden\" name=\"tpPagamento\" value=\"21\" />
//									            <input type=\"hidden\" name=\"urlRetorno\" value=\"/\" />
//									            <input type=\"hidden\" name=\"urlInforma\" value=\"RecBol.aspx\" />
//									            <input type=\"hidden\" name=\"nome\" value=\"".$dados_user->DS_NOME_CASO. "\" />
//									            <input type=\"hidden\" name=\"endereco\" value=\"".$dados_user->DS_ENDERECO_CASO.", ".$dados_user->DS_NUMERO_CASO."\" />
//									            <input type=\"hidden\" name=\"cidade\" value=\"".$dados_user->DS_CIDADE_CASO."\" />
//									            <input type=\"hidden\" name=\"uf\" value=\"".$estado."\" />
//									            <input type=\"hidden\" name=\"cep\" value=\"".$cep."\" />
//									            <input type=\"hidden\" name=\"msgLoja\" value=\"Voce fez uma reverb-compra\" />           
//									            <button type=\"submit\" style=\"background-color: #e85238; color: #FFF; width: 150px; height: 70px; border: none; float: right\">
//									               IMPRIMIR BOLETO
//									            </button>
//								        </form>
//									</td>
//								</tr>";

                $mensagem_baixo .= "<tr>
            <td width=\"600\" height=\"10\"></td>
        </tr> <!-- Done -->   
        <tr>
            <td>
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                    <tbody>
                        <tr>

                            <td width=\"10\" height=\"10\"></td>
                            <td width=\"430\"></td>
                            <td width=\"150\" height=\"50\" bgcolor=\"#FFFFFF\">
                                <a href=\"{$this->view->boleto_url}\" style=\"text-decoration: none; font-family: Verdana; font-size: 12px; text-align: center; color: #FFFFFF; background-color: #e85238; color: #FFF; width: 150px; height: 50px; border: none; float: right; padding: 15px; line-height: 50px\" target=\"_blank\" rel=\"noreferrer\">
                                    IMPRIMIR BOLETO 
                                </a>
                            </td>                                
                            <td width=\"10\" height=\"10\"></td>

                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->                  
        <tr>
            <td width=\"600\" height=\"10\"></td>
        </tr> <!-- Done -->  ";
            }
            //mensagem na parte inferior apos a listagem dos produtos
            $mensagem_baixo .= "        <tr>
            <td width=\"600\" bgcolor=\"#FFFFFF\" style=\"padding-left: 10px; padding-right: 10px; font-family: Verdana; font-size: 12px; color: #646464\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                Mantenha sempre o seu cadastro atualizado, pois caso haja alguma divergência nos dados, isso pode levar ao atraso na entrega da sua encomenda. <br>
                Para esclarecer qualquer dúvida: <b>atendimento@reverbcity.com</b>
            </td>
        </tr>  <!-- Done -->
        <tr>
            <td width=\"600\" height=\"10\"></td>
        </tr> <!-- Done -->";


            $rodape .= '<tr>
            <td>
                <img src="http://reverbcity.com/arquivos/emails/img_compra/3---mail_aguardando-confirmaÃ§Ã£o-de-pagamento_45.png" width="600" height="1" alt="">
            </td>
        </tr> <!-- Done -->
        <tr>
            <td width="600" height="10"></td>
        </tr> <!-- Done -->
        <tr>
            <td width="600"> 
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>                    
                        <tr>
                            <td width="600" style="padding-left: 10px; font-family: Verdana; font-size: 13px; font-style: italic">Abraços</td>
                        </tr>
                        <tr>
                            <td width="600" style="padding-left: 10px; font-family: Verdana; font-size: 13px; font-style: italic">Equipe Reverbcity</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> <!-- Done -->
        <tr>
            <td width="600" height="10"></td>
        </tr> <!-- Done -->
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td align="right">
                               <img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""/>
                           </td>
                           <td>
                            <a href="mailto:atendimento@reverbcity.com" onclick="return rcmail.command(\'compose\', \'atendimento@reverbcity.com\', this)" rel="noreferrer">
                                <img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""/>
                            </a>
                        </td>
                        <td align="left">    
                            <a href="http://www.reverbcity.com" target="_blank" rel="noreferrer">
                                <img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""/>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr> <!-- Done -->
    <tr>
        <td width="600" height="61" bgcolor="#FFFFFF" style="padding-left: 10px;font-size: 11px; color: #9e9e9e">
            <b>www.reverbcity.com</b> <br>
            Para garantir que você sempre receba as nossas mensagens <br>
            adicione o e-mail <u>news@reverbcity.com</u> em sua lista de contatos.
        </td>
    </tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';

            //agora concateno a mensagem toda
            $body .= $topo;
            $body .= $mensagem_topo;
            $body .= $mensagem_meio;
            $body .= $mensagem_baixo;
            $body .= $rodape;

            $fp = fopen("emailconfirmacaocompra.txt", "a");
            $escreve = fwrite($fp, $body);
            fclose($fp);

            //if ($compra->ST_COMPRA_COSO != 'P') {
            if ($formapg == 'boleto') {
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
                $mail->addTo($dados_user->DS_EMAIL_CASO, "Reverbcity - A Música que veste");
                $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                $mail->setReturnPath($emailAdm); #muito importante na locaweb, informar um email vÃ¡lido do seu dominio
                $mail->setSubject("Resumo da compra - Aguardando pagamento");
                $mail->send($mailTransport);
            }

            if ($formapg == 'boleto' or ( $compra->ST_COMPRA_COSO == 'P')) {
                $celddd = $dados_user->DS_DDDCEL_CASO;
                $celular = $dados_user->DS_CELULAR_CASO;
                $idc = $dados_user->NR_SEQ_CADASTRO_CASO;
                $SS_logadm = 32609;

                $texto = "Sua compra foi realizada com sucesso. Em breve vc recebera no seu email mais infos. Consulte seus pedidos aqui http://rvb.la/MinhaCompra";

                // //verifico se tem o celular
                $celddd = str_replace("(", "", $celddd);
                $celddd = str_replace(")", "", $celddd);
                $celddd = str_replace(" ", "", $celddd);

                $celular = str_replace("-", "", $celular);
                $celular = str_replace(".", "", $celular);
                $celular = str_replace("/", "", $celular);
                $celular = str_replace("=", "", $celular);
                $celular = str_replace(" ", "", $celular);

                $celularcomp = $celddd . $celular;

                if (substr($celularcomp, 0, 1) == "0") {

                    $celularcomp = substr($celularcomp, 1, strlen($celularcomp));
                }

                if (strlen($celularcomp) == 10 || strlen($celularcomp) == 11 || strlen($celularcomp) == 12) {

                    $msg = str_replace("&", "e", $texto);

                    $data_sms = array("NR_SEQ_USUARIO_SMRC" => $SS_logadm,
                        "NR_SEQ_CLIENTE_SMRC" => $idc,
                        "DS_CELULAR_SMRC" => $celularcomp,
                        "DS_MSG_SMRC" => $msg,
                        "DT_ENVIO_SMRC" => $hoje);

                    $msgid = $db->insert("sms_envios", $data_sms);

                    $url = "http://193.105.74.59/api/sendsms/plain?user=rbcity&password=rbcity123&sender=Reverbcity&GSM=55$celularcomp&SMStext=" . urlencode($msg);

                    $ch = curl_init();

                    $msg = URLEncode($msg);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                    //curl_setopt($ch, CURLOPT_POST, 1);
                    //curl_setopt($ch, CURLOPT_POSTFIELDS, "UserID=".$UserID."&Token=".$Token."&NroDestino=".$celular."&Mensagem=".$msg."&Remetente=Reverbcity");
                    curl_setopt($ch, CURLOPT_FAILONERROR, 0);

                    $resultbusca = curl_exec($ch);
                    curl_close($ch);

                    $resultbusca = trim($resultbusca);

                    $str = "UPDATE sms_envios SET DS_RETORNO_SMRC = '$resultbusca' where NR_SEQ_SMSENVIO_SMRC = $msgid";
                    //$st = mysql_query($str);
                    $db->query($str);

                    if (trim($resultbusca) > 0) {
                        //if (trim($resultbusca) == "OK"){
                        $strsms = "INSERT INTO sms_controle (NR_SEQ_SMS_CSRC, DS_DESCRICAO_CSRC, NR_QTDE_CSRC, DT_LANCTO_CRSC)
                                VALUES (" . $msgid . ", 'Envio de SMS', -1, sysdate())";
                        //$stsmss = mysql_query($strsms);
                        $db->query($strsms);
                    }
                }
            }

            // Destroi a sessÃ£o do carrinho e de promo no site
            // Zend_Session::namespaceUnset("carrinho");
            Zend_Session::namespaceUnset("promocoes");         
        } else {
            $messages->error = "Você precisa estar logado para chegar a esta página";

            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     */

    public function registravisaAction() {
        //desabilito o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $carrinho = new Zend_Session_Namespace("carrinho");


        session_start();
        /*
          <!--
          '-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
          ' Kit de IntegraÃ§Ã£o Cielo
          ' VersÃ£o: 3.0
          ' Arquivo: registra_transacao.php
          ' FunÃ§Ã£o: Registro de uma transaÃ§Ã£o na Cielo Ecommerce
          '-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
          --> */
        // IMPORTANTE: O SCRIPT A SEGUIR Ã‰ FUNCIONAL APENAS EM PHP 5
        // ########################################################################################################
        ini_set('allow_url_fopen', 1); // Ativa a diretiva 'allow_url_fopen'

        if ($this->_request->isPost()) {

            $bin_cartao = $carrinho->produtos['nr_card'];

            $total_fim = $this->_request->getParam("valor");

            $nr_pedido = $this->_request->getParam("pedido");
            $order = $this->_request->getParam("descricao");
            $bandeira = $this->_request->getParam("bandeira");
            $forma_pagamento = $this->_request->getParam("forma_pagamento");
            $nr_parc_aut = $this->_request->getParam("parcelas");

            function getURL($bin_cartao, $total_fim, $nr_pedido, $order, $bandeira, $forma_pagamento, $nr_parc_aut) {
                // Dados obtidos da loja para a transaÃ§Ã£o
                // - dados do processo
                $identificacao = '1511341';
                $modulo = 'CIELO';
                $operacao = 'Registro';
                $ambiente = 'PRODUCAO';

                // - dados do cartÃ£o
                $bin_cartao = $bin_cartao;

                // - dados do pedido
                $idioma = 'PT';
                $valor = $total_fim;
                $pedido = $nr_pedido;
                $descricao = $order;

                // - dados do pagamento
                $bandeira = $bandeira;
                $forma_pagamento = $forma_pagamento;
                $parcelas = $nr_parc_aut;
                $autorizar = '3';
                $capturar = 'false';

                // - dados adicionais
                $campo_livre = 'Reverbcity';


                // Monta a variÃ¡vel com os dados para postagem
                $request = 'identificacao=' . $identificacao;
                $request .= '&modulo=' . $modulo;
                $request .= '&operacao=' . $operacao;
                $request .= '&ambiente=' . $ambiente;

                $request .= '&bin_cartao=' . $bin_cartao;

                $request .= '&idioma=' . $idioma;
                $request .= '&valor=' . $valor;
                $request .= '&pedido=' . $pedido;
                $request .= '&descricao=' . $descricao;

                $request .= '&bandeira=' . $bandeira;
                $request .= '&forma_pagamento=' . $forma_pagamento;
                $request .= '&parcelas=' . $parcelas;
                $request .= '&autorizar=' . $autorizar;
                $request .= '&capturar=' . $capturar;

                $request .= '&campo_livre=' . $campo_livre;

                // echo $request;die();?
                // Faz a postagem para a Cielo
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://comercio.locaweb.com.br/comercio.comp');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                // var_dump($response);die();
                return $response;
            }

            $XMLtransacao = GetURL($bin_cartao, $total_fim, $nr_pedido, $order, $bandeira, $forma_pagamento, $nr_parc_aut);

            // Carrega o XML
            $objDom = new DomDocument();
            $loadDom = $objDom->loadXML($XMLtransacao);

            $nodeErro = $objDom->getElementsByTagName('erro')->item(0);
            if ($nodeErro != '') {
                $nodeCodigoErro = $nodeErro->getElementsByTagName('codigo')->item(0);
                $retorno_codigo_erro = $nodeCodigoErro->nodeValue;

                $nodeMensagemErro = $nodeErro->getElementsByTagName('mensagem')->item(0);
                $retorno_mensagem_erro = $nodeMensagemErro->nodeValue;
            }

            $nodeTransacao = $objDom->getElementsByTagName('transacao')->item(0);
            if ($nodeTransacao != '') {
                $nodeTID = $nodeTransacao->getElementsByTagName('tid')->item(0);
                $retorno_tid = $nodeTID->nodeValue;

                $nodeDadosPedido = $nodeTransacao->getElementsByTagName('dados-pedido')->item(0);
                if ($nodeDadosPedido != '') {
                    $nodeNumero = $nodeDadosPedido->getElementsByTagName('numero')->item(0);
                    $retorno_pedido = $nodeNumero->nodeValue;

                    $nodeValor = $nodeDadosPedido->getElementsByTagName('valor')->item(0);
                    $retorno_valor = $nodeValor->nodeValue;

                    $nodeMoeda = $nodeDadosPedido->getElementsByTagName('moeda')->item(0);
                    $retorno_moeda = $nodeMoeda->nodeValue;

                    $nodeDataHora = $nodeDadosPedido->getElementsByTagName('data-hora')->item(0);
                    $retorno_data_hora = $nodeDataHora->nodeValue;

                    $nodeDescricao = $nodeDadosPedido->getElementsByTagName('descricao')->item(0);
                    $retorno_descricao = $nodeDescricao->nodeValue;

                    $nodeIdioma = $nodeDadosPedido->getElementsByTagName('idioma')->item(0);
                    $retorno_idioma = $nodeIdioma->nodeValue;
                }

                $nodeFormaPagamento = $nodeTransacao->getElementsByTagName('forma-pagamento')->item(0);
                if ($nodeFormaPagamento != '') {
                    $nodeBandeira = $nodeFormaPagamento->getElementsByTagName('bandeira')->item(0);
                    $retorno_bandeira = $nodeBandeira->nodeValue;

                    $nodeProduto = $nodeFormaPagamento->getElementsByTagName('produto')->item(0);
                    $retorno_produto = $nodeProduto->nodeValue;

                    $nodeParcelas = $nodeFormaPagamento->getElementsByTagName('parcelas')->item(0);
                    $retorno_parcelas = $nodeParcelas->nodeValue;
                }

                $nodeStatus = $nodeTransacao->getElementsByTagName('status')->item(0);
                $retorno_status = $nodeStatus->nodeValue;

                $nodeURLAutenticacao = $nodeTransacao->getElementsByTagName('url-autenticacao')->item(0);
                $retorno_url_autenticacao = $nodeURLAutenticacao->nodeValue;
            }

            // Se nÃ£o ocorreu erro exibe parÃ¢metros
            if ($retorno_codigo_erro == '') {

                $_SESSION['tid'] = $retorno_tid;

                $str = "UPDATE compras SET DS_TID_COSO = '" . $retorno_tid . "',  DS_RETORNO_COSO = '" . $retorno_status . "' WHERE NR_SEQ_COMPRA_COSO = $retorno_pedido";

                // die($str);
                $db = Zend_Registry::get("db");
                $db->query($str);

                //echo '<b> TRANSAÃ‡ÃƒO </b><br />';
                //    echo '<b>CÃ³digo de identificaÃ§Ã£o do pedido (TID): </b>' . $retorno_tid . '<br />';
                //    echo '<b>NÃºmero do pedido (numero): </b>' . $retorno_pedido . '<br />';
                //    echo '<b>Valor do pedido (valor): </b>' . $retorno_valor . '<br />';
                //    echo '<b>Moeda do pedido (moeda): </b>' . $retorno_moeda . '<br />';
                //    echo '<b>Data e hora do pedido (data-hora): </b>' . $retorno_data_hora . '<br />';
                //    echo '<b>DescriÃ§Ã£o do pedido (descricao): </b>' . $retorno_descricao . '<br />';
                //    echo '<b>Idioma do pedido (idioma): </b>' . $retorno_idioma . '<br />';
                //    echo '<b>Bandeira (bandeira): </b>' . $retorno_bandeira . '<br />';
                //    echo '<b>Forma de pagamento (produto): </b>' . $retorno_produto . '<br />';
                //    echo '<b>NÃºmero de parcelas (parcelas): </b>' . $retorno_parcelas . '<br />';
                //    echo '<b>Status do pedido (status): </b>' . $retorno_status . '<br />';
                //    echo '<b>URL para autenticaÃ§Ã£o (url-autenticacao): </b><a href="' . $retorno_url_autenticacao . '">' . $retorno_url_autenticacao . '</a><br />';
                // Destroi a sessÃ£o do carrinho e de promo no site
                Zend_Session::namespaceUnset("carrinho");
                Zend_Session::namespaceUnset("promocoes");
                Zend_Session::namespaceUnset("fretes");

                Header("Location: " . $retorno_url_autenticacao);
                exit();
            } else {
                echo '<b>Erro: </b>' . $retorno_codigo_erro . '<br />';
                echo '<b>Mensagem: </b>' . $retorno_mensagem_erro . '<br />';
            }
        }
    }

    /*
     *
     * Funcao para atualizar o TID
     *
     */

    public function atualizatidAction() {
        // Cria a sessÃ£o das mensagens
        $session = new Zend_Session_Namespace("messages");

        $iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");

        if ($iphone || $android || $palmpre || $ipod || $iPad || $berry == true) {
            // Destroi a sessÃ£o do carrinho e de promo no site
            Zend_Session::namespaceUnset("carrinho");
            Zend_Session::namespaceUnset("promocoes");
            //se nao existir eu redireciono para a pÃ¡gina de cadastro
            $this->_redirect("index/inicio");
        } else {

            // Destroi a sessÃ£o do carrinho e de promo no site
            Zend_Session::namespaceUnset("carrinho");
            Zend_Session::namespaceUnset("promocoes");
        }
    }

    /*
     * AÃ§Ã£o responsÃ¡vel por fazer o calculo de quantidade
     */

    public function aumentarquantidadeAction() {

        //desabilito o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        //recebo os parametros
        $estoque = $this->_request->getParam("idestoque");
        $quantidade = $this->_request->getParam("quantidade");

        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");

        // Zend_Session::namespaceUnset("carrinho");die();
        //atribuo a nova quantidade ao carrinho

        $carrinho->produtos[$estoque]['quantidade'] = $quantidade;

        //redireciono
        $this->_redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * funcÃ£o responsavel por calcular frete de um produto individual
     * */
    public function calculaindividualAction() {
        // Desabilita os layouts
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //crio a sessao de mensagens
        $idproduto = $this->_request->getParam("idproduto");

        // Cria a sessÃ£o de usuÃ¡rio
        $usuarios = new Zend_Session_Namespace("usuarios");


        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");

        $int_cepDestino = $usuarios->cep;

        //verifico se existe usuÃ¡rio logado com sessao
        if ($usuarios->logado == TRUE) {

            // Cria o objeto de conexÃ£o
            $model_produtos = new Default_Model_Produtos();

            $select_produto = $model_produtos->select()
                    ->from('produtos', 'NR_PESOGRAMAS_PRRC')
                    ->where("NR_SEQ_PRODUTO_PRRC = $idproduto");

            $peso_lista = $model_produtos->fetchRow($select_produto);


            //recebo o peso do produto
            $peso_produto = $peso_lista->NR_PESOGRAMAS_PRRC;


            $peso_produto = $peso_produto / 1000;



            if (!$peso_produto || $peso_produto <= 0)
                $peso_produto = "0.375";


            $endereco_wsdl = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx';
            // $nCdServico = '41068';
            $nCdServico = '81019';
            // CÃ³digo para calcular o sedex
            $nCdEmpresa = '13429620';
            $sDsSenha = '08345875';
            $sCepOrigem = '86060510';
            $sCepDestino = $int_cepDestino;
            $nVlPeso = $peso_produto; // Peso em kg
            $nCdFormato = '1'; // Formato, 1-Caixa/pacote, 2-Rolo/prisma, 3-Envelope
            $nVlComprimento = '20'; // Comprimento em cm
            $nVlAltura = '10'; // Altura em cm
            $nVlLargura = '15'; // Largura em cm
            $nVlDiametro = '60'; // Diametro em cm
            $sCdMaoPropria = 'N'; // Servico mÃ£o prÃ³pria
            $nVlValorDeclarado = '0'; // Declarar valor - 0 - desabilitado
            $sCdAvisoRecebimento = 'N'; // Aviso de recebimento
            // O xml a ser enviado - SÃ£o os parametros que os Correios precisam para processar a solicitaÃ§Ã£o
            // Este modelo xml de requisiÃ§Ã£o tem no endereÃ§o do webserivce
            $dados = '
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
			   <soapenv:Header/>
			   <soapenv:Body>
			        <tem:CalcPrecoPrazo>
			              <tem:nCdEmpresa>' . $nCdEmpresa . '</tem:nCdEmpresa>
			              <tem:sDsSenha>' . $sDsSenha . '</tem:sDsSenha>
			              <tem:nCdServico>' . $nCdServico . '</tem:nCdServico>
			              <tem:sCepOrigem>' . $sCepOrigem . '</tem:sCepOrigem>
			              <tem:sCepDestino>' . $sCepDestino . '</tem:sCepDestino>
			              <tem:nVlPeso>' . $nVlPeso . '</tem:nVlPeso>
			              <tem:nCdFormato>' . $nCdFormato . '</tem:nCdFormato>
			              <tem:nVlComprimento>' . $nVlComprimento . '</tem:nVlComprimento>
			              <tem:nVlAltura>' . $nVlAltura . '</tem:nVlAltura>
			              <tem:nVlLargura>' . $nVlLargura . '</tem:nVlLargura>
			              <tem:nVlDiametro>' . $nVlDiametro . '</tem:nVlDiametro>
			              <tem:sCdMaoPropria>' . $sCdMaoPropria . '</tem:sCdMaoPropria>
			              <tem:nVlValorDeclarado>' . $nVlValorDeclarado . '</tem:nVlValorDeclarado>
			              <tem:sCdAvisoRecebimento>' . $sCdAvisoRecebimento . '</tem:sCdAvisoRecebimento>
			        </tem:CalcPrecoPrazo>
			   </soapenv:Body>
			</soapenv:Envelope>
			';

            // Cabecalho
            $cabecalho = array(
                'POST /calculador/CalcPrecoPrazo.asmx HTTP/1.1',
                'Host: ws.correios.com.br',
                'User-Agent: Curl-PHP/',
                'Content-Type: text/xml; charset=utf-8',
                'Content-Length: ' . strlen($dados),
                'Accept-Encoding: GZIP',
                'SOAPAction: "http://tempuri.org/CalcPrecoPrazo"');

            $ch = curl_init(); // Iniciar o Curl
            curl_setopt($ch, CURLOPT_URL, $endereco_wsdl); // O EndereÃ§o que irÃ¡ acessar
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para Retornar o resultado
            curl_setopt($ch, CURLOPT_VERBOSE, false); // Modo Verbose, para exibir o processo na tela
            curl_setopt($ch, CURLOPT_HEADER, false); // Se precisar de retorno dos cabeÃ§alhos
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Tempo mÃ¡ximo em segundos que deve esperar responder
            curl_setopt($ch, CURLOPT_HTTPHEADER, $cabecalho); // Cabecalho para ser enviado
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Seguir redirecionamentos
            curl_setopt($ch, CURLOPT_POST, true); // UsarÃ¡ metodo post
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados); // Dados para serem processados
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Caso precise verificar certificado
            curl_setopt($ch, CURLOPT_ENCODING, 'GZIP'); // Usar compressao
            // Executa a requisiÃ§Ã£o
            $resposta = curl_exec($ch);

            // Se der erro, mostra na tela e encerra
            if (curl_errno($ch)) {
                echo "Error: ", curl_error($ch);
                exit();
            }

            $resp = $this->Xml2array($resposta, false);

            //pego o retorno do servico e acesso o indice com as informacoes
            $retorno = $resp['cResultado']['Servicos']['cServico'];
//            $retorno = $resp['soap:Envelope']['soap:Body']['CalcPrecoPrazoResponse']['CalcPrecoPrazoResult']['Servicos']['cServico'];
            //transformo o retorno de string para double
            $valor_correio = str_replace(",", ".", $retorno['Valor']);
            $valor_correio = floatval($valor_correio);


            //calculo a porcentagem
            $valor_porcentagem = $valor_correio * 0.1;
            //crio o valor total do frete
            $valor_total_frete = $valor_correio + $valor_porcentagem;





            //agora verifico se esta ativo a promo
            if ($configuracoes->ST_FRETEGRATIS_GESA == 'A') {

                //agora verifico se a compra atingiu o valor
                if ($configuracoes->VL_FRETEGRATIS_GESA <= $valor_total) {
                    //atribuo o valor do frete como gratis cep valido e valor para frete zerado
                    $valor_total_frete = 0;

                    $valor_para_frete_gratis = 0;
                } else {
                    //senao falo a quantidade que falta gastar para o frete gratis
                    $valor_para_frete_gratis = $configuracoes->VL_FRETEGRATIS_GESA - $valor_total;
                }
            }
            //inicio a sessao do frete

            $sessao_frete->valor = $valor_total_frete;
            $sessao_frete->cep = $int_cepDestino;
            $sessao_frete->valor_para_frete_gratis = $valor_para_frete_gratis;

            // Verifica se a resposta serÃ¡ um JSON

            $retorno['Valor'] = $valor_total_frete;



            $retorno['valor_frete_gratis'] = $valor_para_frete_gratis;


            $this->_helper->json($retorno);


            // ###################################### DEBUG
            // echo '<fieldset>
            //         <h1>Resposta:</h1>
            //         <pre>',
            //              print_r( $resp, true ),
            //         '</pre>
            //      </fieldset>';
            // exit();
            // ###################################### DEBUG
        } else {
            //retorno mensagem de sucesso para o usuÃ¡rio
            $messages->error = "Você precisa estar logado para calcular o frete.";
            //redireciono
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function correiosAction() {

        //desabilito o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        //inicio o model de frete
        $model_frete = new Default_Model_Fretes();
        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //crio a sessao de usuÃ¡rios
        $usuarios = new Zend_Session_Namespace("usuarios");
        // Cria a sessÃ£o das mensagens
        $messages = new Zend_Session_Namespace("messages");
        //inicia a sessao do frete
        $sessao_frete = new Zend_Session_Namespace("fretes");
        //crio a sessao de mensagens de promo
        $sessao_promo = new Zend_Session_Namespace("promocoes");


        // $sessao_frete->frete_gratis = 0;
        //recupero os parametros
        if ($this->_request->isPost()) {
            //tipo do cadastro
            $tipo_cadastro = $usuarios->tipo;
            //idusuario
            $idusuario = $usuarios->codigo;
            //recebo o cep
            $int_cepDestino = $this->_request->getParam("cep");
            //pego a cidade do usuÃ¡rio
            $cidade = $usuarios->cidade;
            //recebo a forma de envio (1 = PAC, 2 = SEDEX, 3 = E-SEDEX, 4 = TAM) padrÃ£o pac
            $forma_envio = $this->_request->getParam("forma_envio", 1);
            //inicio as variaveis para verificar quantidade de cada produto
            //caneca
            $tem_caneca = 0;
            //bones
            $num_bone = 0;
            //camisetas
            $num_camisetas = 0;
            //calcas
            $num_calcas = 0;
            //tem produto em promo falso (0)
            $tem_promo = 0;
            //inicio a variavel como falsa de vale presente
            $tem_vale_presente = 0;
            //total de produtos
            $total_produtos = 0;
            //vejo se tem frete gratis no produto
            $produto_ft_gratis = 'N';
            //digo se ha brindes como negativo
            $tem_brinde = 0;
            //zero a variavel tem frete gratis ela Ã© usada para quando tem mais de um produto no carrinho e deixar o frete gratis
            $tem_frete_gratis = 0;
            //somente camisetas
            $so_camiseta = true;
            //tem produto cheio
            $tem_cheio = 0;
            $tem_diferente_poster = 0;

            $tem_camiseta_cheia = 0;




            // Cria o objeto de conexÃ£o
            $db = Zend_Registry::get("db");
            //inicio o model de produto
            $model_produtos = new Default_Model_Produtos();

            //inicio o model de promocoes
            $model_promo = new Default_Model_Promocoes();
            //assino os valores na variavel
            $promocoes = $model_promo->fetchRow();

            //inicio o model de configuracoes gerais para pegar o valor do frete gratis
            $model_configuracoes = new Default_Model_Configuracoes();
            //inicio a query
            $select_configuracoes = $model_configuracoes->select()
                //seto integridade como falsa
                ->setIntegrityCheck(FALSE)
                //da tabela de configuracoes, pego o status e o valor
                ->from("config_gerais", array("ST_FRETEGRATIS_GESA",
                    "VL_FRETEGRATIS_GESA"));
            //atribuo para a variavel de configuracoes
            $configuracoes = $model_configuracoes->fetchRow($select_configuracoes);

            $total_itens = count($carrinho->produtos);
            //percorro o carrinho
            foreach ($carrinho->produtos as $key => $produto) {
                // Cria o objeto de conexÃ£o
                $model_produtos = new Default_Model_Produtos();

                $select_produto = $model_produtos->select()
                        ->from('produtos', array('NR_PESOGRAMAS_PRRC', 'NR_SEQ_TIPO_PRRC', 'NR_SEQ_CATEGORIA_PRRC'))
                        ->where("NR_SEQ_PRODUTO_PRRC = ?", $produto['codigo']);

                $peso_lista = $model_produtos->fetchRow($select_produto);
                //se for tipo 9 Ã© vale presente o peso fica 0
                if ($produto['tipo'] == 9) {
                    $peso_unitario = 0;
                } else {
                    //recebo o peso do produto
                    $peso_unitario = $peso_lista->NR_PESOGRAMAS_PRRC;
                }

                if ($peso_lista['NR_SEQ_CATEGORIA_PRRC'] != 173) {
                    $tem_diferente_poster = 1;
                }


                //vejo se tem mais de um produto de cada produto
                if ($produto['quantidade'] > 1) {
                    //se tiver mais de um mesmo produto multiplico seu peso por sua quantidade
                    $peso_unitario = $peso_unitario * $produto['quantidade'];
                }

                //verifico quantos bones tem
                if ($produto['tipo'] == 142) {
                    $num_bone = $num_bone + $produto["quantidade"];
                }

                //verifico se tem so camiseta
                if ($produto['tipo'] <> 6) {
                    $so_camiseta = false;
                }

//                if ($produto['tipo'] == 52) {
//                    $tem_caneca = 1;
//                }

                $quantidade_total = $quantidade_total + $produto['quantidade'];

                //agora somo o peso do carrinho
                $peso_produto = $peso_produto + $peso_unitario;

                //aqui verifico se e promo ou nÃ£o
                if ($produto['vl_promo'] != 0) {
                    //jogo o valor da promo no valor do produto
                    $valor = $produto['vl_promo'];

                    //recebo a quantidade
                    $quantidade = $produto['quantidade'];

                    //multiplico pela quantidade do produto
                    $valor = $valor * $quantidade;

                    $produto['total_produto'] = $valor;

                    //digo que tem promo
                    $tem_promo = 1;
                } elseif ($produto['valor_total_desconto'] > 0) {
                    //jogo o valor da promo no valor do produto
                    $valor = $produto['valor_total_desconto'];
                    $produto['total_produto'] = $produto['valor_total_desconto'];

                    //recebo a quantidade
                    $quantidade = $produto['quantidade'];

                    //digo que tem promo
                    $tem_promo = 1;

                    if (($produto['valor_total_desconto'] / $quantidade) >= 59) {
                        $tem_cheio = 1;
                        $tem_camiseta_cheia = 1;
                    }
                } else {
                    //jogo o valor do produto na variavel
                    $valor = $produto['valor'];
                    //recebo a quantidade
                    $quantidade = $produto['quantidade'];
                    //multiplico pela quantidade do produto
                    $valor = $valor * $quantidade;

                    $tem_cheio = 1;

//                    if ($valor >= 59) {
                    if ($valor) {

                        $tem_camiseta_cheia = 1;
                    }
                }


                /*                 * ************-
                 * **************-
                 * ****PROMOS****-
                 * **************-
                 * ************** */

                //-----------//
                //aniversario//
                //----------//
                //verifico se Ã© promo de niver
                if ($sessao_promo->niver > 0) {

//                    $valor = $produto[$key]['vl_promo'] = 0;
//                    $valor = $produto[$key]['valor'] = 0;
                    $tem_brinde = 1;
                }

                //----------------//
                //Primeira Compra//
                //---------------//
                //verifico se Ã© primeira compra
                if ($sessao_promo->primeira > 0) {

                    //defino os valores como 0
//                    $valor = $produto[$key]['vl_promo'] = 0;
//                    $valor = $produto[$key]['valor'] = 0;
                    $tem_brinde = 1;
                }

                //-----------------------------------------------------------------------------//
                //    Promo ganhe sale para quem sÃ³ fez 1 compra ou esta 3 meses sem compra    //
                //-----------------------------------------------------------------------------//
                //verifico se Ã© primeira compra
                if ($sessao_promo->sale2 > 0) {

                    //defino os valores como 0
//                        $valor = $produto[$key]['vl_promo'] = 0;
//                        $valor = $produto[$key]['valor'] = 0;
                    $tem_brinde = 1;
                }

                //----------------//
                //Primeira Compra//
                //---------------//
                //verifico se Ã© primeira compra
//				if($sessao_promo->sale > 0){
//			 
//				//defino os valores como 0
//
//					$valor = $produto[$key]['vl_promo'] = 0;
//					$valor = $produto[$key]['valor'] = 0;
//					$tem_brinde = 1;
//													
//				}


                /*                 * ************-
                 * **************-
                 * **FIM PROMOS***-
                 * **************-
                 * ************** */

                //agora somo o valor total das compras
                $valor_total += $produto['total_produto'];

                //marco como vale presente existente
                if ($peso_lista->NR_SEQ_TIPO_PRRC == 9) {
                    //ativo a variavel como 1
                    $tem_vale_presente = 1;
                } else {
                    $tem_vale_presente = 0;
                }

                $total_produtos = $total_produtos + $produto['quantidade'];

                //agora jogo a variavel do carrinho de frete gratis
                $produto_ft_gratis = $produto['frete_gratis'];

                if ($produto_ft_gratis == "S") {
                    $tem_frete_gratis = 1;
                }
            }

            // verifico se tem mais de 2 produtose se tiver frete gratis eu mantenho
            if (count($carrinho->produtos) > 1 AND $tem_frete_gratis == 1) {
                $produto_ft_gratis = 'S';
            }

            //agora transformo o peso em centesimos para o calculo
            $peso_produto = $peso_produto / 1000;


            //se nÃ£o tiver peso do produto ele atribui o valor minimo
            if (!$peso_produto || $peso_produto <= 0)
                $peso_produto = "0.375";


            $endereco_wsdl = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx';

            //inicio o model de cidades da tam
            $model_cidades = new Default_Model_Cidadestam();

            switch ($forma_envio) {
                //se for PAC
                case '1':
                    $nCdServico = '41068';
//					$sessao_frete->forma_envio = "PAC";
                    break;
                // forma de envio SEDEX
                case '2':
                    $nCdServico = '40096';
//					$sessao_frete->forma_envio = "SEDEX";
                    break;
                //E-SEDEX
                case '3':
                    $nCdServico = '81019';
//					$sessao_frete->forma_envio = "E-SEDEX";
                    break;
                case '5':

                    break;
                case '4';
                    // o valor da tam
                    $valor_tam = 29.90;
                    //inicio a query para trazer a resposta para ver se a cidade existe
                    $select_tam = $model_cidades->select()
                            ->where($int_cepDestino . " BETWEEN CEP_INICIO AND CEP_FIM");

                    //assino a variavel
                    $cidade_tam = $model_cidades->fetchRow($select_tam);

                    if ($tem_caneca > 0 or $so_camiseta == false) {
                        $retorno['Erro'] = '008';
                    }


                    if ($cidade_tam->CIDADE == null) {

                        $retorno['Erro'] = '008';
                    } else {

                        $valor_tam_1 = ($valor_total * 0.00666) + $valor_tam;
                    }
//					$sessao_frete->forma_envio = "TAM";
                    break;
            }

            if ($forma_envio != 4 && $forma_envio != 5) {
                // CÃ³digo para calcular o sedex
                $nCdEmpresa = '13429620';
                $sDsSenha = '08345875';
                $sCepOrigem = '86060510';
                $sCepDestino = $int_cepDestino;
                $nVlPeso = $peso_produto; // Peso em kg
                $nCdFormato = '1'; // Formato, 1-Caixa/pacote, 2-Rolo/prisma, 3-Envelope
                $nVlComprimento = '20'; // Comprimento em cm
                $nVlAltura = '10'; // Altura em cm
                $nVlLargura = '15'; // Largura em cm
                $nVlDiametro = '60'; // Diametro em cm
                $sCdMaoPropria = 'N'; // Servico mÃ£o prÃ³pria
                $nVlValorDeclarado = '0'; // Declarar valor - 0 - desabilitado
                $sCdAvisoRecebimento = 'N'; // Aviso de recebimento
                // O xml a ser enviado - SÃ£o os parametros que os Correios precisam para processar a solicitaÃ§Ã£o
                // Este modelo xml de requisiÃ§Ã£o tem no endereÃ§o do webserivce
                $dados = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
                   <soapenv:Header/>
                   <soapenv:Body>
                        <tem:CalcPrecoPrazo>
                              <tem:nCdEmpresa>' . $nCdEmpresa . '</tem:nCdEmpresa>
                              <tem:sDsSenha>' . $sDsSenha . '</tem:sDsSenha>
                              <tem:nCdServico>' . $nCdServico . '</tem:nCdServico>
                              <tem:sCepOrigem>' . $sCepOrigem . '</tem:sCepOrigem>
                              <tem:sCepDestino>' . $sCepDestino . '</tem:sCepDestino>
                              <tem:nVlPeso>' . $nVlPeso . '</tem:nVlPeso>
                              <tem:nCdFormato>' . $nCdFormato . '</tem:nCdFormato>
                              <tem:nVlComprimento>' . $nVlComprimento . '</tem:nVlComprimento>
                              <tem:nVlAltura>' . $nVlAltura . '</tem:nVlAltura>
                              <tem:nVlLargura>' . $nVlLargura . '</tem:nVlLargura>
                              <tem:nVlDiametro>' . $nVlDiametro . '</tem:nVlDiametro>
                              <tem:sCdMaoPropria>' . $sCdMaoPropria . '</tem:sCdMaoPropria>
                              <tem:nVlValorDeclarado>' . $nVlValorDeclarado . '</tem:nVlValorDeclarado>
                              <tem:sCdAvisoRecebimento>' . $sCdAvisoRecebimento . '</tem:sCdAvisoRecebimento>
                        </tem:CalcPrecoPrazo>
                   </soapenv:Body>
                </soapenv:Envelope>
                ';

                $idCache = "calculofrete_" . $int_cepDestino . "_" . str_replace('.', '', $peso_produto) . "_" . $forma_envio;
                $resp = Zend_Registry::get("cache")->load($idCache);
                $resp = false;
                if (!$resp && $forma_envio != 4) {
                    // Cabecalho
                    $cabecalho = array(
                        'POST /calculador/CalcPrecoPrazo.asmx HTTP/1.1',
                        'Host: ws.correios.com.br',
                        'Content-Type: text/xml; charset=utf-8',
                        'Content-Length: ' . strlen($dados),
                        'SOAPAction: "http://tempuri.org/CalcPrecoPrazo"');

                    ob_start();
                    $ch = curl_init(); // Iniciar o Curl
                    curl_setopt($ch, CURLOPT_URL, $endereco_wsdl); // O EndereÃ§o que irÃ¡ acessar
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para Retornar o resultado
                    curl_setopt($ch, CURLOPT_VERBOSE, false); // Modo Verbose, para exibir o processo na tela
                    curl_setopt($ch, CURLOPT_HEADER, false); // Se precisar de retorno dos cabeÃ§alhos
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Tempo mÃ¡ximo em segundos que deve esperar responder
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $cabecalho); // Cabecalho para ser enviado
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Seguir redirecionamentos
                    curl_setopt($ch, CURLOPT_POST, true); // UsarÃ¡ metodo post
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dados); // Dados para serem processados
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Caso precise verificar certificado
                    curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); // Usar compressao
                    // Executa a requisiÃ§Ã£o
                    $resposta = curl_exec($ch);
                    curl_close($ch);
                    ob_end_clean();
                    // Se der erro, mostra na tela e encerra
                    if (curl_errno($ch)) {
                        echo "Error: ", curl_error($ch);
                        exit();
                    }

                    $resp = $this->Xml2array($resposta, false);

                    Zend_Registry::get("cache")->save($resp, $idCache);
                }

                //            if($forma_envio == 3){
                //                Zend_Debug::dump($resp); exit;
                //            }
                //pego o retorno do servico e acesso o indice com as informacoes

                $retorno = $resp['soap:Envelope']['soap:Body']['CalcPrecoPrazoResponse']['CalcPrecoPrazoResult']['Servicos']['cServico'];
                $retorno['forma'] = $forma_envio;
                //transformo o retorno de string para double
                $valor_correio = str_replace(",", ".", $retorno['Valor']);
                $valor_correio = floatval($valor_correio);
            }
            $retorno['forma'] = $forma_envio;

            if ($forma_envio == 4) {

                $porcentagem_tam = $valor_tam_1 * 0.15;

                $valor_total_frete = $porcentagem_tam + $valor_tam_1;
                //agora somo os valores
                $retorno['Valor'] = $valor_total_frete;

                if ($retorno['Valor'] == 0) {
                    $retorno['Erro'] = '008';
                    $retorno['PrazoEntrega'] = 3;
                    $retorno["lugar"] = 2;
                } else {
                    $retorno['Erro'] = 'Não houve erro!';
                    $retorno['PrazoEntrega'] = 3;
                    $retorno["lugar"] = 3;
                }
            } else {

                //insiro os 15%
                //calculo a porcentagem
                $valor_porcentagem = $valor_correio * 0.15;
                //crio o valor total do frete
                $valor_total_frete = $valor_correio + $valor_porcentagem;
            }

            //agora verifico se esta ativo a promo e nÃ£o for PJ
            if ($configuracoes->ST_FRETEGRATIS_GESA == 'A' and $usuarios->tipo <> 'PJ') {
                //assino a variavel o valor geral das configuracoes gerais de frete gratis
                $valor_para_frete_gratis = $configuracoes->VL_FRETEGRATIS_GESA;
                //agora verifico se a compra atingiu o valor
                if ($configuracoes->VL_FRETEGRATIS_GESA <= $valor_total and $tem_brinde == 0) {
                    //agora vejo se tem um produto de preÃ§o cheio
                    // Habilitar o if de volta depois da black friday
                    //if ($tem_cheio == 1) {
                        //atribuo o valor do frete como gratis cep valido e valor para frete zerado

                        $valor_total_frete = 0;

                        $valor_para_frete_gratis = 0;

                        $sessao_frete->frete_gratis = 1;
                        $retorno["lugar"] = 4;
                    //}
                } else {
                    //senao falo a quantidade que falta gastar para o frete gratis
                    $valor_para_frete_gratis = $configuracoes->VL_FRETEGRATIS_GESA - $valor_total;

                    $sessao_frete->frete_gratis = 0;
                    $retorno["lugar"] = 5;
                }
            }

            // Se for primeira compra e for mais que 260 ganha frete grÃ¡tis
            if (($sessao_promo->primeira == 1 or $sessao_promo->niver == 1) and $tem_brinde == 1 and $valor_total > $configuracoes->VL_FRETEGRATIS_GESA) {
                //if ($tem_cheio == 1) {
                    //atribuo o valor do frete como gratis cep valido e valor para frete zerado

                    $valor_total_frete = 0;

                    $valor_para_frete_gratis = 0;

                    $sessao_frete->frete_gratis = 1;
                    $retorno["lugar"] = 4;
                //}
            }

            if ($sessao_promo->niver == 1 and $tem_brinde == 1 and $valor_total > $configuracoes->VL_FRETEGRATIS_GESA) {
                //atribuo o valor do frete como gratis cep valido e valor para frete zerado

                $valor_total_frete = 0;

                $valor_para_frete_gratis = 0;

                $sessao_frete->frete_gratis = 1;
                $retorno["lugar"] = 4;
            }

            //verifico se tem apenas um produto com frete gratis se tiver entra na condiÃ§Ã£o
            //if ($produto_ft_gratis == 'S' and $total_itens == 1) {
            if ($produto_ft_gratis == 'S') {
                //atribuo o valor do frete como gratis cep valido e valor para frete zerado
                $valor_total_frete = 0;

                $valor_para_frete_gratis = 0;

                $sessao_frete->frete_gratis = 1;

                $retorno["lugar"] = 6;
            }

//			}

            /*             * ************ */
            /*             * * PROMO **** */
            /*             * *********** */



            $int_cepDestino = str_replace("-", "", $int_cepDestino);
            $int_cepDestino = trim(str_replace(" ", "", $int_cepDestino));

            function busca_cep($int_cepDestino, $forma_envio) {
                $idCache = "busca_cep_correios_" . $int_cepDestino;
                $resultado = Zend_Registry::get("cache")->load($idCache);

                if (!$resultado) {
                    //$resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep=' . urlencode($int_cepDestino) . '&formato=json');
                    $resultado = @file_get_contents('http://viacep.com.br/ws/' . urlencode($int_cepDestino) . '/json/');
                    Zend_Registry::get("cache")->save($resultado, $idCache);
                }

                if (!$resultado) {
                    $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
                }
                //parse_str($resultado, $retorno);
                $retorno = json_decode($resultado, true);

                return $retorno;
            }
            $resultado_busca = busca_cep($int_cepDestino, $forma_envio);

            if (!empty($resultado_busca)) {
                $resultado_busca['resultado'] = 1;
            }

            // verifico se ja ganhou um brinde
            if ($sessao_promo->brinde == 0 || $sessao_promo->sale == 0 || $sessao_promo->primeira == 0 || $sessao_promo->niver == 0) {


                //verifico se a promo de frete gratis londrina esta ativae o tipo de cadastro nao for pj
                if ($promocoes["st_frete_londrina"] == 1 and $usuarios->tipo <> 'PJ') {

                    //agora faço a condição de frete grátis para usuários de londrina and $tem_promo == 0
                    $strPR = strtoupper($resultado_busca['uf']);
                    $strLondrina = strtoupper($resultado_busca['localidade']);

                    if (($strPR == "PR" AND $strLondrina == "LONDRINA") and $valor_total >= $promocoes["vl_frete_londrina"]) {

                        //verifico s tem preco cheio
                        //if ($tem_camiseta_cheia == 1) {

                            //agora verifico se tem brinde
                           // if ($tem_brinde == 0) {

                                $valor_total_frete = 0;

                                $valor_para_frete_gratis = 0;

                                $sessao_frete->frete_gratis = 1;

                                $retorno['PrazoEntrega'] = -1;
                           // }
                        //}
                    }
                }

//                //agora faÃ§o a condiÃ§Ã£o de frete grÃ¡tis para usuÃ¡rios de londrina and $tem_promo == 0
//                if ($resultado_busca['uf'] == "SP" and $valor_total >= 59) {
//
//                    //verifico s tem preco cheio
//                    if ($tem_camiseta_cheia == 1) {
//
//                        //agora verifico se tem brinde
//                        if ($tem_brinde == 0) {
//                            //atribuo o valor do frete como gratis cep valido e valor para frete zerado
//                            $valor_total_frete = 0;
//
//                            $valor_para_frete_gratis = 0;
//
//                            $sessao_frete->frete_gratis = 1;
//
//                            $retorno["lugar"] = 8.1;
//                        }
//		}                
//		}
            }

            /**
             * Promo frete grátis 13/03
             */
//            if ($sessao_promo->sale == 0 || $sessao_promo->niver == 0) {
//                if ($tem_camiseta_cheia == 1) {
//                        $valor_total_frete = 0;
//
//                        $valor_para_frete_gratis = 0;
//
//                        $retorno['PrazoEntrega'] = 0;
//
//                        $sessao_frete->frete_gratis = 1;
//
//                        $retorno["lugar"] = 8;
//                }
//            }

            /*             * ************ */
            /*             * FIM PROMO*** */
            /*             * *********** */

            /**
             * Frete grátis para atacadista acima de 100 produtos
             */
            if ($total_produtos >= 60 and $usuarios->tipo == 'PJ') {

                $valor_total_frete = 0;

                $valor_para_frete_gratis = 0;

                $retorno['PrazoEntrega'] = 0;

                $sessao_frete->frete_gratis = 1;

                $retorno["lugar"] = 8;
                $retorno["Erro"] = '0';
                $retorno["MsgErro"] = '';
            }

            //agora dou frete gratis se tiver apenas vale presente
            if ($tem_vale_presente == 1) {
                //se tiver nÃ£o tem frete nem prazo de entrega
                $valor_total_frete = 0;
                $valor_para_frete_gratis = 0;
                $retorno['PrazoEntrega'] = -1;

                $retorno["lugar"] = 9;
            }


            if ($int_cepDestino == 86060510) {

                $valor_total_frete = 0;

                $valor_para_frete_gratis = 0;

                $sessao_frete->frete_gratis = 1;

                $retorno['PrazoEntrega'] = -1;
            }

            if ($resultado_busca['resultado'] == 0) {
                $valor_total_frete = 0;
                $valor_para_frete_gratis = 0;

                $retorno['Erro'] = 'Cep invalido';
                $retorno['PrazoEntrega'] = 0;
                $retorno["lugar"] = 2;
            }

            //inicio a sessao do frete

            $sessao_frete->valor = $valor_total_frete;
            $sessao_frete->cep = $int_cepDestino;
            $sessao_frete->valor_para_frete_gratis = $valor_para_frete_gratis;

            // Verifica se a resposta serÃ¡ um JSON
            if ($this->_request->getParam('json')) {

                if ($forma_envio == 5 && $tem_diferente_poster == 0) {
                    if ($quantidade == 1) {
                        $retorno['Valor'] = (7.35 * 0.15) + 7.35;
                        $sessao_frete->valor = $retorno['Valor'];
                        $retorno['PrazoEntrega'] = 7;
                        $retorno['Erro'] = 0;
                    } elseif ($quantidade == 2) {
                        $retorno['Valor'] = (7.90 * 0.15) + 7.90;
                        $sessao_frete->valor = $retorno['Valor'];
                        $retorno['PrazoEntrega'] = 7;
                        $retorno['Erro'] = 0;
                    } elseif ($quantidade == 3) {
                        $retorno['Valor'] = (8.45 * 0.15) + 8.45;
                        $sessao_frete->valor = $retorno['Valor'];
                        $retorno['PrazoEntrega'] = 7;
                        $retorno['Erro'] = 0;
                    } else {
                        $retorno['Valor'] = 0;
                        $sessao_frete->valor = $retorno['Valor'];
                        $retorno['PrazoEntrega'] = 0;
                        $retorno['Erro'] = 00023;
                    }
                } elseif ($forma_envio == 4) {
                    //insiro os 10%
                    $valor_total_frete = $valor_tam_1 * 0.1;
                    //agora somo os valores
                    $retorno['Valor'] = $valor_total_frete + $valor_tam_1;

                    if ($retorno['Valor'] == 0) {
                        $retorno['Erro'] = '008';
                        $retorno['PrazoEntrega'] = 3;
                        $retorno["lugar"] = 10;
                    } else {
                        if ($tem_caneca > 0 or $so_camiseta == false) {
                            $retorno['Erro'] = '008';
                            $retorno['PrazoEntrega'] = 3;
                            $retorno["lugar"] = 10.1;
                        } else {
                            $retorno['Erro'] = 'Não houve erro!';
                            $retorno['PrazoEntrega'] = 3;
                            $retorno["lugar"] = 11;
                        }
                    }

                    if ($quantidade_total > 6) {
                        $retorno['Erro'] = 'Excedeu a quantidade. Máximo 6 itens.';
                        $retorno['PrazoEntrega'] = 0;
                        $retorno["lugar"] = 0;
                    }
                } else {
                    $retorno['Valor'] = $valor_total_frete;
                    //agora coloco o parametro se ele for PJ
                    if ($usuarios->tipo == 'PJ') {
                        //1 = atacadista
//						$retorno['Atacadista'] = 1;
                        $retorno['Atacadista'] = 0;
                    } else {
                        //0 = comun
                        $retorno['Atacadista'] = 0;
                    }
                }



                $retorno['valor_frete_gratis'] = $valor_para_frete_gratis;



                $this->_helper->json($retorno);
            }
        }


        // ###################################### DEBUG
        // echo '<fieldset>
        //         <h1>Resposta:</h1>
        //         <pre>',
        //              print_r( $resp, true ),
        //         '</pre>
        //      </fieldset>';
        // exit();
        // ###################################### DEBUG
    }

    /*
     *
     * FunÃ§Ã£o responsavel por reabrir a compra
     *
     */

    public function atualizacompraAction() {
        //desabilito o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");

        //crio a sessao de usuarios
        $usuarios = new Zend_Session_Namespace("usuarios");

        //recebo o codigo da compra
        $idcompra = $this->_request->getParam("idcompra");

        //inicio o model de compra
        $model_compras = new Default_Model_Compras();

        //inicio a query para ver se Ã© a compra correta e se Ã© o usuÃ¡rio dono da compra
        $select_compra = $model_compras->select()
                ->where("NR_SEQ_COMPRA_COSO = ?", $idcompra)
                ->where("NR_SEQ_CADASTRO_COSO = ?", $usuarios->idperfil)
                ->where("ST_COMPRA_COSO = 'A'");


        //agora crio o objeto da compra
        $compra = $model_compras->fetchRow($select_compra);

        //agora verifico se existe a compra
        if ($compra->NR_SEQ_COMPRA_COSO) {
            //pego a data de hoje
            $hoje = date("Y-m-d H:i:s");
            //verifico se e um post
            if ($this->_request->isPost()) {


                //pego a nova forma de pagamento escolhida
                $forma_pagamento = $this->_request->getParam("formapagto");

                //boleto
                if ($forma_pagamento == "boleto") {
                    //rpara boleto Ã© apenas 1 parcela
                    $numero_parcelas = 1;
                }
                //visa
                if ($forma_pagamento == "visa") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelas_visa");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("visa");
                }
                //mastercard
                if ($forma_pagamento == "mastercard") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelas_mastercard");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("mastercard");
                }
                //american express
                if ($forma_pagamento == "amex") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelas_americanexpress");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("americanexpress");
                }
                //dinners
                if ($forma_pagamento == "diners") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelas_diners");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("diners");
                }

                $data_compra = array("DS_FORMAPGTO_COSO" => $forma_pagamento,
                    "NR_PARCELAS_COSO" => $numero_parcelas);

                try {

                    $model_compras->update($data_compra, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));

                    //redireciono para a pÃ¡gina do pedido
                    $this->_redirect("/checkout/finalizarreabertura/idcompra/$idcompra");
                } catch (Exception $e) {

                    $messages->error = "Você não pode acessar esta página direto";
                    //redireciono
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $messages->error = "Você não pode acessar esta página direto";
                //redireciono
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $messages->error = "Você não tem acesso a esta compra!";
            //redireciono
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /*
     *
     * FunÃ§Ã£o responsÃ¡vel por ligar os dados da reabertura de compra e mandar para pagamento
     *
     */

    public function finalizarreaberturaAction() {


        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");

        //crio a sessao de usuarios
        $usuarios = new Zend_Session_Namespace("usuarios");
        //recupero o pedido feito
        $idpedido = $this->_request->getParam("idcompra");
        //inicio o modulo de compra
        $model_compras = new Default_Model_Compras();
        //inicio a query de compra
        $select_compra = $model_compras->select()->where("NR_SEQ_COMPRA_COSO = ?", $idpedido);

        //crio a variavel da compra
        $compra = $model_compras->fetchRow($select_compra);
        //assino ao view
        $this->view->compra = $compra;

        $total_fim = $compra->VL_TOTAL_COSO;

        $total_fim = number_format($total_fim, 2, "", ".");

        $total_fim = explode(".", $total_fim);

        $total_fim = $total_fim[0] . "" . $total_fim[1];

        //assino ao view o valor total da compra
        $this->view->total = $total_fim;

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
                    "DS_INFORMACOES_PRRC"))
                ->where("NR_SEQ_COMPRA_CESO = ?", $idpedido);
        //crio a lista
        $lista_produtos = $model_cesta->fetchAll($select_cesta)->toArray();
        //assino ao view
        $this->view->carrinho = $lista_produtos;

        //inicio o adaotador
        $db = Zend_Registry::get("db");

        //agora trago as informaÃ§Ãµes do usuÃ¡rio logado
        $select_comprador = "SELECT
									DS_LOGIN_CASO,
									DS_NOME_CASO,
									DS_ENDERECO_CASO,
									DS_NUMERO_CASO,
									DS_COMPLEMENTO_CASO,
									DS_BAIRRO_CASO,
									DS_CIDADE_CASO,
									DS_UF_CASO,
									DS_CEP_CASO,
									DS_EMAIL_CASO,
									DT_NASCIMENTO_CASO,
									DS_CPFCNPJ_CASO
								FROM
									cadastros
								WHERE
									NR_SEQ_CADASTRO_CASO = " . $usuarios->idperfil;

        //armazeno os dados do usuario em uma variavel
        $query_usuario = $db->query($select_comprador);



        //crio uma lista de categorias
        $usuario = $query_usuario->fetchAll();
        //crio a variavel com o pedido
        $pedido_visa .= "Prod.: $ds_prod - Vlr.: " . number_format($vl_prod, 2, ",", "") . " - Qtde: " . $qtde . " - Tot.: $vl_total\n";
        //atribuo o valor da ordem para vazio;
        $order = "";
        //agora armazeno as variaveis do usuario
        $nome = $usuario[0]['DS_NOME_CASO'];
        $cidade = $usuario[0]['DS_CIDADE_CASO'];
        $estado = $usuario[0]['DS_UF_CASO'];
        $cep = $usuario[0]['DS_CEP_CASO'];
        $endereco = $usuario[0]['DS_ENDERECO_CASO'];
        $numero = $usuario[0]['DS_NUMERO_CASO'];
        $documento = $usuario[0]['DS_CPFCNPJ_CASO'];
        $bairro = $usuario[0]['DS_BAIRRO_CASO'];

        //agora concateno
        $order = "Dados: " . $nome . ", Docto: " . $documento . ", " . $endereco . " - " . $bairro . " - " . $cep . ", " . $cidade . "/" . $estado;
        $order = $order . " - Pedido: " . $pedido_visa;
        $order = str_replace("\n", "", $order);

        $numero_parcelas = $compra->NR_PARCELAS_COSO;

        $pagamento = $compra->DS_FORMAPGTO_COSO;
        // se o pagamento for boleto defino todas as variaveis como boleto
        if ($pagamento == "boleto") {
            $formapg = "boleto";
            $bandeira = "boleto";
            //se for visa defino a forma de pagamento como 1 (para a vista 2 para parcelas) isso se houver mais de 1 parcela
        } else if ($pagamento == "visa") {
            if ($numero_parcelas > 1) {
                $formapg = "visa";
                $bandeira = "visa";
                $forma_pagamento = "2";
            } else {
                $formapg = "visa";
                $bandeira = "visa";
                $forma_pagamento = "1";
            }
            //para mastercard se tiver mais de uma parcela forma de pagamento fica 2
        } else if ($pagamento == "mastercard") {
            if ($numero_parcelas > 1) {
                $formapg = "visa";
                $bandeira = "mastercard";
                $forma_pagamento = "2";
                //senao mantenho 1
            } else {
                $formapg = "visa";
                $bandeira = "mastercard";
                $forma_pagamento = "1";
            }
            //para pagamento com American express
        } else if ($pagamento == "amex") {
            if ($numero_parcelas > 1) {
                $formapg = "visa";
                $bandeira = "amex";
                $forma_pagamento = "2";
            } else {
                $formapg = "visa";
                $bandeira = "amex";
                $forma_pagamento = "1";
            }
            //para dinners tudo como dinners
        } else if ($pagamento == "diners") {

            if ($numero_parcelas > 1) {
                $formapg = "visa";
                $bandeira = "diners";
                $forma_pagamento = "2";
            } else {
                $formapg = "visa";
                $bandeira = "diners";
                $forma_pagamento = "1";
            }
        }

        //se a forma da pagamento for boleto
        if ($formapg == "boleto") {

            //numero da referencia da transaÃ§Ã£o
            $refTran = "1500893";
            //numero de digitos do codigo de pedido
            $totdig = strlen($idpedido);
            //inicio a variavel do meio dos digitos como vazia
            $meio = "";
            //agora para o total de digitos ate 10 atribuo o valor para a variavel 0
            for ($f = 0; $f < 10 - $totdig; $f++) {
                $meio .= "0";
            }
            //agora concateno o pedido com a quantidade de zeros a referencia da transaÃ§Ã£o
            $refTran .= $meio . $idpedido;
            //valor formatado
            $valor = number_format($compra->VL_TOTAL_COSO, 2, "", "");
            //inicio a variavel vazia que armazenara o valor total e a transiÃ§Ã£o
            $vlTran = "";
            //o total de digitos do valor
            $totdigv = strlen($valor);
            //falo novamente que a variavel meio esta vazia
            $meio = "";
            //agora para cada digito do total de digitos do valor com maximo 15 atribuo o valor para a variavel 0
            for ($f = 0; $f < 15 - $totdigv; $f++) {
                $meio .= "0";
            }
            //atribuindo o valor da transiÃ§Ã£o com o valor a ser pago
            $vlTran .= $meio . $valor;
            //pego o horario
            $t = time();
            //numero de dias atribuo para 3
            $numOfDays = 3;
            //agora gero o numero de offset baseado no numero de dias
            $offSet = 86400 * $numOfDays;

            $t += $offSet;
            //agora o form de gerar o boleto
            //assino ao view as variaveis necessarias
            $this->view->nome = $nome;
            $this->view->refTran = $refTran;
            $this->view->vlTran = $vlTran;
            $this->view->t = date("dmY", $t);
            //crio o endereco completo
            $end_completo = $endereco . ',' . $numero;
            $this->view->endereco = $end_completo;
            $this->view->cidade = $cidade;
            $this->view->estado = $estado;
            $this->view->cep = $cep;

            // Destroi a sessÃ£o do carrinho e de promo no site
            Zend_Session::namespaceUnset("carrinho");
            Zend_Session::namespaceUnset("promocoes");
        }
        //se for visa
        if ($formapg == "visa" or $formapg == "mastercard" or $formapg == "amex" or $formapg == "diners") {
            //digo que a bandeira e visa

            if (strlen($order) > 1000) {
                $order = substr($order, 0, 1000);
            }
            //assino o cartao ao view
            $this->view->cartao = $cartao;
            $this->view->bandeira = $bandeira;
            $this->view->formapg = $forma_pagamento;
            $this->view->numero_parcelas = $numero_parcelas;
        }
    }

    //AÃ§Ã£o responsÃ¡vel pela emissÃ£o da segunda via do boleto
    public function segundoboletoAction() {

        //recebo o parametro referente a compra
        $idcompra = $this->_request->getParam("idcompra");

        //inicio o modulo de compras
        $model_compras = new Default_Model_Compras();

        //crio a query de compras com apenas os campos que eu preciso
        $select_compra = $model_compras->select()
                //seto false para integridade
                ->setIntegrityCheck(false)
                //digo de qual tabela quero e os campos
                ->from("compras", array("DT_COMPRA_COSO",
                    "DT_STATUS_COSO",
                    "DS_IP_COSO",
                    "VL_TOTAL_COSO",
                    "ST_COMPRA_COSO",
                    "DS_FORMAPGTO_COSO",
                    "DS_TID_COSO",
                    "DS_OBS_COSO"))
                //agora faÃ§o o join com a tabela de cliente para trazer os dados do cliente que eu preciso
                ->joinInner("cadastros", "cadastros.NR_SEQ_CADASTRO_CASO = compras.NR_SEQ_CADASTRO_COSO", array("DS_CIDADE_CASO",
                    "DS_NOME_CASO",
                    "DS_UF_CASO",
                    "DS_ENDERECO_CASO",
                    "DS_CIDADE_CASO",
                    "DS_CEP_CASO",
                    "DS_NUMERO_CASO"))
                //coloco a condiÃ§Ã£o que quero somente a compra que eu escolhi
                ->where("NR_SEQ_COMPRA_COSO = ?", $idcompra);



        //crio a lista com informacoes da compra
        $compras = $model_compras->fetchRow($select_compra);

        $this->view->dadosCompras = $compras;

        require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
        Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

        $transaction = PagarMe_Transaction::findById($compras->DS_TID_COSO);

        $this->view->boleto_url = $transaction->getBoletoUrl();

        /* ----------------------------------------------------
         *
         *
         * Inicio o desenvolvimento da segunda via do boleto
         *
         *
         * --------------------------------------------------- */

        //inicio as variaveis que vou utilizar
        $dia_hoje = date("Y-m-d");
        //pego o horario
        $t = time();
        //numero de dias atribuo para 3
        $numOfDays = 3;
        //agora gero o numero de offset baseado no numero de dias
        $offSet = 86400 * $numOfDays;

        $t += $offSet;

        //valor da compra
        $valor_compra = $compras->VL_TOTAL_COSO;
        //agora faÃ§o a regra para removes as virgulas para jogar no boleto
        $valor_compra = str_replace(",", ".", $valor_compra);
        //agora formato o numero para jogar no boleto
        $valor_boleto = number_format($valor_compra, 2, "", "");
        //valor do codigo de referencia
        $refTran = "1500893";
        //agora vejo quantos digitos na compra
        $total_digitos = strlen($idcompra);
        //inicio a variavel meio como vazia
        $meio = "";
        //agora coloco 0 no meio atÃ© completar 10 caracteres
        for ($f = 0; $f < 10 - $total_digitos; $f++) {
            $meio .= "0";
        }
        //agora concateno no codigo de referencia o que eu tenho de meio + compra
        $refTran .= $meio . $idcompra;


        //inicio a variavel vazia que armazenara o valor total e a transiÃ§Ã£o
        $vlTran = "";
        //o total de digitos do valor
        $totdigv = strlen($valor_boleto);
        //falo novamente que a variavel meio esta vazia
        $meio = "";
        //agora para cada digito do total de digitos do valor com maximo 15 atribuo o valor para a variavel 0
        for ($f = 0; $f < 15 - $totdigv; $f++) {
            $meio .= "0";
        }
        //atribuindo o valor da transiÃ§Ã£o com o valor a ser pago
        $vlTran .= $meio . $valor_boleto;
        //crio  a data de vencimento
        $data_vencimento = date("d/m/Y", strtotime($compras->DT_COMPRA_COSO) + ($numOfDays * 86400));
        //removo as barras para formatar do meio aceito pelo banco do brasil
        $data_vencimento = str_replace("/", "", $data_vencimento);



        //agora assino ao view
        $this->view->refTran = $refTran;
        $this->view->vlTran = $vlTran;
        $this->view->dtVenc = $data_vencimento;
        $this->view->nome = $compras->DS_NOME_CASO;
        $this->view->endereco = $compras->DS_ENDERECO_CASO;
        $this->view->numero = $compras->DS_NUMERO_CASO;
        $this->view->cidade = $compras->DS_CIDADE_CASO;
        $this->view->estado = $compras->DS_UF_CASO;
        $this->view->cep = $compras->DS_CEP_CASO;


        // //agora passo os dados para o array de boleto
        // $dadosboleto["nosso_numero"] = $idcompra;;
        // $dadosboleto["numero_documento"] = $refTran;	// Num do pedido ou do documento
        // $dadosboleto["data_vencimento"] = $data_vencimento; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        // $dadosboleto["data_documento"] = date("d/m/Y",strtotime($dia_hoje) ); // Data de emissÃ£o do Boleto
        // $dadosboleto["data_processamento"] = date("d/m/Y",strtotime($dia_hoje) ); // Data de processamento do boleto (opcional)
        // $dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vÃ­rgula e sempre com duas casas depois da virgula
        // // DADOS DO SEU CLIENTE
        // $dadosboleto["sacado"] = $compras->DS_NOME_CASO;
        // $dadosboleto["endereco1"] = $compras->DS_ENDERECO_CASO.', '.$compras->DS_NUMERO_CASO;
        // $dadosboleto["endereco2"] = $compras->DS_CIDADE_CASO.'-'.$compras->DS_UF_CASO.'-'.$compras->DS_CEP_CASO;
        // // INFORMACOES PARA O CLIENTE
        // $dadosboleto["demonstrativo1"] = "Voce fez uma reverb-compra";
        // $dadosboleto["demonstrativo2"] = "";
        // $dadosboleto["demonstrativo3"] = "";
        // // INSTRUÃ‡Ã•ES PARA O CAIXA
        // $dadosboleto["instrucoes1"] = "";
        // $dadosboleto["instrucoes2"] = "";
        // $dadosboleto["instrucoes3"] = "";
        // $dadosboleto["instrucoes4"] = "";
        // // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        // $dadosboleto["quantidade"] = "";
        // $dadosboleto["valor_unitario"] = "";
        // $dadosboleto["aceite"] = "N";		
        // $dadosboleto["especie"] = "R$";
        // $dadosboleto["especie_doc"] = "";
        // // ---------------------- DADOS FIXOS DE CONFIGURAÃ‡ÃƒO DO SEU BOLETO --------------- //
        // // DADOS DA SUA CONTA - BANCO DO BRASIL
        // $dadosboleto["agencia"] = "2755"; // Num da agencia, sem digito
        // $dadosboleto["conta"] = "22693"; 	// Num da conta, sem digito
        // // DADOS PERSONALIZADOS - BANCO DO BRASIL
        // $dadosboleto["convenio"] = "1500893";  // Num do convÃªnio - REGRA: 6 ou 7 ou 8 dÃ­gitos
        // $dadosboleto["contrato"] = "17944377"; // Num do seu contrato
        // $dadosboleto["carteira"] = "18";
        // $dadosboleto["variacao_carteira"] = "";  // VariaÃ§Ã£o da Carteira, com traÃ§o (opcional)
        // // TIPO DO BOLETO
        // $dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ ConvÃªnio c/ 8 dÃ­gitos, 7 p/ ConvÃªnio c/ 7 dÃ­gitos, ou 6 se ConvÃªnio c/ 6 dÃ­gitos
        // $dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ ConvÃªnio c/ 6 dÃ­gitos: informe 1 se for NossoNÃºmero de atÃ© 5 dÃ­gitos ou 2 para opÃ§Ã£o de atÃ© 17 dÃ­gitos
        // // SEUS DADOS
        // $dadosboleto["identificacao"] = "O pagamento deste boleto tambÃ©m;m poderÃ¡; ser efetuado pelo Gerenciador Financeiro, pelo Auto-Atendimento BB
        // Internet ou pelos Terminais de Auto-Atendimento.";
        // $dadosboleto["cpf_cnpj"] = "08345875/0001-37";
        // $dadosboleto["endereco"] = "";
        // $dadosboleto["cidade_uf"] = "";
        // $dadosboleto["cedente"] = "ANTONIO M. DIAS - CONFECCAO";
        // // NÃƒO ALTERAR!
        // include("bb/funcoes_bb.php"); 


        /* ----------------------------------------------------
         *
         *
         * Finalizo o desenvolvimento da segunda via do boleto
         *
         *
         * --------------------------------------------------- */


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
        //junto os 2 tipos de banners em um sÃ³ array
        $banners_topo = array_merge($agendados_topo, $normais_topo);

        //Assino ao view
        $this->view->banners_topo = $banners_topo;
    }

    public function refazerCarrinhoAction() {
        $carrinho_id = $this->_request->getParam('carrinho_id');

        $recuperarCarrinho = new Zend_Session_Namespace("recuperar_carrinho");
        $recuperarCarrinho->carrinho_id = $carrinho_id;

        $modelCarrinho = new Default_Model_Carrinho();
        $dadosCarrinho = $modelCarrinho->fetchRow(array('carrinho_id = ?' => $carrinho_id));

        if ($dadosCarrinho) {
            $estoques = json_decode($dadosCarrinho->estoque_id);
            foreach ($estoques as $estoque_id => $produto_id) {
                $ch = curl_init();
                $timeout = 15;

                $useragent = $_SERVER['HTTP_USER_AGENT'];
                $strCookie = 'PHPSESSID=' . $_COOKIE['PHPSESSID'] . '; path=/';
                session_write_close();

                curl_setopt($ch, CURLOPT_URL, "https://www.reverbcity.com/adicionar-carrinho/{$produto_id}/{$estoque_id}//");
                //curl_setopt($ch, CURLOPT_URL, "http://localhost/reverbcity.com/adicionar-carrinho/{$produto_id}/{$estoque_id}//");
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
                curl_setopt($ch, CURLOPT_COOKIE, $strCookie);
                $data = curl_exec($ch);
                curl_close($ch);
            }
        }

        $this->_redirect('/carrinho-compras');
    }

    public function statusBoletoAction() {

        date_default_timezone_set('America/Sao_Paulo');

        require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
        Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

        $id = $_POST['id'];
        $current_status = $_POST['current_status'];
        $old_status = $_POST['old_status'];
        $fingerprint = $_POST['fingerprint'];

        if (PagarMe::validateFingerprint($id, $fingerprint)) {
            if ($current_status == 'paid') {
                $modelCompras = new Default_Model_Compras();
                $selectCompras = $modelCompras->select()
                        ->from('compras')
                        ->where('DS_FORMAPGTO_COSO = "boleto"')
                        ->where('ST_COMPRA_COSO = "A"')
                        ->where('DS_TID_COSO = ?', $id);
                $dadosCompra = $modelCompras->fetchRow($selectCompras);

                $modelCadastros = new Default_Model_Reverbme();
                $dadosCadastro = $modelCadastros->fetchRow(array('NR_SEQ_CADASTRO_CASO = ?' => $dadosCompra->NR_SEQ_CADASTRO_COSO));

                $modelContaCorrente = new Default_Model_Contascorrente();

                $selectContaCorrente = $modelContaCorrente->select()
                        ->from('contacorrente')
                        ->where('DS_OBSERVACAO_CRSA LIKE ?', '%gerado pela compra ' . $dadosCompra->NR_SEQ_COMPRA_COSO);
                $dadosContaCorrente = $modelContaCorrente->fetchRow($selectContaCorrente);

                if ($dadosContaCorrente) {
                    $modelContaCorrente->update(array('ST_EXPIRADO_CRSA' => 'N'), array('NR_SEQ_CONTA_CRSA = ?' => $dadosContaCorrente->NR_SEQ_CONTA_CRSA));
                }

                if ($dadosCompra) {
                    $modelCompras->update(array('ST_COMPRA_COSO' => 'P', 'DT_STATUS_COSO' => date("Y-m-d H:i:s"), 'DT_PAGAMENTO_COSO' => date("Y-m-d H:i:s")), array('DS_FORMAPGTO_COSO = ?' => 'boleto', 'DS_TID_COSO = ?' => $id));

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
                            CONFIRMAÇÃO DE PAGAMENTO REVERBCITY
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                <div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                                    <p>Olá <strong>' . $dadosCadastro->DS_NOME_CASO . '</strong>,</p>

                                    <p>O seu pagamento referente ao pedido <a href="http://reverbcity.com/reverbme/minhascompras"><strong>' . $idgrp . '</strong></a> foi confirmado com sucesso e já estamos separando sua compra aqui na Reverbcity!</p>
                                    <p>Assim que seu pedido for enviado, você receberá no seu email o código de rastreamento e atualizações sobre o percurso do sua encomenda.</p>
                                    <p>Qualquer dúvida basta entrar em contato: <strong><a href=mailto:atendimento@reverbcity.com>atendimento@reverbcity.com</a></strong></p>
                              </div>
                              <div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">

                                <b>Prazo para a postagem:</b>
                                Pedidos com o pagamento confirmado até as 13:00 de um dia útil serão postados no mesmo dia, após este horário a postagem se dará no próximo dia útil.

                                Prazo para a entrega:
                                Os prazos de entregam dependem da forma de envio escolhida durante a compra.

                                Os envios por E-sedex, Sedex e TAM levam em média três dias úteis após a postagem.

                                Os envios por PAC podem levar até 23 dias úteis, dependendo da região do país. Veja abaixo o prazo médio para sua região:
                                1 a 2 dias úteis para as capitais PR, SC, SP, RJ e MG
                                3 a 7 dias úteis para demais cidades do interior e os estados RS, DF, ES, GO, MS, BA, MT, SE e TO
                                7 a 12 dias úteis para os estados e capitais de AL, AC, AP, CE, MA, PA, PB, PE, PI, RN, RO e RR
                                atÃ© 23 dias úteis para AM
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
                        'username' => "atendimento@reverbcity.com",
                        'password' => "ramones@334",
                        'ssl' => "tls",
                        'port' => "587"
                    );
                    $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                    $emailAdm = "atendimento@reverbcity.com";
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setBodyHtml($htmlBody);
                    $mail->addTo($dadosCadastro->DS_EMAIL_CASO, $dadosCadastro->DS_NOME_CASO);
                    $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                    $mail->setReturnPath($emailAdm);
                    $mail->setSubject("ReverbCity - Confirmação de Pagamento!");
                    $mail->send($mailTransport);
                }
            } else {
                // NÃ£o funcionou...
            }
        }
    }

    public function statusCartaoAction() {

        date_default_timezone_set('America/Sao_Paulo');

        require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
        Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

        $id = $_POST['id'];
        $current_status = $_POST['current_status'];
        $old_status = $_POST['old_status'];
        $fingerprint = $_POST['fingerprint'];

        if (PagarMe::validateFingerprint($id, $fingerprint)) {
            if ($current_status == 'paid') {
                $modelCompras = new Default_Model_Compras();
                $selectCompras = $modelCompras->select()
                        ->from('compras')
                        ->where('DS_FORMAPGTO_COSO <> "boleto"')
                        ->where('ST_COMPRA_COSO = "A"')
                        ->where('DS_TID_COSO = ?', $id);
                $dadosCompra = $modelCompras->fetchRow($selectCompras);

                $modelCadastros = new Default_Model_Reverbme();
                $dadosCadastro = $modelCadastros->fetchRow(array('NR_SEQ_CADASTRO_CASO = ?' => $dadosCompra->NR_SEQ_CADASTRO_COSO));

                if ($dadosCompra) {
                    $modelCompras->update(array('ST_COMPRA_COSO' => 'P', 'DT_STATUS_COSO' => date("Y-m-d H:i:s"), 'DT_PAGAMENTO_COSO' => date("Y-m-d H:i:s")), array('DS_FORMAPGTO_COSO = ?' => 'boleto', 'DS_TID_COSO = ?' => $id));

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
                            CONFIRMAÇÃO DE PAGAMENTO REVERBCITY
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                <div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                                    <p>Olá <strong>' . $dadosCadastro->DS_NOME_CASO . '</strong>,</p>

                                    <p>O seu pagamento referente ao pedido <a href="http://reverbcity.com/reverbme/minhascompras"><strong>' . $idgrp . '</strong></a> foi confirmado com sucesso e já estamos separando sua compra aqui na Reverbcity!</p>
                                    <p>Assim que seu pedido for enviado, você receberá no seu email o código de rastreamento e atualizações sobre o percurso do sua encomenda.</p>
                                    <p>Qualquer dúvida basta entrar em contato: <strong><a href=mailto:atendimento@reverbcity.com>atendimento@reverbcity.com</a></strong></p>
                              </div>
                              <div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">

                                <b>Prazo para a postagem:</b>
                                Pedidos com o pagamento confirmado até as 13:00 de um dia útil serão postados no mesmo dia, após este horário a postagem se dará no próximo dia útil.

                                Prazo para a entrega:
                                Os prazos de entregam dependem da forma de envio escolhida durante a compra.

                                Os envios por E-sedex, Sedex e TAM levam em média três dias úteis após a postagem.

                                Os envios por PAC podem levar até 23 dias úteis, dependendo da região do país. Veja abaixo o prazo médio para sua região:
                                1 a 2 dias úteis para as capitais PR, SC, SP, RJ e MG
                                3 a 7 dias úteis para demais cidades do interior e os estados RS, DF, ES, GO, MS, BA, MT, SE e TO
                                7 a 12 dias úteis para os estados e capitais de AL, AC, AP, CE, MA, PA, PB, PE, PI, RN, RO e RR
                                atÃ© 23 dias úteis para AM
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
                        'username' => "atendimento@reverbcity.com",
                        'password' => "ramones@334",
                        'ssl' => "tls",
                        'port' => "587"
                    );
                    $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

                    $emailAdm = "atendimento@reverbcity.com";
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setBodyHtml($htmlBody);
                    $mail->addTo($dadosCadastro->DS_EMAIL_CASO, $dadosCadastro->DS_NOME_CASO);
                    $mail->setFrom($emailAdm, "Reverbcity - A Música que veste");
                    $mail->setReturnPath($emailAdm);
                    $mail->setSubject("ReverbCity - Confirmação de Pagamento!");
                    $mail->send($mailTransport);
                }
            } else {
                // NÃ£o funcionou...
            }
        }
    }

    // Funcao para converter um xml para array
    function Xml2array($contents, $get_attributes = 0) {

        if (!$contents)
            return array();

        if (!function_exists('xml_parser_create')) {
            return array();
        }

        $parser = xml_parser_create();

        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'utf-8');
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $contents, $xml_values);
        xml_parser_free($parser);

        if (!$xml_values)
            return;

        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();

        $current = &$xml_array;

        foreach ($xml_values as $data) {
            unset($attributes, $value);
            extract($data);

            $result = '';

            if ($get_attributes) {
                $result = array();
                if (isset($value))
                    $result['value'] = $value;


                if (isset($attributes)) {
                    foreach ($attributes as $attr => $val) {
                        if ($get_attributes == 1)
                            $result['attr'][$attr] = $val;
                    }
                }
            } elseif (isset($value)) {
                $result = $value;
            }

            if ($type == "open") {
                $parent[$level - 1] = &$current;

                if (!is_array($current) or ( !in_array($tag, array_keys($current)))) {
                    $current[$tag] = $result;
                    $current = &$current[$tag];
                } else {
                    if (isset($current[$tag][0])) {
                        array_push($current[$tag], $result);
                    } else {
                        $current[$tag] = array($current[$tag], $result);
                    }
                    $last = count($current[$tag]) - 1;
                    $current = &$current[$tag][$last];
                }
            } elseif ($type == "complete") {
                if (!isset($current[$tag])) {
                    $current[$tag] = $result;
                } else {
                    if ((is_array($current[$tag]) and $get_attributes == 0)
                            or ( isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1)) {
                        array_push($current[$tag], $result);
                    } else {
                        $current[$tag] = array($current[$tag], $result);
                    }
                }
            } elseif ($type == 'close') {
                $current = &$parent[$level - 1];
            }
        }

        return($xml_array);
    }

}
