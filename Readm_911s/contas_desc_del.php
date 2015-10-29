<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");

$sql = "SELECT NR_SEQ_DESCRICAO_CORC from contas WHERE NR_SEQ_DESCRICAO_CORC = $idc";
$st = mysql_query($sql);

if (mysql_num_rows($st) <= 0) {
	$str = "DELETE FROM contas_descricao WHERE NR_SEQ_SUBCATCONTA_DCRC = $idc";
	$st = mysql_query($str);
	
	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Descricao de contas excluida $idc");
	
	Header("Location: contas_descricao.php");
}else{
?>
<script language="JavaScript">
   alert('Esta descricao não pode ser excluída pois ela está em uso.');
   top.window.location.href=('contas_descricao.php');
</script>
<?php
exit();
}

mysql_close($con);
exit();
?>