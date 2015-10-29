<?php
include 'auth.php';
include 'lib.php';
$idsub = $_REQUEST['id'];
    
$descs = "";
$sql2 = "select NR_SEQ_SUBCATCONTA_DCRC, DS_SUBCATEGORIA_DCRC from contas_descricao order by DS_SUBCATEGORIA_DCRC";
$st2 = mysql_query($sql2);
if (mysql_num_rows($st2) > 0) {
    while($row2 = mysql_fetch_row($st2)) {
        $id_desc	   = $row2[0];
        $ds_desc	   = $row2[1];
       
        $descs .= "<option value=".$id_desc.">".$ds_desc."</option>";
    }
}

echo $descs;

mysql_close($con);
?>