<?php
include 'auth.php';
include 'lib.php';
require_once('../phpthumb.class.php');
$phpThumb = new phpThumb();

$nome_post = request("nome_post");
$colunista = request("colunista");
$categoria = request("categoria");
$txt_blog  = request("FCKeditor1");
$youtube   = request("youtube");
$linkfoto  = request("linkfoto");
$datapub   = request("datapub");

if (!$datapub) {
    $datapub = date("Y-m-d G:i");
}else{
    $datapub = FormataDataMysql($datapub);
}

if (!$linkfoto){
    $linkfoto = "null";
}else{
    $linkfoto = "'".$linkfoto."'";
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

$str = "INSERT INTO blog_preview (NR_SEQ_CATEGORIA_BLRC, NR_SEQ_COLUNISTA_BLRC, DS_TITULO_BLRC, DT_CADASTRO_BLRC,
                          DS_STATUS_BLRC, DS_TEXTO_BLRC, DS_EXT_BLRC, DS_YOUTUBE_BLRC, DS_LINKIMAGEM_BLRC, 
                          DT_PUBLICACAO_BLRC) VALUES 
						 ($categoria, $colunista, '$nome_post', sysdate(), 'A', '$txt_blog', '-', '$youtube',
                          $linkfoto, '$datapub')";
$st = mysql_query($str);
$id = mysql_insert_id();

if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
	$imagem_nome = $id . "." . $ext[1];
	$imagem_dir = "../images/blog_p/" . $imagem_nome;
	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$str2 = "UPDATE blog_preview SET DS_EXT_BLRC = '".$ext[1]."' WHERE NR_SEQ_BLOG_BLRC = $id";
	$st2 = mysql_query($str2);
    
	$absolute_path = str_replace("/Readm_911s","\\",dirname(__FILE__));
	$absolute_path = str_replace("\\","/",$absolute_path);
	
	$old_xx=getimagesize($absolute_path."images/blog_p/".$id.".".$ext[1]);
	$old_x = $old_xx[0];
	
	if ($old_x > 600) {
		$phpThumb->setSourceData(file_get_contents("../images/blog_p/$imagem_nome"));
		$output_filename = "../images/blog_p/".$id.".".$ext[1];
		
		$phpThumb->setParameter('w', 600);
		
		$phpThumb->GenerateThumbnail();
		$phpThumb->RenderToFile($output_filename);
	}
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu Blog $nome_post");

mysql_close($con);

Header("Location: ../blog/blog_preview.php?idb=$id");
exit();
?>