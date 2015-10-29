<?php
include 'auth.php';
include 'lib.php';

$nome_musica 		= request("nome_musica");

if (!$nome_musica){
	$msg = "Voce precisa informar o nome da Categoria!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO produtos_musica (DS_MUSICA_MURC, DT_CADASTRO_MURC, NR_SEQ_LOJA_MURC) VALUES ('$nome_musica',sysdate(),$SS_loja)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inlcuiu nova musica $nome_musica");

mysql_close($con);

Header("Location: grupos.php?aba=5");

?>