<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");

$sql = "SELECT NR_SEQ_SUBCATCONTA_CORC from contas WHERE NR_SEQ_SUBCATCONTA_CORC = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM contas_subcategorias WHERE NR_SEQ_SUBCATCONTA_SCRC = $idc";
	$st = mysql_query($str);
	
	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Subcategoria de contas excluida $idc");
	
	Header("Location: contas_subcategorias.php");
}else{
?>
<script language="JavaScript">
   alert('Esta subcategoria não pode ser excluída pois ela está em uso.');
   top.window.location.href=('contas_subcategorias.php');
</script>
<?php
exit();
}

mysql_close($con);
?>