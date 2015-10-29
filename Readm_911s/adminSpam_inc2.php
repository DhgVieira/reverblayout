<? include 'auth.php'; ?>
<? include 'lib.php'; ?>
<?
$titulo = request("titulo");
$conteudo = request("FCKeditor1");

if (!$titulo) {
	$msg = "O%20titulo%20e%20de%20preenchimento%20obrigatorio!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$conteudo) {
	$msg = "O%20Conteudo%20e%20de%20preenchimento%20obrigatorio!";
	Header("Location: erro.php?msg=$msg");
    exit();
}

$conteudo = str_replace("src=\"/images/","src=\"http://www.reverbcity.com/images/",$conteudo);
$conteudo = str_replace("src=/images/","src=http://www.reverbcity.com/images/",$conteudo);

$str = "INSERT INTO spam (ds_descricao, dt_inclusao, st_status, ds_conteudo) VALUES ('$titulo', sysdate(), 'A','$conteudo')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu Newsletter");

mysql_close($con);

Header("Location: newsletter.php");
?>