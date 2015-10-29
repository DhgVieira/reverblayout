<?php
include 'auth.php';
include 'lib.php';

$arq = request("arq");
$str_perm  = request("str_perm");

$sql = "DELETE FROM arquivos_rel WHERE NR_SEQ_ARQUIVO_AURC = $arq";
$st = mysql_query($sql);

$sqlus = "select DS_EMAIL_USRC, DS_LOGIN_USRC from usuarios WHERE NR_SEQ_USUARIO_USRC = $SS_logadm";
$stus = mysql_query($sqlus);
if (mysql_num_rows($stus) > 0) {
	$rowus = mysql_fetch_row($stus);
	$remetemail = $rowus[0];
    $retnome  = $rowus[1];
}

$i = 0;

$arr_perm = explode("|", $str_perm);

for ($i=0; $i < count($arr_perm); $i++) {
    $sql = "INSERT INTO arquivos_rel (NR_SEQ_ARQUIVO_AURC, NR_SEQ_USER_AURC) VALUES (" . $arq . ", " . $arr_perm[$i] . ")";
    $st = mysql_query($sql);
    
    $sqlmin = "SELECT DS_ARQUIVO_AQRC, DS_NOME_ORIG_AQRC, DS_DESCRICAO_AQRC FROM arquivos WHERE NR_SEQ_ARQUIVO_AQRC = $arq";
	$stmin = mysql_query($sqlmin);
	$retnome = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retnome = utf8_decode($rowmin[0]." (".$rowmin[1].")");
        $descricao = utf8_decode($rowmin[2]);
	}
  
    $corpo = "<table width=\"557\" height=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
    $corpo .= "<tr><td width=\"557\" height=\"87\" valign=\"bottom\" colspan=\"3\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" width=\"557\" height=\"87\"></td>";
    $corpo .= "</tr><tr>";
    $corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "    <td><table width=\"100%\" cellpadding=\"3\" cellspacing=\"3\">";
    $corpo .= "        	<tr><td style=\"font-family:Arial, Helvetica, sans-serif;\" width=\"555\">";
    $corpo .= "        	<strong>Novo arquivo disponível!</strong>";
    $corpo .= "        	<br /><br />";
    $corpo .= "        	O arquivo abaixo foi incluído no sistema de arquivos Reverbcity e você faz parte do mesmo:";
    $corpo .= "        	<br /><br />";
    $corpo .= "        	<strong>$retnome</strong><br />";
    $corpo .= "        	$descricao<br /><br />";
    $corpo .= "        	<a href=http://www.reverbcity.com/Readm_911s/arquivos.php>http://www.reverbcity.com/Readm_911s/arquivos.php</a><br /><br />";
    $corpo .= "        	Para baixá-lo acesse a área de arquivos da ADM Reverb <br /><br />";
    $corpo .= "        	Reverbcity System<br />";
    $corpo .= "        	www.reverbcity.com";
    $corpo .= "        	</td></tr>";
    $corpo .= "        </table></td>";
    $corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "</tr><tr>";
    $corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "    <td height=\"1\">&nbsp;</td>";
    $corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "</tr><tr><td width=\"557\" height=\"26\" colspan=\"3\" valign=\"top\"><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" usemap=\"#Map\" width=\"557\" height=\"26\" border=0></td>";
    $corpo .= "</tr></table>";
    
    $sqlmin2 = "SELECT DS_EMAIL_USRC FROM usuarios WHERE NR_SEQ_USUARIO_USRC <> $SS_logadm and NR_SEQ_USUARIO_USRC = ".$arr_perm[$i];
	$stmin2 = mysql_query($sqlmin2);
	$retemail = "";
	if (mysql_num_rows($stmin2) > 0) {
		$rowmin2 = mysql_fetch_row($stmin2);
		$retemail = $rowmin2[0];
        if ($retemail) EnviaEmailNovo($remetemail,$retnome,$retemail,"","","Novo Arquivo - Reverbcity", $corpo);
	}
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou permissoes de Arquivo $arq");

mysql_close($con);

Header("Location: arquivos.php");
exit();
?>