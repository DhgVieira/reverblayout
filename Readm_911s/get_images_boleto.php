<?php
include 'auth.php';
include 'lib.php';
$term = $_REQUEST['q'];
//$nrseq = $_REQUEST['cli'];
$nrseq  = (isset($_SESSION["clitemp"])) ? $_SESSION["clitemp"] : "";
$tam = strlen($term);
//and ST_PRODUTOS_PRRC = 'A'
$sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC
        from produtos WHERE NR_SEQ_PRODUTO_PRRC in (4679) and LEFT(DS_PRODUTO2_PRRC,$tam) = '$term'";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $id_prod = $row[0];
        $ds_prod = str_replace(",","",$row[1]);
        $ds_prod = str_replace("&","e",$ds_prod);
        $ex_prod = $row[2];
        
        echo $id_prod.".".$ex_prod.",".$ds_prod.",0,1,0,0\n";
    }
}
mysql_close($con);
?>