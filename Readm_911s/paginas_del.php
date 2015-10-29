<?php
include 'auth.php'; 
include 'lib.php';

$idp = request("idp");

$str = "DELETE FROM paginas WHERE NR_SEQ_PAGINA_PASA = $idp";
$st = mysql_query($str);

mysql_close($con);

Header("Location: paginas.php");
?>