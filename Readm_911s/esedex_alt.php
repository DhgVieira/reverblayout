<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$arraycampos = array('ide_sedex','cidade','cep_inicio','cep_fim','faixa_peso','valor');

$str = "update e_sedex set ";
for ($f=1;$f<6;$f++){

	$variavel = $arraycampos[$f];
	
	$valor = str_replace(",",".",request($arraycampos[$f]));
	$str .= "`".$variavel."` = ".$valor.", ";
}
$str = substr($str,0,strlen($str)-2);
$str .= " WHERE ide_sedex = $idf";

die($str);
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou valores do Frete $idf");

mysql_close($con);

Header("Location: frete.php");
exit();
?>
