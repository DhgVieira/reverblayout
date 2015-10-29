<?php
include 'auth.php';
include 'lib.php';

$nome_ass 		= request("nome_ass");
$email_ass 		= request("email_ass");
$idgrupo 		= request("idgrupo");

if (!$nome_ass){
	$msg = "Voce precisa informar o nome do Assinante!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

  
$str = "INSERT INTO Assinante (Nome, Email) VALUES ('$nome_ass', '$email_ass')";
$st = mysql_query($str);
$id = mysql_insert_id();

$str = "INSERT INTO AssinanteGrupo (IdAssinante, IdGrupo) VALUES ($id, $idgrupo)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu Assinante $nome_ass");

mysql_close($con);

Header("Location: newsletter_grpemail.php?idg=$idgrupo");

?>
