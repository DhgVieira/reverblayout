<?php
include 'auth.php';
include 'lib.php'; 

$nomecol 		= request("nomecol");
$emailcol 		= request("emailcol");
$descricaocol 	= request("descricaocol");

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if (!$nomecol){
	$msg = "Voce precisa informar o nome do Colunista!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$emailcol){
	$msg = "Voce%20precisa%20informar%20o%20E-Mail!";
	Header("Location: erro.php?msg=$msg");
    exit();
}
if (!$descricaocol) $descricaocol = "";
  
$str = "INSERT INTO colunistas (DS_COLUNISTA_CORC, DS_EMAIL_CORC, DT_CADASTRO_CORC,DS_DESCRICAO_CORC) VALUES ('$nomecol','$emailcol',sysdate(),'$descricaocol')";
$st = mysql_query($str);

$id = mysql_insert_id();

if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
	$imagem_nome = $id . "." . $ext[1];
	$imagem_dir = "../images/colunistas/" . $imagem_nome;
	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	$str2 = "UPDATE colunistas SET DS_EXT_CORC = '".$ext[1]."' WHERE NR_SEQ_COLUNISTA_CORC = $id";
	$st2 = mysql_query($str2);
	
	Header("Location: blog.php?aba=3");
}
GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu colunista $nomecol");

mysql_close($con);

Header("Location: blog.php?aba=3");
 
?>
