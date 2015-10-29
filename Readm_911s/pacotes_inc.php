<?php
include 'auth.php';
include 'lib.php';


$tipo = request("tipo");
$produto = $_POST["idproduto"];



if (!$tipo){
	$msg = "Voce precisa informar o tipo do pacote!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}


if (!$produto){
	$msg = "Voce precisa informar o produto do pacote!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
foreach ($produto as $key => $prod) {
	$quantidade = $_POST["quantidade"][$key];

	$str = "INSERT INTO pacotes_has_itens (idpacote_tipo, iditem_pacote, quantidade_itens) VALUES 
							 ($tipo, $prod, '$quantidade')";

	$st = mysql_query($str);

}



GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu pacote $tipo");

mysql_close($con);

Header("Location: pacotes.php");

?>