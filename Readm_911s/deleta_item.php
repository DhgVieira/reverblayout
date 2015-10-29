<?php
include 'auth.php';
include 'lib.php';

$idp = request("id_item");




$str = "DELETE FROM itens_pacote WHERE iditem_pacote = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou o item de pacote $idp");


mysql_close($con);

Header("Location: pacotes.php?pagina=$page");
?>