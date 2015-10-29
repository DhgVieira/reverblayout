<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$page = request("pg");
$ext = request("ext");

if ($SS_nivel > 100){

$str = "DELETE FROM party_coments WHERE NR_SEQ_PARTY_PCRC = $idp";
$st = mysql_query($str);

$str = "DELETE FROM partys WHERE NR_SEQ_PARTY_PARC = $idp";
$st = mysql_query($str);

if (file_exists("../images/partys/$idp.$ext")) unlink("../images/partys/$idp.$ext");
if (file_exists("../images/partys/".$idp."p.$ext")) unlink("../images/partys/".$idp."p.$ext");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou party $idp");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar festa - $SS_logadm");
}

mysql_close($con);

Header("Location: party.php?pagina=$page");
?>