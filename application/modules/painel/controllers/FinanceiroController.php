<?php

/**
 *
 */
class Painel_FinanceiroController extends Reverb_Controller_Action {
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
        $modelLancamento = new Default_Model_Lancamento();
        $selectLancamento = $modelLancamento->select()
            ->from(array('l' => 'lancamento'), array())
            ->columns(array(
                'l.DT_VENCIMENTO_LARC',
                'VL_PAGO' => 'SUM(VL_VALOR_LARC) * DS_NUMERO_PARCELA_LARC',
                'VL_TOTAL' => 'SUM(VL_VALOR_LARC * NR_PARCELAS_LARC)'
            ))
            ->group('l.DT_VENCIMENTO_LARC')
            ->order('l.DT_VENCIMENTO_LARC ASC');
        $dadosLancamento = $modelLancamento->fetchAll($selectLancamento)->toArray();

        foreach($dadosLancamento as $key => $lancamento){
            $selectLancamento = $modelLancamento->select()
                ->from(array('l' => 'lancamento'))
                ->join(array('b' => 'banco'), 'b.NR_SEQ_BANCO_BARC = l.NR_BANCO_LARC', array('DS_BANCO_BARC'))
                ->join(array('f' => 'fornecedor'), 'f.NR_SEQ_FORNECEDOR_FORC = l.NR_FORNECEDOR_LARC', array('DS_FANTASIA_FORC'))
                ->where('DT_VENCIMENTO_LARC = ?', $lancamento['DT_VENCIMENTO_LARC'])
                ->setIntegrityCheck(false);
            $dadosLancamento[$key]['lancamentos'] = $modelLancamento->fetchAll($selectLancamento)->toArray();
        }

        $this->view->dadosLancamento = $dadosLancamento;
    }

    /**
     *
     */
    public function categoriasSubcategoriasAction() {
    }

    /**
     *
     */
    public function fornecedoresAction() {

        if($this->_request->isPost()){
            $busca = $this->_request->getParam('busca');
            if(!empty($busca)){
                $this->_redirect('/painel/financeiro/fornecedores/termo/'.$busca);
            }else{
                $this->_redirect('/painel/financeiro/fornecedores');
            }

        }

        $termo = $this->_request->getParam('termo');

        $modelFornecedor = new Default_Model_Fornecedor();

        $selectFornecedor = $modelFornecedor->select()
            ->from(array('f' => 'fornecedor'));

        if(!empty($termo)){
            $selectFornecedor->where("f.DS_FANTASIA_FORC LIKE '%$termo%'")
                ->orWhere("f.DS_RAZAO_FORC LIKE '%$termo%'")
                ->orWhere("f.DS_EMAIL_FORC LIKE '%$termo%'")
                ->orWhere("f.DS_CONTATO_FORC LIKE '%$termo%'")
                ->orWhere("f.DS_FAVORECIDO_FORC LIKE '%$termo%'");

            $this->view->termo = $termo;

        }

        $dadosFornecedor = $modelFornecedor->fetchAll($selectFornecedor);
        $this->view->dadosFornecedor = $dadosFornecedor;
    }

    /**
     *
     */
    public function editarFornecedorAction(){
        $id = $this->_request->getParam('id');

        if(!empty($id)){
            $modelFornecedor = new Default_Model_Fornecedor();
            $dadosFornecedor = $modelFornecedor->fetchRow(array('NR_SEQ_FORNECEDOR_FORC = ?' => $id));
            $this->view->dadosFornecedor = $dadosFornecedor;

            if($this->_request->isPost()){
                $dadosPost = $this->_request->getParams();

                unset($dadosPost['module']);
                unset($dadosPost['controller']);
                unset($dadosPost['action']);
                unset($dadosPost['id']);

                $modelFornecedor->update($dadosPost, array('NR_SEQ_FORNECEDOR_FORC = ?' => $id));

                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    /**
     *
     */
    public function novoFornecedorAction() {

        if($this->_request->isPost()){
            $dadosPost = $this->_request->getParams();

            try{
                unset($dadosPost['module']);
                unset($dadosPost['controller']);
                unset($dadosPost['action']);

                $modelFornecedor = new Default_Model_Fornecedor();
                $modelFornecedor->insert($dadosPost);

                $this->_redirect('/painel/financeiro/fornecedores');
            }catch (Exception $e){
                die($e->getMessage());
            }
        }

    }

    /**
     *
     */
    public function novoLancamentoAction() {
        $modelFornecedor = new Default_Model_Fornecedor();
        $dadosFornecedor = $modelFornecedor->fetchAll();
        $this->view->dadosFornecedor = $dadosFornecedor;

        $modelBanco = new Default_Model_Banco();
        $dadosBanco = $modelBanco->fetchAll(array('NR_ATIVO_BARC = ?' => 1));
        $this->view->dadosBanco = $dadosBanco;

        if($this->_request->isPost()){
            try {
                $messages = new Zend_Session_Namespace('messages');

                $dadosPost = $this->_request->getParams();

                unset($dadosPost['module']);
                unset($dadosPost['controller']);
                unset($dadosPost['action']);

                $dadosPost['DT_EMISSAO_LARC']       = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_EMISSAO_LARC'])));
                $dadosPost['DT_VENCIMENTO_LARC']    = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_VENCIMENTO_LARC'])));

                $dadosPost['VL_VALOR_LARC'] = str_replace('R$ ', '', $dadosPost['VL_VALOR_LARC']);

                $dadosPost['DS_NUMERO_PARCELA_LARC'] = 1;

                $modelLancamento = new Default_Model_Lancamento();

                $idLancamento = $modelLancamento->insert($dadosPost);

                if($dadosPost['DS_REPETIR_LARC'] == 1){
                    switch ($dadosPost['NR_PERIODO_LARC']) {
                        case 1:
                            $qtdPeriodo = 1;
                            $tipoPeriodo = 'days';
                            break;
                        case 2:
                            $qtdPeriodo = 1;
                            $tipoPeriodo = ' week';
                            break;
                        case 3:
                            $qtdPeriodo = 15;
                            $tipoPeriodo = ' days';
                            break;
                        case 4:
                            $qtdPeriodo = 1;
                            $tipoPeriodo = ' month';
                            break;
                        case 5:
                            $qtdPeriodo = 6;
                            $tipoPeriodo = ' month';
                            break;
                        case 6:
                            $qtdPeriodo = 1;
                            $tipoPeriodo = ' years';
                            break;
                    }

                    for($i = 1; $i < $dadosPost['NR_PARCELAS_LARC']; $i++){
                        $dataProximoLancamento                              = array();
                        $dataProximoLancamento['NR_FORNECEDOR_LARC']        = $dadosPost['NR_FORNECEDOR_LARC'];
                        $dataProximoLancamento['NR_BANCO_LARC']             = $dadosPost['NR_BANCO_LARC'];
                        $dataProximoLancamento['NR_CATEGORIA_LARC']         = $dadosPost['NR_CATEGORIA_LARC'];
                        $dataProximoLancamento['NR_CLASSIFICACAO_LARC']     = $dadosPost['NR_CLASSIFICACAO_LARC'];
                        $dataProximoLancamento['DT_EMISSAO_LARC']           = $dadosPost['DT_EMISSAO_LARC'];
                        $dataProximoLancamento['DT_VENCIMENTO_LARC']        = date('Y-m-d', strtotime($dadosPost['DT_VENCIMENTO_LARC'] . ' +' . (($i) * $qtdPeriodo) . $tipoPeriodo));
                        $dataProximoLancamento['NR_PARCELAS_LARC']          = $dadosPost['NR_PARCELAS_LARC'];
                        $dataProximoLancamento['NR_PERIODO_LARC']           = $dadosPost['NR_PERIODO_LARC'];
                        $dataProximoLancamento['VL_VALOR_LARC']             = $dadosPost['VL_VALOR_LARC'];
                        $dataProximoLancamento['DS_REPETIR_LARC']           = $dadosPost['DS_REPETIR_LARC'];
                        $dataProximoLancamento['DS_OBS_LARC']               = $dadosPost['DS_OBS_LARC'];
                        $dataProximoLancamento['NR_LANCAMENTOPAI_LARC']     = $idLancamento;
                        $dataProximoLancamento['DS_NUMERO_PARCELA_LARC']    = $i+1;

                        $modelLancamento->insert($dataProximoLancamento);
                    }
                }

                $messages->success = 'Lançamento criado com sucesso';

                $this->_redirect('/painel/financeiro/editar-lancamento/id/'.$idLancamento);
            } catch (Exception $e) {
                $messages->error = 'Ocorreu um erro ao cadastrar o lançamento';
            }

        }
    }

    /**
     *
     */
    public function editarLancamentoAction(){
        $idLancamento = $this->_request->getParam('id');

        if(!empty($idLancamento)){
            $modelFornecedor = new Default_Model_Fornecedor();
            $dadosFornecedor = $modelFornecedor->fetchAll();
            $this->view->dadosFornecedor = $dadosFornecedor;

            $modelBanco = new Default_Model_Banco();
            $dadosBanco = $modelBanco->fetchAll(array('NR_ATIVO_BARC = ?' => 1));
            $this->view->dadosBanco = $dadosBanco;

            $modelLancamento = new Default_Model_Lancamento();
            $dadosLancamento = $modelLancamento->fetchRow(array('NR_SEQ_LANCAMENTO_LARC = ?' => $idLancamento));
            $this->view->dadosLancamento = $dadosLancamento;

            $dadosLancamentoFuturo = $modelLancamento->fetchAll(array('NR_LANCAMENTOPAI_LARC = ?' => $dadosLancamento->NR_LANCAMENTOPAI_LARC ? $dadosLancamento->NR_LANCAMENTOPAI_LARC : $idLancamento, 'DT_VENCIMENTO_LARC > ?' => $dadosLancamento->DT_VENCIMENTO_LARC));
            $this->view->dadosLancamentoFuturo = $dadosLancamentoFuturo;

            if($this->_request->isPost()){
                try {
                    $messages = new Zend_Session_Namespace('messages');

                    $dadosPost = $this->_request->getParams();

                    unset($dadosPost['module']);
                    unset($dadosPost['controller']);
                    unset($dadosPost['action']);
                    unset($dadosPost['id']);

                    $dadosPost['DT_EMISSAO_LARC']       = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_EMISSAO_LARC'])));
                    $dadosPost['DT_VENCIMENTO_LARC']    = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_VENCIMENTO_LARC'])));

                    $dadosPost['VL_VALOR_LARC'] = str_replace('R$ ', '', $dadosPost['VL_VALOR_LARC']);

                    $modelLancamento->update($dadosPost, array('NR_SEQ_LANCAMENTO_LARC = ?' => $idLancamento));

                    $messages->success = 'Lançamento editado com sucesso';

                    $this->_redirect('/painel/financeiro/editar-lancamento/id/'.$idLancamento);
                } catch (Exception $e) {
                    $messages->error = 'Ocorreu um erro ao editar o lançamento';
                }

            }
        }
    }

    /**
     *
     */
    public function bancosAction(){
        $modelBanco = new Default_Model_Banco();

        if($this->_request->isPost()){
            $busca = $this->_request->getParam('busca');
            if(!empty($busca)){
                $this->_redirect('/painel/financeiro/bancos/termo/'.$busca);
            }else{
                $this->_redirect('/painel/financeiro/bancos');
            }

        }

        $termo = $this->_request->getParam('termo');

        $selectBanco = $modelBanco->select()
            ->from('banco')
            ->where('NR_ATIVO_BARC = 1');

        if(!empty($termo)){
            $selectBanco->where('DS_BANCO_BARC LIKE "%'.addslashes($termo).'%"');

            $this->view->busca = $termo;
        }

        $dadosBanco = $modelBanco->fetchAll($selectBanco);

        $this->view->dadosBanco = $dadosBanco;
    }

    /**
     *
     */
    public function editarBancoAction(){
        $idBanco = $this->_request->getParam('id');

        if(!empty($idBanco)){
            $modelBanco = new Default_Model_Banco();
            $dadosBanco = $modelBanco->fetchRow(array('NR_SEQ_BANCO_BARC = ?' => $idBanco));
            $this->view->dadosBanco = $dadosBanco;

            if($this->_request->isPost()){
                try {
                    $messages = new Zend_Session_Namespace('messages');

                    $dadosPost = $this->_request->getParams();

                    unset($dadosPost['module']);
                    unset($dadosPost['controller']);
                    unset($dadosPost['action']);
                    unset($dadosPost['id']);

                    $modelBanco->update($dadosPost, array('NR_SEQ_BANCO_BARC = ?' => $idBanco));

                    $messages->success = 'Banco editado com sucesso';
                    $this->_redirect('/painel/financeiro/editar-banco/id/'.$idBanco);
                } catch (Exception $e) {
                    $messages->error = 'Ocorreu um erro ao editar o banco';
                }
            }
        }
    }

    /**
     *
     */
    public function novoBancoAction(){
        if($this->_request->isPost()){
            try {
                $modelBanco = new Default_Model_Banco();

                $messages = new Zend_Session_Namespace('messages');

                $dadosPost = $this->_request->getParams();

                unset($dadosPost['module']);
                unset($dadosPost['controller']);
                unset($dadosPost['action']);
                unset($dadosPost['id']);

                $idBanco = $modelBanco->insert($dadosPost);

                $messages->success = 'Banco criado com sucesso';
                $this->_redirect('/painel/financeiro/editar-banco/id/'.$idBanco);
            } catch (Exception $e) {
                $messages->error = 'Ocorreu um erro ao criar o banco';
            }
        }
    }

    /**
     *
     */
    public function removerBancoAction(){
        $idBanco = $this->_request->getParam('id');

        if(!empty($idBanco)){
            $messages = new Zend_Session_Namespace('messages');

            try{
                $modelBanco = new Default_Model_Banco();
                $modelBanco->update(array('NR_ATIVO_BARC' => 0), array('NR_SEQ_BANCO_BARC = ?' => $idBanco));

                $messages->success = 'Banco removido com sucesso';
            }catch(Exception $e){
                $messages->error = 'Ocorreu um erro ao excluir o banco';
            }

            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }
}

