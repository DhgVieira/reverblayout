<?php

/**
 * Cria o helper das fotos do produto
 *
 * @name Reverb_View_Helper_Fotoproduto
 */
class Reverb_View_Helper_Respostacyclecoments extends Zend_View_Helper_Abstract {


    public function respostacyclecoments($comentario_id) {
        $lista = array();

        if($comentario_id){
            $db = Zend_Registry::get("db");
            //crio a query para selecionar os comentarios
            $select_comentarios = "SELECT
    								`cadastros`.`DS_NOME_CASO`,
    								`cadastros`.`NR_SEQ_CADASTRO_CASO`,
   								 	`reverbcycle_coments` . *
								FROM
									reverbcycle_coments
  								inner join
								cadastros on cadastros.NR_SEQ_CADASTRO_CASO =reverbcycle_coments.NR_SEQ_CADASTRO_CRRC
								WHERE reverbcycle_coments.comentario_id = $comentario_id
								ORDER BY
									NR_SEQ_COMENTARIO_CRRC
								DESC";
            
            // Monta a query
            $query = $db->query($select_comentarios);
            //crio uma lista de comentarios
            $lista = $query->fetchAll();
        }

        return $lista;
    }
}