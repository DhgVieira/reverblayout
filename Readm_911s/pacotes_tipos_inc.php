<?php
include 'auth.php';
include 'lib.php';


$descricao = request("descricao");
$valor = request("valor");



if (!$descricao){
	$msg = "Voce precisa informar a descricao do produto!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}


if (!$valor){
	$msg = "Voce precisa informar o valor do produto!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}


	$str = "INSERT INTO tipos_pacote (tipo_pacote, valor_tipo) VALUES 
							 ('$descricao', $valor)";


	$st = mysql_query($str);





GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu pacote $tipo");

mysql_close($con);

Header("Location: pacotes.php");

?>dd