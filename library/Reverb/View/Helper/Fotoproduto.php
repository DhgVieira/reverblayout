<?php

/**
 * Cria o helper das fotos do produto
 * 
 * @name Reverb_View_Helper_Fotoproduto
 */
class Reverb_View_Helper_Fotoproduto extends Zend_View_Helper_Abstract {
    
    
    public function fotoproduto($produto_id, $boolEstampa = false) {
        $lista = array();
        
        if($produto_id){
            $db = Zend_Registry::get("db");
            //crio a query para selecionar os amigos
            $select_fotos = "SELECT
                        NR_SEQ_FOTO_FORC,
                        NR_SEQ_PRODUTO_FORC,
                        DS_EXT_FORC,
                        NR_ORDEM_FORC
                FROM
                   fotos
                WHERE
                   NR_SEQ_PRODUTO_FORC = '". addslashes($produto_id) ."'
                ORDER BY
                        NR_ORDEM_FORC ASC
                LIMIT 2";
            
            $idCache = md5($select_fotos);
            
            $lista = Zend_Registry::get("cache")->load($idCache);
            
            if(!$lista){
                $query = $db->query($select_fotos);
                $lista = $query->fetchAll();
                
                Zend_Registry::get("cache")->save($lista, $idCache);
            }

            if($boolEstampa == true && count($lista) >= 2) {
                $lista[0] = $lista[1];
            }

        }
        
        return $lista;
    }
}