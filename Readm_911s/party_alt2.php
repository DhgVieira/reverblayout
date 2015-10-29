<?php
include 'auth.php';
include 'lib.php';

$party = request("party");
$dia = request("dia");
$mes = request("mes");
$ano = request("ano");
$cidade = request("cidade");
$estado  = request("estado");
$idp  = request("idp");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou party $idp");

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if (!$party){
	$msg = "Voce precisa informar o nome da Party!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$cidade) $cidade = "-";

$str = "UPDATE partys SET DT_PARTY_PARC = '$ano-$mes-$dia', DS_PARTY_PARC = '$party', DS_CIDADE_PARC = '$cidade', DS_UF_PARC = '$estado'
		WHERE NR_SEQ_PARTY_PARC = $idp";
$st = mysql_query($str);

if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
	$imagem_nome = $idp . "." . $ext[1];
	$imagem_dir = "../images/partys/" . $imagem_nome;
	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$str = "UPDATE partys SET DS_EXT_PARC = '".$ext[1]."' WHERE NR_SEQ_PARTY_PARC = $idp";
	$st = mysql_query($str);
	
	Header("Location: resize_party.asp?imagem=$imagem_dir");
	exit();
}

mysql_close($con);

Header("Location: party.php");

?>
