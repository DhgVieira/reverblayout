<?php
include 'auth.php';
include 'lib.php';

$fotos      = array();
$fotos 	    = $_REQUEST["fotos"];

$ordem      = array();
$ordem 	    = $_REQUEST["ordem"];

$idp 	    = $_REQUEST["idp"];

if (count($fotos)>0){
    $x=0;
    foreach($fotos as $values){
        if (!$ordem[$x]) $ordem[$x] = 0;
        $str = "UPDATE fotos SET NR_ORDEM_FORC = ".$ordem[$x]." where NR_SEQ_FOTO_FORC = $values";
        $st = mysql_query($str);
        $x++;
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou ordem das fotos do produto $idp");

mysql_close($con);

Header("Location: grupos_fotos.php?idp=$idp");
exit();
?>