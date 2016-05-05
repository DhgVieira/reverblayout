<?php

class Zend_Controller_Action_Helper_Criteo extends Zend_Controller_Action_Helper_Abstract
{
    const INT_ID_AACOUNT = "28203";

    private function setProdByObj($objProd) {
        $arrProd = [];
        $i = 1;
        foreach($objProd as $produto) {
            if($i <= 3)
                array_push($arrProd, $produto->NR_SEQ_PRODUTO_PRRC);
            else
                break;
            $i++;
        }
        return json_encode($arrProd);
    }

    private function setCarrinho($returnJSON = false) {
        $carrinho = new Zend_Session_Namespace("carrinho");
//        Zend_Debug::dump($carrinho->produtos); exit;
        $arrRetorno = [];
        $strArrayRetorno = '';
        foreach ($carrinho->produtos as $key => $produto) {
                if(empty($produto['vl_promo']))
                    $price = $produto['valor'];
                else
                    $price = $produto['vl_promo'];
                $arrRetorno[] = ['id' => $produto['codigo'], 'price' => number_format($price, 2, '.', '.'), 'quantity' => $produto['quantidade']];
                $strArrayRetorno .= '{id: ' . '"'. $produto['codigo'] . '", price: ' . number_format($price, 2, '.', '.') . ', ' . 'quantity: ' . $produto['quantidade'] . '},';
        }

        if(empty($returnJSON)) {
            $strSize = strlen($strArrayRetorno);
            $strArrayRetorno = substr($strArrayRetorno,0, $strSize-1);
            return $strArrayRetorno;
        }
        return json_encode($arrRetorno);
    }

    public function getCarrinho($whatDevice, $userEmail){
        $strProductList = "{ event: \"viewBasket\", item:[" . $this->setCarrinho() . "]}";
        $getCriteo = $this->getCriteo($whatDevice, $userEmail, $strProductList);
        return $getCriteo;
    }

    public function getTransaction($whatDevice, $userEmail, $intIDPedido){
        $strProductList = "{ event: \"trackTransaction\", id: \"{$intIDPedido}\",
        item:[" . $this->setCarrinho() . "]}";
        $getCriteo = $this->getCriteo($whatDevice, $userEmail, $strProductList);
        return $getCriteo;
    }

    public function getCriteoHome($whatDevice, $userEmail){
        $strHome = "{ event: \"viewHome\" }";
        $getCriteo = $this->getCriteo($whatDevice, $userEmail, $strHome);
        return $getCriteo;
    }

    public function getProdct($whatDevice, $userEmail, $intProdID){
        $strProductList = "{ event: \"viewItem\", item: \"{$intProdID}\" }";
        $getCriteo = $this->getCriteo($whatDevice, $userEmail, $strProductList);
        return $getCriteo;
    }

    public function getProdctList($whatDevice, $userEmail, $objProdutos){
        $strProductList = "{ event: \"viewList\", item:" . $this->setProdByObj($objProdutos) . "}";
        $getCriteo = $this->getCriteo($whatDevice, $userEmail, $strProductList);
        return $getCriteo;
    }

    private function getCriteo($whatDevice, $userEmail, $strLocal) {
        $strCriteo = 'window.criteo_q = window.criteo_q || [];
        window.criteo_q.push(
        { event: "setAccount", account: ' . self::INT_ID_AACOUNT . ' },
        { event: "setEmail", email: "' . $userEmail . '" },
        { event: "setSiteType", type: "' . $whatDevice . '" },
        ' . $strLocal . '
        );';

        return $strCriteo;
    }
}