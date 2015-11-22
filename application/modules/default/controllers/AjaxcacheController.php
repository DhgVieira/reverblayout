<?php

class AjaxcacheController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->disableLayout();
    }

    public function topAction()
    {
        $isMobile = (bool) $this->_request->getParam('isMobile', false);

        if ($isMobile) {
            $this->render('topbarmobile');
        } else {
            $this->render('topbar');
        }
    }

    public function sidebarAction()
    {
        $this->render('sidebar');
    }
}
