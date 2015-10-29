<? include 'auth.php'; ?>
<? include 'lib.php'; ?>
<?
$titulo = request("titulo");
$idspam = request("idspam");
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

$str = "UPDATE spam SET ds_descricao = '$titulo', ds_conteudo = '$conteudo' WHERE id_spam = $idspam";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou newsletter $idspam");

mysql_close($con);

Header("Location: newsletter.php");
?>