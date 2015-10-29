<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$legenda = request("legenda");

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
{
	$msg = "Formato%20de%20Arquivo%20Invalido!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

$str = "INSERT INTO fotos (NR_SEQ_PRODUTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC) VALUES ($idp, '".$ext[1]."', '$legenda')";
$st = mysql_query($str);
$id = mysql_insert_id();

$imagem_nome = $id . "." . $ext[1];
$imagem_dir = "../arquivos/uploads/fotosprodutos/" . $imagem_nome;
move_uploaded_file($arquivo["tmp_name"], $imagem_dir);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu nova foto para o produto $idp");

mysql_close($con);

Header("Location: resize2.asp?idp=$idp&idf=$id&ext=".$ext[1]);
?>