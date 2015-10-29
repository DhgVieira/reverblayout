<?php
include 'auth.php';
include 'lib.php';

$posicao = request("posicao");
$idfoto = request("idfoto");
$pagina = request("pagina");
$aba = request("aba");

$str = "UPDATE me_fotos SET NR_POSICAO_FORC = $posicao where NR_SEQ_FOTO_FORC = $idfoto";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou posicao da foto $idfoto");

mysql_close($con);

Header("Location: people.php?aba=$aba&pagina=$pagina");
?>