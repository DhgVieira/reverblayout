<?php
include 'auth.php';
include 'lib.php'; 

$idc		   = request("idc");
$nome		   = request("nome");
$endereco	   = request("endereco");
$numero		   = request("numero");
$complem	   = request("complem");
$bairro		   = request("bairro");
$cidade		   = request("cidade");
$estado		   = request("estado");
$cep		   = request("cep");
$email		   = request("email");
$dt_nasc	   = request("dt_nasc");
$documento	   = request("documento");
$dddfone	   = request("dddfone");
$fone		   = request("fone");
$dddcel		   = request("dddcel");
$celular	   = request("celular");
$senha		   = request("senha");
$conheceu	   = request("conheceu");
$tipo		   = request("tipo");
$tipocli	   = request("tipocli");
$twitter	   = request("twitter");
$facebook      = request("facebook");
$dsnick        = request("nick");
$ie            = request("ie");

if (!$nome){
	$msg = "Voce%20precisa%20informar%20o%20Nome!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$senha){
	$msg = "Voce%20precisa%20informar%20a%20Senha!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$email){
	$msg = "Voce%20precisa%20informar%20o%20E-Mail!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$dt_nasc){
	$msg = "Voce%20precisa%20informar%20a%20Data%20de%20Nascimento!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$endereco) $endereco = "-";
if (!$numero) $numero = "-";
if (!$complem) $complem = "-";
if (!$bairro) $bairro = "-";
if (!$cidade) $cidade = "-";
if (!$estado) $estado = "-";
if (!$cep) $cep = "-";
if (!$documento) $documento = "-";
if (!$dddfone) $dddfone = "-";
if (!$fone) $fone = "-";
if (!$dddcel) $dddcel = "-";
if (!$celular) $celular = "-";
if (!$conheceu) $conheceu = "-";
if (!$tipo) $tipo = "PF";

if (!$twitter){
    $twitter = "null";
}else{
    $twitter = "'".$twitter."'";
}

if (!$facebook){
    $facebook = "null";
}else{
    $facebook = "'".$facebook."'";
}


$datanasc =explode("/",$dt_nasc);
krsort($datanasc);

$str = "UPDATE cadastros SET 
 		DS_NOME_CASO = '$nome', DS_ENDERECO_CASO = '$endereco', DS_NUMERO_CASO = '$numero', DS_COMPLEMENTO_CASO = '$complem', DS_BAIRRO_CASO = '$bairro', TP_CADASTRO_CACH = $tipocli, 
		DS_CIDADE_CASO = '$cidade', DS_UF_CASO = '$estado', DS_CEP_CASO = '$cep', DS_EMAIL_CASO = '$email', DT_NASCIMENTO_CASO = '" . implode("-",$datanasc) . "', DS_CPFCNPJ_CASO = '$documento',
		DS_DDDFONE_CASO = '$dddfone', DS_FONE_CASO = '$fone', DS_DDDCEL_CASO = '$dddcel', DS_CELULAR_CASO = '$celular', DS_SENHA_CASO = '$senha',
		DS_CONHECEU_CASO = '$conheceu', DS_TIPO_CASO = '$tipo', DS_TWITTER_CACH = $twitter, DS_FACEBOOK_CACH = $facebook, DS_LOGIN_CASO = '$dsnick',
        DS_INSCRICAO_CACH = '$ie'
        where NR_SEQ_CADASTRO_CASO = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou cadastro $idc");

mysql_close($con);

if ($tipocli == 2){
	Header("Location: vendedores.php");
}else if ($tipocli == 1){
	Header("Location: clientes_lj.php");
}else{
    Header("Location: clientes.php");
}
exit();
?>