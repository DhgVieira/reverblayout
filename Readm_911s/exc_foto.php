<?php 
include 'auth.php';
include 'lib.php';

$id = request("id");
$idp = request("idp");
$ext = request("ext");

$str = "DELETE FROM fotos WHERE NR_SEQ_FOTO_FORC = $id";
$st = mysql_query($str);

if (file_exists("../arquivos/uploads/fotosprodutos/$id.$ext")) unlink("../arquivos/uploads/fotosprodutos/$id.$ext");
if (file_exists("../arquivos/uploads/fotosprodutos/".$id."g.$ext")) unlink("../arquivos/uploads/fotosprodutos/".$id."g.$ext");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Excluiu a foto $id do produto $idp");

mysql_close($con);

Header("Location: grupos_fotos.php?idp=$idp");
?>