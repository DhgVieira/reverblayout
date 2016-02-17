<?php
include 'lib.php';
 $data_hoje = date("Y-m-d");

$sql_count = "SELECT 
				count(*) as total_novos
			  FROM 
			  	cadastros 
			  where 
                     DAY(DT_CADASTRO_CASO) = DAY(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) 
              AND
                     MONTH(DT_CADASTRO_CASO) = MONTH(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) 
              AND
                     YEAR(DT_CADASTRO_CASO) = YEAR(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) 
              ";

$st_count = mysql_query($sql_count);

if (mysql_num_rows($st_count) > 0) {
	while($row = mysql_fetch_row($st_count)) {
		    $total	   	   = $row[0];

	}
}

$sql_cadastros = "SELECT
						NR_SEQ_CADASTRO_CASO,
						DS_NOME_CASO,
						DS_SEXO_CACH,
						DS_EXT_CACH,
						DS_CIDADE_CASO,
						DS_UF_CASO
						
				    FROM 
				    	cadastros
				     where 
                     	DAY(DT_CADASTRO_CASO) = DAY(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) 
		              AND
		                     MONTH(DT_CADASTRO_CASO) = MONTH(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) 
		              AND
		                     YEAR(DT_CADASTRO_CASO) = YEAR(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) 
		              ";	

  $st = mysql_query($sql_cadastros);

$mensagem .= "<p> Lista de usuários cadastrados  - <b> $total </b>Novos Cadastros</p>";

$mensagem .= "
			<table>

			<tbody>";

if (mysql_num_rows($st) > 0) {
                       
    while($row = mysql_fetch_row($st)) {
	    $idperfil	   = $row[0];
	    $nome	   	   = $row[1];
	    $sexo	   	   = $row[2];
	    $extencao	   = $row[3];
	    $cidade	   = $row[4];
	    $uf	   = $row[5];

        $sql_compradores = "SELECT
        						VL_TOTAL_COSO
        					FROM 
        						compras
        					WHERE
        						NR_SEQ_CADASTRO_COSO = $idperfil
        					AND 
        						ST_COMPRA_COSO <> 'C'
        					ORDER BY 
        						DT_COMPRA_COSO
        					LIMIT 1";

        $st_c = mysql_query($sql_compradores);
          	if (mysql_num_rows($st_c) > 0) {
          		$row_c = mysql_fetch_row($st_c);

	    		$total         = $row_c[0];

	    		$totcompras++;
	    	}else{

	    		$total = 0;
	    	}
	    	

		$totcompgeral += $total;

		$data_formatada = date("d/m/Y");

		$mensagem .= utf8_encode(
					"<tr>
						<td width='400px' style='padding: 5px'><b><a href='http://reverbcity.com/perfil/".$nome."/$idperfil'>". $nome ."</a></b></td>
						<td style='padding: 5px'><b><a href='http://reverbcity.com/perfil/".$nome."/$idperfil'>".  $cidade . " / " . $uf ."</a></b></td>
					</tr>");
		//$mensagem .= utf8_encode("<p><b><a href='http://reverbcity.com/perfil/".$nome."/$idperfil'>". $nome ." - " . $cidade . " - " . $uf . " </a></b></p>");
	}
	$mensagem .= "</tbody></table>";
}		
		$mensagem .= "<p><b>Total Gasto Pelos Novos Usuários :</b> R$". number_format($totcompgeral,2,",","") ."</p>";
		$mensagem .= "<p><b>Obs:</b> Para acessar o perfil dos usuários, basta clicar no nome dos mesmos.</p>";


$contatos = array('tony' =>"contato@reverbcity.com" ,
				'miri' =>"atendimento@reverbcity.com",
				'gustavo' => "gustavo@reverbcity.com",
				'desenvolvimento' => "desenvolvimento@reverbcity.com",
				'diego' => "diego@reverbcity.com");


	foreach ($contatos as $key => $contato) {
		$corpo = IncluiPapelCarta("sistema",$mensagem,utf8_encode('Novos cadastros') . " - $data_formatada"); 
		EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$contato,"","",utf8_encode('Novos cadastros') . " - $data_formatada", $corpo);
	}

?>