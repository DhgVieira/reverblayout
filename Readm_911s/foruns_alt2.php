<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$nome = request("nome");

if (!$nome){
	Header("Location: foruns_alt.php?idf=$idf");
    exit();
}

$str = "UPDATE foruns SET DS_FORUM_FOSO = '$nome' where NR_SEQ_FORUM_FOSO = $idf";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou o forum $idf");

mysql_close($con);

Header("Location: foruns.php");

?>
