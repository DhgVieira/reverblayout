<?php
include 'auth.php';
include 'lib.php';

$produto = request("p");

$str = "DELETE from produtos_monitora WHERE NR_SEQ_PRODUTO_MOPR = $produto";
$st2 = mysql_query($str);

mysql_close($con);

Header("Location: monitora.php");
exit();
?>