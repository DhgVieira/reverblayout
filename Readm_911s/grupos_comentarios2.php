<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
include 'topo.php';

$comentarios = $_POST["idcomentario"];
$status = $_POST["status"];

foreach ($comentarios as $key => $comentario) {
	
	if ($status[$key] == 'A'){

		$sql_atualiza = "UPDATE produtos_coments SET DS_STATUS_PCRC = 'I' where NR_SEQ_PRODCOMENT_PCRC = $comentario";

		$st2 = mysql_query($sql_atualiza);
	}else{

		$sql_atualiza = "UPDATE produtos_coments SET DS_STATUS_PCRC = 'A' where NR_SEQ_PRODCOMENT_PCRC = $comentario";
		$st2 = mysql_query($sql_atualiza);
	}
}

Header("Location: grupos.php");
?>