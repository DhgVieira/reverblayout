<?php
include 'lib.php';
include('phplot.php');

$ano = request("ano");

$data2 = array();

$meses = array('Janeiro','Fevereiro','Marco','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

for ($f=1;$f<13;$f++){
    $cad_comcpras = 0;
    $sql = "select count(*) from cadastros, compras where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
        AND DT_COMPRA_COSO > DT_CADASTRO_CASO and month(DT_CADASTRO_CASO) = $f and year(DT_CADASTRO_CASO) = $ano
        AND ST_COMPRA_COSO <> 'C'";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
      $row = mysql_fetch_row($st);
      $cad_comcpras = $row[0];
    }
    
    $ticketmedio = 0;
    $sql = "SELECT sum(VL_TOTAL_COSO) from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
            AND DT_COMPRA_COSO > DT_CADASTRO_CASO and month(DT_CADASTRO_CASO) = $f and year(DT_CADASTRO_CASO) = $ano
            AND ST_COMPRA_COSO <> 'C'";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
      $row = mysql_fetch_row($st);
      $ticketmedio = $row[0];
    }
    
    if ($cad_comcpras != 0){
        $data2[$f-1] = array($meses[$f-1],$cad_comcpras,number_format($ticketmedio/$cad_comcpras,1,".",""));
    }else{
        $data2[$f-1] = array($meses[$f-1],'','');
    }
}

$graph = new PHPlot(800, 400);

$graph->SetPlotType('bars');
$graph->SetDataType('text-data');
$graph->SetTitle("Primeira Compra x Ticket Medio - $ano");
$graph->SetShading(0);
$graph->SetDataBorderColors('black');
$graph->SetYDataLabelPos('plotin');
$graph->SetPlotAreaWorld(NULL, 0);
$graph->SetXTickLabelPos('none');
$graph->SetXTickPos('none');
$graph->SetDataValues($data2);
$graph->SetLegend(array('Quantidade','Ticket Medio (R$)'));

# cada valor com uma cor
//$graph->SetCallback('data_color', 'pickcolor');
//foreach ($data as $row)
//  $graph->SetLegend(implode(': ', $row));
//function pickcolor($img, $ignore, $row, $col)
//{
//  return $row;
//}

$graph->DrawGraph();
?>