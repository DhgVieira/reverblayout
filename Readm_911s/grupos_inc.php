<?php
include 'auth.php';
include 'lib.php';

$loja 		= request("loja");
$tipo 		= request("tipo");
$categoria	= request("categoria");
$musica		= request("musica");

$descricao 	= request("descricao");
$descricao2 	= request("descricao2");
$ref 		= request("ref");
$valor 		= request("valor");
$valor2 	= request("valor2");
$peso 		= request("peso");
$garantia	= request("garantia");

$codloc 	= request("codloc");

if (!$codloc){
    $codloc = "null";
}else{
    $codloc = "'".$codloc."'";
}

$destaque   = request("destaque");
$frete   	= request("frete");
$vlrpromo	= request("vlrpromo");
$status		= request("status");
$anocriacao = request("anocriacao");
$musicprod  = request("musicprod");

$textodestaq = request("textodestaq");
$descloj     = request("descloj");
$partpromo   = request("partpromo");

$dsncmprod   = request("ncmprod");

$cor 	 	 = request("cores");
$genero 	 = request("genero");
$modelo 	 = request("modelo");

$tags		= request("tags");

if (!$textodestaq){
    $textodestaq = "null";
}else{
    $textodestaq = "'".$textodestaq."'";
}

$informacoes = request("FCKeditor1");

if (!$descricao){
	$msg = "Voce precisa informar a descricao do produto!";
	$msg = str_replace(" ","%20",$msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$ref){
	$msg = "Voce precisa informar a referencia do produto!";
	$msg = str_replace(" ","%20",$msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$valor){
	$msg = "Voce precisa informar o valor do produto!";
	$msg = str_replace(" ","%20",$msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$valor2) $valor2 = 0;

if (!$vlrpromo) $vlrpromo = 0;

$valor = str_replace(",",".",$valor);
$valor2 = str_replace(",",".",$valor2);
$vlrpromo = str_replace(",",".",$vlrpromo);

if (!$peso)	$peso = 0;
if (!$garantia)	$garantia = " ";
if (!$informacoes) $informacoes = " ";

if (!$anocriacao) $anocriacao = " ";
if (!$musicprod) $musicprod = " ";

$inseriu = false;

$sql = "SELECT DS_PRODUTO2_PRRC from produtos WHERE DS_PRODUTO2_PRRC = '$descricao' and NR_SEQ_TIPO_PRRC = $tipo
        and NR_SEQ_CATEGORIA_PRRC = $categoria and DS_CLASSIC_PRRC = 'N' and NR_SEQ_LOJAS_PRRC = $SS_loja";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    $msg = "Ja existe um produto com este nome para este tipo e categoria!";
	$msg = str_replace(" ","%20",$msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}


$str = "INSERT INTO produtos (NR_SEQ_LOJAS_PRRC,
						NR_SEQ_TIPO_PRRC,
						NR_SEQ_CATEGORIA_PRRC,
						NR_SEQ_MUSICA_PRRC,
						DS_REFERENCIA_PRRC,
						DS_PRODUTO2_PRRC,
						DS_PRODUTO_PRRC,
						VL_PRODUTO_PRRC,
						VL_PRODUTO2_PRRC,
						DT_CADASTRO_PRRC,
						NR_VISITAS_PRRC,
						NR_PESOGRAMAS_PRRC,
						DS_GARANTIA_PRRC,
						DS_INFORMACOES_PRRC,
						DS_CLASSIC_PRRC,
						TP_DESTAQUE_PRRC,
						DS_FRETEGRATIS_PRRC,
						VL_PROMO_PRRC,
						ST_PRODUTOS_PRRC,
                        DT_CRIACAO_PRRC,
						DS_IMMEM_PRRC,
                        NR_CODIGOLOJA_PRRC,
                        DS_TEXTO_PRRC,
                        ST_DESCONTO_LOJA_PRRC,
                        ST_PART_PROMO_PRRC,
                        DS_NCM_PRRC,
                        NR_SEQ_COR_PRRC,
                        DS_GENERO_PRRC,
                        NR_SEQ_MODELO_PRRC
                        ) VALUES 
						($SS_loja,$tipo,$categoria,$musica,'$ref','$descricao2','$descricao',$valor,$valor2,sysdate(),
                         0,$peso,'$garantia','$informacoes','N',$destaque,'$frete',$vlrpromo,'$status',
                         '$anocriacao','$musicprod',$codloc,$textodestaq,'$descloj','$partpromo','$dsncmprod','$cor', '$genero', $modelo)";
$st = mysql_query($str);
$id = mysql_insert_id();

//aqui inicio o processo das tags

//removo todas as do produto para atualizar

$remove_tag = "DELETE FROM produtos_tags where idproduto = $id";
$st_remove_tag = mysql_query($remove_tag);
//agora explodo as tags

$tags = explode(";", $tags);

//agora para cada tag
foreach ($tags as $key => $tag) {
	//removo os espacos em branco
	$nova_tag = str_replace(" ", "", $tag);
	if($nova_tag != ""){
		$str_tag = "INSERT INTO produtos_tags (idproduto, produto_tag) VALUES ($id, '$nova_tag')";

		$st_tag = mysql_query($str_tag);
	}
}

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if($arquivo["name"])
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg|swf){1}$/i", $arquivo["name"], $ext);
	
	$imagem_nome = $idp . "." . $ext[1];
	
	$imagem_dir = "../arquivos/uploads/produtos/" . $imagem_nome;


	move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	
	$strp = "update produtos set DS_EXT_PRRC = '" . $ext[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $id";
	$stp = mysql_query($strp);
}


$arquivo2 = isset($_FILES["FILE2"]) ? $_FILES["FILE2"] : FALSE;

if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo2["type"]))
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo2["name"], $ext2);
	$imagem_nome2 = $id . "." . $ext2[1];
	$imagem_dir2 = "../images/tamanhos/" . $imagem_nome2;
	move_uploaded_file($arquivo2["tmp_name"], $imagem_dir2);
	
	$strp = "update produtos set DS_EXTTAM_PRRC = '" . $ext2[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $id";
	$stp = mysql_query($strp);
}


GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu produto $descricao");

mysql_close($con);

//verdadeiro para nao avisar mais do estoque
$inseriu = true;
$direciona1 = "Location: grupos.php";
$direciona2 = "grupos.php";

if ($inseriu) {
	Header($direciona1);
}else{
?>
 <script>
 alert('Produto incluido sem estoque. Para adicionar estoque ao mesmo clique no icone alterar!');
 window.location="<?php echo $direciona2; ?>";
 </script>
<?php } ?>