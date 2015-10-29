<?php
	include 'lib.php';

	$dataReferencia = date('m-Y', strtotime('-1 month'));

	$body = '<a style="font-family:Verdana;font-size:12px; width: 570px; margin-top: 15px;" href="https://www.reverbcity.com/Readm_911s/xx_defeitos.php?data='.$dataReferencia.'">https://www.reverbcity.com/Readm_911s/xx_defeitos.php?data='.$dataReferencia.'</a>';

	$dataReferencia = explode('-', $dataReferencia);
	$dataReferencia = $dataReferencia[0].'/'.$dataReferencia[1];
	
	$body = IncluiPapelCarta("sistema",$body,'Camisetas com defeito - '. $dataReferencia); 

	$contatos = array('tony' => "contato@reverbcity.com",
                  'moda' => "moda@reverbcity.com",
                  'miria' => 'atendimento@reverbcity.com',
                  'jana' => 'janaina@reverbcity.com');

	foreach ($contatos as $key => $contato) {
		EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$contato,"","",'Camisetas com defeito - ' . $dataReferencia, $body);
	}
?>