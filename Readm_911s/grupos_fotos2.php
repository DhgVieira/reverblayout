<?
include 'auth.php';
include 'lib.php';


$idp = request("idp");
$legenda = request("legenda");

for ($i = 0; $i < count($_FILES['FILE1']['name']); $i++) {

 	$ext = substr(strrchr($_FILES['FILE1']['name'][$i], "."), 1); 

	$str = "INSERT INTO fotos (NR_SEQ_PRODUTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC) VALUES ($idp, '".$ext."', '$legenda')";
	
	$st = mysql_query($str);
	$id = mysql_insert_id();


 	$imagem_nome = $id . "." . $ext;
	
	$imagem_dir = "../arquivos/uploads/fotosprodutos/" . $imagem_nome;


 	$result = move_uploaded_file($_FILES['FILE1']['tmp_name'][$i], $imagem_dir);

 	$strp = "update produtos set DS_EXT_PRRC = '" . $ext. "' WHERE NR_SEQ_PRODUTO_PRRC = $idp";
	$stp = mysql_query($strp);


}

	Header("Location: grupos_fotos.php?idp=$idp");

exit();
?>