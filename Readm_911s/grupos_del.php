<?php 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$ext = request("ext");
$ext2 = request("ext2");
$pag = request("pg");

if ($SS_nivel > 100){

$sql = "SELECT NR_SEQ_PRODUTO_CESO from cestas WHERE NR_SEQ_PRODUTO_CESO = $idp";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM estoque WHERE NR_SEQ_PRODUTO_ESRC = $idp";
	$st = mysql_query($str);
    
    $str = "DELETE FROM estoque_controle WHERE NR_SEQ_PRODUTO_ECRC = $idp";
	$st = mysql_query($str);
	
	$str = "DELETE FROM produtos WHERE NR_SEQ_PRODUTO_PRRC = $idp";
	$st = mysql_query($str);
	
	if (file_exists("../arquivos/uploads/produtos/$idp.$ext")) unlink("../arquivos/uploads/produtos/$idp.$ext");
	if (file_exists("../arquivos/uploads/produtos/".$idp.".$ext")) unlink("../arquivos/uploads/produtos/".$idp.".$ext");
	if (file_exists("../images/tamanhos/$idp.$ext2")) unlink("../images/tamanhos/$idp.$ext2");
    
    $sql3 = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = $idp";
    $st3 = mysql_query($sql3);
    if (mysql_num_rows($st3) > 0) {
    	while($row3 = mysql_fetch_row($st3)) {
    	   if (file_exists("../arquivos/uploads/fotosprodutos/".$row3[0].".".$row3[1])) unlink("../arquivos/uploads/fotosprodutos/".$row3[0].".".$row3[1]);
           if (file_exists("../arquivos/uploads/fotosprodutos/".$row3[0].".".$row3[1])) unlink("../arquivos/uploads/fotosprodutos/".$row3[0].".".$row3[1]);
           if (file_exists("../arquivos/uploads/fotosprodutos/".$row3[0].".".$row3[1])) unlink("../arquivos/uploads/fotosprodutos/".$row3[0].".".$row3[1]);
 	    }
    }
    
    $str = "DELETE FROM fotos WHERE NR_SEQ_PRODUTO_FORC = $idp";
	$st = mysql_query($str);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou produto $idp");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar produto - $SS_logadm");
}

mysql_close($con);

Header("Location: grupos.php?pagina=$pag");
exit();
?>