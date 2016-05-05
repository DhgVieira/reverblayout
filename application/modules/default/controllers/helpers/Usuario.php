<?php

class Zend_Controller_Action_Helper_Usuario extends Zend_Controller_Action_Helper_Abstract
{
    private $ObjUser;

    public function userSession() {
        $this->ObjUser = new Zend_Session_Namespace("usuarios");
    }

    public function isLogado() {
        $this->userSession();
        if(isset($this->ObjUser->logado) && $this->ObjUser->logado)
            return $this->ObjUser->idperfil;
        return;
    }

    public function getUser() {
        if($this->isLogado())
            return $this->ObjUser;
        return;
    }

    public function getEmail() {
        if($this->getUser())
            return $this->ObjUser->email;
    }
}