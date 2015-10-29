<?php
// if (!isset( $_SESSION )) { 
   	session_start(); 
// }

$SS_sessao  = (isset($_SESSION["SS_sessao"])) ? $_SESSION["SS_sessao"] : ""; //coockie
$SS_logadm = (isset($_SESSION["SS_logadm"])) ? $_SESSION["SS_logadm"] : ""; //id usuario
$SS_login = (isset($_SESSION["SS_login"])) ? $_SESSION["SS_login"] : ""; // login
$SS_acesso = (isset($_SESSION["SS_acesso"])) ? $_SESSION["SS_acesso"] : ""; // data
$SS_nivel = (isset($_SESSION["SS_nivel"])) ? $_SESSION["SS_nivel"] : ""; // nive de acesso
$SS_loja = (isset($_SESSION["SS_loja"])) ? $_SESSION["SS_loja"] : ""; // loja

if ((!$SS_sessao) || (!$SS_logadm)) {
    $CC_sessao = @$HTTP_COOKIE_VARS["ck_sessao"];

    if ($CC_sessao){
        $CC_logadm = @$HTTP_COOKIE_VARS["ck_logadm"];
        if ($CC_logadm > 0){
            $CC_login = @$HTTP_COOKIE_VARS["ck_login"];
            $CC_acesso = @$HTTP_COOKIE_VARS["ck_acesso"];
            $CC_nivel = @$HTTP_COOKIE_VARS["ck_nivel"];
            $CC_loja = @$HTTP_COOKIE_VARS["ck_loja"];
            
            $_SESSION["SS_sessao"] = $CC_sessao;
            $_SESSION["SS_logadm"] = $CC_logadm;
            $_SESSION["SS_login"] = $CC_login;
            $_SESSION["SS_acesso"] = $CC_acesso;
            $_SESSION["SS_nivel"] = $CC_nivel;
            $_SESSION["SS_loja"] = $CC_loja;
            
            $SS_sessao  = $CC_sessao;
            $SS_logadm = $CC_logadm;
            $SS_login = $CC_login;
            $SS_acesso = $CC_acesso;
            $SS_nivel = $CC_nivel;
            $SS_loja = $CC_loja;
        }else{
            ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
            <html>
            <head>
            	<title>Untitled</title>
            <script language="JavaScript">
               function logout() {
                  top.window.location.href=('login.php');
               }
            </script>
            </head>
            <body onLoad="javascript:logout();">
            </body>
            </html>
            <?php
            exit();
        }
        
    }else{
        ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
        <head>
        	<title>Untitled</title>
        <script language="JavaScript">
           function logout() {
              top.window.location.href=('login.php');
           }
        </script>
        </head>
        <body onLoad="javascript:logout();">
        </body>
        </html>
        <?php
        exit();
    }
}

//verificando pagina
$pagina_atual = end(explode("/", $_SERVER['PHP_SELF']));
?>