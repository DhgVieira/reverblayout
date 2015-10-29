<?php

/**
 * Cria o helper das fotos do produto
 * 
 * @name Reverb_View_Helper_Fotoproduto
 */
class Reverb_View_Helper_Produtovendidodia extends Zend_View_Helper_Abstract {
    
    
    public function produtovendidodia($data, $produto_id) {
        $modelCompra = new Default_Model_Compras();

        $selectCompra = $modelCompra->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ce' => 'cestas'), 'ce.nr_seq_compra_ceso = c.nr_seq_compra_coso', array())
            ->columns(array(
                'total' => "coalesce(sum(nr_qtde_ceso), 0)"
            ))
            ->where('ce.nr_seq_produto_ceso = ?', $produto_id)
            ->where('DATE_FORMAT(c.dt_compra_coso, "%Y-%m-%d") = ?', $data)
            ->where('c.st_compra_coso not in ("C", "A")')
            ->setIntegrityCheck(false);

        $dadosCompra = $modelCompra->fetchRow($selectCompra);

        return $dadosCompra->total;
    }
}