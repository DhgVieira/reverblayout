<?php
include 'auth.php';
include 'lib.php';

$nome_cat = request("nome");

if (!$nome_cat){
	echo "-1";
    exit();
}
  
$str = "INSERT INTO contas_categorias (DS_CATEGORIA_CCRC) VALUES ('$nome_cat')";
$st = mysql_query($str);
$id = mysql_insert_id();

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inlcuiu categoria no contas $nome_cat");

mysql_close($con);

echo $id;
exit();
?>