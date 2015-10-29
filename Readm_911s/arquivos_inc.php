<?php
include 'auth.php';
include 'lib.php';

$categoria	= request("categoria");
$nome	    = request("nome");
$descricao	= request("descricao");

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

$extensao = strtolower(end(explode('.', $arquivo['name'])));

$str = "INSERT INTO arquivos (NR_SEQ_CATEGORIA_AQRC, NR_SEQ_USER_AQRC, DS_ARQUIVO_AQRC, DS_DESCRICAO_AQRC,
        DT_ARQUIVO_AQRC, DS_NOME_ORIG_AQRC, DS_EXT_AQRC) 
        values ($categoria, $SS_logadm, '$nome', '$descricao', sysdate(), '".$arquivo['name']."', '$extensao')";
$st = mysql_query($str);
$id = mysql_insert_id();

$str = "INSERT INTO arquivos_rel (NR_SEQ_USER_AURC, NR_SEQ_ARQUIVO_AURC) 
        values ($SS_logadm, $id)";
$st = mysql_query($str);

$arquivo_nome = $id . "." . $extensao;
$arquivo_dir = "arquivos/" . $arquivo_nome;
move_uploaded_file($arquivo["tmp_name"], $arquivo_dir);

mysql_close($con);

Header("Location: arquivos.php");
exit();
?>