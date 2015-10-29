<?php
include 'auth.php';
include 'lib.php';

$produto = request("imageSearch");

$splprod = explode(",",$produto);
$splprod2 = explode(".",$splprod[0]);

$nrprod = $splprod2[0];

$sql = "select NR_SEQ_MONITORA_MOPR from produtos_monitora where NR_SEQ_PRODUTO_MOPR = $nrprod";
$st = mysql_query($sql);
if (mysql_num_rows($st) <= 0) {
	$sql3 = "select NR_VISITAS_PRRC from produtos where NR_SEQ_PRODUTO_PRRC = $nrprod";
    $st3 = mysql_query($sql3);
    $vis = 0;
    if (mysql_num_rows($st3) > 0) {
        $row = mysql_fetch_row($st3);
        $vis = $row[0];
        if (!$vis) $vis = 0;
    }
    $str = "INSERT INTO produtos_monitora (NR_SEQ_PRODUTO_MOPR, NR_VISITASINI_MOPR) VALUES ($nrprod, $vis)";
    $st2 = mysql_query($str);
}

mysql_close($con);

Header("Location: monitora.php");
exit();
?>