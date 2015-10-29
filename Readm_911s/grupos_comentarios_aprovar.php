<?php
include 'auth.php';
include 'lib.php';

$comentario = $_GET["idcomentario"];
$url = $_GET['url'];

$sql_atualiza = "UPDATE produtos_coments SET DS_STATUS_PCRC = 'A' where NR_SEQ_PRODCOMENT_PCRC = $comentario";
$st2 = mysql_query($sql_atualiza);

Header("Location: ".$url);
?>