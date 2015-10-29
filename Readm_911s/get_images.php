<?php
include 'auth.php';
include 'lib.php';
$term = $_REQUEST['q'];
//$nrseq = $_REQUEST['cli'];
$nrseq  = (isset($_SESSION["clitemp"])) ? $_SESSION["clitemp"] : "";
$tam = strlen($term);
//and ST_PRODUTOS_PRRC = 'A'
$sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC, VL_PRODUTO_PRRC, VL_PROMO_PRRC, NR_QTDE_ESRC, DS_TAMANHO_TARC, NR_SEQ_TAMANHO_ESRC
        from produtos, estoque, tamanhos WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
        and NR_SEQ_LOJAS_PRRC = $SS_loja AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 
        AND (LEFT(DS_PRODUTO2_PRRC,$tam) = '$term' or LEFT(NR_SEQ_PRODUTO_PRRC,$tam) = '$term') ORDER BY DS_PRODUTO2_PRRC limit 20";


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
        $nrestoq = $row[7];
        
        if ($vlrpromo > 0 && $vlrpromo < $valor) {
            $valor = $vlrpromo;
        }
        
        echo $id_prod.".".$ex_prod.",".$ds_prod.",".$valor.",".$estoque.",".$tamanho.",".$nrestoq."\n";
    }
}
mysql_close($con);
?>