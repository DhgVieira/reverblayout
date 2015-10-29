<?php 
include 'auth.php';
include 'lib.php';

$id_prod = $_POST["selec"];

var_dump($id_prod);die;

foreach ($id_prod as $key => $produto) {
	$sql = "DELETE FROM aviseme WHERE NR_SEQ_PRODUTO_AVRC = $produto" ;
	$st = mysql_query($str);
}

mysql_close($con);

Header("Location: grupos_aviso2.php");
?>