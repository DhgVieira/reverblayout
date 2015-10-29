<?php
include 'auth.php';
include 'lib.php';

if (!isset( $_SESSION )) { 
   	session_start(); 
}

setcookie("fhferedtexs", "");

$idc = request("idc");

$SS_cesta = "";
$cesta_new = "";

$sql = "SELECT NR_SEQ_PRODUTO_CESO, NR_QTDE_CESO, NR_SEQ_ESTOQUE_CESO FROM cestas
		 WHERE NR_SEQ_COMPRA_CESO = $idc";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $idp = $row[0];
        $qtd = $row[1];
        $ide = $row[2];
        
        $cesta_new .= $idp . "|" . $qtd . "|" . $ide . ";";
    }
}

echo $cesta_new;

setcookie("rcityrwixav", $cesta_new);

mysql_close($con);

$_SESSION["8792hgaq3"] = "";
$_SESSION["promo"] = "";
$_SESSION["hude78wsxa3a"] = "";
?>