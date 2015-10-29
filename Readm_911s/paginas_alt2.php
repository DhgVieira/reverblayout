<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$nome_noticia = request("nome_noticia");
$noticia = request("FCKeditor1");

if (!$nome_noticia){
	$nome_noticia = "-";
}

if (!$noticia){
	Header("Location: paginas.php");
    exit();
}

$str = "UPDATE paginas SET DS_TITULO_PASA = '$nome_noticia', DS_TEXTO_PASA = '$noticia' WHERE NR_SEQ_PAGINA_PASA = $idp";
$st = mysql_query($str);

mysql_close($con);

Header("Location: paginas.php");

?>
