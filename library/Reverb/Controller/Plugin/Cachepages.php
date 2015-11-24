<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 11/23/15
 * Time: 2:11 AM
 */

class Reverb_Controller_Plugin_Cachepages extends Zend_Controller_Plugin_Abstract {

    protected $domain;

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

        $options = $bootstrap->getOptions();

        $this->setDomain($options);

        $key = $this->domain . $_SERVER['REQUEST_URI'];
        $optionsMemcached = $options['resources']['cachemanager']['memcached']['backend'];
        $cache = $this->getCache($optionsMemcached);

        if ($request->getParam('noCache')) {
            return;
        }
        $load = $cache->get($key);

        if (isset($load[0])) {
            return;
        }

        // CARREGA A PAGINA
        $output = $this->loadPage($options);

        $cache->set($key, $output, $optionsMemcached['lifetime']);
    }

    private function setDomain($config)
    {
        $prefix = '';
        if ((bool) $config['Reverb']['config']['ssl'] && strpos($config['Reverb']['config']['domain'], 'wwww') === false) {
            $prefix = 'www.';
        }

        $this->domain = $prefix . $config['Reverb']['config']['domain'];
    }

    protected function loadPage($config)
    {
        $scheme = (bool) $config['Reverb']['config']['ssl'] ? 'https' : 'http';
        $uri =  $_SERVER['REQUEST_URI'];
        if (!empty($_SERVER['QUERY_STRING'])) {
            $uri .= $_SERVER['QUERY_STRING'] . '&' . 'noCache=true';
        } else {
            $uri .= '?noCache=true';
        }
        $url = $scheme . '://' . $this->domain . $uri;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    /**
     * @param $config
     * @return \Memcached
     */
    protected function getCache($config)
    {
        $cache = new \Memcached();
        $cache->setOption(\Memcached::OPT_COMPRESSION, false);

        foreach ($config['options']['servers'] as $server) {
            $cache->addServer($server['host'], $server['port']);
        }

        return $cache;
    }

} 