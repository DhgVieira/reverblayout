<?php
include 'auth.php';
include 'lib.php'; 

$datafret 	= request("datafret");
$comprafret = request("comprafret");
$frete 		= request("frete");
$correio 	= request("correio");
$correio2 	= request("correio2");

if (!$datafret){
$datafret = date('Y/m/d G:i:s')	; //A DATA TM QUE TER ESSE FORMATO
}
if (!$frete) $frete = "";
if (!$correio) $correio = "";
if (!$correio2) $correio2 = "";


/*
if (!$datafret){
	$msg = "Voce precisa informar a data!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}*/

if (!$comprafret){
	$msg = "Voce precisa informar a compra!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
};
/*
if (!$frete){
	$msg = "Voce precisa informar o frete!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$correio){
	$msg = "Voce precisa informar o correio!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$correio2){
	$msg = "Voce precisa informar o correio 2!";
	Header("Location: erro.php?msg=$msg");
    exit();
}
if (!$descricaocol) $descricaocol = "";
  */
//echo $datafret.' '.$comprafret.' '.$frete.' '.$correio.' '.$correio2;  
$str = "INSERT INTO fretescruzados(DT_COMPRA_FCRC, NR_COMPRA_FCRC, VL_FRETE_FCRC, VL_CORREIO_FCRC, VL_CORREIOEXT_FCRC) VALUES ('$datafret', '$comprafret', '$frete', '$correio', '$correio2')";
$stt = mysql_query($str);
$id = mysql_insert_id();

//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu frete $comprafret");
mysql_close($con);

Header("Location: compras.php?st=F");
 
?>
