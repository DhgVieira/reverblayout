<?php 
//<!-- //***** -->
//<!-- SALVA EM ARQUIVO O GRUPO DE EMAIL SELECIONADO -->
include 'auth.php';
include 'lib.php';

$grupo2 = request("grupo2");
$arq = 'temp/email_clientes.txt';
$handle = fopen($arq,"w+");

$tipo = request("tipo_filtro");

$busca = request("valor_filtro");

 unset($linhas);
 $cria = fopen($arq,"w+");
 fclose($cria);

header("Content-type: application/csv");   
header("Content-Disposition: attachment; filename=file.csv");   
header("Pragma: no-cache"); 

if ($handle){	
	$num=0;

	if($tipo == 1){
		

		$mes_niver = $busca;

		$sql = "SELECT DS_NOME_CASO, DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO from cadastros where MONTH(DT_NASCIMENTO_CASO) = '$mes_niver'";

		
	}
	if ($tipo == 2) {
		$sql = "SELECT DS_NOME_CASO, DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO from cadastros where DS_CIDADE_CASO LIKE '%". $busca . "%'";

	}
	if ($tipo == 3) {
		$sql = "SELECT DS_NOME_CASO, DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO from cadastros where DS_UF_CASO LIKE '%". $busca . "%'";	
	}


		$rs = mysql_query($sql) or die ('table_from_doom'); 

		while ($ret = mysql_fetch_assoc($rs)){ 

			 echo implode(';', $ret);  
    		 echo "\n";
    	}
	// 	if(mysql_num_rows($st) > 0){
	// 		while($row = mysql_fetch_row($st)){
	// 			$nome = $row[0];	
	// 			$email = $row[1];
	// 			$num++;
	// 			fwrite($handle,$nome.';'.$email."\n");
				
	// 		} // FIM WHILE
	// 	}  // FIM IF
	// fclose($handle);
    
 //    Header("Location: temp/email_clientes.txt");
 //    exit();
} // FIM IF
else{
 echo "Falha ao abrir o arquivo!";
}

mysql_close($con);
exit();
//<!-- //***** -->
?>