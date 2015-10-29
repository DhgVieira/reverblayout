<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");

$sql = "SELECT NR_SEQ_CATCONTA_CORC from contas WHERE NR_SEQ_CATCONTA_CORC = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM contas_categorias WHERE NR_SEQ_CATCONTA_CCRC = $idc";
	$st = mysql_query($str);
	
	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou categoria do contas $idc");
	
	Header("Location: contas_categorias.php");
}else{
?>
<script language="JavaScript">
   alert('Esta categoria não pode ser excluída pois ela está em uso.');
   top.window.location.href=('contas_categorias.php');
</script>
<?php
exit();
}

mysql_close($con);
?>