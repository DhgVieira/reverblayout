<?php
include 'auth.php';
include 'lib.php';

$nome = request("nome");

$id_cad = $SS_logado;

if (!$nome){
	Header("Location: foruns.php");
    exit();
}

$str = "INSERT INTO foruns (NR_SEQ_CADASTRO_FOSO, DS_FORUM_FOSO, ST_FORUM_FOSO, DT_CADASTRO_FOSO) VALUES ($id_cad,'$nome','A',sysdate())";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Forum incluido $nome");

mysql_close($con);

Header("Location: foruns.php");

?>
