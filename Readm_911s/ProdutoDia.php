<?php

/**
 * Created by PhpStorm.
 * User: alecio
 * Date: 11/04/16
 * Time: 22:45
 */
require_once 'DBConnection.php';
require_once 'RVBMemcached.php';

class ProdutoDia
{
    private $strMsgLog;
    public $boolClearMemCached = false;
    public $setLog = false;
    public $DB;
    private $setEnv = 'development : production';

    public function __construct($strSetDB = false)
    {
        $strSetDB = (!empty($strSetDB))? $strSetDB : $this->setEnv;
        $this->DB = new DBConnection($strSetDB);
        $this->setLog = true;
    }

    /**
     * Pega Produto do dia
     *
     * @param null $strSetAtivar
     * @return mixed
     */
    public function getProdutoDia($strSetAtivar = null) {
        try {

            $strSql = 'SELECT NR_SEQ_AGENDAMENTO_BARC,  NR_SEQ_PRODUTO_BARC, VL_PROMOATUAL_BARC, VL_NOVOVALOR_BARC, DS_FRETEGRATUAL_BARC, DS_FRETEGRATIS_BARC, DATE_FORMAT(DT_PUBLICACAO_BARC,\'%Y-%m-%d\') FROM banners_agendados ';

            if(empty($strSetAtivar))
                $strWhere = ' WHERE ST_ATUAL_BARC = \'S\' ';
            else
                $strWhere = ' WHERE ST_ATUAL_BARC = \'N\' AND DAY(DT_PUBLICACAO_BARC) = DAY(now()) AND MONTH(DT_PUBLICACAO_BARC) = MONTH(now()) AND YEAR(DT_PUBLICACAO_BARC) = YEAR(now())';

            $strOrderBy = ' ORDER BY DT_PUBLICACAO_BARC DESC ';

            $strLimit = ' LIMIT 1';

            $strExec = $strSql . $strWhere . $strOrderBy . $strLimit;

            $objResult = $this->DB->prepare($strExec);
            $objResult->execute();

            return $objResult->fetchObject(__CLASS__);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * executa todas as funçoes
     */
    public function exec() {

        $this->printLog('inicio');
        $objProdutoDia = $this->getProdutoDia();
        $this->printLog('msg', 'Total de Produtos Ativos" : ' . count($objProdutoDia));

        if(!empty($objProdutoDia)) {
            $objDatePublicacao = new DateTime($objProdutoDia->DT_PUBLICACAO_BARC);

            $strDatePublicacao = $objDatePublicacao->format("Y-m-d");
            $strDateNow = date("Y-m-d");

            $this->printLog('msg', 'Data de Publicao VS Data Hoje: ' . $strDatePublicacao . ' x ' . $strDateNow);

            //if($strDatePublicacao != $strDateNow) {
                $this->setPromoAntigo($objProdutoDia->NR_SEQ_PRODUTO_BARC, $objProdutoDia->VL_PROMOATUAL_BARC, $objProdutoDia->DS_FRETEGRATUAL_BARC);
                $this->setBannersAgendados($objProdutoDia->NR_SEQ_AGENDAMENTO_BARC, 'N');
            //} else
            //    $this->printLog('msg', 'Não foi possivel setar valores de produtos antigos e novos banners pois a data de publicação do banner atual é a mesma de hoje: ' . $strDatePublicacao . ' x ' . $strDateNow);
        }

        $objProdutoDiaNovo = $this->getProdutoDia(true);
        $this->printLog('msg', 'Total Produtos a serem ativados: ' . count($objProdutoDia));

        if(!empty($objProdutoDiaNovo)) {
            $this->setProdutoDia($objProdutoDiaNovo->NR_SEQ_PRODUTO_BARC, $objProdutoDiaNovo->VL_NOVOVALOR_BARC, $objProdutoDiaNovo->DS_FRETEGRATIS_BARC);
            $this->setBannersAgendados($objProdutoDiaNovo->NR_SEQ_AGENDAMENTO_BARC, 'S');
        }else
            $this->printLog('msg', 'Não foram econtrados produtos novos a Serem Setados');

//        if(!empty($this->clearMemCached)) {
//            $memcached = new RVBMemcached();
//            $memcached->flushCache();
//        }
        $this->printLog('fim');
    }

    /**
     * @param $intCodProd
     * @param $vlrPromoAntigo
     * @param $strFreteGratis
     */
    private function setProdutoDia($intCodProd, $vlrPromoNovo, $strFreteGratis) {
        try {
            $this->printLog('msg', 'Setando novo Produto dia: .' . $intCodProd);

            $strSQL = 'UPDATE `produtos`
                SET `VL_PROMO_PRRC` = :vlrPromoNovo, `DS_FRETEGRATIS_PRRC` = :strFreteGratis
                WHERE `NR_SEQ_PRODUTO_PRRC`= :intCodProd';

            $statement = $this->DB->prepare($strSQL);
            $statement->bindValue(":vlrPromoNovo", $vlrPromoNovo);
            $statement->bindValue(":strFreteGratis", $strFreteGratis);
            $statement->bindValue(":intCodProd", $intCodProd);
            $result = $statement->execute();

            if($result)
                $this->printLog('msg', 'COD Produto: ' . $intCodProd .  ' Setando Preço Promocional, ' . $vlrPromoNovo . ' Frete Gratis?: ' . $strFreteGratis);

        } catch (PDOException $e) {
            $this->printLog('msg', 'Algo deu errado ao setar preço novo produto: ' . $intCodProd);
            $this->printLog('msg', 'Exception: ' . $e->getMessage());
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * @param $intCodProd
     * @param $vlrPromoAntigo
     * @param $strFreteGratis
     */
    private function setPromoAntigo($intCodProd, $vlrPromoAntigo, $strFreteGratis) {

        try {
            $this->printLog('msg', 'Retirando valores do produto...' . $intCodProd);

            $strSQL = 'UPDATE `produtos`
                SET `VL_PROMO_PRRC` = :vlrPromoAntigo, `DS_FRETEGRATIS_PRRC` = :strFreteGratis
                WHERE `NR_SEQ_PRODUTO_PRRC`= :intCodProd';

            $statement = $this->DB->prepare($strSQL);
            $statement->bindValue(":vlrPromoAntigo", $vlrPromoAntigo);
            $statement->bindValue(":strFreteGratis", $strFreteGratis);
            $statement->bindValue(":intCodProd", $intCodProd);
            $result = $statement->execute();

            if($result)
                $this->printLog('msg', 'COD Produto: ' . $intCodProd .  ' Setando Preço Promocional Anterior: , ' . $vlrPromoAntigo . ' Frete Gratis?: ' . $strFreteGratis);
        } catch (PDOException $e) {
            $this->printLog('msg', 'Algo deu errado ao setar preço antigo do produto: ' . $intCodProd);
            $this->printLog('msg', 'Exception: ' . $e->getMessage());
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * @param $intCodAgendamento
     */
    private function setBannersAgendados($intCodAgendamento, $strStatus) {

        try {
            $this->printLog('msg', 'Alterando Banners Agendados');
            $this->printLog('msg', 'Cod Agendamento' . $intCodAgendamento . 'Novo Status Agendamento: ' . $strStatus);

            $strSQL = 'UPDATE `banners_agendados`
                SET `ST_ATUAL_BARC` = :strStatus
                WHERE `NR_SEQ_AGENDAMENTO_BARC`= :intCodAgendamento';

            $statement = $this->DB->prepare($strSQL);
            $statement->bindValue(":intCodAgendamento", $intCodAgendamento);
            $statement->bindValue(":strStatus", $strStatus);
            $result = $statement->execute();

            if($result)
                $this->printLog('msg', 'Alterado' . $intCodAgendamento . 'Novo Status Agendamento: ' . $strStatus);

        } catch (PDOException $e) {
            $this->printLog('msg', 'Algo deu errado ao alterar o Status de Agendamento: ' . $intCodAgendamento);
            $this->printLog('msg', 'Exception: ' . $e->getMessage());
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    private function printLog($strLocal = false, $strMsgLog = false) {
        if($this->setLog)
            $this->setLog($strLocal, $strMsgLog);
    }

    private function setLog($strLocal = false, $strMsgLog = false) {

        $strVarFN = "|----------------------------------------------------------------------|" . PHP_EOL;

        $strRetun = '';

        switch ($strLocal) {
            case 'inicio':
                $strRetun = $strVarFN . substr_replace($strVarFN, '   INICIO    ', 30, -30);
                break;
            case 'fim':
                $strRetun = substr_replace($strVarFN, '    FIM      ', 30, -30) . $strVarFN;
                break;
            case 'bar':
                $strRetun = $strVarFN;
                break;
            case 'msg':
                $strRetun = '-   ' . utf8_decode($strMsgLog) . PHP_EOL;
        }
        echo $strRetun;
    }
}