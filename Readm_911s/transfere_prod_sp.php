<?php
include 'auth.php';
include 'lib.php';

$produtos = array("4726","4727","4728","4729","4730","4731","4732","4733","4734","4735","4736","4737");

for ($i = 0; $i < count($produtos); $i++) { 
    $idprod = $produtos[$i];
    $qtprod = 1;
    
    $sqlprod = "select DS_PRODUTO2_PRRC, NR_SEQ_TIPO_PRRC, NR_SEQ_CATEGORIA_PRRC, DS_REFERENCIA_PRRC, NR_SEQ_TAMANHO_ESRC
                from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC and
                NR_SEQ_PRODUTO_PRRC = $idprod";
    $stprod = mysql_query($sqlprod);

	if (mysql_num_rows($stprod) > 0) {
		$retprod = mysql_fetch_row($stprod);
        $prod_nome = $retprod[0];
        $prod_tipo = $retprod[1];
        $prod_cate = $retprod[2];
        $prod_refe = $retprod[3];
        $tmprod    = $retprod[4];
    }
    
    //consulta para ver se o produto existe em SP
    $sqlprod = "select NR_SEQ_PRODUTO_PRRC from produtos WHERE
                DS_PRODUTO2_PRRC = '$prod_nome' and
                NR_SEQ_TIPO_PRRC = $prod_tipo and
                NR_SEQ_CATEGORIA_PRRC = $prod_cate and 
                DS_REFERENCIA_PRRC = '$prod_refe' and
                NR_SEQ_LOJAS_PRRC = 2";
    
    $stprod = mysql_query($sqlprod);
	if (mysql_num_rows($stprod) > 0) {
	    //caso exista, pega o codigo
		$retprod = mysql_fetch_row($stprod);
        $prod_codigo = $retprod[0];
        
        //consulta o estoque para ver se já existe do mesmo tamanho
        $sqlest = "select NR_SEQ_PRODUTO_ESRC from estoque WHERE NR_SEQ_PRODUTO_ESRC = $prod_codigo and NR_SEQ_TAMANHO_ESRC = $tmprod";
        $stesto = mysql_query($sqlest);
    	if (mysql_num_rows($stesto) > 0) {
    	    //caso exista no estoque, apenas aumenta a quantidade
	        $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC + ".$qtprod." WHERE NR_SEQ_PRODUTO_ESRC = ".$prod_codigo." AND
                    NR_SEQ_TAMANHO_ESRC = ".$tmprod;
            $st4 = mysql_query($str4);
            GravaLogEstoque($SS_logadm,$prod_codigo,$tmprod,"Adicionou $qtprod","Entrada Nova",$qtprod);
        }else{
            //caso nao exista, insere uma nova quantidade no estoque
            $str4 = "INSERT INTO estoque (NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) values
                     ($prod_codigo, $tmprod, $qtprod)";
            $st4 = mysql_query($str4);
            GravaLogEstoque($SS_logadm,$prod_codigo,$tmprod,"Adicionou $qtprod","Entrada Nova",$qtprod);
        }
    }else{
        //caso não exista, duplica o produto para SP
        
        $sqldupl = "select * from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
                 AND NR_SEQ_PRODUTO_PRRC = $idprod";
        $stdup = mysql_query($sqldupl);
        if (mysql_num_rows($stdup) > 0) {
            $rowdup = mysql_fetch_array($stdup);
            $strdup = "INSERT INTO produtos (
                    NR_SEQ_LOJAS_PRRC,
                    NR_SEQ_TIPO_PRRC,
                    NR_SEQ_CATEGORIA_PRRC,
                    NR_SEQ_ESTILO_PRRC,
                    NR_SEQ_MUSICA_PRRC,
                    DS_REFERENCIA_PRRC,
                    DS_PRODUTO2_PRRC,
                    VL_PRODUTO_PRRC,
                    DT_CADASTRO_PRRC,
                    NR_VISITAS_PRRC,
                    NR_PESOGRAMAS_PRRC,
                    DS_GARANTIA_PRRC,
                    DS_EXT_PRRC,
                    DS_EXTTAM_PRRC,
                    DS_CLASSIC_PRRC,
                    DS_INFORMACOES_PRRC,
                    TP_DESTAQUE_PRRC,
                    DS_FRETEGRATIS_PRRC,
                    VL_PROMO_PRRC,
                    ST_PRODUTOS_PRRC,
                    DT_CRIACAO_PRRC,
                    DS_IMMEM_PRRC,
                    VL_PRODUTO2_PRRC) values (
                    2,
                    ".formataCampo($rowdup["NR_SEQ_TIPO_PRRC"]).",
                    ".formataCampo($rowdup["NR_SEQ_CATEGORIA_PRRC"]).",
                    ".formataCampo($rowdup["NR_SEQ_ESTILO_PRRC"]).",
                    ".formataCampo($rowdup["NR_SEQ_MUSICA_PRRC"]).",
                    '".$rowdup["DS_REFERENCIA_PRRC"]."',
                    '".$rowdup["DS_PRODUTO2_PRRC"]."',
                    ".formataCampo($rowdup["VL_PRODUTO_PRRC"]).",
                    '".$rowdup["DT_CADASTRO_PRRC"]."',
                    ".formataCampo($rowdup["NR_VISITAS_PRRC"]).",
                    ".formataCampo($rowdup["NR_PESOGRAMAS_PRRC"]).",
                    '".$rowdup["DS_GARANTIA_PRRC"]."',
                    '".$rowdup["DS_EXT_PRRC"]."',
                    '".$rowdup["DS_EXTTAM_PRRC"]."',
                    '".$rowdup["DS_CLASSIC_PRRC"]."',
                    '".$rowdup["DS_INFORMACOES_PRRC"]."',
                    ".formataCampo($rowdup["TP_DESTAQUE_PRRC"]).",
                    '".$rowdup["DS_FRETEGRATIS_PRRC"]."',
                    ".formataCampo($rowdup["VL_PROMO_PRRC"]).",
                    'A',
                    '".$rowdup["DT_CRIACAO_PRRC"]."',
                    '".$rowdup["DS_IMMEM_PRRC"]."',
                    ".formataCampo($rowdup["VL_PRODUTO2_PRRC"]).")";
            $stdupp = mysql_query($strdup);
            $iddupp = mysql_insert_id();
            
            $str4 = "INSERT INTO estoque (NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) values
                     ($iddupp, $tmprod, $qtprod)";
            $st4 = mysql_query($str4);
            GravaLogEstoque($SS_logadm,$iddupp,$tmprod,"Adicionou $qtprod","Transf. Londrina($nr_pedido)",$qtprod);
            
            $newfile1 = $iddupp.".".$rowdup["DS_EXT_PRRC"];
            $newfile2 = $iddupp."p.".$rowdup["DS_EXT_PRRC"];
            
            $file1 = $rowdup["NR_SEQ_PRODUTO_PRRC"].".".$rowdup["DS_EXT_PRRC"];
            $file2 = $rowdup["NR_SEQ_PRODUTO_PRRC"]."p.".$rowdup["DS_EXT_PRRC"];
            if (file_exists("../arquivos/uploads/produtos/".$file1)) copy("../arquivos/uploads/produtos/".$file1, "../arquivos/uploads/produtos/".$newfile1);
            if (file_exists("../arquivos/uploads/produtos/".$file2)) copy("../arquivos/uploads/produtos/".$file2, "../arquivos/uploads/produtos/".$newfile2);
            
            $sql3 = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, ZOOM_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = ".$rowdup["NR_SEQ_PRODUTO_PRRC"]." order by NR_ORDEM_FORC, NR_SEQ_FOTO_FORC";
            $st3 = mysql_query($sql3);
            if (mysql_num_rows($st3) > 0) {
            	while($row3 = mysql_fetch_array($st3)) {
            		$str2ft = "INSERT INTO fotos (NR_SEQ_PRODUTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, NR_ORDEM_FORC, ZOOM_FORC)
                            VALUES (
                            ".$iddupp.",
                            '".$row3["DS_EXT_FORC"]."',
                            '".$row3["DS_LEGENDA_FORC"]."',
                            ".formataCampo($row3["NR_ORDEM_FORC"]).",
                            ".formataCampo($row3["ZOOM_FORC"]).")";
                    $st4 = mysql_query($str2ft);
                    $idfoto = mysql_insert_id();
                     
                    $file1 = $row3["NR_SEQ_FOTO_FORC"].".".$row3["DS_EXT_FORC"];
                    $file2 = $row3["NR_SEQ_FOTO_FORC"]."g.".$row3["DS_EXT_FORC"];
                    $file3 = $row3["NR_SEQ_FOTO_FORC"]."p.".$row3["DS_EXT_FORC"];
                    
                    $newfile1 = $idfoto.".".$row3["DS_EXT_FORC"];
                    $newfile2 = $idfoto."g.".$row3["DS_EXT_FORC"];
                    $newfile3 = $idfoto."p.".$row3["DS_EXT_FORC"];
                                
                    if (file_exists("../arquivos/uploads/fotosprodutos/".$file1)) copy("../arquivos/uploads/fotosprodutos/".$file1, "../arquivos/uploads/fotosprodutos/".$newfile1);
                    if (file_exists("../arquivos/uploads/fotosprodutos/".$file2)) copy("../arquivos/uploads/fotosprodutos/".$file2, "../arquivos/uploads/fotosprodutos/".$newfile2);
                    if (file_exists("../arquivos/uploads/fotosprodutos/".$file3)) copy("../arquivos/uploads/fotosprodutos/".$file3, "../arquivos/uploads/fotosprodutos/".$newfile3);
               }
            }
        }
    }
}


function PegaNomeProduto($produto){
	$sqlmin = "SELECT DS_PRODUTO2_PRRC FROM produtos WHERE NR_SEQ_PRODUTO_PRRC = $produto";
	$stmin = mysql_query($sqlmin);
	$retnome = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retnome = $rowmin[0];
	}
	return $retnome;
}

mysql_close($con);

function TrataStr($texto1){
    if (!$texto1){
    	$texto1 = "null";
    }else{
        $texto1 = "'".$texto1."'";
    }
    return $texto1;
}
function TrataInt($texto2){
    if (!$texto2){
    	$texto2 = "null";
    }else{
        $texto2 = $texto2;
    }
    return $texto2;
}
function TrataValor($vlrr){
    if (!$vlrr){
    	$vlrr = "null";
    }else{
        $vlrr = str_replace(",",".",$vlrr);
    }
    return $vlrr;
}

function formataCampo($campo){
    $retorno = "null";
    if (!$campo){
        $retorno = "null";
    }else{
        $retorno = $campo;
    }
    return $retorno;
}
?>