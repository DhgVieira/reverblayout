<?
include 'auth.php';
include 'lib.php';

$idb	   = request("idb");
$descricao = request("descricao");
$local	   = request("local");
$link	   = request("link");
$embed	   = request("FCKeditor1");

$agenda	   		= request("banner_agendado");
$dia_inicio	   	= request("data_inicio");
$dia_fim	   	= request("data_fim");
$hora_inicio	= request("hora_inicio");
$hora_fim	   	= request("hora_fim");



$inicio = $dia_inicio . " " . $hora_inicio;
$fim 	= $dia_fim . " " . $hora_fim;


if (!$descricao) $descricao = " ";

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

$str = "UPDATE banners set NR_SEQ_LOCAL_BARC = $local, DS_DESCRICAO_BARC = '$descricao', DS_LINK_BARC = '$link', DS_TEXT_BARC = '$embed', ST_AGENDAMENTO_BARC = $agenda, DT_INICIO_BARC = '$inicio', DT_FIM_BARC = '$fim' WHERE NR_SEQ_BANNER_BARC = $idb";

$st = mysql_query($str);

if($arquivo["name"])
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
	
	$imagem_nome = $idb . "." . $ext[1];
	
	$imagem_dir = "../arquivos/uploads/banners/" . $imagem_nome;

	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$strp = "update banners set DS_EXT_BARC = '" . $ext[1]. "' WHERE NR_SEQ_BANNER_BARC = $idb";
	$stp = mysql_query($strp);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou Banner $idb");

mysql_close($con);

Header("Location: banners.php");
?>