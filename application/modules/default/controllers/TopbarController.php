<?php

class TopbarController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->_helper->layout()->disableLayout();
        $isMobile = (bool) $this->_request->getParam('isMobile', false);

        //$this->_helper->viewRenderer->setNoRender(true);
        if ($isMobile) {
            $this->render('topbar-mobile');
            return;
        }

        $this->render('topbar');
    }
}
