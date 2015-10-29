<?php
include 'auth.php';
include 'lib.php';

$party = request("party");
$dia = request("dia");
$mes = request("mes");
$ano = request("ano");
$cidade = request("cidade");
$estado  = request("estado");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu party $party");

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if (!$party){
	$msg = "Voce precisa informar o nome da Party!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$cidade) $cidade = "-";

$str = "INSERT INTO partys (NR_SEQ_AUTOR_PARC, DT_PARTY_PARC, DS_PARTY_PARC, DS_CIDADE_PARC, DS_UF_PARC, DT_CADASTRO_PARC, ST_PARTY_PARC) VALUES 
						 ($SS_logado, '$ano-$mes-$dia', '$party', '$cidade', '$estado', sysdate(), 'A')";
$st = mysql_query($str);
$id = mysql_insert_id();

if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
	$imagem_nome = $id . "." . $ext[1];
	$imagem_dir = "../images/partys/" . $imagem_nome;
	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$str = "UPDATE partys SET DS_EXT_PARC = '".$ext[1]."' WHERE NR_SEQ_PARTY_PARC = $id";
	$st = mysql_query($str);
	
	Header("Location: resize_party.asp?imagem=$imagem_dir");
	exit();
}

mysql_close($con);

Header("Location: party.php");

?>
