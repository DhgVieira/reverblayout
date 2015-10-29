<?php
include 'auth.php';
include 'lib.php';

$loja 		= request("loja");
$tipo 		= request("tipo");
$categoria	= request("categoria");
$musica		= request("musica");

$descricao 	= request("descricao");
$ref 		= request("ref");
$valor 		= request("valor");
$peso 		= request("peso");
$garantia	= request("garantia");

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

$tam_un		= request("tam_un");
$tam_unqt	= request("tam_unqt");
$destaque   = request("destaque");
$frete   	= request("frete");
$vlrpromo	= request("vlrpromo");
$status		= request("status");

$informacoes = request("FCKeditor1");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu produto $descricao");

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

if (!$vlrpromo) $vlrpromo = 0;

$valor = str_replace(",",".",$valor);
$vlrpromo = str_replace(",",".",$vlrpromo);

if (!$m_tamPP)	$m_tamPP = 0;
if (!$m_tamP)	$m_tamP = 0;
if (!$m_tamM)	$m_tamM = 0;
if (!$m_tamG)	$m_tamG = 0;
if (!$m_tamGG)	$m_tamGG = 0;
if (!$f_tamPP)	$f_tamPP = 0;
if (!$f_tamP)	$f_tamP = 0;
if (!$f_tamM)	$f_tamM = 0;
if (!$f_tamG)	$f_tamG = 0;
if (!$f_tamGG)	$f_tamGG = 0;
if (!$tam_unqt)	$tam_unqt = 0;

if (!$peso)	$peso = 0;
if (!$garantia)	$garantia = " ";
if (!$informacoes) $informacoes = " ";

$inseriu = false;
$ids = "";

if ($loja == 0) {
	$sql = "SELECT NR_SEQ_LOJA_LJRC FROM lojas WHERE ST_LOJA_LJRC = 'A'";
	$st2 = mysql_query($sql);
	$up1 = array();
	$up2 = array();
	while($row = mysql_fetch_row($st2)) {
		$id_loja = $row[0];
		$str = "INSERT INTO produtos (NR_SEQ_LOJAS_PRRC,
							NR_SEQ_TIPO_PRRC,
							NR_SEQ_CATEGORIA_PRRC,
							NR_SEQ_MUSICA_PRRC,
							DS_REFERENCIA_PRRC,
							DS_PRODUTO2_PRRC,
							VL_PRODUTO_PRRC,
							DT_CADASTRO_PRRC,
							NR_VISITAS_PRRC,
							NR_PESOGRAMAS_PRRC,
							DS_GARANTIA_PRRC,
							DS_INFORMACOES_PRRC, 
							DS_CLASSIC_PRRC,
							TP_DESTAQUE_PRRC,
							DS_FRETEGRATIS_PRRC,
							VL_PROMO_PRRC,
							ST_PRODUTOS_PRRC) VALUES 
							($id_loja,$tipo,$categoria,$musica,'$ref','$descricao',$valor,sysdate(),0,$peso,'$garantia','$informacoes','N',$destaque,'$frete',$vlrpromo,'$status')";
		$st = mysql_query($str);
		$id = mysql_insert_id();
		
		if (!$up1) {
			$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;
	
			if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
			{
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
				$imagem_nome = $id . "." . $ext[1];
				$imagem_dir = "../arquivos/uploads/produtos/" . $imagem_nome;
				move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
				$up1[0] = $id;
				$up1[1] = $ext[1];
				
				$strp = "update produtos set DS_EXT_PRRC = '" . $ext[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $id";
				$stp = mysql_query($strp);
				
				$ids .= $id . ";" . $ext[1] . "|"; 
			}
		}else{
			$imagem_at = "../arquivos/uploads/produtos/" . $up1[0] . "." . $up1[1];
			$imagem_nv = "../arquivos/uploads/produtos/" . $id . "." . $up1[1];
			copy($imagem_at, $imagem_nv);
			
			$strp = "update produtos set DS_EXT_PRRC = '" . $up1[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $id";
			$stp = mysql_query($strp);
			
			$ids .= $id . ";" . $up1[1] . "|"; 
		}	
		
		if (!$up2) {
			$arquivo2 = isset($_FILES["FILE2"]) ? $_FILES["FILE2"] : FALSE;
		
			if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo2["type"]))
			{
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo2["name"], $ext2);
				$imagem_nome2 = $id . "." . $ext2[1];
				$imagem_dir2 = "../images/tamanhos/" . $imagem_nome2;
				move_uploaded_file($arquivo2["tmp_name"], $imagem_dir2);
				$up2[0] = $id;
				$up2[1] = $ext2[1];
				
				$strp = "update produtos set DS_EXTTAM_PRRC = '" . $ext2[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $id";
				$stp = mysql_query($strp);
			}
		}else{
			$imagem_at = "../images/tamanhos/" . $up2[0] . "." . $up2[1];
			$imagem_nv = "../images/tamanhos/" . $id . "." . $up2[1];
			copy($imagem_at, $imagem_nv);
			
			$strp = "update produtos set DS_EXTTAM_PRRC = '" . $up2[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $id";
			$stp = mysql_query($strp);
		}	
		
		if ($tam_un != "S") {
			if ($m_tamPP > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 1, $m_tamPP)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($m_tamP > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 2, $m_tamP)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($m_tamM > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 3, $m_tamM)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($m_tamG > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 4, $m_tamG)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($m_tamGG > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 5, $m_tamGG)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($f_tamPP > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 6, $f_tamPP)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($f_tamP > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 7, $f_tamP)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($f_tamM > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 8, $f_tamM)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($f_tamG > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 9, $f_tamG)";
				$st = mysql_query($str);
				$inseriu = true;
			}
			if ($f_tamGG > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 10, $f_tamGG)";
				$st = mysql_query($str);
				$inseriu = true;
			}
		}else{
			if ($tam_unqt > 0) {
				$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($id_loja, $id, 11, $tam_unqt)";
				$st = mysql_query($str);
				$inseriu = true;
			}
		}
	}
}else{
	$str = "INSERT INTO produtos (NR_SEQ_LOJAS_PRRC,
							NR_SEQ_TIPO_PRRC,
							NR_SEQ_CATEGORIA_PRRC,
							NR_SEQ_MUSICA_PRRC,
							DS_REFERENCIA_PRRC,
							DS_PRODUTO2_PRRC,
							VL_PRODUTO_PRRC,
							DT_CADASTRO_PRRC,
							NR_VISITAS_PRRC,
							NR_PESOGRAMAS_PRRC,
							DS_GARANTIA_PRRC,
							DS_INFORMACOES_PRRC,
							DS_CLASSIC_PRRC,
							TP_DESTAQUE_PRRC,
							DS_FRETEGRATIS_PRRC,
							VL_PROMO_PRRC,
							ST_PRODUTOS_PRRC) VALUES 
							($loja,$tipo,$categoria,$musica,'$ref','$descricao',$valor,sysdate(),0,$peso,'$garantia','$informacoes','N',$destaque,'$frete',$vlrpromo,'$status')";
	$st = mysql_query($str);
	$id = mysql_insert_id();
	
	$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

	if(eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
	{
		preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
		$imagem_nome = $id . "." . $ext[1];
		$imagem_dir = "../arquivos/uploads/produtos/" . $imagem_nome;
		move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
		
		$strp = "update produtos set DS_EXT_PRRC = '" . $ext[1]. "' WHERE NR_SEQ_PRODUTO_PRRC = $id";
		$stp = mysql_query($strp);
		
		$ids .= $id . ";" . $ext[1] . "|"; 
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
	
	if ($tam_un != "S") {
		if ($m_tamPP > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 1, $m_tamPP)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($m_tamP > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 2, $m_tamP)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($m_tamM > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 3, $m_tamM)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($m_tamG > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 4, $m_tamG)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($m_tamGG > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 5, $m_tamGG)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($f_tamPP > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 6, $f_tamPP)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($f_tamP > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 7, $f_tamP)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($f_tamM > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 8, $f_tamM)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($f_tamG > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 9, $f_tamG)";
			$st = mysql_query($str);
			$inseriu = true;
		}
		if ($f_tamGG > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 10, $f_tamGG)";
			$st = mysql_query($str);
			$inseriu = true;
		}
	}else{
		if ($tam_unqt > 0) {
			$str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) VALUES ($loja, $id, 11, $tam_unqt)";
			$st = mysql_query($str);
			$inseriu = true;
		}
	}
}

mysql_close($con);

if ($ids) {
	$direciona1 = "Location: resize.asp?ids=$ids";
	$direciona2 = "resize.asp?ids=$ids";
}else{
	$direciona1 = "Location: grupos.php";
	$direciona2 = "grupos.php";
}

if ($inseriu) {
	Header($direciona1);
}else{
?>
 <script>
 alert('Produto incluido sem estoque. Para adicionar estoque ao mesmo clique no icone alterar!');
 window.location="<?php echo $direciona2; ?>";
 </script>
<?php } ?>