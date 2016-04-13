<?php

/**
 * Created by PhpStorm.
 * User: alecio
 * Date: 11/04/16
 * Time: 22:49
 */
class DBConnection extends PDO
{
    public $getenv = 'development : production';

    private $host;
    private $dbname;
    private $user;
    private $pass;
    private $localFileConfig = '../application/configs/application.ini';

    public function __construct()
    {

        $this->setDbConfig();

        try {
            parent::__construct("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
        } catch (PDOException $e) {
            echo 'Erro ao conectar ao Banco de Dados: ' . $e->getMessage();
        }
    }

    private function setDbConfig()
    {
        $this->host = $this->getDBConfig('resources.db.params.host');
        $this->user = $this->getDBConfig('resources.db.params.username');
        $this->pass = $this->getDBConfig('resources.db.params.password');
        $this->dbname = $this->getDBConfig('resources.db.params.dbname');
    }

    private function getDBConfig($strOpt = null)
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
}