<? include 'auth.php'; ?>
<? include 'lib.php'; ?>
<?
$id_spam = request("id");

if ($SS_nivel > 100){
    
$str = "DELETE FROM spam where id_spam = $id_spam";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou Newsletter $id_spam");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar spam - $SS_logadm");
}

mysql_close($con);

Header("Location: newsletter.php");

?>