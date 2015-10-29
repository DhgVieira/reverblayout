<?php

/**
 * Cria o helper do lista curtiram
 * 
 * @name Reverb_View_Helper_Listacurtiram
 */
class Reverb_View_Helper_Listacurtiram extends Zend_View_Helper_Abstract {
    
    
    public function listacurtiram($comentario_id) {
        $modelCurtiram = new Default_Model_Curtiram();
        
        $selectCurtiram = $modelCurtiram->select()
                ->from(array('c' => 'curtiram'), array())
                ->join(array('ca' => 'cadastros'), 'c.NR_SEQ_CADASTRO_CURC = ca.NR_SEQ_CADASTRO_CASO', array())
                ->columns(array(
                    'nome' => 'ca.DS_NOME_CASO',
                    'id' => 'ca.NR_SEQ_CADASTRO_CASO'
                ))
                ->where('c.NR_SEQ_MSG_CURC = ?', $comentario_id)
                ->setIntegrityCheck(FALSE);
        
        $dadosCurtiram = $modelCurtiram->fetchAll($selectCurtiram);
        
        return $dadosCurtiram;
    }
}