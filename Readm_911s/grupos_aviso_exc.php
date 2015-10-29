<?php 
include 'auth.php';
include 'lib.php';

$ida = request("ida");
$aba = request("aba");

$str = "DELETE FROM aviseme WHERE NR_SEQ_AVISEME_AVRC = $ida";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou aviseme");

mysql_close($con);

if (!$aba){
    Header("Location: grupos_aviso.php");
    exit();
}else{
    if ($aba == 1){
        Header("Location: grupos_aviso.php");
    }else{
        Header("Location: grupos_aviso2.php");
    }
    exit();
}
?>