<?php
//if (!isset( $_SESSION )) { 
   	session_start(); 
//}

include 'lib.php';

$login = request("login");
$senha = request("senha");

$sql = "select NR_SEQ_USUARIO_USRC, DS_LOGIN_USRC, NR_NIVEL_USRC, NR_SEQ_LOJA_USRC from usuarios WHERE DS_LOGIN_USRC = '$login' and DS_SENHA_USRC = '$senha' and ST_STATUS_USRC = 'A'";


$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$id_cad	= $row[0];
	$login	= $row[1];
    $nivel	= $row[2];
    $loja	= $row[3];

	$sql2 = "select DT_ACESSO_LOSO from logs_adm WHERE NR_SEQ_LOGIN_LOSO = $id_cad order by DT_ACESSO_LOSO desc limit 1";
	$st2 = mysql_query($sql2);
	if (mysql_num_rows($st2) > 0) {
		$row2 = mysql_fetch_row($st2);
		$SS_acesso = date("d/m/Y G:i", strtotime($row2[0]));
	}else{
		$SS_acesso = "Primeiro Acesso";
	}
    
    $sessao = session_id();
    
    $_SESSION["SS_sessao"] = $sessao;
	$_SESSION["SS_logadm"] = $id_cad;
    $_SESSION["SS_login"] = $login;
    $_SESSION["SS_nivel"] = $nivel;
    $_SESSION["SS_acesso"] = $SS_acesso;
    $_SESSION["SS_loja"] = $loja;
    
    setcookie("ck_sessao", $sessao, time()+60*60*24*100, "/");
    setcookie("ck_logadm", $id_cad, time()+60*60*24*100, "/");
    setcookie("ck_login", $login, time()+60*60*24*100, "/");
    setcookie("ck_nivel", $nivel, time()+60*60*24*100, "/");
    setcookie("ck_acesso", $SS_acesso, time()+60*60*24*100, "/");
    setcookie("ck_loja", $loja, time()+60*60*24*100, "/");
	
	GravaLog($id_cad,end(explode("/", $_SERVER['PHP_SELF'])),"Validou Cadastro");
    session_write_close();
	Header("Location: index.php");
}else{
    GravaLog(0,end(explode("/", $_SERVER['PHP_SELF'])),"Tentativa de login: $login - Senha: $senha");
	Header("Location: login.php");
    exit();
}

mysql_close($con);
?>