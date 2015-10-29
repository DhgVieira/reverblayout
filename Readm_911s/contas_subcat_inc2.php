<?php
include 'auth.php';
include 'lib.php';

$nome_subcat 	= request("nome");
$categoria		= request("cate");

if (!$nome_subcat){
	echo "-1";
    exit();
}
  
$str = "INSERT INTO contas_subcategorias (DS_SUBCATEGORIA_SCRC, NR_SEQ_CATCONTA_SCRC) VALUES ('$nome_subcat', $categoria)";
$st = mysql_query($str);
$id = mysql_insert_id();

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu subcategoria no contas");

mysql_close($con);

echo "<option value=$id>$nome_subcat</option>";
exit();
?>