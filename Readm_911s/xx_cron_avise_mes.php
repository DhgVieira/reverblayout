<?php
	include 'lib.php';

	$dataReferencia = date('Y-m-d');

	$body = '<a style="font-family:Verdana;font-size:12px; width: 570px; margin-top: 15px;" href="https://www.reverbcity.com/Readm_911s/rel_avise.php?data='.$dataReferencia.'&semana=0">
		https://www.reverbcity.com/Readm_911s/rel_avise.php?data='.$dataReferencia.'&semana=0
		</a>';

	$dataReferencia = explode('-', $dataReferencia);
	$dataReferencia = $dataReferencia[0].'/'.$dataReferencia[1];
	
	$body = IncluiPapelCarta("sistema",$body,'Relatório avise-me - '. $dataReferencia); 

	$contatos = array('daniel' => "daniel.arbext@gmail.com",
                  'tony' => "contato@reverbcity.com",
                  'jonathan' => "moda@reverbcity.com",
                  'jana' => 'janaina@reverbcity.com');


	foreach ($contatos as $key => $contato) {
		EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$contato,"","",'Relatório avise-me mensal - ' . $dataReferencia, $body);
	}
?>