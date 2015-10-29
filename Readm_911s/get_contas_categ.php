<?php
include 'auth.php';
include 'lib.php';
$term = $_REQUEST['q'];
$nrseq = $_REQUEST['cli'];
$tam = strlen($term);

$sql = "select NR_SEQ_CATCONTA_CCRC, DS_CATEGORIA_CCRC from contas_categorias
         WHERE LEFT(DS_CATEGORIA_CCRC,$tam) = '$term' order by DS_CATEGORIA_CCRC limit 20";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $id_cate	   = $row[0];
        $ds_cate	   = $row[1];
        
        $subs = "";
        $sql2 = "select NR_SEQ_SUBCATCONTA_SCRC, DS_SUBCATEGORIA_SCRC from contas_subcategorias WHERE NR_SEQ_CATCONTA_SCRC = $id_cate order by DS_SUBCATEGORIA_SCRC";
        $st2 = mysql_query($sql2);
        if (mysql_num_rows($st2) > 0) {
            $idpri = "";
            while($row2 = mysql_fetch_row($st2)) {
                $id_scate	   = $row2[0];
                $ds_scate	   = $row2[1];
                if (!$idpri) $idpri = $id_scate;
               
                $subs .= "<option value=".$id_scate.">".$ds_scate."</option>";
            }
        }
        
        $descs = "";
        $sql2 = "select NR_SEQ_SUBCATCONTA_DCRC, DS_SUBCATEGORIA_DCRC from contas_descricao WHERE NR_SEQ_CATCONTA_DCRC = $idpri order by DS_SUBCATEGORIA_DCRC";
        $st2 = mysql_query($sql2);
        if (mysql_num_rows($st2) > 0) {
            while($row2 = mysql_fetch_row($st2)) {
                $id_desc	   = $row2[0];
                $ds_desc	   = $row2[1];
               
                $descs .= "<option value=".$id_desc.">".$ds_desc."</option>";
            }
        }
       
        echo $id_cate.",".$ds_cate.",".$subs.",".$descs.",".$idpri."\n";
    }
}
mysql_close($con);
?>