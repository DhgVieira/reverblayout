<?php 
include 'auth.php';
include 'lib.php';

$idcliente = $_POST["idcliente"];

var_dump($idcliente);die();

foreach ($idcliente as $key => $cliente) {
    $sql = "DELETE FROM cadastros WHERE NR_SEQ_CADASTRO_COSO = $cliente" ;
    $st = mysql_query($str);
}

mysql_close($con);

Header("Location: index.php");
?>