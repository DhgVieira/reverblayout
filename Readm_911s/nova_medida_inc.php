<?
include 'auth.php';
include 'lib.php';

$modelo 		= request("modelo");
$tamanho		= request("tamanho");


$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;

$str = "INSERT INTO modelos_has_tamanhos (idmodelo, idtamanho) 
			VALUES ($modelo, $tamanho)";



$st = mysql_query($str);
$id = mysql_insert_id();

if($arquivo["name"])
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
	
	$imagem_nome = $id . "." . $ext[1];
	
	$imagem_dir = "../arquivos/uploads/medidas/" . $imagem_nome;


	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$strp = "UPDATE modelos_has_tamanhos set imagem_tamanho = '" . $imagem_nome. "' WHERE idmodelo_has_tamanho = $id";
	$stp = mysql_query($strp);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu novo modelo $id");

mysql_close($con);

Header("Location: grupos.php");
?>