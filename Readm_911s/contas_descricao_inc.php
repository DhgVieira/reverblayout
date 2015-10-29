<?php
include 'auth.php';
include 'lib.php';

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
  
$str = "INSERT INTO contas_descricao 
           (DS_SUBCATEGORIA_DCRC,
            DS_RAZAO_DCRC, 
            DS_CNPJ_DCRC,
            DS_IE_DCRC,
            DS_ENDERECO_DCRC,
            DS_FONE_DCRC,
            DS_EMAIL_DCRC,
            DS_CONTATO_DCRC,
            DS_NOMEFAVORECIDO_DCRC,
            DS_AGENCIA_DCRC,
            DS_CONTA_DCRC,
            DS_BANCO_DCRC,
            DS_OBSERVACOES_DCRC

) VALUES ('$nome_subcat', '$razao', '$cnpj', '$ie', '$endereco', '$fone', '$email', '$contato', '$nome_favorecido', '$agencia' , '$conta' , '$banco', '$observacoes')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu fornecedor no contas");

mysql_close($con);

Header("Location: contas_descricao.php");
exit();
?>