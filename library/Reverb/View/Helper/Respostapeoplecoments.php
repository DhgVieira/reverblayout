<?php

/**
 * Cria o helper das fotos do produto
 *
 * @name Reverb_View_Helper_Fotoproduto
 */
class Reverb_View_Helper_Respostapeoplecoments extends Zend_View_Helper_Abstract {


    public function respostapeoplecoments($comentario_id) {
        $lista = array();

        if($comentario_id){
            $db = Zend_Registry::get("db");
            //crio a query para selecionar os comentarios
            $select_comentarios = "SELECT
	    								cadastros.DS_NOME_CASO,
	    								cadastros.NR_SEQ_CADASTRO_CASO,
	   								 	me_fotos_coments.*
									FROM
										me_fotos_coments
	  								inner join
									cadastros on cadastros.NR_SEQ_CADASTRO_CASO = me_fotos_coments.NR_SEQ_CADASTRO_MCRC
									WHERE me_fotos_coments.comentario_id = $comentario_id
									ORDER BY
										NR_SEQ_COMENTARIO_MCRC
									DESC
									LIMIT 4";

            // Monta a query
            $query = $db->query($select_comentarios);
            //crio uma lista de comentarios
            $lista = $query->fetchAll();
        }

        return $lista;
    }
}