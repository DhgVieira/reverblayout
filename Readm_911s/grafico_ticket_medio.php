<?php
include 'lib.php';
include('phplot.php');

$ano = request("ano");

$data2 = array();

$meses = array('Janeiro','Fevereiro','Marco','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

for ($f=1;$f<13;$f++){
    $cadastros = 0;
    $sql = "select count(*) from cadastros where month(DT_CADASTRO_CASO) = $f and year(DT_CADASTRO_CASO) = $ano";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
      $row = mysql_fetch_row($st);
      $cadastros = $row[0];
    }
    
    $cad_comcpras = 0;
    $sql = "select count(*) from cadastros where month(DT_CADASTRO_CASO) = $f and year(DT_CADASTRO_CASO) = $ano
        AND NR_SEQ_CADASTRO_CASO IN (SELECT NR_SEQ_CADASTRO_COSO from compras WHERE ST_COMPRA_COSO <> 'C' and 
        month(DT_COMPRA_COSO) = $f and year(DT_COMPRA_COSO) = $ano)";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
      $row = mysql_fetch_row($st);
      $cad_comcpras = $row[0];
    }
    
    $ticketmedio = 0;
    $sql = "SELECT sum(VL_TOTAL_COSO) from compras WHERE ST_COMPRA_COSO <> 'C' and month(DT_COMPRA_COSO) = $f and year(DT_COMPRA_COSO) = $ano
            AND NR_SEQ_CADASTRO_COSO IN (select NR_SEQ_CADASTRO_CASO from cadastros where month(DT_CADASTRO_CASO) = $f and year(DT_CADASTRO_CASO) = $ano)";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
      $row = mysql_fetch_row($st);
      $ticketmedio = $row[0];
    }
    
    if ($cadastros != 0){
        $data2[$f-1] = array($meses[$f-1],$cadastros,number_format($ticketmedio/$cad_comcpras,1,".",""));
    }else{
        $data2[$f-1] = array($meses[$f-1],'','');
    }
}

$graph = new PHPlot(800, 400);

$graph->SetPlotType('bars');
$graph->SetDataType('text-data');
$graph->SetTitle("Novos Cadastros x Ticket Medio - $ano");
$graph->SetShading(0);
$graph->SetDataBorderColors('black');
$graph->SetYDataLabelPos('plotin');
$graph->SetPlotAreaWorld(NULL, 0);
$graph->SetXTickLabelPos('none');
$graph->SetXTickPos('none');
$graph->SetDataValues($data2);
$graph->SetLegend(array('Cadastros','Ticket Medio (R$)'));

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