<?php 
include 'auth.php';
include 'lib.php';

$ida = request("arq");
$ext = request("ext");

if ($SS_nivel > 100){
    
$sql = "SELECT NR_SEQ_ARQ_HIST_AHRC, DS_EXT_AHRC from arquivos_historico WHERE NR_SEQ_ARQUIVO_AHRC = $ida";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
   while($row = mysql_fetch_row($st)) {
       $idh = $row[0];
       $exth = $row[1];
       $str = "DELETE FROM arquivos_historico WHERE NR_SEQ_ARQ_HIST_AHRC = $idh";
	   $st = mysql_query($str);
       
       if (file_exists("arquivos/historico/$idh.$exth")) unlink("arquivos/historico/$idh.$exth");
   }    
}

$str = "DELETE FROM arquivos WHERE NR_SEQ_ARQUIVO_AQRC = $ida";
$st = mysql_query($str);

$str = "DELETE FROM arquivos_rel WHERE NR_SEQ_ARQUIVO_AURC = $ida";
$st = mysql_query($str);

if (file_exists("arquivos/$ida.$ext")) unlink("arquivos/$ida.$ext");

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou o arquivo $ida.$ext e o seu historico");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar arquivos - $SS_logadm");
}

mysql_close($con);

Header("Location: arquivos.php");
exit();
?>