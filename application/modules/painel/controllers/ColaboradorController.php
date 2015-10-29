<?php

/**
 *
 */
class Painel_ColaboradorController extends Reverb_Controller_Action
{

    /**
     *
     */
    public function init()
    {

    }

    /**
     *
     */
    public function indexAction()
    {
        if($this->_request->isPost()){
            $termo = $this->_request->getParam('termo');

            if(!empty($termo)){
                $this->_redirect('/painel/colaborador/index/busca/' . $termo);
            }else{
                $this->_redirect('/painel/colaborador/');
            }
        }

        $modelUsuarios = new Default_Model_Usuarios();
        $selectUsuarios = $modelUsuarios->select()
            ->from(array('u' => 'usuarios'), array())
            ->columns(array(
                'NR_SEQ_USUARIO_USRC',
                'DS_LOGIN_USRC',
                'DS_EMAIL_USRC',
                'ST_STATUS_USRC'
            ))
            ->where('DS_EMAIL_USRC IS NOT NULL');

        $busca = $this->_request->getParam('busca');

        if(!empty($busca)){
            $selectUsuarios->where('DS_LOGIN_USRC LIKE "%' . addslashes($busca) . '%"')
                ->orWhere('DS_EMAIL_USRC LIKE "%' . addslashes($busca) . '%"');

            $this->view->busca = $busca;
        }

        $current_page = $this->_request->getParam("page", 1);
        $dadosUsuarios = new Reverb_Paginator($selectUsuarios);
        $dadosUsuarios->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $this->view->dadosUsuarios = $dadosUsuarios;
    }

    /**
     *
     */
    public function ativarAction(){
        $id = $this->_request->getParam('id');

        if(!empty($id)){
            $messages = new Zend_Session_Namespace("messages");

            try{

                $modelUsuarios = new Default_Model_Usuarios();
                $modelUsuarios->update(array('ST_STATUS_USRC' => 'A'), array('NR_SEQ_USUARIO_USRC = ?' => $id));

                $messages->success = "Usuário ativado com sucesso.";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch (Exception $e){
                $messages->error = "Ocorreu um erro ao ativar o usuário.";
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
                $modelUsuarios = new Default_Model_Usuarios();
                $modelUsuarios->update(array('ST_STATUS_USRC' => 'I'), array('NR_SEQ_USUARIO_USRC = ?' => $id));

                $messages->success = "Usuário desativado com sucesso.";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch (Exception $e){
                $messages->error = "Ocorreu um erro ao desativar o usuário.";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $messages->error = "Ocorreu um erro ao desativar o usuário.";
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }
}