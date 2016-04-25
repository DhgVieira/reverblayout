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

    /**
     * DBConnection constructor.
     */
    public function __construct($setEnv = false)
    {
        $this->getenv = (!empty($setEnv))? $setEnv : $this->getenv;
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

    /**
     * Seta as variv
     */
    private function setDbConfig()
    {
        $this->host = $this->getDBConfig('resources.db.params.host');
        $this->user = $this->getDBConfig('resources.db.params.username');
        $this->pass = $this->getDBConfig('resources.db.params.password');
        $this->dbname = $this->getDBConfig('resources.db.params.dbname');
    }

    /**
     * @param null $strOpt
     * @return array
     */
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

    private function getUserByLogin() {

    }

    /**
     * Grava Logs do Sistema
     *
     * @param $intCoduser
     * @param $strScript
     * @param $strDsAcao
     */
    public function setLog($intCoduser = null, $strScript = null, $strDsAcao = null){

        try {

            $strSQL = 'INSERT INTO `logs_adm` `NR_SEQ_LOGIN_LOSO` = :intCoduser, `DT_ACESSO_LOSO` = :srtDate, DS_SCRIPT_LOSO = :strScript, DS_ACAO_LOSO = :strDsAcao, DS_IP_LOSO = :strIpUser';

            //INSERT INTO `reverb_amazon`.`logs_adm` (`NR_SEQ_LOGIN_LOSO`, `DT_ACESSO_LOSO`, `DS_SCRIPT_LOSO`, `DS_ACAO_LOSO`) VALUES ('0', 'now()', 'teste.php', 'teste de teste');

            $strIpUser = $_SERVER["REMOTE_ADDR"];
            $statement = $this->prepare($strSQL);
            $statement->bindValue(":strScript", $strScript);
            $statement->bindValue(":strDsAcao", $strDsAcao);
            $statement->bindValue(":strIpUser", $strIpUser);
            $statement->bindValue(":strDate",  date('Y-m-d H:i:s'));
            $result = $statement->execute();

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}