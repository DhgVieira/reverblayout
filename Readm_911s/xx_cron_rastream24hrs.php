<?php

$dia = date("d");
$mes = date("m");
$ano = date("Y");

require_once 'codigo-correios.php';

$objCodigoCorreios= new CodigoCorreios();

$objCodigoCorreios->dia = $dia;
$objCodigoCorreios->mes = $mes;
$objCodigoCorreios->ano = $ano;

$msgfim = $objCodigoCorreios->innitOrders();

echo $msgfim;