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

    /**
     * FunÃ§Ã£o responsavel pela aÃ§Ã£o de fazer o pedido
     * */
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
                }

                //elo
                if ($forma_pagamento == "elo") {
                    //recupero o numero de parcelas
                    $numero_parcelas = $this->_request->getParam("parcelamento");
                    //agora o numero do cartao do usuario
                    $cartao = $this->_request->getParam("elo");
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


                    /*                     * ************-
                     * **************-
                     * ****PROMOS****-
                     * **************-
                     * ************** */

                    //-----------//
                    //aniversario//
                    //----------//
//                    //agora passo o valor do produto se tiver promo atribuo o valor de promo para ver na promo
//                    if ($data_carrinho[$key]['vl_promo'] == 0) {
//                        $valor_produto_promo = $data_carrinho[$key]['valor'];
//                    } else {
//                        $valor_produto_promo = $data_carrinho[$key]['vl_promo'];
//                    }
//
//                    // verifico se entrou na promo certa
//                    if ($sessao_promo->niver > 0) {
//
//                        //Ã© aniversariante
//                        $aniversariante == true;
//                        if ($ja_tem_brinde == 0) {
//
//                            //se tiver apenas 1
//                            if ($quantidade == 1) {
//                                //agora vejo se e camiseta
//                                if ($item["tipo"] == 6 and $tem_cheio == 1 and $valor_total >= 150) {
//                                    //defino os valores como 0
//                                    $data_carrinho[$key]['vl_promo'] = 0.1;
//                                    $data_carrinho[$key]['valor'] = 0;
//                                    //falo que ele ja ganhou um brinde
//                                    $ja_tem_brinde = 1;
//
//                                    $data_niver["ST_COMPROU_NIVER"] = 1;
//
//                                    $model_compras->update($data_niver, array("NR_SEQ_COMPRA_COSO = ?" => $idcompra));
//                                }
//                            }
//                        }
//                    }
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
//                    if ($sessao_promo->primeira > 0) {
//
//                        //agora verifico se existe mais de o valor para entrar na promo em compras e se ainda nÃ£o entrou brinde para ele
//                        if ($valor_total >= $promocoes["vl_primeira_compra"]) {
//
//                            // if($valor_total >= $promocoes["vl_primeira_compra"] and $ja_tem_brinde == 0){
//                            //se tiver apenas 1
//                            if ($item['quantidade'] == 1) {
//
//
//                                //agora vejo se e camiseta
//                                if ($item["tipo"] == 6 and $tem_cheio == 1) {
//
//                                    if ($ja_tem_brinde == 0) {
//
//                                        if ($data_carrinho[$key]["brinde"] == 1) {
//
//                                            //defino os valores como 0
//                                            $data_carrinho[$key]['vl_promo'] = 0.1;
//                                            $data_carrinho[$key]['valor'] = 0;
//                                            //falo que ele ja ganhou um brinde
//                                            $ja_tem_brinde = 1;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
                    // Zend_Debug::dump($data_carrinho[$key]);
                    //-----------------------------------------------------------------------------//
                    //    Promo ganhe sale para quem sÃ³ fez 1 compra ou esta 3 meses sem compra    //
                    //-----------------------------------------------------------------------------//
                    // verifico se Ã© a promocao correta
//                    if ($sessao_promo->sale2 > 0) {
//                        //verifico se ja tem brinde
//                        if ($item["tipo"] == 6 and $ja_tem_brinde == 0) {
//
//                            if ($tem_cheio == 1) {
//                                //agora vejo se e camiseta
//                                if ($data_carrinho[$key]["destaque"] == 2) {
//                                    //verifico se tem apenas 1
//                                    if ($quantidade == 1) {
//                                        //defino os valores como 0
//                                        $data_carrinho[$key]['vl_promo'] = 0.1;
//                                        $data_carrinho[$key]['valor'] = 0;
//                                        //falo que ele ja ganhou um brinde
//                                        $ja_tem_brinde = 1;
//                                    }
//                                }
//                            }
//                        }
//                    }
                    //-----------//
                    //Ganha sale //
                    //-----------//	
                    // verifico se Ã© a promocao correta
//                                        if ($sessao_promo->sale > 0){
//                                               //verifico se ja tem brinde
//                                               if($item["tipo"] == 6 and $ja_tem_brinde == 0){
//
//                                                       if ($tem_cheio == 1){
//                                                           //agora vejo se e camiseta
//                                                            if($data_carrinho[$key]["destaque"] == 2){
//                                                               //verifico se tem apenas 1
//                                                               if($quantidade == 1){
//                                                                       //defino os valores como 0
//                                                                       $data_carrinho[$key]['vl_promo'] = 0.1;
//                                                                       $data_carrinho[$key]['valor'] = 0;
//                                                                       //falo que ele ja ganhou um brinde
//                                                                       $ja_tem_brinde = 1;
//                                                               }
//                                                            }
//                                                       }	
//                                               }
//                                        }




                    /*                     * ************-
                     * **************-
                     * **FIM PROMOS***-
                     * **************-
                     * ************** */

                    if ($usuarios->tipo == 'PJ') {
//						if($data_carrinho[$key]['tipo'] == 142){
//							//atribuo o valor cheio
//							$valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//							//jogo o valor do produto na variavel
//							$valor = $data_carrinho[$key]['valor'] * 0.7;
//							//jogo o valor do produto na variavel de produto cheio
//							$valor_uni = $data_carrinho[$key]['valor'] * 0.7;
//						}else{
//							if($data_carrinho[$key]['destaque'] == 2){
//							//atribuo o valor cheio
//								$valor_cheio = $data_carrinho[$key]['valor'] * 0.4;
//								//jogo o valor do produto na variavel
//								$valor = $data_carrinho[$key]['valor'] * 0.4;
//								//jogo o valor do produto na variavel de produto cheio
//								$valor_uni = $data_carrinho[$key]['valor'] * 0.4;
//							}else{
//								//atribuo o valor cheio
//								$valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//								//jogo o valor do produto na variavel
//								$valor = $data_carrinho[$key]['valor'] * 0.7;
//								//jogo o valor do produto na variavel de produto cheio
//								$valor_uni = $data_carrinho[$key]['valor'] * 0.7;
//							}
//						}
//                        if ($data_carrinho[$key]["destaque"] != 2) {
//
//                            //jogo o valor do produto na variavel
//                            $valor = $data_carrinho[$key]['valor'];
//                            //jogo o valor do produto na variavel de produto cheio
//                            $valor_cheio = $data_carrinho[$key]['valor'];
//                            $valor_uni = $data_carrinho[$key]['valor'];
//                        }else{
//                            //jogo o valor do produto na variavel
//                            $valor = $data_carrinho[$key]['valor'];
//                            //jogo o valor do produto na variavel de produto cheio
//                            $valor_cheio = $data_carrinho[$key]['valor'];
//                            $valor_uni = $data_carrinho[$key]['valor'];
//                        }

                        $valor = $data_carrinho[$key]['valor'];
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        $valor_uni = $data_carrinho[$key]['valor'];

                        //recebo a quantidade
                        $quantidade = $item['quantidade'];
                        //multiplico pela quantidade do produto
                        $valor = $valor * $quantidade;

                        // Se o preço promocional for menor que o com desconto
//                        if($data_carrinho[$key]['vl_promo'] > 0 && $valor > $data_carrinho[$key]['vl_promo']){
//                            $valor_uni = $data_carrinho[$key]['vl_promo'];
//                            $valor = $quantidade * $data_carrinho[$key]['vl_promo'];
//                        }

                        if ($data_carrinho[$key]['codigo'] == 5745) {
                            $valor_uni = $data_carrinho[$key]['valor'];
                            $valor = $quantidade * $data_carrinho[$key]['valor'];
                        }

                        //assino o valor total por produto ao view
                        $this->view->total_produto = $valor;

                        $data_carrinho[$key]['vl_promo'] = 0;
                    } else {


                        //aqui verifico se e promo ou nÃ£o
//                        if ($data_carrinho[$key]['vl_promo'] > 0) {
//                            //jogo o valor da promo no valor do produto
//                            $valor = $data_carrinho[$key]['vl_promo'];
//
//                            //o mesmo valor para inserir no banco sem ter sido multiplicado
//                            $valor_uni = $data_carrinho[$key]['vl_promo'];
//
//                            //atribuo o valor cheio
//                            $valor_cheio = $data_carrinho[$key]['valor'];
//
//                            //recebo a quantidade
//                            $quantidade = $item['quantidade'];
//
//                            //multiplico pela quantidade do produto
//                            $valor = $valor * $quantidade;
//
//                            //agora falo que tem promo na variavel
//                            $tem_promo = 1;
//                            //assino o valor total por produto ao view
//                            $this->view->total_produto_promo = $valor;
//                        } else {
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
//
//                            $valor = $data_carrinho[$key]['vl_desconto'];
//
//                            //o mesmo valor para inserir no banco sem ter sido multiplicado
//                            $valor_uni = $data_carrinho[$key]['vl_desconto'];
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
//                        }
                    }

                    //agora vejo se o valor e 0.1 da promocao para jogar o valor como 0
                    if ($valor_uni == 0.1 or $valor == 0.1) {
                        $valor_uni = 0;
                        $valor = 0;
                        $valor_cheio = 0;
                    }

                    //crio a query para pegar o estoque
//                    $select_estoque = $model_estoque->select()
//                            ->where("NR_SEQ_PRODUTO_ESRC = ?", $item['codigo'])
//                            ->where("NR_SEQ_TAMANHO_ESRC = ?", $item['tamanho']);

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

//					//agora eu insiro o valor da nova quantidade no array
//					$data_estoque = array('NR_QTDE_ESRC' => $produto_estoque['NR_QTDE_ESRC'] - $quantidade);
                    //agora atualizo o carrinho com a quantidade disponivel
                    $carrinho->produtos[$key]['estoque'] = $produto_estoque['NR_QTDE_ESRC'] - $quantidade;
//					//atualizo a quantidade
//					$model_estoque->update($data_estoque, array("NR_SEQ_PRODUTO_ESRC = ?" => $item['codigo'],
//																"NR_SEQ_TAMANHO_ESRC = ?" => $item['tamanho']));
//
//					//crio o array da cesta
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
//
//
//					//crio o array de controle de estoque
//					$data_controle = array("NR_SEQ_PRODUTO_ECRC"=> $item["codigo"],
//										   "NR_SEQ_USUARIO_ECRC"=> 9,
//										   "NR_SEQ_TAMANHO_ECRC"=> $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
//										   "DS_ACAO_ECRC" 		=> "Removeu ".$quantidade,
//										   "DS_OBS_ECRC" 		=> "Venda site - Compra Nr ".$idcompra,
//										   "DT_ACAO_ECRC" 		=> $data_hoje,
//										   "NR_QTDE_ECRC"		=> "-".$quantidade);
//					//agora insiro no banco de dados o registro do controle de estoque
//					$model_controle_estoque->insert($data_controle);
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

                        //coloco as informaÃ§Ãµes de vale presente em um array
                        $data_vale_presente = array("NR_SEQ_COMPRA_BIRC" => $idcompra,
                            "NR_SEQ_CADCRIADOR_BIRC" => $usuarios->idperfil,
                            "DS_BILHETE_BIRC" => $bilhete,
                            "DT_CRIACAO_BIRC" => date("Y-m-d H:i:s"),
                            "ST_STATUS_BIRC" => 'A',
                            "VL_BILHETE_BIRC" => $row_produto["valor"]);
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

                // if($valor_final < 0){
                // 	$valor_final = 0;
                // 	$data_compra["DS_FORMAPGTO_COSO"] = "Credito";
                // }

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

//                                    if ($data_carrinho[$key]["destaque"] != 2) {
//
//                                        //jogo o valor do produto na variavel
//                                        $valor = $data_carrinho[$key]['valor'] * 0.7;
//                                        //jogo o valor do produto na variavel de produto cheio
//                                        $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//                                        $valor_uni = $data_carrinho[$key]['valor'] * 0.7;
//                                    }
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
//                                $model_estoque->update($data_estoque, array("NR_SEQ_PRODUTO_ESRC = ?" => $item['codigo'],
//                                    "NR_SEQ_TAMANHO_ESRC = ?" => $item['tamanho']));
                                $model_estoque->update($data_estoque, array("NR_SEQ_ESTOQUE_ESRC = ?" => $key));

                                //crio o array da cesta
//                                                $data_cesta = array("NR_SEQ_CADASTRO_CESO" 	=> $usuarios->idperfil,
//                                                                                        "NR_SEQ_COMPRA_CESO" 	=> $idcompra,
//                                                                                        "NR_SEQ_PRODUTO_CESO" 	=> $item["codigo"],
//                                                                                        "NR_SEQ_ESTOQUE_CESO" 	=> $produto_estoque["NR_SEQ_ESTOQUE_ESRC"],
//                                                                                        "NR_SEQ_TAMANHO_CESO" 	=> $produto_estoque["NR_SEQ_TAMANHO_ESRC"],
//                                                                                        "NR_QTDE_CESO"		  	=> $quantidade,
//                                                                                        "VL_PRODUTO_CESO"		=> $valor_uni,
//                                                                                        "DT_INCLUSAO_CESO"		=> $data_hoje,
//                                                                                        "VL_PRODUTOCHEIO_CESO"  => $valor_cheio);
//                                                //agora insiro o registro da cesta
//                                                $model_cestas->insert($data_cesta);
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

                            if (!empty($