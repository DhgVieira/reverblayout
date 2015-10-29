<?php
include 'lib.php';
 $data_hoje = date("Y-m-d");



$mensagem .= utf8_decode("<p> Relatorio de participação de Blog");

 $sql_funcionarios = "SELECT
 							NR_SEQ_CADASTRO_CASO,
 							DS_NOME_CASO
 					 FROM 
 					 		cadastros
 					 where
 					  NR_SEQ_CADASTRO_CASO in (29424, 8185, 31165, 3388, 5189, 26087, 22652, 4162, 10470, 32609, 2) 
 					 ORDER BY DS_NOME_CASO ASC"; 


$st_funcionarios = mysql_query($sql_funcionarios);

if (mysql_num_rows($st_funcionarios) > 0) {
	while($row = mysql_fetch_row($st_funcionarios)) {
		    $idf	  = $row[0];
		    $nomef	  = $row[1];

		    $sql_total_comentarios = "SELECT 
		    							COUNT(NR_SEQ_COMENTARIO_CBRC) AS total_comentarios
		    						  FROM 
		    						  	blog_coments 
		    						  WHERE 
		    						  	NR_SEQ_CADASTRO_CBRC = $idf
		    						   AND DT_CADASTRO_CBRC < DATE_SUB(NOW(), INTERVAL 30 DAY)";

		   	$st_comentarios = mysql_query($sql_total_comentarios);

		   	if (mysql_num_rows($st_comentarios) > 0) {
				while($rowc = mysql_fetch_row($st_comentarios)) {

					 $total	  = $rowc[0];

				   	$mensagem .= utf8_decode("<p><b><a href='http://www.reverbcity.com/me/me_perfil.php?idme=$idf'>". $nomef ."</a></b> - Total de comentários no blog = ". $total ."</p>");		
					
						
				}
			}					              
	}
}
		
$data_formatada = date("d/m/Y");
$mensagem .= utf8_decode("<p><b>Obs:</b> Para acessar o perfil dos usuários, basta clicar no nome dos mesmos.</p>");

$contatos = array('gustavo' => "gustavo@reverbcity.com",
				  'tony'    => "contato@reverbcity.com");


	foreach ($contatos as $key => $contato) {
		$corpo = IncluiPapelCarta("sistema",$mensagem,utf8_decode('Relatorio de Participação de Blog') . " - $data_formatada"); 
		EnviaEmailNovo("news@reverbcity.com","Reverbcity",$contato,"","",utf8_decode('Relatorio de Participação de Blog') . " - $data_formatada", $corpo);
	}

?>