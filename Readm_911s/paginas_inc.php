<?php
include 'auth.php';
include 'lib.php';

$nome_noticia = request("nome_noticia");
$noticia = request("FCKeditor1");

if (!$nome_noticia){
	$nome_noticia = "-";
}

if (!$noticia){
	Header("Location: paginas.php");
    exit();
}

$str = "INSERT INTO paginas (DS_TITULO_PASA, DS_STATUS_PASA, DT_CADASTRO_PASA, DS_TEXTO_PASA) VALUES ('$nome_noticia','E',sysdate(),'$noticia')";
$st = mysql_query($str);

mysql_close($con);

Header("Location: paginas.php");

?>
