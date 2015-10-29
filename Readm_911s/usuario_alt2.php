<?php
include 'auth.php';
include 'lib.php';

$login 		= request("login");
$senha 		= request("senha");
$idu 		= request("idu");

$email 		= request("email");

$email = $email ."@reverbcity.com";

$email = str_replace("@reverbcity.com@reverbcity.com","@reverbcity.com",$email);
$email = str_replace("@reverbcity.com.br@reverbcity.com","@reverbcity.com",$email);

 
$str = "UPDATE usuarios SET DS_LOGIN_USRC = '$login', DS_SENHA_USRC = '$senha', DS_EMAIL_USRC = '$email' WHERE NR_SEQ_USUARIO_USRC = $idu";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou dados do usuario $login");

mysql_close($con);

Header("Location: usuarios.php");

?>
