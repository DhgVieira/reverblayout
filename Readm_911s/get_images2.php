<?php
include 'auth.php';
include 'lib.php';
$term = $_REQUEST['q'];
$nrseq = $_REQUEST['cli'];
$tam = strlen($term);
//and ST_PRODUTOS_PRRC = 'A'
$sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC, VL_PRODUTO_PRRC, VL_PROMO_PRRC, NR_QTDE_ESRC, DS_TAMANHO_TARC, DS_FRETEGRATIS_PRRC, (SELECT
                        CONCAT(NR_SEQ_FOTO_FORC, '.', DS_EXT_FORC)
                        
                FROM
                   fotos
                WHERE
                   NR_SEQ_PRODUTO_FORC = NR_SEQ_PRODUTO_PRRC
                ORDER BY
                        NR_ORDEM_FORC ASC
                LIMIT 1) as foto
        from produtos, estoque, tamanhos WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
        and NR_SEQ_LOJAS_PRRC = $SS_loja AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 
        AND DS_PRODUTO2_PRRC like '%$term%' 
        GROUP BY NR_SEQ_PRODUTO_PRRC
        ORDER BY DS_PRODUTO2_PRRC limit 20";
        
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $id_prod = $row[0];
        $ds_prod = str_replace(",","",$row[1]);
        $ds_prod = str_replace("&","e",$ds_prod);
        $ex_prod = $row[2];
        if ($nrseq){
            $valor = Valor_Produto($id_prod,$nrseq);
        }else{
            $valor = $row[3];
        }
        $vlrpromo = $row[4];
        $estoque = $row[5];
        $tamanho = $row[6];
        $fretegra = $row[7];
        $foto = $row[8];
        
        echo $id_prod.".".$ex_prod.",".$ds_prod.",".$valor.",".$estoque.",".$vlrpromo.",".$fretegra.",". $foto ."\n";
    }
}
mysql_close($con);
?>