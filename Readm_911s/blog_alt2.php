<?php
include 'auth.php';
include 'lib.php';

$idb  = request("idb");

$nome_post = request("nome_post");
$colunista = request("colunista");
$categoria = request("categoria");
$txt_blog  = request("FCKeditor1");
$youtube   = request("youtube");
$linkfoto  = request("linkfoto");
$pg		   = request("pg");
$datapub   = request("datapub");

if (!$linkfoto){
    $linkfoto = "null";
}else{
    $linkfoto = "'".$linkfoto."'";
}

if (!$datapub) {
    $datapub = date("Y-m-d G:i");
}else{
    $datapub = FormataDataMysql($datapub);
}


$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if (!$nome_post){
	$msg = "Voce precisa informar o titulo do Post!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$txt_blog){
	$msg = "Voce precisa informar o texto do Post!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$youtube) $youtube = "-";

$str = "UPDATE blog set DS_LINKIMAGEM_BLRC = $linkfoto, DS_YOUTUBE_BLRC = '$youtube', NR_SEQ_CATEGORIA_BLRC = $categoria,
                        NR_SEQ_COLUNISTA_BLRC = $colunista, DS_TITULO_BLRC = '$nome_post', DS_TEXTO_BLRC = '$txt_blog',
                        DT_PUBLICACAO_BLRC = '$datapub' WHERE NR_SEQ_BLOG_BLRC = $idb";
$st = mysql_query($str);

// if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
// {
// 	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
// 	$imagem_nome = $idb . "." . $ext[1];
// 	$imagem_dir = "../images/blog/" . $imagem_nome;
// 	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
// 	$str = "UPDATE blog SET DS_EXT_BLRC = '".$ext[1]."' WHERE NR_SEQ_BLOG_BLRC = $idb";
// 	$st = mysql_query($str);
	
// 	mysql_close($con);
	
// 	//Header("Location: resize_blog.asp?imagem=$imagem_dir&pg=$pg");
// 	//exit();
// }
if($_FILES['FILE1']['name'] != ""){
	$ext = substr(strrchr($_FILES['FILE1']['name'], "."), 1); 
	

 	$imagem_nome = $idb . "." . $ext;
	
	$imagem_dir = "../arquivos/uploads/blog/" . $imagem_nome;


  	$result = move_uploaded_file($_FILES['FILE1']['tmp_name'], $imagem_dir);

 	$strp = "UPDATE blog SET DS_EXT_BLRC = '".$ext."' WHERE NR_SEQ_BLOG_BLRC = $idb";
	$stp = mysql_query($strp);
}

Header("Location: blog.php?pagina=$pg");

?>