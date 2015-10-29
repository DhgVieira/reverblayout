<?php
include 'auth.php';
include 'lib.php';  

$datafret 	= request("datafret");
$comprafret = request("comprafret");
$frete 		= request("frete");
$correio 	= request("correio");
$correio2 	= request("correio2");
$idf 		= request("idf");

if (!$datafret){
$datafret = date('Y/m/d G:i:s')	; //A DATA TM QUE TER ESSE FORMATO
}
if (!$frete) $frete = "";
if (!$correio) $correio = "";
if (!$correio2) $correio2 = "";

if (!$comprafret){
	$msg = "Voce precisa informar a compra!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

$str = "UPDATE fretescruzados SET 
		DT_COMPRA_FCRC = '$datafret',
		NR_COMPRA_FCRC = '$comprafret',
		VL_FRETE_FCRC = '$frete',
		VL_CORREIO_FCRC = '$correio',
		VL_CORREIOEXT_FCRC = '$correio2'
		where NR_SEQ_FRETE_FCRC = $idf";
$st = mysql_query($str);


//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou frete $idf");
mysql_close($con);
Header("Location: compras.php?st=F");
?>
