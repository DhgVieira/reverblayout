<?php
include 'auth.php';
include 'lib.php';

$mesn = date("m");
$anon = date("Y");

$sqladm = "SELECT day(DT_REGISTRO_ATRV), hour(DT_REGISTRO_ATRV), max(NR_QTDE_ATRV) FROM atividade WHERE DT_REGISTRO_ATRV > '$anon-$mesn-01 00:00:00' group by day(DT_REGISTRO_ATRV), hour(DT_REGISTRO_ATRV)";
$stadm = mysql_query($sqladm);
$retuser = "";
$result = array();
$resultitem = array();
if (mysql_num_rows($stadm) > 0) {
    $x=0;
    $y=0;
	while($rowadm = mysql_fetch_row($stadm)){
	   if ($y == 0){
	       $result[$x] = array($rowadm[1],$rowadm[2]);
           $y++;
       }else{
           $result[$x] = array('',$rowadm[2]);
           $y++;
           if ($y == 4) $y=0;
       }
       $x++;
    }
}
//Include a classe phplot
include('phplot.php');//mude de acrodo com a sua situação

//Define o objeto
$graph = new PHPlot(900, 180);

//Define alguns valores
$example_data = $result;

$graph->SetDataValues($example_data);
$graph->plot_type = 'lines';
$graph->SetDataType('text-data');
$graph->SetYTickIncrement(10);
$graph->SetXTickIncrement(24);
//$graph->SetTitle('Atividade www.reverbcity.com 09/2010');
$graph->SetLegend(array('Max Online'));
$graph->SetYTitle('Quantidade');
$graph->SetXTitle('Dia/Hora');
$graph->SetDataColors(array('red'));

$graph->DrawGraph(); //Desenha o gráfico 
?>