<?php

/**
 *
 */
class Painel_ClienteController extends Reverb_Controller_Action {

    /**
     *
     */
    public function init(){

    }

    /**
     *
     */
    public function indexAction(){

        if($this->_request->isPost()){
            $termo = $this->_request->getParam('termo');
            if(!empty($termo)){
                $this->_redirect('/painel/cliente/index/busca/' . $termo);
            }else{
                $this->_redirect('/painel/cliente/');
            }
        }

        $modelCliente = new Default_Model_Reverbme();
        $selectCliente = $modelCliente->select()
            ->from(array('c' => 'cadastros'), array())
            ->columns(array(
                'NR_SEQ_CADASTRO_CASO',
                'DS_NOME_CASO',
                'DS_EMAIL_CASO',
                'DS_DDDFONE_CASO',
                'DS_FONE_CASO',
                'DS_CEP_CASO',
                'DS_CIDADE_CASO',
                'DS_UF_CASO',
                'ST_CADASTRO_CASO'
            ))
            ->order('NR_SEQ_CADASTRO_CASO DESC');

        $busca = $this->_request->getParam('busca');

        if(!empty($busca)){
            $selectCliente->where('DS_NOME_CASO LIKE "%' . str_replace(' ', '%', addslashes($busca)) . '%"')
                ->orWhere('DS_EMAIL_CASO LIKE "%' . str_replace(' ', '%', addslashes($busca)) . '%"')
                ->orWhere('DS_CPFCNPJ_CASO LIKE "%' . addslashes($busca) . '%"');

            $this->view->busca = $busca;
        }

        $current_page = $this->_request->getParam("page", 1);
        $dadosCliente = new Reverb_Paginator($selectCliente);
        $dadosCliente->setItemCountPerPage(25)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $this->view->dadosCliente = $dadosCliente;
    }

    /**
     *
     */
    public function formAction(){
        $id = $this->_request->getParam('id');

        if(!empty($id)){
            $modelCliente = new Default_Model_Reverbme();
            $modelEnderecos = new Default_Model_Enderecosentrega();

            if($this->_request->isPost()){
                $messages = new Zend_Session_Namespace("messages");
                try{
                    $dadosPost = $this->_request->getParams();

                    unset($dadosPost['module']);
                    unset($dadosPost['controller']);
                    unset($dadosPost['action']);
                    unset($dadosPost['id']);

                    $dadosPost['DT_NASCIMENTO_CASO'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_NASCIMENTO_CASO'])));
                    $dadosPost['DS_CEP_CASO'] = str_replace('.','', str_replace('-', '', $dadosPost['DS_CEP_CASO']));

                    $dataCliente['DS_NOME_CASO']        = $dadosPost['DS_NOME_CASO'];
                    $dataCliente['DS_EMAIL_CASO']       = $dadosPost['DS_EMAIL_CASO'];
                    $dataCliente['DS_ENDERECO_CASO']    = $dadosPost['DS_ENDERECO_CASO'];
                    $dataCliente['DS_NUMERO_CASO']      = $dadosPost['DS_NUMERO_CASO'];
                    $dataCliente['DS_COMPLEMENTO_CASO'] = $dadosPost['DS_COMPLEMENTO_CASO'];
                    $dataCliente['DS_BAIRRO_CASO']      = $dadosPost['DS_BAIRRO_CASO'];
                    $dataCliente['DS_CIDADE_CASO']      = $dadosPost['DS_CIDADE_CASO'];
                    $dataCliente['DS_UF_CASO']          = $dadosPost['DS_UF_CASO'];
                    $dataCliente['DS_CEP_CASO']         = $dadosPost['DS_CEP_CASO'];
                    $dataCliente['DT_NASCIMENTO_CASO']  = $dadosPost['DT_NASCIMENTO_CASO'];
                    $dataCliente['DS_CPFCNPJ_CASO']     = $dadosPost['DS_CPFCNPJ_CASO'];
                    $dataCliente['DS_TIPO_CASO']        = $dadosPost['DS_TIPO_CASO'];
                    $dataCliente['DS_DDDFONE_CASO']     = $dadosPost['DS_DDDFONE_CASO'];
                    $dataCliente['DS_FONE_CASO']        = $dadosPost['DS_FONE_CASO'];
                    $dataCliente['DS_DDDCEL_CASO']      = $dadosPost['DS_DDDCEL_CASO'];
                    $dataCliente['DS_CELULAR_CASO']     = $dadosPost['DS_CELULAR_CASO'];
                    $dataCliente['DS_SENHA_CASO']       = $dadosPost['DS_SENHA_CASO'];
                    $dataCliente['DS_TWITTER_CACH']     = $dadosPost['DS_TWITTER_CACH'];
                    $dataCliente['DS_FACEBOOK_CACH']    = $dadosPost['DS_FACEBOOK_CACH'];

                    $modelCliente->update($dataCliente, array('NR_SEQ_CADASTRO_CASO = ?' => $id));

                    foreach($dadosPost['NR_SEQ_ENDERECO_ENRC'] as $key => $enderecoId){
                        $dataEndereco = array();
                        $dataEndereco['DS_DESTINATARIO_ENRC']   = $dadosPost['DS_DESTINATARIO_ENRC'][$key];
                        $dataEndereco['DS_ENDERECO_ENRC']       = $dadosPost['DS_ENDERECO_ENRC'][$key];
                        $dataEndereco['DS_NUMERO_ENRC']         = $dadosPost['DS_NUMERO_ENRC'][$key];
                        $dataEndereco['DS_COMPLEMENTO_ENRC']    = $dadosPost['DS_COMPLEMENTO_ENRC'][$key];
                        $dataEndereco['DS_BAIRRO_ENRC']         = $dadosPost['DS_BAIRRO_ENRC'][$key];
                        $dataEndereco['DS_CEP_ENRC']            = str_replace('.','', str_replace('-', '', $dadosPost['DS_CEP_ENRC'][$key]));
                        $dataEndereco['DS_CIDADE_ENRC']         = $dadosPost['DS_CIDADE_ENRC'][$key];
                        $dataEndereco['DS_UF_ENRC']             = $dadosPost['DS_UF_ENRC'][$key];

                        $modelEnderecos->update($dataEndereco, array('NR_SEQ_ENDERECO_ENRC = ?' => $enderecoId));
                    }

                    $messages->success = 'Cliente alterado com sucesso.';
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }catch (Exception $e){
                    Zend_Debug::dump($e->getMessage()); exit;
                    $messages->error = 'Erro ao alterar cliente.';
                    $this->_redirect($_SERVER['HTTP_REFERER']);
                }
            }else{
                $selectCliente = $modelCliente->select()
                    ->from(array('c' => 'cadastros'), array())
                    ->columns(array(
                        'DS_NOME_CASO',
                        'DS_EMAIL_CASO',
                        'DS_ENDERECO_CASO',
                        'DS_NUMERO_CASO',
                        'DS_COMPLEMENTO_CASO',
                        'DS_BAIRRO_CASO',
                        'DS_CIDADE_CASO',
                        'DS_UF_CASO',
                        'DS_CEP_CASO',
                        'DT_NASCIMENTO_CASO',
                        'DS_CPFCNPJ_CASO',
                        'DS_TIPO_CASO',
                        'DS_DDDFONE_CASO',
                        'DS_FONE_CASO',
                        'DS_DDDCEL_CASO',
                        'DS_CELULAR_CASO',
                        'DS_SENHA_CASO',
                        'DS_TWITTER_CACH',
                        'DS_FACEBOOK_CACH'
                    ))
                    ->where('NR_SEQ_CADASTRO_CASO = ?', $id);
                $dadosCliente = $modelCliente->fetchRow($selectCliente);

                $dadosEnderecos = $modelEnderecos->fetchAll(array('NR_SEQ_CADASTRO_ENRC = ?' => $id));

                $this->view->dadosEnderecos = $dadosEnderecos;
                $this->view->dadosCliente = $dadosCliente;
            }
        }else{
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     *
     */
    public function desativarAction(){
        $id = $this->_request->getParam('id');
        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)) {
            try{
                $modelCliente = new Default_Model_Reverbme();
                $modelCliente->update(array('ST_CADASTRO_CASO' => 'I'), array('NR_SEQ_CADASTRO_CASO = ?' => $id));

                $messages->success = 'Cliente desativado com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch(Exception $e){
                $messages->error = 'Ocorreu um erro ao desativar o cliente.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }

        }else{
            $messages->error = "Ocorreu um erro ao desativar o usuário.";
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     *
     */
    public function ativarAction(){
        $id = $this->_request->getParam('id');
        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)) {
            $modelCliente = new Default_Model_Reverbme();

            try{
                $modelCliente->update(array('ST_CADASTRO_CASO' => 'A'), array('NR_SEQ_CADASTRO_CASO = ?' => $id));

                $messages->success = 'Cliente ativado com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch(Exception $e){
                $messages->error = 'Ocorreu um erro ao ativar o cliente.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }

        }
        die();
    }
}