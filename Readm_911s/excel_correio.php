<?php
include 'auth.php';
include 'lib.php';

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('America/Sao_Paulo');

$pedido = request("ped");
         
$sql2 = "SELECT DS_CATEGORIA_PTRC, count(*), sum(VL_PRODUTO_CESO*NR_QTDE_CESO), NR_SEQ_TIPO_PRRC, NR_SEQ_CATEGORIA_PRRC,
        sum(NR_QTDE_CESO) from cestas, produtos, produtos_tipo where NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
         and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_COMPRA_CESO = $pedido GROUP BY NR_SEQ_TIPO_PRRC";
$st2 = mysql_query($sql2);

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . 'Excel/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';

$inputFileName = 'SEGUROCORREIOS.xls';

$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

$objWorksheet = $objPHPExcel->getActiveSheet();

$objWorksheet->getCell('A1')->setValue('PEDIDO '.$pedido);

if (mysql_num_rows($st2) > 0) {
    $cell = 13;
    $x = 1;
    $total = 0;
    while($row2 = mysql_fetch_row($st2)){
        $dstip = $row2[0];
        $qtde  = $row2[1];
        $valor = $row2[2];
        $nrtip = $row2[3];
        $nrcat = $row2[4];
        $nrqtde = $row2[5];
        
        $total += $valor;
        
        if ($nrtip == 52 || $nrtip == 51 || $nrtip == 54 || $nrtip == 55){
            $sql = "select DS_CATEGORIA_PCRC from produtos_categoria where NR_SEQ_CATEGPRO_PCRC = $nrcat";
            $st = mysql_query($sql);
            if (mysql_num_rows($st) > 0) {
                $row = mysql_fetch_row($st);
                $dstip = $row[0];
            }
        }
        
        $objWorksheet->getCell('A'.$cell)->setValue($x);
        $objWorksheet->getCell('C'.$cell)->setValue($nrqtde);
        $objWorksheet->getCell('E'.$cell)->setValue($dstip);
        $objWorksheet->getCell('L'.$cell)->setValue('R$ '.number_format($valor,2,",",""));
        
        $cell += 20;
        
        $objWorksheet->getCell('A'.$cell)->setValue($x);
        $objWorksheet->getCell('C'.$cell)->setValue($nrqtde);
        $objWorksheet->getCell('E'.$cell)->setValue($dstip);
        $objWorksheet->getCell('L'.$cell)->setValue('R$ '.number_format($valor,2,",",""));
        
        $cell += 20;
        
        $objWorksheet->getCell('A'.$cell)->setValue($x);
        $objWorksheet->getCell('C'.$cell)->setValue($nrqtde);
        $objWorksheet->getCell('E'.$cell)->setValue($dstip);
        $objWorksheet->getCell('L'.$cell)->setValue('R$ '.number_format($valor,2,",",""));
        
        $cell -= 39;
        $x++;
	}
}

//$sql = "select VL_TOTAL_COSO from compras where NR_SEQ_COMPRA_COSO = $pedido";
//$st = mysql_query($sql);
//if (mysql_num_rows($st) > 0) {
//    $row = mysql_fetch_row($st);
//    $total = $row[0];
//}

$objWorksheet->getCell('L17')->setValue('R$ '.number_format($total,2,",",""));
$objWorksheet->getCell('L37')->setValue('R$ '.number_format($total,2,",",""));
$objWorksheet->getCell('L57')->setValue('R$ '.number_format($total,2,",",""));

$objWorksheet->getCell('A20')->setValue(date("d/m/Y"));
$objWorksheet->getCell('A40')->setValue(date("d/m/Y"));
$objWorksheet->getCell('A60')->setValue(date("d/m/Y"));

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('temp/SEGUROCORREIOS_'.$pedido.'.xls');

mysql_close($con);
Header("Location: temp/SEGUROCORREIOS_$pedido.xls");
?>