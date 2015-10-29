<?php
include 'auth.php';
include 'lib.php';


$descricao = request("descricao");
$quantidade = request("quantidade");



if (!$descricao){
	$msg = "Voce precisa informar a descricao do produto!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}


if (!$quantidade){
	$msg = "Voce precisa informar a quantidade do produto!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}


	$str = "INSERT INTO itens_pacote (descricao_item, quantidade_estoque) VALUES 
							 ('$descricao', $quantidade)";

	$st = mysql_query($str);





GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu pacote $tipo");

mysql_close($con);

Header("Location: pacotes.php");

?>dd