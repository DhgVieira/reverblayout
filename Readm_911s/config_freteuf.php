<?php
include 'auth.php';
include 'lib.php';

$uf = request("uf");

$sql = "select ST_FRETEGRATIS_EFRC, VL_VALOR_EFRC from estados_frete WHERE DS_SIGLA_EFRC = '$uf'";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $stfrete   = $row[0];
    $vlfrete   = $row[1];
    $result = number_format($vlfrete,2,",","")."|$stfrete";
    echo $result;
}
mysql_close($con);
?>