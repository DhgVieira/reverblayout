<?php
include 'lib.php';

$val_fem = request("fem");
$val_masc = request("mas");

//Include a classe phplot
include('phplot.php');//mude de acrodo com a sua situação

//Define o objeto
$graph = new PHPlot(300, 230);

$data = array(
  array('Homens', $val_masc),
  array('Mulheres', $val_fem),
);


$graph->SetImageBorderType('plain');

$graph->SetPlotType('pie');
$graph->SetDataType('text-data-single');
$graph->SetDataValues($data);

# Set enough different colors;
$graph->SetDataColors(array('red', 'blue'));

# Build a legend from our data array.
# Each call to SetLegend makes one line as "label: value".
foreach ($data as $row)
  $graph->SetLegend(implode(': ', $row));

$graph->DrawGraph();
?>