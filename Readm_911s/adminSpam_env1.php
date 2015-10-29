<? include 'auth.php'; ?>
<? include 'lib.php'; ?>
<?
$id_spam = request("id_spam");
$nome    = request("nome");
$data    = request("data");
$tipo    = request("tipo");

$str = "update cadastros set ST_SPAM_CACH = 'N'";
$st = mysql_query($str);
	
$str = "update Assinante set ST_SPAM_CACH = 'N'";
$st = mysql_query($str);

if ($tipo == 1) {
	$grupo   = $_POST["grupo"];
	foreach ($grupo as $grp) {
		if ($grp == 0) {
			$str = "update cadastros set ST_SPAM_CACH = 'E' WHERE ST_ENVIO_CASO = 'S'";
			$st = mysql_query($str);
		}else{
			$str = "UPDATE Assinante a, AssinanteGrupo b SET a.ST_SPAM_CACH = 'E' WHERE a.IdAssinante = b.IdAssinante and b.IdGrupo = $grp";
			$st = mysql_query($str);
		}
	}
}else{
	$grupo = "";
	$str = "update cadastros set ST_SPAM_CACH = 'E'";
	$st = mysql_query($str);
	
	$str = "update Assinante set ST_SPAM_CACH = 'E'";
	$st = mysql_query($str);
}

$str2 = "update spam set dt_inicio = sysdate(), st_status = 'I' where id_spam = $id_spam";
$st = mysql_query($str2);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Iniciou envio de Newsletter $id_spam");

mysql_close($con);

Header("Location: adminSpam_env2.php?id_spam=$id_spam&forma=$forma&nome=$nome");

?>