<?php 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$pagina = request("pg");

if ($SS_nivel > 100){
    
$str = "DELETE FROM blog_coments WHERE NR_SEQ_BLOG_CBRC = $idp";
$st = mysql_query($str);

$str = "DELETE FROM blog WHERE NR_SEQ_BLOG_BLRC = $idp";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou Blog $idp");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar blog - $SS_logadm");
}

mysql_close($con);

Header("Location: blog.php?aba=2");
?>