<?php
/**
 * Created by PhpStorm.
 * User: Alecio
 * Date: 25/11/15
 *
 *
 * *************************************
 * DATE: 25-04-2016
 * INCLUSAO DE CONFIG VIA APPLICATION.INI
 */
class RVBMemcached {

    public $host;
    public $port;
    private $localFileConfig = '../application/configs/application.ini';

    public $getenv = 'production';

    private $objMemcached;
    private $intDelay;

    /**
     * RVBMemcached constructor.
     * @param int $persistent_id [optional]
     * @param bool $setEnv
     */
    public function __construct($intDelay = 0, $setEnv = false)
    {
        try {
            $this->getenv = (!empty($setEnv))? $setEnv : $this->getenv;
            $this->setCacheConfig();

            $this->objMemcached = new Memcached();
            $this->objMemcached->addServer($this->host, $this->port);
            $this->intDelay = $intDelay;
        } catch (PDOException $e) {
            echo 'Erro ao iniciar Mencached: ' . $e->getMessage();
        }
    }

    /**
     * Seta as variv
     */
    private function setCacheConfig()
    {
        $this->host = $this->getCacheConfig('resources.cachemanager.memcached.backend.options.servers.one.host');
        $this->port = $this->getCacheConfig('resources.cachemanager.memcached.backend.options.servers.one.port');
    }

    /**
     * @param null $strOpt
     * @return array
     */
    private function getCacheConfig($strOpt = null)
    {
        $arrConfig = parse_ini_file($this->localFileConfig, true);
        $arrReturn = array();

        if (empty($strOpt))
            $arrReturn = $arrConfig[$this->getenv];
        else {
            $arrReturn = $arrConfig[$this->getenv][$strOpt];
        }

        return $arrReturn;
    }

    /**
     * @param bool $intDelay
     */
    public function flushCached($intDelay = false) {
        $this->intDelay = (!empty($intDelay))? $intDelay : $this->intDelay;
        $this->flush($this->intDelay);
    }
}