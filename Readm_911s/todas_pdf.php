<?php 
include 'lib.php';
include 'auth.php';

require_once("pdf/fpdf.php");
 
$pdf= new FPDF("P","pt","A4");
$pdf->AddPage();
                           
$sql = "select NR_SEQ_PRODUTO_PRRC, VL_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC, TP_DESTAQUE_PRRC, DS_FRETEGRATIS_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PTRC, DS_TEXTO_PRRC
                     from produtos, estoque, produtos_tipo WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_LOJAS_PRRC = 1
                     AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A' AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC ";
$sql .= "AND NR_SEQ_TIPO_PRRC = 6 ";
$sql .= "group by NR_SEQ_PRODUTO_PRRC ";
$sql .= "ORDER BY DS_PRODUTO2_PRRC limit 10 ";

$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $xx=0;
    $pdf->SetFont('arial','',12);
    while($row = mysql_fetch_row($st)) {
        $id_prod	   = $row[0];
        $ds_prod	   = $row[2];
        $ds_ext		   = $row[3];
        
        $pdf->Image("http://www.reverbcity.com/arquivos/uploads/produtos/$id_prod.$ds_ext",null,null,120);
        $pdf->Write(5,$ds_prod);
    }
}
$pdf->Output("arquivo.pdf","D");
?>           