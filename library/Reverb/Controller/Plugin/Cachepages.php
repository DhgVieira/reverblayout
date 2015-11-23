<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 11/23/15
 * Time: 2:11 AM
 */

class Reverb_Controller_Plugin_Cachepages extends Zend_Controller_Plugin_Abstract {


    protected function getRoutesAllowedCache() {
        return array(
            'default-index-index',
            'default-index-inicio',
            'default-loja-todos-produtos',
            'default-loja-sale',
            'default-loja-novidades',
            'default-loja-masculino',
            'default-loja-feminino',
            'default-loja-casa',
            'default-loja-produto',
            'default-index-imprensa',
            'default-index-quemsomos',
        );
    }

    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {

        $route = $request->getModuleName() . '-' . $request->getControllerName() . '-' . $request->getActionName();
        $routes = $this->getRoutesAllowedCache();
        if (!in_array($route, $routes)) {
            return;
        }
        $front = Zend_Controller_Front::getInstance();
        /**
         * @var $bootstrap \Bootstrap
         */
        $bootstrap = $front->getParam("bootstrap");

        $registry = Zend_Registry::getInstance();

        /* @var \Zend_Cache_Core $cache*/
        $cache = $registry->get('cacheMemcached');
        $options = $bootstrap->getOptions();

        $key = $options['Reverb']['config']['domain'] . $_SERVER['REQUEST_URI'];


        if ($cache->load($key)) {
            return;
        }

        /* @var Smarty $view*/
        $smarty = $registry->get('view')->getEngine();

        $tpl = current($smarty->template_objects)->template_resource;

        $output = $smarty->fetch($tpl);

        $cache->save($output, $key, array(), 3600);
    }


} 