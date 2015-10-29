<?php
include 'auth.php';
include 'lib.php';  

$idc		   = request("idc");
$nome		   = request("nome_col");
$email	 	   = request("email_col");
$descricao	   = request("descricao_col");

if (!$nome){
	$msg = "Voce%20precisa%20informar%20o%20Nome!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$email){
	$msg = "Voce%20precisa%20informar%20o%20E-Mail!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$descricao) $descricao = "" ;

$str = "UPDATE colunistas SET 
 		DS_COLUNISTA_CORC = '$nome', 
		DS_EMAIL_CORC = '$email',
		DS_DESCRICAO_CORC = '$descricao'
		where NR_SEQ_COLUNISTA_CORC = $idc";
$st = mysql_query($str);


$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
	$imagem_nome = $idc . "." . $ext[1];
	$imagem_dir = "../images/colunistas/" . $imagem_nome;
	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$str = "UPDATE colunistas SET DS_EXT_CORC = '".$ext[1]."' WHERE NR_SEQ_COLUNISTA_CORC = $idc";
	$st = mysql_query($str);
	
	Header("Location: blog.php?aba=3");

	
}
GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou colunista $nome");
mysql_close($con);
Header("Location: blog.php?aba=3");


?>
