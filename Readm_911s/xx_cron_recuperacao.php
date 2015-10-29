<?php
	include 'lib.php';

	$dataReferencia = date('Y-m-d');

	$body = '<a style="font-family:Verdana;font-size:12px; width: 570px; margin-top: 15px;" href="https://www.reverbcity.com/Readm_911s/rel_recuperacao_carrinho.php?data='.$dataReferencia.'">https://www.reverbcity.com/Readm_911s/rel_recuperacao_carrinho.php?data='.$dataReferencia.'</a>';
	
	$body = IncluiPapelCarta("sistema",$body,'Recuperação de carrinho - '. date('d/m/Y')); 

	$contatos = array('daniel' => "daniel.arbext@gmail.com",
                  'tony' => "contato@reverbcity.com",
                  'marcio' => "marcio@reverbcity.com",
                  'miria' => 'atendimento@reverbcity.com');
	
	foreach ($contatos as $key => $contato) {
		EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$contato,"","",'Recuperação de carrinho - ' . date('d/m/Y'), $body);
	}
?>