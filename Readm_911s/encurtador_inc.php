<?php 
include 'auth.php';
include 'lib.php';

$big = request("urlfull");
$link = RemoveAcentos(request("link"));

$link = str_replace("&","",$link);
$link = str_replace("*","",$link);
$link = str_replace("(","",$link);
$link = str_replace(")","",$link);
$link = str_replace("-","_",$link);
$link = str_replace("!","",$link);
$link = str_replace("@","",$link);
$link = str_replace("$","",$link);
$link = str_replace("%","",$link);
$link = str_replace("^","",$link);
$link = str_replace("+","",$link);
$link = str_replace("=","",$link);
$link = str_replace("[","",$link);
$link = str_replace("]","",$link);
$link = str_replace("{","",$link);
$link = str_replace("}","",$link);
$link = str_replace(":","",$link);
$link = str_replace("'","",$link);
$link = str_replace("\"","",$link);
$link = str_replace("?","",$link);
$link = str_replace("/","",$link);
$link = str_replace("<","",$link);
$link = str_replace(">","",$link);
$link = str_replace(".","",$link);
$link = str_replace(",","",$link);
$link = str_replace(" ","",$link);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Encurtou uma url");

mysql_close($con);

$con2 = mysql_connect("reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com","reverb","reverbserver2014") or die("Conexão Falhou!");
mysql_select_db("rvbla",$con2) or die("Database Inválido");

if ($big){
    if (InStr($big,"http://") < 0) $big = "http://".$big;
    if (!$link){
        $dumb = GeraLink(3);
    }else{
        $dumb = $link;
        $sql = "select NR_SEQ_URL_URDB from urls WHERE DS_URLCUT_URDB = '$dumb'";
    	$st = mysql_query($sql);
    	if (mysql_num_rows($st) > 0) {
    	   ?>
<script language="JavaScript">
   alert('Ja existe uma url encurtada utilizando: <?php echo $dumb; ?>!');
   window.location.href=('encurtador.php');
</script>
          <?php
          exit();
    	}
    }
    
    $ipuser = get_ip();
    
    $str = "INSERT INTO urls (DS_URLFULL_URDB, DS_URLCUT_URDB, DT_CADASTRO_URDB, DS_IPUSER_URDB) values ('$big', '$dumb', sysdate(), '$ipuser')";
    $stb = mysql_query($str);
}

mysql_close($con);

Header("Location: encurtador.php");
exit();

function InStr($haystack, $needle)
{
    $pos=strpos($haystack, $needle);
    if ($pos !== false)
    {
        return $pos;
    }
    else
    {
        return -1;
    }
}
function GeraLink($carac){
	$CaracteresAceitos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
	$max = strlen($CaracteresAceitos)-1;
	
    $achou = false;
    while (!$achou){
        $codval = "";
    	for($i=0; $i < $carac; $i++) {
    	   $codval .= $CaracteresAceitos{mt_rand(0, $max)};
    	}
    
    	$sql = "select NR_SEQ_URL_URDB from urls WHERE DS_URLCUT_URDB = '$codval'";
    	$st = mysql_query($sql);
    	if (mysql_num_rows($st) <= 0) $achou = true;
   	}
	return $codval;
}
?>