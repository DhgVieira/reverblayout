<?php

/**
 * Created by PhpStorm.
 * User: alecio
 * Date: 11/04/16
 * Time: 22:45
 */
require_once 'DBConnection.php';

class ProdutoDia
{
    public $DB;
    public function __construct()
    {
        $this->DB = new DBConnection();
    }

    public function getProdutoDia($strSetAtivar = null) {
        try {

            $strSql = 'SELECT NR_SEQ_AGENDAMENTO_BARC,  NR_SEQ_PRODUTO_BARC, VL_PROMOATUAL_BARC, VL_NOVOVALOR_BARC, DS_FRETEGRATUAL_BARC FROM banners_agendados ';

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

    public function exec() {
        $objProdutoDia = $this->getProdutoDia();
        if(count($objProdutoDia)) {
            //$this->setPromoAntigo($objProdutoDia->NR_SEQ_PRODUTO_BARC, $objProdutoDia->VL_PROMOATUAL_BARC, $objProdutoDia->DS_FRETEGRATUAL_BARC);
           // $this->setBannersAgendados($objProdutoDia->NR_SEQ_AGENDAMENTO_BARC);
        }
        $objProdutoDiaNovo = $this->getProdutoDia(true);
    }
    /*
     * UPDATE
        produtos
        SET
        VL_PROMO_PRRC = $novo_valor,
        DS_FRETEGRATIS_PRRC = '$st_frete'
        WHERE 
        NR_SEQ_PRODUTO_PRRC = $codigo_produto_new
     */
    private function setProdutoDia($intCodProd, $vlrPromoAntigo, $strFreteGratis) {
        try {
            $strSQL = 'UPDATE `produtos`
                SET `VL_PROMO_PRRC` = :vlrPromoAntigo, `DS_FRETEGRATIS_PRRC` = :strFreteGratis
                WHERE `NR_SEQ_PRODUTO_PRRC`= :intCodProd';

            $statement = $this->DB->prepare($strSQL);
            $statement->bindValue(":vlrPromoAntigo", $vlrPromoAntigo);
            $statement->bindValue(":strFreteGratis", $strFreteGratis);
            $statement->bindValue(":intCodProd", $intCodProd);
            $result = $statement->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    private function setPromoAntigo($intCodProd, $vlrPromoAntigo, $strFreteGratis) {

        try {
            $strSQL = 'UPDATE `produtos`
                SET `VL_PROMO_PRRC` = :vlrPromoAntigo, `DS_FRETEGRATIS_PRRC` = :strFreteGratis
                WHERE `NR_SEQ_PRODUTO_PRRC`= :intCodProd';

            $statement = $this->DB->prepare($strSQL);
            $statement->bindValue(":vlrPromoAntigo", $vlrPromoAntigo);
            $statement->bindValue(":strFreteGratis", $strFreteGratis);
            $statement->bindValue(":intCodProd", $intCodProd);
            $result = $statement->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    private function setBannersAgendados($intCodAgendamento) {

        try {
            $strSQL = 'UPDATE `banners_agendados`
                SET `ST_ATUAL_BARC` = \'N\'
                WHERE `NR_SEQ_AGENDAMENTO_BARC`= :intCodAgendamento';

            $statement = $this->DB->prepare($strSQL);
            $statement->bindValue(":intCodProd", $intCodAgendamento);
            $result = $statement->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

$prodDia = new ProdutoDia();
$prodDia->exec();