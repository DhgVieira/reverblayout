<?php
include 'auth.php';
include 'lib.php';

$local 		= request("local");

if (!$local){
	$msg = "Voce precisa informar o nome da Local!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
  
$str = "INSERT INTO banners_locais (DS_LOCAL_BLRC, ST_LOCAL_BLRC) VALUES ('$local','A')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Criou o local: ($local) para banner");

mysql_close($con);

Header("Location: banners.php?aba=3");

?>
