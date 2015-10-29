<?php 
include 'auth.php';
include 'lib.php';

$idf = request("idf");

$str = "DELETE FROM fretescruzados WHERE NR_SEQ_FRETE_FCRC = $idf";
$st = mysql_query($str);


//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou frete $idf");

mysql_close($con);

Header("Location: compras.php?st=F");
?>