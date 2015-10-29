<?php 
include 'auth.php';
include 'lib.php';
$idf = request("idf");
$page = request("pg");

if ($SS_nivel > 100){

$sql = "SELECT NR_SEQ_TOPICO_TOSO FROM topicos WHERE NR_SEQ_FORUM_TOSO = $idf";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
	while($row = mysql_fetch_row($st)) {
		$id_top = $row[0];
		
		$str = "DELETE from msgs WHERE NR_SEQ_TOPICO_MESO = $id_top";
		$st2 = mysql_query($str);
	
		$str = "DELETE from topicos WHERE NR_SEQ_TOPICO_TOSO = $id_top";
		$st3 = mysql_query($str);
	}
}

$str = "DELETE FROM foruns WHERE NR_SEQ_FORUM_FOSO = $idf";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Excluiu Forum $idf");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar forum - $SS_logadm");
}

mysql_close($con);

Header("Location: foruns.php?pagina=$page");
?>