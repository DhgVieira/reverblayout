<?php
if (!isset( $_SESSION )) { 
   	session_start(); 
}
$SS_sessao  = (isset($_SESSION["SS_sessao"])) ? $_SESSION["SS_sessao"] : "";
$SS_logadm = (isset($_SESSION["SS_logadm"])) ? $_SESSION["SS_logadm"] : "";
$SS_login = (isset($_SESSION["SS_login"])) ? $_SESSION["SS_login"] : "";
$SS_acesso = (isset($_SESSION["SS_acesso"])) ? $_SESSION["SS_acesso"] : "";
$SS_nivel = (isset($_SESSION["SS_nivel"])) ? $_SESSION["SS_nivel"] : "";
$SS_loja = (isset($_SESSION["SS_loja"])) ? $_SESSION["SS_loja"] : "";

$testa = true;

while($testa){
	$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
	$max = strlen($CaracteresAceitos)-1;
	//$password = date('Ymdhis');
	$password = "";
	for($i=0; $i < 1; $i++) {
	   $password .= $CaracteresAceitos{mt_rand(0, $max)};
	}
	$testa = false;
}
echo $password;
?>