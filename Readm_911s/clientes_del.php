<?php 
include 'auth.php';
include 'lib.php';
$idc = request("idc");
$page = request("pg");
$nome = request("nom");
$cpf = request("cpf");

if ($SS_nivel > 100){
    
$str = "DELETE FROM me_friends WHERE NR_SEQ_CADASTRO_FRRC = $idc";
$st = mysql_query($str);

$str = "DELETE FROM me_scraps WHERE NR_SEQ_CADASTRO_SBRC = $idc";
$st = mysql_query($str);

$str = "DELETE FROM me_fotos WHERE NR_SEQ_CADASTRO_FORC = $idc";
$st = mysql_query($str);

$str = "DELETE FROM me_videos WHERE NR_SEQ_CADASTRO_VIRC = $idc";
$st = mysql_query($str);

$str = "DELETE FROM me_wishlist WHERE NR_SEQ_CADASTRO_WLRC = $idc";
$st = mysql_query($str);

$str = "DELETE FROM cestas WHERE NR_SEQ_CADASTRO_CESO = $idc";
$st = mysql_query($str);

$str = "DELETE FROM compras WHERE NR_SEQ_CADASTRO_COSO = $idc";
$st = mysql_query($str);

$str = "DELETE FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou cliente $idc");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar cliente - $SS_logadm");
}

mysql_close($con);

Header("Location: clientes.php?pagina=$page&nome=$nome&cpf=$cpf");
exit();
?>