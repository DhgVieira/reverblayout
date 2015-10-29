<?php
include 'auth.php';
include 'lib.php';
$idgrp = request("idgrp");
$status = request("st");
$page = request("pg");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Separou Compra para envio: $idgrp");

$str = "UPDATE compras SET ST_SEPARADO_COSO = 'S', DT_STATUS_COSO = sysdate() WHERE NR_SEQ_COMPRA_COSO = $idgrp";
$st = mysql_query($str);

mysql_close($con);

Header("Location: compras.php?st=$status&pagina=$page");

?>