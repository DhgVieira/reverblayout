<?php
include 'auth.php';
include 'lib.php';

$login 		= request("login");
$senha 		= request("senha");
$email 		= request("email");

$email = $email ."@reverbcity.com";

$email = str_replace("@reverbcity.com@reverbcity.com","@reverbcity.com",$email);
$email = str_replace("@reverbcity.com.br@reverbcity.com","@reverbcity`.com",$email);

$sql = "SELECT DS_LOGIN_USRC from usuarios WHERE DS_LOGIN_USRC = '$login'";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
	$msg = "Ja existe um usuario para este login!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}
 
$str = "INSERT INTO usuarios (DS_LOGIN_USRC, DS_SENHA_USRC, DT_CADASTRO_USRC, ST_STATUS_USRC, NR_SEQ_LOJA_USRC, DS_EMAIL_USRC
        ) VALUES ('$login','$senha',sysdate(),'A',$SS_loja,'$email')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Adicionou novo usuario $login");

mysql_close($con);

Header("Location: usuarios.php");

?>