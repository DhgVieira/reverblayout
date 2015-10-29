<?php
include 'auth.php';
include 'lib.php';

$nome_cat 		= request("nome_cat");

if (!$nome_cat){
	$msg = "Voce precisa informar o nome da Categoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO blog_categorias (DS_CATEGORIA_BCRC, DT_CADASTRO_BCRC) VALUES ('$nome_cat',sysdate())";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Criou a categoria $nome_cat no blog");

mysql_close($con);

Header("Location: blog.php?aba=4");

?>
