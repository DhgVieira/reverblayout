<?php
include 'auth.php';
include 'lib.php';

// $phpThumb = new phpThumb();

$idp 		= request("idp");
$pg 		= request("pg");

$loja 		= request("loja2");
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

$textodestaq  = request("textodestaq");
$descloj     = request("descloj");
$partpromo   = request("partpromo");
$dsncmprod   = request("ncmprod");
$cor 	 	 = request("cores");
$genero 	 = request("genero");
$modelo 	 = request("modelo");

$tags 	 	  = request("tags");

if (!$textodestaq){
    $textodestaq = "null";
}else{
    $textodestaq = "'".$textodestaq."'";
}

if (!$codloc){
    $codloc = "null";
}else{
    $codloc = "'".$codloc."'";
}

/*
$m_tamPP	= request("m_tamPP");
$m_tamP 	= request("m_tamP");
$m_tamM		= request("m_tamM");
$m_tamG		= request("m_tamG");
$m_tamGG	= request("m_tamGG");
$f_tamPP	= request("f_tamPP");
$f_tamP		= request("f_tamP");
$f_tamM		= request("f_tamM");
$f_tamG		= request("f_tamG");
$f_tamGG	= request("f_tamGG");

$tam33	= request("tam33");
$tam34	= request("tam34");
$tam35	= request("tam35");
$tam36	= request("tam36");
$tam37	= request("tam37");
$tam38	= request("tam38");
$tam39	= request("tam39");
$tam40	= request("tam40");
$tam41	= request("tam41");
$tam42	= request("tam42");
$tam43	= request("tam43");
$tam44	= request("tam44");
$tam45	= request("tam45");
$tam46	= request("tam46");

$tam_un		= request("tam_un");
$tam_unqt	= request("tam_unqt");

*/

$destaque	= request("destaque");
$frete		= request("frete");
$vlrpromo	= request("vlrpromo");
$vlrpromo_xgl	= request("vlrpromo_xgl");
$vlrpromo_m	= request("vlrpromo_m");
$status		= request("status");
//***** PEGA O ANO DA CRAICAO
$anocriacao  = request("anocriacao");
//***** musica
$musicprod   = request("musicprod");

//*****
$informacoes = request("FCKeditor1");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou produto $idp (valor: $valor, promo: $vlrpromo, frete: $frete)");

// if (!$descricao){
// 	$msg = "Voce precisa informar a descricao do produto!";
// 	$msg = str_replace(" ","%20",$msg);
// 	Header("Location: erro.php?msg=$msg");
//     exit();
// }

// if (!$ref){
// 	$msg = "Voce precisa informar a referencia do produto!";
// 	$msg = str_replace(" ","%20",$msg);
// 	Header("Location: erro.php?msg=$msg");
//     exit();
// }

// if (!$valor){
// 	$msg = "Voce precisa informar o valor do produto!";
// 	$msg = str_replace(" ","%20",$msg);
// 	Header("Location: erro.php?msg=$msg");
//     exit();
// }
if (!$vlrpromo) $vlrpromo = 0;
if (!$vlrpromo_xgl) $vlrpromo_xgl = 0;
if (!$vlrpromo_m) $vlrpromo_m = 0;
if (!$valor2) $valor2 = 0;

$valor = str_replace(",",".",$valor);
$valor2 = str_replace(",",".",$valor2);
$vlrpromo = str_replace(",",".",$vlrpromo);
$vlrpromo_xgl = str_replace(",",".",$vlrpromo_xgl);
$vlrpromo_m = str_replace(",",".",$vlrpromo_m);

//if (!$m_tamPP)	$m_tamPP = -1;
//if (!$m_tamP)	$m_tamP = -1;
//if (!$m_tamM)	$m_tamM = -1;
//if (!$m_tamG)	$m_tamG = -1;
//if (!$m_tamGG)	$m_tamGG = -1;
//if (!$f_tamPP)	$f_tamPP = -1;
//if (!$f_tamP)	$f_tamP = -1;
//if (!$f_tamM)	$f_tamM = -1;
//if (!$f_tamG)	$f_tamG = -1;
//if (!$f_tamGG)	$f_tamGG = -1;
//if (!$tam_unqt)	$tam_unqt = -1;

if (!$peso)	$peso = 0;
if (!$garantia)	$garantia = " ";
if (!$informacoes) $informacoes = " ";
if (!$anocriacao) $anocriacao = NULL;
if (!$musicprod) $musicprod = " ";
if (!$cor) $cor = 13;

$sql = "SELECT DS_PRODUTO2_PRRC from produtos WHERE DS_PRODUTO2_PRRC = '$descricao' and NR_SEQ_TIPO_PRRC = $tipo and NR_SEQ_CATEGORIA_PRRC = $categoria and DS_CLASSIC_PRRC = 'N' and NR_SEQ_LOJAS_PRRC = $SS_loja and NR_SEQ_PRODUTO_PRRC <> $idp";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    $msg = "Ja existe um produto com este nome para este tipo e categoria!";
	$msg = str_replace(" ","%20",$msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

$inseriu = false;
//***** ATUALIZA O PRODUTO COM O ANO DA CRIACAO
$str = "UPDATE produtos SET 
							NR_SEQ_TIPO_PRRC = $tipo,
							NR_SEQ_CATEGORIA_PRRC = $categoria,
							NR_SEQ_MUSICA_PRRC = $musica,
							DS_REFERENCIA_PRRC = '$ref',
							DS_PRODUTO2_PRRC = '$descricao2',
							DS_PRODUTO_PRRC = '$descricao',
							VL_PRODUTO_PRRC = $valor,
							VL_PRODUTO2_PRRC = $valor2,
							NR_PESOGRAMAS_PRRC = $peso,
							DS_GARANTIA_PRRC = '$garantia',
							DS_INFORMACOES_PRRC = '$informacoes',
							TP_DESTAQUE_PRRC = '$destaque',
							DS_FRETEGRATIS_PRRC = '$frete',
							VL_PROMO_PRRC = $vlrpromo,
							VL_PROMO_XGL_PRRC = $vlrpromo_xgl,
							VL_PROMO_M_PRRC = $vlrpromo_m,
							ST_PRODUTOS_PRRC = '$status',
							DT_CRIACAO_PRRC = '$anocriacao',
							DS_IMMEM_PRRC = '$musicprod',
	                        NR_CODIGOLOJA_PRRC = $codloc,
	                        DS_TEXTO_PRRC = $textodestaq,
	                        ST_DESCONTO_LOJA_PRRC = '$descloj',
	                        ST_PART_PROMO_PRRC = '$partpromo',
	                        DS_NCM_PRRC = '$dsncmprod',
							NR_SEQ_COR_PRRC = $cor,
							DS_GENERO_PRRC = '$genero',
							NR_SEQ_MODELO_PRRC = $modelo
						WHERE
							NR_SEQ_PRODUTO_PRRC = $idp";


					

//*****		

			
$st = mysql_query($str);

//aqui inicio o processo das tags

//removo todas as do produto para atualizar

$remove_tag = "DELETE FROM produtos_tags where idproduto = $idp";
$st_remove_tag = mysql_query($remove_tag);
//agora explodo as tags

$tags = explode(";", $tags);

//agora para cada tag
foreach ($tags as $key => $tag) {
	//removo os espacos em branco
	$nova_tag = str_replace(" ", "", $tag);
	if($nova_tag != ""){
		$str_tag = "INSERT INTO produtos_tags (idproduto, produto_tag) VALUES ($idp, '$nova_tag')";

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
	
	$strp = "update produtos set DS_EXT_PRRC = '" . $ext[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $idp";
	$stp = mysql_query($strp);
}


$arquivo2 = isset($_FILES["FILE2"]) ? $_FILES["FILE2"] : FALSE;

if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo2["type"]))
{
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo2["name"], $ext2);
	$imagem_nome2 = $idp . "." . $ext2[1];
	$imagem_dir2 = "../images/tamanhos/" . $imagem_nome2;
	move_uploaded_file($arquivo2["tmp_name"], $imagem_dir2);
	
	$strp = "update produtos set DS_EXTTAM_PRRC = '" . $ext2[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $idp";
	$stp = mysql_query($strp);
}

//$str = "DELETE FROM estoque WHERE NR_SEQ_PRODUTO_ESRC = $idp";
//$st = mysql_query($str);

//$inseriu = false;

/*

if ($tam_un != "S") {
	if ($m_tamPP >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 1, $m_tamPP)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($m_tamP >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 2, $m_tamP)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($m_tamM >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 3, $m_tamM)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($m_tamG >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 4, $m_tamG)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($m_tamGG >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 5, $m_tamGG)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($f_tamPP >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 6, $f_tamPP)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($f_tamP >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 7, $f_tamP)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($f_tamM >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 8, $f_tamM)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($f_tamG >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 9, $f_tamG)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($f_tamGG >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 10, $f_tamGG)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	
	if ($tam33 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 13, $tam33";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam34 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 14, $tam34)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam35 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 15, $tam35)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam36 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 16, $tam36)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam37 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 17, $tam37)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam38 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 18, $tam38)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam39 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 19, $tam39)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam40 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 20, $tam40)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam41 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 21, $tam41)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam42 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 22, $tam42)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam43 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 23, $tam43)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam44 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 24, $tam44)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam45 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 25, $tam45)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	if ($tam46 >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 26, $tam46)";
		$st = mysql_query($str);
		$inseriu = true;
	}
	
}else{
	if ($tam_unqt >= 0) {
		$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $idp, 11, $tam_unqt)";
		$st = mysql_query($str);
		$inseriu = true;
	}
}

*/

mysql_close($con);

//verdadeiro para nao avisar mais do estoque
$inseriu = true;

$direciona1 = "Location: grupos.php?pagina=$pg";
$direciona2 = "grupos.php?pagina=$pg";

if ($inseriu) {
	Header($direciona1);
}else{
?>
 <script>
 alert('Produto alterado sem estoque. Para adicionar estoque ao mesmo clique no icone alterar!');
 window.location="<?php echo $direciona2; ?>";
 </script>
<?php } ?>