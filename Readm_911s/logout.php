<?php
if (!isset( $_SESSION )) { 
   	session_start(); 
}
session_unset();

setcookie("sessaosadas", "", time() - 3600, "/");
setcookie("ujr73jfw93", "", time() - 3600, "/");
setcookie("f3uydiwfer", "", time() - 3600, "/");
setcookie("ouirhcnwfj", "", time() - 3600, "/");
setcookie("mvbncbxvwu", "", time() - 3600, "/");
setcookie("ghsdsdfjkf", "", time() - 3600, "/");

setcookie("sessaosadas", "", time() - 3600);
setcookie("ujr73jfw93", "", time() - 3600);
setcookie("f3uydiwfer", "", time() - 3600);
setcookie("ouirhcnwfj", "", time() - 3600);
setcookie("mvbncbxvwu", "", time() - 3600);
setcookie("ghsdsdfjkf", "", time() - 3600);

setcookie("ck_sessao", "", time() - 3600, "/");
setcookie("ck_logadm", "", time() - 3600, "/");
setcookie("ck_login", "", time() - 3600, "/");
setcookie("ck_nivel", "", time() - 3600, "/");
setcookie("ck_acesso", "", time() - 3600, "/");
setcookie("ck_loja", "", time() - 3600, "/");

Header("Location: login.php");
exit();
?>