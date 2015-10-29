<?php
include 'auth.php';
include 'lib.php';

$pagina = request("pagina");
$busca = request("chave");

$num_por_pagina = 250;

$sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC, 
                 DS_TAMANHO_TARC, COUNT(*) as qtde, NR_SEQ_TAMANHO_AVRC, DT_SOLICITACAO_AVRC, NR_QTDE_ESRC
				 from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque
				 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
				 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
				 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'N' and
                 NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC ";
if ($busca) $sql .= " AND DS_PRODUTO2_PRRC LIKE '%$busca%' ";
$sql .= "		 GROUP BY NR_SEQ_PRODUTO_PRRC";
$st = mysql_query($sql);                 
$total_usuarios = mysql_num_rows($st);

$total_paginas = ceil($total_usuarios/$num_por_pagina);

require_once("pdf/dompdf/dompdf_config.inc.php");

$num_por_pagina = 250;
if (!$pagina) {
 $pagina = 1;
}
$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
 
$html1 = "";

$html1 .= "<table border=0>";
$html1 .= " 	<tr>";
$html1 .= "     	<td></td>";
$html1 .= "         <td>Tipo</td>";
$html1 .= "         <td>Ref.</td>";
$html1 .= "         <td>Descri&ccedil;&atilde;o</td>";
$html1 .= "         <td>Tamanhos</td>";
$html1 .= "     </tr>";
  
  $sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC, 
                 DS_TAMANHO_TARC, COUNT(*) as qtde, NR_SEQ_TAMANHO_AVRC, DT_SOLICITACAO_AVRC, NR_QTDE_ESRC
				 from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque
				 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
				 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
				 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'N' and
                 NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC ";
  if ($busca) $sql .= " AND DS_PRODUTO2_PRRC LIKE '%$busca%' ";
  $sql .= " GROUP BY NR_SEQ_PRODUTO_PRRC order by DS_CATEGORIA_PTRC, DS_PRODUTO2_PRRC, qtde desc LIMIT $primeiro_registro, $num_por_pagina";
  $st = mysql_query($sql);

  if (mysql_num_rows($st) > 0) {
	$xtot = 0;
    $tr = 0;
  	while($row = mysql_fetch_row($st)) {
	 $mostraprod = true;
	 
	 $id_prod	   = $row[0];
     $dt_prod	   = $row[1];
	 $ds_tipo	   = utf8_decode($row[2]);
	 $ds_ref	   = $row[3];
	 $vl_prod	   = $row[4];
	 $ds_prod	   = utf8_decode($row[5]);
	 $ds_loja	   = $row[6];
	 $ext		   = $row[7];
	 $ext2		   = $row[8];
	 $status	   = $row[9];
	 $vlrpromo	   = $row[10];
	 $tamanho	   = $row[11];
	 $qtdepess	   = $row[12];
     $idtamanho	   = $row[13];
     
     $datasoli	   = $row[14];
     $estoque	   = $row[15];
     
     //$sqlest = "SELECT NR_QTDE_ESRC FROM estoque WHERE NR_SEQ_PRODUTO_ESRC = $id_prod AND NR_SEQ_TAMANHO_ESRC = $idtamanho and NR_QTDE_ESRC > 0";
     //$stest = mysql_query($sqlest);
     $qtdees = 0;
     $bgtab = "#FDEBDF";
     if ($estoque > 0) {
     //if (mysql_num_rows($stest) > 0) {
     //   $rowest = mysql_fetch_row($stest);
     //   $qtdees = $rowest[0];
        $qtdees = $estoque;
        $bgtab = "#CBFEAD";
     }else{
        $qtdees = 0;
        $bgtab = "#FFFFFF";
     }
	 
	 if ($mostraprod) {
	 $xtot++;
    
    if ($qtdees <= 0) {
        
    $tamanhos = "";
        
    $sql22 = "select DS_TAMANHO_TARC, COUNT(*) as qtde from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque
				 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
				 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
				 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'N' and
                 NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC AND NR_SEQ_PRODUTO_PRRC = $id_prod
				 GROUP BY NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC order by DS_PRODUTO2_PRRC, qtde desc";
    $st22 = mysql_query($sql22);

    if (mysql_num_rows($st22) > 0) {
  	     while($row22 = mysql_fetch_row($st22)) {
  	         $tamanhos .= $row22[0]."(".$row22[1].") ";
	     }
    }   
        
    $html1 .= "	<tr><td><img src=../arquivos/uploads/produtos/".$id_prod.".$ext width=45 height=52/></td><td>$ds_tipo</td><td>$ds_ref</td><td>$ds_prod</td><td>$tamanhos</td></tr>";
        
    }

	  }
	}
  }
 
$html1 .= "</table>";
                        
mysql_close($con);

$dompdf = new DOMPDF();
$dompdf->load_html($html1);
$dompdf->set_paper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Aviseme $pagina de $total_paginas.pdf");
?>