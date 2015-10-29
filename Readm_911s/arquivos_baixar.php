<?php
include 'auth.php';
include 'lib.php';

$file = $_GET['file'];
$arq  = $_GET['arq'];
$tipo = $_GET['tipo'];

if ($tipo == 2){
    $sqlmin = "SELECT DS_NOMEORIG_AHRC FROM arquivos_historico WHERE NR_SEQ_ARQ_HIST_AHRC = $arq";
    $stmin = mysql_query($sqlmin);
    $retnome = "";
    if (mysql_num_rows($stmin) > 0) {
    	$rowmin = mysql_fetch_row($stmin);
    	$retnome = $rowmin[0];
    }
}else{
    $sqlmin = "SELECT DS_NOME_ORIG_AQRC FROM arquivos WHERE NR_SEQ_ARQUIVO_AQRC = $arq";
    $stmin = mysql_query($sqlmin);
    $retnome = "";
    if (mysql_num_rows($stmin) > 0) {
    	$rowmin = mysql_fetch_row($stmin);
    	$retnome = $rowmin[0];
    }
}

header("Content-Type: application/save");
header("Content-Length:".filesize($file)); 
header('Content-Disposition: attachment; filename="' . $retnome . '"'); 
header("Content-Transfer-Encoding: binary");
header('Expires: 0'); 
header('Pragma: no-cache'); 

$fp = fopen("$file", "r"); 
fpassthru($fp); 
fclose($fp); 
?>