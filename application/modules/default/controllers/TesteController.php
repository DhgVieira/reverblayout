﻿<?php

/**
 *
 */
class TesteController extends Zend_Controller_Action {

    /**
     *
     */
    public function init() {
        
    }

    /**
     *
     */
    public function indexAction() {
        //inicio a sessao de carrinho
        $carrinho = new Zend_Session_Namespace("carrinho");
        //Zend_Debug::dump($carrinho->produtos); exit;
        //crio a sessao de mensagens
        $messages = new Zend_Session_Namespace("messages");
        //inicio a sessao do usuario logado
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio a sessao dos descontos
        $descontos = new Zend_Session_Namespace("descontos");
        //crio a sessao de mensagens de promo
        $sessao_promo = new Zend_Session_Namespace("promocoes");

        $campanhas = new Zend_Session_Namespace("campanhas");

        $sessionPromoBoleto = new Zend_Session_Namespace("promoBoleto");
        //pego a url da campanha
        $endereco = $_SERVER ['REQUEST_URI'];
        //pego o id da campanha
        $parametro = explode("=", $endereco);
        //adiciono a campanha a sessão
        //verifico se existe parametro

        $parametros = $this->_request->getParams();

        if ($parametros['cp'] != "") {
            //adiciono a campanha a sessão
            $campanhas->idcampanha = $parametro[1];
        }

//         foreach ($carrinho->produtos as $key => $produto) {
//         	$vl_promo[$key]  = $produto['vl_promo'];
//         }
//         array_multisort($vl_promo, SORT_DESC, $carrinho->produtos);
//         usort($carrinho->produtos, create_function('$a, $b',
//  			'if ($a["vl_promo"] == $b["vl_promo"]) return 0; return ($a["vl_promo"] < $b["vl_promo"]) ? -1 : 1;'));


       /* foreach ($carrinho->produtos as $key => $row) {
            $vl_promo[$key] = $row['vl_promo'];
        }

        array_multisort($vl_promo, SORT_ASC, $carrinho->produtos);*/


        $sessao_promo->niver = 0;
        $sessao_promo->primeira = 0;
        $sessao_promo->brinde = 0;
        $sessao_promo->valor_desconto = 0;
        //verifico se o usuario esta logado
        if ($usuarios->logado == TRUE) {
            //verifico se existe produtos no carrinho
            if (count($carrinho->produtos) <= 0) {
                //mensagem de retorno para o usuario
                $messages->error = "Seu carrinho esta vazio.";
                // Redireciona para a última página
                $this->_redirect("/todos-produtos");
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
            $this->view->frete = $sessao_frete->valor;
            $sessao_frete->valor = null;

            //assino o tipo do frete
            $this->view->forma_envio = $sessao_frete->forma_envio;
            //coloco o cep
            $this->view->cep = $sessao_frete->cep;

            //coloco o valor para frete gratis
            $this->view->valor_para_frete_gratis = $sessao_frete->valor_para_frete_gratis;
            //recebo o cupon de desconto ou vale presente
            $cupom = $this->_request->getParam("cupom");

//            $paymentSelected = $this->_request->getParam("paymentSelected");
            $selecPayment = $this->_request->getParam("selecPayment");


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
            $tem_estilos_musicais = 0;
            $tem_estilos_musicais_brinde = 0;
            //vejo se tem produto cheio
            $tem_produto_cheio = 0;

            $credito_proxima_compra = 0;

            $sem_promo_recur = 0;

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
                        "replace(replace(DS_NUMERO_CASO,'-',''),'.','') as DS_NUMERO_CASO",
                        "DS_COMPLEMENTO_CASO",
                        "DS_CIDADE_CASO",
                        "DS_UF_CASO",
                        "DS_PAIS_CACH",
                        "DS_CEP_CASO",
                        "replace(replace(DS_CEP_CASO,'-',''),'.','') as DS_CEP_CASO",
                        "DS_BAIRRO_CASO",
                        "replace(replace(DS_CPFCNPJ_CASO,'-',''),'.','') as DS_CPFCNPJ_CASO",
                        "DS_EMAIL_CASO",
                        "replace(replace(DS_DDDFONE_CASO,'-',''),'.','') as DS_DDDFONE_CASO",
                        "replace(replace(DS_FONE_CASO,'-',''),'.','') as DS_FONE_CASO"
                        ))
                    ->where("NR_SEQ_CADASTRO_CASO = '$usuarios->idperfil'");
            //assino o cliente ao view
            $infos = $model_cadastro->fetchRow($select_info)->toArray();

            $modelEnderecos = new Default_Model_Enderecosentrega();
            $dadosEnderecos = $modelEnderecos->fetchAll(array('NR_SEQ_CADASTRO_ENRC = ?' => $usuarios->idperfil));

            $this->view->dadosEnderecos = $dadosEnderecos;

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

//            uasort($carrinho->produtos, function($a, $b) {
//                return $b['total_produto'] - $a['total_produto'];
//            });


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
                            "vl_promo_xgg" => "VL_PROMO_XGL_PRRC",
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

                /**
                 *  Promo de preço para tamanho M
                 */
                if ($row_produto['vl_promo_m'] > 0 and ( $item['tamanho'] == 3 or $item['tamanho'] == 8)) {
                    $data_carrinho[$key]['vl_promo'] = $row_produto['vl_promo_m'];
                    $carrinho->produtos[$key]['vl_promo'] = $row_produto['vl_promo_m'];
                }

                /**
                 *  Promo de preço para tamanho XGG
                 */
                if ($row_produto['vl_promo_xgg'] > 0 and ( $item['tamanho'] == 33 or $item['tamanho'] == 47)) {
                    $data_carrinho[$key]['vl_promo'] = $row_produto['vl_promo_xgg'];
                    $carrinho->produtos[$key]['vl_promo'] = $row_produto['vl_promo_xgg'];
                }

                $modelEstoque = new Default_Model_Estoque();
                $dadosEstoque = $modelEstoque->fetchRow(array('NR_SEQ_ESTOQUE_ESRC = ?' => $key));

                if ($dadosEstoque->NR_VALOR_ESRC) {
                    $data_carrinho[$key]['vl_promo'] = $dadosEstoque->NR_VALOR_ESRC;
                    $carrinho->produtos[$key]['vl_promo'] = $dadosEstoque->NR_VALOR_ESRC;
                }

                //agora verifico se existe algo que anule frete gratis
                /*if ($data_carrinho[$key]['tipo'] == 52) {
                    //anulo o frete gratis
                    $anula_frete_gratis = 1;
                } else {
                    //nao anulo
                    $anula_frete_gratis = 0;
                }*/

                // Verifico se o produto nao tem valor promocional
                $sem_promo = false;
//                if ($data_carrinho[$key]['vl_promo'] == 0 and $data_carrinho[$key]['valor'] >= 59) {
                if ($data_carrinho[$key]['vl_promo'] == 0) {
                    $sem_promo = true;
                    //aqui somamos a quantidade de produtos com valor cheio estao fora da promocao
                    $sem_promo_recur++;

                    ($item['quantidade']>= 2)? $sem_promo_recur++ : '';
                }

                // Promo caneca ou poster grátis da compra de uma estilos musicais
//                if($data_carrinho[$key]['categoria'] == 186){
//                    $tem_estilos_musicais = 1;
//                }
//                if(($data_carrinho[$key]['categoria'] == 57 or $data_carrinho[$key]['categoria'] == 173) and $tem_estilos_musicais == 1 and $tem_estilos_musicais_brinde == 0 and $tem_cheio == 1 and $sessao_promo->niver != 1 and $sessao_promo->primeira != 1){
//                    $data_carrinho[$key]['valor'] = 0;
//                    $carrinho->produtos[$key]['valor'] = 0;
//                    $data_carrinho[$key]['vl_promo'] = 0;
//                    $carrinho->produtos[$key]['vl_promo'] = 0;
//                    $tem_estilos_musicais_brinde = 1;
//                }
                // Fim promo

                /*                 * *************-
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

                //verifico se a promo de aniversário esta ativa
                if ($promocoes["st_promo_niver"] == 1) {

                    $ano_atual = date("Y");

                    // deixo a data de aniversario como a data de hoje para ativar a promo de dia dos namorados
                    // $dia_aniversario = $hoje;
                    // se hoje for o dia do aniversario do usuario atribuo como aniversariante e não for PJ

                    if ($dia_aniversario == date('m') and $usuarios->tipo <> 'PJ') {

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
                            //if($sem_promo == true) {
                                //é aniversariante
                                $aniversariante = true;
                                // atribuo a mensagem para o carrinho
                                // $msg_promo = $promocoes["msg_promo_niver"];
                                // agora assino a mensagem a promo
                                // $sessao_promo->msg = $msg_promo;
// 
                                // $this->view->compra_niver = 1;
// 
                                // $valor = $data_carrinho[$key]['valor'] * $item['quantidade'];
// 
                                // $sessao_promo->valor_desconto += $valor * 0.15;
// 
                                // $valor = $valor - ($valor * 0.15);
                                $sessao_promo->niver = 1;
                                // $sessao_promo->brinde = 1;
// 
// 
                                // $data_carrinho[$key]['valor_total_desconto'] = $valor;
                                // $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                            //}
                        }
                    }
                }


                //----------------//
                //Desconto R$10,00// PROMO APPLICATIVA
                //---------------//                
                /* Vamos dar 10,00 de desconto nas compras dos clientes dos estados 
                 * Norte: AM, RR, AP, PA, TO, RO, AC 
                 * Nordeste: MA, PI, CE, RN, PE, PB, SE, AL, BA
                 * Eles terão que comprar R$ 130,00 com pelo menos um produto de preço cheio (59)
                 */

                //Crio um array com os estados da promoção
//                $ufs_promocao = array('AM', 'RR', 'AP', 'PA', 'TO', 'RO', 'AC', 'MA', 'PI', 'CE', 'RN', 'PE', 'PB', 'SE', 'AL', 'BA');
//                if (in_array($usuarios->uf, $ufs_promocao)) {
//                    //aqui verifico se e promo ou não
//                    if ($data_carrinho[$key]['vl_promo'] > 0) {
//                        //jogo o valor da promo no valor do produto
//                        $valor = $data_carrinho[$key]['vl_promo'];
//
//                        //recebo a quantidade
//                        $quantidade = $item['quantidade'];
//
//                        //multiplico pela quantidade do produto
//                        $valor = $valor * $quantidade;
//
//                        //agora falo que tem promo na variavel
//                        $tem_produto_promo = 1;
//                    } else {
//                        //jogo o valor do produto na variavel
//                        $valor = $data_carrinho[$key]['valor'];
//                        //jogo o valor do produto na variavel de produto cheio
//                        $valor_cheio = $data_carrinho[$key]['valor'];
//                        //recebo a quantidade
//                        $quantidade = $item['quantidade'];
//                        //multiplico pela quantidade do produto
//                        $valor = $valor * $quantidade;
//                        //agora falo que tem produto cheio
//                        if ($valor_cheio >= 59) {
//                            $tem_produto_cheio = 1;
//                        }
//                    }
//                }
                //----------------//
                //Primeira Compra//
                //---------------//
                //verifico se a promo de primeira compra esta ativa
                if ($promocoes["st_primeira_compra"] == 1 and $usuarios->tipo <> 'PJ' and $aniversariante != true) {

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
                    //die($select_primeira_compra);
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

                        //if ($ja_tem_brinde == 0) {

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

                                //if ($sem_promo == true) {

                                        $sessao_promo->primeira = 1;
                                        $sessao_promo->brinde = 1;
                                        $primeiracompra = true;

                                        $msg_promo = $promocoes["msg_primeira_compra"];
                                        $sessao_promo->msg = $promocoes["msg_primeira_compra"];


                                        //$credito_proxima_compra += $data_carrinho[$key]['valor'] * 0.15;
                                    
                                //}
                            }
                        }
                    }
                }

                //-----------------------------------------//
                //  Promo ganhe outra quem nunca comprou   //
                //-----------------------------------------//
//                // Cria o objeto de conexão
//                $db = Zend_Registry::get("db");
//                //crio a query para verificar se o usuário tem alguma compra que não seja cancelada
//                $select_compra = "SELECT
//                                            NR_SEQ_CADASTRO_COSO
//                                     from
//                                            compras,
//                                            cadastros
//                                     WHERE
//                                            NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
//                                     AND
//                                            ST_COMPRA_COSO <> 'C'
//
//                                     AND NR_SEQ_CADASTRO_CASO = $usuarios->idperfil";
//                // die($select_compra_mes);
//                //executo a query
//                $query_compra = $db->query($select_compra);
//
//                //crio uma varivel que recebe a primeira compra ou fica vazia
//                $dadosCompra = $query_compra->fetchAll();
//
//                if($dadosCompra[0] == NULL and $ja_tem_brinde == 0 and $valor_total >= 150){
//                    //é aniversariante
//                    $aniversariante == true;
//                    //atribuo a mensagem para o carrinho
//                    $msg_promo = "Compre 1 camiseta de preço cheio e ganhe outra, a mesma de aniversario (para quem tem cadastro e nunca comprou)";
//                    //agora assino a mensagem a promo
//                    $sessao_promo->msg = $msg_promo;
//
//                    $this->view->compra_niver = 1;
//
//                    if ($tem_promo == 0) {
//
//                        //agora verifico se o produto e valor maior que o ultimo e se ainda não entrou brinde para ele e se é camiseta
//                        if ($valor_cheio >= $valor_produto_promo and $ja_tem_brinde == 0 and $data_carrinho[$key]['tipo'] == 6 and $tem_cheio == 1) {
//
//                            //se tiver apenas 1
//                            if ($item['quantidade'] == 1) {
//                                //defino os valores como 0
//
//                                $data_carrinho[$key]['vl_promo'] = 0;
//                                $data_carrinho[$key]['valor'] = 0;
//                                $carrinho->produtos[$key]["brinde"] = 1;
//                                $carrinho->produtos[$key]["brinde"];
//                                //falo que ele ja ganhou um brinde
//                                $ja_tem_brinde = 1;
//                                //agora atribuo como verdadeiro a sessao de primeira compra
//                                $sessao_promo->niver = 1;
//                                $sessao_promo->brinde = 1;
//                            }
//                        }
//                    }
//                }
                //-----------------------------------------------------------------------------//
                //    Promo ganhe sale para quem só fez 1 compra ou esta 3 meses sem compra    //
                //-----------------------------------------------------------------------------//
//                // Cria o objeto de conexão
//                $db = Zend_Registry::get("db");
//                //crio a query para verificar se o usuário tem alguma compra que não seja cancelada
//                $select_compra = "SELECT
//                                    date_format(max(dt_compra_coso), '%Y-%m-%d') as ultima_compra,
//                                    count(*) as total_compra
//                                FROM
//                                    compras
//                                WHERE
//                                    st_compra_coso <> 'C'
//                                AND
//                                    NR_SEQ_CADASTRO_COSO = '".$usuarios->idperfil."'";
//                // die($select_compra_mes);
//                //executo a query
//                $query_compra = $db->query($select_compra);
//
//                //crio uma varivel que recebe a primeira compra ou fica vazia
//                $dadosCompra = $query_compra->fetchAll();
//
//                $data_limite = '2014-07-01';
//
//                if(($dadosCompra[0]['ultima_compra'] <= $data_limite || $dadosCompra[0]['total_compra'] == 1) && $ja_tem_brinde == 0){
//                    //se tiver apenas 1
//                    if ($item['quantidade'] == 1){
//                            //se tiver um de preco cheio
//                            if($tem_cheio == 1){
//
//                                    //agora vejo se e camiseta
//                                    if($data_carrinho[$key]["destaque"] == 2){
//
//                                            //atribuo a mensagem para o carrinho
//                                            $msg_promo = "Compre 1 camiseta de preço cheio (R$69) e ganhe outra com a tag sale (para segunda compra e cadastro com +3 meses sem compra)";
//                                            //agora assino a mensagem a promo
//                                            $sessao_promo->msg = $msg_promo;
//
//                                            $this->view->promo_sale = 1;
//
//                                            //agora vejo se e camiseta
//                                            if($item["tipo"] == 6 and $ja_tem_brinde == 0){
//                                                    //defino os valores como 0
//                                                    $data_carrinho[$key]['vl_promo'] = 0;
//                                                    $data_carrinho[$key]['valor'] = 0;
//                                                    //falo que ele ja ganhou um brinde
//                                                    $ja_tem_brinde = 1;
//                                                    //agora atribuo como verdadeiro a sessao de primeira compra
//                                                    $sessao_promo->sale2 = 1;
//                                                    $sessao_promo->brinde = 1;
//
//                                            }
//                                    }
//                            }
//                    }
//                }


                /**
                 * Promo Boleto - Pagou com boleto ganha Sale - Sale Free
                 */

//                if(!empty($paymentSelected)) {
//                    if(!empty($data_carrinho[$key]['vl_promo'])) {
//                        if($paymentSelected == 'boleto') {
//                            if(!empty($sem_promo_recur) && $sem_promo_recur >= 2) {
//                                //agora vejo se e camiseta
//                                if($data_carrinho[$key]["destaque"] == 2){
//                                    //atribuo a mensagem para o carrinho
//                                    $msg_promo = "Na compra de 2(duas) camisetas(59,00), ganhe uma camiseta grátis com a Tag Sale!";
//                                    //agora assino a mensagem a promo
//                                    $sessao_promo->msg = $msg_promo;
//
//                                    $this->view->promo_sale = 1;
//
//                                    //agora vejo se e camiseta
//                                    if($item["tipo"] == 6 and $ja_tem_brinde == 0){
//                                        //defino os valores como 0
//                                        $vlr_desconto = $data_carrinho[$key]['vl_promo'];
//                                        $data_carrinho[$key]['vl_promo'] = 0;
//                                        $data_carrinho[$key]['valor'] = 0;
//                                        //falo que ele ja ganhou um brinde
//                                        $ja_tem_brinde = 1;
//                                        //agora atribuo como verdadeiro a sessao sale
//                                        $sessao_promo->sale = 1;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }

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
//                        if ($valor_cheio >= 59) {
                        if ($valor_cheio) {
                            $tem_cheio = 1;
                        }
                    }
                } else {

//                    if ($data_carrinho[$key]["tipo"] == 142) {
//
//
//                        //jogo o valor do produto na variavel
//                        $valor = $data_carrinho[$key]['valor'] * 0.7;
//                        //jogo o valor do produto na variavel de produto cheio
//                        $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//                        $carrinho->produtos[$key]['valor'] = $valor;
//                    } else {
//                        if ($data_carrinho[$key]["destaque"] == 2) {
//
//                            //jogo o valor do produto na variavel
//                            $valor = $data_carrinho[$key]['valor'] * 0.7;
//                            //jogo o valor do produto na variavel de produto cheio
//                            $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//                            $carrinho->produtos[$key]['valor'] = $valor;
//                        } else {
//                            //jogo o valor do produto na variavel
//                            $valor = $data_carrinho[$key]['valor'] * 0.7;
//                            //jogo o valor do produto na variavel de produto cheio
//                            $valor_cheio = $data_carrinho[$key]['valor'] * 0.7;
//                            $carrinho->produtos[$key]['valor'] = $valor;
//                        }
//                    }

                    $valor = $data_carrinho[$key]['valor'] * 0.6;
                    $valor_cheio = $data_carrinho[$key]['valor'] * 0.6;
                    $carrinho->produtos[$key]['valor'] = $valor;

                    // Se o preço promocional for menor que o com desconto
                    if ($data_carrinho[$key]['vl_promo'] > 0 && $valor > $data_carrinho[$key]['vl_promo']) {
                        $valor = $data_carrinho[$key]['vl_promo'];
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        $carrinho->produtos[$key]['valor'] = $data_carrinho[$key]['vl_promo'];
                    }

                    if ($data_carrinho[$key]['codigo'] == 5745) {
                        $valor = $data_carrinho[$key]['valor'];
                        $valor_cheio = $data_carrinho[$key]['valor'];
                        $carrinho->produtos[$key]['valor'] = $data_carrinho[$key]['valor'];
                    }

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
                //$carrinho->produtos[$key]['total_produto'] = $valor;
//                $data_carrinho[$key]['valor_total_desconto'] = 0;
//                $carrinho->produtos[$key]['valor_total_desconto'] = 0;
                // Busca os créditos referente a primeira compra
                $model_creditos = new Default_Model_Contascorrente();
                $select_credito = $model_creditos->select()
                        //digo a tabela e os campos que vou precisar
                        ->from("contacorrente", array("NR_SEQ_CONTA_CRSA",
                            "VL_LANCAMENTO_CRSA"))
                        //coloco todas as condições necessárias
                        ->where("TP_LANCAMENTO_CRSA = 'C'")
                        ->where("NR_SEQ_CADASTRO_CRSA = ?", $usuarios->idperfil)
                        ->where("VL_LANCAMENTO_CRSA > 0")
                        ->where("DT_VENCIMENTO_CRSA >= NOW()")
                        ->where("DS_OBSERVACAO_CRSA LIKE 'Crédito de % gerado pela compra %'")
                        ->where('ST_EXPIRADO_CRSA = "N"');
                $creditos = $model_creditos->fetchRow($select_credito);

                // Busca os créditos gerado pelo admin
                $model_creditos = new Default_Model_Contascorrente();
                $select_credito = $model_creditos->select()
                        //digo a tabela e os campos que vou precisar
                        ->from("contacorrente", array("NR_SEQ_CONTA_CRSA",
                            "VL_LANCAMENTO_CRSA"))
                        //coloco todas as condições necessárias
                        ->where("TP_LANCAMENTO_CRSA = 'C'")
                        ->where("NR_SEQ_CADASTRO_CRSA = ?", $usuarios->idperfil)
                        ->where("VL_LANCAMENTO_CRSA > 0")
                        ->where("DT_VENCIMENTO_CRSA >= NOW()")
                        ->where("DS_OBSERVACAO_CRSA NOT LIKE 'Crédito de % gerado pela compra %'")
                        ->where('ST_EXPIRADO_CRSA = "N"');
                $creditos2 = $model_creditos->fetchRow($select_credito);

//                if ($valor_cheio >= 59 and $data_carrinho[$key]['vl_promo'] == 0) {
                if ($data_carrinho[$key]['vl_promo'] == 0) {
                    $data_hoje = date("Y-m-d");

                    if ($creditos->VL_LANCAMENTO_CRSA > 0) {
                        if ($creditos->VL_LANCAMENTO_CRSA <= $valor and ! isset($sobraCredito)) {
                            $valor = $valor - $creditos->VL_LANCAMENTO_CRSA;
                            $data_carrinho[$key]['valor_total_desconto'] = $valor;
                            $carrinho->produtos[$key]['valor_total_desconto'] = $valor;

                            $sessao_promo->valor_desconto += $creditos->VL_LANCAMENTO_CRSA;

                            //coloco na sessao
                            $sessao_frete->idconta = $creditos->NR_SEQ_CONTA_CRSA;
                            $sobraCredito = 0;
                        } else {
                            if (!isset($sobraCredito)) {
                                $sobraCredito = $valor - $creditos->VL_LANCAMENTO_CRSA;
                                $sobraCredito = abs($sobraCredito);

                                $sessao_promo->valor_desconto += $valor;

                                $valor = 0;
                                $data_carrinho[$key]['valor_total_desconto'] = $valor;
                                $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                            } else {
                                if ($sobraCredito <= $valor) {
                                    $sessao_promo->valor_desconto += $sobraCredito;
                                    $valor = $valor - $sobraCredito;
                                    $sobraCredito = 0;
                                } else {
                                    $sessao_promo->valor_desconto += 5;
                                    $sobraCredito = $valor - $sobraCredito;
                                    $sobraCredito = abs($sobraCredito);
                                    $valor = 0;
                                }
                                $data_carrinho[$key]['valor_total_desconto'] = $valor;
                                $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                            }

                            //coloco na sessao
                            $sessao_frete->idconta = $creditos->NR_SEQ_CONTA_CRSA;
                        }
                        $this->view->valorCredito = $creditos->VL_LANCAMENTO_CRSA;
                    } elseif ($creditos2->VL_LANCAMENTO_CRSA > 0) {
                        if ($creditos2->VL_LANCAMENTO_CRSA <= $valor and ! isset($sobraCredito)) {
                            $valor = $valor - $creditos2->VL_LANCAMENTO_CRSA;
                            $data_carrinho[$key]['valor_total_desconto'] = $valor;
                            $carrinho->produtos[$key]['valor_total_desconto'] = $valor;

                            $sessao_promo->valor_desconto += $creditos2->VL_LANCAMENTO_CRSA;

                            //coloco na sessao
                            $sessao_frete->idconta = $creditos2->NR_SEQ_CONTA_CRSA;
                            $sobraCredito = 0;
                        } else {
                            if (!isset($sobraCredito)) {
                                $sobraCredito = $valor - $creditos2->VL_LANCAMENTO_CRSA;
                                $sobraCredito = abs($sobraCredito);

                                $sessao_promo->valor_desconto += $valor;

                                $valor = 0;
                                $data_carrinho[$key]['valor_total_desconto'] = $valor;
                                $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                            } else {
                                if ($sobraCredito <= $valor) {
                                    $sessao_promo->valor_desconto += $sobraCredito;
                                    $valor = $valor - $sobraCredito;
                                    $sobraCredito = 0;
                                } else {
                                    $sessao_promo->valor_desconto += 5;
                                    $sobraCredito = $valor - $sobraCredito;
                                    $sobraCredito = abs($sobraCredito);
                                    $valor = 0;
                                }
                                $data_carrinho[$key]['valor_total_desconto'] = $valor;
                                $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                            }

                            //coloco na sessao
                            $sessao_frete->idconta = $creditos2->NR_SEQ_CONTA_CRSA;
                        }
                        $this->view->valorCredito = $creditos2->VL_LANCAMENTO_CRSA;
                    } else {
                        if ($sessao_promo->primeira != 1 and $sessao_promo->niver != 1) {
                            $data_carrinho[$key]['valor_total_desconto'] = $valor;
                            $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                        }
                    }
                } else {
                    if ($creditos2->VL_LANCAMENTO_CRSA > 0) {
                        if ($creditos2->VL_LANCAMENTO_CRSA <= $valor and ! isset($sobraCredito)) {
                            $valor = $valor - $creditos2->VL_LANCAMENTO_CRSA;
                            $data_carrinho[$key]['valor_total_desconto'] = $valor;
                            $carrinho->produtos[$key]['valor_total_desconto'] = $valor;

                            $sessao_promo->valor_desconto += $creditos2->VL_LANCAMENTO_CRSA;

                            //coloco na sessao
                            $sessao_frete->idconta = $creditos2->NR_SEQ_CONTA_CRSA;
                            $sobraCredito = 0;
                        } else {
                            if (!isset($sobraCredito)) {
                                $sobraCredito = $valor - $creditos2->VL_LANCAMENTO_CRSA;
                                $sobraCredito = abs($sobraCredito);

                                $sessao_promo->valor_desconto += $valor;

                                $valor = 0;
                                $data_carrinho[$key]['valor_total_desconto'] = $valor;
                                $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                            } else {
                                if ($sobraCredito <= $valor) {
                                    $sessao_promo->valor_desconto += $sobraCredito;
                                    $valor = $valor - $sobraCredito;
                                    $sobraCredito = 0;
                                } else {
                                    $sessao_promo->valor_desconto += 5;
                                    $sobraCredito = $valor - $sobraCredito;
                                    $sobraCredito = abs($sobraCredito);
                                    $valor = 0;
                                }
                                $data_carrinho[$key]['valor_total_desconto'] = $valor;
                                $carrinho->produtos[$key]['valor_total_desconto'] = $valor;
                            }

                            //coloco na sessao
                            $sessao_frete->idconta = $creditos->NR_SEQ_CONTA_CRSA;
                        }
                        $this->view->valorCredito = $creditos2->VL_LANCAMENTO_CRSA;
                    }
                }

                //pra carrinho da sessao
                $carrinho->produtos[$key]['total_produto'] = $valor;

                //atribuo o valor total do carrinho
                $valor_total += $valor;
            }

            if ($usuarios->email == 'campana@reverbcity.com') {
//                Zend_Debug::dump($valor_total); exit;
            }

            if ($credito_proxima_compra > 0) {
                $sessao_promo->creditos = $credito_proxima_compra;
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

                //se existir promo boleto
//                if(!empty($paymentSelected)) {
//                    $sessao_frete->valor = $this->view->frete;
//                    $sessao_frete->valor_desconto = $vlr_desconto;
//                    //se for json
//                    if ($this->_request->getParam('json')) {
//                        //crio um array com mensagem do json
//                        $data_json = array('valor_desconto' => $vlr_desconto,
//                            'erro' => false,
//                            'msg_erro' => $sessao_promo->msg);
//                        //assino o json
//                        $this->_helper->json($data_json);
//                    }
//                }
//
//
//                if(empty($paymentSelected) && !empty($selecPayment)) {
//                    $sessao_frete->valor_desconto = 0;
//                    $sessao_frete->valor = $this->view->frete;
//                    //crio um array com mensagem do json
//                    $data_json = array('valor_desconto' => 0,
//                        'erro' => false,
//                        'msg_erro' => $sessao_promo->msg);
//                    //assino o json
//                    $this->_helper->json($data_json);
//                }

                // se existir um cupom informado
                if ($cupom != "") {
                    $sessao_frete->valor = $this->view->frete;

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
                    //if(empty($this->_request->getParam('selecPayment'))) {
                        if ($this->_request->getParam('json')) {
                            //crio um array com mensagem do json
                            $data_json = array('valor_desconto' => 0,
                                'erro' => true,
                                'msg_erro' => 'Por favor insira um cupom / vale presente válido');
                            //assino o json
                            $this->_helper->json($data_json);
                        }
                    //}
                    //mensagem de retorno para o usuario
                    $messages->error = "Por favor insira um cupom / vale presente válido.";
                    // Redireciona para a última página
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $sessao_frete->valor = null;
                $this->view->frete = null;
            }

            if ($sessao_promo->primeira == 1 or $sessao_promo->niver == 1) {
                $valor_desconto = $valor_total * 0.15;
                if ($sessao_promo->niver == true) {
                    $this->view->compra_niver = 1;
                    $sessao_frete->valor_desconto = $valor_desconto;
                } elseif ($sessao_promo->primeira) {
                    $sessao_frete->valor_desconto = $valor_desconto;
                }
            }

            /*
              //inicio a função de creditos dos parceiros
             */

            //agora verifico se trouxe algum resultado ou se existe valor
//            if ($creditos->VL_LANCAMENTO_CRSA > 0) {
//                //atribuo o desconto do cupom
//                $valor_desconto = $creditos->VL_LANCAMENTO_CRSA;
//                //coloco na sessao
//                $sessao_frete->valor_desconto = $valor_desconto;
//                //coloco na sessao
//                $sessao_frete->idconta = $creditos->NR_SEQ_CONTA_CRSA;
//                //se for json
//                if ($this->_request->getParam('json')) {
//                    //crio um array com mensagem do json
//                    $data_json = array('valor_desconto' => $valor_desconto,
//                        'erro' => false,
//                        'msg_erro' => '');
//                    //assino o json
//                    $this->_helper->json($data_json);
//                }
//            }


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

            $this->view->frete_valor = $sessao_frete->valor;

            //botao comprar mais
            $this->view->btn_comprar_mais = ($sem_promo_recur >= 2)? 'sale' : 'todos-produtos';
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
    public function pagamentoAction() {
        
    }

    /**
     * 
     */
    public function novoEnderecoAction() {

        $return = array();
        $return['status'] = FALSE;

        $usuarios = new Zend_Session_Namespace("usuarios");

        if ($usuarios->logado && $usuarios->idperfil) {
            $dados = $this->_request->getParams();

            $modelEndereco = new Default_Model_Enderecosentrega();

            $data = array();
            $data['NR_SEQ_CADASTRO_ENRC'] = $usuarios->idperfil;
            $data['DS_DESTINATARIO_ENRC'] = $dados['endereco_nome'];
            $data['DS_ENDERECO_ENRC'] = $dados['endereco_endereco'];
            $data['DS_NUMERO_ENRC'] = $dados['endereco_numero'];
            $data['DS_COMPLEMENTO_ENRC'] = $dados['endereco_complemento'];
            $data['DS_BAIRRO_ENRC'] = $dados['endereco_bairro'];
            $data['DS_CEP_ENRC'] = $dados['endereco_cep'];
            $data['DS_CIDADE_ENRC'] = $dados['endereco_cidade'];
            $data['DS_UF_ENRC'] = $dados['endereco_estado'];

            if (!empty($dados['endereco_id'])) {
                $modelEndereco->update($data, array('NR_SEQ_ENDERECO_ENRC = ?' => $dados['endereco_id']));
                $endereco_id = $dados['endereco_id'];
            } else {
                $endereco_id = $modelEndereco->insert($data);
            }

            $return['endereco_id'] = $endereco_id;
            $return['status'] = TRUE;
        }

        $this->_helper->json($return);
    }

    public function listaEnderecoAction() {
        $return = array();
        $return['status'] = FALSE;

        $usuarios = new Zend_Session_Namespace("usuarios");

        if ($usuarios->logado && $usuarios->idperfil) {
            $dados = $this->_request->getParams();

            $modelEndereco = new Default_Model_Enderecosentrega();
            $dadosEndereco = $modelEndereco->fetchRow(array('NR_SEQ_ENDERECO_ENRC = ?' => $dados['endereco_id']));

            $return['endereco'] = $dadosEndereco ? $dadosEndereco->toArray() : array();
            $return['status'] = TRUE;
        }

        $this->_helper->json($return);
    }

}
