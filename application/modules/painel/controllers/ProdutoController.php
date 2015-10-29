<?php

/**
 *
 */
class Painel_ProdutoController extends Reverb_Controller_Action {
    /**
     *
     */
    public function init() {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
        date_default_timezone_set('America/Sao_Paulo');
    }

    /**
     *
     */
    public function indexAction() {

        if($this->_request->isPost()){
            $termo = $this->_request->getParam('termo');
            if(!empty($termo)){
                $this->_redirect('/painel/produto/index/busca/' . $termo);
            }else{
                $this->_redirect('/painel/produto/');
            }
        }

        $modelProduto = new Default_Model_produtos();
        $selectProduto = $modelProduto->select()
            ->from(array('p' => 'produtos'), array())
            ->joinInner(array('pt' => 'produtos_tipo'), 'NR_SEQ_CATEGPRO_PTRC = NR_SEQ_TIPO_PRRC', array())
            ->joinInner(array('pc' => 'produtos_categoria'), 'NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC', array())
            ->columns(array(
                'p.NR_SEQ_PRODUTO_PRRC',
                'p.DT_CADASTRO_PRRC',
                'pt.DS_CATEGORIA_PTRC',
                'pc.DS_CATEGORIA_PCRC',
                'p.DS_REFERENCIA_PRRC',
                'p.DS_PRODUTO_PRRC',
                'p.VL_PRODUTO_PRRC',
                'p.ST_PRODUTOS_PRRC',
                'estoque' => '(SELECT COALESCE(SUM(NR_QTDE_ESRC), 0) FROM estoque e WHERE e.NR_SEQ_PRODUTO_ESRC = p.NR_SEQ_PRODUTO_PRRC)'
            ))
            ->order('p.DT_CADASTRO_PRRC DESC')
            ->where('DS_CLASSIC_PRRC = "N"')
            ->setIntegrityCheck(false);

        $busca = $this->_request->getParam('busca');
        if(!empty($busca)){
            $selectProduto->where(
                'NR_SEQ_PRODUTO_PRRC = "'. addslashes($busca).'"
                OR DS_REFERENCIA_PRRC = "'. addslashes($busca) .'"
                OR DS_PRODUTO_PRRC LIKE "%'. addslashes($busca) .'%"');

            $this->view->busca = $busca;
        }

        $current_page = $this->_request->getParam("page", 1);
        $dadosProduto = new Reverb_Paginator($selectProduto);
        $dadosProduto->setItemCountPerPage(25)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $this->view->dadosProduto = $dadosProduto;
    }

    /**
     *
     */
    public function ativarAction(){
        $id = $this->_request->getParam('id');
        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)){
            try{
                $modelProduto = new Default_Model_produtos();
                $modelProduto->update(array('ST_PRODUTOS_PRRC' => 'A'), array('NR_SEQ_PRODUTO_PRRC = ?' => $id));

                $messages->success = 'Produto ativado com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch (Exception $e){
                $messages->error = 'Erro ao ativar o produto.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }

    }

    /**
     *
     */
    public function desativarAction(){
        $id = $this->_request->getParam('id');
        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)){
            try{
                $modelProduto = new Default_Model_produtos();
                $modelProduto->update(array('ST_PRODUTOS_PRRC' => 'I'), array('NR_SEQ_PRODUTO_PRRC = ?' => $id));

                $messages->success = 'Produto desativado com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch (Exception $e){
                $messages->error = 'Erro ao desativar o produto.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    /**
     *
     */
    public function moverClassicAction(){
        $id = $this->_request->getParam('id');
        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)){
            try{
                $modelProduto = new Default_Model_produtos();
                $modelProduto->update(array('DS_CLASSIC_PRRC' => 'S'), array('NR_SEQ_PRODUTO_PRRC = ?' => $id));

                $messages->success = 'Produto movido com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch (Exception $e){
                $messages->error = 'Erro ao mover o produto.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    /**
     *
     */
    public function moverProdutoAction(){
        $id = $this->_request->getParam('id');
        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)){
            try{
                $modelProduto = new Default_Model_produtos();
                $modelProduto->update(array('DS_CLASSIC_PRRC' => 'N'), array('NR_SEQ_PRODUTO_PRRC = ?' => $id));

                $messages->success = 'Produto movido com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch (Exception $e){
                $messages->error = 'Erro ao mover o produto.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }



    /**
     *
     */
    public function classicsAction() {

        if($this->_request->isPost()){
            $termo = $this->_request->getParam('termo');
            if(!empty($termo)){
                $this->_redirect('/painel/produto/index/busca/' . $termo);
            }else{
                $this->_redirect('/painel/produto/');
            }
        }

        $modelProduto = new Default_Model_produtos();
        $selectProduto = $modelProduto->select()
            ->from(array('p' => 'produtos'), array())
            ->joinInner(array('pt' => 'produtos_tipo'), 'NR_SEQ_CATEGPRO_PTRC = NR_SEQ_TIPO_PRRC', array())
            ->joinInner(array('pc' => 'produtos_categoria'), 'NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC', array())
            ->columns(array(
                'p.NR_SEQ_PRODUTO_PRRC',
                'p.DT_CADASTRO_PRRC',
                'pt.DS_CATEGORIA_PTRC',
                'pc.DS_CATEGORIA_PCRC',
                'p.DS_REFERENCIA_PRRC',
                'p.DS_PRODUTO_PRRC',
                'p.VL_PRODUTO_PRRC',
                'p.ST_PRODUTOS_PRRC',
                'estoque' => '(SELECT COALESCE(SUM(NR_QTDE_ESRC), 0) FROM estoque e WHERE e.NR_SEQ_PRODUTO_ESRC = p.NR_SEQ_PRODUTO_PRRC)'
            ))
            ->order('p.DT_CADASTRO_PRRC DESC')
            ->where('DS_CLASSIC_PRRC = "S"')
            ->setIntegrityCheck(false);

        $busca = $this->_request->getParam('busca');
        if(!empty($busca)){
            $selectProduto->where(
                'NR_SEQ_PRODUTO_PRRC = "'. addslashes($busca).'"
                OR DS_REFERENCIA_PRRC = "'. addslashes($busca) .'"
                OR DS_PRODUTO_PRRC LIKE "%'. addslashes($busca) .'%"');

            $this->view->busca = $busca;
        }

        $current_page = $this->_request->getParam("page", 1);
        $dadosProduto = new Reverb_Paginator($selectProduto);
        $dadosProduto->setItemCountPerPage(25)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $this->view->dadosProduto = $dadosProduto;
    }


    public function tiposProdutosAction(){
        
    }


    public function novoProdutoAction(){
        $modelProdutoTipo = new Default_Model_Produtotipo();
        $dadosProdutoTipo = $modelProdutoTipo->fetchAll(array('DS_STATUS_PTRC = ?' => 'A'));
        $this->view->dadosProdutoTipo = $dadosProdutoTipo;

        $modelProdutoCategoria = new Default_Model_Produtoscategoria();
        $dadosProdutoCategoria = $modelProdutoCategoria->fetchAll(array('DS_STATUS_PCRC = ?' => 'A'));
        $this->view->dadosProdutoCategoria = $dadosProdutoCategoria;

        $modelModelo = new Default_Model_Modelo();
        $dadosModelo = $modelModelo->fetchAll(array('modelo_ativo = ?' => '1'), 'descricao');
        $this->view->dadosModelo = $dadosModelo;

        $modelCores = new Default_Model_Cores();
        $dadosCores = $modelCores->fetchAll();
        $this->view->dadosCores = $dadosCores;

        if($this->_request->isPost()){
            $messages = new Zend_Session_Namespace('messages');

            $dadosPost = $this->_request->getParams();

            unset($dadosPost['module']);
            unset($dadosPost['controller']);
            unset($dadosPost['action']);

            $dadosPost['VL_PRODUTO_PRRC'] = str_replace(',', '', $dadosPost['VL_PRODUTO_PRRC']);
            $dadosPost['VL_PRODUTO_PRRC'] = str_replace('R$ ', '', $dadosPost['VL_PRODUTO_PRRC']);

            $dadosPost['VL_PRODUTO2_PRRC'] = str_replace(',', '', $dadosPost['VL_PRODUTO2_PRRC']);
            $dadosPost['VL_PRODUTO2_PRRC'] = str_replace('R$ ', '', $dadosPost['VL_PRODUTO2_PRRC']);

            $dadosPost['VL_PROMO_PRRC'] = str_replace(',', '', $dadosPost['VL_PROMO_PRRC']);
            $dadosPost['VL_PROMO_PRRC'] = str_replace('R$ ', '', $dadosPost['VL_PROMO_PRRC']);

            $dadosPost['DS_CLASSIC_PRRC'] = 'N';

            $dadosPost['DT_CADASTRO_PRRC'] = date('Y-m-d H:i:s');

            try {
                $modelProduto = new Default_Model_produtos();
                $idProduto = $modelProduto->insert($dadosPost);

                $messages->success = 'Produto inserido com sucesso.';
            } catch (Exception $e) {
                die($e->getMessage());
            }

            $this->_redirect('/painel/produto/editar-produto/id/'.$idProduto);
        }
    }

    public function editarProdutoAction(){
        $modelProdutoTipo = new Default_Model_Produtotipo();
        $dadosProdutoTipo = $modelProdutoTipo->fetchAll(array('DS_STATUS_PTRC = ?' => 'A'));
        $this->view->dadosProdutoTipo = $dadosProdutoTipo;

        $modelProdutoCategoria = new Default_Model_Produtoscategoria();
        $dadosProdutoCategoria = $modelProdutoCategoria->fetchAll(array('DS_STATUS_PCRC = ?' => 'A'));
        $this->view->dadosProdutoCategoria = $dadosProdutoCategoria;

        $modelModelo = new Default_Model_Modelo();
        $dadosModelo = $modelModelo->fetchAll(array('modelo_ativo = ?' => '1'), 'descricao');
        $this->view->dadosModelo = $dadosModelo;

        $modelCores = new Default_Model_Cores();
        $dadosCores = $modelCores->fetchAll();
        $this->view->dadosCores = $dadosCores;

        $idProduto = $this->_request->getParam('id');

        $modelProduto = new Default_Model_produtos();
        $dadosProduto = $modelProduto->fetchRow(array('NR_SEQ_PRODUTO_PRRC = ?' => $idProduto));
        $this->view->dadosProduto = $dadosProduto;

        $modelFoto = new Default_Model_Foto();
        $dadosFoto = $modelFoto->fetchAll(array('NR_SEQ_PRODUTO_FORC = ?' => $idProduto));
        $this->view->dadosFoto = $dadosFoto;

        if($this->_request->isPost()){
            $messages = new Zend_Session_Namespace('messages');

            $dadosPost = $this->_request->getParams();

            $idProduto = $dadosPost['id'];

            unset($dadosPost['module']);
            unset($dadosPost['controller']);
            unset($dadosPost['action']);
            unset($dadosPost['id']);

            $dadosPost['VL_PRODUTO_PRRC'] = str_replace(',', '', $dadosPost['VL_PRODUTO_PRRC']);
            $dadosPost['VL_PRODUTO_PRRC'] = str_replace('R$ ', '', $dadosPost['VL_PRODUTO_PRRC']);

            $dadosPost['VL_PRODUTO2_PRRC'] = str_replace(',', '', $dadosPost['VL_PRODUTO2_PRRC']);
            $dadosPost['VL_PRODUTO2_PRRC'] = str_replace('R$ ', '', $dadosPost['VL_PRODUTO2_PRRC']);

            $dadosPost['VL_PROMO_PRRC'] = str_replace(',', '', $dadosPost['VL_PROMO_PRRC']);
            $dadosPost['VL_PROMO_PRRC'] = str_replace('R$ ', '', $dadosPost['VL_PROMO_PRRC']);

            try {
                $modelProduto = new Default_Model_produtos();
                $modelProduto->update($dadosPost, array('NR_SEQ_PRODUTO_PRRC = ?' => $idProduto));

                $messages->success = 'Produto editado com sucesso.';
            } catch (Exception $e){
                die($e->getMessage());
            }

            $this->_redirect('/painel/produto/editar-produto/id/'.$idProduto);
        }
    }

    public function vinculaImageAction(){
        $modelFotos = new Default_Model_Foto();

        $dadosPost = $this->_request->getParams();

        $extImg = explode('.', $dadosPost['imgName']);

        $dataFoto['NR_SEQ_PRODUTO_FORC'] = $dadosPost['idProduto'];
        $dataFoto['DS_EXT_FORC'] = $extImg[1];

        $idFoto = $modelFotos->insert($dataFoto);

        rename(APPLICATION_PATH . '/../arquivos/uploads/teste/' . $dadosPost['imgName'], APPLICATION_PATH . '/../arquivos/uploads/fotosprodutos/' . $idFoto . '.' . $extImg[1] );

        echo $idFoto . '.' . $extImg[1];

        exit;
    }

    public function unlinkFotoAction(){
        $imgName = $this->_request->getParam('path');
        $dataImg = explode('.', $imgName);

        $modelFotos = new Default_Model_Foto();
        $modelFotos->delete(array('NR_SEQ_FOTO_FORC = ?' => $dataImg[0], 'DS_EXT_FORC = ?' => $dataImg[1]));

        unlink(APPLICATION_PATH . '/../arquivos/uploads/fotosprodutos/' . $imgName);

        exit;
    }


    public function categoriasAction(){
        
    }

    public function musicasAction(){
        
    }



    /**
     *
     */
    public function produtosInativosAction() {

        if($this->_request->isPost()){
            $termo = $this->_request->getParam('termo');
            if(!empty($termo)){
                $this->_redirect('/painel/produto/index/busca/' . $termo);
            }else{
                $this->_redirect('/painel/produto/');
            }
        }

        $modelProduto = new Default_Model_produtos();
        $selectProduto = $modelProduto->select()
            ->from(array('p' => 'produtos'), array())
            ->joinInner(array('pt' => 'produtos_tipo'), 'NR_SEQ_CATEGPRO_PTRC = NR_SEQ_TIPO_PRRC', array())
            ->joinInner(array('pc' => 'produtos_categoria'), 'NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC', array())
            ->columns(array(
                'p.NR_SEQ_PRODUTO_PRRC',
                'p.DT_CADASTRO_PRRC',
                'pt.DS_CATEGORIA_PTRC',
                'pc.DS_CATEGORIA_PCRC',
                'p.DS_REFERENCIA_PRRC',
                'p.DS_PRODUTO_PRRC',
                'p.VL_PRODUTO_PRRC',
                'p.ST_PRODUTOS_PRRC',
                'estoque' => '(SELECT COALESCE(SUM(NR_QTDE_ESRC), 0) FROM estoque e WHERE e.NR_SEQ_PRODUTO_ESRC = p.NR_SEQ_PRODUTO_PRRC)'
            ))
            ->order('p.DT_CADASTRO_PRRC DESC')
            ->where('DS_CLASSIC_PRRC = "S"')
            ->setIntegrityCheck(false);

        $busca = $this->_request->getParam('busca');
        if(!empty($busca)){
            $selectProduto->where(
                'NR_SEQ_PRODUTO_PRRC = "'. addslashes($busca).'"
                OR DS_REFERENCIA_PRRC = "'. addslashes($busca) .'"
                OR DS_PRODUTO_PRRC LIKE "%'. addslashes($busca) .'%"');

            $this->view->busca = $busca;
        }

        $current_page = $this->_request->getParam("page", 1);
        $dadosProduto = new Reverb_Paginator($selectProduto);
        $dadosProduto->setItemCountPerPage(25)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $this->view->dadosProduto = $dadosProduto;
    }

    public function aviseMeAction(){
        if($this->_request->isPost()){
            $termo = $this->_request->getParam('termo');
            if(!empty($termo)){
                $this->_redirect('/painel/produto/avise-me/busca/' . $termo);
            }else{
                $this->_redirect('/painel/produto/avise-me');
            }
        }

        $busca = $this->_request->getParam('busca');

        $modelAviseMe = new Default_Model_Aviseme();
        $selectProdutoAviseme = $modelAviseMe->select()
            ->from(array('am' => 'aviseme'), array())
            ->join(array('pr' => 'produtos'), 'NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_AVRC', array())
            ->join(array('tm' => 'tamanhos'), 'NR_SEQ_TAMANHO_TARC = NR_SEQ_TAMANHO_AVRC', array())
            ->join(array('es' => 'estoque'), 'NR_SEQ_PRODUTO_ESRC = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC', array())
            ->join(array('pt' => 'produtos_tipo'), 'NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC', array())
            ->columns(array(
                'pr.NR_SEQ_PRODUTO_PRRC',
                'pr.DS_PRODUTO2_PRRC',
                'pr.VL_PRODUTO_PRRC',
                'tm.NR_SEQ_TAMANHO_TARC',
                'tm.DS_TAMANHO_TARC',
                'es.NR_QTDE_ESRC',
                'pt.DS_CATEGORIA_PTRC',
                'qtd' => 'COUNT(*)'
            ))
            ->where('am.ST_AVISO_AVRC = "N"')
            ->where('es.NR_QTDE_ESRC > 0')
            ->group(array(
                'pr.NR_SEQ_PRODUTO_PRRC',
                'am.NR_SEQ_TAMANHO_AVRC'
            ))
            ->order('qtd DESC')
            ->limit(10)
            ->setIntegrityCheck(false);

        if(!empty($busca)){
            $selectProdutoAviseme->where('pr.DS_PRODUTO2_PRRC LIKE "%'.addslashes($busca).'%"');
            $this->view->busca = $busca;
        }

        $dadosProdutos = $modelAviseMe->fetchAll($selectProdutoAviseme)->toArray();

        foreach($dadosProdutos as $key => $produto){
            $selectCliente = $modelAviseMe->select()
                ->from(array('am' => 'aviseme'), array())
                ->columns(array(
                    'am.DS_NOME_AVRC',
                    'am.DS_EMAIL_AVRC',
                    'am.DS_TELEFONE_AVRC',
                    'am.DS_CIDADE_AVRC',
                    'am.DS_UF_AVRC',
                    'am.DT_SOLICITACAO_AVRC'
                ))
                ->where('NR_SEQ_PRODUTO_AVRC = ?', $produto['NR_SEQ_PRODUTO_PRRC'])
                ->where('NR_SEQ_TAMANHO_AVRC = ?', $produto['NR_SEQ_TAMANHO_TARC'])
                ->where('am.ST_AVISO_AVRC = "N"');
            $dadosProdutos[$key]['clientes'] = $modelAviseMe->fetchAll($selectCliente)->toArray();
        }

        $this->view->dadosProdutos = $dadosProdutos;
    }

    public function ordemProdutosAction(){

    }

    public function previsaoProducaoAction(){

        if($this->_request->isPost()){
            $busca = $this->_request->getParam('busca');

            if(!empty($busca)){
                $this->_redirect('/painel/produto/previsao-producao/termo/'.$busca);
            }else{
                $this->_redirect('/painel/produto/previsao-producao');
            }
        }

        $termo = $this->_request->getParam('termo');

        $modelProduto = new Default_Model_produtos();
        $selectProduto = $modelProduto->select()
            ->from(array('p' => 'produtos'), array())
            ->join(array('e' => 'estoque'), 'NR_SEQ_PRODUTO_ESRC = NR_SEQ_PRODUTO_PRRC', array())
            ->columns(array(
                'p.NR_SEQ_PRODUTO_PRRC',
                'total' => 'SUM(e.NR_QTDE_ESRC)',
                'meses_ativo' => 'FORMAT((DATEDIFF(SYSDATE(), p.DT_CADASTRO_PRRC) / 30), 0)',
                'p.DS_PRODUTO2_PRRC'
            ))
            ->where('NR_SEQ_LOJAS_PRRC = 1')
            ->where('NR_SEQ_TIPO_PRRC = 6')
            ->where('DS_CLASSIC_PRRC = "N"')
            ->where('NR_SEQ_PRODUTO_PRRC NOT IN (510 , 528, 517, 604, 652, 706, 745, 1752, 1998, 4530, 379, 2106)')
            ->group('NR_SEQ_PRODUTO_PRRC')
            ->order('NR_TEMPLIXO_PRRC DESC')
            ->setIntegrityCheck(false);

        if(!empty($termo)){
            $selectProduto->where('DS_PRODUTO_PRRC LIKE "'.addslashes($termo).'"');

            $this->view->termo = $termo;
        }

        $dadosProduto = $modelProduto->fetchAll($selectProduto)->toArray();

        $modelCesta = new Default_Model_Cestas();

        foreach($dadosProduto as $key => $produto){
            if($produto['meses_ativo'] >= 12){
                $mesesAtivo = 12;
            }else{
                $mesesAtivo = 1;
            }

            $selectCesta = $modelCesta->select()
                ->from(array('ce' => 'cestas'), array())
                ->join(array('co' => 'compras'), 'NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO', array())
                ->join(array('pr' => 'produtos'), 'NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC', array())
                ->join(array('ta' => 'tamanhos'), 'NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC', array())
                ->columns(array(
                    'total' => 'SUM(ce.NR_QTDE_CESO)',
                    'ta.DS_TAMANHO_TARC',
                    'ce.NR_SEQ_TAMANHO_CESO',
                    'saldo_atual' => "(select NR_QTDE_ESRC from estoque where NR_SEQ_PRODUTO_ESRC = NR_SEQ_PRODUTO_PRRC and NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC)"
                ))
                ->where("ST_COMPRA_COSO <> 'C'")
                ->where("DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL $mesesAtivo MONTH)")
                ->where("NR_SEQ_CADASTRO_COSO <> 8074")
                ->where("NR_SEQ_PRODUTO_CESO = ?", $produto['NR_SEQ_PRODUTO_PRRC'])
                ->group("NR_SEQ_TAMANHO_CESO")
                ->order('NR_ORDEM_TARC')
                ->setIntegrityCheck(false);
            $dadosCesta = $modelCesta->fetchAll($selectCesta)->toArray();

            $mes = array();

            foreach($dadosCesta as $key2 => $cesta){
                $mediaMes = $cesta['total']/$mesesAtivo;
                $mesesSaldo = ceil($cesta['saldo_atual']/$mediaMes);

                $dadosCesta[$key2]['media_mes'] = $mediaMes;
                $dadosCesta[$key2]['meses_saldo'] = $mesesSaldo;

                $primeiroMes = date('n');
                $ultimoMes = date('m', strtotime(date('Y-m-d') . ' +3 months')) * 1;

                $saldoPrevisao = $mesesSaldo;

                for($i = $primeiroMes; $i <= $ultimoMes; $i++){
                    $saldoPrevisao = $saldoPrevisao - $mediaMes;

                    if($saldoPrevisao < 0){
                        $colorClass = 'red';
                    }elseif(($saldoPrevisao - $mediaMes) < 1){
                        $colorClass = 'yellow';
                    }else{
                        $colorClass = 'gray';
                    }

                    $dadosCesta[$key2]['previsao'][$i] = array(
                        'qtd' => $saldoPrevisao,
                        'colorClass' => $colorClass
                    );

                    $mes[$i] += $saldoPrevisao;
                }
            }

            $dadosProduto[$key]['saldoPrevisao'] = $mes;
            $dadosProduto[$key]['cesta'] = $dadosCesta;
        }

        //Zend_Debug::dump($dadosProduto); exit;

        $this->view->dadosProduto = $dadosProduto;
    }


    public function reprintAction(){

    }

    public function enviarSmsAction(){
        $this->_helper->layout()->disableLayout();

        if($this->_request->isPost()){
            $dados = $this->_request->getParams();

            $messages = new Zend_Session_Namespace("messages");

            if(!empty($dados['celular']) && !empty($dados['mensagem'])){
                $sms = new Reverb_Controller_Plugin_Sms();
                $sms->enviarSms($dados['celular'], $dados['mensagem']);

                $messages->success = "SMS enviado com sucesso.";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }else{
                $messages->error = "Erro ao enviar SMS.";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $nome = $this->_request->getParam('nome');
            $celular = $this->_request->getParam('celular');
            $nomeProduto = $this->_request->getParam('nomeproduto');

            $this->view->nome = $nome;
            $this->view->celular = $celular;
            $this->view->nomeProduto = $nomeProduto;
        }
    }

}

