<?php
exit();
include 'auth.php';
include 'lib.php';

$sql2 = "select * from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
         AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND NR_SEQ_LOJAS_PRRC = 1 AND ST_PRODUTOS_PRRC = 'A' and NR_SEQ_PRODUTO_PRRC > 1485 group by NR_SEQ_PRODUTO_PRRC order by NR_SEQ_PRODUTO_PRRC";
$st2 = mysql_query($sql2);
while($row2 = mysql_fetch_array($st2)) {
    $str = "INSERT INTO produtos (
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
            ".formataCampo($row2["NR_SEQ_TIPO_PRRC"]).",
            ".formataCampo($row2["NR_SEQ_CATEGORIA_PRRC"]).",
            ".formataCampo($row2["NR_SEQ_ESTILO_PRRC"]).",
            ".formataCampo($row2["NR_SEQ_MUSICA_PRRC"]).",
            '".$row2["DS_REFERENCIA_PRRC"]."',
            '".$row2["DS_PRODUTO2_PRRC"]."',
            ".formataCampo($row2["VL_PRODUTO_PRRC"]).",
            '".$row2["DT_CADASTRO_PRRC"]."',
            ".formataCampo($row2["NR_VISITAS_PRRC"]).",
            ".formataCampo($row2["NR_PESOGRAMAS_PRRC"]).",
            '".$row2["DS_GARANTIA_PRRC"]."',
            '".$row2["DS_EXT_PRRC"]."',
            '".$row2["DS_EXTTAM_PRRC"]."',
            '".$row2["DS_CLASSIC_PRRC"]."',
            '".$row2["DS_INFORMACOES_PRRC"]."',
            ".formataCampo($row2["TP_DESTAQUE_PRRC"]).",
            '".$row2["DS_FRETEGRATIS_PRRC"]."',
            ".formataCampo($row2["VL_PROMO_PRRC"]).",
            '".$row2["ST_PRODUTOS_PRRC"]."',
            '".$row2["DT_CRIACAO_PRRC"]."',
            '".$row2["DS_IMMEM_PRRC"]."',
            ".formataCampo($row2["VL_PRODUTO2_PRRC"]).")";
    echo "Duplicou Produto ID: ".$row2["NR_SEQ_PRODUTO_PRRC"]."<br>";
    $st = mysql_query($str);
    $id = mysql_insert_id();
    
    $newfile1 = $id.".".$row2["DS_EXT_PRRC"];
    $newfile2 = $id."p.".$row2["DS_EXT_PRRC"];
    
    $file1 = $row2["NR_SEQ_PRODUTO_PRRC"].".".$row2["DS_EXT_PRRC"];
    $file2 = $row2["NR_SEQ_PRODUTO_PRRC"]."p.".$row2["DS_EXT_PRRC"];
    if (file_exists("../images/produtos/".$file1)) copy("../images/produtos/".$file1, "../images/produtos/".$newfile1);
    if (file_exists("../images/produtos/".$file2)) copy("../images/produtos/".$file2, "../images/produtos/".$newfile2);
    
    $sql3 = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, ZOOM_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = ".$row2["NR_SEQ_PRODUTO_PRRC"]." order by NR_ORDEM_FORC, NR_SEQ_FOTO_FORC";
    $st3 = mysql_query($sql3);
    if (mysql_num_rows($st3) > 0) {
    	while($row3 = mysql_fetch_array($st3)) {
    		$str2 = "INSERT INTO fotos (NR_SEQ_PRODUTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, NR_ORDEM_FORC, ZOOM_FORC)
                    VALUES (
                    ".$id.",
                    '".$row3["DS_EXT_FORC"]."',
                    '".$row3["DS_LEGENDA_FORC"]."',
                    ".formataCampo($row3["NR_ORDEM_FORC"]).",
                    ".formataCampo($row3["ZOOM_FORC"]).")";
            $st4 = mysql_query($str2);
            $idfoto = mysql_insert_id();
             
            $file1 = $row3["NR_SEQ_FOTO_FORC"].".".$row3["DS_EXT_FORC"];
            $file2 = $row3["NR_SEQ_FOTO_FORC"]."g.".$row3["DS_EXT_FORC"];
            $file3 = $row3["NR_SEQ_FOTO_FORC"]."p.".$row3["DS_EXT_FORC"];
            
            $newfile1 = $idfoto.".".$row3["DS_EXT_FORC"];
            $newfile2 = $idfoto."g.".$row3["DS_EXT_FORC"];
            $newfile3 = $idfoto."p.".$row3["DS_EXT_FORC"];
                        
            if (file_exists("../images/produtos/adic/".$file1)) copy("../images/produtos/adic/".$file1, "../images/produtos/adic/".$newfile1);
            if (file_exists("../images/produtos/adic/".$file2)) copy("../images/produtos/adic/".$file2, "../images/produtos/adic/".$newfile2);
            if (file_exists("../images/produtos/adic/".$file3)) copy("../images/produtos/adic/".$file3, "../images/produtos/adic/".$newfile3);
       }
    }
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