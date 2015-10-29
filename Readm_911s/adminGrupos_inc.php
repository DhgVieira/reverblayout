<?php
include 'auth.php';
include 'lib.php';

$nome_grp 		= request("nome_grp");

if (!$nome_grp){
	$msg = "Voce precisa informar o nome do Grupo!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO Grupo (Nome) VALUES ('$nome_grp')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Criou grupo $nome_grp");

mysql_close($con);

Header("Location: newsletter.php?aba=3");

?>
