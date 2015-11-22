<?php

class AjaxcacheController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->disableLayout();
    }

    public function topAction()
    {
        $isMobile = false;
        $iphone = (bool) strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $android = (bool) strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        $palmpre = (bool) strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
        $berry = (bool) strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
        $ipod = (bool) strpos($_SERVER['HTTP_USER_AGENT'], "iPod");

        //se for mobile eu vou assinar uma variavel para identificar e remover um menu
        if ($iphone || $android || $palmpre || $ipod || $iPad || $berry == true) {
            //se entrar e porque e dispositivo movel e assino ao view como true
            $isMobile = true;

        }
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
