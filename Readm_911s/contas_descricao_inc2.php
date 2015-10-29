<?php
include 'auth.php';
include 'lib.php';

$nome_desc  	= request("nome");

if (!$nome_desc){
	echo "-1";
    exit();
}
  
$str = "INSERT INTO contas_descricao (DS_SUBCATEGORIA_DCRC) VALUES ('$nome_desc')";
$st = mysql_query($str);
$id = mysql_insert_id();

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu fornecedor no contas");

mysql_close($con);

echo "<option value=$id>$nome_desc</option>";
exit();
?>