<?php
include 'auth.php';
include 'lib.php';

$idc  = request("id_contadesc");

$nome_subcat 	= request("nome_subcat");
$razao 	= request("razao");
$cnpj 	= request("cnpj");
$ie 	= request("ie");
$endereco 	= request("endereco");
$fone 	= request("fone");
$email 	= request("email");
$contato 	= request("contato");
$nome_favorecido    = request("nome_favorecido");
$banco    = request("banco");
$agencia    = request("agencia");
$conta    = request("conta");
$observacoes    = request("observacoes");


$str = "UPDATE 
			contas_descricao 
		SET 
			DS_SUBCATEGORIA_DCRC = '$nome_subcat',
		 	DS_RAZAO_DCRC = '$razao', 
		 	DS_CNPJ_DCRC = '$cnpj',
            DS_IE_DCRC = '$ie',
            DS_ENDERECO_DCRC = '$endereco', 
            DS_FONE_DCRC = '$fone',
            DS_EMAIL_DCRC = '$email',
            DS_CONTATO_DCRC = '$contato',
		 	DS_NOMEFAVORECIDO_DCRC = '$nome_favorecido', 
		 	DS_AGENCIA_DCRC = '$agencia',
            DS_CONTA_DCRC = '$conta',
            DS_BANCO_DCRC = '$banco', 
            DS_OBSERVACOES_DCRC = '$observacoes'

        WHERE
        	NR_SEQ_SUBCATCONTA_DCRC = $idc";
$st = mysql_query($str);


Header("Location: contas_descricao.php?pagina=$pg");

?>
