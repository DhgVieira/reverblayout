<?
include 'auth.php';
include 'lib.php';

$descricao 		= request("descricao");


if (!$descricao) $descricao = " ";

$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;

$str = "INSERT INTO modelos (descricao) 
			VALUES ('$descricao')";



$st = mysql_query($str);
$id = mysql_insert_id();

if($arquivo["name"])
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
	
	$imagem_nome = $id . "." . $ext[1];
	
	$imagem_dir = "../arquivos/uploads/modelos/" . $imagem_nome;


	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$strp = "update modelos set imagem_modelo = '" . $imagem_nome. "' WHERE idmodelo = $id";
	$stp = mysql_query($strp);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu novo Banner $id");

mysql_close($con);

Header("Location: banners.php?aba=2");
?>