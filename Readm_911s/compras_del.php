<?php 
include 'auth.php';
include 'lib.php';
$status = request("st");
$statusn = request("stn");
$page = request("pg");
$idc = request("idc");

if ($SS_nivel > 100){

if ($status != "C") {
	$sql = "select NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idc";
	$st = mysql_query($sql);
	if (mysql_num_rows($st) > 0) {
		while($row = mysql_fetch_row($st)) {
			$id_tamanho = $row[0];
			$nr_qtde	= $row[1];
			$nr_produto	= $row[2];
		
        	$str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC + ".$nr_qtde." WHERE NR_SEQ_TAMANHO_ESRC = $id_tamanho AND NR_SEQ_PRODUTO_ESRC = $nr_produto";
			$st4 = mysql_query($str4); 
            
            GravaLogEstoque($SS_logadm,$nr_produto,$id_tamanho,"Adicionou $nr_qtde","Exclusão da Compra nr. $idc",$nr_qtde);
		}
	}
}

//$strpt = "UPDATE pontos SET ST_PONTOS_PORC = 'E' WHERE NR_SEQ_COMPRAUTIL_PORC = $idc AND ST_PONTOS_PORC = 'U'";
//$st = mysql_query($strpt);

$str = "DELETE from cestas WHERE NR_SEQ_COMPRA_CESO = $idc";
$st = mysql_query($str);

$str = "DELETE FROM compras WHERE NR_SEQ_COMPRA_COSO = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou compra $idc");

}else{
    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"TENTOU!! deletar compra - $SS_logadm");
}

mysql_close($con);

Header("Location: compras.php?st=$status&pagina=$page");
?>