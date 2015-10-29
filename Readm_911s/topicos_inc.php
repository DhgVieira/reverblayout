<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");
$nome = request("nome");

$id_cad = $SS_logado;

if (!$nome){
	Header("Location: topicos.php?idf=$idf");
    exit();
}

$str = "INSERT INTO topicos (NR_SEQ_FORUM_TOSO, NR_SEQ_CADASTRO_TOSO, DS_TOPICO_TOSO, ST_TOPICO_TOSO, DT_CADASTRO_TOSO, NR_MSGS_TOSO) VALUES ($idf, $id_cad, '$nome','A',sysdate(), 0)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu novo topico $idf");

mysql_close($con);

Header("Location: topicos.php?idf=$idf");

?>
