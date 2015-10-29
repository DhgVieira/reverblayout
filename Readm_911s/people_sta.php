<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$status = request("st");
$pg = request("pg");

if ($status == "A") {
	$status = "I";
}else{
	$status = "A";
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status do people $status");

if ($status == "A") {
	$sql = "SELECT NR_SEQ_CADASTRO_CASO FROM cadastros, me_fotos WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_FORC AND NR_SEQ_FOTO_FORC = $idp";
	$st = mysql_query($sql);
	if (mysql_num_rows($st) > 0) {
		$row = mysql_fetch_row($st);
		$nrcad = $row[0];
	}
	
	//$sqlpt = "SELECT NR_SEQ_PONTOS_PORC FROM pontos where NR_SEQ_CADASTRO_PORC = $nrcad and NR_SEQ_REFERENCIA_PORC = 2";
	//$st = mysql_query($sqlpt);
	//if (mysql_num_rows($st) <= 0) {
	//	$strpt = "INSERT INTO pontos (NR_SEQ_CADASTRO_PORC, NR_SEQ_REFERENCIA_PORC, NR_QTDE_PORC, DT_INCLUSAO_PORC, ST_PONTOS_PORC)
	//			VALUES ($nrcad, 2, 2, sysdate(), 'E')";
	//	$st = mysql_query($strpt);
	//}
}

$str = "UPDATE me_fotos SET ST_PEOPLE_FORC = '$status' where NR_SEQ_FOTO_FORC = $idp";
$st = mysql_query($str);

mysql_close($con);

Header("Location: people.php?pagina=$pg");
?>