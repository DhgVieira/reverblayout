<?
include 'auth.php';
include 'lib.php';

$descricao 		= request("descricao");
$local	   		= request("localBan");
$link	   		= request("link");
$embed	   		= request("FCKeditor1");
$agenda	   		= request("banner_agendado");
$dia_inicio	   	= request("data_inicio");
$dia_fim	   	= request("data_fim");
$hora_inicio	= request("hora_inicio");
$hora_fim	   	= request("hora_fim");



$inicio = $dia_inicio . " " . $hora_inicio;
$fim 	= $dia_fim . " " . $hora_fim;


if (!$descricao) $descricao = " ";

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

$str = "INSERT INTO banners (NR_SEQ_LOCAL_BARC, DS_DESCRICAO_BARC, ST_BANNER_BARC, DT_CADASTRO_BARC, DS_LINK_BARC, DS_TEXT_BARC, NR_POSICAO_BARC, ST_AGENDAMENTO_BARC, DT_INICIO_BARC, DT_FIM_BARC) 
			VALUES ($local, '$descricao', 'A', sysdate(), '$link', '$embed', 1, $agenda, '$inicio', '$fim')";



$st = mysql_query($str);
$id = mysql_insert_id();

if($arquivo["name"])
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
	
	$imagem_nome = $id . "." . $ext[1];
	
	$imagem_dir = "../arquivos/uploads/banners/" . $imagem_nome;


	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$strp = "update banners set DS_EXT_BARC = '" . $ext[1]. "' WHERE NR_SEQ_BANNER_BARC = $id";
	$stp = mysql_query($strp);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu novo Banner $id");

mysql_close($con);

Header("Location: banners.php?aba=2");
?>