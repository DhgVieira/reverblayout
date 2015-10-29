<?php

/**
 *
 */
class Painel_LojistasController extends Reverb_Controller_Action {
    /**
     *
     */
    public function init() {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
    }

    /**
     *
     */
    public function indexAction() {
    }

    /**
     *
     */
    public function tiposAction() {

        $this->view->crumb = "Relatórios > Gerais";
        $this->view->pageName = "Tipos Liberados";

    }
}

