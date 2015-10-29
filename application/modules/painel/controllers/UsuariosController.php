<?php

/**
 *
 */
class Painel_UsuariosController extends Reverb_Controller_Action {

    public function init() {
        // Inicializa o model da tela
        $this->_model = new Default_Model_Usuarios();

        // Chama o parent
        parent::init();
    }

    public function loginAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(TRUE);

        // Busca a instancia do zend_auth
        $auth = Zend_Auth::getInstance();


        // Verifica se ja está logado
        if($auth->hasIdentity()) {
            $this->_helper->redirector(NULL, NULL, "painel");
        }

        // Cria as sessões
        $session = new Zend_Session_Namespace("login");
        $messages = new Zend_Session_Namespace("messages");

        // Verifica se tem dados vindo do formulario
        if($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getPost();

            // Busca as informações do login
            $login = $data["login"];
            $senha = $data["senha"];

            // Busca a instancia de Zend_Auth
            $objAuth = Zend_Auth::getInstance();
            $authAdapter = new Zend_Auth_Adapter_DbTable(
                Zend_Registry::get("db"),
                "usuarios",
                "DS_LOGIN_USRC",
                "DS_SENHA_USRC",
                "?"
            );

            // Define os dados para processar o login
            $authAdapter->setIdentity($login)
                ->setCredential($senha);

            // Efetua o login
            $result = $objAuth->authenticate($authAdapter);




            // Verifica se o login está correto
            if($result->isValid()) {

                // Armazena os dados do usuário em sessão, apenas desconsiderando a senha do usuário
                $info = $authAdapter->getResultRowObject(NULL, "senha");
                $objAuth->getStorage()->write($info);

                // Busca as informações do usuario
                $usuario_row = $this->_model->fetchRow(array("DS_LOGIN_USRC = ?" => $login));


                // Converte para array
                $usuario_array = $usuario_row->toArray();

                // Adiciona as informações à sessão
                $session->logged_usuario = $usuario_array;

                // Redireciona o usuario
                $this->_helper->redirector(NULL, NULL, "painel");
            }
            else {
                // Armazena o erro
                $messages->error = "Os dados informados (e-mail e/ou senha) não são válidos.";

                // Dados inválidos
                $this->_helper->redirector(NULL, NULL, "painel");
            }
        }
    }

    public function logoutAction(){
        Zend_Auth::getInstance()->clearIdentity();

        $this->_helper->redirector(NULL, NULL, "painel");
    }
}