<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$arraycampos = array('NR_SEQ_FRETE_FRRC','Peso','LDA','AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO');

$str = "update fretes set ";
for ($f=1;$f<30;$f++){
	if ($f==1){
		$variavel = "NR_FAIXAPESO_FRRC";
	}else if ($f==2){
		$variavel = "LONDRINA";
	}else{
		$variavel = $arraycampos[$f];
	}
	$valor = str_replace(",",".",request($arraycampos[$f]));
	$str .= "`".$variavel."` = ".$valor.", ";
}
$str = substr($str,0,strlen($str)-2);
$str .= " WHERE NR_SEQ_FRETE_FRRC = $idf";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou valores do Frete $idf");

mysql_close($con);

Header("Location: frete.php");
exit();
?>
